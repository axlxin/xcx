<?php
  class ControllerFullInformation extends Controller
  {
      public function edit() {
			
			if (!$this->customer->isLogged())
			 {
				$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

				$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		    
		     }

		     $this->load->language('account/address');

		     $this->document->setTitle($this->language->get('heading_title'));

            $this->document->addScript('catalog/view/javascript/jquery/layer/bootstrap/js/bootstrap.min.js');
			$this->document->addScript('catalog/view/javascript/jquery/layer/js/jquery-3.3.1.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/layer/bootstrap/css/bootstrap.min.css');
			$this->document->addStyle('catalog/view/javascript/jquery/layer//css/login.css')

			$this->load->model('account/address');

			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);

			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}

			$this->session->data['success'] = $this->language->get('text_edit');

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);
            
			$this->model_account_activity->addActivity('address_edit', $activity_data);

			$this->response->redirect($this->url->link('account/address', '', 'SSL'));
		}
		
       }


	

  }