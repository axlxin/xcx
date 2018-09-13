<?php
class ControllerModuleSignUpCoupons extends Controller {

	private $data = array();
	private $error = array();
	private $version;
	private $module_path;
	private $extensions_link;
	private $language_variables;
	private $moduleModel;
	private $moduleName;
	private $call_model;

	public function __construct($registry){
		parent::__construct($registry);
		$this->load->config('isenselabs/signupcoupons');
		$this->moduleName = $this->config->get('signupcoupons_name');
		$this->call_model = $this->config->get('signupcoupons_model');
		$this->module_path = $this->config->get('signupcoupons_path');
		$this->version = $this->config->get('signupcoupons_version');
		
		if (version_compare(VERSION, '2.3.0.0', '>=')) {			
			$this->extensions_link = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL');
		} else {
			$this->extensions_link = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');	
		}
			
		$this->load->model($this->module_path);
		$this->moduleModel = $this->{$this->call_model};
    	$this->language_variables = $this->load->language($this->module_path);

    	//Loading framework models
	 	$this->load->model('setting/store');
		$this->load->model('setting/setting');
        $this->load->model('localisation/language');

		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');

		$this->data['module_path']     = $this->module_path;
		$this->data['moduleName']      = $this->moduleName;
		$this->data['moduleNameSmall'] = $this->moduleName;	    
	}
	
