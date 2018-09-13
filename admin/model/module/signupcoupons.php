<?php 
class ModelModuleSignUpCoupons extends Model {
	
	public function addCouponCodeToMessage($data = array()) {	
		if($data['SignUpCoupons']['Enabled'] == 'yes') {
			if(strpos($data['message'], '{discount_code}')) {
				$coupon_code = $this->generateCouponCode();
				$timeEnd =  time() + $data['SignUpCoupons']['days_after'] * 24 * 60 * 60;	
				$couponInfo  = array('name' => 'SignUpCoupon[' . $data['customer_email'].']',
					'code' => $coupon_code, 
					'discount' => $data['SignUpCoupons']['discount'],
					'type' => $data['SignUpCoupons']['discount_type'],
					'total' => $data['SignUpCoupons']['total_amount'],
					'logged' => '1',
					'shipping' => '0',
					'date_start' => date('Y-m-d', time()),
					'date_end' => date('Y-m-d', $timeEnd),
					'uses_total' => '1',
					'uses_customer' => '1',
					'status' => '1',
					'coupon_category' => $data['SignUpCoupons']['coupon_category'],
					'coupon_product' => $data['SignUpCoupons']['coupon_product']);				
				$coupon_id = $this->addCoupon($couponInfo);
			}
			
			if(isset($coupon_code) && isset($coupon_id)){
				$product_list = $this->getProductList($coupon_id);
				$category_list = $this->getCategoryList($coupon_id);
				$date_end =  date('Y-m-d', $timeEnd);
			} else {
				$product_list = '';
				$category_list = '';
				$coupon_code='';
			}
			
			$wordTemplates = array(
				"{firstname}", 
				"{lastname}", 
				"{discount_code}", 
				"{discount_value}", 
				"{total_amount}", 
				"{date_end}", 
				'{product_list}', 
				'{category_list}');

			$words = array(
				$data['firstname'], 
				$data['lastname'], 
				$coupon_code,  
				$data['SignUpCoupons']['discount'], 
				$data['SignUpCoupons']['total_amount'],  
				$date_end,
				$product_list,
				$category_list	
			);					
			$message = str_replace($wordTemplates, $words, $data['message']); 
			return $message;
		}
	}	

	private function generateCouponCode() {
		$usedCodes = $this->db->query('SELECT code FROM ' . DB_PREFIX . 'coupon')->rows;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$couponCode = '';	
		for ($i = 0; $i < 10; $i++) {
			$couponCode .= $characters[rand(0, strlen($characters) - 1)]; 
		}			
		if(!in_array($couponCode,$usedCodes)) {	
			return $couponCode;
		}
		else {	
			return generateUniqueRandomVoucherCode($usedCodes);
		}
	}
	
	private function addCoupon($data) {	
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
		return $coupon_id;		
	}
	
	private function getCategoryList($coupon_id) {
		$sql = "SELECT * FROM " . DB_PREFIX. "coupon_category AS cc JOIN " . DB_PREFIX .  "category_description as cd ON cc.category_id=cd.category_id WHERE cc.coupon_id=" . (int)$coupon_id . " AND cd.language_id=".$this->config->get('config_language_id');
		$categories = $this->db->query($sql)->rows;
		$category_list='';
		$count = count($categories);
		foreach ($categories as  $category) {
			$category_list .= $category['name'];
			if(--$count) $category_list .= ', ';
		}
		return $category_list;
	} 

	private function getProductList($coupon_id) {
		$sql = "SELECT * FROM " . DB_PREFIX. "coupon_product AS cp JOIN " . DB_PREFIX .  "product_description as pd ON cp.product_id=pd.product_id WHERE cp.coupon_id=" . (int)$coupon_id . " AND pd.language_id=".$this->config->get('config_language_id');
		$products = $this->db->query($sql)->rows;
		$product_list='';
		$count  =  count($products);
		foreach ($products as  $product) {
			$product_list .= $product['name'];
			if(--$count) $product_list .= ', ';
		}
		return $product_list;
	}
	
}
?>