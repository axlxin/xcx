<?php

if (!function_exists('export_customer_data_memory_overflow_handler')) {

	function export_customer_data_memory_overflow_handler() {
		$last_error = error_get_last();
		if ($last_error['type'] === E_ERROR) {
			$_SESSION['error_memory'] = 1;
			$location = HTTP_SERVER . 'index.php?route=tool/export_customers&token=' . $_SESSION['token'];
			header('location: ' . $location);
			exit;
		}
		if ($last_error) {
			error_handler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
		}
	}

}

class ControllerToolExportCustomers extends Controller {

	public function index() {
		$this->load->language('tool/export_customers');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['button_export'] = $this->language->get('text_export');
		$data['text_export_copy'] = $this->language->get('text_export_copy');
		$data['export_url'] = $this->url->link('tool/export_customers/export', 'token=' . $this->session->data['token'], 'SSL');

		$data['entry_export_customers'] = $this->language->get('entry_export_customers');
		$data['entry_export_orders'] = $this->language->get('entry_export_orders');
		$data['entry_export_order_products'] = $this->language->get('entry_export_order_products');
		$data['entry_joined_between'] = $this->language->get('entry_joined_between');
		$data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$data['entry_order_date_between'] = $this->language->get('entry_order_date_between');
		$data['entry_order_id_between'] = $this->language->get('entry_order_id_between');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_zipped'] = $this->language->get('entry_zipped');
		$data['entry_and'] = $this->language->get('entry_and');

		$data['entry_filetype_csv'] = $this->language->get('entry_filetype_csv');
		$data['entry_filetype_xls'] = $this->language->get('entry_filetype_xls');
		$data['entry_filetype_xlsx'] = $this->language->get('entry_filetype_xlsx');
		$data['entry_filetype_csv_single'] = $this->language->get('entry_filetype_csv_single');
		$data['entry_filetype_xls_single'] = $this->language->get('entry_filetype_xls_single');
		$data['entry_filetype_xlsx_single'] = $this->language->get('entry_filetype_xlsx_single');

		$data['text_separate_sheets'] = $this->language->get('text_separate_sheets');
		$data['text_single_sheet'] = $this->language->get('text_single_sheet');

		if (isset($this->session->data['error_memory'])) {
			$data['error_memory'] = sprintf($this->language->get('error_memory'), ini_get('memory_limit'));
			unset($this->session->data['error_memory']);
		} else {
			$data['error_memory'] = '';
		}
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('tool/export_customers', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->template = 'tool/export_customers.tpl';
		
                
                $data['header'] = $this->load->controller('common/header');
                $data['column_left'] = $this->load->controller('common/column_left');
                $data['footer'] = $this->load->controller('common/footer');
                
                
                

		$this->response->setOutput($this->load->view('tool/export_customers.tpl', $data), $this->config->get('config_compression'));
	}

	public function export() {

		$this->load->language('tool/export_customers');
		$this->load->model('tool/export_customers');

		if (!$this->user->hasPermission('modify', 'tool/export_customers')) {
			$this->session->data['error'] = $this->language->get('error_permission');
			$this->redirect($this->url->link('tool/export_customers', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->redirect($this->url->link('tool/export_customers', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (!isset($this->request->post['export_customers']) && !isset($this->request->post['export_orders']) && !isset($this->request->post['export_order_products'])) {
			$this->session->data['error'] = $this->language->get('error_nothing_selected');
			$this->redirect($this->url->link('tool/export_customers', 'token=' . $this->session->data['token'], 'SSL'));
		}

		register_shutdown_function('export_customer_data_memory_overflow_handler');

		require_once DIR_SYSTEM . 'library/PHPExcel.php';
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		defined('PCLZIP_TEMPORARY_DIR') || define('PCLZIP_TEMPORARY_DIR', realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR);

		$data = array();

		$data['export_customers'] = isset($this->request->post['export_customers']);
		$data['export_orders'] = isset($this->request->post['export_orders']);
		$data['export_order_products'] = isset($this->request->post['export_order_products']);
		$data['single_sheet'] = in_array($this->request->post['filetype'], array('csv_single', 'xls_single', 'xlsx_single'));
		$data['join_date_start'] = false;
		$data['join_date_end'] = false;
		$data['newsletter'] = false;
		$data['order_start_date'] = false;
		$data['order_date_end'] = false;
		$data['order_id_start'] = false;
		$data['order_id_end'] = false;
		
		

		if ($data['export_orders']) {
			$data['order_start_date'] = $this->stringToDate($this->request->post['order_date_start']);
			$data['order_date_end'] = $this->stringToDate($this->request->post['order_date_end']);
			$data['order_id_start'] = $this->stringToDate($this->request->post['order_id_start']);
			$data['order_id_end'] = $this->stringToDate($this->request->post['order_id_end']);
			$data['order_status_id'] = $this->request->post['order_status_id'];
		} else if ($data['export_customers']) {
			$data['join_date_start'] = $this->stringToDate($this->request->post['join_date_start']);
			$data['join_date_end'] = $this->stringToDate($this->request->post['join_date_end']);
			$data['newsletter'] = $this->request->post['newsletter'];
		}

		$sheetCount = $data['single_sheet'] ? 1 : $data['export_customers'] + $data['export_orders'] + $data['export_order_products'];

		$workbook = new PHPExcel();
		$workbook->removeSheetByIndex(0);

		$data['tables'] = array();

		if ($data['single_sheet'] == "1") {
			// all in one dataset
		

			if ($data['export_customers']) {
				$data['tables'][] = 'customers';
			}
			if ($data['export_orders']) {
				$data['tables'][] = 'orders';
			}
			if ($data['export_order_products']) {
				$data['tables'][] = 'order_products';
			}

			$spreadsheetData = $this->model_tool_export_customers->getData($data);
			$this->addSheet($workbook, $spreadsheetData, $this->language->get('tab_combined_export'));
		} else {
		
			// individual files

			if ($data['export_customers']) {
				$data['tables'] = array('customers');
				$spreadsheetData = $this->model_tool_export_customers->getData($data);
				$this->addSheet($workbook, $spreadsheetData, $this->language->get('tab_customers'));
			}
			if ($data['export_orders']) {
				$data['tables'] = array('orders');
				$spreadsheetData = $this->model_tool_export_customers->getData($data);
				$this->addSheet($workbook, $spreadsheetData, $this->language->get('tab_orders'));
			}
			if ($data['export_order_products']) {
				$data['tables'] = array('order_products');
				$spreadsheetData = $this->model_tool_export_customers->getData($data);
				$this->addSheet($workbook, $spreadsheetData, $this->language->get('tab_order_products'));
			}
		}

		$filetypes = array(
			'csv' => array(
				'mimetype' => 'text/csv',
				'phpexcel_class' => 'CSV'
			),
			'xls' => array(
				'mimetype' => 'application/vnd.ms-excel',
				'phpexcel_class' => 'Excel5'
			),
			'xlsx' => array(
				'mimetype' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'phpexcel_class' => 'Excel2007'
			),
			'csv_single' => array(
				'mimetype' => 'text/csv',
				'phpexcel_class' => 'CSV'
			),
			'xls_single' => array(
				'mimetype' => 'application/vnd.ms-excel',
				'phpexcel_class' => 'Excel5'
			),
			'xlsx_single' => array(
				'mimetype' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'phpexcel_class' => 'Excel2007'
			)
		);
		
		
		

		if (isset($this->request->post['filetype']) && in_array($this->request->post['filetype'], array_keys($filetypes))) {
			$filetype = $this->request->post['filetype'];
		} else {
			$filetype = 'csv';
		}

		$zipped = isset($this->request->post['zipped']);
		$multipleSheets = false;

		if ($filetype == 'csv' && $sheetCount > 1) {
			$multipleSheets = true;
			$zipped = true;
		}

		$filename_prefix = 'export_' . date('Y-m-d_Hi') . '.';
		
		if(strpos($filetype,"_")==true) { 
			
			$filetype_parts = explode("_",$filetype);
			$filetype = $filetype_parts[0];
			
		}

		$filename = $filename_prefix . ($zipped ? 'zip' : $filetype);

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: max-age=0');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename=' . $filename);

		if ($zipped) {

			require_once DIR_SYSTEM . 'library/PHPExcel/Shared/PCLZip/pclzip.lib.php';

			$temp_zip_path = tempnam(sys_get_temp_dir(), '');
			$temp_file_folder = $temp_zip_path . '-files';
			mkdir($temp_file_folder);

			$zip = new PclZip($temp_zip_path);

			if ($multipleSheets == true) {

				$index = 0;
				foreach ($workbook->getWorksheetIterator() as $worksheet) {
					$objWriter = PHPExcel_IOFactory::createWriter($workbook, $filetypes[$filetype]['phpexcel_class']);
					$objWriter->setSheetIndex($index);
					if ($filetype == 'csv') {
						$objWriter->setUseBOM(true);
					}

					$tempfile = $temp_file_folder . DIRECTORY_SEPARATOR . $workbook->getSheet($index)->getTitle() . '.' . $filetype;
					$objWriter->save($tempfile);
					$zip->add($tempfile, PCLZIP_OPT_REMOVE_ALL_PATH);
					unlink($tempfile);
					$index++;
				}
			} else {
				$objWriter = PHPExcel_IOFactory::createWriter($workbook, $filetypes[$filetype]['phpexcel_class']);
				if ($filetype == 'csv') {
					$objWriter->setUseBOM(true);
				}
				$tempfile = $temp_file_folder . DIRECTORY_SEPARATOR . $filename_prefix . $filetype;
				$objWriter->save($tempfile);
				$zip->add($tempfile, PCLZIP_OPT_REMOVE_ALL_PATH);
				unlink($tempfile);
			}

			header('Content-Type: application/zip');
			readfile($temp_zip_path);
			unlink($temp_zip_path);
		} else {

			header('Content-Type: ' . $filetypes[$filetype]['mimetype']);
			$objWriter = PHPExcel_IOFactory::createWriter($workbook, $filetypes[$filetype]['phpexcel_class']);
			if ($filetype == 'csv') {
				$objWriter->setUseBOM(true);
			}
			$objWriter->save('php://output');
		}

		exit;
	}

	private function addSheet($workbook, $data, $title) {
		$sheet = $workbook->createSheet()->setTitle($title);

		if (empty($data)) {
			$sheet->setCellValueByColumnAndRow(0, 1, $this->language->get('text_no_data'));
		} else {
			$headers = array_keys($data[0]);
			foreach ($headers as $index => $header) {
				$sheet->setCellValueByColumnAndRow($index, 1, $this->language->get('data_column_' . $header));
			}
		}
		$this->addWorksheetData($sheet, $data);
	}

	private function addWorksheetData($sheet, $data) {

		$row_index = 2;
		foreach ($data as $row) {
			$column_index = 0;
			foreach ($row as $key => $value) {
				$sheet->setCellValueExplicitByColumnAndRow($column_index, $row_index, $value, PHPExcel_Cell_DataType::TYPE_STRING);
				$column_index++;
			}
			$row_index++;
		}
	}

	private function stringToDate($date) {
		$parts = explode("-", $date);
		if (count($parts) != 3) {
			return false;
		}

		if (is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2]) && checkdate($parts[1], $parts[2], $parts[0])) {
			return mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]);
		}
		return false;
	}

}

?>