	public function index() {  

		foreach ($this->language_variables as $code => $languageVariable) {
		    $this->data[$code] = $languageVariable;
		}  

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		$this->load->model('marketing/coupon');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('design/layout');
		$this->document->addStyle('view/javascript/signupcoupons/font-awesome/css/font-awesome.min.css');
		$this->document->addStyle('view/stylesheet/signupcoupons.css');		
		$this->data['error_warning'] = '';
		
		if(isset($this->request->get['store_id'])) {
        	$store_id = $this->request->get['store_id']; 
        } elseif (isset($this->request->post['store_id'])) {
			$store_id = $this->request->post['store_id'];
		} else {
			$store_id = 0;
		}
		
        $store = $this->getCurrentStore($store_id);
				
		$languages = $this->model_localisation_language->getLanguages();
	
		$signupMails = array();
		
		foreach($languages as $language) { 	
			$directory = $language['directory'];
			if (version_compare(VERSION,'2.2.0.0','>=')) {
				$directory = $language['code'];
			} 
			if(file_exists(DIR_APPLICATION.'language/' . $directory . '/mail/customer.php')) {
				
				$currentLanguage = new Language($language['directory']);
				$currentLanguage->load('mail/customer');	
				$currentLanguage->get('text_welcome');
				$buffer  = sprintf($currentLanguage->get('text_approve_welcome'), $this->config->get('config_name')) . "<br /><br />";
				$buffer .= $currentLanguage->get('text_approve_login') . "<br /><br />";
				
				if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            		$buffer .= HTTPS_CATALOG.'index.php?route=account/login' . "<br /><br />";
        		} else {
           			$buffer .= HTTP_CATALOG.'index.php?route=account/login' . "<br /><br />";
      			} 
				
				//$buffer .= HTTP_CATALOG.'index.php?route=account/login' . "<br /><br />";
				$buffer .= $currentLanguage->get('text_approve_services') . "<br /><br />";
				$buffer .= $currentLanguage->get('text_approve_thanks'). "<br />";
				$buffer .= $this->config->get('config_name');
				$this->data['subject'][$language['code']] = sprintf($currentLanguage->get('text_approve_subject'), $this->config->get('config_name'));
				
				$signupMails[$language['code']] = html_entity_decode($buffer, ENT_QUOTES, 'UTF-8');
			}
		}	
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if (!$this->user->hasPermission('modify', $this->module_path)) {
				$this->response->redirect($this->extensions_link);
			}

			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
				$this->request->post['SignUpCoupons']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
			}
			if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
				$this->request->post['SignUpCoupons']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']),true);
			}
			
			if($this->request->post['SignUpCoupons']['selected_products'] == 'all') {
				$this->request->post['SignUpCoupons']['coupon_product'] = array();
			} elseif(empty($this->request->post['SignUpCoupons']['coupon_product'])){
				$this->request->post['SignUpCoupons']['selected_products'] = 'all';
			}
			
			if($this->request->post['SignUpCoupons']['selected_categories'] == 'all') {
				$this->request->post['SignUpCoupons']['coupon_category'] = array();
			} elseif(empty($this->request->post['SignUpCoupons']['coupon_category'])) {
				$this->request->post['SignUpCoupons']['selected_categories'] = 'all';
			}
			
			
			$this->model_setting_setting->editSetting('SignUpCoupons', $this->request->post, $store_id);		
					
			$this->session->data['success'] = $this->language->get('text_success');
		}	
	
		$this->data['error_code'] = isset($this->error['code']) ? $this->error['code'] : '';
  		
		if (isset($this->session->data['success'])) {     
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
        if (isset($this->error['warning'])) { 
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->extensions_link,
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link($this->module_path, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->data['heading_title']   .= ' ' . $this->version;
		
		$this->data['action']          = $this->url->link($this->module_path, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel']          = $this->extensions_link;
		$this->data['currenttemplate'] =  $this->config->get('config_template');
		$this->data['currency']        = $this->config->get('config_currency');
		$this->data['modules']         = array();
		$this->data['emails']          = $signupMails; 
		$this->data['languages']       = $languages;

        foreach ($this->data['languages'] as $key => $value) {
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				$this->data['languages'][$key]['flag_url'] = 'view/image/flags/'.$this->data['languages'][$key]['image'];

			} else {
				$this->data['languages'][$key]['flag_url'] = 'language/'.$this->data['languages'][$key]['code'].'/'.$this->data['languages'][$key]['code'].'.png"';
			}
		}
        
		$this->data['data'] = $this->model_setting_setting->getSetting('SignUpCoupons', $store_id);

		if (isset($this->request->post['coupon_product'])) {
			$products = $this->request->post['coupon_product'];
		}  elseif(isset($this->data['data']['SignUpCoupons']['coupon_product'])) {
			$products = $this->data['data']['SignUpCoupons']['coupon_product'];
		} else {
			$products = array();
		}
		$this->data['coupon_product'] = array();
		
		$coupon_product =array();
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
			$coupon_product[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}

		if (isset($this->request->post['coupon_category'])) {
			$categories = $this->request->post['coupon_category'];
		} elseif(isset($this->data['data']['SignUpCoupons']['coupon_category'])) {
			$categories = $this->data['data']['SignUpCoupons']['coupon_category'];
		} else {
			$categories = array();
		}

		$this->data['coupon_category'] = array();
		$coupon_category = array();
		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);
			if ($category_info) {
			 $coupon_category[] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
				);
			}
		}
		$this->data['data']['SignUpCoupons']['coupon_product'] = $coupon_product;
		$this->data['data']['SignUpCoupons']['coupon_category'] = $coupon_category;
		
		if ($this->config->get('signupcoupons_status')) { 
            $this->data['signupcoupons_status'] = $this->config->get('signupcoupons_status'); 
        } else {
            $this->data['signupcoupons_status'] = '0';
        }
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();				

		$this->data['stores'] = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' ' . $this->data['text_default'], 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $this->data['store']                  = $store;
        $this->data['token']                  = $this->session->data['token'];
		
		$this->data['header']                 = $this->load->controller('common/header');
        $this->data['column_left']            = $this->load->controller('common/column_left');
        $this->data['footer']                 = $this->load->controller('common/footer');
        	
        $this->response->setOutput($this->load->view($this->module_path."/signupcoupons.tpl", $this->data)); 
	}	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', $this->module_path)) {
			$this->error = true;
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	 private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }

    private function getServerURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_SERVER;
        } else {
            $storeURL = HTTP_SERVER;
        } 
        return $storeURL;
    }

    private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }
	
	public function install() {
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=1 WHERE `name` LIKE'%SignUpCoupons by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');				   
  	} 
  
  	public function uninstall() {
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=0 WHERE `name` LIKE'%SignUpCoupons by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
  	}
}
?>