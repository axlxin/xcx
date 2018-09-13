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
            //var_dump($order_info);var_dump($products);
            $selectedOrders[$order_id] = $this->sortOrderFields($order_info, $products);
        }
        return $selectedOrders;
    }
    
    // 按照DHL的格式筛选处理订单
    public function sortOrderFields($order_info, $order_products){
        $data = array();
        $data[] = 'SP'. str_pad($order_info['order_id'], 8, '0', STR_PAD_LEFT);;
        $data[] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']; //Recipient Full Name
        
        
        if(empty($order_info['shipping_address_2'])){
            $address = $order_info['shipping_address_1'];
        }else{
            $address = "address1:".$order_info['shipping_address_1'].";address2:".$order_info['shipping_address_2'];
        }
        $data[] = $address; //Recipient Address Line 1
        $data[] = $order_info['shipping_city']; //Recipient City
        $data[] = $order_info['shipping_zone']; //Recipient State
        $data[] = $order_info['shipping_country']; //Recipient Country Code
        $data[] = $order_info['shipping_postcode']; //Recipient Zip Code
        $data[] = $order_info['telephone']; //Recipient Tel
        
        foreach($order_products as $product){
            $productName[] = $product['name'];
        }
        $productList = implode(',', $productName);
        $data[] = substr($productList, 0, 140); //Description EN
        
        $totals = $this->model_sale_order->getOrderTotals($order_info['order_id']);
        $sub_total = '0.00';
        //var_dump($totals);
        foreach($totals as $each){
            if('Total'==$each['title']){
                $total = $each['value'];
            }
        }
        $total = preg_replace("/[^0-9.,]+/","",$total);
        //$sub_total_new = (floatval($sub_total) > 45) ? '45.00' :  $sub_total;
        $data[] = $total; //Commodity Unit Value
        $data[] = '1'; //Quantity of Package
        $data[] = empty($order_info['shipping_company']) ? $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'] : $order_info['shipping_company'];

        
        return $data;
    }
}



?>
