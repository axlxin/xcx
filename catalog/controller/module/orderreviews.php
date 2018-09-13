<?php
class ControllerModuleOrderReviews extends Controller {
	
	private $moduleName = 'orderreviews';
	private $moduleModel = 'model_module_orderreviews';
	
    public function sendEmails()  {
        $this->load->model('setting/setting');
		$this->load->model('setting/store');
		$this->load->model('localisation/language');
        $this->load->model('module/'.$this->moduleName);
		
		$stores = array_merge(array(0 => $this->{$this->moduleModel}->getStore(0)), $this->model_setting_store->getStores());
		foreach ($stores as $store) {
			$setting = $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
			$moduleData = isset($setting[$this->moduleName]) ? $setting[$this->moduleName] : array();
			if (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes' && isset($moduleData['ReviewMail'])) {
				$counter = 0;
				
				foreach ($moduleData['ReviewMail'] as $reviewmail) {
					if ($reviewmail['Enabled']=='yes') {
						$orders = $this->{$this->moduleModel}->getOrders($reviewmail['OrderStatusID'], $reviewmail['Delay'], $reviewmail['DateType']);
						foreach ($orders as $order) {
							if (!(($reviewmail['CustomerGroupID'] == 'send_all') || ($reviewmail['CustomerGroupID'] != 'send_all' && $reviewmail['CustomerGroupID']==$order['customer_group_id']))) {
								break;	
							}
							if ($this->{$this->moduleModel}->checkReviewLog($order['order_id'])) {
								continue;	
							}
							
							$OrderLanguage = $this->model_localisation_language->getLanguage($order['language_id']);
							$LangVars = $this->{$this->moduleModel}->loadLanguage($OrderLanguage['directory'].'/module','orderreviews');
							$OrderProducts = $this->{$this->moduleModel}->getOrderProducts($order['order_id']);
							$Products = '';
							$ProductIDs = '';
							if (sizeof($OrderProducts)==1) {
								$Products = '<a href="'.$store['url'].'index.php?route=product/product&amp;product_id=' . $OrderProducts[0]['product_id'].'">'.$OrderProducts[0]['name'].'</a>';
								$ProductIDs = $OrderProducts[0]['product_id'];
							} else {
								for ($i=0; $i<sizeof($OrderProducts); $i++) {
									if (($i+1) == sizeof($OrderProducts)) {
										$Products .= ' '.$LangVars['text_and'].' ';
									}  else if (($i+1) < sizeof($OrderProducts) && ($i>0)) {
										$Products .= ', ';	
									}
									$Products .= '<a href="'.$store['url'].'index.php?route=product/product&amp;product_id=' . $OrderProducts[$i]['product_id'].'">'.$OrderProducts[$i]['name'].'</a>';
									$ProductIDs .= $OrderProducts[$i]['product_id'];
									
									if (!(($i+1) == sizeof($OrderProducts)))
											$ProductIDs .= '_';
								}
							}
							$subject_original = array('{first_name}','{last_name}', '{order_id}');
							$subject_replace = array($order['firstname'], $order['lastname'], $order['order_id']);
							$Subject = str_replace($subject_original, $subject_replace, $reviewmail['Subject'][$order['language_id']]);
							$Message = html_entity_decode($reviewmail['Message'][$order['language_id']]);
							$FirstName = $order['firstname'];
							$LastName = $order['lastname'];
							$Email = $order['email'];
							$SubmitLink = $store['url'].'index.php?route=module/orderreviews/sendReview';
							$ReveiewMailLink = $store['url'].'index.php?route=module/orderreviews/sendReview&order_id='.$order['order_id'].'&reviewmail_id='.$reviewmail['id'].'&store_id='.$store['store_id'];
													
							
							$ProductFormData = $this->{$this->moduleModel}->fetchForm('default/template/module/orderreviews_product_form_include.tpl');			
							$ProductsViews = "";
							
							
							if ($reviewmail['ReviewType'] == 'per_purchase') {
								$tempVar = '';
								$old = array("{number}","{pr_name}","{pr_id}","{image}");
								$new = array('0','','0',NULL);
								$tempVar = str_replace($old, $new, $ProductFormData);
								$ProductsViews .= $tempVar;
							} else if ($reviewmail['ReviewType'] == 'per_product') { 
								if (sizeof($OrderProducts)>0) {
									for ($i=0; $i<sizeof($OrderProducts); $i++) {
										$tempVar = '';
										if($reviewmail['DisplayImages'] == 'yes'){										
											$this->load->model('catalog/product');
											$product_info = $this->model_catalog_product->getProduct($OrderProducts[$i]['product_id']);
											$this->load->model('tool/image');
											if ($product_info['image']) { $image = $this->model_tool_image->resize($product_info['image'], 200, 200); } else { $image = false; }										
											$old = array("{number}","{pr_name}","{pr_id}","{image}");
											$new = array($OrderProducts[$i]['product_id'],$OrderProducts[$i]['name'].':',$OrderProducts[$i]['product_id'].'<br/>',"<img src='".$image."' />");
										} else {
											$old = array("{number}","{pr_name}","{pr_id}","{image}");
											$new = array($OrderProducts[$i]['product_id'],$OrderProducts[$i]['name'].':',$OrderProducts[$i]['product_id'].'<br/>',NULL);									
										}
										$tempVar = str_replace($old, $new, $ProductFormData);
										$ProductsViews .= $tempVar;
									}
								}
							}
							
							if(!empty($moduleData['EmailType']) && $moduleData['EmailType'] == 'link'){
								
								$MainFormData = $this->{$this->moduleModel}->fetchForm('default/template/module/orderreviews_review_email_form.tpl');
															
								$form_pattern = array("{submit_link}","{first_name}", "{last_name}", "{customer_id}", "{text_submit}", "{text_review}", "{product_id}", "{order_id}", "{customer_name}", "{reviewmail_id}", "{email}","{product_info}","{reviewmail_link_href}");
								$form_replacements = array($SubmitLink, $FirstName, $LastName, $order['customer_id'], $LangVars['text_submit'], $LangVars['text_review'], $ProductIDs, $order['order_id'], $FirstName.' '.$LastName, $reviewmail['id'], $Email, $ProductsViews, $ReveiewMailLink);
																
							}else{
								$MainFormData = $this->{$this->moduleModel}->fetchForm('default/template/module/orderreviews_product_form_main.tpl');
								
								$form_pattern = array("{submit_link}","{first_name}", "{last_name}", "{customer_id}", "{text_submit}", "{text_review}", "{product_id}", "{order_id}", "{customer_name}", "{reviewmail_id}", "{email}","{product_info}");				
								$form_replacements = array($SubmitLink, $FirstName, $LastName, $order['customer_id'], $LangVars['text_submit'], $LangVars['text_review'], $ProductIDs, $order['order_id'], $FirstName.' '.$LastName, $reviewmail['id'], $Email, $ProductsViews);	
													
							}
								
							
							
							$ReviewForm = str_replace($form_pattern, $form_replacements, $MainFormData);
							
							if(!empty($moduleData['EmailType']) && $moduleData['EmailType'] == 'link'){
								$patterns = array('{first_name}', '{last_name}', '{review_form}', '{order_products}', '{order_id}','{reviewmail_link}');
								$replacements = array($FirstName, $LastName, $ReviewForm, $Products, $order['order_id'],$LangVars['link_replacement']);	
							}else {
								$patterns = array('{first_name}', '{last_name}', '{review_form}', '{order_products}', '{order_id}', '{reviewmail_link}', '{reviewmail_link_href}');
								$replacements = array($FirstName, $LastName, $ReviewForm, $Products, $order['order_id'], $LangVars['text_reviewmail_link'], $ReveiewMailLink);								
							}
							
							$HTMLMail = str_replace($patterns, $replacements, $Message);
							
							
							$newMail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
									<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
									<title>Monthly Newsletter</title>
								</head>
								<body>'.$HTMLMail.'</body></html>';

							$MailData = array(
								'email' =>  $Email,
								'message' => $newMail, 
								'subject' => $Subject,
								'store_name' => $store['name'],
								'store_id' => $store['store_id']);
						
							$emailResult = $this->{$this->moduleModel}->sendMail($MailData);
							$counter++;
						}
					}
				}
				
				$result = "Cron was executed successfully! A total of <strong>".$counter."</strong> emails were sent to the customers.<br />";
	
				if (isset($moduleData['CronNotification']) && $moduleData['CronNotification']=='yes') {
					if (VERSION < '2.0.2.0' || (VERSION > '2.0.3.0' && VERSION < '2.1.0.1')) {
						$mailToUser = new Mail($this->config->get('config_mail'));
					} else {
						$mailToUser = new Mail();
						$mailToUser->protocol = $this->config->get('config_mail_protocol');
						$mailToUser->parameter = $this->config->get('config_mail_parameter');
						$mailToUser->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
						$mailToUser->smtp_username = $this->config->get('config_mail_smtp_username');
						$mailToUser->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
						$mailToUser->smtp_port = $this->config->get('config_mail_smtp_port');
						$mailToUser->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
					}
					$mailToUser->setTo($this->config->get('config_email'));
					$mailToUser->setFrom($this->config->get('config_email'));
					$mailToUser->setSender($this->config->get('config_name'));
					$mailToUser->setSubject(html_entity_decode('OrderReviews Cron Task', ENT_QUOTES, 'UTF-8'));
					$mailToUser->setHtml($result);
					$mailToUser->send(); 
				} else {
					echo $result;	
				}	
			}
		}
    }
	
