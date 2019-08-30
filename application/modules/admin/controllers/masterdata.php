<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
class Masterdata extends my_controller
{
    
    function __construct()
    {
        
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->library("pagination");
        
    }
    
    
    //----------------------------------start master data function-----------------------
    
    public function masterdata_list()
    {
        $info = array();
        
        $res = $this->db->select('*')->where('status', 'A')->get('tbl_master_data');
        
        $i = '0';
        
        foreach ($res->result() as $row) {
            
            $compQuery = $this->db->select('*')->where('param_id', $row->param_id)->get('tbl_master_data_mst');
            $compRow   = $compQuery->row();
            
            $info[$i]['1'] = $compRow->keyname;
            $info[$i]['2'] = $row->keyvalue;
            $info[$i]['3'] = $row->description;
            $info[$i]['4'] = $row->serial_number;
            
            $i++;
            
        }
        return $info;
        
    }
    
    public function update_master_data()
    {
        //echo "hi";die;
        extract($_POST);
        $table_name = 'tbl_master_data';
        $pri_col    = 'serial_number';
        $id         = $this->input->post('id');
        
        $this->load->model('Model_admin_login');
        
        if ($id != '') {
            
            $dataarr = array(
                
                'param_id' => $this->input->post('param_id'),
                'keyvalue' => $this->input->post('keyvalue'),
                'description' => $this->input->post('description')
                
            );
            
            $this->Model_admin_login->update_user($pri_col, $table_name, $id, $dataarr);
            //echo "update tbl_master_data set param_id='$param_id', keyvalue='$keyvalue',description='$description' where serial_number = '$id' ";die;
            //$this->db->query("update tbl_master_data set param_id='$param_id', keyvalue='$keyvalue',description='$description' where serial_number = '$id' ");
            $this->session->set_flashdata('flash_msg', 'Record Update Successfully.');
            redirect('/admin/masterdata/manage_master_data');
        }
    }
    
    public function insert_master_data()
    {
        //echo "hi";die;
        extract($_POST);
        $table_name = 'tbl_master_data';
        $pri_col    = 'serial_number';
        $id         = $this->input->post('id');
        
        $this->load->model('Model_admin_login');
        
        if ($id == '') {
            
            
            $data  = array(
                
                'param_id' => $this->input->post('param_id'),
                'keyvalue' => $this->input->post('keyvalue'),
                'description' => $this->input->post('description')
                
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
            
            $this->Model_admin_login->insert_user($table_name, $dataall);
            $this->session->set_flashdata('flash_msg', 'Record Added Successfully.');
            redirect('/admin/masterdata/manage_master_data');
        }
    }
    
    public function add_master_data()
    {
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('/masterdata/add-master-data');
        } else {
            redirect('index');
        }
    }
    
    public function edit_master_data()
    {
        $data = array(
            'id' => $_GET['id'],
            'type' => $_GET['type']
        );
        //print_r($data);
        //$data['result'] = $this->model_admin->master_data();
        $this->load->view("masterdata/edit-master-data", $data);
        
    }
    
    public function manage_master_data()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->user_function(); // call permission fnctn
            //$data['result'] = $this->model_admin->master_data();
            $data = $this->manageMasterJoin();
            $this->load->view('/masterdata/manage-master-data', $data);
        } else {
            redirect('index');
        }
    }
    
    
    public function manageMasterJoin()
    {
        
        
        $table_name     = 'tbl_master_data';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/admin/masterdata/manage_master_data?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_admin->countMasterData($table_name, 'A', $this->input->get());
        
        
        // if($_GET['entries']!="" && $_GET['filter'] == ""){
        // $url   = site_url('/admin/masterdata/manage_master_data?entries='.$_GET['entries']);
        // }elseif($_GET['filter'] != ""){
        //      $url   = site_url('/admin/masterdata/manage_master_data?entries='.$_GET['entries'].'&sku_no='.$_GET['sku_no'].'&category='.$_GET['category'].'&type_of_spare='.$_GET['type_of_spare'].'&productname='.$_GET['productname'].'&usages_unit='.$_GET['usages_unit'].'&purchase_price='.$_GET['purchase_price'].'&filter='.$_GET['filter']);
        //      // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
        // }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        //echo $pagination; die;
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        //  if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
        // $data['result']          = $this->model_admin->filterMasterData($pagination['per_page'],$pagination['page'],$this->input->get());
        //  else    
        $data['result'] = $this->model_admin->master_data($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
        
    }
    
    
    //--------------------------close master data -----------------------------------    
    
    
    
    
}


?>