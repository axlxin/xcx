<?php

class ModelToolExportCustomers extends Model {

	public function getData($data) {

		$tables = $data['tables'];

		$fieldsToExport = $this->getFields($tables);

		$query = "SELECT " . $fieldsToExport;

		if (in_array('order_products', $tables)) {
			$query .= " FROM `" . DB_PREFIX . "order_product` op";
			if (in_array('orders', $tables) || in_array('customers', $tables)) {
				$query .= " LEFT JOIN `" . DB_PREFIX . "order` o ON o.order_id = op.order_id";
				$query .= " LEFT JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id";
			}
		} elseif (in_array('orders', $tables)) {
			$query .= " FROM `" . DB_PREFIX . "order` o";
			$query .= " LEFT JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id";
		} else {
			$query .= " FROM `" . DB_PREFIX . "customer` c";
		}

		if (in_array('orders', $tables) || in_array('customers', $tables)) {

			$query .= " LEFT JOIN `" . DB_PREFIX . "customer_group` cg ON cg.customer_group_id = c.customer_group_id";

			if (version_compare(VERSION, "1.5.3", '>=')) {
				$query .= "	LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON cgd.customer_group_id = c.customer_group_id AND cgd.language_id = " . (int) $this->config->get('config_language_id');
			}
		}

		if (in_array('customers', $tables)) {
			$query .= " LEFT JOIN `" . DB_PREFIX . "store` s ON s.store_id = c.store_id";
			$query .= " LEFT JOIN `" . DB_PREFIX . "address` a ON a.address_id = c.address_id";
			$query .= " LEFT JOIN `" . DB_PREFIX . "zone` z ON z.zone_id = a.zone_id";
			$query .= " LEFT JOIN `" . DB_PREFIX . "country` co ON co.country_id = a.country_id";
		}

		if (in_array('orders', $tables)) {
			$query .= " LEFT JOIN `" . DB_PREFIX . "country` sco ON sco.country_id = o.shipping_country_id";
		}

		$query .= " WHERE 1";

		if (in_array('customers', $tables)) {
			if ($data['join_date_start']) {
				$query .= " AND c.date_added >= '" . date('Y-m-d', $data['join_date_start']) . " 00:00:00'";
			}

			if ($data['join_date_end']) {
				$query .= " AND c.date_added <= '" . date('Y-m-d', $data['join_date_end']) . " 23:59:59'";
			}
			
			if (is_numeric($data['newsletter']))  {
				$query .= " AND c.newsletter = ".$data['newsletter'];
			}
			
		}

		if (in_array('orders', $tables)) {
			if ($data['order_start_date']) {
				$query .= " AND o.date_added >= '" . date('Y-m-d', $data['order_start_date']) . " 00:00:00'";
			}

			if ($data['order_date_end']) {
				$query .= " AND o.date_added <= '" . date('Y-m-d', $data['order_date_end']) . " 23:59:59'";
			}

			if ($data['order_id_start']) {
				$query .= " AND o.order_id >= '" . (int) $data['order_id_start'] . "'";
			}

			if ($data['order_id_end']) {
				$query .= " AND o.order_id <= '" . (int) $data['order_id_end'] . "'";
			}

			if ($data['order_status_id'] && $data['order_status_id'] != 'all') {
				$query .= " AND o.order_status_id = '" . (int) $data['order_status_id'] . "'";
			}
			
			if (isset($data['order_status_id']) && $data['order_status_id'] != 'all') {
				$query .= " AND o.order_status_id = '" . (int) $data['order_status_id'] . "'";
			}
			
			if (isset($data['order_status_id']) && $data['order_status_id'] == 'all') {
				$query .= " AND o.order_status_id > 0";
			}
			
		}


		$result = $this->db->query($query);

		return $result->num_rows ? $result->rows : array();
	}

