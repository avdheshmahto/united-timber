<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);

class labour extends my_controller {

function __construct()
{
	parent::__construct(); 
	$this->load->library('pagination');
	$this->load->model('model_master');	
}     

/*=================================Start Labour Task ================================*/

function manage_labor_task() 
{

    if($this->session->userdata('is_logged_in'))
    {
    	$data = $this->manageLabourJoinfun();
    	$this->load->view('labour/manage-labour-task',$data);
	}
	else
	{
		redirect('index');
	}

}

public function manageLabourJoinfun()
{
    
		$table_name='tbl_workorder_labor_task';
		$data['result'] = "";
		////Pagination start ///
		$url   = site_url('/maintenance/labour/manage_labor_task?');
		$sgmnt = "4";

		if($_GET['entries']!="")
		$showEntries = $_GET['entries'];
		else
		$showEntries = 10;


		$totalData   = $this->model_master->count_labourTask($table_name,'A',$this->input->get());


		if($_GET['entries']!="" && $_GET['filter'] == ""){
		$url   = site_url('/maintenance/labour/manage_labor_task?entries='.$_GET['entries']);
		}elseif($_GET['filter'] != ""){
		$url   = site_url('/maintenance/labour/manage_labor_task?entries='.$_GET['entries'].'&location_rack_id='.$_GET['location_rack_id'].'&rack_name='.$_GET['rack_name'].'&filter='.$_GET['filter']);
		// sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
		}

		$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
		$data       = $this->user_function();
		//////Pagination end ///
		$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
		$data['pagination']        = $this->pagination->create_links();

		if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
		$data['result']          = $this->model_master->filterLabourTask($pagination['per_page'],$pagination['page'],$this->input->get());
		else	
		$data['result']          = $this->model_master->getLabourTask($pagination['per_page'],$pagination['page']);

		// call permission fnctn
		$data['categorySelectbox'] = $this->model_master->categorySelectbox();	
		return $data;

}


function insert_labour_task()
{
	
	//@extract($_POST);

	//print_r($_POST);die;
	$table_name='tbl_workorder_labor_task';	

	$data=array(
				
					'section'     			=> $this->input->post('section'),
					'task_date'				=> $this->input->post('task_date'),
					'task_name'     		=> $this->input->post('task_name'),
					'task_type'         	=> $this->input->post('task_type'),				
					'start_date'   			=> $this->input->post('start_date'),
					'date_completed'   		=> $this->input->post('date_completed'),
					'time_estimate'   		=> $this->input->post('time_estimate'),			
					'time_spent'   		    => $this->input->post('time_spent'),
					'cost_estimate'			=> $this->input->post('cost_estimate'),
					'cost_spent'			=> $this->input->post('cost_spent'),
					'desc_name'   			=> $this->input->post('des_name'),
					'task_completion_notes' => $this->input->post('task_notes'),
					'labor_type' 			=> 'S',
		
				);


	$sesio = array(
					'maker_id'    => $this->session->userdata('user_id'),
					'author_id'   => $this->session->userdata('user_id'),
					'comp_id' 	  => $this->session->userdata('comp_id'),
					'divn_id' 	  => $this->session->userdata('divn_id'),
					'zone_id' 	  => $this->session->userdata('zone_id'),
					'brnh_id' 	  => $this->session->userdata('brnh_id'),
					'maker_date'  => date('Y-m-d'),
					'author_date' => date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

		$this->Model_admin_login->insert_user($table_name,$dataall);
		$lastId=$this->db->insert_id();

		$this->add_software_cost_log($lastId,'Labour',$this->input->post('task_date'),$this->input->post('section'),'','','','','',$this->input->post('cost_spent') );

	echo 1;

}


function ajex_LabourTaskData()
{

	$data = $this->manageLabourJoinfun();
	$this->load->view('labour/get-labour-task',$data);	

}


/*==============================================================================================*/
}
?>