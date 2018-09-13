<?php

class ModelCatalogPcbAssembly extends Model {

    public function addInquiry($data) {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "pcb_assembling_inquiry` SET formData = '" . $this->db->escape($data['formData']) . "', comment = '" . $this->db->escape($data['comment']) . "', date_added = '" . $this->db->escape($data['date_added']) . "', email = '" . $this->db->escape($data['email']) . "', estimated_cost = '" . $this->db->escape($data['estimated_cost']) . "', customer_id = '" . (int)$data['customer_id'] . "'");

        $id = $this->db->getLastId();

        return $id;
    }

}
