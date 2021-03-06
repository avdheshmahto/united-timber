<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
class Report extends my_controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('model_report');
    }
    
    
    
    function report_function()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('open-page-report');
        } else {
            redirect('index');
        }
        
    }
    
    function frequency_details_machine()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('frequency-machine-spares');
        } else {
            redirect('index');
        }
        
    }
    
    
    function frequency_details_section()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('frequency-section-spares');
        } else {
            redirect('index');
        }
        
    }
    
    //***************************************************************************
    
    function currentStock()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageStockJoinfun();
            $this->load->view('current-stock-type', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageStockJoinfun()
    {
        
        $table_name     = 'tbl_master_data';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/currentStock?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_ProductType($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/currentStock?entries=' . $_GET['entries'] . '&type=' . $_GET['type'] . '&filter=' . $_GET['filter']);
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/currentStock?entries=' . $_GET['entries'] . '&type=' . $_GET['type'] . '&filter=' . $_GET['filter']);
        } else {
            $url = site_url('/report/Report/currentStock?');
        }
        
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterProductType($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->product_type_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    //==============================================================
    
    function searchStock()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemJoinfun();
            $this->load->view('current-stock-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageItemJoinfun()
    {
        
        $table_name     = 'tbl_product_stock';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/searchStock?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_allproduct($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/searchStock?entries=' . $_GET['entries'] . '&code=' . $_GET['code'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/searchStock?entries=' . $_GET['entries'] . '&code=' . $_GET['code'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        } else {
            $url = site_url('/report/Report/searchStock?');
        }
        
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterListproduct($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->product_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    //**********************************************************************************
    
    
    function searchReorderLevel()
    {
        
        //extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemJoinfunSearch();
            $this->load->view('minimum-reorder-level-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageItemJoinfunSearch()
    {
        
        $table_name     = 'tbl_product_stock';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/searchReorderLevel?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_allproduct_reorder($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/searchReorderLevel?entries=' . $_GET['entries'] . '&code=' . $_GET['code'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/searchReorderLevel?entries=' . $_GET['entries'] . '&code=' . $_GET['code'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            
            
        } else {
            $url = site_url('/report/Report/searchReorderLevel?');
        }
        
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($_GET['filter'] != "") ////filter start ////
            $data['result'] = $this->model_report->filterListproduct_reorder($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->product_reorder_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    //*******************************************************************************************************
    
    function searchBincard1()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $postlist['searchTemplate'] = $this->model_report->getTemplateSearch($temp_id, $p_name, $f_date, $t_date);
            $this->load->view('template-report', $postlist);
        } else {
            redirect('index');
        }
        
    }
    
    public function searchBincard()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemJoinBincard();
            $this->load->view('bincard-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageItemJoinBincard()
    {
        
        $table_name     = 'tbl_bin_card_hdr';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/searchBincard?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_allbincard($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/searchBincard?entries=' . $_GET['entries'] . '&temp_id=' . $_GET['temp_id'] . '&p_name=' . $_GET['p_name'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/searchBincard?entries=' . $_GET['entries'] . '&temp_id=' . $_GET['temp_id'] . '&p_name=' . $_GET['p_name'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        }
        
        else {
            $url = site_url('/report/Report/searchBincard?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterListbincard($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->bincard_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    //*************************************************************************************************
    
    
    function detailed_workorder()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemlocationrack();
            //$postlist['masterCuttingSearch'] = $this->model_report->getSearchMasterCutting($p_id,$p_name,$f_date,$t_date);
            $this->load->view('detailed-workorder-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    
    public function manageItemlocationrack()
    {
        
        $table_name     = 'tbl_workorder_spare_hdr';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/detailed_workorder?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        $totalData = $this->model_report->count_allDetailedWorkorder($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/detailed_workorder?entries=' . $_GET['entries'] . '&date_range=' . $_GET['date_range'] . '&type=' . $_GET['type'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/detailed_workorder?entries=' . $_GET['entries'] . '&date_range=' . $_GET['date_range'] . '&type=' . $_GET['type'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        }
        
        else {
            $url = site_url('/report/Report/detailed_workorder?');
        }
        
        
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterDetailedWorkorder($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->detailed_workorderGet($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    //*********************************************************************************************************
    
    
    function breakdown_report()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItembreakdown();
            $this->load->view('breakdown-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    function breakdown_workorder()
    {
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('breakdown-workorder');
        } else {
            redirect('index');
        }
    }
    
    public function manageItembreakdown()
    {
        
        $table_name     = 'tbl_machine_breakdown';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/breakdown?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        $totalData = $this->model_report->count_allbreakdown($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/breakdown?entries=' . $_GET['entries'] . '&machine=' . $_GET['machine'] . '&section=' . $_GET['section'] . '&date_range=' . $_GET['date_range'] . '&filter=' . $_GET['filter']);
            
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/breakdown?entries=' . $_GET['entries'] . '&machine=' . $_GET['machine'] . '&section=' . $_GET['section'] . '&date_range=' . $_GET['date_range'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/breakdown?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterListbreakdown($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->breakdown_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    
    
    
    function scheduled_report()
    {
        
        //extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageScheduledJoin();
            $this->load->view('scheduled-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    
    public function manageScheduledJoin()
    {
        
        $table_name     = 'tbl_machine_breakdown';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/scheduled_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        $totalData = $this->model_report->count_allScheduled($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/breakdown?entries=' . $_GET['entries'] . '&machine=' . $_GET['machine'] . '&date_range=' . $_GET['date_range'] . '&filter=' . $_GET['filter']);
            
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/scheduled_report?entries=' . $_GET['entries'] . '&machine=' . $_GET['machine'] . '&date_range=' . $_GET['date_range'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/scheduled_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterListScheduled($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->scheduled_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    
    //***********************************************************************************************************************************************************************************************************
    
    function maintenance_details()
    {
        $this->load->view('maintenance-details');
    }
    
    
    function total_maintenance()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            @extract($_GET);
            $data = $this->Spare_Location_Function();
            $this->load->view("total-maintenance-report", $data);
        } else {
            redirect('index');
        }
        
    }
    
    function Spare_Location_Function()
    {
        
        $table_name     = "tbl_work_order_maintain";
        $data['result'] = "";
        $url            = site_url('report/Report/total_maintenance');
        $sgmnt          = 4;
        $totalData      = $this->model_report->count_allWorkorder($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != '') {
            $showEntries = $_GET['entries'];
            $url         = site_url('report/Report/total_maintenance?entries=' . $_GET['entries'] . 'date_range=' . $_GET['date_range'] . '&section=' . $_GET['section'] . '&machine=' . $_GET['machine']);
        } else
            $showEntries = 10;
        
        if ($_GET['entries'] != '' && $_GET['filter'] == "filter") {
            $url = site_url('report/Report/total_maintenance?entries=' . $_GET['entries'] . 'date_range=' . $_GET['date_range'] . '&section=' . $_GET['section'] . '&machine=' . $_GET['machine'] . '&filter=' . $_GET['filter']);
        } else
            $url = site_url('report/Report/total_maintenance?');
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterWorkorder($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->workorder_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    
    //************************************************************************************************************
    
    function comparison_details_report()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('comparison-details-report', $data);
        } else {
            redirect('index');
        }
    }
    function comparison_report()
    {
        
        extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            //$data = $this->mangeWorkorderCost();
            //$this->load->view('comparison-report',$data);
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('comparison-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    function comparison_section_spares()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('comparison-section-spares');
        } else {
            redirect('index');
        }
    }
    
    
    function comparison_machine_spares()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('compairson-machine-spares');
        } else {
            redirect('index');
        }
    }
    
    public function mangeWorkorderCost()
    {
        
        $table_name     = 'tbl_software_cost_log';
        $data['result'] = "";
        
        ////Pagination start ///
        //$url   = site_url('/report/Report/comparison_report?');
        
        $sgmnt = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_allSoftwareCost($table_name, 'A', $this->input->get());
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/comparison_report?entries=' . $_GET['entries'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/comparison_report?entries=' . $_GET['entries'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
        } else {
            $url = site_url('/report/Report/comparison_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterSoftwareCost($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->getSoftwareCost($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    //*************************************************************************************************************
    
    
    
    public function spare_return()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageSpareReturn();
            $this->load->view('spare-return-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageSpareReturn()
    {
        
        $table_name     = 'tbl_spare_return_hdr';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/spare_return?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_allsparereturn($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/spare_return?entries=' . $_GET['entries'] . '&po_no=' . $_GET['po_no'] . '&p_name=' . $_GET['p_name'] . '&p_date=' . $_GET['p_date'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/spare_return?entries=' . $_GET['entries'] . '&po_no=' . $_GET['po_no'] . '&p_name=' . $_GET['p_name'] . '&p_date=' . $_GET['p_date'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        }
        
        
        else {
            $url = site_url('/report/Report/spare_return?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterListsparereturn($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->sparereturn_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    
    //******************************************************************************************************
    
    
    
    public function consumption_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            //$data = $this->manage_consumption();
            $this->load->view('consumption-report');
        } else {
            redirect('index');
        }
        
    }
    
    public function manage_consumption()
    {
        
        $table_name     = 'tbl_vendor_spare_price_map';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/spare_price_mapping_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_all_spare_map($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/spare_price_mapping_report?entries=' . $_GET['entries'] . '&v_name=' . $_GET['v_name'] . '&sp_name=' . $_GET['sp_name'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            
            
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/spare_price_mapping_report?entries=' . $_GET['entries'] . '&v_name=' . $_GET['v_name'] . '&sp_name=' . $_GET['sp_name'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        }
        
        else {
            $url = site_url('/report/Report/spare_price_mapping_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterList_spare_mapp($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_report->spare_mapping_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    //*******************************************************************************************************
    
    
    public function section_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            //$data = $this->manageSectionJoinReport();
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('section-wise-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageSectionJoinReport()
    {
        
        $table_name     = 'tbl_machine_spare_map';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/section_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_all_spare_machine_map($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/section_report?entries=' . $_GET['entries'] . '&m_name=' . $_GET['m_name'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            
            
        }
        
        elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/section_report?entries=' . $_GET['entries'] . '&m_name=' . $_GET['m_name'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        }
        
        else {
            $url = site_url('/report/Report/section_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterList_machine_spare_mapp($pagination['per_page'], $pagination['page'], $this->input->get());
        
        else
            $data['result'] = $this->model_report->spare_machine_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    
    
    //*****************************************************************************************************
    
    
    public function machine_files_log()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('machine-files-log', $data);
        } else {
            redirect('index');
        }
        
    }

    
    public function machine_details_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('machine-details-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function machine_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data                      = $this->manageMachineJoin();
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('machine-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageMachineJoin()
    {
        
        $table_name     = 'tbl_category';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/machine_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_all_machine($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/machine_report?entries=' . $_GET['entries'] . '&m_type=' . $_GET['m_type'] . '&machineid=' . $_GET['machineid'] . '&filter=' . $_GET['filter']);
        }
        
        elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/machine_report?entries=' . $_GET['entries'] . '&m_type=' . $_GET['m_type'] . '&machineid=' . $_GET['machineid'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/machine_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterList_machine($pagination['per_page'], $pagination['page'], $this->input->get());
        
        else
            $data['result'] = $this->model_report->machine_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    

    //============================================================

        public function machine_spares_log()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('machine-spares-log', $data);
        } else {
            redirect('index');
        }
        
    }    
    
    public function machine_spare_details()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('machine-spare-details', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function machine_spare_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data                      = $this->manageMachineSpareJoin();
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('machine-spare-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageMachineSpareJoin()
    {
        
        $table_name     = 'tbl_category';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/machine_spare_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_mspare($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/machine_spare_report?entries=' . $_GET['entries'] . '&m_type=' . $_GET['m_type'] . '&machineid=' . $_GET['machineid'] . '&filter=' . $_GET['filter']);
            
            
        }
        
        elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/machine_spare_report?entries=' . $_GET['entries'] . '&m_type=' . $_GET['m_type'] . '&machineid=' . $_GET['machineid'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/machine_spare_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterList_mspare($pagination['per_page'], $pagination['page'], $this->input->get());
        
        else
            $data['result'] = $this->model_report->machine_spare($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    //========================================================
    
    
    public function breakdown_hours_details()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('breakdown-hours-details', $data);
        } else {
            redirect('index');
        }
        
    }
    
    
    public function breakdown_hours_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data                      = $this->manageBreakdownHoursJoin();
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('breakdown-hours-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageBreakdownHoursJoin()
    {
        
        $table_name     = 'tbl_product_stock';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/breakdown_hours_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_Spare($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/breakdown_hours_report?entries=' . $_GET['entries'] . '&m_name=' . $_GET['m_name'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
            
            
        }
        
        elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/breakdown_hours_report?entries=' . $_GET['entries'] . '&m_name=' . $_GET['m_name'] . '&sp_name=' . $_GET['sp_name'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/breakdown_hours_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterSpareList($pagination['per_page'], $pagination['page'], $this->input->get());
        
        else
            $data['result'] = $this->model_report->Spare_Get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }


    //============================ spare to machine =============================

    public function spares_machine_log()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('spares-machine-log', $data);
        } else {
            redirect('index');
        }
        
    }     
    
    public function spare_machine_details()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('spare-machine-details', $data);
        } else {
            redirect('index');
        }
        
    }
     
    public function spare_machine_report()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data                      = $this->manageSpareMachineJoin();
            $data['categorySelectbox'] = $this->model_report->categorySelectbox();
            $this->load->view('spare-machine-report', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageSpareMachineJoin()
    {
        
        $table_name     = 'tbl_master_data';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/spare_machine_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_sparem($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/spare_machine_report?entries=' . $_GET['entries'] . '&m_type=' . $_GET['m_type'] . '&machineid=' . $_GET['machineid'] . '&filter=' . $_GET['filter']);
            
            
        }
        
        elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/spare_machine_report?entries=' . $_GET['entries'] . '&m_type=' . $_GET['m_type'] . '&machineid=' . $_GET['machineid'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/spare_machine_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterList_sparem($pagination['per_page'], $pagination['page'], $this->input->get());
        
        else
            $data['result'] = $this->model_report->spare_machine($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }
    //========================================================

    function get_machine_list()
    {
        
        $sec     = $this->input->post('mid');
        $machine = $this->db->query("select * from tbl_machine where m_type='$sec' ");
        echo "<option value=''>----Select ----</option> ";
        foreach ($machine->result() as $getMachine) {
            echo "<option value=" . $getMachine->id . ">" . $getMachine->machine_name . "</option>";
        }
        
    }


    function get_spare_list_data()
    {
        
        $typ     = $this->input->post('typId');
        $prd = $this->db->query("select * from tbl_product_stock where type_of_spare='$typ'");
        echo "<option value=''>----Select ----</option> ";
        foreach ($prd->result() as $getPrd) {
            echo "<option value=" . $getPrd->Product_id . ">" . $getPrd->productname . "</option>";
        }
        
    }


//=====================================================================================


    public function daily_entries_report()
    {
        
        //extract($_POST);
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageSoftwareLog();
            $this->load->view('daily-entries',$data);
        } else {
            redirect('index');
        }
        
    }


    public function manageSoftwareLog()
    {
        
        $table_name     = 'tbl_software_log';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/report/Report/daily_entries_report?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_report->count_softwareLog($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] != 'filter') {
            $url = site_url('/report/Report/daily_entries_report?entries=' . $_GET['entries'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
            
            
        }
        
        elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/report/Report/daily_entries_report?entries=' . $_GET['entries'] . '&f_date=' . $_GET['f_date'] . '&t_date=' . $_GET['t_date'] . '&filter=' . $_GET['filter']);
        }
        
        else {
            $url = site_url('/report/Report/daily_entries_report?');
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_report->filterList_softwareLog($pagination['per_page'], $pagination['page'], $this->input->get());
        
        else
            $data['result'] = $this->model_report->get_softwareLog($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_report->categorySelectbox();
        return $data;
        
    }






    
}

?>