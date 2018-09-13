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

if(!isset($_POST["selected"]) || empty($_POST["selected"]) ){
    exit_error('打开姿势不正确！');
}

if(!isset($_POST["export_token"]) || empty($_POST["export_token"]) ){
    exit_error('打开姿势不正确！');
}

checkToken($_POST["export_token"]);


// Configuration
require_once('../admin/config.php');
require_once(DIR_SYSTEM . 'startup.php');
require_once('dhl_orderReader.php');

// Registy
$registry = new Registry();

//读取orders的信息
$orderReader = new orderReader($registry);
$orders = $orderReader->getSelectedOrders($_POST["selected"]);
//print_r($orders);
//exit();

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
/** PHPExcel_IOFactory */
include dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';

function readTemplate(){
    $inputFileName = './SFC_Standard.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    return $sheetData;
}
$tplData = readTemplate();

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Kevin Pan")
    ->setLastModifiedBy("Kevin Pan")
    ->setTitle("Opencart orders 2 DHL Data")
    ->setSubject("Opencart orders 2 DHL Data")
    ->setDescription("This document created by KP_expressDataExporter.")
    ->setKeywords("DHL excel")
    ->setCategory("DHL excel");

//设置激活中的Sheet
$objPHPExcel->setActiveSheetIndex(0);

// 设置表头
$limit = 12; //只有33列内容
foreach($tplData[1] as $key =>$value ){
    if(0==$limit){
        break;
    }
    $objActSheet = $objPHPExcel->getActiveSheet();
    $objActSheet->setCellValue($key.'1', $value);
    $objActSheet->getColumnDimension($key)->setAutoSize(true); //设置单元格宽度自适应
    $limit--;
}

$row_index = 2; //开始行号

foreach($orders as $id => $order){
    $objActSheet = $objPHPExcel->getActiveSheet();
    $start = 0; //数组开始索引值
    foreach($tplData[1] as $key =>$value ){
        if(12==$start){
            break;
        }
        $objActSheet->setCellValue($key.$row_index, $order[$start]);
        $start++;
    }
    $row_index++;
}


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="oc_orders_DHL_' . date("ymd") . '.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit();
        

?>