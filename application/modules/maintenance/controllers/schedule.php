<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class schedule extends my_controller {


function __construct()
{
    parent::__construct(); 
    $this->load->library('pagination');
    $this->load->model('model_master');	
}


public function manage_schedule()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data = $this->manageItemJoinfun();
		//$data['result'] = $this->model_master->getMachineData();	
		$this->load->view('schedule/manage-schedule',$data);
	}
	else
	{
		redirect('index');
	}
}

public function getschedulingspare()
{
	//@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $_GET['ID'];
	$this->load->view('schedule/view-scheduling-spares',$data);	
}

public function addlabortasksscheduling()
{
	//@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $_GET['ID'];
	$this->load->view('schedule/add-labor-tasks-scheduling',$data);	
}

public function editschedulingspare()
{
	$this->load->view('schedule/edit-scheduling-spares');	
}


public function editspareschedulingparts()
{
	$data['id'] = $_GET['ID'];
	$this->load->view('schedule/edit-schedule-spare-map',$data);		
}
//======================= Start All labor tasks functions ===================================

public function insert_scheduling_labor_tasks()
{
	
	@extract($_POST);
	$table_name='tbl_workorder_labor_task';

	$wo=$this->db->query("SELECT * FROM tbl_work_order_maintain where id='$brekdown_id'");
	$getWorkid=$wo->row();
	$machine_id=$getWorkid->machine_name;

	$mac=$this->db->query("select * from tbl_machine where id='$machine_id' ");
	$getMac=$mac->row();
	$section_id=$getMac->m_type;

	$data=array(
				
					'work_order_id'     	=> $this->input->post('brekdown_id'),
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
					'labor_type' 			=> 'SM',
		
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

	$this->add_software_cost_log($lastId,'Labour',$task_date,$section_id,$machine_id,$brekdown_id,'','','',$cost_spent);

	echo 1;
}

public function get_labor_tasks_scheduling()
{
	@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $id;
	$this->load->view('schedule/get-scheduling-labor-tasks',$data);	
}

//==============Close All labor tasks functions========================================





public function vieworderspare()
{
	//@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $_GET['ID'];
	$this->load->view('schedule/view-scheduling-order-spares',$data);	
}


public function get_schedule()
{
	if($this->session->userdata('is_logged_in'))
	{
    	$data = $this->manageItemJoinfun();
		//$data=$this->user_function();// call permission fnctn
		//$data['result'] = $this->model_master->getMachineData();	
		$this->load->view('schedule/get-schedule',$data);
	}
	else
	{
		redirect('index');
	}
}



public function insert_schedule()
{
		
	@extract($_GET);
	$table_name='tbl_schedule_maintain';
	$id=$this->input->get('id');
	$pri_col='id';	
	

	$data=array(
	  
	  'code'         => $code,
	  'm_type' 		 => $m_type,
	  'machine_name' => $machine_name,
	  'wostatus' 	 => $wostatus,
	  'maintyp' 	 => $maintyp,
	  'priority' 	 => $priority
	  
    );

    $sesio = array(
		'maker_id'    => $this->session->userdata('user_id'),
		'author_id'   => $this->session->userdata('user_id'),
		'comp_id'     => $this->session->userdata('comp_id'),
		'divn_id'     => $this->session->userdata('divn_id'),
		'zone_id'     => $this->session->userdata('zone_id'),
		'brnh_id'     => $this->session->userdata('brnh_id'),
		'maker_date'  => date('Y-m-d'),
		'author_date' => date('Y-m-d')
		);
		
   $dataall = array_merge($data,$sesio);

   if($id!='')
   {
	$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
   }else{
	$this->Model_admin_login->insert_user($table_name,$dataall);
   }
  redirect("maintenance/schedule/get_schedule");
  //$this->load->view('assets/machine/get_machine');

}


public function getSchedulePage()
{

	$data=array(
	'id'   => $_GET['id'],
	'type' => $_GET['type']
	);	
    
    $data['categorySelectbox'] = $this->model_master->categorySelectbox();		
	$this->load->view("schedule/edit-schedule",$data);	
	
}


public function getSchedulesparePage()
{

	$data=array(
	'p_id' 		=> $_GET['pId'],
	'type' 		=> $_GET['type'],
	'tri_code'  => $_GET['triCode'],
	);	
	//print_r($data);
		
	$this->load->view("schedule/edit-schedule-spare-map",$data);	
	
}

public function getSpare()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data=array(
		'ID' => $_GET['ID']
		);
		
		$this->load->view('machine/map-spare',$data);
	}
	else
	{
		redirect('index');
	}
}