	public function sendReview()  {
		$this->language->load('product/product');
		$this->language->load('module/orderreviews');
		$this->load->model('catalog/review');
		$this->load->model('setting/setting');
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['button_back'] = $this->language->get('button_back');
		$error = array();
		$missing_data = true;
		
		if ($this->request->server['REQUEST_METHOD'] == 'GET' && isset($this->request->get['orderreviews'])) {
			$missing_data = false;
			$this->load->model('module/'.$this->moduleName);
			$this->load->model('setting/setting');
			$setting = $this->model_setting_setting->getSetting($this->moduleName, $this->config->get('config_store_id'));
			$moduleData = $setting[$this->moduleName];
			
			if (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes') {
				$reviewData = $setting[$this->moduleName]['ReviewMail'][$this->request->get['reviewmail_id']];
				$couponChance = false;
				
				if ($reviewData['ReviewType'] == 'per_purchase') {
					if ((utf8_strlen($this->request->get['name']) < 3) || (utf8_strlen($this->request->get['name']) > 100)) {
						$error['error'] = $this->language->get('error_name');
					}
		
					if ((utf8_strlen($this->request->get['orderreviews'][0]['text']) < 10) || (utf8_strlen($this->request->get['orderreviews'][0]['text']) > 1000)) {
						$error['error'] = $this->language->get('error_text');
					}
		
					if (empty($this->request->get['orderreviews'][0]['rating'])) {
						$error['error'] = $this->language->get('error_rating');
					}
					
					if (isset($this->request->get['order_id']) && ($this->{$this->moduleModel}->checkReviewLog($this->request->get['order_id']))) {
						$error['error'] = $this->language->get('error_duplicate');	
					}
					
					if (!isset($error['error'])) {
						$products = explode('_', $this->request->get['product_ids']);
						foreach ($products as $product_id) {
							$data = array(
							'name' => $this->request->get['name'],
							'customer_id' => $this->request->get['customer_id'],
							'product_id' => $product_id,
							'text' => $this->request->get['orderreviews'][0]['text'],
							'rating' => $this->request->get['orderreviews'][0]['rating']
							);
							$this->model_catalog_review->addReview($product_id, $data);
						}
						$this->{$this->moduleModel}->addReviewLog($this->request->get['order_id']);
						$data['success'] = $this->language->get('successfull_review');
						$data['button_continue'] = $this->language->get('button_continue');
						$data['continue'] = $this->url->link('common/home');
						$couponChance = true;
					} else {
						$data['errors'] = $this->language->get('text_errors');
						$data['errorsArray'] = $error;
					}
				} else if ($reviewData['ReviewType'] == 'per_product') { 
					if (isset($this->request->get['order_id']) && ($this->{$this->moduleModel}->checkReviewLog($this->request->get['order_id']))) {
						$error['error'] = $this->language->get('error_duplicate');
						$data['errors'] = $this->language->get('text_errors');
						$data['errorsArray'] = $error;
					} else {
						$products = explode('_', $this->request->get['product_ids']);
						$checker = false;
						foreach ($products as $product_id) {
							if (!empty($this->request->get['orderreviews'][$product_id]['text']) && !empty($this->request->get['orderreviews'][$product_id]['rating'])){ 
								$data = array(
								'name' => $this->request->get['name'],
								'customer_id' => $this->request->get['customer_id'],
								'product_id' => $product_id,
								'text' => $this->request->get['orderreviews'][$product_id]['text'],
								'rating' => $this->request->get['orderreviews'][$product_id]['rating']
								);
								$this->model_catalog_review->addReview($product_id, $data);
								$checker = true;
							}
						}
						if (!$checker) {
							$error['error'] = $this->language->get('no_reviews');
							$data['errors'] = $this->language->get('text_errors');
							$data['errorsArray'] = $error;
						} else {
							$this->{$this->moduleModel}->addReviewLog($this->request->get['order_id']);
							$data['success'] = $this->language->get('successfull_review');
							$data['button_continue'] = $this->language->get('button_continue');
							$data['continue'] = $this->url->link('common/home');
							$couponChance = true;
						}
					}
				}
				
				if ($couponChance) {
					if ($reviewData['DiscountType']!='N') {
						$DiscountCode			= $this->{$this->moduleModel}->generateuniquerandomcouponcode();
						$TimeEnd				=  time() + $reviewData['DiscountValidity'] * 24 * 60 * 60;
						$CouponData				= array('name' => 'OrderReviews Coupon [' . $this->request->get['name'] . ']',
						'code'					=> $DiscountCode, 
						'discount'				=> $reviewData['Discount'],
						'type'					=> $reviewData['DiscountType'],
						'total'					=> $reviewData['TotalAmount'],
						'logged'				=> '0',
						'shipping'				=> '0',
						'date_start'			=> date('Y-m-d', time()),
						'date_end'				=> date('Y-m-d', $TimeEnd),
						'uses_total'			=> '1',
						'uses_customer'			=> '1',
						'status'				=> '1');
						$this->{$this->moduleModel}->addCoupon($CouponData);
						
						$discount_text = $this->language->get('text_discount');
						$discount_value = ($reviewData['DiscountType']=='F') ? $this->currency->format($reviewData['Discount'],$this->session->data['currency']) : $reviewData['Discount'].'%';
						$total_amount = $this->currency->format($reviewData['TotalAmount'],$this->session->data['currency']);
						$patterns = array('{discount_code}', '{discount_value}', '{total_amount}', '{date_end}');
						$replacements = array($DiscountCode, $discount_value, $total_amount, date($reviewData['DateFormat'], $TimeEnd));
						$data['discount_text'] = str_replace($patterns, $replacements, $discount_text);
						
						if (isset($reviewData['DiscountMailEnabled']) && $reviewData['DiscountMailEnabled']=='yes' && isset($reviewData['MessageDiscount'][$this->config->get('config_language_id')]) && isset($reviewData['SubjectDiscount'][$this->config->get('config_language_id')]) ) {
							$Email = $this->request->get['email'];
							
							$subject_discount_original = array('{first_name}','{last_name}', '{order_id}');
							$subject_discount_replace = array($this->request->get['fname'], $this->request->get['lname'],$this->request->get['order_id']);
							$Subject = str_replace($subject_discount_original, $subject_discount_replace, $reviewData['SubjectDiscount'][$this->config->get('config_language_id')]);
							
							//$Subject = $reviewData['SubjectDiscount'][$this->config->get('config_language_id')];
							$Message = html_entity_decode($reviewData['MessageDiscount'][$this->config->get('config_language_id')]);
							$patterns1 = array('{first_name}', '{last_name}', '{discount_code}', '{discount_value}', '{total_amount}', '{date_end}');
							$replacements1 = array($this->request->get['fname'], $this->request->get['lname'], $DiscountCode, $discount_value, $total_amount, date($reviewData['DateFormat'], $TimeEnd));
							$HTMLMail = str_replace($patterns1, $replacements1, $Message);
								
							$Mail = array(
								'email' =>  $Email,
								'message' => $HTMLMail, 
								'subject' => $Subject,
								'store_name' => $this->config->get('config_name')
							);
	
							$emailResult = $this->{$this->moduleModel}->sendMail($Mail);
						}
					}	
				} 
			}
		}
		
		if (isset($this->request->get['order_id']) && isset($this->request->get['reviewmail_id']) && isset($this->request->get['store_id'])) {
			$missing_data = false;
			$this->load->model('localisation/language');
			$this->load->model('module/'.$this->moduleName);
			$this->load->model('checkout/order');
			
			$order_id			= $this->request->get['order_id'];
			$order				= $this->model_checkout_order->getOrder($order_id);
			$store				= $this->{$this->moduleModel}->getStore($this->request->get['store_id']);
			$setting			= $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
			$moduleData			= isset($setting[$this->moduleName]) ? $setting[$this->moduleName] : array();
			$reviewmail_id 		= $this->request->get['reviewmail_id'];
			$reviewmail			= isset ($moduleData['ReviewMail'][$reviewmail_id]) ? $moduleData['ReviewMail'][$reviewmail_id] : array();			
			
			if (!empty($reviewmail)) {
				$OrderLanguage = $this->model_localisation_language->getLanguage($order['language_id']);
				$LangVars = $this->{$this->moduleModel}->loadLanguage($OrderLanguage['directory'].'/module','orderreviews');
				$OrderProducts = $this->{$this->moduleModel}->getOrderProducts($order['order_id']);
				$Products = '';
				$ProductIDs = '';
				if (sizeof($OrderProducts)==1) {
					$Products = '<a href="'.$store['url'].'index.php?route=product/product&amp;product_id=' . $OrderProducts[0]['product_id'].'">'.$OrderProducts[0]['name'].'</a>';
					$ProductIDs = $OrderProducts[0]['product_id'];
				} else {
					for ($i=0; $i<sizeof($OrderProducts); $i++) {
						if (($i+1) == sizeof($OrderProducts)) {
							$Products .= ' '.$LangVars['text_and'].' ';
						}  else if (($i+1) < sizeof($OrderProducts) && ($i>0)) {
							$Products .= ', ';	
						}
						$Products .= '<a href="'.$store['url'].'index.php?route=product/product&amp;product_id=' . $OrderProducts[$i]['product_id'].'">'.$OrderProducts[$i]['name'].'</a>';
						$ProductIDs .= $OrderProducts[$i]['product_id'];
						
						if (!(($i+1) == sizeof($OrderProducts)))
								$ProductIDs .= '_';
					}
				}
				
				$subject_original = array('{first_name}','{last_name}', '{order_id}');
				$subject_replace = array($order['firstname'], $order['lastname'], $order['order_id']);
				$Subject = str_replace($subject_original, $subject_replace, $reviewmail['Subject'][$order['language_id']]);
				$Message = html_entity_decode($reviewmail['Message'][$order['language_id']]);
				$FirstName = $order['firstname'];
				$LastName = $order['lastname'];
				$Email = $order['email'];
				$SubmitLink = $store['url'].'index.php?route=module/orderreviews/sendReview';

				$MainFormData = $this->{$this->moduleModel}->fetchForm('default/template/module/orderreviews_product_form_main.tpl');
				$ProductFormData = $this->{$this->moduleModel}->fetchForm('default/template/module/orderreviews_product_form_include.tpl');			
				$ProductsViews = "";
				
				if ($reviewmail['ReviewType'] == 'per_purchase') {
					$tempVar = '';
					$old = array("{number}","{pr_name}","{pr_id}","{image}");
					$new = array('0','','0',NULL);
					$tempVar = str_replace($old, $new, $ProductFormData);
					$ProductsViews .= $tempVar;
				} else if ($reviewmail['ReviewType'] == 'per_product') { 
					if (sizeof($OrderProducts)>0) {
						for ($i=0; $i<sizeof($OrderProducts); $i++) {
							$tempVar = '';
							if($reviewmail['DisplayImages'] == 'yes'){										
								$this->load->model('catalog/product');
								$product_info = $this->model_catalog_product->getProduct($OrderProducts[$i]['product_id']);
								$this->load->model('tool/image');
								if ($product_info['image']) { $image = $this->model_tool_image->resize($product_info['image'], 200, 200); } else { $image = false; }										
								$old = array("{number}","{pr_name}","{pr_id}","{image}");
								$new = array($OrderProducts[$i]['product_id'],$OrderProducts[$i]['name'].':',$OrderProducts[$i]['product_id'].'<br/>',"<img src='".$image."' />");
							} else {
								$old = array("{number}","{pr_name}","{pr_id}","{image}");
											$new = array($OrderProducts[$i]['product_id'],$OrderProducts[$i]['name'].':',$OrderProducts[$i]['product_id'].'<br/>',NULL);											
							}
							$tempVar = str_replace($old, $new, $ProductFormData);
							$ProductsViews .= $tempVar;
						}
					}
				}
				
				$form_pattern = array("{submit_link}","{first_name}", "{last_name}", "{customer_id}", "{text_submit}", "{text_review}", "{product_id}", "{order_id}", "{customer_name}", "{reviewmail_id}", "{email}","{product_info}");
				
				$form_replacements = array($SubmitLink, $FirstName, $LastName, $order['customer_id'], $LangVars['text_submit'], $LangVars['text_review'], $ProductIDs, $order['order_id'], $FirstName.' '.$LastName, $reviewmail['id'], $Email, $ProductsViews);
				
				$ReviewForm = str_replace($form_pattern, $form_replacements, $MainFormData);
				
				$patterns = array('{first_name}', '{last_name}', '{review_form}', '{order_products}', '{order_id}', '{reviewmail_link}');
				$replacements = array($FirstName, $LastName, $ReviewForm, $Products, $order['order_id'], '');
				$HTMLMail = str_replace($patterns, $replacements, $Message);
				
				$data['FormData'] = $HTMLMail;
			}
		} else if ($missing_data) {
			$data['FormData']	= '<div class="warning">'.$this->language->get('error_form').'</div>';
		}
		
		$data['breadcrumbs'] = array(); 

		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);
		$link =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$escaped_link = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
		$data['breadcrumbs'][] = array(
			'href'      => $escaped_link,
			'text'      => $this->language->get('heading_title'),
			'separator' => false
		);
		
		$data['heading_title'] 			= $this->language->get('heading_title');
		$data['button_continue'] 		= $this->language->get('button_continue');
		$data['continue'] 				= $this->url->link('common/home');

		$data['column_left'] 			= $this->load->controller('common/column_left');
		$data['column_right'] 			= $this->load->controller('common/column_right');
		$data['content_top'] 			= $this->load->controller('common/content_top');
		$data['content_bottom'] 		= $this->load->controller('common/content_bottom');
		$data['footer']					= $this->load->controller('common/footer');
		$data['header'] 				= $this->load->controller('common/header');
	
		// if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/orderreviews_success.tpl')) {
		// 	$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/orderreviews_success.tpl', $data));
		// } else {
		// 	$this->response->setOutput($this->load->view('default/template/module/orderreviews_success.tpl', $data));
		// }

		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/facebooklogin.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/orderreviews_success.tpl', $data));
			 } else {
				 $this->response->setOutput($this->load->view('default/template/module/orderreviews_success.tpl', $data));
			 }
		} else {
			  $this->response->setOutput($this->load->view('module/orderreviews_success.tpl', $data));
		}
}
}
?>