<?php

function exit_error($msg){
    header("Content-type: text/html; charset=utf-8");
    exit($msg);
}

function checkToken($token){
    $seed = 'hhs823(^3Y';
    $date = date('ymdh');
    $md5 = md5($date . $seed);
    if($token!=$md5){
        exit_error('验证码不正确，请刷新页面重试。');
    }
}

if ( version_compare ( PHP_VERSION ,  '5.2.0' ) <  0 ) {
    exit_error('PHP版本过低');
}

if(!extension_loaded("xml")){
    exit_error('依赖库php_xml未加载');
}

if(!isset($_POST["date_start"]) || empty($_POST["date_start"]) ){
    exit_error('打开姿势不正确！');
}

if(!isset($_POST["export_token"]) || empty($_POST["export_token"]) ){
    exit_error('打开姿势不正确！');
}

checkToken($_POST["export_token"]);


// Configuration
require_once('../admin/config.php');
require_once(DIR_SYSTEM . 'startup.php');
require_once('orderReader.php');

// Include PHPExcel
require_once DIR_SYSTEM . 'library/PHPExcel.php';
include DIR_SYSTEM . 'library/PHPExcel/IOFactory.php';

// Registy
$registry = new Registry();


// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

//设定缓存模式为经gzip压缩后存入cache（还有多种方式请百度）
$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Kevin Pan")
    ->setLastModifiedBy("Kevin Pan")
    ->setTitle("The Exported Opencart orders")
    ->setSubject("custom data format")
    ->setDescription("This document created by KP_orderExporter.")
    ->setKeywords("Opencart orders")
    ->setCategory("Opencart orders");

// 设置激活中的Sheet
$objPHPExcel->setActiveSheetIndex(0);

// 字段表
$field_names = array(
    'Date',
    'Name',
    'Order Country',
    'Order ID',
    'Product Name',
    'Product Model',
    'Product Quantity',
    'Currency',
    'Product Value', //单项产品的订单金额
    'Purchase Cost'
);
$letter_range = range('A', 'Z');

$objActSheet = $objPHPExcel->getActiveSheet();
foreach($field_names as $i =>$value ){
    $key = $letter_range[$i];
    //var_dump($key);
    $objActSheet->setCellValue($key.'1', $value);
    $objActSheet->getColumnDimension($key)->setAutoSize(true); //设置单元格宽度自适应PHP
    $objActSheet->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH); //设置A列数据类型为日期
    $objActSheet->getStyle('I')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00); //设置I列数据类型为0.00的数字
    $objActSheet->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00); //新增 J列（Purchase Cost），数值格式化：保留两位小数
}

// 读取orders的信息
$filter = array('date_start'=>$_POST["date_start"], 'date_end'=>$_POST["date_end"]);
$orderReader = new orderReader($registry);

$total_orders = $orderReader->getTotalOrders($filter); // 订单的总数量
$limit = 100; // 每次读取100条记录
$start = 0;
$start_row_num = 2;
for($i=0;$i<($total_orders/$limit);$i++){
    $orders = $orderReader->getProcessedOrders($start, $limit, $filter);

    foreach($orders as $order_rows){
        foreach($order_rows as $row){
            $objActSheet->fromArray($row, '', 'A'.$start_row_num);
            $start_row_num++;
        }

        // 每个订单空一行
        //$objActSheet->fromArray(array(), '', 'A'.++$start_row_num);
    }
    $start += $limit;
}

// Redirect output to a client’s web browser (Excel5)
$end_date = !empty($_POST["date_end"]) ? date("ymd",strtotime($_POST["date_end"])) : date("ymd");
$filename = sprintf("OC_Orders_%s_%s", date("ymd",strtotime($_POST["date_start"])), $end_date );
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit();


?>