//======================= Start All Spare Parts functions ===================================

public function insert_add_spare_scheduling()
{
	
	@extract($_POST);
	$table_name='tbl_schedule_spare_hdr';

	$rows=count($spareids);

	$maker_id    = $this->session->userdata('user_id');
	$author_id   = $this->session->userdata('user_id');
	$comp_id     = $this->session->userdata('comp_id');
	$divn_id     = $this->session->userdata('divn_id');
	$zone_id     = $this->session->userdata('zone_id');
	$brnh_id     = $this->session->userdata('brnh_id');
	$maker_date  = date('Y-m-d');
	$author_date = date('Y-m-d');
		
							
	$this->db->query("insert into tbl_schedule_spare_hdr set schedule_id='$scheduled_id', trigger_code='$triggercode', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

	$last=$this->db->insert_id();

	$this->db->query("insert into tbl_workorder_spare_hdr set schedule_id='$scheduled_id', trigger_id='$triggercode',type='Parts', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

	$lastto=$this->db->insert_id();
		
	for($i=0;$i<$rows;$i++)
	{

		$this->db->query("insert into tbl_schedule_spare_dtl set smsparetrigger_hdr_id='$last',spare_id='$spareids[$i]', suggested_qty='$qtyname[$i]',via_type='$via_types[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

		$this->db->query("insert into tbl_workorder_spare_dtl set spare_hdr_id='$lastto',spare_id='$spareids[$i]', qty_name='$qtyname[$i]',via_type='$via_types[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

	}

	echo 1;

}

public function get_spare_schedule()
{
	@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $id;
	$this->load->view('schedule/get-scheduling-spare-parts',$data);	
}

public function scheduling_spare_validation()
{

	@extract($_POST);

	//echo $scheduled_id;
	$abc=$this->db->query("select * from tbl_schedule_spare_hdr where schedule_id='$scheduled_id' AND trigger_code='$trigger_codeid'");
	$getXyz=$abc->row();
	$sql=$this->db->query("select * from tbl_schedule_spare_dtl where smsparetrigger_hdr_id='$getXyz->id' and spare_id='$spare_nameid'");

	$rws=$sql->num_rows();

	echo $rws;

}

//==============Close All Spare Parts functions========================================

//********************************Machine Metering*********************************************


public function insert_spare_unit()
{
	@extract($_GET);
	$table_name='tbl_machine_reading';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	//echo "fxgdgc".die;
	$data=array(
	'machine_id' => $_GET['pri_id_meter'],
	//'spare_id' => $_GET['code'],
	'reading'    => $_GET['readingmeter'],
	'unit'       => $_GET['unit_metering'],
	'date_time'  => $_GET['datetimepicker_mask']
	
	);


	$sesio = array(
					'maker_id'   => $this->session->userdata('comp_id'),
					'comp_id' 	 => $this->session->userdata('comp_id'),
					'divn_id' 	 => $this->session->userdata('divn_id'),
					'zone_id' 	 => $this->session->userdata('zone_id'),
					'brnh_id' 	 => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);



	$this->Model_admin_login->insert_user($table_name,$dataall);
	

//redirect("maintenance/schedule/get_metering_trigger?id=".$_GET['pri_id_meter']);
$this->load->view('get-current-metering',$data);

}

public function get_metering_trigger()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getmeter_currentData();
		//print_r($data);
	$this->load->view('get-current-metering',$data);	
}



//*****************************************************************************************************

public function getproduct()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data=array(
		'id' => $_GET['con'] 
		);
	
		$this->load->view('machine/getproduct',$data);
	}
	else
	{
		redirect('index');
	}
}

public function manageItemJoinfun()
	{

	$table_name='tbl_schedule_maintain';
	$data['result'] = "";
	////Pagination start ///
	$url   = site_url('maintenance/schedule/manage_schedule?');
	$sgmnt = "4";
	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;

	$totalData   = $this->model_master->count_schedule($table_name,'A',$this->input->get());
	//$showEntries= $_GET['entries']?$_GET['entries']:'12';


	if($_GET['entries']!="" && $_GET['filter'] == ""){
	$url   = site_url('maintenance/schedule/manage_schedule?entries='.$_GET['entries']);
	}elseif($_GET['filter'] != ""){
	$url   = site_url('maintenance/schedule/manage_schedule?entries='.$_GET['entries'].'&codee='.$_GET['codee'].'&m_type='.$_GET['m_type'].'&machine_name='.$_GET['machine_name'].'&machine_description='.$_GET['machine_description'].'&capacity='.$_GET['capacity'].'&filter='.$_GET['filter']);
	// sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
	}


	$pagination    = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data=$this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']        = $this->pagination->create_links();

	if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
	$data['result']       = $this->model_master->filterSchedule($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result'] = $this->model_master->getScheduleData($pagination['per_page'],$pagination['page']);


	// call permission fnctn
	$data['categorySelectbox'] = $this->model_master->categorySelectbox();	
	return $data;

}

public function getcat()
{
	
	$queryPo=$this->db->query("select *from tbl_machine where m_type='".$_GET['loc']."'");
	echo '<select>';
	echo '<option>----select----</option>';
	foreach($queryPo->result() as $getPO){
	
	echo '<option value='.$getPO->id.'>'.$getPO->machine_name.'</option>';

	}
	echo '</select>';		
	
}

public function getcatt()
{
	
	$queryPo=$this->db->query("select *from tbl_machine where m_type='".$_GET['loc']."'");
	echo '<select>';
	echo '<option>----select----</option>';
	foreach($queryPo->result() as $getPO){
	
	echo '<option value='.$getPO->id.'>'.$getPO->machine_name.'</option>';

	}
	echo '</select>';		
	
}


public function insert_scheduling()
{
	
	@extract($_POST);
	
	$table_name='tbl_schedule_triggering';
	
	$data=array(
	
	'schedule_id'			 => $scheduling_id,
	'machine_id'			 => $machine_id,
	'trigger_code'			 => $trigger_code,
	'every_reading' 		 => $every_name,
	'machine_current_reading'=> $machine_current_reading,
	'unit' 			 		 => $unit_meter,
	'starting_reading'   	 => $start_at,
	'next_trigger_reading'	 => $next_trigge_val_id,
	'type' 					 => $end_by,
	'endby_reading' 		 => $end_by_reading_meter
	
	);


	$sesio = array(
					'maker_id'   => $this->session->userdata('user_id'),
					'author_id'  => $this->session->userdata('user_id'),
					'comp_id'    => $this->session->userdata('comp_id'),
					'divn_id'    => $this->session->userdata('divn_id'),
					'zone_id'    => $this->session->userdata('zone_id'),
					'brnh_id'    => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);


	$this->Model_admin_login->insert_user($table_name,$dataall);

	echo 1;

}

public function insert_edit_scheduling()
{
	
	@extract($_POST);
	
	$table_name='tbl_schedule_triggering';
	$pri_col = 'id';
	$id= $scheduling_id_log;

	$data=array(
	
	'trigger_code'			 => $trigger_code,
	'every_reading' 		 => $every_name,
	'machine_current_reading'=> $machine_current_reading,
	'unit' 			 		 => $unit_meter,
	'starting_reading'   	 => $start_at,
	'next_trigger_reading'	 => $next_trigge_val_id,
	'type' 					 => $end_by,
	'endby_reading' 		 => $end_by_reading_meter
	
	);


	$sesio = array(
					'maker_id'   => $this->session->userdata('user_id'),
					'author_id'  => $this->session->userdata('user_id'),
					'comp_id'    => $this->session->userdata('comp_id'),
					'divn_id'    => $this->session->userdata('divn_id'),
					'zone_id'    => $this->session->userdata('zone_id'),
					'brnh_id'    => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

	$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
		
	echo 2;

}


public function get_schedule_trigger()
{
	@extract($_POST);
	$data=$this->user_function();// call permission fnctn
	$data['id'] = $id;
	$this->load->view('schedule/get-schedule-trigger',$data);	
}


public function trigger_code_validation()
{
	
	//print_r($_POST);die;
	$tids=$this->input->post('tid');
	$sids=$this->input->post('sid');

	$sqlquery=$this->db->query("select * from tbl_schedule_triggering where trigger_code='$tids' and schedule_id = '$sids'");
	$rw=$sqlquery->num_rows();

	if($rw>0){
		echo 1;
	}else{
		echo 2;
	}

}

public function PartsTriggerCode()
{
	
	$tids=$this->input->post('tid');
	$sids=$this->input->post('sid');

	//echo "select * from tbl_schedule_spare_hdr where trigger_code='$tids' and schedule_id='$sids'";die;
	$sqlquery=$this->db->query("select * from tbl_schedule_spare_hdr where trigger_code='$tids' and schedule_id='$sids'");
	$rw=$sqlquery->num_rows();

	if($rw>0){
		echo 1;
	}else{
		echo 2;
	}

}

public function addschedulingtrigger()
{

	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("schedule/add-scheduling-trigger",$data);	
		
}

public function addspareschedulingparts()
{

	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("schedule/add-spare-scheduling",$data);	
	
}

public function getschedulingtrigger()
{

	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("schedule/view-scheduling-trigger",$data);	
	
}


public function editschedulingtrigger()
{

	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("schedule/edit-scheduling-trigger",$data);	
	
}

public function manage_schedule_map()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data=$this->user_function();// call permission fnctn
		$data['result'] = $this->model_master->getScheduledData();
		$this->load->view('schedule/manage-schedule-map',$data);
	}
	else
	{
		redirect('index');
	}
}

//*******************************************************************************************************


public function ajex_spare_Data()
{
	
	//echo "djbv";
	$data['result'] = $this->model_master->get_spare_trigger_code();	 	
	$this->load->view('schedule/get-schedule-sparemap',$data);

} 

//******************************************************************************************************

public function insert_schedule_triggering_spare()
{
	//echo "suwub".die;
	@extract($_GET);
	$table_name='tbl_schedule_spare_hdr';
	
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(
	
	'schedule_id'			=> $_GET['code'],
	'trigger_code'			=> $_GET['trigger_code_spare_add'],
	'spare_id' 		 		=> $_GET['spare_name_map'],
	'quantity' 			 	=> $_GET['quantity_spare']
	
	
	);


	$sesio = array(
					'maker_id'   => $this->session->userdata('user_id'),
					'author_id'  => $this->session->userdata('user_id'),
					'comp_id'    => $this->session->userdata('comp_id'),
					'divn_id'    => $this->session->userdata('divn_id'),
					'zone_id'    => $this->session->userdata('zone_id'),
					'brnh_id'    => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);


	$this->Model_admin_login->insert_user($table_name,$dataall);

	
//redirect("maintenance/schedule/get_schedule_trigger?id=".$_GET['schedule_id']);
//$this->load->view('assets/machine/get_machine');

}





public function insert_schedule_triggering_edit()
{
	//echo "suwub".die;
	@extract($_GET);
	$table_name='tbl_schedule_triggering';
	//$id = 'schedule_id';
	$pri_col = 'id';
	$id= $id;
	$starting_reading =$_GET['start_reading_meter'];
	$next_trigger_reading =$_GET['next_trigger_reading_meter'];
	//echo $starting_reading;
	//echo $next_trigger_reading;die;
	//echo "uwh".$id;
	
	
	$data=array(
	
	'schedule_id'			 => $_GET['pri_idd'],
	'trigger_code'			 => $_GET['trigger_code_meter'],
	'machine_id'			 => $_GET['machine_trigger_id_edit'],
	'every_reading' 		 => $_GET['every_reading_meter'],
	'unit' 			 		 => $_GET['unit_meter'],
	'starting_reading'   	 => $_GET['start_reading_meter'],
	'next_trigger_reading'	 => $_GET['next_trigger_reading_meter'],
  	'next_trigger_reading'	 => $_GET['next_trigger_reading_meter_add'],
	'type' 					 => $_GET['readtype_meter'],
	'endby_reading' 		 => $_GET['end_by_reading_meter']
	
	);


	
   

	
	$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
	
	
	if($starting_reading > $next_trigger_reading){
	//echo $next_trigger_reading;die;
	$sqltriggerspa2="insert into tbl_schedule_triggering_log set schedule_id ='$pri_idd', trigger_code='$trigger_code_meter',next_trigger_reading='$next_trigger_reading_meter_add',machine_id='$machine_trigger_id_edit', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'"; 
			$this->db->query($sqltriggerspa2);
			
	$sqltriggerspa2="insert into tbl_work_order_maintain set schedule_id ='$pri_idd', trigger_code='$trigger_code_meter',next_trigger_reading='$next_trigger_reading_meter_add',maintyp='$maintenance_type_id',priority='$priority_id',wostatus='$work_order_status_id',machine_name='$machine_trigger_id_edit', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'"; 
			$this->db->query($sqltriggerspa2);
	}
	
redirect("maintenance/schedule/get_schedule_trigger?id=".$_GET['pri_idd']);
//$this->load->view('assets/machine/get_machine');

}





public function ajax_productlist()
{
	$result = $this->model_master->mod_productList($this->input->post('value')); 
	if(sizeof($result) > 0)
	{
		foreach ($result as  $dt) 
		{
			if($dt['productname']!= "")
			{
				echo "<a class='form-control listpro' jsvalue='".json_encode($dt)."' onclick='selectList(this)'>".$dt['productname']."</a>";
		    }
		}
    }
    else
	  echo "<a class='form-control' value='Not Found !'> Not Found !</a>";	
		    
}




public function test_sch()
{
	@extract($_POST);
		
	echo $trigger_code_shed;	

	print_r($qnty)."<br>";
	print_r($spare_name_sched);
}



public function insert_schedule_triggering_spare1()
{


	@extract($_POST);
	$table_name='tbl_schedule_spare_hdr';
	$spare_name_schedd =count($spare_name_sched);
	
	for($i=0;$i< $spare_name_schedd;$i++)
	{
	
		 $mapdata = array
		 (
		 	'schedule_id'					 => $pri_id_schedule_id,
		    'trigger_code'        			 => $trigger_code_shed,
			'machine_id'        			 => $machine_spare_id,		    
			'spare_id'              		 => $spare_name_sched[$i],
			'quantity'             			 => $qnty[$i]
		   );
	//print_r($qnty);
	//print_r($mapdata);
	$sesio = array(
					'maker_id'   => $this->session->userdata('user_id'),
					'author_id'  => $this->session->userdata('user_id'),
					'comp_id'    => $this->session->userdata('comp_id'),
					'divn_id' 	 => $this->session->userdata('divn_id'),
					'zone_id' 	 => $this->session->userdata('zone_id'),
					'brnh_id' 	 => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($mapdata,$sesio);


	$this->Model_admin_login->insert_user($table_name,$dataall);
	
	$lhh="insert into tbl_work_order_spare set schedule_id ='$pri_id_schedule_id', trigger_code='$trigger_code_shed',machine_id='$machine_spare_id',spare_id = '$spare_name_sched[$i]',quantity = '$qnty[$i]', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'"; 
			$this->db->query($lhh);
	
	}
	echo 1;
	

}

public function insert_schedule_triggering_spare12()
{


	@extract($_POST);
	$table_name='tbl_schedule_spare_hdr';
	$pri_col='id';
	$id='pri_id_spare_sched_edit';
					
	
	$delquery =	"delete from tbl_schedule_spare_hdr where trigger_code = '$triggercode_edit' and schedule_id = '$pri_id_schedule_id_edit'";
	$this->db->query($delquery);
	$spare_name_schedd_edit =count($spare_name_sched_edit);
	
	
	for($i=0;$i< $spare_name_schedd_edit;$i++)
	{
	
		 $mapdata = array
		 (
		 	'schedule_id'					 => $pri_id_schedule_id_edit,
		    'trigger_code'        			 => $triggercode_edit,
			'machine_id'        			 => $machine_spare_edit_id,
			'spare_id'              		 => $spare_name_sched_edit[$i],
			'quantity'             			 => $qnty_edit[$i]
		   );
	$sesio = array(
					'maker_id' => $this->session->userdata('comp_id'),
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_date'=> date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
					
					$dataall = array_merge($mapdata,$sesio);
					//print_r($dataall);
					
		$this->Model_admin_login->insert_user($table_name,$dataall);
	
	}
	
	echo 2;

}

public function triggerCode_validate()
{

	$query=$this->db->query("select * from tbl_schedule_triggering where status='A'and schedule_id ='".$_GET['codeval_id']."' and trigger_code='".$_GET['codeval']."'");
	$getQuery = $query->num_rows();

	echo $getQuery;

	//$this->load->view('assets/machine/validate-code-value',$data);

}

public function triggerCode_validate_spare()
{
				
	$query=$this->db->query("select * from tbl_schedule_spare_hdr where status='A' and schedule_id = '".$_GET['codeval_id_edit']."' and trigger_code='".$_GET['codeval']."'");
	$getQuery = $query->num_rows();
	
	echo $getQuery;
							
	//$this->load->view('assets/machine/validate-code-value',$data);

}


public function scheduleCode_validate()
{
				
	$id=$this->input->get("codeval");			
	$query=$this->db->query("select * from tbl_schedule_maintain where status='A' and code='$id'");
	$getQuery = $query->num_rows();
	
	echo $getQuery;
							
	//$this->load->view('assets/machine/validate-code-value',$data);

}


//======================= Start All Spare Parts functions ===================================

public function insert_schedule_parts()
{
	@extract($_POST);
	$table_name='tbl_workorder_spare_hdr';

	$rows=count($spareids);

					$maker_id 	= $this->session->userdata('user_id');
					$author_id  = $this->session->userdata('user_id');
					$comp_id 	= $this->session->userdata('comp_id');
					$divn_id 	= $this->session->userdata('divn_id');
					$zone_id 	= $this->session->userdata('zone_id');
					$brnh_id 	= $this->session->userdata('brnh_id');
					$maker_date = date('Y-m-d');
					$author_date= date('Y-m-d');
							
			$this->db->query("insert into tbl_workorder_spare_hdr set work_order_id='$spare_work_order_id',type='Parts', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id',author_date='$author_date'");

		$last=$this->db->insert_id();
		
		for($i=0;$i<$rows;$i++)
		{

			$this->db->query("insert into tbl_workorder_spare_dtl set spare_hdr_id='$last',spare_id='$spareids[$i]', qty_name='$qtyname[$i]',via_type='$via_types[$i]', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date',author_id='$author_id'");
		}


	echo 1;
}

public function get_schedule_parts()
{
	@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $id;
	$this->load->view('schedule/get-schedule-parts',$data);	
}

//==============Close All Spare Parts functions========================================

//======================= Start All Tools functions ===================================

public function insert_schedule_tools()
{
	
	@extract($_POST);
	$table_name='tbl_schedule_tools_hdr';

	$rows=count($toolids);

					$maker_id   = $this->session->userdata('user_id');
					$author_id  = $this->session->userdata('user_id');
					$comp_id    = $this->session->userdata('comp_id');
					$divn_id 	= $this->session->userdata('divn_id');
					$zone_id 	= $this->session->userdata('zone_id');
					$brnh_id 	= $this->session->userdata('brnh_id');
					$maker_date = date('Y-m-d');
					$author_date= date('Y-m-d');
							
			$this->db->query("insert into tbl_workorder_spare_hdr set work_order_id='$tools_workorder_id',type='Tools', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id', author_date='$author_date'");

		$last=$this->db->insert_id();
		
		for($i=0;$i<$rows;$i++)
		{

			$this->db->query("insert into tbl_workorder_spare_dtl set spare_hdr_id='$last',spare_id='$toolids[$i]', qty_name='$qtyname[$i]',via_type='$via_types[$i]', maker_id='$maker_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date',author_id='$author_id', author_date='$author_date'");
		}

	echo 1;

}

public function get_schedule_tools()
{
	@extract($_POST);

	$data=$this->user_function();// call permission fnctn
	$data['id'] = $id;
	$this->load->view('schedule/get-schedule-tools',$data);	
}

//==============Close All Tools functions========================================

public function view_schedule_parts()
{

	$data=array(
	'id' => $_GET['ID']
	);	
	
	//echo $data; die;
	$this->load->view("schedule/view-schedule-parts",$data);	
	
}

public function view_schedule_tools()
{
	
	$data=array(
	'id' => $_GET['ID']
	);	
	
	$this->load->view("schedule/view-schedule-tools",$data);	
	
}


/*========================Start All file uploads =================================================*/

public function insert_schedule_files()
{
	
	@extract($_POST);
	$table_name='tbl_machine_files_uploads';
	
	if($_FILES['image_name']['name']!='')
	{
		$target = "filesimages/schedule_files/"; 
		$target1 =$target . @date(U)."_".( $_FILES['image_name']['name']);
		$image_name=@date(U)."_".( $_FILES['image_name']['name']);
		move_uploaded_file($_FILES['image_name']['tmp_name'], $target1);
	}	


	$data=array(
			
				'module_type' => 'Schedule',
				'file_log_id' => $schedule_id,
				'file_name'   => $image_name,
				'desc_id'     => $desc_id	
		
			   );


	$sesio = array(
					'maker_id'  => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'comp_id'   => $this->session->userdata('comp_id'),
					'divn_id'   => $this->session->userdata('divn_id'),
					'zone_id'   => $this->session->userdata('zone_id'),
					'brnh_id'   => $this->session->userdata('brnh_id'),
					'maker_date'  => date('Y-m-d'),
					'author_date' => date('Y-m-d')
				  );
		
		$dataall = array_merge($data,$sesio);

	$this->Model_admin_login->insert_user($table_name,$dataall);

		
}


public function get_schedule_files()
{
	@extract($_POST);
	$data=$this->user_function();// call permission fnctn	
	$data['id'] = $id;
	$this->load->view("schedule/get-schedule-uploads-file",$data);	
}

/*=========================Close all file uploads function ==================================*/


public function check_product_type()
{
	$prdctid=$this->input->post('pid');
	$product=$this->db->query("select * from tbl_product_stock where Product_id='$prdctid'");
	$getProductRow=$product->row();

	echo $getProductRow->via_type;
}

}
?>