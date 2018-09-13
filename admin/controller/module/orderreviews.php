<?php
class ControllerModuleOrderReviews extends Controller {
	private $error = array(); 
		
	private $moduleName = 'orderreviews';
	private $moduleModel = 'model_module_orderreviews';

	private $version = '2.7.3';

    public function index() { 
		$data['moduleName'] = $this->moduleName;
		$data['moduleNameSmall'] = $this->moduleName;
		$data['moduleModel'] = $this->moduleModel;
	 
        $this->load->language('module/'.$this->moduleName);
		
        $this->load->model('module/'.$this->moduleName);
        $this->load->model('setting/store');
		$this->load->model('setting/setting');
        $this->load->model('localisation/language');
		
		if(VERSION >= '2.1.0.1'){
			$this->load->model('customer/customer_group');
		} else {
			$this->load->model('sale/customer_group');
		}
		
		
        $this->document->addStyle('view/stylesheet/'.$this->moduleName.'/'.$this->moduleName.'.css');
		$this->document->addScript('view/javascript/'.$this->moduleName.'/nprogress.js');
		
        $this->document->setTitle($this->language->get('heading_title').' '.$this->version);

        if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }
		
		$this->{$this->moduleModel}->checkForTable();
	
        $store = $this->getCurrentStore($this->request->get['store_id']);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { 	
            if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post[$this->moduleName]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }
            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }

        	$this->model_setting_setting->editSetting($this->moduleName, $this->request->post, $this->request->post['store_id']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('module/'.$this->moduleName, 'store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));
        }
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

        $data['breadcrumbs']   = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'),
        );

        $languageVariables = array('heading_title', 'error_permission', 'text_success', 'text_enabled', 'text_disabled', 'button_cancel', 'save_changes', 'text_default', 'text_module');
       
        foreach ($languageVariables as $languageVariable) {
            $data[$languageVariable] = $this->language->get($languageVariable);
        }
		$data['heading_title'] 				= $this->language->get('heading_title').' '.$this->version;
		
 		$data['currency']					= $this->config->get('config_currency');
        $data['stores']						= array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $data['languages']              	= $this->model_localisation_language->getLanguages();
        //2.2.0.0 language flag image fix
		foreach ($data['languages'] as $key => $value) {
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				$data['languages'][$key]['flag_url'] = 'view/image/flags/'.$data['languages'][$key]['image'];
			} else {
				$data['languages'][$key]['flag_url'] = 'language/'.$data['languages'][$key]['code'].'/'.$data['languages'][$key]['code'].'.png"';
			}
		}
        $data['store']                  	= $store;
        $data['token']                  	= $this->session->data['token'];
        $data['action']                 	= $this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel']                 	= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['moduleSettings']				= $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
        $data['moduleData']					= (isset($data['moduleSettings'][$this->moduleName])) ? $data['moduleSettings'][$this->moduleName] : array();
		$data['orderStatuses']		  		= $this->getAllOrderStatuses();
		
		if(VERSION >= '2.1.0.1'){
			$data['customer_groups']		  	= $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$data['customer_groups']		  	= $this->model_sale_customer_group->getCustomerGroups();
		}
		
		$data['e_mail']						= $this->config->get('config_email');
		
		$data['header']						= $this->load->controller('common/header');
		$data['column_left']				= $this->load->controller('common/column_left');
		$data['footer']						= $this->load->controller('common/footer');
	
		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'.tpl', $data));
    }
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	public function get_review_settings() {
        $this->load->model('module/'.$this->moduleName);
        $this->load->model('setting/store');
		$this->load->model('setting/setting');
        $this->load->model('localisation/language');
		
		
		if(VERSION >= '2.1.0.1'){
			$this->load->model('customer/customer_group');
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$this->load->model('sale/customer_group');
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		}
		
 		$data['currency']						= $this->config->get('config_currency');	
		$data['languages']						= $this->model_localisation_language->getLanguages();
		foreach ($data['languages'] as $key => $value) {
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				$data['languages'][$key]['flag_url'] = 'view/image/flags/'.$data['languages'][$key]['image'];
			} else {
				$data['languages'][$key]['flag_url'] = 'language/'.$data['languages'][$key]['code'].'/'.$data['languages'][$key]['code'].'.png"';
			}
		}
		$data['reviewmail']['id']				= $this->request->get['reviewmail_id'];
		$store_id								= $this->request->get['store_id'];
		$data['data']							= $this->model_setting_setting->getSetting($this->moduleName, $store_id);
		$data['moduleName']						= $this->moduleName;
		$data['moduleData']						= (isset($data['data'][$this->moduleName])) ? $data['data'][$this->moduleName] : array();
		$data['orderStatuses']					= $this->getAllOrderStatuses();
		$data['newAddition']					= true;
		
		
		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'/tab_reviewtab.tpl', $data));
	}
	
	
	public function getAllOrderStatuses() {
		$query = 'SELECT * FROM ' . DB_PREFIX . 'order_status WHERE language_id='.$this->config->get('config_language_id');
		return $this->db->query($query)->rows;
	}
	
    public function install() {
	    $this->load->model('module/'.$this->moduleName);
	    $this->{$this->moduleModel}->install();
    }
    
    public function uninstall() {
        $this->load->model('module/'.$this->moduleName);
        $this->load->model('setting/store');
        $this->load->model('localisation/language');
        $this->load->model('design/layout');
		
		$this->model_setting_setting->deleteSetting($this->moduleName,0);
		$stores=$this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$this->model_setting_setting->deleteSetting($this->moduleName, $store['store_id']);
		}
        $this->load->model('module/'.$this->moduleName);
        $this->{$this->moduleModel}->uninstall();
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
}
?>