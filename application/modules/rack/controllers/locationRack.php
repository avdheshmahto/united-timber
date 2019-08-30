<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
class locationRack extends my_controller
{
    
    function __construct()
    {
        
        parent::__construct();
        $this->load->model('model_locationrack');
        $this->load->library('pagination');
        
    }
    
    
    public function manage_location_rack()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->user_function(); // call permission fnctn
            $data = $this->manageItemJoinfun();
            $this->load->view('manage-location-rack', $data);
        } else {
            redirect('index');
        }
        
    }
    
    
    public function manageItemJoinfun()
    {
        
        $table_name     = 'tbl_location_rack';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/rack/locationRack/manage_location_rack?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_locationrack->count_allproduct($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] == "") {
            $url = site_url('/rack/locationRack/manage_location_rack?entries=' . $_GET['entries']);
        } elseif ($_GET['filter'] != "") {
            $url = site_url('/rack/locationRack/manage_location_rack?entries=' . $_GET['entries'] . '&location_rack_id=' . $_GET['location_rack_id'] . '&rack_name=' . $_GET['rack_name'] . '&filter=' . $_GET['filter']);
            // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
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
            $data['result'] = $this->model_locationrack->filterListproduct($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_locationrack->locationrack($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    
    public function get_cid()
    {
        
        //$data=$this->user_function();// call permission function    
        $this->load->view('get_cid');
        
    }
    
    public function add_location_rack()
    {
        
        //echo "";die;
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('add-location-rack');
        } else {
            redirect('index');
        }
        
    }
    
    
    public function insert_location_rack()
    {
        
        @extract($_POST);
        $table_name = 'tbl_location_rack';
        $pri_col    = 'id';
        $id         = $id;
        $data       = array(
            
            'location_id' => $this->input->post('location_id'),
            'location_rack_id' => $this->input->post('location_rack_id'),
            'rack_name' => $this->input->post('rack_name')
        );
        
        
        $sesio = array(
            
            'comp_id' => $this->session->userdata('comp_id'),
            'divn_id' => $this->session->userdata('divn_id'),
            'zone_id' => $this->session->userdata('zone_id'),
            'brnh_id' => $this->session->userdata('brnh_id'),
            'maker_id' => $this->session->userdata('user_id'),
            'author_id' => $this->session->userdata('user_id'),
            'maker_date' => date('y-m-d'),
            'author_date' => date('y-m-d')
        );
        
        $dataall = array_merge($data, $sesio);
        
        $this->load->model('Model_admin_login');
        
        if ($id != '') {
            
            $this->Model_admin_login->update_user($pri_col, $table_name, $id, $dataall);
            echo "2";
            
        } else {
            
            $this->Model_admin_login->insert_user($table_name, $dataall);
            echo "1";
            
        }
        
    }
    
    
    
    public function getLocationRackPage()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = array(
                'id' => $_GET['id'],
                'type' => $_GET['type']
            );
            $this->load->view('edit-location-rack', $data);
        } else {
            redirect('index');
        }
        
    }
    
    
    public function LocationRackData()
    {
        
        $locationrack = $this->manageItemJoinfun();
        $this->load->view('rack/get_manage_location_rack', $locationrack);
        
    }
    
    public function LocationRackDataEdit()
    {
        
        $locationrack = $this->manageItemJoinfun();
        $this->load->view('rack/get_manage_location_rack', $locationrack);
        
    }
    
}

?>