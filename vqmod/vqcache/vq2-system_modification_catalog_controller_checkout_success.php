<?php
class ControllerCheckoutSuccess extends Controller {
	public function index() {

				$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

				$data['ecommerce_tracking_tax'] = $this->config->get('ecommerce_tracking_tax');
				$data['ecommerce_tracking_status'] = false;
				$data['ecommerce_tracking_convert_currency'] = $this->config->get('ecommerce_tracking_convert_currency');
				$data['order'] = array();
				$data['order_products'] = array();

				if ($this->config->get('ecommerce_tracking_status') && $this->config->get('config_google_analytics')) {
					$data['ecommerce_tracking_status'] = true;

					if (strpos($data['google_analytics'], 'i,s,o,g,r,a,m') !== false) {
						$ecommerce_global_object_pos = strrpos($data['google_analytics'], "analytics.js','") + strlen("analytics.js','");
						$data['ecommerce_global_object'] = substr($data['google_analytics'], $ecommerce_global_object_pos, (strpos($data['google_analytics'], "');", $ecommerce_global_object_pos) - $ecommerce_global_object_pos));
						$data['start_google_code'] = substr($data['google_analytics'], 0, (strpos($data['google_analytics'], "pageview');") + strlen("pageview');")));
						$data['end_google_code'] = substr($data['google_analytics'], (strpos($data['google_analytics'], "pageview');") + strlen("pageview');")));
					} else {
						$data['ecommerce_global_object'] = false;
						$data['start_google_code'] = substr($data['google_analytics'], 0, strpos($data['google_analytics'], '(function'));
						$data['end_google_code'] = substr($data['google_analytics'], strpos($data['google_analytics'], '(function'));
					}

					if (isset($this->session->data['order_id'])) {
						$order_id = $this->session->data['order_id'];

						$this->load->model('account/order');
						$this->load->model('checkout/order');

						$order_info = $this->model_checkout_order->getOrder($order_id);

						if ($order_info) {
							$tax = 0;
							$shipping = 0;
							$sub_total = 0;

							$order_totals = $this->model_account_order->getOrderTotals($order_id);

							foreach ($order_totals as $order_total) {
								if ($order_total['code'] == 'tax') {
									$tax += $order_total['value'];
								} elseif($order_total['code'] == 'shipping') {
									$shipping += $order_total['value'];
								} elseif($order_total['code'] == 'sub_total') {
									$sub_total += $order_total['value'];
								}
							}

							// Data required for _addTrans
							$data['order'] = $order_info;
							$data['order']['currency_code'] = (($this->config->get('ecommerce_tracking_currency') != '' && $this->config->get('ecommerce_tracking_convert_currency')) ? $this->config->get('ecommerce_tracking_currency') : $order_info['currency_code']);
							$data['order']['store_name'] = $this->config->get('config_name');
							$data['order']['order_total'] = round(($this->config->get('ecommerce_tracking_currency') != '' && $this->config->get('ecommerce_tracking_convert_currency')) ? $this->currency->convert($this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false), $order_info['currency_code'], $this->config->get('ecommerce_tracking_currency')) : $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false), 2);
							$data['order']['order_tax'] = round(($this->config->get('ecommerce_tracking_currency') != '' && $this->config->get('ecommerce_tracking_convert_currency')) ? $this->currency->convert($this->currency->format($tax, $order_info['currency_code'], $order_info['currency_value'], false), $order_info['currency_code'], $this->config->get('ecommerce_tracking_currency')) : $this->currency->format($tax, $order_info['currency_code'], $order_info['currency_value'], false), 2);
							$data['order']['order_shipping'] = round(($this->config->get('ecommerce_tracking_currency') != '' && $this->config->get('ecommerce_tracking_convert_currency')) ? $this->currency->convert($this->currency->format($shipping, $order_info['currency_code'], $order_info['currency_value'], false), $order_info['currency_code'], $this->config->get('ecommerce_tracking_currency')) : $this->currency->format($shipping, $order_info['currency_code'], $order_info['currency_value'], false), 2);
							$data['order']['order_sub_total'] = round(($this->config->get('ecommerce_tracking_currency') != '' && $this->config->get('ecommerce_tracking_convert_currency')) ? $this->currency->convert($this->currency->format($sub_total, $order_info['currency_code'], $order_info['currency_value'], false), $order_info['currency_code'], $this->config->get('ecommerce_tracking_currency')) : $this->currency->format($sub_total, $order_info['currency_code'], $order_info['currency_value'], false), 2);

							// Data required for _addItem
							$order_products = $this->model_account_order->getOrderProducts($order_id);

							$this->load->model('catalog/product');
							$this->load->model('catalog/category');

							foreach ($order_products as $order_product) {
								$sku = $order_product['product_id'];

								if (($this->config->get('ecommerce_tracking_sku') == 'sku') || ($this->config->get('ecommerce_tracking_sku') == 'sku_option')) {
									$order_product_info = $this->model_catalog_product->getProduct($order_product['product_id']);

									if ($order_product_info && $order_product_info['sku']) {
										$sku = $order_product_info['sku'];
									}
								}

								if (($this->config->get('ecommerce_tracking_sku') == 'id_option') || ($this->config->get('ecommerce_tracking_sku') == 'sku_option')) {
									$order_options = $this->model_account_order->getOrderOptions($order_id, $order_product['order_product_id']);

									foreach ($order_options as $order_option) {
										$sku .= '-' . $order_option['product_option_id'] . ':' . $order_option['product_option_value_id'];

										if ($order_option['type'] != 'file') {
											$option_value = $order_option['value'];
										} else {
											$option_value = utf8_substr($order_option['value'], 0, utf8_strrpos($order_option['value'], '.'));
										}

										$order_product['name'] .= ' - ' . $order_option['name'] . ': ' . (utf8_strlen($option_value) > 20 ? utf8_substr($option_value, 0, 20) . '..' : $option_value);
									}
								}

								$categories = array();

								$order_product_categories = $this->model_catalog_product->getCategories($order_product['product_id']);

								if ($order_product_categories) {
									foreach ($order_product_categories as $order_product_category) {
										$category_data = $this->model_catalog_category->getCategory($order_product_category['category_id']);

										if ($category_data) {
											$categories[] = $category_data['name'];
										}
									}
								}

								$data['order_products'][] = array(
									'order_id' => $order_id,
									'sku'      => $sku,
									'name'     => $order_product['name'],
									'category' => implode(',', $categories),
									'quantity' => $order_product['quantity'],
									'price'    => round(($this->config->get('ecommerce_tracking_currency') != '' && $this->config->get('ecommerce_tracking_convert_currency')) ? $this->currency->convert($this->currency->format($order_product['price'] + ($this->config->get('ecommerce_tracking_tax') == 1 ? ($this->config->get('config_tax') ? $order_product['tax'] : 0) : 0), $order_info['currency_code'], $order_info['currency_value'], false), $order_info['currency_code'], $this->config->get('ecommerce_tracking_currency')) : $this->currency->format($order_product['price'], $order_info['currency_code'], $order_info['currency_value'], false), 2)
								);
							}
						}
					}
				}
			
		$this->load->language('checkout/success');
    
          $app_key = $this->config->get('yotpo_appkey');      
          if (isset($this->session->data['order_id']) && !empty($app_key)) {        
        $this->load->model('account/order');        
        $orders_total = $this->model_account_order->getOrderTotals($this->session->data['order_id']);
        $total = null;
        foreach ($orders_total as $order_total) { 
          if ($order_total['code'] == 'total') {
            
            $total = $order_total['value'];
          }
        }
        $conversion_params = "app_key="     .$app_key.
                   "&order_id="   .$this->session->data['order_id'].
                   "&order_amount=" .$total.
                   "&order_currency=" .$this->session->data['currency'];
        $conversion_url = "https://api.yotpo.com/conversion_tracking.gif?$conversion_params";
        $data['yotpoConversionUrl'] = $conversion_url;
      }
        

		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();

			// Add to activity log
			$this->load->model('account/activity');

			if ($this->customer->isLogged()) {
				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
					'order_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_account', $activity_data);
			} else {
				$activity_data = array(
					'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
					'order_id' => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_guest', $activity_data);
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}
}