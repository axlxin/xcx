<?php 
class ControllerCatalogRewards extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/rewards');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/rewards');
		
		$this->getList();
		 
	}
	
	private function getList() {
	
	$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/rewards', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	
	$data['heading_title'] = $this->language->get('heading_title');
	$data['entry_customer_group'] = $this->language->get('entry_customer_group');
	$data['entry_reward'] = $this->language->get('entry_reward');
	$data['entry_points'] = $this->language->get('entry_points');
	$data['button_generate'] = $this->language->get('button_generate');
	
	$data['action'] = $this->url->link('catalog/rewards/generate', 'token=' . $this->session->data['token'], 'SSL');
	
	$this->load->model('sale/customer_group');
		
	$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
	
	$this->load->model('localisation/order_status');
		
	$data['orderstatuses'] = $this->model_localisation_order_status->getOrderStatuses();
	
	
		
	if (isset($this->request->post['rewards_auto_order_id'])) {
			$data['rewards_auto_order_id'] = $this->request->post['rewards_auto_order_id'];
		} elseif ($this->config->get('rewards_auto_order_id')) { 
			$data['rewards_auto_order_id'] = $this->config->get('rewards_auto_order_id');
		}	
	
	if (isset($this->request->post['rewards_points'])) {
			$data['rewards_points'] = $this->request->post['rewards_points'];
		} elseif ($this->config->get('rewards_points')) { 
			$data['rewards_points'] = $this->config->get('rewards_points');
		}	
	
	$data['rewards_product_reward'] = array();
		
		if (isset($this->request->post['rewards_product_reward'])) {
			$data['rewards_product_reward'] = $this->request->post['rewards_product_reward'];
		} elseif ($this->config->get('rewards_product_reward')) { 
			$data['rewards_product_reward'] = $this->config->get('rewards_product_reward');
		}
		
		
	if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
	
	
	
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	$this->response->setOutput($this->load->view('catalog/rewards.tpl', $data));
	
	}
	
	public function generate() {
		$this->load->language('catalog/rewards');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/rewards');
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_setting->editSetting('rewards', $this->request->post); 
			
			$this->model_catalog_rewards->generateRewards($this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
	
			$this->response->redirect($this->url->link('catalog/rewards', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/rewards')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else { 
			return false;
		}
	}


	
}
?>