<?php
class ModelModuleOrderReviews extends Model {
	public function sendMail($data = array()) {
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
		$mailToUser->setTo($data['email']);
		$mailToUser->setFrom($this->config->get('config_email'));
		$mailToUser->setSender($data['store_name']);
		$mailToUser->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
		$mailToUser->setHtml($data['message']);
		
		$moduleSettings = $this->model_setting_setting->getSetting('orderreviews', $this->config->get('store_id'));
		if(isset($moduleSettings['orderreviews']['BCC']) && $moduleSettings['orderreviews']['BCC'] == 'yes') { 
			$mailToUser->setOrderReviewsBcc($this->config->get('config_email'));
		}
		
		$mailToUser->send(); 

		if ($mailToUser) 
			return true;
		else
			return false;
	}
	
	public function getOrders($orderID, $dayLimit, $dateType = 'date_modified') {	
		$query =  $this->db->query("SELECT * FROM `" . DB_PREFIX . "order`
			WHERE `order_status_id`=".$orderID." AND DATE(`". $dateType ."`) = '".date("Y-m-d ",strtotime('-'.$dayLimit.' days'))."'");

		return $query->rows; 
	}
	
	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT DISTINCTROW product_id, name, order_id FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "' ORDER BY product_id");
		return $query->rows;
	}
	
	
	public function loadLanguage($directory, $filename) {
		$default = 'english/module';
		$data = array();
		
		$file = DIR_LANGUAGE . $directory . '/' . $filename . '.php';
		if (file_exists($file)) {
			$_ = array();

			require($file);
			 $data = array_merge($data, $_);
			return $data;
		}
		
		$file = DIR_LANGUAGE . $default . '/' . $filename . '.php';
		if (file_exists($file)) {
			$_ = array();
			require($file);
			$data = array_merge($data, $_);
			return $data;
		} else {
			trigger_error('Error: Could not load language ' . $filename . '!');
		//	exit();
		}
	}
	
	// Coupons
	public function generateuniquerandomcouponcode() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$couponCode = '';
		for ($i = 0; $i < 10; $i++) {	
			$couponCode .= $characters[rand(0, strlen($characters) - 1)]; 
		}
		if($this->isUniqueCode($couponCode)) {	
			return $couponCode;
		} else {	
			return $this->generateuniquerandomcouponcode();
		}
	}
	
	public function isUniqueCode($randomCode) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE code='".$this->db->escape($randomCode)."'");
				if($query->num_rows == 0) {
					return true;
							} else {
					return false;
				}	
	}
	
	public function addCoupon($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', discount = '" . (float)$data['discount'] . "', type = '" . $this->db->escape($data['type']) . "', total = '" . (float)$data['total'] . "', logged = '" . (int)$data['logged'] . "', shipping = '" . (int)$data['shipping'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', uses_total = '" . (int)$data['uses_total'] . "', uses_customer = '" . (int)$data['uses_customer'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$coupon_id = $this->db->getLastId();

		if (isset($data['coupon_product'])) {
			foreach ($data['coupon_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_product SET coupon_id = '" . (int)$coupon_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['coupon_category'])) {
			foreach ($data['coupon_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_category SET coupon_id = '" . (int)$coupon_id . "', category_id = '" . (int)$category_id . "'");
			}
		}		
	}
		
	private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTP_SERVER;
        } else {
            $storeURL = HTTPS_SERVER;
        } 
        return $storeURL;
    }
	
	public function getStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->getStoreData($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL();
        }
        return $store;
    }
	
	private function getStoreData($store_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");

		return $query->row;
	}
	
	public function fetchForm($filename) {
		$data = array();
		$file = DIR_APPLICATION.'view/theme/'. $filename;

		if (file_exists($file)) {
			extract($data);
			ob_start();
			include($file);
			$content = ob_get_clean();
			return $content;
		} else {
			trigger_error('Error: Could not load template ' . $file . '!');
			exit();				
		}
	}

	private $moduleName = 'orderreviews';
	private $moduleModel = 'model_module_orderreviews';
	

public function addUrlEncryptRecord($order_id, $reviewmail_id, $store_id) {
    $sha1 = sha1($order_id.$reviewmail_id.$store_id.time());
    $this->db->query("INSERT INTO " . DB_PREFIX . "orderreviews_url_encrypt SET order_id = '" . (int)$order_id . "', reviewmail_id = '" . (int)$reviewmail_id . "', store_id = '" . (int)$store_id . "', sha1 = '" . $this->db->escape($sha1) . "'");
    return $sha1;
}
public function getParamsByEncryptCode($code){
    $record = $this->db->query("SELECT * FROM " . DB_PREFIX . "orderreviews_url_encrypt WHERE `sha1` = '" . $this->db->escape($code) . "' LIMIT 1");
    return $record->row;
}

	public function sendReviewMail($order_id, $order_status_id) {
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		$this->load->model('checkout/order');
		$this->load->model('localisation/language');
        $this->load->model('module/'.$this->moduleName);
		
	
		
		
		$stores = array_merge(array(0 => $this->getStore(0)), $this->model_setting_store->getStores());
		foreach ($stores as $store) {
			$setting = $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
			$moduleData = isset($setting[$this->moduleName]) ? $setting[$this->moduleName] : array();
			if (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes' && isset($moduleData['ReviewMail'])) {
				foreach ($moduleData['ReviewMail'] as $reviewmail) {
					if ($reviewmail['Enabled']=='yes' && $reviewmail['Delay']=='0' && $reviewmail['OrderStatusID']==$order_status_id) {
						
						$order = $this->model_checkout_order->getOrder($order_id);
						if (!(($reviewmail['CustomerGroupID'] == 'send_all') || ($reviewmail['CustomerGroupID'] != 'send_all' && $reviewmail['CustomerGroupID']==$order['customer_group_id']))) {
							break;	
						}	
					
						
						
						
						$OrderLanguage = $this->model_localisation_language->getLanguage($order['language_id']);
						$LangVars = $this->loadLanguage($OrderLanguage['directory'].'/module','orderreviews');
						$OrderProducts = $this->getOrderProducts($order['order_id']);
						
						
$currentProducts = $OrderProducts;
$Products = ''; //修复$currentProducts大于0时，此变量未声明的bug

						
						if(!empty($currentProducts)) {
							$ProductIDs = '';
							if (sizeof($currentProducts)==1) {
								$Products = '<a href="'.$store['url'].'index.php?route=product/product&amp;product_id=' . $currentProducts[0]['product_id'].'">'.$currentProducts[0]['name'].'</a>';
								
								$ProductIDs = $currentProducts[0]['product_id'];
							} else {
								for ($i=0; $i<sizeof($currentProducts); $i++) {
									if (($i+1) == sizeof($currentProducts)) {
										$Products .= ' '.$LangVars['text_and'].' ';
									}  else if (($i+1) < sizeof($currentProducts) && ($i>0)) {
										$Products .= ', ';	
									}
									$Products .= '<a href="'.$store['url'].'index.php?route=product/product&amp;product_id=' . $currentProducts[$i]['product_id'].'">'.$currentProducts[$i]['name'].'</a>';
									$ProductIDs .= $currentProducts[$i]['product_id'];
									
									if (!(($i+1) == sizeof($currentProducts)))
											$ProductIDs .= '_';
								}
							}
							
							
							
							
							$subject_original = array('{first_name}','{last_name}', '{order_id}');
							$subject_replace = array($order['firstname'], $order['lastname'], $order_id);
							$Subject = str_replace($subject_original, $subject_replace, $reviewmail['Subject'][$order['language_id']]);
							$Message = html_entity_decode($reviewmail['Message'][$order['language_id']]);
							$FirstName = $order['firstname'];
							$LastName = $order['lastname'];
							$Email = $order['email'];
							$SubmitLink = $store['url'].'index.php?route=module/orderreviews/sendReview';
							
$encrypt = $this->addUrlEncryptRecord($order['order_id'], $reviewmail['id'], $store['store_id']);
$ReveiewMailLink = $store['url'].'index.php?route=module/orderreviews/sendReview&encrypt='.$encrypt;

							
							//$MainFormData = $this->fetchForm('default/template/module/orderreviews_review_email_form.tpl');
							$ProductFormData = $this->fetchForm('default/template/module/orderreviews_product_form_include.tpl');			
							$ProductsViews = "";
							
							
							if ($reviewmail['ReviewType'] == 'per_purchase') {
								$tempVar = '';
								$old = array("{number}","{pr_name}","{pr_id}","{image}");
								$new = array('0','','0',NULL);
								$tempVar = str_replace($old, $new, $ProductFormData);
								$ProductsViews .= $tempVar;
							} else if ($reviewmail['ReviewType'] == 'per_product') { 
								if (sizeof($currentProducts)>0) {								
										for ($i=0; $i<sizeof($currentProducts); $i++) {
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
							
							/*$form_pattern = array("{submit_link}","{first_name}", "{last_name}", "{customer_id}", "{text_submit}", "{text_review}", "{product_id}", "{order_id}", "{customer_name}", "{reviewmail_id}", "{email}","{product_info}");
							$form_replacements = array($SubmitLink, $FirstName, $LastName, $order['customer_id'], $LangVars['text_submit'], $LangVars['text_review'], $ProductIDs, $order['order_id'], $FirstName.' '.$LastName, $reviewmail['id'], $Email, $ProductsViews);*/
							
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
									<title>OrderReviews</title>
								</head>
								<body>'.$HTMLMail.'</body></html>';
	
							$MailData = array(
								'email' =>  $Email,
								'message' => $newMail, 
								'subject' => $Subject,
								'store_name' => $store['name'],
								'store_id' => $store['store_id']);
						
							$emailResult = $this->sendMail($MailData);
						}
					}
				}
			}
		}
	
	}
	
	public function addReviewLog($order_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "orderreviews_log 
				SET order_id = '" . $this->db->escape($order_id) . "', 
				date_created = NOW()
		");
	}
	
	
	public function checkReviewLog($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "orderreviews_log` WHERE order_id='".$this->db->escape($order_id)."'");
			if($query->num_rows > 0) {
				return true;
						} else {
				return false;
			}
	}
	//
}
?>