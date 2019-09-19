<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
class machine_breakdown extends my_controller
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('model_master_breakdown');
    }
    
    
    public function manage_break()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemJoinfun();
            $this->load->view('breakdown/machine-breakdown', $data);
        } else {
            redirect('index');
        }
        
    }
    
    
    public function vieworderspares()
    {
        
        $data = array(
            'id' => $_GET['ID']
        );
        
        $this->load->view("breakdown/view-order-spares", $data);
        
    }
    
    public function viewordertools()
    {
        
        $data = array(
            'id' => $_GET['ID']
        );
        
        $this->load->view("breakdown/view-order-tools", $data);
        
    }
    
    public function get_manage_machine_breakdown()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemJoinfun();
            $this->load->view('breakdown/get-manage-machine-breakdown', $data);
        } else {
            redirect('index');
        }
    }
    
    
    
    public function manage_machine_breakdown_sm_map()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('schedule/manage-machine-breakdown-sm-map');
        } else {
            redirect('index');
        }
        
    }
    
    
    public function manage_machine_breakdown_map()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data           = $this->user_function(); // call permission fnctn
            $data['result'] = $this->model_master_breakdown->getbreakdownData();
            $this->load->view('breakdown/manage-machine-breakdown-map', $data);
        } else {
            redirect('index');
        }
    }
    
    
    
    public function insert_breakdown()
    {
        
        @extract($_GET);
        $table_name = 'tbl_work_order_maintain';
        $pri_col    = 'id';
        
        $table_name_break = 'tbl_machine_breakdown';
        
        $id = $this->input->get('id');
        
        $data = array(
            
            'code' => $code,
            'm_type' => $m_type,
            'machine_name' => $machine_name,
            'wostatus' => $wostatus,
            'maintyp' => $maintyp,
            'priority' => $priority,
            'date_time' => $datetimepicker_mask
            
        );
        
        $dataBreak = array(
            
            'code' => $code,
            'nature_of_breakdown' => $maintyp,
            'section' => $m_type,
            'break_time' => $datetimepicker_mask,
            'machine_id' => $machine_name,
            'operator_id' => $operator_id
            //'priority'  => $priority,
            
        );
        $sesio     = array(
            
            'maker_id' => $this->session->userdata('user_id'),
            'author_id' => $this->session->userdata('user_id'),
            'comp_id' => $this->session->userdata('comp_id'),
            'divn_id' => $this->session->userdata('divn_id'),
            'zone_id' => $this->session->userdata('zone_id'),
            'brnh_id' => $this->session->userdata('brnh_id'),
            'maker_date' => date('Y-m-d'),
            'author_date' => date('Y-m-d')
        );
        
        $dataall      = array_merge($data, $sesio);
        $dataallBreak = array_merge($dataBreak, $sesio);
        
        if ($id != '') {
            $this->Model_admin_login->update_user($pri_col, $table_name, $id, $data);
            $this->db->query("update tbl_machine_breakdown set nature_of_breakdown='$maintyp', section='$m_type', break_time='$datetimepicker_mask', machine_id='$machine_name',operator_id='$operator_id' where code='$code' ");
        } else {
            $this->Model_admin_login->insert_user($table_name, $dataall);
            $lastId = $this->db->insert_id();
            $this->Model_admin_login->insert_user($table_name_break, $dataallBreak);
            $this->db->query("update tbl_machine_breakdown set workorder_id='$lastId' where code='$code' ");
            $this->software_log_insert($lastId, 'Workorder Created');
        }
        redirect("maintenance/machine_breakdown/get_manage_machine_breakdown");
        
    }
    
    
    public function getSchedulePage()
    {
        
        $data['id']                = $_GET['id'];
        $data['type']              = $_GET['type'];
        $data['categorySelectbox'] = $this->model_master_breakdown->categorySelectbox();
        $this->load->view("breakdown/edit-machine-break", $data);
        
    }
    
    
    
    
    public function Work_orderCode_validate()
    {
        
        $id       = $this->input->get("codeval");
        $query    = $this->db->query("select * from tbl_work_order_maintain where status='A' and code='$id'");
        $getQuery = $query->num_rows();
        
        echo $getQuery;        
        
    }
    
    public function getSchedulesparePage()
    {
        
        $data = array(
            'p_id' => $_GET['pId'],
            'type' => $_GET['type'],
            'tri_code' => $_GET['triCode']
        );
        
        $this->load->view("schedule/edit-schedule-spare-map", $data);
        
    }
    
    public function getSpare()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = array(
                'ID' => $_GET['ID']
            );
            
            $this->load->view('machine/map-spare', $data);
        } else {
            redirect('index');
        }
    }
    
    
    //********************************Machine Metering*********************************************
    
    
    public function insert_spare_unit()
    {
        
        @extract($_GET);
        $table_name = 'tbl_machine_reading';

        $data       = array(
            
            'machine_id' => $_GET['pri_id_meter'],
            //'spare_id' => $_GET['code'],
            'reading' => $_GET['readingmeter'],
            'unit' => $_GET['unit_metering'],
            'date_time' => $_GET['datetimepicker_mask']
            
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
        
        $this->load->view('get-current-metering', $data);
        
    }
    
    public function get_metering_trigger()
    {
        $data           = $this->user_function(); // call permission fnctn
        $data['result'] = $this->model_master->getmeter_currentData();
        //print_r($data);
        $this->load->view('get-current-metering', $data);
    }
    
    
    
    //*****************************************************************************************************
    
    //======================= Start All labor tasks functions ===================================
    
    public function insert_breakdown_labor_tasks()
    {
        
        @extract($_POST);
        $table_name = 'tbl_workorder_labor_task';
        
        $wo         = $this->db->query("SELECT * FROM tbl_work_order_maintain where id='$brekdown_id'");
        $getWorkid  = $wo->row();
        $machine_id = $getWorkid->machine_name;
        
        $mac        = $this->db->query("select * from tbl_machine where id='$machine_id' ");
        $getMac     = $mac->row();
        $section_id = $getMac->m_type;
        
        
        $data = array(
            
            'work_order_id' => $brekdown_id,
            'task_date' => $task_date,
            'task_name' => $task_name,
            'task_type' => $task_type,
            'start_date' => $start_date,
            'date_completed' => $date_completed,
            'time_estimate' => $time_estimate,
            'time_spent' => $time_spent,
            'cost_estimate' => $cost_estimate,
            'cost_spent' => $cost_spent,
            'desc_name' => $des_name,
            'task_completion_notes' => $task_notes,
            'labor_type' => 'A'
            
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
        $lastId = $this->db->insert_id();
        
        $this->add_software_cost_log($lastId, 'Labour', $task_date, $section_id, $machine_id, $brekdown_id, '', '', '', $cost_spent, '');
        
        echo 1;
        
    }
    
    
    public function get_breakdown_labor_tasks()
    {
        @extract($_POST);
        
        $data       = $this->user_function(); // call permission fnctn
        $data['id'] = $id;
        $this->load->view('breakdown/get-breakdown-labor-tasks', $data);
    }
    
    //=======================Close All labor tasks functions============================
    
    //======================= Start All Spare Parts functions ===================================
    
    public function insert_breakdown_parts()
    {
        @extract($_POST);
        $table_name = 'tbl_workorder_spare_hdr';
        $cnt[] = $spareids;
        $rows = count($cnt);
        
        $maker_id    = $this->session->userdata('user_id');
        $author_id   = $this->session->userdata('user_id');
        $comp_id     = $this->session->userdata('comp_id');
        $divn_id     = $this->session->userdata('divn_id');
        $zone_id     = $this->session->userdata('zone_id');
        $brnh_id     = $this->session->userdata('brnh_id');
        $maker_date  = date('Y-m-d');
        $author_date = date('Y-m-d');
        
        $this->db->query("insert into tbl_workorder_spare_hdr set work_order_id='$spare_work_order_id',type='Parts', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id',author_date='$author_date'");
        
        $last = $this->db->insert_id();
        
        for ($i = 0; $i < $rows; $i++) {
            
            $this->db->query("insert into tbl_workorder_spare_dtl set spare_hdr_id='$last',spare_id='$spareids[$i]', qty_name='$qtyname[$i]',via_type='$via_types[$i]', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id', author_date='$author_date'");
        }
        
        
        echo 1;
    }
    
    public function get_breakdown_parts()
    {
        @extract($_POST);
        
        $data       = $this->user_function(); // call permission fnctn
        $data['id'] = $id;
        $this->load->view('breakdown/get-breakdown-parts', $data);
    }
    
    //==============Close All Spare Parts functions========================================
    
    //======================= Start All Tools functions ===================================
    
    public function insert_breakdown_tools()
    {
        @extract($_POST);
        $table_name = 'tbl_workorder_spare_hdr';
        
        $rows = count($toolids);
        
        $maker_id    = $this->session->userdata('user_id');
        $author_id   = $this->session->userdata('user_id');
        $comp_id     = $this->session->userdata('comp_id');
        $divn_id     = $this->session->userdata('divn_id');
        $zone_id     = $this->session->userdata('zone_id');
        $brnh_id     = $this->session->userdata('brnh_id');
        $maker_date  = date('Y-m-d');
        $author_date = date('Y-m-d');
        
        $this->db->query("insert into tbl_workorder_spare_hdr set work_order_id='$tools_work_order_id',type='Tools', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id', author_date='$author_date'");
        
        $last = $this->db->insert_id();
        
        for ($i = 0; $i < $rows; $i++) {
            
            $this->db->query("insert into tbl_workorder_spare_dtl set spare_hdr_id='$last',spare_id='$toolids[$i]', qty_name='$qtyname[$i]',via_type='$via_types[$i]', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id', author_date='$author_date'");
        }
        
        echo 1;
    }
    
    public function get_breakdown_tools()
    {
        @extract($_POST);
        
        $data       = $this->user_function(); // call permission fnctn
        $data['id'] = $id;
        $this->load->view('breakdown/get-breakdown-tools', $data);
    }
    
    //==============Close All Tools functions========================================
    
    //======================= Start All Meter Reading functions ===================================
    
    public function insert_work_order_meter_reading()
    {
        @extract($_POST);
        $table_name = 'tbl_work_order_meter_reading';
        
        $data = array(
            'work_order_id' => $work_order_id,
            'meter_reading' => $meter_reading,
            'meter_unit' => $meter_unite
            
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
        
        echo 1;
    }
    
    public function get_work_order_meter_reading()
    {
        @extract($_POST);
        
        $data       = $this->user_function(); // call permission fnctn
        $data['id'] = $id;
        $this->load->view('breakdown/get-work-order-meter-reading', $data);
    }
    
    //==============Close All Meter Reading functions========================================
    
    //======================= Start All Misc costs functions ===================================
    
    public function insert_work_order_misc_costs()
    {
        @extract($_POST);
        $table_name = 'tbl_work_order_misc_costs';
        
        $data = array(
            'work_order_id' => $work_order_id,
            'type_name' => $type_name,
            'desc_name' => $desc_name,
            'est_qty' => $est_qty,
            'est_unit_cost' => $est_unit_cost,
            'est_total_cost' => $est_total_cost,
            'act_qty' => $act_qty,
            'act_unit_cost' => $act_unit_cost,
            'act_total_cost' => $act_total_cost
            
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
        
        echo 1;
    }
    
    public function get_work_order_misc_costs()
    {
        @extract($_POST);
        
        $data       = $this->user_function(); // call permission fnctn
        $data['id'] = $id;
        $this->load->view('breakdown/get-work-order-misc-costs', $data);
    }
    
    //==============Close All misc costs functions========================================
    
    /*========================Start All file uploads =================================================*/
    
    public function insert_breakdown_files()
    {
        
        @extract($_POST);
        $table_name = 'tbl_machine_files_uploads';
        
        if ($_FILES['image_name']['name'] != '') {
            $target     = "filesimages/breakdown_files/";
            $target1    = $target . @date(U) . "_" . ($_FILES['image_name']['name']);
            $image_name = @date(U) . "_" . ($_FILES['image_name']['name']);
            move_uploaded_file($_FILES['image_name']['tmp_name'], $target1);
        }
        
        
        $data = array(
            
            'module_type' => 'Breakdown',
            'file_log_id' => $breakdown_id,
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
    
    
    public function get_breakdown_files()
    {
        @extract($_POST);
        $data       = $this->user_function(); // call permission fnctn    
        $data['id'] = $id;
        $this->load->view("breakdown/get-breakdown-uploads-file", $data);
    }
    
    /*=========================Close all file uploads function ==================================*/
    
    public function getproduct()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = array(
                'id' => $_GET['con']
            );
            
            $this->load->view('machine/getproduct', $data);
        } else {
            redirect('index');
        }
    }
    
    public function manageItemJoinfun()
    {
        
        $table_name     = 'tbl_schedule_triggering_log';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('maintenance/machine_breakdown/manage_break?');
        $sgmnt          = "4";
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        $totalData = $this->model_master_breakdown->count_schedule($table_name, 'A', $this->input->get());
        //$showEntries= $_GET['entries']?$_GET['entries']:'12';
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] == "") {
            $url = site_url('maintenance/machine_breakdown/manage_break?entries=' . $_GET['entries']);
        } elseif ($_GET['filter'] != "") {
            $url = site_url('maintenance/machine_breakdown/manage_break?entries=' . $_GET['entries'] . '&codee=' . $_GET['codee'] . '&m_type=' . $_GET['m_type'] . '&machine_name=' . $_GET['machine_name'] . '&machine_description=' . $_GET['machine_description'] . '&capacity=' . $_GET['capacity'] . '&filter=' . $_GET['filter']);            
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
            $data['result'] = $this->model_master_breakdown->filterSchedule($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_master_breakdown->getScheduleData($pagination['per_page'], $pagination['page']);
        
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_master_breakdown->categorySelectbox();
        return $data;
        
    }
    
    public function getcat()
    {
        
        $mcchine = $this->input->get('locs');
        $queryPo = $this->db->query("select * from tbl_machine where m_type='$mcchine'");
        echo '<select>';
        echo '<option>----select----</option>';
        foreach ($queryPo->result() as $getPO) {
            
            echo '<option value=' . $getPO->id . '>' . $getPO->machine_name . '</option>';
            
        }
        echo '</select>';
        
    }
    
    public function getcatt()
    {
        
        $queryPo = $this->db->query("select * from tbl_machine where m_type='" . $_GET['loc'] . "'");
        echo '<select>';
        echo '<option value="">----select----</option>';
        foreach ($queryPo->result() as $getPO) {
            
            echo '<option value=' . $getPO->id . '>' . $getPO->machine_name . '</option>';
            
        }
        echo '</select>';
        
    }
    
    
    public function insert_schedule_triggering()
    {
        
        @extract($_GET);
        $table_name = 'tbl_schedule_triggering';
        
        $data = array(
            
            'schedule_id' => $_GET['code'],
            'trigger_code' => $_GET['trigger_code'],
            'every_reading' => $_GET['every_reading'],
            'unit' => $_GET['unitt'],
            'starting_reading' => $_GET['start_reading'],
            'next_trigger_reading' => $_GET['next_trigger_reading'],
            'type' => $_GET['readtype'],
            'endby_reading' => $_GET['end_by_reading']
            
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
        
        
        redirect("maintenance/schedule/get_schedule_trigger?id=" . $_GET['code']);
        
    }
    
    
    public function get_schedule_trigger()
    {
        $data           = $this->user_function(); // call permission fnctn
        $data['result'] = $this->model_master->getScheduledData();
        //print_r($data);
        $this->load->view('schedule/get-schedule-trigger', $data);
    }
    
    
    
    public function manage_schedule_map()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data           = $this->user_function(); // call permission fnctn
            $data['result'] = $this->model_master->getScheduledData();
            $this->load->view('schedule/manage-schedule-map', $data);
        } else {
            redirect('index');
        }
    }
    
    //*******************************************************************************************************
    
    
    public function ajex_spare_Data()
    {
        
        //echo "djbv";
        $data['result'] = $this->model_master->get_spare_trigger_code();
        
        $this->load->view('schedule/get-schedule-sparemap', $data);
    }
    
    //******************************************************************************************************
    
    public function insert_schedule_triggering_spare()
    {
        //echo "suwub".die;
        @extract($_GET);
        $table_name = 'tbl_schedule_spare_hdr';        
        
        $data = array(
            
            'schedule_id' => $_GET['code'],
            'trigger_code' => $_GET['trigger_code_spare_add'],
            'spare_id' => $_GET['spare_name_map'],
            'quantity' => $_GET['quantity_spare']
            
            
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
    
    
    
    
    
    public function insert_schedule_triggering_edit()
    {
        //echo "suwub".die;
        @extract($_GET);
        $table_name = 'tbl_schedule_triggering';
        //$id = 'schedule_id';
        $pri_col    = 'id';
        $id         = $id;
        
        echo "uwh" . $id;
        
        
        $data = array(
            
            'schedule_id' => $_GET['pri_idd'],
            'every_reading' => $_GET['every_reading_meter'],
            'unit' => $_GET['unit_meter'],
            'starting_reading' => $_GET['start_reading_meter'],
            'next_trigger_reading' => $_GET['next_trigger_reading_meter'],
            'type' => $_GET['readtype_meter'],
            'endby_reading' => $_GET['end_by_reading_meter']
            
        );
        
                                
        $this->Model_admin_login->update_user($pri_col, $table_name, $id, $data);
        
        
        redirect("maintenance/schedule/get_schedule_trigger?id=" . $_GET['pri_idd']);
        
    }
    
    
    
    
    
    public function ajax_productlist()
    {
        $result = $this->model_master->mod_productList($this->input->post('value'));
        if (sizeof($result) > 0) {
            foreach ($result as $dt) {
                if ($dt['productname'] != "") {
                    echo "<a class='form-control listpro' jsvalue='" . json_encode($dt) . "' onclick='selectList(this)'>" . $dt['productname'] . "</a>";
                }
            }
        } else
            echo "<a class='form-control' value='Not Found !'> Not Found !</a>";
        
    }
    
    
    
    
    public function test_sch()
    {
        @extract($_POST);
        
        echo $trigger_code_shed;
        
        print_r($qnty) . "<br>";
        print_r($spare_name_sched);
    }
    
    
    
    public function insert_work_order_spare()
    {
        
        
        @extract($_POST);
        $table_name = 'tbl_work_order_spare';
        //$spare_name_schedd =count($spare_name_sched);
        
        for ($i = 0; $i < $spare_name_schedd; $i++) {
            
            $mapdata = array(
                'schedule_id' => $pri_id_schedule_id,
                'trigger_code' => $trigger_code_shed,
                'spare_id' => $spare_name_sched,
                'quantity' => $qnty,
                'actual_quantity' => $actual_qnty
            );
            //print_r($qnty);
            //print_r($mapdata);
            $sesio   = array(
                'maker_id' => $this->session->userdata('user_id'),
                'author_id' => $this->session->userdata('user_id'),
                'comp_id' => $this->session->userdata('comp_id'),
                'divn_id' => $this->session->userdata('divn_id'),
                'zone_id' => $this->session->userdata('zone_id'),
                'brnh_id' => $this->session->userdata('brnh_id'),
                'maker_date' => date('Y-m-d'),
                'author_date' => date('Y-m-d')
            );
            
            $dataall = array_merge($mapdata, $sesio);
            
            
            $this->Model_admin_login->insert_user($table_name, $dataall);
            
        }
        echo 1;
        
        
    }
    
    
    public function insert_schedule_triggering_spare12()
    {
        
        
        @extract($_POST);
        $table_name = 'tbl_schedule_spare_hdr';
        $pri_col    = 'id';
        $id         = 'pri_id_spare_sched_edit';
        
        
        $delquery = "delete from tbl_schedule_spare_hdr where trigger_code = '$triggercode_edit' and schedule_id = '$pri_id_schedule_id_edit'";
        $this->db->query($delquery);
        $spare_name_schedd_edit = count($spare_name_sched_edit);
        
        
        for ($i = 0; $i < $spare_name_schedd_edit; $i++) {
            
            $mapdata = array(
                'schedule_id' => $pri_id_schedule_id_edit,
                'trigger_code' => $triggercode_edit,
                'spare_id' => $spare_name_sched_edit[$i],
                'quantity' => $qnty_edit[$i]
            );
            $sesio   = array(
                'maker_id' => $this->session->userdata('comp_id'),
                'comp_id' => $this->session->userdata('comp_id'),
                'divn_id' => $this->session->userdata('divn_id'),
                'zone_id' => $this->session->userdata('zone_id'),
                'brnh_id' => $this->session->userdata('brnh_id'),
                'maker_date' => date('Y-m-d'),
                'author_date' => date('Y-m-d')
            );
            
            $dataall = array_merge($mapdata, $sesio);
            //print_r($dataall);
            
            $this->Model_admin_login->insert_user($table_name, $dataall);
            
        }
        
        echo 2;
        
    }
    
    
    public function update_workorder_id()
    {
        
        $wid   = $this->input->post('wid');
        $trgid = $this->input->post('trgid');
        //print_r($_POST);
        $this->db->query("update tbl_workorder_spare_hdr set work_order_id='$wid' where trigger_id='$trgid'");
        
    }
    
    public function insert_breakdown_hours()
    {
        
        //print_r($_POST);die;
        $table_name = "tbl_machine_breakdown";
        
        $breakdown_date       = $this->input->post('breakdown_date');
        $breakdown_start_time = $this->input->post('breakdown_start_time');
        $breakdown_end_time   = $this->input->post('breakdown_end_time');
        $code                 = $this->input->post('code');
        $work_order_id_hours  = $this->input->post("work_order_id_hours");
        
        $this->db->query("update tbl_machine_breakdown set breakdown_date='$breakdown_date', start_time='$breakdown_start_time',end_time='$breakdown_end_time' where code='$code' ");
        
        echo $work_order_id_hours;
        
    }
    
    public function ajax_getBreakdownHours()
    {
        
        //print_r($_POST);
        $data['id'] = $this->input->post('idval');
        $this->load->view('breakdown/load-breakdown-hours', $data);
    }
    
    
    
    public function chek_breakdown_hours()
    {
        $wids = $this->input->post('wid');
        $data = $this->db->query("select * from tbl_machine_breakdown where workorder_id='$wids' AND start_time !='' AND end_time !='' ")->result_array();
        if (sizeof($data) > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
}
?>