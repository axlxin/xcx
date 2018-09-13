<?php
class ControllerTotalReward extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/reward');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('reward', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('total/reward', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('total/reward', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['reward_status'])) {
			$data['reward_status'] = $this->request->post['reward_status'];
		} else {
			$data['reward_status'] = $this->config->get('reward_status');
		}

		if (isset($this->request->post['reward_sort_order'])) {
			$data['reward_sort_order'] = $this->request->post['reward_sort_order'];
		} else {
			$data['reward_sort_order'] = $this->config->get('reward_sort_order');
		}

if (isset($this->request->post['reward_points2money'])) {
			$data['reward_points2money'] = $this->request->post['reward_points2money'];
		} else {
			$data['reward_points2money'] = $this->config->get('reward_points2money');
                        if( empty($data['reward_points2money']) ){
                            $data['reward_points2money'] = 0;
                        }
		}
                
if (isset($this->request->post['reward_money2points'])) {
			$data['reward_money2points'] = $this->request->post['reward_money2points'];
		} else {
			$data['reward_money2points'] = $this->config->get('reward_money2points');
                        if( empty($data['reward_money2points']) ){
                            $data['reward_money2points'] = 0;
                        }
		}

if (isset($this->request->post['reward_order_status_id'])) {
			$data['reward_order_status_id'] = $this->request->post['reward_order_status_id'];
		} else {
			$data['reward_order_status_id'] = $this->config->get('reward_order_status_id');
                        if( empty($data['reward_order_status_id']) ){
                            $data['reward_order_status_id'] = 0;
                        }
		}
                
$this->load->model('localisation/order_status');
$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();    


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/reward.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/reward')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}