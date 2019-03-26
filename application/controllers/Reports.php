<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
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
        $this->load->model('Reports_model');
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

    // View Sales Report;
    public function sales_report()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

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
        $data['site_currency'] = $siteSetting_currency;
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
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_sale_id'] = $this->lang->line('sale_id');
        $data['lang_tax_total'] = $this->lang->line('tax_total');
        $data['lang_export_to_excel'] = $this->lang->line('export_to_excel');
        $data['lang_type'] = $this->lang->line('type');
        $data['lang_print'] = $this->lang->line('print');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_previous_sales'] = $this->lang->line('previous_sales');
        $data['lang_customer'] = $this->lang->line('customer');
        $data['lang_per_item_price'] = $this->lang->line('per_item_price');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_date'] = $this->lang->line('date');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_quantity'] = $this->lang->line('quantity');

        $data['lang_all_outlets'] = $this->lang->line('all_outlets');
        $data['lang_choose_outlet'] = $this->lang->line('choose_outlet');
        $data['lang_choose_paid_by'] = $this->lang->line('choose_paid_by');
        $data['lang_all'] = $this->lang->line('all');
        $data['lang_start_date'] = $this->lang->line('start_date');
        $data['lang_end_date'] = $this->lang->line('end_date');
        $data['lang_get_report'] = $this->lang->line('get_report');

        $data['lang_report_details'] = $this->lang->line('report_details');
        $data['lang_promotion'] = $this->lang->line('promotion');
        $data['lang_margin_80'] = $this->lang->line('margin_80');
        $data['lang_margin_20'] = $this->lang->line('margin_20');


        $data['lang_gross_sales'] = $this->lang->line('gross_sales');
        $data['lang_net_sales'] = $this->lang->line('net_sales');

        $this->load->view('sales_report', $data);
    }


    public function report_details()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

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
        $data['site_currency'] = $siteSetting_currency;
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
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_sale_id'] = $this->lang->line('sale_id');
        $data['lang_tax_total'] = $this->lang->line('tax_total');
        $data['lang_export_to_excel'] = $this->lang->line('export_to_excel');
        $data['lang_type'] = $this->lang->line('type');
        $data['lang_print'] = $this->lang->line('print');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_previous_sales'] = $this->lang->line('previous_sales');
        $data['lang_customer'] = $this->lang->line('customer');
        $data['lang_per_item_price'] = $this->lang->line('per_item_price');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_date'] = $this->lang->line('date');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_quantity'] = $this->lang->line('quantity');

        $data['lang_all_outlets'] = $this->lang->line('all_outlets');
        $data['lang_choose_outlet'] = $this->lang->line('choose_outlet');
        $data['lang_choose_paid_by'] = $this->lang->line('choose_paid_by');
        $data['lang_all'] = $this->lang->line('all');
        $data['lang_start_date'] = $this->lang->line('start_date');
        $data['lang_end_date'] = $this->lang->line('end_date');
        $data['lang_get_report'] = $this->lang->line('get_report');

        $data['lang_report_details'] = $this->lang->line('report_details');
        $data['lang_promotion'] = $this->lang->line('promotion');
        $data['lang_report_details'] = $this->lang->line('report_details');

        $data['lang_product_category'] = $this->lang->line('product_category');

        $this->load->view('report_details', $data);
    }
    

    // ****************************** View Page -- END ****************************** //

    // ****************************** Export Excel -- START ****************************** //
    public function exportSalesReport()
    {
        $report = $this->input->get('report');
        $url_start = $this->input->get('start_date');
        $url_end = $this->input->get('end_date');
        $url_outlet = $this->input->get('outlet');
        $url_paid_by = $this->input->get('paid');

        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

        $this->load->library('excel');

        require_once './application/third_party/PHPExcel.php';
        require_once './application/third_party/PHPExcel/IOFactory.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Settingan awal file excel
		 $objPHPExcel->getProperties()->setCreator('Eryan Fauzan')
         ->setLastModifiedBy('Eryan Fauzan')
         ->setTitle("POS Galuh Mas")
         ->setSubject("POS Galuh Mas")
         ->setDescription("Created By Eryan Fauzan")
         ->setKeywords("POS Galuh Mas");

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

        $lang_sales_report = $this->lang->line('sales_report');
        $lang_date = $this->lang->line('date');
        $lang_sale_id = $this->lang->line('sale_id');
        $lang_type = $this->lang->line('type');
        $lang_outlet_name = $this->lang->line('outlet_name');
        $lang_cust_name = $this->lang->line('customer_name');
        $lang_total_items = $this->lang->line('total_items');
        $lang_sub_total = $this->lang->line('sub_total');
        $lang_tax = $this->lang->line('tax');
        $lang_grand_total = $this->lang->line('grand_total');
        $lang_total = $this->lang->line('total');
        $lang_payment = $this->lang->line('payment');

        $lang_discount = $this->lang->line('discount');
        $lang_promotion = $this->lang->line('promotion');
        $lang_margin_80 = $this->lang->line('margin_80');
        $lang_margin_20 = $this->lang->line('margin_20');
        $lang_gross_sales = $this->lang->line('gross_sales');
        $lang_net_sales = $this->lang->line('net_sales');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "$lang_sales_report");

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
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
   

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "$lang_date");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "$lang_type");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "$lang_sale_id");        
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "$lang_outlet_name");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "$lang_payment");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "$lang_promotion");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "$lang_gross_sales ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "$lang_discount ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('I2', "$lang_net_sales ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('J2', "$lang_tax ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('K2', "$lang_grand_total ($site_currency)");

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
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $total_sub_amt = 0;
        $total_tax_amt = 0;
        $total_grand_amt = 0;

        $start_date = $url_start.' 00:00:00';
        $end_date = $url_end.' 23:59:59';

        $paid_sort = '';
        if ($url_paid_by == '-') {
            $paid_sort = ' AND payment_method > 0 ';
        } else {
            $paid_sort = " AND payment_method = '$url_paid_by' ";
        }

        $outlet_sort = '';
        if ($url_outlet == '-') {
            $outlet_sort = ' AND outlet_id > 0 ';
        } else {
            $outlet_sort = " AND outlet_id = '$url_outlet' ";
        }

        $orderResult = $this->db->query("SELECT o.id,
        o.ordered_datetime,o.customer_name,o.customer_mobile,o.outlet_id,o.subtotal,o.discount_total,o.tax,o.grandtotal,
        o.payment_method,o.payment_method_name,o.paid_amt,o.return_change,o.cheque_number, o.discount_total,
        o.discount_percentage,o.outlet_name,o.outlet_address,o.outlet_contact,
        o.gift_card,o.card_number,o.outlet_receipt_footer,o.status,p.promotion_name,p.discount_percentage
        FROM orders as o 
        INNER JOIN promotion as p ON o.promo_id = p.id
        WHERE o.ordered_datetime >= '$start_date' AND o.ordered_datetime <= '$end_date' $paid_sort $outlet_sort 
        ORDER BY o.ordered_datetime DESC");
        $orderRows = $orderResult->num_rows();
        if ($orderRows > 0) {
            $orderData = $orderResult->result();
            for ($od = 0; $od < count($orderData); ++$od) {
                $order_id = $orderData[$od]->id;
                $order_dtm = date("$site_dateformat H:i", strtotime($orderData[$od]->ordered_datetime));            
                $outlet_id = $orderData[$od]->outlet_id;
                $subTotal = $orderData[$od]->subtotal;
                $promotion_name = $orderData[$od]->promotion_name;
                $discount_percentage = $orderData[$od]->discount_percentage;
                $discount_total = $orderData[$od]->discount_total;
                $tax = $orderData[$od]->tax;
                $grandTotal = $orderData[$od]->grandtotal;
                $pay_method_id = $orderData[$od]->payment_method;
                $cheque_numb = $orderData[$od]->cheque_number;
                $outlet_name = $orderData[$od]->outlet_name;
                $payment_method_name = $orderData[$od]->payment_method_name;
                $order_type = $orderData[$od]->status;
                $gross_sales = $subTotal + $discount_total;
                $type_name = '';
                if ($order_type == '1') {
                    $type_name = 'Sale';
                } elseif ($order_type == '2') {
                    $type_name = 'Return';
                }

                if (!empty($cheque_numb)) {
                    $payment_method_name = $payment_method_name." (Cheque No. : $cheque_numb)";
                }

                $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$order_dtm");
                $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$type_name");
                $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$order_id");
                $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$outlet_name");
                $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$payment_method_name");
                $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$promotion_name");
                $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$gross_sales");
                if ($discount_total == 0 ){
                    $dis_amt = " ";
                }else{
                    $dis_amt = "-".$discount_total;                   
                }
                $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$dis_amt"); 
                $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$subTotal");
                $objPHPExcel->getActiveSheet()->setCellValue("J$jj", "$tax");
                $objPHPExcel->getActiveSheet()->setCellValue("K$jj", "$grandTotal");

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
                $objPHPExcel->getActiveSheet()->getStyle("K$jj")->applyFromArray($account_value_style_header);

                $total_sub_amt += $subTotal;
                $total_tax_amt += $tax;
                $total_grand_amt += $grandTotal;

                unset($order_dtm);
                unset($type_name);
                unset($order_id);
                unset($outlet_name);
                unset($payment_method_name);
                unset($promotion_name);
                unset($discount_total);
                unset($dis_amt);
                unset($subTotal);
                unset($tax);
                unset($grandTotal);

                ++$jj;
            }
            unset($orderData);
        }
        unset($orderResult);
        unset($orderRows);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:F$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$lang_total");
        $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "=SUM(G3:G".($jj-1).")");
        $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "=SUM(H3:H".($jj-1).")");
        $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "=SUM(I3:I".($jj-1).")");
        $objPHPExcel->getActiveSheet()->setCellValue("J$jj", "=SUM(J3:J".($jj-1).")");
        $objPHPExcel->getActiveSheet()->setCellValue("K$jj", "=SUM(K3:K".($jj-1).")");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("J$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("K$jj")->applyFromArray($style_header);
       

        $kk=$jj+1;
         $margin20 = $total_sub_amt*0.2;
         $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$kk:H$kk");       
         $objPHPExcel->getActiveSheet()->setCellValue("A$kk", "$lang_margin_20");       
         $objPHPExcel->getActiveSheet()->setCellValue("I$kk", "=SUM(I3:I".($kk-2).")*0.2");
         $objPHPExcel->getActiveSheet()->getStyle("A$kk")->applyFromArray($text_align_style);
         $objPHPExcel->getActiveSheet()->getStyle("B$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("C$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("D$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("E$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("F$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("G$kk")->applyFromArray($style_header);        
         $objPHPExcel->getActiveSheet()->getStyle("H$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("I$kk")->applyFromArray($style_header);
         
         
         $ll=$jj+2;
         $margin80 = $total_sub_amt*0.8;
         $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$ll:H$ll");       
         $objPHPExcel->getActiveSheet()->setCellValue("A$ll", "$lang_margin_80");       
         $objPHPExcel->getActiveSheet()->setCellValue("I$ll", "=SUM(I3:I".($ll-3).")*0.8");
         $objPHPExcel->getActiveSheet()->getStyle("A$ll")->applyFromArray($text_align_style);
         $objPHPExcel->getActiveSheet()->getStyle("B$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("C$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("D$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("E$ll")->applyFromArray($style_header);  
         $objPHPExcel->getActiveSheet()->getStyle("F$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("G$ll")->applyFromArray($style_header);        
         $objPHPExcel->getActiveSheet()->getStyle("H$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("I$ll")->applyFromArray($style_header);
      

        $objPHPExcel->getActiveSheet()->getRowDimension("$ll")->setRowHeight(30);

        // Redirect output to a client’s web browser (Excel2007)        

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         /*header('Content-Disposition: attachment;filename="Report_Details_'.$date1.'_to_'.$date2.'.xlsx"');*/
        header('Content-Disposition: attachment;filename="Sales_Report_'.$url_start.'_to_'.$url_end.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function exportreport_details()
    {  
        $date1 = date('d-m-Y', strtotime(strip_tags($this->input->post('start_date'))));
        $date2 = date('d-m-Y', strtotime(strip_tags($this->input->post('end_date'))));


        $start_date = date('Y-m-d 00:00:00', strtotime(strip_tags($this->input->post('start_date'))));
        $end_date = date('Y-m-d 23:59:59', strtotime(strip_tags($this->input->post('end_date'))));

        $category_tenant= strip_tags($this->input->post('category'));
       
         $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
         $site_dateformat = $siteSettingData[0]->datetime_format;
         $site_currency = $siteSettingData[0]->currency;
 
         //Ubah Disini
         /*$custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', "$cust_id");
         $cust_fn = $custDtaData[0]->fullname;*/
 
         $this->load->library('excel');
 
         require_once './application/third_party/PHPExcel.php';
         require_once './application/third_party/PHPExcel/IOFactory.php';
 
         // Create new PHPExcel object
         $objPHPExcel = new PHPExcel();

         // Settingan awal file excel
		 $objPHPExcel->getProperties()->setCreator('Eryan Fauzan')
                    ->setLastModifiedBy('Eryan Fauzan')
                    ->setTitle("POS Galuh Mas")
                    ->setSubject("POS Galuh Mas")
                    ->setDescription("Created By Eryan Fauzan")
                    ->setKeywords("POS Galuh Mas");
 
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
 
         $lang_sales_history = $this->lang->line('sales_history');
         $lang_sale_id = $this->lang->line('sale_id');
         $lang_type = $this->lang->line('type');
         $lang_date_time = $this->lang->line('date_time');
         $lang_products = $this->lang->line('products');
         $lang_qty = $this->lang->line('quantity');
         $lang_total_qty = $this->lang->line('total_quantity');
         $lang_sub_total = $this->lang->line('sub_total');
         $lang_tax = $this->lang->line('tax');
         $lang_grand_total = $this->lang->line('grand_total');
         $lang_total = $this->lang->line('total');
         $lang_price = $this->lang->line('price');

         $lang_product_category = $this->lang->line('product_category');
         $lang_discount = $this->lang->line('discount');
         $lang_promotion = $this->lang->line('promotion');
         $lang_margin_80 = $this->lang->line('margin_80');
         $lang_margin_20 = $this->lang->line('margin_20');
         $lang_gross_sales = $this->lang->line('gross_sales');
         $lang_net_sales = $this->lang->line('net_sales');
 
         $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1');
         $objPHPExcel->getActiveSheet()->setCellValue('A1', "Report Details POS Galuh Mas");
 
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
         $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
         $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($top_header_style);
         $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($top_header_style);
        
         $objPHPExcel->getActiveSheet()->setCellValue('A2', "$lang_date_time");
         $objPHPExcel->getActiveSheet()->setCellValue('B2', "$lang_type");
         $objPHPExcel->getActiveSheet()->setCellValue('C2', "$lang_sale_id");
         $objPHPExcel->getActiveSheet()->setCellValue('D2', "$lang_promotion");         
         $objPHPExcel->getActiveSheet()->setCellValue('E2', "$lang_product_category");
         $objPHPExcel->getActiveSheet()->setCellValue('F2', "$lang_products");
         $objPHPExcel->getActiveSheet()->setCellValue('G2', "$lang_qty");
         $objPHPExcel->getActiveSheet()->setCellValue('H2', "$lang_price ($site_currency)");
         $objPHPExcel->getActiveSheet()->setCellValue('I2', "$lang_gross_sales ($site_currency)");
         $objPHPExcel->getActiveSheet()->setCellValue('J2', "$lang_discount ($site_currency)");
         $objPHPExcel->getActiveSheet()->setCellValue('K2', "$lang_net_sales ($site_currency)");
         $objPHPExcel->getActiveSheet()->setCellValue('L2', "$lang_tax ($site_currency)");
         $objPHPExcel->getActiveSheet()->setCellValue('M2', "$lang_grand_total ($site_currency)");
 
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
         $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($style_header);
        
 
         $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
         $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
         $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
         $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
 
         $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
 
         $jj = 3;
 
         $total_sub_amt = 0;
         $total_tax_amt = 0;
         $total_grand_amt = 0;
         
        if ($category_tenant=="all"){
            $orderResult = $this->db->query("SELECT o.id, o.customer_id,o.customer_name,o.customer_email,o.customer_mobile,o.ordered_datetime,o.outlet_id,o.outlet_name,o.outlet_address,o.outlet_contact,o.outlet_receipt_footer,      
                        o.gift_card,o.subtotal,o.discount_total,o.discount_percentage,o.promo_id,o.tax,o.grandtotal,o.total_items,o.payment_method,o.payment_method_name,o.cheque_number,o.paid_amt,
                        o.return_change,o.created_user_id,o.created_datetime,o.updated_user_id,o.updated_datetime,o.vt_status,o.status,
                        o.refund_status,o.remark,o.card_number, oi.price as harga, oi.qty as qty, p.promotion_name
                        FROM orders  as o 
                        LEFT JOIN return_items as r on o.id = r.order_id                    
                        LEFT JOIN order_items as oi ON o.id = oi.order_id 
                        LEFT JOIN category as c on oi.product_category = c.id OR r.product_category = c.id
                        LEFT JOIN promotion as p on o.promo_id = p.id
                        WHERE o.ordered_datetime >= '$start_date'  AND o.ordered_datetime <= '$end_date'
                        GROUP BY o.id
                        ORDER BY o.id DESC");
                        $orderData = $orderResult->result();    
        }else {
                $orderResult = $this->db->query("SELECT o.id, o.customer_id,o.customer_name,o.customer_email,o.customer_mobile,o.ordered_datetime,o.outlet_id,o.outlet_name,o.outlet_address,o.outlet_contact,o.outlet_receipt_footer,      
                        o.gift_card,o.subtotal,o.discount_total,o.discount_percentage,o.promo_id,o.tax,o.grandtotal,o.total_items,o.payment_method,o.payment_method_name,o.cheque_number,o.paid_amt,
                        o.return_change,o.created_user_id,o.created_datetime,o.updated_user_id,o.updated_datetime,o.vt_status,o.status,
                        o.refund_status,o.remark,o.card_number, oi.price as harga, oi.qty as qty, p.promotion_name
                        FROM orders  as o 
                        LEFT JOIN return_items as r on o.id = r.order_id                    
                        LEFT JOIN order_items as oi ON o.id = oi.order_id 
                        LEFT JOIN category as c on oi.product_category = c.id OR r.product_category = c.id
                        LEFT JOIN promotion as p on o.promo_id = p.id
                        WHERE o.ordered_datetime >= '$start_date'  AND o.ordered_datetime <= '$end_date' AND c.id = '$category_tenant'
                        GROUP BY o.id
                        ORDER BY o.id DESC");
                        $orderData = $orderResult->result();            
        }
         for ($d = 0; $d < count($orderData); ++$d) {
             $order_id = $orderData[$d]->id;
             $ordered_dtm = date("$site_dateformat H:i A", strtotime($orderData[$d]->ordered_datetime));             
             $gstTotal = $orderData[$d]->tax;
             $grandTotal = $orderData[$d]->grandtotal;
             //$total_item_qty = $orderData[$d]->join_qty;
            
             //$subtot = $orderData[$d]->subtotal;
             $order_type = $orderData[$d]->status;
             $subTotal = $orderData[$d]->harga * $orderData[$d]->qty; 
             $total_sub_amt += $subTotal;
             /*$total_tax_amt += $gstTotal;
             $total_grand_amt += $grandTotal; untuk yang dubawah*/
            
            
 
             $pcodeArray = array();
             $pnameArray = array();
             $qtyArray = array();
             $priceArray = array();
             $subtotalArray = array();
             $taxArray = array();
             $grandtotalArray = array();
             $grossArray = array();
             $promotionArray = array();
             $categoryArray = array();
             $discountArray = array();
             $type_name = '';
 
             if ($order_type == '1') {                // Order;
 
                 $type_name = 'Sale';                

                if ($category_tenant=="all"){
                    $oItemResult = $this->db->query("SELECT oi.id, oi.order_id, oi.product_code, oi.product_name,oi.cost, oi.price, oi.qty, o.discount_percentage,c.name as tenant,c.id, p.promotion_name
                    FROM order_items as oi 
                    LEFT JOIN orders as o on o.id = oi.order_id 
                    LEFT JOIN category as c ON oi.product_category = c.id
                    LEFT JOIN promotion as p on p.id = o.promo_id
                    WHERE order_id = '$order_id'  ORDER BY oi.id ");                    
                }else{
                    $oItemResult = $this->db->query("SELECT oi.id, oi.order_id, oi.product_code, oi.product_name,oi.cost, oi.price, oi.qty, o.discount_percentage,c.name as tenant,c.id, p.promotion_name
                    FROM order_items as oi 
                    LEFT JOIN orders as o on o.id = oi.order_id 
                    LEFT JOIN category as c ON oi.product_category = c.id
                    LEFT JOIN promotion as p on p.id = o.promo_id
                    WHERE order_id = '$order_id' AND c.id = '$category_tenant'  ORDER BY oi.id"
                    );
                }
                 $oItemRows = $oItemResult->num_rows();
                 if ($oItemRows > 0) {
                     $oItemData = $oItemResult->result();
 
                     for ($t = 0; $t < count($oItemData); ++$t) {
                         $oItem_pcode = $oItemData[$t]->product_code;
                         $oItem_promotion = $oItemData[$t]->promotion_name;
                         $oItem_discount = $oItemData[$t]->discount_percentage;   
                         $oItem_cname = $oItemData[$t]->tenant;
                         $oItem_pname = $oItemData[$t]->product_name;
                         $oItem_qty = $oItemData[$t]->qty;
                         $oItem_price = $oItemData[$t]->price;

                        if ($oItem_discount == 0) {
                            $oItem_dis_amt = 0;
                        } elseif (strpos($oItem_discount, '%') > 0) {
                            $temp_dis_Array= explode('%', $oItem_discount);                    
                            $temp_dis = $temp_dis_Array[0];                            
                            $temp_item_price = 0;  
                            $oItem_dis_amt=0;                        
                            $oItem_dis_amt = "-".($oItem_price * ($temp_dis / 100) * $oItemData[$t]->qty);
                        }else{
                            $oItem_dis_amt = $oItem_discount;
                        }
                         
                         $oItem_gross = ($oItemData[$t]->price * $oItemData[$t]->qty);
                         $oItem_subtotal = ($oItemData[$t]->price * $oItemData[$t]->qty) + $oItem_dis_amt;
                         $oItem_tax = $oItem_subtotal * 0.1;
                         $oItem_grandtotal = $oItem_subtotal + $oItem_tax;       

                         array_push($pcodeArray, $oItem_pcode);
                         array_push($pnameArray, $oItem_pname);
                         array_push($qtyArray, $oItem_qty);
                         array_push($priceArray, $oItem_price);
                         array_push($subtotalArray, $oItem_subtotal);
                         array_push($taxArray, $oItem_tax);
                         array_push($grandtotalArray, $oItem_grandtotal);
                         array_push($grossArray, $oItem_gross);
                         array_push($promotionArray, $oItem_promotion);
                         array_push($categoryArray, $oItem_cname);
                         array_push($discountArray, $oItem_dis_amt);   
 
                         unset($oItem_pcode);
                         unset($oItem_pname);
                         unset($oItem_qty);
                         unset($oItem_price);
                         unset($oItem_subtotal);
                         unset($oItem_tax);
                         unset($oItem_grandtotal);
                         unset($oItem_gross);
                         unset($oItem_promotion);
                         unset($oItem_cname);
                         unset($oItem_discount);
                     }
 
                     unset($oItemData);
                 }
                 unset($oItemResult);
                 unset($oItemRows);
             } elseif ($order_type == '2') {    // Return;
                 $type_name = 'Return';
                 if ($category_tenant=="all"){
                    $rItemResult = $this->db->query("SELECT r.id, r.order_id, r.product_code, r.product_name,r.cost, r.price, r.qty, c.name as tenant, c.id
                 FROM return_items as r 
                 LEFT JOIN category as c ON r.product_category = c.id
                 WHERE order_id = '$order_id' ORDER BY r.id ");
                 }
                   else{
                    $rItemResult = $this->db->query("SELECT r.id, r.order_id, r.product_code, r.product_name,r.cost, r.price, r.qty, c.name as tenant, c.id
                 FROM return_items as r 
                 LEFT JOIN category as c ON r.product_category = c.id
                 WHERE order_id = '$order_id' AND c.id = '$category_tenant' ORDER BY r.id ");
                 }
                 
                 $rItemRows = $rItemResult->num_rows();
                 if ($rItemRows > 0) {
                     $rItemData = $rItemResult->result();
 
                     for ($r = 0; $r < count($rItemData); ++$r) {
                         $rItem_pcode = $rItemData[$r]->product_code;
                         $rItem_pname = $rItemData[$r]->product_name;
                         $rItem_cname = $rItemData[$r]->tenant;
                         $rItem_qty = $rItemData[$r]->qty;
                         $rItem_price = $rItemData[$r]->price;
                         $rItem_gross = $rItemData[$r]->price * $rItemData[$r]->qty;
                         $rItem_subtotal = $rItemData[$r]->price * $rItemData[$r]->qty;
                         $rItem_tax = $rItem_subtotal * 0.1;
                         $rItem_grandtotal = $rItem_subtotal + $rItem_tax;

 
                         array_push($pcodeArray, $rItem_pcode);
                         array_push($pnameArray, $rItem_pname);
                         array_push($qtyArray, $rItem_qty);
                         array_push($priceArray, $rItem_price);
                         array_push($subtotalArray, $rItem_subtotal);
                         array_push($taxArray, $rItem_tax);
                         array_push($grandtotalArray, $rItem_grandtotal);
                         array_push($grossArray, $rItem_gross);
                         array_push($categoryArray, $rItem_cname);

 
                         unset($rItem_pcode);
                         unset($rItem_pname);
                         unset($rItem_qty);
                         unset($rItem_price);
                         unset($rItem_gross);
                         unset($rItem_subtotal);
                         unset($rItem_tax);
                         unset($rItem_grandtotal);
                         unset($rItem_cname);
                     }
 
                     unset($rItemData);
                 }
                 unset($rItemResult);
                 unset($rItemRows);
             }

             $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$ordered_dtm");
             $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$type_name");
             $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$order_id");             
             
            if (count($promotionArray) > 0) {
                $f_promotion = '';
                $f_promotion = $promotionArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$f_promotion");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("D$jj", '');
            }
            if (count($categoryArray) > 0) {
                $f_category = '';
                $f_category = $categoryArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$f_category");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("E$jj", '');
            }

             if (count($pcodeArray) > 0) {
                 $f_pcode = '';
                 $f_pcode = $pnameArray[0].' ['.$pcodeArray[0].']';
                 $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$f_pcode");
             } else {
                 $objPHPExcel->getActiveSheet()->setCellValue("F$jj", '');
             }

             if (count($qtyArray) > 0) {
                 $f_qty = '';
                 $f_qty = $qtyArray[0];
                 $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$f_qty");
             } else {
                 $objPHPExcel->getActiveSheet()->setCellValue("G$jj", '');
             }
             
             if (count($priceArray) > 0) {
                $f_price = '';
                $f_price = $priceArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$f_price");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("H$jj", '');
            }


            if (count($grossArray) > 0) {
                $f_gross = '';
                $f_gross = $grossArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$f_gross");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("I$jj", '');
            }

            if (count($discountArray) > 0) {
                $f_discount = '';
                $f_discount = $discountArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("J$jj", "$f_discount");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("J$jj", '');
            }

            if (count($subtotalArray) > 0) {
                $f_subtotal = '';
                $f_subtotal = $subtotalArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("K$jj", "$f_subtotal");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("K$jj", '');
            }

            if (count($taxArray) > 0) {
                $f_tax = '';
                $f_tax = $taxArray[0];
                $objPHPExcel->getActiveSheet()->setCellValue("L$jj", "$f_tax");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("L$jj", '');
            }

            if (count($grandtotalArray) > 0) {
                $f_grandtotal = '';
                $f_grandtotal = $grandtotalArray [0];
                $objPHPExcel->getActiveSheet()->setCellValue("M$jj", "$f_grandtotal");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("M$jj", '');
            }
            //$objPHPExcel->getActiveSheet()->setCellValue("M$jj", "$subtot");  
            //$objPHPExcel->getActiveSheet()->setCellValue("N$jj", "$inputs");  
                         
 
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
             $objPHPExcel->getActiveSheet()->getStyle("K$jj")->applyFromArray($account_value_style_header);
             $objPHPExcel->getActiveSheet()->getStyle("L$jj")->applyFromArray($account_value_style_header);
             $objPHPExcel->getActiveSheet()->getStyle("M$jj")->applyFromArray($account_value_style_header);
 
             ++$jj;
 
             if (count($pcodeArray) > 1) {
                 for ($p = 1; $p < count($pcodeArray); ++$p) {
                     $s_pcode = '';
                     $s_qty = '';
                     $s_price = '';
                     $s_subtotal = '';
                     $s_tax = '';
                     $s_grandtotal ='';
                     $s_gross = '';
                     $s_promotion ='';
                     $s_category ='';
                     $s_discount ='';

                     $s_pcode = $pnameArray[$p].' ['.$pcodeArray[$p].']';
                     $s_qty = $qtyArray[$p];
                     $s_price = $priceArray[$p];
                     $s_subtotal = $subtotalArray[$p];
                     $s_tax = $taxArray[$p];
                     $s_grandtotal = $grandtotalArray[$p];
                     $s_gross = $grossArray[$p];
                     $s_promotion = $promotionArray[$p];
                     $s_category = $categoryArray[$p];
                     $s_discount = $discountArray[$p];

                     $objPHPExcel->getActiveSheet()->setCellValue("A$jj", '');
                     $objPHPExcel->getActiveSheet()->setCellValue("B$jj", '');
                     $objPHPExcel->getActiveSheet()->setCellValue("C$jj", '');
                     $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$s_promotion");
                     $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$s_category");
                     $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$s_pcode");
                     $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$s_qty");
                     $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$s_price");
                     $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$s_gross");
                     $objPHPExcel->getActiveSheet()->setCellValue("J$jj", "$s_discount");
                     $objPHPExcel->getActiveSheet()->setCellValue("K$jj", "$s_subtotal");
                     $objPHPExcel->getActiveSheet()->setCellValue("L$jj", "$s_tax");
                     $objPHPExcel->getActiveSheet()->setCellValue("M$jj", "$s_grandtotal");
 
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
                     $objPHPExcel->getActiveSheet()->getStyle("K$jj")->applyFromArray($account_value_style_header);
                     $objPHPExcel->getActiveSheet()->getStyle("L$jj")->applyFromArray($account_value_style_header);
                     $objPHPExcel->getActiveSheet()->getStyle("M$jj")->applyFromArray($account_value_style_header);
 
                     ++$jj;
                 }
             }
 
             unset($order_id);
             unset($ordered_dtm);
             unset($subTotal);
             unset($gstTotal);
             unset($grandTotal);
            // unset($total_item_qty);
         }
         unset($orderResult);
         unset($orderData);
 
        /* $total_sub_amt = number_format($total_sub_amt, 2, '.', '');
         $total_tax_amt = number_format($total_tax_amt, 2, '.', '');
         $total_grand_amt = number_format($total_grand_amt, 2, '.', '');*/
 
         $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:F$jj");
         $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$lang_total");
     
         $objPHPExcel->getActiveSheet()->SetCellValue('G'.$jj, "=SUM(G3:G".($jj-1).")");  
         $objPHPExcel->getActiveSheet()->SetCellValue('I'.$jj, "=SUM(I3:I".($jj-1).")");          
         $objPHPExcel->getActiveSheet()->SetCellValue('J'.$jj, "=SUM(J3:J".($jj-1).")");  
         $objPHPExcel->getActiveSheet()->SetCellValue('K'.$jj, "=SUM(K3:K".($jj-1).")");  
         $objPHPExcel->getActiveSheet()->SetCellValue('L'.$jj, "=SUM(L3:L".($jj-1).")"); 
         $objPHPExcel->getActiveSheet()->SetCellValue('M'.$jj, "=SUM(M3:M".($jj-1).")");       
         
         //$objPHPExcel->getActiveSheet()->setCellValue("H$jj", number_format($total_tax_amt));
         //$objPHPExcel->getActiveSheet()->setCellValue("I$jj", number_format($total_grand_amt));         
         
         $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
         $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("J$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("K$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("L$jj")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("M$jj")->applyFromArray($style_header);

         $kk=$jj+1;
        // $margin20 = $total_sub_amt *0.2;
         $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$kk:J$kk");       
         $objPHPExcel->getActiveSheet()->setCellValue("A$kk", "$lang_margin_20");
         $objPHPExcel->getActiveSheet()->SetCellValue('K'.$kk, "=SUM(K3:K".($kk-2).")*0.2");        
         //$objPHPExcel->getActiveSheet()->setCellValue("G$kk", number_format($margin20));
         $objPHPExcel->getActiveSheet()->getStyle("A$kk")->applyFromArray($text_align_style);
         $objPHPExcel->getActiveSheet()->getStyle("B$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("C$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("D$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("E$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("F$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("G$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("H$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("I$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("J$kk")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("K$kk")->applyFromArray($style_header);        

         $ll=$jj+2;
         //$margin80 = $total_sub_amt *0.8;

         $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$ll:J$ll");       
         $objPHPExcel->getActiveSheet()->setCellValue("A$ll", "$lang_margin_80"); 
         $objPHPExcel->getActiveSheet()->SetCellValue('K'.$ll, "=SUM(K3:K".($ll-3).")*0.8");         
         //$objPHPExcel->getActiveSheet()->setCellValue("G$ll", number_format($margin80));
         $objPHPExcel->getActiveSheet()->getStyle("A$ll")->applyFromArray($text_align_style);
         $objPHPExcel->getActiveSheet()->getStyle("B$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("C$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("D$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("E$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("F$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("G$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("H$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("I$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("J$ll")->applyFromArray($style_header);
         $objPHPExcel->getActiveSheet()->getStyle("K$ll")->applyFromArray($style_header);

         
 
         $objPHPExcel->getActiveSheet()->getRowDimension("$ll")->setRowHeight(30);
 
         // Redirect output to a client’s web browser (Excel5)
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="Report_Details_'.$date1.'_to_'.$date2.'_tenant_'.$category_tenant.'.xlsx"');
         header('Cache-Control: max-age=0');
         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
         $objWriter->save('php://output');
    }

    // ****************************** Export Excel -- END ****************************** //
}
