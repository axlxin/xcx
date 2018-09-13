<?php
class ModelCatalogRewards extends Model {

	
	public function generateRewards($data) {
		 
		$this->db->query("UPDATE " . DB_PREFIX . "product SET points = round(price * 100 / ".(int)$data['rewards_points'].")");//'" . $this->db->escape($data['author']) . "', product_id = '" . $this->db->escape($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE review_id = '" . (int)$review_id . "'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET points = round(price * 100 / ".(int)$data['rewards_points'].")");//'" . $this->db->escape($data['author']) . "', product_id = '" . $this->db->escape($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE review_id = '" . (int)$review_id . "'");
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward");
		
		if (isset($data['rewards_product_reward'])) {
			foreach ($data['rewards_product_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward (product_id, customer_group_id, points) SELECT product_id , '" . (int)$customer_group_id . "', round(price * " . (int)$value['points'] . " / 100) from " . DB_PREFIX . "product");
			}
		}
		
	}
	
	
}
?>