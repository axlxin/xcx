<?php
class ControllerGuestbookEntry extends Controller {
  private $error = array();
 
  public function index() {
    $this->load->language('guestbook/guestbook');
 
    $this->document->setTitle($this->language->get('heading_title'));
    
    $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

    
 
    $data['success'] = '';
    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    }
 
  
 
    $data['action'] = $this->url->link('guestbook/entry', '', true);
     
    if (isset($this->request->post['guest_name'])) {
      $data['guest_name'] = $this->request->post['guest_name'];
    } else {
      $data['guest_name'] = '';
    }
     
    if (isset($this->request->post['guest_message'])) {
      $data['guest_message'] = $this->request->post['guest_message'];
    } else {
      $data['guest_message'] = '';
    }

   if (!isset($this->request->get['address_id'])) {
      $data['action'] = $this->url->link('guestbook/entry', '', 'SSL');
    } else {
      $data['action'] = $this->url->link('guestbook/entry', 'address_id=' . $this->request->get['address_id'], 'SSL');
    }


    $this->load->model('localisation/country');
    $this->load->model('account/address');
    $this->load->model('account/customer');
   if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      $address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
      //var_dump($address_info);
      $data['address_id'] =$this->request->get['address_id'];
    }
    $data['countries'] = $this->model_localisation_country->getCountries();
    
     
    if (isset($this->request->post['customer_id'])) {
      $data['customer_id'] = $this->request->post['customer_id'];
    } elseif (!empty($address_info)) {
      $data['customer_id'] = $address_info['customer_id'];
    } else {
      $data['customer_id'] = '';
    }

   // var_dump($data['customer_id']);
    // if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
    //   $customer_info = $this->model_account_customer->getCustomer($data['customer_id']);
    // }
    
    // var_dump($customer_info);
     if (isset($this->request->post['telephone'])) {
      $data['telephone'] = $this->request->post['telephone'];
    } elseif (!empty($address_info)) {
      $data['telephone'] = $address_info['telephone'];
    } else {
      $data['telephone'] = '';
    }

    if (isset($this->request->post['firstname'])) {
      $data['firstname'] = $this->request->post['firstname'];
    } elseif (!empty($address_info)) {
      $data['firstname'] = $address_info['firstname'];
    } else {
      $data['firstname'] = '';
    }
    
    if(isset($this->request->post['company']))
      {
        $data['company'] = $this->request->post['company'];
      }
      elseif(!empty($address_info))
      {
        $data['company'] = $address_info['company'];
      }
      else
      {
        $data['company'] ='';
      }


    if (isset($this->request->post['lastname'])) {
      $data['lastname'] = $this->request->post['lastname'];
    } elseif (!empty($address_info)) {
      $data['lastname'] = $address_info['lastname'];
    } else {
      $data['lastname'] = '';
    }

    if (isset($this->request->post['company'])) {
      $data['company'] = $this->request->post['company'];
    } elseif (!empty($address_info)) {
      $data['company'] = $address_info['company'];
    } else {
      $data['company'] = '';
    }

    if (isset($this->request->post['address_1'])) {
      $data['address_1'] = $this->request->post['address_1'];
    } elseif (!empty($address_info)) {
      $data['address_1'] = $address_info['address_1'];
    } else {
      $data['address_1'] = '';
    }

    if (isset($this->request->post['address_2'])) {
      $data['address_2'] = $this->request->post['address_2'];
    } elseif (!empty($address_info)) {
      $data['address_2'] = $address_info['address_2'];
    } else {
      $data['address_2'] = '';
    }

    if (isset($this->request->post['postcode'])) {
      $data['postcode'] = $this->request->post['postcode'];
    } elseif (!empty($address_info)) {
      $data['postcode'] = $address_info['postcode'];
    } else {
      $data['postcode'] = '';
    }

    if (isset($this->request->post['city'])) {
      $data['city'] = $this->request->post['city'];
    } elseif (!empty($address_info)) {
      $data['city'] = $address_info['city'];
    } else {
      $data['city'] = '';
    }
    

    if (isset($this->request->post['country_id'])) {
      $data['country_id'] = $this->request->post['country_id'];
    }  elseif (!empty($address_info)) {
      $data['country_id'] = $address_info['country_id'];
    } else {
      $data['country_id'] = $this->config->get('config_country_id');
    }

    if (isset($this->request->post['zone_id'])) {
      $data['zone_id'] = $this->request->post['zone_id'];
    }  elseif (!empty($address_info)) {
      $data['zone_id'] = $address_info['zone_id'];
    } else {
      $data['zone_id'] = '';
    }
    //var_dump($data['zone_id']);

  
  
    $this->response->setOutput($this->load->view('default/template/guestbook/entry.tpl',$data));
    

  }

  //新建change方法,便于ajax提交
 public function change()
 {
    $this->load->model('guestbook/guestbook');
    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      $address_info=$this->model_guestbook_guestbook->editAddress($this->request->get['address_id'], $this->request->post);
    }

 }

 
  protected function validate() {
    if (utf8_strlen(trim($this->request->post['guest_name'])) < 1) {
      $this->error['guest_name'] = $this->language->get('error_guest_name');
    }
     
    if (utf8_strlen(trim($this->request->post['guest_message'])) < 1) {
      $this->error['guest_message'] = $this->language->get('error_guest_message');
    }
 
    return !$this->error;
  }

  

}