<?php

/**
 * Google Analytics Ecommerce Tracking module for Opencart by Extensa Web Development
 *
 * Copyright © 2013 Extensa Web Development Ltd. All Rights Reserved.
 * This file may not be redistributed in whole or significant part.
 * This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author 		Extensa Web Development Ltd. (www.extensadev.com)
 * @copyright	Copyright (c) 2013, Extensa Web Development Ltd.
 * @package 	Google Analytics Ecommerce Tracking module
 * @link		http://www.opencart.com/index.php?route=extension/extension/info&extension_id=11242
 */

class ControllerModuleEcommerceTracking extends Controller {
	private $error = array();

	public $_allowedGoogleCurrencies = array(
			'USD' => 'US Dollars',
			'AED' => 'United Arab Emirates Dirham',
			'ARS' => 'Argentine Pesos',
			'AUD' => 'Australian Dollars',
			'BGN' => 'Bulgarian Lev',
			'BOB' => 'Bolivian Boliviano',
			'BRL' => 'Brazilian Real',
			'CAD' => 'Canadian Dollars',
			'CHF' => 'Swiss Francs',
			'CLP' => 'Chilean Peso',
			'CNY' => 'Yuan Renminbi',
			'COP' => 'Colombian Peso',
			'CZK' => 'Czech Koruna',
			'DKK' => 'Denmark Kroner',
			'EGP' => 'Egyptian Pound',
			'EUR' => 'Euros',
			'FRF' => 'French Francs',
			'GBP' => 'British Pounds',
			'HKD' => 'Hong Kong Dollars',
			'HRK' => 'Croatian Kuna',
			'HUF' => 'Hungarian Forint',
			'IDR' => 'Indonesian Rupiah',
			'ILS' => 'Israeli Shekel',
			'INR' => 'Indian Rupee',
			'JPY' => 'Japanese Yen',
			'KRW' => 'South Korean Won',
			'LTL' => 'Lithuanian Litas',
			'MAD' => 'Moroccan Dirham',
			'MXN' => 'Mexican Peso',
			'MYR' => 'Malaysian Ringgit',
			'NOK' => 'Norway Kroner',
			'NZD' => 'New Zealand Dollars',
			'PEN' => 'Peruvian Nuevo Sol',
			'PHP' => 'Philippine Peso',
			'PKR' => 'Pakistan Rupee',
			'PLN' => 'Polish New Zloty',
			'RON' => 'New Romanian Leu',
			'RSD' => 'Serbian Dinar',
			'RUB' => 'Russian Ruble',
			'SAR' => 'Saudi Riyal',
			'SEK' => 'Sweden Kronor',
			'SGD' => 'Singapore Dollars',
			'THB' => 'Thai Baht',
			'TRY' => 'Turkish Lira',
			'TWD' => 'New Taiwan Dollar',
			'UAH' => 'Ukrainian Hryvnia',
			'VEF' => 'Venezuela Bolivar Fuerte',
			'VND' => 'Vietnamese Dong',
			'ZAR' => 'South African Rand'
		);

	public function index() {
		$this->load->language('module/ecommerce_tracking');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('setting/store');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$ecommerce_tracking = $this->request->post;
			unset($ecommerce_tracking['config_google_analytics']);
			$this->model_setting_setting->editSetting('ecommerce_tracking', $ecommerce_tracking);

			foreach ($this->request->post['config_google_analytics'] as $store_id => $value) {
				$config_info = $this->model_setting_setting->getSetting('config', $store_id);
				if (!empty($value)) {
					$config_info['config_google_analytics'] = $value;
				} else {
					$config_info['config_google_analytics'] = $this->request->post['config_google_analytics'][0];
				}
				$this->model_setting_setting->editSetting('config', $config_info, $store_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_excl_tax'] = $this->language->get('text_excl_tax');
		$data['text_incl_tax'] = $this->language->get('text_incl_tax');

		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_convert_currency'] = $this->language->get('entry_convert_currency');
		$data['entry_product_price'] = $this->language->get('entry_product_price');
		$data['entry_google_analytics'] = $this->language->get('entry_google_analytics');

		$data['help_google_analytics'] = $this->language->get('help_google_analytics');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ecommerce_tracking', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/ecommerce_tracking', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ecommerce_tracking_sku'])) {
			$data['ecommerce_tracking_sku'] = $this->request->post['ecommerce_tracking_sku'];
		} else {
			$data['ecommerce_tracking_sku'] = $this->config->get('ecommerce_tracking_sku');
		}

		if (isset($this->request->post['ecommerce_tracking_status'])) {
			$data['ecommerce_tracking_status'] = $this->request->post['ecommerce_tracking_status'];
		} else {
			$data['ecommerce_tracking_status'] = $this->config->get('ecommerce_tracking_status');
		}

		if (isset($this->request->post['ecommerce_tracking_convert_currency'])) {
			$data['ecommerce_tracking_convert_currency'] = $this->request->post['ecommerce_tracking_convert_currency'];
		} else {
			$data['ecommerce_tracking_convert_currency'] = $this->config->get('ecommerce_tracking_convert_currency');
		}

		if (isset($this->request->post['ecommerce_tracking_currency'])) {
			$data['ecommerce_tracking_currency'] = $this->request->post['ecommerce_tracking_currency'];
		} else {
			$data['ecommerce_tracking_currency'] = $this->config->get('ecommerce_tracking_currency');
		}

		if (isset($this->request->post['ecommerce_tracking_tax'])) {
			$data['ecommerce_tracking_tax'] = $this->request->post['ecommerce_tracking_tax'];
		} else {
			$data['ecommerce_tracking_tax'] = $this->config->get('ecommerce_tracking_tax');
		}

		if (isset($this->request->post['config_google_analytics'][0])) {
			$data['config_google_analytics'] = $this->request->post['config_google_analytics'][0]; 
		} else {
			$data['config_google_analytics'] = $this->config->get('config_google_analytics');
		}

		$data['skus'] = array(
			array('id' => 'id', 'name' => $this->language->get('text_product_id')),
			array('id' => 'sku', 'name' => $this->language->get('text_sku')),
			array('id' => 'id_option', 'name' => $this->language->get('text_id_option')),
			array('id' => 'sku_option', 'name' => $this->language->get('text_sku_option'))
		);

		$data['store_name'] = $this->config->get('config_name');

		$this->load->model('localisation/currency');

		$data['currencies'] = array();

		$results = $this->model_localisation_currency->getCurrencies();

		$intersect_currencies = array_intersect_key($results, $this->_allowedGoogleCurrencies);

		foreach ($intersect_currencies as $result) {
			if ($result['status']) {
				$data['currencies'][] = array(
					'title'        => $result['title'],
					'code'         => $result['code']
				);
			}
		}

		$stores = $this->model_setting_store->getStores();

		$data['stores'] = array();

		foreach ($stores as $store) {
			$config_info = $this->model_setting_setting->getSetting('config', $store['store_id']);

			$data['stores'][] = array(
				'store_id'          => $store['store_id'],
				'name'              => $store['name'],
				'google_analytics'  => (!empty($config_info['config_google_analytics']) ? $config_info['config_google_analytics'] : $data['config_google_analytics'])
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/ecommerce_tracking.tpl', $data));
	}

	public function install() {
		if (preg_match("/2.1/i", VERSION)) {
			$this->load->model('setting/setting');

			$google_analytics_data = array(
				'google_analytics_status' => 0
			);

			$this->model_setting_setting->editSetting('google_analytics', $google_analytics_data);
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ecommerce_tracking')) {
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