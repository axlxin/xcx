<?php

class ControllerProductProductpcb extends Controller {

    public function getShippingMethods() {
        $this->load->model('shipping/ocaaspro');

        $fake_address = $this->fakeShippingAddress();
        $fake_products = $this->fakeProducts();
        $fake_saveCart = $this->fakeSaveCart();

        //$log = new Log("kp_debug.log");
        //$log->write(print_r($fake_products, 1));
        $quote = $this->{'model_shipping_ocaaspro'}->getQuote($fake_address, true, $fake_products, $fake_saveCart);

        if ($quote) {
            $method_data['ocaaspro'] = array(
                'title' => $quote['title'],
                'quote' => $quote['quote'],
                'sort_order' => $quote['sort_order'],
                'error' => $quote['error']
            );
        }

        $shipping_methods = $method_data;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($shipping_methods));
    }

    public function getCountries() {
        $this->load->model('localisation/country');
        $countries = $this->model_localisation_country->getCountries();
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($countries));
    }

    private function fakeShippingAddress() {
        $this->load->model('localisation/country');

        $country_id = $this->request->post['country_id'];

        $country_info = $this->model_localisation_country->getCountry($country_id);

        if ($country_info) {
            $country = $country_info['name'];
            $iso_code_2 = $country_info['iso_code_2'];
            $iso_code_3 = $country_info['iso_code_3'];
            $address_format = $country_info['address_format'];
        } else {
            $country = '';
            $iso_code_2 = '';
            $iso_code_3 = '';
            $address_format = '';
        }

        $this->load->model('localisation/zone');

        $zones = $this->model_localisation_zone->getZonesByCountryId($country_id);
        $zone_info = empty($zones) ? null : $zones[0];

        if ($zone_info) {
            $zone = $zone_info['name'];
            $zone_code = $zone_info['code'];
            $zone_id = $zone_info['zone_id'];
        } else {
            $zone = '';
            $zone_code = '';
            $zone_id = 0;
        }

        $address = array(
            'firstname' => '',
            'lastname' => '',
            'company' => '',
            'address_id' => '',
            'address_1' => '',
            'address_2' => '',
            'city' => '',
            'postcode' => '',
            'country_id' => $country_id,
            'zone_id' => $zone_id,
            'custom_field' => array(),
            'country_name' => $country,
            'country' => $country,
            'iso_code_2' => $iso_code_2,
            'iso_code_3' => $iso_code_3,
            'address_format' => $address_format,
            'zone' => $zone,
            'zone_name' => $zone,
            'zone_code' => $zone_code,
        );

        return $address;
    }

    private function fakeProducts() {
        $product_id = $this->request->post['product_id'];
        $options = array_filter($this->request->post['option']);
        
        $products = array();
        $this->load->model('catalog/product');

        $product = $this->model_catalog_product->getProduct($product_id);
        $price = $product['price'];

        //optionCalculate
        $calculate_query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "product_option_calculate WHERE product_id='" . (int) $product_id . "'");
        $calculate_info = $calculate_query->row;
        $calculate_code = '';
        $combination_price = 0;
        $product_weight = $product['weight'];
        if (is_array($calculate_info) && count($calculate_info) > 0) {
            $calculate_code = html_entity_decode($calculate_info['code'], ENT_COMPAT);
            $this->current_product_id = $product_id;
            $this->current_product_options = $options;
            eval($calculate_code);
        }
        $price += $combination_price;

        $products[0] = array(
            'key' => '',
            'product_id' => $product_id,
            'quantity' => 1,
            'price' => $price,
            'total' => $price / 1,
            'tax_class_id' => $product['tax_class_id'],
            'length' => $this->length->convert($product['length'], $product['length_class_id'], $this->config->get('config_length_class_id')),
            'width' => $this->length->convert($product['width'], $product['length_class_id'], $this->config->get('config_length_class_id')),
            'height' => $this->length->convert($product['height'], $product['length_class_id'], $this->config->get('config_length_class_id')),
            'volume' => $this->length->convert($product['length'], $product['length_class_id'], $this->config->get('config_length_class_id')) * $this->length->convert($product['width'], $product['length_class_id'], $this->config->get('config_length_class_id')) * $this->length->convert($product['height'], $product['length_class_id'], $this->config->get('config_length_class_id')),
            'weight' => $this->weight->convert($product_weight, $product['weight_class_id'], $this->config->get('config_weight_class_id')) / 1,
            'category' => $this->model_catalog_product->getCategories($product['product_id']),
            'name' => $product['name'],
            'model' => $product['model'],
            'sku' => $product['sku'],
            'upc' => $product['upc'],
            'ean' => !empty($product['ean']) ? $product['ean'] : '',
            'jan' => !empty($product['jan']) ? $product['jan'] : '',
            'isbn' => !empty($product['isbn']) ? $product['isbn'] : '',
            'mpn' => !empty($product['mpn']) ? $product['mpn'] : '',
            'location' => $product['location'],
            'stock' => $product['quantity'],
            'manufacturer' => $product['manufacturer_id'],
            'option' => $options,
            'recurring' => !empty($product['recurring']) ? $product['recurring'] : '',
        );

        return $products;
    }
    
    private function fakeSaveCart(){
        $product_id = $this->request->post['product_id'];
        $options = array_filter($this->request->post['option']);
        
        $product = array();
        $product['product_id'] = (int)$product_id;
	$product['option'] = $options;
        $key = base64_encode(serialize($product));
        
        $cart = array();
        $cart[$key] = 1;
        return $cart;
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

}
