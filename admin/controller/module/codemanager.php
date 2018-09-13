<?php
class ControllerModuleCodeManager extends Controller {

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
		$this->load->config('isenselabs/codemanager');
		$this->moduleName = $this->config->get('codemanager_name');
		$this->call_model = $this->config->get('codemanager_model');
		$this->module_path = $this->config->get('codemanager_path');
		$this->version = $this->config->get('codemanager_version');
		
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
		
		if ($this->user->hasPermission('access', $this->module_path)) {
			$_SESSION[$this->moduleName] = true;
			$_SESSION['OC_VERSION'] = VERSION;
			$this->data['usable'] = true;
		} else {
			$this->data['usable'] = false;
		}
		
		if ($this->user->hasPermission('modify', $this->module_path)) {
			$this->data['buttons'] = true;
		} else {
			$this->data['buttons'] = false;
		}
			
        $catalogURL = $this->getCatalogURL();
        $this->document->addStyle('view/stylesheet/'.$this->moduleName.'/'.$this->moduleName.'.css');
        $this->document->setTitle($this->language->get('heading_title') . ' ' . $this->version);

        if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE name = '".$this->moduleName."'");
		if (!$query->rows) {
			$permissions = array();
			$permissions["access"][] = 'extension/module';
			$permissions["access"][] = $this->module_path;
			$this->db->query("INSERT INTO " . DB_PREFIX . "user_group SET name = '" . $this->db->escape($this->moduleName) . "', permission = '" . (isset($permissions) ? serialize($permissions) : '') . "'");	
		}
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE name = '".$this->moduleName."'");
		$this->data['UserGroupID'] = $query->row['user_group_id'];
		
        $store = $this->getCurrentStore($this->request->get['store_id']);
		
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) { 	
            if (!$this->user->hasPermission('modify', $this->module_path)) {
                $this->redirect($this->extensions_link);
            }

            if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post[$this->moduleName]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }

            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }
			
            $this->model_setting_setting->editSetting($this->moduleName, $this->request->post, $this->request->post['store_id']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link($this->module_path, 'store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));
        }
		
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

        $this->data['breadcrumbs']   = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->extensions_link,
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title') . ' ' . $this->moduleVersion,
            'href' => $this->url->link($this->module_path, 'token=' . $this->session->data['token'], 'SSL'),
        );

		$this->data['heading_title']			= $this->language->get('heading_title') . ' ' . $this->moduleVersion;
 
        $this->data['stores']					= array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $this->data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $this->data['languages']              = $this->model_localisation_language->getLanguages();
        $this->data['store']                  = $store;
        $this->data['token']                  = $this->session->data['token'];
        $this->data['action']                 = $this->url->link($this->module_path, 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel']                 = $this->extensions_link;
        $this->data['moduleSettings']			= $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
        $this->data['catalog_url']			= $catalogURL;
		
		$this->data['moduleData'] = (isset($this->data['moduleSettings'][$this->moduleName])) ? $this->data['moduleSettings'][$this->moduleName] : '';

		$this->data['header']					= $this->load->controller('common/header');
		$this->data['column_left']			= $this->load->controller('common/column_left');
		$this->data['footer']					= $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view($this->module_path . '/' . $this->moduleName . '.tpl', $this->data));
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
	   $this->moduleModel->install();
    }
    
    public function uninstall() {
		$this->model_setting_setting->deleteSetting($this->moduleName,0);
		$stores=$this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$this->model_setting_setting->deleteSetting($this->moduleName, $store['store_id']);
		}
		
		$files = array('active.php', 'projects.php', 'settings.php', 'users.php', 'version.php');
		$dir_folder = dirname(DIR_APPLICATION).'/vendors/codemanager/data/';
		
		foreach ($files as $file) {
			 if (is_file($dir_folder.$file)) {
				unlink($dir_folder.$file);
			}
		}

      $this->moduleModel->uninstall();
    }
	
	public function givecredentials() {
		$this->load->model('user/user');
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE name = '".$this->moduleName."'");
		$this->data['user_group_id'] = $query->row['user_group_id'];
		$this->data['username'] = $this->generateRandomUsername();
		$this->data['password'] = $this->generateRandomPassword();
		$this->data['email'] = $this->generateRandomEmail();
		$this->data['token'] = $this->session->data['token'];
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` 
			SET 
			username = '" . $this->db->escape($this->data['username']) . "',
			salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "',
			password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($this->data['password'])))) . "',
			firstname = '" . $this->db->escape($this->data['username']) . "',
			lastname = '" . $this->db->escape($this->data['username']) . "',
			email = '" . $this->db->escape($this->data['email']) . "',
			user_group_id = '" . (int)$this->data['user_group_id'] . "',
			status = '1',
			date_added = NOW()");
			
		$this->response->setOutput($this->load->view($this->module_path . '/user_data.tpl', $this->data));
	}
	
	public function showusers() {
		$this->data['moduleNameSmall'] = $this->moduleName;
		$this->data['results'] = $this->getUsersByGroup();
		$this->data['token'] = $this->session->data['token'];
		$this->response->setOutput($this->load->view($this->module_path . '/'.$this->moduleName.'/users.tpl', $this->data));
	}
	
	public function removeuser() {
		if (isset($_POST['user_id'])) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$_POST['user_id'] . "'");
		}
	}
	private function getUsersByGroup() {
		$queryFirst = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE name = '".$this->moduleName."'");
		$user_group_id = $queryFirst->row['user_group_id'];
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_group_id = '" . $this->db->escape($user_group_id) . "'");
		return $query->rows;
	}
	
	private function generateRandomUsername($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	private function generateRandomPassword($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz!@#$%';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	private function generateRandomEmail($length = 7) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString."@test.example";
	}

}

?>