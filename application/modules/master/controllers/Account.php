<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
class Account extends my_controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_master');
        $this->load->library('pagination');
        $this->load->model('model_admin_login');
    }
    
    public function manage_contact()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manage_contactJoin();
            $this->load->view('Account/manage-contact', $data);
        } else {
            redirect('index');
        }
    }
    
    
    public function manage_contact_map()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data           = $this->user_function(); // call permission fnctn
            $data['result'] = $this->model_master->getSpareData();
            $this->load->view('Account/manage-contact-map', $data);
        } else {
            redirect('index');
        }
    }
    
    public function get_sparelist()
    {
        $result = $this->model_master->model_spare_productList($this->input->post('value'));
        if (sizeof($result) > 0) {
            foreach ($result as $dt) {
                if ($dt['productname'] != "") {
                    echo "<a class='form-control listpro' jsvalue='" . json_encode($dt) . "' onclick='selectSpareList(this)'>" . $dt['productname'] . "</a>";
                }
            }
        } else
            echo "<a class='form-control' value='Not Found !'> Not Found !</a>";
        
    }
    
    
    /*=========================================================================*/
    
    public function insert_contact_files()
    {
        
        @extract($_POST);
        $table_name = 'tbl_machine_files_uploads';
        
        if ($_FILES['image_name']['name'] != '') {
            $target     = "filesimages/contactfiles/";
            $target1    = $target . @date(U) . "_" . ($_FILES['image_name']['name']);
            $image_name = @date(U) . "_" . ($_FILES['image_name']['name']);
            move_uploaded_file($_FILES['image_name']['tmp_name'], $target1);
        }
        
        
        $data = array(
            
            'module_type' => 'Contact',
            'file_log_id' => $contact_id,
            'file_name' => $image_name,
            'desc_id' => $desc_id
            
        );
        
        
        $sesio = array(
            'maker_id' => $this->session->userdata('user_id'),
            'author_id' => $this->session->userdata('user_id'),
            'comp_id' => $this->session->userdata('comp_id'),
            'divn_id' => $this->session->userdata('divn_id'),
            'zone_id' => $this->session->userdata('zone_id'),
            'brnh_id' => $this->session->userdata('brnh_id'),
            'maker_date' => date('Y-m-d'),
            'author_date' => date('Y-m-d')
        );
        
        $dataall = array_merge($data, $sesio);
        
        $this->Model_admin_login->insert_user($table_name, $dataall);
        
    }
    
    
    public function get_contact_files()
    {
        @extract($_POST);
        $data       = $this->user_function(); // call permission fnctn    
        $data['id'] = $id;
        $this->load->view("Account/get-contact-uploads-file", $data);
    }
    
    /*=========================================================================*/
    
    
    function manage_contactJoin()
    {
        
        $table_name = 'tbl_contact_m';
        //$url        = site_url('/master/Account/manage_contact?');
        $sgmnt      = "4";
        
        if ($_GET['entries'] != '') {
            $showEntries = $_GET['entries'];
        } else {
            $showEntries = 10;
        }
        
        $totalData = $this->model_master->count_contact($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != '' && $_GET['filter'] != 'filter') {
            $url = site_url('/master/Account/manage_contact?entries=' . $_GET['entries']);
        } elseif ($_GET['filter'] == 'filter' || $_GET['entries'] != '') {
            $url = site_url('/master/Account/manage_contact?entries=' . $_GET['entries'] . '&first_namee=' . $_GET['first_namee'] . '&maingroupname=' . $_GET['maingroupname'] . '&emailee=' . $_GET['emailee'] . '&mobile=' . $_GET['mobile'] . '&phone=' . $_GET['phone'] . '&filter=' . $_GET['filter']);
        } else {
            $url = site_url('/master/Account/manage_contact?');
        }
        
        $pagination = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        
        //////Pagination end ///
        $data               = $this->user_function(); // call permission fnctn
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '')
            $data['result'] = $this->model_master->filterContactList($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_master->contact_get($pagination['per_page'], $pagination['page']);
        
        return $data;
        
    }
    
    public function ajex_ContactListData()
    {
        $data = $this->manage_contactJoin();
        $this->load->view('/Account/edit-contact', $data);
    }
    
    public function updateContact()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['ID'] = $_GET['ID'];
            $this->load->view('/Account/edit-contact', $data);
        } else {
            redirect('index');
        }
    }
    
    public function getdata_fun()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['id'] = $_GET['con'];
            $this->load->view('/Account/getdata', $data);
        } else {
            redirect('index');
        }
    }
    
    public function contact_log()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->user_function(); // call permission fnctn
            $this->load->view('Account/contact-log', $data);
        } else {
            redirect('index');
        }
    }
    
    
    public function contact_log_pay()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->user_function(); // call permission fnctn
            $this->load->view('Account/contact-log-pay', $data);
        } else {
            redirect('index');
        }
    }
    
    
    
    public function contact_list_pay()
    {
        $info = array();
        
        $res = $this->db->select('*')->where('group_name', '5')->get('tbl_contact_m');
        
        $i = '0';
        
        foreach ($res->result() as $row) {
            
            $compQuery = $this->db->select('*')->where('account_id', $row->group_name)->get('tbl_account_mst');
            $compRow   = $compQuery->row();
            
            $info[$i]['1'] = $row->first_name;
            $info[$i]['2'] = $compRow->account_name;
            $info[$i]['3'] = $row->email;
            $info[$i]['4'] = $row->mobile;
            $info[$i]['5'] = $row->contact_id;
            $info[$i]['6'] = $row->phone;
            $i++;
            
        }
        
        return $info;
        
    }
    
    public function contact_list()
    {
        $info = array();
        
        $res = $this->db->select('*')->where('group_name', '4')->get('tbl_contact_m');
        
        $i = '0';
        
        foreach ($res->result() as $row) {
            
            $compQuery = $this->db->select('*')->where('account_id', $row->group_name)->get('tbl_account_mst');
            $compRow   = $compQuery->row();
            
            $info[$i]['1'] = $row->first_name;
            $info[$i]['2'] = $compRow->account_name;
            $info[$i]['3'] = $row->email;
            $info[$i]['4'] = $row->mobile;
            $info[$i]['5'] = $row->contact_id;
            $info[$i]['6'] = $row->phone;
            $i++;
            
        }
        
        return $info;
        
    }
    
    
    public function add_contact()
    {
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('Account/add-contact');
        } else {
            redirect('index');
        }
    }
    
    
    
    public function insert_contact()
    {
        
        @extract($_POST);
        $table_name = 'tbl_contact_m';
        //$table_name_dtl = 'tbl_contact_person';
        $pri_col    = 'contact_id';
        //$pri_col_dtl    = 'person_id';
        $id         = $this->input->post('contact_id');
        $total      = '0';
        
        $data = array(
            
            'first_name' => $this->input->post('first_name'),
            'group_name' => $this->input->post('groupName'),
            'contact_person' => $this->input->post('contact_person'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'mobile' => $this->input->post('mobile'),
            'IT_Pan' => $this->input->post('pan_no'),
            'gst' => $this->input->post('gstin'),
            'address1' => $this->input->post('address1'),
            'address3' => $this->input->post('address3'),
            'city' => $this->input->post('city'),
            'state_id' => $this->input->post('state_id'),
            'pin_code' => $this->input->post('pin_code')
            //'city'       => $this->input->post('city'),
            //'accunt'     => $this->input->post('groupname'),
            //'alias'      => $this->input->post('alias_name'),
            //'printname'  => $this->input->post('printname'),
            
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
        
        
        $data_entr = array_merge($data, $sesio);
        //$this->load->model('Model_admin_login');
        
        
        
        if ($id != '') {
            
            $this->Model_admin_login->update_user($pri_col, $table_name, $id, $data);
            //$lastHdrId = $this->db->insert_id();        
            echo 2;
            
        } else {
            
            $this->Model_admin_login->insert_user($table_name, $data_entr);
            $lastId=$this->db->insert_id();
            $this->software_log_insert($lastId, 'Contact Created');
            echo 1;
            
        }
    }
    
    
    
    public function firstfunction()
    {
        $data['firstid'] = $_GET['firstid'];
        $this->load->view('get-alies-itemctg', $data);
    }
    
    public function aliesnamefunction()
    {
        $data['aliesnameid'] = $_GET['aliesnameid'];
        $this->load->view('get-alies-itemctg', $data);
    }
    
    
    public function add_spare_price()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['ID'] = $_GET['ID'];
            $this->load->view('Account/spare-price-mapping', $data);
        } else {
            redirect('index');
        }
    }
    
    
    public function ajax_sparePriceMapping()
    {
        @extract($_POST);
        //print_r($_POST);die;
        $table_name = 'tbl_vendor_spare_price_map';
        
        
        $data = array(
            'vendor_id' => $this->input->post('vendorid'),
            'create_on' => date('y-m-d h:i:sa'),
            'spare_id' => $this->input->post('pri_id'),
            'price' => $this->input->post('rate'),
            'maker_id' => $this->session->userdata('user_id'),
            'author_id' => $this->session->userdata('user_id'),
            'maker_date' => date('y-m-d'),
            'author_date' => date('y-m-d'),
            
            'comp_id' => $this->session->userdata('comp_id'),
            'zone_id' => $this->session->userdata('zone_id'),
            'brnh_id' => $this->session->userdata('brnh_id'),
            'divn_id' => $this->session->userdata('divn_id')
        );
        $this->Model_admin_login->insert_user($table_name, $data);
        
        echo "1";
    }
    
    public function get_manage_spare_price_mapping()
    {
        
        $data       = $this->user_function(); // call permission fnctn
        $data['id'] = $_POST['id'];
        $this->load->view("Account/get-sub-manage-spare-price-mapping", $data);
    }
    
    public function fetch_sparePriceMapping()
    {
        $result = $this->model_master->fetch_sparePriceMapping();
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        $html = "";
        if (sizeof($result) > 0) {
            foreach ($result as $key => $value) {
                
            }
        }
    }
    
    function ajax_productMapping()
    {
        
        //print_r($this->input->post('id'));die;
        $result         = $this->model_master->mod_productmapData($this->input->post('id'));
        $data['id']     = $this->input->post('id');
        $data['result'] = $result;
        
        $this->load->view('Account/view_mapping_price', $data);
        
    }
    
    
}
?>