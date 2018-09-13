<?php

class ControllerSalePcbAssemblingInquiry extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('sale/pcb_assembling_inquiry');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/pcb_assembling_inquiry');

        $this->getList();
    }

    protected function getList() {

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'pai.id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/pcb_assembling_inquiry', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['inquiries'] = array();

        $config_limit_admin = 10;
        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $config_limit_admin,
            'limit' => $config_limit_admin
        );

        $inquiry_total = $this->model_sale_pcb_assembling_inquiry->getTotalInquiries($filter_data);

        $results = $this->model_sale_pcb_assembling_inquiry->getInquiries($filter_data);
        
        $this->load->model('tool/upload');

        foreach ($results as $result) {
            $formData = json_decode($result['formData'], true);
            $estimated_cost = json_decode($result['estimated_cost'], true);
            $estimated_cost['c']['user_selected'] =  $estimated_cost['c'][$formData['c_option_summary']];
            
            $data['inquiries'][] = array(
                'id' => $result['id'],
                'customer' => $result['customer'],
                'email' => $result['email'],
                'estimated_cost' => $estimated_cost,
                'formData' => $this->formDataFormat($formData, $result['comment']),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['column_id'] = $this->language->get('column_id');
        $data['column_customer'] = $this->language->get('column_customer');
        $data['column_email'] = $this->language->get('column_email');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_view'] = $this->language->get('button_view');

        $data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_id'] = $this->url->link('sale/pcb_assembling_inquiry', 'token=' . $this->session->data['token'] . '&sort=pai.id' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $inquiry_total;
        $pagination->page = $page;
        $pagination->limit = $config_limit_admin;
        $pagination->url = $this->url->link('sale/pcb_assembling_inquiry', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($inquiry_total) ? (($page - 1) * $config_limit_admin) + 1 : 0, ((($page - 1) * $config_limit_admin) > ($inquiry_total - $config_limit_admin)) ? $inquiry_total : ((($page - 1) * $config_limit_admin) + $config_limit_admin), $inquiry_total, ceil($inquiry_total / $config_limit_admin));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/pcb_assembling_inquiry_list.tpl', $data));
    }
    
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
            $result[] = sprintf('File: <a href="%s" style="text-decoration: underline;">%s</a>', $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $formData['project_file'], 'SSL'), $project_file);
        }
        
        $result[] = sprintf('Remark: %s', $comment);
        
        return $result;
    }

}
