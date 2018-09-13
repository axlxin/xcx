<?php

class ModelSalePcbAssemblingInquiry extends Model {

    public function getTotalInquiries($data) {
        $sql = "SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "pcb_assembling_inquiry` WHERE 1 = 1";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getInquiries($data) {
        $sql = "SELECT pai.*, CONCAT(c.`firstname`, ' ', c.`lastname`) AS `customer` FROM `" . DB_PREFIX . "pcb_assembling_inquiry` pai LEFT JOIN `" . DB_PREFIX . "customer` c ON pai.customer_id = c.customer_id WHERE 1 = 1 ";

        $sort_data = array(
            'pai.id',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY pai.id";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $results = $this->db->query($sql)->rows;

        return $results;
    }

    public function getInquiry($id) {
        $inquiry = array();

        $query = $this->db->query("SELECT pai.*, CONCAT(c.`firstname`, ' ', c.`lastname`) AS `customer` FROM " . DB_PREFIX . "pcb_assembling_inquiry pai LEFT JOIN `" . DB_PREFIX . "customer` c ON pai.customer_id = c.customer_id WHERE id = " . (int)$id);

        if ($query->num_rows) {
            $inquiry = $query->row;
        }

        return $inquiry;
    }

}
