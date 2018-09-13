<?php
class ControllerCommonHeader extends Controller {
	public function index() {

           $data['yotpo_app_key'] = $this->config->get('yotpo_appkey');  
        

						$this->load->model('setting/setting');
						$signUpCoupons = $this->model_setting_setting->getSetting('SignUpCoupons', $this->config->get('config_store_id'));
						if(isset($signUpCoupons) && isset($signUpCoupons['SignUpCoupons'])) {
							$signUpCoupons = $signUpCoupons['SignUpCoupons'];
							if(!empty($signUpCoupons['Enabled']) && $signUpCoupons['Enabled'] == 'yes') {

								if(version_compare(VERSION, '2.2.0.0', '<')) {
									$curent_template = $this->config->get('config_template');
								} else {
									$curent_template = $this->config->get($this->config->get('config_theme') . '_directory');
								}

								if (file_exists(DIR_TEMPLATE . $curent_template . '/stylesheet/signupcoupons.css')) {
									$this->document->addStyle('catalog/view/theme/'. $curent_template .'/stylesheet/signupcoupons.css');
								}
								$data['signUpCoupons'] = $signUpCoupons;
							}
						}
				
// Clear Thinking: MailChimp Integration Pro
				$prefix = (version_compare(VERSION, '3.0', '<')) ? '' : 'module_';
				
				if ($this->config->get($prefix . 'mailchimp_integration_ecommerce360')) {
					if (isset($this->request->get['mc_cid'])) {
						setcookie('mc_cid', $this->request->get['mc_cid'], time() + 60*60*24 * $this->config->get($prefix . 'mailchimp_integration_cookietime'), '/');
					}
					if (isset($this->request->get['mc_eid'])) {
						setcookie('mc_eid', $this->request->get['mc_eid'], time() + 60*60*24 * $this->config->get($prefix . 'mailchimp_integration_cookietime'), '/');
					}
				}
				// end
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
                
                $this->document->addStyle('catalog/view/theme/journal2/css/kp_siteModification.css');
                $this->document->addScript('catalog/view/theme/journal2/js/kp_siteModification.js');


			if (preg_match("/2.1/i", VERSION)) { 
				if (!$this->config->get('ecommerce_tracking_status') || ($this->config->get('ecommerce_tracking_status') && isset($this->request->get['route']) && $this->request->get['route'] == 'checkout/success')) {
					$data['google_analytics'] = '';
				} else {
					$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
				}
			}
			
		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();

				
				foreach ($data['links'] as $link) { 
					if ($link['rel']=='canonical') {$hasCanonical = true;} 
					} 
				$data['canonical_link'] = '';
				$canonicals = $this->config->get('canonicals'); 
				if (!isset($hasCanonical) && isset($this->request->get['route']) && (isset($canonicals['canonicals_extended']))) {
					$data['canonical_link'] = $this->url->link($this->request->get['route']);					
					}
				
				
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		if ($this->config->get('config_google_analytics_status')) {
			
			if (!preg_match("/2.1/i", VERSION)) {
				if ($this->config->get('ecommerce_tracking_status') && isset($this->request->get['route']) && $this->request->get['route'] == 'checkout/success') {
					$data['google_analytics'] = '';
				} else {
					$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
				}
			}
			
		} else {
			$data['google_analytics'] = '';
		}

		$data['name'] = $this->config->get('config_name');

						$data['language_code'] = $this->config->get('config_language'); 
						if(isset($this->session->data['customer_id'])) {
							$data['customer_id'] = $this->session->data['customer_id'];
						} else {
							$data['customer_id']='';
						}
				

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = strpos($this->config->get('config_template'), 'journal2') === 0 ? array() : $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		
if (isset($this->request->get['product_id']) && $this->request->get['product_id'] == '142') {
    return $this->load->view($this->config->get('config_template') . '/template/common/kp_headerPcb.tpl', $data);
}elseif(isset($this->request->get['product_id']) && $this->request->get['product_id'] == '52') {
    return $this->load->view($this->config->get('config_template') . '/template/common/kp_headerPcbAssembly.tpl', $data);
}elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {

			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}