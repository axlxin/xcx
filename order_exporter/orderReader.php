<?php
/*************************************
* 将订单导出成Excel数据
* 
* 更新记录：
* 2016/09/10 在order_id前加上前缀SP，并补足8位数字
**************************************/

class orderReader{
    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;

        // Loader
        $loader = new Loader($this->registry);
        $this->registry->set('load', $loader);

        $this->load->model('sale/order');
    }

    public function __get($key) {
        return $this->registry->get($key);
    }

    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }
    
    public function generate_order_id($old){
        $prefix = "SP";
        return $prefix . str_pad($old, 8, "0", STR_PAD_LEFT);
    }


    // 按照SFC的格式筛选处理订单
    public function sortOrderFields($order_info, $order_products){
        $row = array();
        list($row[],) = explode(' ', $order_info['date_added']);
        $row[] = $order_info['customer'];
        $row[] = $order_info['shipping_country'];
        $row[] = $this->generate_order_id($order_info['order_id']);

        $rows = array();
        foreach($order_products as $product){
            $new_row = $row;
            $new_row[] = $product['name'];
            $new_row[] = $product['model'];
            $new_row[] = $product['quantity'];
            $new_row[] = $order_info['currency_code'];
            $new_row[] = number_format($product['total'],2,'.','');
            $rows[] = $new_row;
        }
       //print_r($rows);

        $totals = $this->model_sale_order->getOrderTotals($order_info['order_id']);
        foreach($totals as $each){
            if($each['code']=='shipping' || $each['code']=='total'){
                $new_row = $row;
                $new_row[] = $each['title'];
                $new_row[] = '---';
                $new_row[] = '---';
                $new_row[] = $order_info['currency_code'];
                $new_row[] = number_format($each['value'],2,'.','');
                $rows[] = $new_row;
            }
        }

        return $rows;
    }

    /**
     * 获取已处理的订单记录
     * @param int $start 开始位置索引， 从第$start+1条记录开始读取
     * @param int $limit 每次读取多少行记录
     * @param array $filter
     * @return type
     */
    public function getProcessedOrders($start=0, $limit=0, $filter){
        //$rows = array();
        $filter['start'] = $start;
        $limit && $filter['limit'] = $limit;

        $orders = $this->getOrdersWithProducts($filter);
        /*foreach($orders as &$order){
            $products = $this->model_sale_order->getOrderProducts($order['order_id']);
            $order['products'] = $products;
            $new_rows = $this->sortOrderFields($order, $products);
            $rows[] = $new_rows;
        }*/

        $rows = $this->sortOrderFields_2($orders);
        return $rows;
    }


    /**
     * 获取符合条件的所有订单
     * @param type $data
     * @return type
     */
    public function getOrders($data = array()) {
        $sql = "SELECT o.order_id, CONCAT(o.shipping_firstname, ' ', o.shipping_lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified, o.shipping_country FROM `" . DB_PREFIX . "order` o";

        $sql .= " WHERE DATE(o.date_added) >= DATE('" . $this->db->escape($data['date_start']) . "')";

        if(!empty($data['date_end'])){
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['date_end']) . "')";
        }

        $sql .= " ORDER BY o.order_id ASC";

        if (isset($data['start']) && isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    /**
     * 统计符合条件的订单总数
     * @param type $data
     * @return type
     */
    public function getTotalOrders($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

        $sql .= " WHERE DATE(date_added) >= DATE('" . $this->db->escape($data['date_start']) . "')";

        if(!empty($data['date_end'])){
            $sql .= " AND DATE(date_added) <= DATE('" . $this->db->escape($data['date_end']) . "')";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }


    /**
     * 获取符合条件的所有订单（含产品）
     * @param type $data
     * @return type
     */
    public function getOrdersWithProducts($data = array()) {
        $op_fields = 'op.name as product_name, op.model, op.quantity, op.price as product_price, op.total as product_total';

        $table_order = DB_PREFIX . 'order';
        $table_order_status = DB_PREFIX . 'order_status';
        $table_order_product = DB_PREFIX . 'order_product';
        $sql = <<<SQL
SELECT
    o.order_id,
    CONCAT(o.shipping_firstname, ' ', o.shipping_lastname) AS customer,
    (SELECT os.name FROM $table_order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status,
    o.shipping_code,
    o.total,
    o.currency_code,
    o.currency_value,
    o.date_added,
    o.date_modified,
    o.shipping_country,
    $op_fields,
    op.purchase_cost
FROM `$table_order` o
RIGHT JOIN `$table_order_product` op ON o.order_id=op.order_id
SQL;

        $sql .= " WHERE DATE(o.date_added) >= DATE('" . $this->db->escape($data['date_start']) . "')";

        if(!empty($data['date_end'])){
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['date_end']) . "')";
        }

        $sql .= " AND o.order_status_id<>0 ";

        $sql .= " ORDER BY o.order_id ASC";

        if (isset($data['start']) && isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    // 按照SFC的格式筛选处理订单
    public function sortOrderFields_2($orders){

        $rows = array();
        foreach($orders as $order){
            $row = array();
            list($date,) = explode(' ', $order['date_added']);
            $row[] = str_replace('-', '/', $date);
            $row[] = $order['customer'];
            $row[] = $order['shipping_country'];
            $row[] = $this->generate_order_id($order['order_id']);
            $row[] = $order['product_name'];
            $row[] = $order['model'];
            $row[] = $order['quantity'];
            $row[] = $order['currency_code'];
            $row[] = number_format($order['product_total'],2,'.','');

             //  新增 J列（Purchase Cost）
            $purchase_cost = (int) $order['purchase_cost'];
            $row[] = sprintf("%1\$.2f", $purchase_cost);
            $rows[$order['order_id']][] = $row;
        }

        foreach($rows as $order_id => $row){
            //在每一张订单末尾加上order_total的数据
            $totals = $this->model_sale_order->getOrderTotals($order_id);
            foreach($totals as $each){
                $new_row = array();
                if($each['code']=='shipping' || $each['code']=='total'){
                    $new_row[] = $row[0][0];
                    $new_row[] = $row[0][1];
                    $new_row[] = $row[0][2];
                    $new_row[] = $this->generate_order_id($order_id);
                    $new_row[] = $each['title'];
                    $new_row[] = '---';
                    $new_row[] = '---';
                    $new_row[] = $row[0][7];
                    $new_row[] = number_format($each['value'],2,'.','');
                    $new_row[] = '---'; //  新增 J列（Purchase Cost）
                    $rows[$order_id][] = $new_row;
                }
            }
        }

        return $rows;
    }
}



?>
