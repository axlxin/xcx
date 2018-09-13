<?php 
class ModelModuleOrderReviews extends Model {	
  	public function install() {
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "orderreviews_log`
		(`log_id` INT(11) NOT NULL AUTO_INCREMENT, 
		 `order_id` INT(11) NOT NULL DEFAULT 0,
		 `date_created` DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`log_id`));");
		
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=1 WHERE `name` LIKE'%OrderReviews by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
  	} 
  
  	public function uninstall() {
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=0 WHERE `name` LIKE'%OrderReviews by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
  	}
	
	public function checkForTable() {
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "orderreviews_log`
		(`log_id` INT(11) NOT NULL AUTO_INCREMENT, 
		 `order_id` INT(11) NOT NULL DEFAULT 0,
		 `date_created` DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`log_id`));");
	}
	
  }
?>