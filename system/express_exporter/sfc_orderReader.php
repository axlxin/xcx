<?php
class orderReader{
    protected $registry;
    
    public function __construct($registry) {
        $this->registry = $registry;

        // Loader
        $loader = new Loader($this->registry);
        $this->registry->set('load', $loader);

        // Database
        $db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $this->registry->set('db', $db);
        
        $this->load->model('sale/order');
    }
    
    public function __get($key) {
        return $this->registry->get($key);
    }

    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }
    
    public function getSelectedOrders($selected){
        $selectedOrders = array();
        
        $orders = $selected;
        foreach ($orders as $order_id) {
            $order_info = $this->model_sale_order->getOrder($order_id);
            $products = $this->model_sale_order->getOrderProducts($order_id);
            var_dump($order_info);var_dump($products);
            $selectedOrders[$order_id] = $this->sortOrderFields($order_info, $products);
        }
        return $selectedOrders;
    }
    
    // 按照SFC的格式筛选处理订单
    public function sortOrderFields($order_info, $order_products){
        $data = array();
        $data[] = 'SP'. str_pad($order_info['order_id'], 8, '0', STR_PAD_LEFT);
        $data[] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];
        $data[] = $order_info['shipping_address_1'];
        $data[] = $order_info['shipping_city'];
        $data[] = $order_info['shipping_zone'];
        $data[] = $order_info['shipping_country'];
        $data[] = $order_info['shipping_postcode'];
        $data[] = $order_info['telephone'];
        
        foreach($order_products as $product){
            $productName[] = $product['name'];
        }
        $productList = implode(',', $productName);
        $data[] = substr($productList, 0, 140);
        
        $totals = $this->model_sale_order->getOrderTotals($order_info['order_id']);
        $sub_total = '0.00';
        //var_dump($totals);
        foreach($totals as $each){
            if('Sub-Total'==$each['title']){
                $sub_total = $each['value'];
            }
        }
        $sub_total = preg_replace("/[^0-9.,]+/","",$sub_total);
        $sub_total_new = (floatval($sub_total) > 45) ? '45.00' :  $sub_total;
        $data[] = $sub_total_new; //Commodity Unit Value
        $data[] = '1'; //Quantity of Package
        $data[] = $order_info['shipping_method'];
        

        $data[] = $sub_total_new; //Evaluate
        $data[] = ''; //Item Number
        $data[] = ''; //Transaction ID
        $data[] = ''; //Package Number
        $data[] = ''; //Number of Box
        $data[] = $order_info['shipping_company'];
        $data[] = $order_info['shipping_address_2'];
        $data[] = ''; //Description CN
        $data[] = ''; //Harmonized Code
        $data[] = ''; //Country of Manufacture
        $data[] = ''; //Mark
        $data[] = 'N';
        $data[] = 'N';
        $data[] = ''; //with_battery
        $data[] = ''; //weight
        $data[] = ''; //Length
        $data[] = ''; //Width
        $data[] = ''; //Height
        $data[] = ''; //Tax Number
        $data[] = ''; //shipping worth
        $data[] = ''; //Doorplate
        
        return $data;
    }
}



?>
