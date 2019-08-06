<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Service_center extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Servicecenter_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }

    // ****************************** View Page -- START ****************************** //

    // View List Service;
    public function list_service()
    {

        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
     
        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat'] = $siteSetting_dateformat;    
        $data['dateformat'] = $dateformat;
        
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        $config = array();
        $config['base_url'] = base_url().'service_center/list_service/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Servicecenter_model->record_service_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Servicecenter_model->fetch_service_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Servicecenter_model->record_service_count();

            $start_pg_point = 0;
            if ($have_count == 0) {
                $start_pg_point = 0;
            } else {
                $start_pg_point = 1;
            }

            $sh_text = "Showing $start_pg_point to ".count($data['results']).' of '.$this->Servicecenter_model->record_service_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Servicecenter_model->record_service_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data['setting_dateformat'] = $setting_dateformat;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');       
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_export'] = $this->lang->line('export');
        $data['lang_search'] = $this->lang->line('search');       
        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');          
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');
        $data['lang_promotion'] = $this->lang->line('promotion');
        $data['lang_active']= $this->lang->line('active');
        $data['lang_inactive']= $this->lang->line('inactive');
        $data['lang_report_details'] = $this->lang->line('report_details');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_service_center'] = $this->lang->line('service_center');
        $data['lang_list_service'] = $this->lang->line('list_service');
        $data['lang_add_service_item'] = $this->lang->line('add_service_item');
        $data['lang_service_code'] = $this->lang->line('service_code');
        $data['lang_search_item'] = $this->lang->line('search_item');
        $data['lang_start_date'] = $this->lang->line('start_date');
        $data['lang_end_date'] = $this->lang->line('end_date');
        $data['lang_code'] = $this->lang->line('code');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_date_of_entry'] = $this->lang->line('date_of_entry');
        $data['lang_date_of_completion'] = $this->lang->line('date_of_completion');
        $data['lang_technician'] = $this->lang->line('technician');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_phone'] = $this->lang->line('phone');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_qty'] = $this->lang->line('qty');
        $data['lang_new'] = $this->lang->line('new');
        $data['lang_process'] = $this->lang->line('process');
        $data['lang_done'] = $this->lang->line('done');
        $data['lang_monthly_report_category'] = $this->lang->line('monthly_report_category');
        $data['lang_delete_service_item'] = $this->lang->line('delete_service_item');

        $this->load->view('service_center', $data);
    }

    // Edit Customer;
    public function edit_serviceitem()
    {   
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
     
        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat'] = $siteSetting_dateformat;    
        $data['dateformat'] = $dateformat;

        $id_service = $this->input->get('id_service');
        $data['id_service'] = $id_service;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_add_customer'] = $this->lang->line('add_customer');
        $data['lang_export'] = $this->lang->line('export');
        $data['lang_search'] = $this->lang->line('search');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_email'] = $this->lang->line('email');
        $data['lang_mobile'] = $this->lang->line('mobile');
        $data['lang_customer_name'] = $this->lang->line('customer_name');
        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_sales_history'] = $this->lang->line('sales_history');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_full_name'] = $this->lang->line('full_name');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_delete_customer'] = $this->lang->line('delete_customer');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_edit_customer'] = $this->lang->line('edit_customer');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_report_details'] = $this->lang->line('report_details');
        $data['lang_promotion'] = $this->lang->line('promotion');
        $data['lang_service_center'] = $this->lang->line('service_center');
        $data['lang_list_service'] = $this->lang->line('list_service');
        $data['lang_add_service_item'] = $this->lang->line('add_service_item');
        $data['lang_edit_service_item'] = $this->lang->line('edit_service_item');
        $data['lang_customer_name'] = $this->lang->line('customer_name');
        $data['lang_date_of_entry'] = $this->lang->line('date_of_entry');
        $data['lang_date_of_completion'] = $this->lang->line('date_of_completion');
        $data['lang_technician'] = $this->lang->line('technician');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_phone'] = $this->lang->line('phone');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_qty'] = $this->lang->line('qty');
        $data['lang_monthly_report_category'] = $this->lang->line('monthly_report_category');
        $data['lang_service_center'] = $this->lang->line('service_center');
        $data['lang_list_service'] = $this->lang->line('list_service');
        $data['lang_delete_service_item'] = $this->lang->line('delete_service_item');
        $this->load->view('edit_serviceitem', $data);
    }

     
    // Add Promotion;
    public function add_serviceitem()
    {   
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;      
     
        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat'] = $siteSetting_dateformat;    
        $data['dateformat'] = $dateformat;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');

        $data['lang_report_details'] = $this->lang->line('report_details');
        $data['lang_add_promotion'] = $this->lang->line('add_promotion');
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_export'] = $this->lang->line('export');
        $data['lang_search'] = $this->lang->line('search');
        $data['lang_promotion_name'] = $this->lang->line('promotion_name');
        $data['lang_actived_promotion'] = $this->lang->line('actived_promotion');
        $data['lang_deactived_promotion']= $this->lang->line('deactived_promotion');
        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');

       
        $data['lang_sales_history'] = $this->lang->line('sales_history');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_full_name'] = $this->lang->line('full_name');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');
        $data['lang_promotion'] = $this->lang->line('promotion');

        $data['lang_service_center'] = $this->lang->line('service_center');
        $data['lang_list_service'] = $this->lang->line('list_service');
        $data['lang_add_service_item'] = $this->lang->line('add_service_item');
        $data['lang_customer_name'] = $this->lang->line('customer_name');
        $data['lang_date_of_entry'] = $this->lang->line('date_of_entry');
        $data['lang_date_of_completion'] = $this->lang->line('date_of_completion');
        $data['lang_technician'] = $this->lang->line('technician');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_phone'] = $this->lang->line('phone');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_qty'] = $this->lang->line('qty');
        $data['lang_monthly_report_category'] = $this->lang->line('monthly_report_category');
        $data['lang_service_center'] = $this->lang->line('service_center');
        $data['lang_list_service'] = $this->lang->line('list_service');
        $data['lang_grouping_category'] = $this->lang->line('grouping_category');

        $this->load->view('add_serviceitem', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Customer;
    public function deletePromotion()
    {
        $promo_id = $this->input->post('promo_id');
        $promotion_name = $this->input->post('promotion_name');

        if ($this->Constant_model->deleteData('promotion', $promo_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Promotion', "Successfully Deleted Promotion : $promotion_name."));
            redirect(base_url().'promotion/view');
        }
    }

    // Insert New Customer;
    public function insertServiceitem()
    {
        $cust_id = $this->input->post('cust_id');
        $start_date = date('Y-m-d H:i:s', strtotime(strip_tags($this->input->post('start_date'))));
        $technician = $this->input->post('technician');
        $price = $this->input->post('price');
        $qty = $this->input->post('qty');
        $remark = $this->input->post('remark');
       
       

        //$us_id = $this->session->userdata('user_id');
        //$tm = date('Y-m-d H:i:s', time());

        if (empty($cust_id)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Service', 'Please enter Customer'));
            redirect(base_url().'service_center/add_serviceitem');
        }else if (empty($start_date )){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Service', 'Please enter Date of Entry'));
            redirect(base_url().'service_center/add_serviceitem');
        }else if (empty($technician)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Service', 'Please enter technician'));
            redirect(base_url().'service_center/add_serviceitem');
        }else if (empty($price)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Service', 'Please enter price'));
            redirect(base_url().'service_center/add_serviceitem');
        }else if (empty($qty)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Service', 'Please enter qty'));
            redirect(base_url().'service_center/add_serviceitem');
        }else if (empty($remark)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Service', 'Please enter remark'));
            redirect(base_url().'service_center/add_serviceitem');
        }else {            

            $ins_service_data = array(
                      'id_service' => $this->Servicecenter_model->SET_idservice(),
                      'id_customer' => $cust_id,
                      'created_datetime' => $start_date,
                      'technician' => $technician,
                      'price' => $price,
                      'qty' => $qty,
                      'remark' => $remark, 
                      'status'=>'1'
                      
            );
            if ($this->Constant_model->insertData('service_center', $ins_service_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add Service', "Successfully Added Service Item : $remark"));
                redirect(base_url().'service_center/add_serviceitem');
            }
        }
    }

    public function updateStatusitem()
    {
        $id_service = $this->input->post('id_service');
        $update_status = $this->input->post('update_status');
        $updated_datetime = date('Y-m-d H:i:s');
        if ($update_status == 3){
            $upd_data = array(            
                'status' => $update_status,
                'updated_datetime'=> $updated_datetime
            );
        }else{
            $upd_data = array(            
                'status' => $update_status,
                
            );
        }
        
        $this->Servicecenter_model->updateData('service_center', $upd_data, $id_service);

        $this->session->set_flashdata('alert_msg', array('success', 'Update Promotion', 'Successfully Updated Service Item!'));
        redirect(base_url().'service_center/list_service');
    }

    public function updateserviceitem()
    {   
        $id_service = $this->input->post('id_service');
        $cust_id = $this->input->post('cust_id');
        $start_date = date('Y-m-d H:i:s', strtotime(strip_tags($this->input->post('start_date'))));
        $technician = $this->input->post('technician');
        $price = $this->input->post('price');
        $qty = $this->input->post('qty');
        $remark = $this->input->post('remark');

        $upd_data = array(
                
                'id_customer' => $cust_id,
                'created_datetime' => $start_date,
                'technician' => $technician,
                'price' => $price,
                'qty' => $qty,
                'remark' => $remark 
        );
        $this->Servicecenter_model->updateData('service_center', $upd_data, $id_service);

        $this->session->set_flashdata('alert_msg', array('success', 'Update Service', 'Successfully Updated Service Item!'));
        redirect(base_url().'service_center/edit_serviceitem?id_service='.$id_service);
    }

    
    public function deleteserviceitem()
    {
        $id_service = $this->input->post('id_service');
        $remark = $this->input->post('remark');

        if ($this->Servicecenter_model->deleteData('service_center', $id_service)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Service Item', "Successfully Deleted Service Item : $id_service $remark."));
            redirect(base_url().'service_center/list_service');
        }
    }

    public function view_invoice()
    {
        $id_service = $this->input->get('id_service');

        $data['id_service'] = $id_service;

        $data['lang_address'] = $this->lang->line('address');
        $data['lang_telephone'] = $this->lang->line('telephone');
       
        $data['lang_customer_name'] = $this->lang->line('customer_name');
        $data['lang_mobile'] = $this->lang->line('mobile');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_qty'] = $this->lang->line('qty');
        $data['lang_per_item'] = $this->lang->line('per_item');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_card_number'] = $this->lang->line('card_number');
        $data['lang_cheque_number'] = $this->lang->line('cheque_number');
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_unpaid_amount'] = $this->lang->line('unpaid_amount');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_back_to_pos'] = $this->lang->line('back_to_pos');
        $data['lang_print_small_receipt'] = $this->lang->line('print_small_receipt');
        $data['lang_email'] = $this->lang->line('email');
        $data['lang_print_a4'] = $this->lang->line('print_a4');


        $data['lang_service_item'] = $this->lang->line('service_item');
        $data['lang_service_code'] = $this->lang->line('service_code');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_date_of_entry'] = $this->lang->line('date_of_entry');
        $data['lang_date_of_completion'] = $this->lang->line('date_of_completion');
        $data['lang_technician'] = $this->lang->line('technician');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_phone'] = $this->lang->line('phone');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_qty']= $this->lang->line('qty');
        $data['lang_new'] = $this->lang->line('new');
        $data['lang_process'] = $this->lang->line('process');
        $data['lang_done'] = $this->lang->line('done');
        $data['lang_status'] = $this->lang->line('status');

        $this->load->view('print_invoice_sc', $data);
    }
    // ****************************** Action To Database -- END ****************************** //

    public function export_listservice(){
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

        $this->load->library('excel');

        require_once './application/third_party/PHPExcel.php';
        require_once './application/third_party/PHPExcel/IOFactory.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        );

        $acc_default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => 'c7c7c7'),
        );
        $outlet_style_header = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 10,
                'name' => 'Arial',
                'bold' => true,
            ),
        );
        $top_header_style = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 15,
                'name' => 'Arial',
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $account_value_style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $text_align_style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
        );

        $lang_service_code = $this->lang->line('service_code');
        $lang_name = $this->lang->line('name');
        $lang_date_of_entry = $this->lang->line('date_of_entry');
        $lang_date_of_completion = $this->lang->line('date_of_completion');
        $lang_technician = $this->lang->line('technician');
        $lang_price = $this->lang->line('price');
        $lang_phone = $this->lang->line('phone');
        $lang_remark = $this->lang->line('remark');
        $lang_qty= $this->lang->line('qty');
        $lang_new = $this->lang->line('new');
        $lang_process = $this->lang->line('process');
        $lang_done = $this->lang->line('done');
        $lang_report_service_center = $this->lang->line('report_service_center');
        $lang_status = $this->lang->line('status');
        

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "$lang_report_service_center");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "$lang_service_code");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "$lang_name");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "$lang_date_of_entry");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "$lang_date_of_completion");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "$lang_phone");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "$lang_technician");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "$lang_qty");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "$lang_remark");
        $objPHPExcel->getActiveSheet()->setCellValue('I2', "$lang_status");
        $objPHPExcel->getActiveSheet()->setCellValue('J2', "$lang_price ($site_currency)");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;

        $servDtaResult = $this->db->query('SELECT sc.id_service, cu.fullname, sc.created_datetime, sc.updated_datetime, cu.mobile, sc.technician, sc.qty, sc.remark, sc.price, sc.status
        FROM service_center as sc join customers as cu on sc.id_customer = cu.id
        ORDER BY sc.id_service');
        $servDtaData = $servDtaResult->result();
        for ($t = 0; $t < count($servDtaData); ++$t) {
            $id_service = $servDtaData[$t]->id_service;
            $name = $servDtaData[$t]->fullname;
            $created_datetime = date("$site_dateformat H:i:s", strtotime($servDtaData[$t]->created_datetime));
            $updated_datetime = $servDtaData[$t]->updated_datetime;
            IF($updated_datetime == '0000-00-00 00:00:00'){
                $date_of_completion = "-";
            }ELSE{
                $date_of_completion =  date("$site_dateformat H:i:s", strtotime($servDtaData[$t]->updated_datetime));      
            }
              
            $phone= $servDtaData[$t]->mobile;
            $technician= $servDtaData[$t]->technician;
            $qty= $servDtaData[$t]->qty;
            $remark= $servDtaData[$t]->remark;
            $price= $servDtaData[$t]->price;
            
            $status= $servDtaData[$t]->status;
            IF($status==1){ 
                $info = $lang_new;
            }ELSE IF ($status==2){
                $info = $lang_process;
            }ELSE IF ($status==3){
                $info = $lang_done;
            }
           

            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$id_service");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$name");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$created_datetime");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$date_of_completion");                      
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$phone");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$technician");
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$qty");
            $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$remark");            
            $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$info");
            $objPHPExcel->getActiveSheet()->setCellValue("J$jj", "$price");
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("J$jj")->applyFromArray($account_value_style_header);


            unset($id_service);
            unset($name);
            unset($created_datetime);
            unset($updated_datetime);
            unset($phone);
            unset($technician);
            unset($qty);
            unset($remark);
            unset($price);
            unset($status);
           

            ++$jj;
        }
        unset($servDtaResult);
        unset($servDtaData);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Service_center_Report.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

}
