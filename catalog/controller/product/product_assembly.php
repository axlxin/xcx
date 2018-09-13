<?php

class ControllerProductProductAssembly extends Controller {

    public function getBomAssemblyTotal() {
        $post = $this->request->post['c'];

        $totals = $this->calcPcbAssembling($post);
        
        if($post['bga_pitch']!='No BGA'){
            unset($totals['manual_without_stencil']);
        }

        asort($totals);

        $json = [
            'manual_with_stencil' => $this->currency->format($totals['manual_with_stencil']),
            'automatic' => $this->currency->format($totals['automatic']),
            'recommended' => key($totals)
        ];
        
        if($post['bga_pitch']=='No BGA'){
            $json['manual_without_stencil'] = $this->currency->format($totals['manual_without_stencil']);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * PCB FLASHING AND TESTING
     */
    public function getFlashingTotal() {
        $seconds = isset($this->request->post['seconds']) ? intval($this->request->post['seconds']) : 0;
        $pcba_quantity = isset($this->request->post['pcba_quantity']) ? intval($this->request->post['pcba_quantity']) : 0;

        if (0 == $seconds) {
            $total = 'Unknown';
        } else {
            $total = $this->calcPcbFlashing($seconds, $pcba_quantity);
            $total = $this->currency->format($total);
        }

        $json['total'] = $total;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Shipping Company自动补全功能
     */
    public function autocomplete() {
        $json = array();
        $limit = 20;

        if (isset($this->request->get['filter_name'])) {
            $filter_name = strtolower($this->request->get['filter_name']);

            $companies = [
                'Post Office',
				'UPS',
                'DHL',
                'Fedex',
                'TNT',
            ];

            if (!empty($filter_name)) {
                $num = 0;
                foreach ($companies as $company) {
                    if ($num < $limit && stripos(strtolower($company), $filter_name) !== false) {
                        $json[] = array(
                            'name' => $company,
                        );
                        $num++;
                    }
                }
            } else {
                for ($i = 0; $i < count($companies); $i++) {
                    if($i > $limit){
                        break;
                    }
                    $json[] = array(
                        'name' => $companies[$i],
                    );
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocompleteOrderFiles() {
        $json = array();
        $this->load->model('account/order');
        $this->load->model('tool/upload');

        $order_id = $this->request->get['order_id'];
        $customer_id = $this->customer->isLogged();
        $order = $this->model_account_order->getOrder($order_id);
        if ($order_id && $customer_id && $order && $order['customer_id'] === $customer_id) {

            $products = $this->model_account_order->getOrderProducts($order_id);
            $current_currency_code = $this->currency->getCode();

            foreach ($products as $product) {
                if ($product['name'] == 'PCB Prototyping') {
                    $options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

                    foreach ($options as $option) {
                        if ($option['type'] == 'file') {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info) {
                                if ($order['currency_code'] == $current_currency_code) {
                                    $price_format = $this->currency->format($product['total'], $order['currency_code'], $order['currency_value']);
                                } else {
                                    $price = $this->currency->convert($product['total'], $order['currency_code'], $current_currency_code);
                                    $price_format = $this->currency->format($price);
                                }

                                $json[] = array(
                                    'name' => $upload_info['name'],
                                    'value' => $price_format
                                );
                            }
                        }
                    }
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function saveInquiry() {
        $json = ['error' => 0, 'message' => ''];

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $_SERVER['HTTP_REFERER'];
            $json = ['error' => 2, 'redirect' => $this->url->link('account/login', '', 'SSL')];
        } else if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $post = $this->request->post;

            $data = [];

            $estimated_cost = $this->getEstimatedCost($post);
            $data['estimated_cost'] = json_encode($estimated_cost);

            $data['comment'] = $post['comment'];
            unset($post['comment']);

            $data['formData'] = json_encode($post);

            $customer_id = $this->customer->getId();
            $data['customer_id'] = $customer_id > 0 ? $customer_id : 0;

            $data['date_added'] = date('Y-m-d H:i:s');

            $data['email'] = $this->customer->getEmail();

            $this->load->model('catalog/pcb_assembly');
            $this->model_catalog_pcb_assembly->addInquiry($data);
            
            $this->sendEmail($post, $estimated_cost, $data['comment']);
        } else {
            $json['error'] = 1;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function getEstimatedCost($formData) {
        $this->load->model('account/order');
        $this->load->model('tool/upload');

        $estimated_cost = [
            'a' => '$0.00',
            'b' => '$0.00',
            'c' => [],
            'd' => '$0.00'
        ];

        $current_currency_code = $this->currency->getCode();

        // A.PCB Manufacturing
        $smart_order_id = $formData['a']['smart_order_id'];
        $estimated_cost['a'] = 'Unknown';
        if (!empty($smart_order_id) && !empty($formData['a']['smart_file_name'])) {
            $order = $this->model_account_order->getOrder($smart_order_id);
            $products = $this->model_account_order->getOrderProducts($smart_order_id);

            foreach ($products as $product) {
                if ($product['name'] == 'PCB Prototyping') {
                    $options = $this->model_account_order->getOrderOptions($smart_order_id, $product['order_product_id']);

                    foreach ($options as $option) {
                        if ($option['type'] == 'file') {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info && $upload_info['name'] == $formData['a']['smart_file_name']) {
                                if ($order['currency_code'] == $current_currency_code) {
                                    $price_format = $this->currency->format($product['total'], $order['currency_code'], $order['currency_value']);
                                } else {
                                    $price = $this->currency->convert($product['total'], $order['currency_code'], $current_currency_code);
                                    $price_format = $this->currency->format($price);
                                }


                                $estimated_cost['a'] = $price_format . ' ' . $current_currency_code;
                                break;
                            }
                        }
                    }
                }
            }
        }

        // B.BOM Purchasing
        $estimated_cost['b'] = $this->calcBomPurchasing($formData) . ' ' . $current_currency_code;

        // C.PCB Assembling
        $calcPcbAssembling = $this->calcPcbAssembling($formData['c']);
        $estimated_cost['c'] = [
            'manual_without_stencil' => $this->currency->format($calcPcbAssembling['manual_without_stencil']) . ' ' . $current_currency_code,
            'manual_with_stencil' => $this->currency->format($calcPcbAssembling['manual_with_stencil']) . ' ' . $current_currency_code,
            'automatic' => $this->currency->format($calcPcbAssembling['automatic']) . ' ' . $current_currency_code,
        ];

        // D.PCB Flashing & Testing
        $d_seconds = intval($formData['d']['estimate_of_testing_time']);
        $d_assembly_quantity = intval($formData['c']['pcb_assembly_quantity']);

        if (0 == $d_seconds) {
            $estimated_cost['d'] = 'Unknown';
        } else {
            $calcPcbFlashing = $this->calcPcbFlashing($d_seconds, $d_assembly_quantity);
            $estimated_cost['d'] = $this->currency->format($calcPcbFlashing) . ' ' . $current_currency_code;
        }

        return $estimated_cost;
    }

    private function calcPcbAssembling($formC) {
        $pcb_assembly_quantity = (int) $formC['pcb_assembly_quantity'];
        $smt_pads_per_board = (int) $formC['smt_pads_per_board'];
        $tht_pins_per_board = (int) $formC['tht_pins_per_board'];
        $no_lead_pads_per_board = (int) $formC['no_lead_pads_per_board'];

        //默认计算货币单位为美元
        $total_manual_without_stencil = $pcb_assembly_quantity * (0.08 * ($smt_pads_per_board - $no_lead_pads_per_board) + 0.05 * $tht_pins_per_board + 0.18 * $no_lead_pads_per_board) + 19.99;
        $total_manual_with_stencil = $pcb_assembly_quantity * (0.05 * ($smt_pads_per_board - $no_lead_pads_per_board) + 0.05 * $tht_pins_per_board + 0.12 * $no_lead_pads_per_board) + 39.99;
        $total_automatic = $pcb_assembly_quantity * (0.01 * ($smt_pads_per_board - $no_lead_pads_per_board) + 0.05 * $tht_pins_per_board + 0.01 * $no_lead_pads_per_board) + 699.99;

        $totals = [
            'manual_without_stencil' => ($total_manual_without_stencil > 79.99) ? $total_manual_without_stencil : 79.99,
            'manual_with_stencil' => ($total_manual_with_stencil > 99.99) ? $total_manual_with_stencil : 99.99,
            'automatic' => ($total_automatic > 799.99) ? $total_automatic : 799.99,
        ];

        return $totals;
    }

    private function calcBomPurchasing($formData) {
        $formB = $formData['b'];
        $formC = $formData['c'];

        if ($formB['estimated_type'] == 1) {
            $total = intval($formC['pcb_assembly_quantity']) * floatval($formB['estimated_price']);
        } else {
            $total = $formB['estimated_price'];
        }

        if($total==0){
            return 'Unknown';
        }else{
            return $this->currency->getSymbolLeft() . $total;
        }
    }

    private function calcPcbFlashing($seconds, $pcba_quantity) {
        $calc_total = 0;
        if ($seconds > 0 && $pcba_quantity > 0) {
            $calc_total = $seconds * $pcba_quantity / 3600 * 38;
        }

        return ($calc_total>38) ? $calc_total : 38;
    }

    /**
     * 询价提交后，发送通知邮件给客户
     */
    private function sendEmail($formData, $estimated_cost, $comment) {
        $subject = 'Thank you for submitting your PCBA inquiry.';

        $message = "Thank you for submitting your PCBA inquiry. We will work on a formal quotation based on the files and requirements you submitted as soon as possible. In the meantime, here is a copy of your rough quotation. Please remember, this is an estimate only." . "\n\n";
        $message .= "Copy of rough quotation" . "\n";
        
        $formDataFormat = $this->formDataFormat($formData, $comment);
        foreach($formDataFormat as $item){
            $message .= $item. "\n";
        }
        
        $message .= "\n\n";
        
        $message .= sprintf("A. PCB Manufacturing: %s\n", $estimated_cost['a']);
        $message .= sprintf("B. BOM Purchasing: %s\n", $estimated_cost['b']);
        $message .= sprintf("C. PCB Assembly Recommended Selection:\n");
        
        $recommended['manual_without_stencil'] = $recommended['manual_with_stencil'] = $recommended['automatic'] = '';
        $recommended[$formData['c_option_recommended']] = ' (recommended)';
        
        $message .= sprintf("Manual without stencil%s: %s\n", $recommended['manual_without_stencil'], $estimated_cost['c']['manual_without_stencil']);
        $message .= sprintf("Manual with stencil%s: %s\n", $recommended['manual_with_stencil'], $estimated_cost['c']['manual_with_stencil']);
        $message .= sprintf("Automatic%s: %s\n", $recommended['automatic'], $estimated_cost['c']['automatic']);
        $message .= sprintf("D. PCBA Flashing & Testing: %s\n\n", $estimated_cost['d']);
        
        $message .= "Thank you for your patience as we put together a quotation for you.\n\n";
        $message .= "Warm regards,\n";
        $message .= 'Smart Prototyping Team';

        //sent to customer
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setTo($this->customer->getEmail());
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText($message);
        $mail->send();
        
        //sent to store owner
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setTo($this->config->get('config_email'));
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText($message);
        $mail->send();
    }
    
    /**
     * 格式化提交的表单数据
     */
    private function formDataFormat($formData, $comment){
        $formA = $formData['a'];
        $formB = $formData['b'];
        $formC = $formData['c'];
        $formD = $formData['d'];
        
        $result = [];
        
        //A
        if($formA['pcb_supplied_by']=='Smart Prototyping'){
            $result[] = sprintf('PCB Supplied by: %s, Order ID: %s, File Name: %s', $formA['pcb_supplied_by'], $formA['smart_order_id'], $formA['smart_file_name']);
        }else{
            $result[] = sprintf('PCB Supplied by: %s, Shipping Company: %s, Tracking Number: %s', $formA['pcb_supplied_by'], $formA['me_shipping_company'], $formA['me_tracking_number']);
        }
        
        //B
        if($formB['components_supplied_by']=='Smart Prototyping'){
            $estimated_type = ($formB['estimated_type']==0) ? 'Estimated total of all components in batch' : 'Estimated total of components per board';
            $result[] = sprintf('Components Supplied by: %s, %s: %s', $formB['components_supplied_by'], $estimated_type, $formB['estimated_price']);
        }else{
            $result[] = sprintf('Components Supplied by: %s, Shipping Company: %s, Tracking Number: %s', $formB['components_supplied_by'], $formB['me_shipping_company'], $formB['me_tracking_number']);
        }
        //C
        $result[] = sprintf('PCB Assembly Quantity: %s', $formC['pcb_assembly_quantity']);
        $result[] = sprintf('Unique Number of Parts: %s', $formC['unique_number_of_parts']);
        $result[] = sprintf('SMT Pads per Board: %s', $formC['smt_pads_per_board']);
        $result[] = sprintf('THT Pins per Board: %s', $formC['tht_pins_per_board']);
        $result[] = sprintf('No-Lead Pads Per Board: %s', $formC['no_lead_pads_per_board']);
        $result[] = sprintf('Single/Double-sided: %s', $formC['single_double_sided']);
        $result[] = sprintf('FPCB Assembly: %s', $formC['fpcb_assembly']);
        $result[] = sprintf('BGA Pitch: %s', $formC['bga_pitch']);
        
        //D
        $result[] = sprintf('Short Circuit Testing: %s', $formD['short_circuit_testing']);
        $result[] = sprintf('Power On Testing: %s', $formD['power_on_testing']);
        $result[] = sprintf('Firmware Flashing: %s', $formD['firmware_flashing']);
        $result[] = sprintf('Functional Testing: %s', $formD['functional_testing']);
        $result[] = sprintf('Design Tester: %s', $formD['design_tester']);
        $result[] = sprintf('Build Tester: %s', $formD['build_tester']);
        $result[] = sprintf('X-Ray: %s', $formD['x_ray']);
        $result[] = sprintf('AOI: %s', $formD['aoi']);
        $result[] = sprintf('Estimate of Testing Time: %s seconds per board', $formD['estimate_of_testing_time']);
        
        //Project Files
        $project_file = '';
        if(!empty($formData['project_file'])){
            $upload_info = $this->model_tool_upload->getUploadByCode($formData['project_file']);
            $project_file = $upload_info['name'];
        }
        $result[] = sprintf('File: %s', $project_file);
        
        $result[] = sprintf('Remark: %s', $comment);
        
        return $result;
    }

}