	public function getFields($tables) {
		$fields = array();

		if (in_array('customers', $tables)) {
			$fields = array_merge($fields, array(
				'customer_id' => 'c.customer_id',
				'firstname' => 'c.firstname',
				'lastname' => 'c.firstname',
				'fullname' => "CONCAT(c.firstname, ' ', c.lastname)",
				'email' => 'c.email',
				'telephone' => 'c.telephone',
				'fax' => 'c.fax',
				'company' => 'a.company',
				'address_1' => 'a.address_1',
				'address_2' => 'a.address_2',
				'city' => 'a.city',
				'county' => 'z.name',
				'postcode' => 'a.postcode',
				'country' => 'co.name',
				'country_iso' => 'co.iso_code_2',
				'store_name' => "IFNULL(s.name , '" . $this->db->escape($this->config->get('config_name')) . "')",
				'newsletter' => 'c.newsletter',
				'status' => 'c.status',
				'approved' => 'c.approved',
				'customer_group' => (version_compare(VERSION, "1.5.3", '>=') ? 'cgd.name' : 'cg.name')
			));
		}
		if (in_array('orders', $tables)) {
			$fields = array_merge($fields, array(
				'order_id' => 'o.order_id',
				'invoice_no' => 'o.invoice_no',
				'invoice_prefix' => 'o.invoice_prefix',
				'store_id' => 'o.store_id',
				'store_name' => 'o.store_name',
				'store_url' => 'o.store_url',
				'customer_id' => 'o.customer_id',
				'customer_group' => (version_compare(VERSION, "1.5.3", '>=') ? 'cgd.name' : 'cg.name'),
				'firstname' => 'o.firstname',
				'lastname' => 'o.lastname',
				'email' => 'o.email',
				'telephone' => 'o.telephone',
				'fax' => 'o.fax',
				'payment_firstname' => 'o.payment_firstname',
				'payment_lastname' => 'o.payment_lastname',
				'payment_company' => 'o.payment_company',
				//'payment_company_id' => 'o.payment_company_id', 
				//'payment_tax_id' => 'o.payment_tax_id',
				'payment_address_1' => 'o.payment_address_1',
				'payment_address_2' => 'o.payment_address_2',
				'payment_city' => 'o.payment_city',
				'payment_postcode' => 'o.payment_postcode',
				'payment_country' => 'o.payment_country',
				'payment_country_id' => 'o.payment_country_id',
				'payment_zone' => 'o.payment_zone',
				'payment_zone_id' => 'o.payment_zone_id',
				'payment_address_format' => 'o.payment_address_format',
				'payment_method' => 'o.payment_method',
				'payment_code' => 'o.payment_code',
				'shipping_firstname' => 'o.shipping_firstname',
				'shipping_lastname' => 'o.shipping_lastname',
				'shipping_company' => 'o.shipping_company',
				'shipping_address_1' => 'o.shipping_address_1',
				'shipping_address_2' => 'o.shipping_address_2',
				'shipping_city' => 'o.shipping_city',
				'shipping_postcode' => 'o.shipping_postcode',
				'shipping_country' => 'o.shipping_country',
				'shipping_country_id' => 'o.shipping_country_id',
				'shipping_country_iso' => 'sco.iso_code_2',
				'shipping_zone' => 'o.shipping_zone',
				'shipping_zone_id' => 'o.shipping_zone_id',
				'shipping_address_format' => 'o.shipping_address_format',
				'shipping_method' => 'o.shipping_method',
				'shipping_code' => 'o.shipping_code',
				'comment' => 'o.comment',
				'total' => 'o.total',
				'order_status_id' => 'o.order_status_id',
				'affiliate_id' => 'o.affiliate_id',
				'commission' => 'o.commission',
				'language_id' => 'o.language_id',
				'currency_id' => 'o.currency_id',
				'currency_code' => 'o.currency_code',
				'currency_value' => 'o.currency_value',
				'ip' => 'o.ip',
				'forwarded_ip' => 'o.forwarded_ip',
				'user_agent' => 'o.user_agent',
				'accept_language' => 'o.accept_language',
				'date_added' => 'o.date_added',
				'date_modified' => 'o.date_modified'
			));
		}

		if (in_array('order_products', $tables)) {
			$fields = array_merge($fields, array(
				'order_product_id' => 'op.order_product_id',
				'order_id' => 'op.order_id',
				'product_id' => 'op.product_id',
				'name' => 'op.name',
				'model' => 'op.model',
				'quantity' => 'op.quantity',
				'price' => 'op.price',
				'total' => 'op.total',
				'tax' => 'op.tax',
				'reward' => 'op.reward'
			));
		}

		$aliasedFields = array();
		foreach ($fields as $alias => $fieldName) {
			$aliasedFields[] = $fieldName . " AS " . $alias;
		}
		return join(', ', $aliasedFields);
	}

}
