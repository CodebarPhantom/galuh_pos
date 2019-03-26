<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Promotion extends CI_Controller
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
        $this->load->model('Promotion_model');
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

    // View Customers;
    public function view()
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
        $config['base_url'] = base_url().'promotion/view/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Promotion_model->record_promotion_count();
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

        $data['results'] = $this->Promotion_model->fetch_promotion_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Promotion_model->record_promotion_count();

            $start_pg_point = 0;
            if ($have_count == 0) {
                $start_pg_point = 0;
            } else {
                $start_pg_point = 1;
            }

            $sh_text = "Showing $start_pg_point to ".count($data['results']).' of '.$this->Promotion_model->record_promotion_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Promotion_model->record_promotion_count().' entries';
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
        $data['lang_report_details'] = $this->lang->line('report_details');

        $data['lang_sales_history'] = $this->lang->line('sales_history');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');
        $data['lang_promotion'] = $this->lang->line('promotion');
        $data['lang_active']= $this->lang->line('active');
        $data['lang_inactive']= $this->lang->line('inactive');

        $this->load->view('promotion', $data);
    }

    // Edit Customer;
    public function edit_promotion()
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

        $promo_id = $this->input->get('promo_id');
        $data['promo_id'] = $promo_id;

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
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_edit_promotion'] =$this->lang->line('edit_promotion');
        $data['lang_promotion_name'] = $this->lang->line('promotion_name');
        $data['lang_actived_promotion'] = $this->lang->line('actived_promotion');
        $data['lang_deactived_promotion']= $this->lang->line('deactived_promotion');
        $data['lang_delete_promotion']= $this->lang->line('delete_promotion');

        $data['lang_active']= $this->lang->line('active');
        $data['lang_inactive']= $this->lang->line('inactive');
        $this->load->view('edit_promotion', $data);
    }

     
    // Add Promotion;
    public function addPromotion()
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

        $this->load->view('add_promotion', $data);
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
    public function insertPromotion()
    {
        $promotion_name = $this->input->post('promotion_name');
        $discount = $this->input->post('discount');
        $start_date = date('Y-m-d', strtotime(strip_tags($this->input->post('start_date'))));
        $end_date = date('Y-m-d', strtotime(strip_tags($this->input->post('end_date'))));
       

        //$us_id = $this->session->userdata('user_id');
        //$tm = date('Y-m-d H:i:s', time());

        if (empty($promotion_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Promotion', 'Please enter Promotion Name!'));
            redirect(base_url().'promotion/addPromotion');
        }else if (empty($discount)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Promotion', 'Please enter Discount!'));
            redirect(base_url().'promotion/addPromotion');
        }else if (empty($start_date)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Promotion', 'Please enter Actived Date'));
            redirect(base_url().'promotion/addPromotion');
        }else if (empty($end_date)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Promotion', 'Please enter Deactived Date'));
            redirect(base_url().'promotion/addPromotion');
        }else {            

            $ins_promo_data = array(
                      'promotion_name' => $promotion_name,
                      'discount_percentage' => $discount,
                      'actived_datetime' => $start_date,
                      'deactived_datetime' => $end_date, 
                      'status'=>'1'
                      
            );
            if ($this->Constant_model->insertData('promotion', $ins_promo_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add Promotion', "Successfully Added Promotion : $promotion_name"));
                redirect(base_url().'promotion/addPromotion');
            }
        }
    }

    public function updatePromotion()
    {
        $promo_id = $this->input->post('promo_id');
        $promotion_name = $this->input->post('promotion_name');
        $discount = $this->input->post('discount');
        $start_date = date('Y-m-d', strtotime(strip_tags($this->input->post('start_date'))));
        $end_date = date('Y-m-d', strtotime(strip_tags($this->input->post('end_date'))));
        $status = $this->input->post('status');

        $upd_data = array(
            'promotion_name' => $promotion_name,
            'discount_percentage' => $discount,
            'actived_datetime' => $start_date,
            'deactived_datetime' => $end_date,
            'status' => $status
            
            //'status'=>1
        );
        $this->Promotion_model->updateData('promotion', $upd_data, $promo_id);

        $this->session->set_flashdata('alert_msg', array('success', 'Update Promotion', 'Successfully Updated Promotion Detail!'));
        redirect(base_url().'promotion/edit_promotion?promo_id='.$promo_id);
    }

    // ****************************** Action To Database -- END ****************************** //

}
