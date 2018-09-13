<?php
class ControllerJournal2Ajax extends Controller {

    protected $data = array();

    protected function render() {
        return Front::$IS_OC2 ? $this->load->view($this->template, $this->data) : parent::render();
    }

    public function __construct($reg) {
        parent::__construct($reg);
    }

    public function price() {
        $this->load->model('catalog/product');
        $this->load->model('journal2/product');
        $this->language->load('product/product');

        $product_id = isset($this->request->post['product_id']) ? $this->request->post['product_id'] : 0;
        $product_info = $this->model_catalog_product->getProduct($product_id);

        if (!$product_info) {
            $this->response->setOutput(json_encode(array(
                'error' => 'Product not found'
            )));
            return;
        }

        if (!isset($product_info['tax_class_id'])) {
            $product_info['tax_class_id'] = '';
        }

        $price = 0;
        $special = 0;
        $extra = 0;
        $quantity = $product_info['quantity'];
        $points = $product_info['points'];

        if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
            $price = $product_info['price'];
        }

        if ((float)$product_info['special']) {
            $special = $product_info['special'];
        }

        $product_options = Front::$IS_OC2 ? $this->model_journal2_product->getProductOptionsOC2($product_id) : $this->model_journal2_product->getProductOptionsOC1($product_id);

        foreach ($product_options as $option) {
            if (!in_array($option['type'], array('select', 'radio', 'checkbox', 'image'))) continue;

            $option_ids = Journal2Utils::getProperty($this->request->post, 'option.' . $option['product_option_id'], array());

            if (is_scalar($option_ids)) {
                $option_ids = array($option_ids);
            }

            foreach ($option_ids as $option_id) {
                foreach (Journal2Utils::getProperty($option, Front::$IS_OC2 ? 'product_option_value' : 'option_value', array()) as $option_value) {
                    if ($option_id == $option_value['product_option_value_id']) {
                        $quantity = min($quantity, (int)$option_value['quantity']);
                        if ($option_value['price_prefix'] === '+') {
                            $extra += (float)$option_value['price'];
                        } else {
                            $extra -= (float)$option_value['price'];
                        }
                        if ($option_value['points_prefix'] === '+') {
                            $points += (float)$option_value['points'];
                        } else {
                            $points -= (float)$option_value['points'];
                        }
                    }
                }
            }
        }

        $tax = $special ? $special : $price;

        $price += $extra;
        $special += $extra;
        $tax += $extra;

        if ($quantity <= 0) {
            $stock = $product_info['stock_status'];
        } elseif ($this->config->get('config_stock_display')) {
            $stock = $quantity;
        } else {
            $stock = $this->language->get('text_instock');
        }

// gp_option_calculate插件运算代码
        $calculate_query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "GP_product_option_calculate WHERE product_id='" . (int)$product_id . "'");
        $calculate_info = $calculate_query->row;
        $calculate_code = '';
        $combination_price = 0;
        $options = $this->request->post['option'];

        if (is_array($calculate_info) && count($calculate_info)>0 )
        {
            $calculate_code = html_entity_decode($calculate_info['code'], ENT_COMPAT);
            $this->current_product_id = $product_id;
            $this->current_product_options = $this->request->post['option'];
            eval($calculate_code);
        }                                     
        $price += $combination_price;


        $this->response->setOutput(json_encode(array(
            'price'     => $this->currency->format($this->tax->calculate($price, $product_info['tax_class_id'], $this->config->get('config_tax'))),
            'special'   => $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax'))),
            'tax'       => $this->language->get('text_tax') . ' ' . $this->currency->format($tax),
            'stock'     => $stock,
            'cls'       => $quantity ? 'instock' : 'outofstock',
            'points'    => $this->language->get('text_points') . ' ' . $points,
        )));
    }


private function getPON($selected_option_id) {
        //$this->load->model('catalog/option');
        //$product_options = $this->model_catalog_product->getProductOptions($this->current_product_id);
        $product_options = $this->getProductOptions($this->current_product_id);
        foreach ($product_options as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox') {
                if ($selected_option_id == (int) $product_option['product_option_id']) {
                    foreach ($product_option['product_option_value'] as $product_option_value) {
                        $selected_option_value_id = $this->current_product_options[$selected_option_id];
                        if ($selected_option_value_id == $product_option_value['product_option_value_id']) {
                            return $product_option_value['name'];
                        }
                    }
                }
            }
        }
        return null;
    }
        
    private function getProductOptions($product_id) {
    $product_option_data = array();

    $product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int) $product_id . "' AND od.language_id = '" . (int) $this->config->get('config_language_id') . "'");

    foreach ($product_option_query->rows as $product_option) {
        $product_option_value_data = array();

        $product_option_value_query = $this->db->query("SELECT pov.*,ovd.name FROM " . DB_PREFIX . "product_option_value pov INNER JOIN " . DB_PREFIX . "option_value_description ovd ON pov.option_value_id=ovd.option_value_id WHERE pov.product_option_id = '" . (int) $product_option['product_option_id'] . "' ");

        foreach ($product_option_value_query->rows as $product_option_value) {
            $product_option_value_data[] = array(
                'product_option_value_id' => $product_option_value['product_option_value_id'],
                'option_value_id' => $product_option_value['option_value_id'],
                'quantity' => $product_option_value['quantity'],
                'subtract' => $product_option_value['subtract'],
                'price' => $product_option_value['price'],
                'name' => $product_option_value["name"],
                'price_prefix' => $product_option_value['price_prefix'],
                'points' => $product_option_value['points'],
                'points_prefix' => $product_option_value['points_prefix'],
                'weight' => $product_option_value['weight'],
                'weight_prefix' => $product_option_value['weight_prefix']
            );
        }

        $product_option_data[] = array(
            'product_option_id' => $product_option['product_option_id'],
            'product_option_value' => $product_option_value_data,
            'option_id' => $product_option['option_id'],
            'name' => $product_option['name'],
            'type' => $product_option['type'],
            'value' => $product_option['value'],
            'required' => $product_option['required']
        );
    }

    return $product_option_data;
}

}
