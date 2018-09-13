<?php
class ControllerCheckoutReward extends Controller {
	public function index() {
		$points = $this->customer->getRewardPoints();

		
$points_total = 0;
$rate_points2money = (int)$this->config->get('reward_points2money');
$rate_money2points = (int)$this->config->get('reward_money2points');
foreach ($this->cart->getProducts() as $product) {
    $product_total = (float)$product['total'];
    $points_total += $rate_points2money * $product_total;
}
$points_total = ceil($points_total);


		
if( $rate_points2money && $rate_money2points && $this->config->get('reward_status') ){


			$this->load->language('checkout/reward');

			$data['heading_title'] = sprintf($this->language->get('heading_title'), $points);

			$data['text_loading'] = $this->language->get('text_loading');

			$data['entry_reward'] = sprintf($this->language->get('entry_reward'), $points_total);

			$data['button_reward'] = $this->language->get('button_reward');

			if (isset($this->session->data['reward'])) {
				$data['reward'] = $this->session->data['reward'];
			} else {
				$data['reward'] = '';
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/reward.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/checkout/reward.tpl', $data);
			} else {
				return $this->load->view('default/template/checkout/reward.tpl', $data);
			}
		}
	}

	public function reward() {
		$this->load->language('checkout/reward');

		$json = array();

		$points = $this->customer->getRewardPoints();

		
$points_total = 0;
$rate_points2money = (int)$this->config->get('reward_points2money');
$rate_money2points = (int)$this->config->get('reward_money2points');
foreach ($this->cart->getProducts() as $product) {
    $product_total = (float)$product['total'];
    $points_total += $rate_points2money * $product_total;
}
$points_total = ceil($points_total);


		if (empty($this->request->post['reward'])) {
			$json['error'] = $this->language->get('error_reward');
		}

		if ($this->request->post['reward'] > $points) {
			$json['error'] = sprintf($this->language->get('error_points'), $this->request->post['reward']);
		}

		if ($this->request->post['reward'] > $points_total) {
			$json['error'] = sprintf($this->language->get('error_maximum'), $points_total);
		}

		if (!$json) {
			$this->session->data['reward'] = abs($this->request->post['reward']);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['redirect'])) {
				$json['redirect'] = $this->url->link($this->request->post['redirect']);
			} else {
				$json['redirect'] = $this->url->link('checkout/cart');	
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
