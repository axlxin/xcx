<?php
class ModelCatalogKPOptionCalculate extends Model {	
	public function editProductCalculate($product_id, $data) {
             $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_calculate WHERE product_id = '" . (int)$product_id . "'");
             $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_calculate SET product_id = '" . (int)$product_id . "', code='" . $data . "'");
	}
        
        public function getProductCalculateCode($product_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "product_option_calculate WHERE product_id='" . (int)$product_id . "'");
		$info = $query->row;
                $code = '';
                if (is_array($info) && count($info)>0 )
                {
                    $code = html_entity_decode($info['code'], ENT_COMPAT);
                }
		return $code;
	}
}
?>