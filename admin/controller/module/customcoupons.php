<?php
class ControllerModuleCustomcoupons extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/customcoupons');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                        $this->model_setting_setting->editSetting('config_custom_coupons', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_enable_custom_coupons'] = $this->language->get('text_enable_custom_coupons');
                $data['button_coupon'] = $this->language->get('button_coupon');
                
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->load->model('localisation/language');
		$data['langs']  = $this->model_localisation_language->getLanguages();
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error'] = '';
		}

                if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
       		'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
       		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
                'href'      => $this->url->link('module/customcoupons', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
		$data['action'] = $this->url->link('module/customcoupons', 'token=' . $this->session->data['token'], 'SSL');
                
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['url_coupon'] = $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'], 'SSL');
                $data['module'] = array();
		
		if (isset($this->request->post['config_custom_coupons'])) {
			$data['config_custom_coupons'] = $this->request->post['config_custom_coupons']; 
		} else {
			$data['config_custom_coupons'] = $this->config->get('config_custom_coupons')?$this->config->get('config_custom_coupons'):'N';
		}
		
		$data['token'] =  $this->session->data['token'];

		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
						
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('module/customcoupons', $data));

	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/customcoupons')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

        public function couponnotification() {
		$this->language->load('marketing/coupon');
		$this->language->load('module/customcoupons');
		$this->load->model('marketing/coupon');
                
                $this->document->setTitle($this->language->get('heading_title'));
      		$data['heading_title'] = $this->language->get('text_notification');
                
                $coupon_info = $this->model_marketing_coupon->getCoupon($this->request->get['coupon_id']);
                if($coupon_info['status'] != 1){
                    $this->session->data['error'] = 'Coupon is Disabled';
                    $this->response->redirect($this->url->link('marketing/coupon', 'token=' . $this->session->data['token'], 'SSL'));                    
                }

                $data['text_specific_customers'] = $this->language->get('text_specific_customers');
                $data['text_notification_customers'] = $this->language->get('text_notification_customers');
                $data['text_notification_message'] = $this->language->get('text_notification_message');
                $data['help_text_notification_message'] = $this->language->get('help_text_notification_message');
                $data['text_notification_subject'] = $this->language->get('text_notification_subject');
                $data['text_extra_notification_customers'] = $this->language->get('text_extra_notification_customers');
                $data['help_text_extra_notification_customers'] = $this->language->get('help_text_extra_notification_customers');
                $data['text_notification'] = $this->language->get('text_notification');
                $data['entry_customer'] = $this->language->get('entry_customer');

                
                $data['help_text_notification_customers'] = $this->language->get('help_text_notification_customers');
                
                $data['button_notification'] = $this->language->get('button_notification');
                $data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');
                
                $data['text_no_results'] = $this->language->get('text_no_results');                
 
                $data['token'] = $this->session->data['token'];
                
		$data['breadcrumbs'] = array();

                $data['breadcrumbs'][] = array(
                        'text'      => $this->language->get('text_home'),
                        'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
                        'separator' => false
                );

                $data['breadcrumbs'][] = array(
                        'text'      => $this->language->get('text_module'),
                        'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
                        'separator' => false
                );

                $data['breadcrumbs'][] = array(
                        'text'      => $this->language->get('heading_title'),
                        'href'      => $this->url->link('module/customcoupons', 'token=' . $this->session->data['token'], 'SSL'),
                        'separator' => false
                );

                if (isset($this->session->data['error'])) {
                        $data['error'] = $this->session->data['error'];
                        unset($this->session->data['error']);
                } else {
                        $data['error'] = '';
                }

                if (isset($this->session->data['success'])) {
                        $data['success'] = $this->session->data['success'];
                        unset($this->session->data['success']);
                } else {
                        $data['success'] = '';
                }
                
                if (isset($this->request->get['coupon_id'])) { 
                     $data['coupon_id'] = $this->request->get['coupon_id'];
                 }        
	
                 if (isset($coupon_info['coupon_subject']) && $coupon_info['coupon_subject']!= '' ) { 
                     $data['subject'] = $coupon_info['coupon_subject'];
                 } else {
                     $data['subject'] = 'Find your discount coupon inside';
                 }        
                if (isset($coupon_info['coupon_message']) && $coupon_info['coupon_message'] != '') { 
                     $data['message'] = $coupon_info['coupon_message'];
                 } else {
                     $data['message'] = '<p>Hello {firstname} {lastname} ,</p><p>As our esteemed customer, we would like to provide you with discount code below to get discount on your next purchase at <a href="'.HTTP_CATALOG.'">'.HTTP_CATALOG.'</a><br />your coupon code: {couponcode}</p><p>Thanks,<br />Admin</p>';
                 }        
                        
                $results = $this->model_marketing_coupon->getCouponSpecificCustomers($this->request->get['coupon_id']);
                $this->load->model('customer/customer');
                $data['coupon_customer_notification'] = array();
				
                foreach ($results as $customer_id) {
                    $customer_info = $this->model_customer_customer->getCustomer($customer_id);
                    $data['coupon_customer_notification'][] = array(
                        'customer_id'   => $customer_id,
                        'name'   => $customer_info['firstname']." ".$customer_info['lastname']." (".$customer_info['customer_id'].")",//strip_tags(html_entity_decode($customer_info['firstname']." ".$customer_info['lastname'],ENT_QUOTES, 'UTF-8'));
                    );
                }			
		
                $this->load->model('design/layout');

                $data['layouts'] = $this->model_design_layout->getLayouts();
                $data['action']  = $this->url->link('module/customcoupons/sendnotification', 'token=' . $this->session->data['token'], 'SSL');
                $data['cancel'] = $this->url->link('module/customcoupons', 'token=' . $this->session->data['token'], 'SSL');

                $data['header'] = $this->load->controller('common/header');
                $data['column_left'] = $this->load->controller('common/column_left');
                $data['footer'] = $this->load->controller('common/footer');

                $this->response->setOutput($this->load->view('marketing/coupon_custom_notification', $data));
  	}		

        public function sendnotification(){
        	//echo "<pre>";print_r($_POST);echo "<pre>";
                $this->language->load('module/customcoupons');
                $extra_emails = array();
                $customer_ids = array();
                $mailLog=new Log('customcouponMail-'.date('Y-m-d').'.log');
                if($this->request->post['extra_emails_notifications'] != ''){
                    $extra_emails =  $this->request->post['extra_emails_notifications'];
                    $extra_emails = explode(",",$extra_emails);
                }
                $error = array(); 
                if (isset($this->request->post['notification_coupon_id'])) { 
                     $coupon_id = $this->request->post['notification_coupon_id'];
                 } else {
                     $error[] = $this->language->get('error_no_coupon_id');
                 }        

                 if (isset($this->request->post['coupon_customer_notification'])) { 
                     $customer_ids = $this->request->post['coupon_customer_notification'];
                     if(( empty($customer_ids) || $customer_ids[0]< 1 ) && empty($extra_emails)){
                         $error[] = $this->language->get('error_no_customer');
                     }
                 }elseif(empty($extra_emails)) {
                     $error[] = $this->language->get('error_no_customer');
                 }        

                if (isset($this->request->post['subject']) && trim($this->request->post['subject'])) { 
                    $subject = $this->request->post['subject'];
                 } else {
                     $error[] = $this->language->get('error_no_subject');
                 }
                 
                if (isset($this->request->post['message']) && trim($this->request->post['message'])) { 
                     $message = $this->request->post['message'];
                 } else {
                     $error[] = $this->language->get('error_no_message');
                 }
                if(!empty($error)){
                    $this->session->data['error'] = implode(" , ",$error);
                    $this->response->redirect($this->url->link('module/customcoupons/couponnotification', 'token=' . $this->session->data['token'].'&coupon_id='.$coupon_id, 'SSL'));
                    //$this->redirect($this->url->link('module/customcoupons', 'token=' . $this->session->data['token'], 'SSL'));                    
                }
                
                $this->language->load('marketing/coupon');
		$this->load->model('marketing/coupon');
		$this->load->model('customer/customer');
				
                $this->db->query("UPDATE " . DB_PREFIX . "coupon SET  coupon_subject= '" . $this->db->escape($subject) . "',coupon_message= '" . $this->db->escape($message) . "' WHERE coupon_id = '" . (int)$coupon_id . "' LIMIT 1 ");    
		$coupon_info = $this->model_marketing_coupon->getCoupon($coupon_id);
                if(is_array($customer_ids) && !empty($customer_ids)){
                    foreach($customer_ids as $customer_id){
                         $customer_info = $this->model_customer_customer->getCustomer($customer_id);
                         $firstname = $customer_info['firstname'];
                         $lastname =  $customer_info['lastname'];
                         $email =  $customer_info['email'];
                         $custom_message = '';
                         $custom_message = str_replace("{firstname}", $firstname, $message);
                         $custom_message = str_replace("{lastname}", $lastname, $custom_message);
                         $custom_message = str_replace("{couponcode}", $coupon_info['code'], $custom_message);
                            $mailmessage  = '<html dir="ltr" lang="en">' . "\n";
                            $mailmessage .= '  <head>' . "\n";
                            $mailmessage .= '    <title>' . $subject . '</title>' . "\n";
                            $mailmessage .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
                            $mailmessage .= '  </head>' . "\n";
                            $mailmessage .= '  <body>' . html_entity_decode($custom_message, ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
                            $mailmessage .= '</html>' . "\n";
                            $mail = new Mail();	
                            $mail->protocol = $this->config->get('config_mail_protocol');
                            $mail->smtp_parameter = $this->config->get('config_mail_parameter');
                            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                            $mail->smtp_password = $this->config->get('config_mail_smtp_password');
                            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');				
                            $mail->setTo($email);
                            $mail->setFrom($this->config->get('config_email'));
                            $mail->setSender($this->config->get('config_name'));
                            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));					
                            $mail->setHtml($mailmessage);
                            $rs=$mail->send();
                            if($rs){
                                $mailLog->write('mail send .'.print_R($mail,true));
                            }else{
                                $mailLog->write('mail not send .'.print_R($mail,true));
                            }
                            unset($mail);    
                     }
                }
                if(is_array($extra_emails) && !empty($extra_emails)){
                    foreach($extra_emails as $email){
                         $customer_info = $this->model_customer_customer->getCustomerByEmail($email);
                         $customer_id = '';
                         $firstname = '';
                         $lastname = '';
                         if(!empty($customer_info)){
                            $customer_id = $customer_info['customer_id'];
                            $firstname = $customer_info['firstname'];
                            $lastname =  $customer_info['lastname'];
                            ## dont send coupon again if its already been send in above mail loop.
                            if(in_array($customer_id, $customer_ids)) continue;
                         }
                         $custom_message = '';
                         $custom_message = str_replace("{firstname}", $firstname, $message);
                         $custom_message = str_replace("{lastname}", $lastname, $custom_message);
                         $custom_message = str_replace("{couponcode}", $coupon_info['code'], $custom_message);
                            $mailmessage  = '<html dir="ltr" lang="en">' . "\n";
                            $mailmessage .= '  <head>' . "\n";
                            $mailmessage .= '    <title>' . $subject . '</title>' . "\n";
                            $mailmessage .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
                            $mailmessage .= '  </head>' . "\n";
                            $mailmessage .= '  <body>' . html_entity_decode($custom_message, ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
                            $mailmessage .= '</html>' . "\n";
                            $mail = new Mail();	
                            $mail->protocol = $this->config->get('config_mail_protocol');
                            $mail->parameter = $this->config->get('config_mail_parameter');
                            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                            $mail->smtp_password = $this->config->get('config_mail_smtp_password');
                            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');			
                            $mail->setTo($email);
                            $mail->setFrom($this->config->get('config_email'));
                            $mail->setSender($this->config->get('config_name'));
                            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));					
                            $mail->setHtml($mailmessage);
                            $rs=$mail->send();
                            if($rs){
                                $mailLog->write('mail send .'.print_R($mail,true));
                            }else{
                                $mailLog->write('mail not send .'.print_R($mail,true));
                            }
                            unset($mail);    
                     }
                }
                 
                $this->session->data['success'] = $this->language->get('text_notification_success');
                $this->response->redirect($this->url->link('module/customcoupons/couponnotification', 'token=' . $this->session->data['token'].'&coupon_id='.$coupon_id, 'SSL'));                    
        }       
		
        public function install() {
            ## Add specific_customer into coupon table.
            $this->db->query("
                 ALTER TABLE `" . DB_PREFIX . "coupon` ADD `customer_specific` char(2) NOT NULL DEFAULT 'N', ADD `coupon_subject` VARCHAR( 250 ) NULL , ADD `coupon_message` TEXT NULL;
             ");
            ##also create coupon_customer table.
            $this->db->query("
                 CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "coupon_customer` (
                        `coupon_id` int(11) NOT NULL,
                        `customer_id` int(11) NOT NULL,
                        PRIMARY KEY (`coupon_id`,`customer_id`))
             ");

       }        
        public function uninstall() {
            ## remove field reference from table.
            $this->db->query("
                 ALTER TABLE `" . DB_PREFIX . "coupon` DROP `customer_specific` , DROP `coupon_subject` , DROP `coupon_message` ;
             "); 
			 
            $this->db->query("
                 DROP TABLE IF EXISTS `" . DB_PREFIX . "coupon_customer`;
             ");

        }

}
?>