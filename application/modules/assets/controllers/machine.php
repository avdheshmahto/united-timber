<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class machine extends my_controller {


function __construct()
{
    parent::__construct(); 
    $this->load->library('pagination');
    $this->load->model('model_master');	
}


public function manage_machine()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data = $this->manageItemJoinfun();
		//$data['result'] = $this->model_master->getMachineData();	
		$this->load->view('machine/manage-machine',$data);
	}
	else
	{
		redirect('index');
	}
}

public function get_machine()
{
	if($this->session->userdata('is_logged_in'))
	{
    	$data = $this->manageItemJoinfun();
		//$data=$this->user_function();// call permission fnctn
		//$data['result'] = $this->model_master->getMachineData();	
		$this->load->view('machine/get-machine',$data);
	}
	else
	{
		redirect('index');
	}
}


public function insert_machine()
{
		
	@extract($_GET);
	$table_name='tbl_machine';
	$id=$this->input->get('id');
	$pri_col='id';	
	

	$data=array(
			 
			  'code' 		=> $code,
			  'm_type' 		=> $m_type,
			  'machine_name'=> $machine_name,
			  'machine_des' => $machine_des,
			  'capacity' 	=> $capacity,
			  'm_unit' 		=> $m_unit
			  
		    );

   $sesio = array(
			
				'maker_id' 	=> $this->session->userdata('user_id'),
				'author_id' => $this->session->userdata('user_id'),
				'comp_id' 	=> $this->session->userdata('comp_id'),
				'divn_id' 	=> $this->session->userdata('divn_id'),
				'zone_id' 	=> $this->session->userdata('zone_id'),
				'brnh_id' 	=> $this->session->userdata('brnh_id'),
				'maker_date' => date('Y-m-d'),
				'author_date'=> date('Y-m-d')
		
			);
		
   $dataall = array_merge($data,$sesio);

   if($id!='')
   {

	$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
   }else{
	$this->Model_admin_login->insert_user($table_name,$dataall);
   }
  redirect("assets/machine/get_machine");
  //$this->load->view('assets/machine/get_machine');

}


public function getMachinePage()
{
	
	$data=array(
	'id' => $_GET['id'],
	'type' => $_GET['type']
	);	
	$data['categorySelectbox'] = $this->model_master->categorySelectbox();			
	$this->load->view("assets/machine/edit-machine",$data);	
	
}

public function getMachineMetering()
{
	
	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("assets/machine/add-machine-metering",$data);	
	
}

public function getMachineWarranties()
{
	
	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("assets/machine/add-machine-warranties",$data);	
		
}

public function getMachineSuppliers()
{
	
	$data=array(
	'id' => $_GET['ID']
	);	
		
	$this->load->view("assets/machine/add-machine-Suppliers",$data);	
		
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
    
	$table_name='tbl_machine';
	$data['result'] = "";
	////Pagination start ///
	$url   = site_url('/assets/machine/manage_machine?');
	$sgmnt = "4";
	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;

	$totalData   = $this->model_master->count_machine($table_name,'A',$this->input->get());
	//$showEntries= $_GET['entries']?$_GET['entries']:'12';


	if($_GET['entries']!="" && $_GET['filter'] == ""){
	$url   = site_url('//assets/machine/manage_machine?entries='.$_GET['entries']);
	}elseif($_GET['filter'] != ""){
	$url   = site_url('//assets/machine/manage_machine?entries='.$_GET['entries'].'&codee='.$_GET['codee'].'&m_type='.$_GET['m_type'].'&machine_name='.$_GET['machine_name'].'&machine_description='.$_GET['machine_description'].'&capacity='.$_GET['capacity'].'&filter='.$_GET['filter']);
	// sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
	}


	$pagination    = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data=$this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']        = $this->pagination->create_links();

	if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
	$data['result']       = $this->model_master->filterMachine($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result'] = $this->model_master->getMachineData($pagination['per_page'],$pagination['page']);


	// call permission fnctn
	$data['categorySelectbox'] = $this->model_master->categorySelectbox();	
	return $data;

}




public function insert_spare()
{
	
	@extract($_GET);
	$table_name='tbl_machine_spare_map';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(
	'machine_id' => $_GET['machine_name'],
	'spare_id'   => $_GET['code'],
	'reading'    => $_GET['reading'],
	'unit'       => $_GET['unitt'],
	'quantity'   => $_GET['qty']
	
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
	
   redirect("assets/machine/get_spare?id=".$_GET['machine_name']);
  //$this->load->view('assets/machine/get_machine');

}

/*=========================================================================*/

public function insert_machine_warranty()
{
	
	@extract($_GET);
	$table_name='tbl_machine_warranty';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(

		'module_type' 				=> 'Machine',
		'warranty_log_id' 			=> $_GET['machine_id'],
		'warranty_type' 			=> $_GET['warranty_type'],
		'provider_id' 				=> $_GET['provider'],
		'warranty_usage_term_type'  => $_GET['wrty_term_type'],
		'meter_reading_value_limit' => $_GET['meter_limit'],
		'meter_reading_units'   	=> $_GET['meter_reading_units'],
		'expiry_date'   			=> $_GET['expiry_date'],
		'certificate_number'   		=> $_GET['certificate_no'],
		'description_name'   		=> $_GET['desc'],
		'date_added' 				=> $_GET['date_added']
	
	);


	$sesio = array(
					'maker_id' => $this->session->userdata('user_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'comp_id'  => $this->session->userdata('comp_id'),
					'divn_id'  => $this->session->userdata('divn_id'),
					'zone_id'  => $this->session->userdata('zone_id'),
					'brnh_id'  => $this->session->userdata('brnh_id'),
					'maker_date'  => date('Y-m-d'),
					'author_date' => date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

 	  $this->Model_admin_login->insert_user($table_name,$dataall);
	
	redirect("assets/machine/get_machine_warranty?id=".$_GET['machine_id']);

}


public function get_machine_warranty()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getMachineWarrantyData();
	$this->load->view("machine/get-machine-warranty",$data);	
}

/*=========================================================================*/

/*=========================================================================*/

public function insert_machine_suppliers()
{
	@extract($_GET);
	$table_name='tbl_machine_suppliers';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(
	'machine_id' 	 => $_GET['machine_id'],
	'suppliers_name' => $_GET['supplier_name'],
	'suppliers_type' => $_GET['supplier_type'],
	'supplier_part_number'  => $_GET['Supplier_part_number'],
	'catalog_name'   		=> $_GET['catelog_id']	
	
	);


	$sesio = array(

					'maker_id'  => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'comp_id'   => $this->session->userdata('comp_id'),
					'divn_id'   => $this->session->userdata('divn_id'),
					'zone_id'   => $this->session->userdata('zone_id'),
					'brnh_id'   => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
				
				 );
		
		$dataall = array_merge($data,$sesio);



	$this->Model_admin_login->insert_user($table_name,$dataall);
	

redirect("assets/machine/get_machine_suppliers?id=".$_GET['machine_id']);

}


public function get_machine_suppliers()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getMachineSuppliersData();
	$this->load->view("machine/get-machine-suppliers",$data);	
}

/*=========================================================================*/


/*=========================================================================*/

public function insert_machine_files()
{
	
	@extract($_POST);
	$table_name='tbl_machine_files_uploads';
	
	if($_FILES['image_name']['name']!='')
	{
		$target = "filesimages/machinefiles/"; 
		$target1 =$target . @date(U)."_".( $_FILES['image_name']['name']);
		$image_name=@date(U)."_".( $_FILES['image_name']['name']);
		move_uploaded_file($_FILES['image_name']['tmp_name'], $target1);
	}	


	$data=array(

			'module_type' => 'Machine',
			'file_log_id' => $machine_id,
			'file_name'   => $image_name,
			'desc_id' 	  => $desc_id	
		
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


public function get_machine_files()
{
	@extract($_POST);
	$data=$this->user_function();// call permission fnctn	
	$data['id'] = $id;
	$this->load->view("machine/get-machine-uploads-file",$data);	
}

/*=========================================================================*/

/*===========================Start machine metering===========================================*/

public function insert_spare_unit()
{
	@extract($_GET);
	
	date_default_timezone_set('Asia/Kolkata');
	$dt    = new DateTime();
	$mdate = $dt->format('d/m/Y H:i:s');	

	$table_name           ='tbl_machine_reading';
	$table_name_log       ='tbl_schedule_triggering_log';
	$table_name_workorder ='tbl_work_order_maintain';

	$machineid      = $_GET['machine_name'];
	$machinereading = $_GET['readingg'];

	$sqlq=$this->db->query("select * from tbl_schedule_triggering where machine_id = '$machineid' and status='A' order by id desc limit 0,1"); 
	$getdata=$sqlq->row();
	
	$schdlTrgId = $getdata->id;
	
	$scheduleid=$getdata->schedule_id;

	$sqlsheduling=$this->db->query("select * from tbl_schedule_maintain where id='$scheduleid' and status='A'"); 
	$getdatascheduling=$sqlsheduling->row();

	$wostatusid = $getdatascheduling->wostatus;
	$priorityid = $getdatascheduling->priority;
	$maintypid  = $getdatascheduling->maintyp;

	$machineid       = $getdata->machine_id;
	$everyreading    = $getdata->every_reading;
	$unitval         = $getdata->unit;
	$triggercode     = $getdata->trigger_code;
	$typeval         = $getdata->type;
	$endbyreading    = $getdata->endby_reading;
	$startingreading = $getdata->starting_reading;
	$nexttriggerval  = $getdata->next_trigger_reading;

	$sqlsheduling=$this->db->query("select * from tbl_schedule_triggering_log where next_trigger_reading='$nexttriggerval'"); 
	$rwlog=$sqlsheduling->num_rows();

	$data=array(

				'machine_id'   => $_GET['machine_name'],
				'spare_id'     => $_GET['code'],
				'reading'  	   => $_GET['readingg'],
				'unit'   	   => $_GET['unittt'],
				'date_time'    => $_GET['datetimepicker_mask']
				
			   );

	$datashedulinglog=array(
						
							'machine_id' 		=> $machineid,
							'schedule_id' 		=> $scheduleid,
							'every_reading' 	=> $everyreading,
							'unit'   			=> $unitval,
							'trigger_code'   	=> $triggercode,
							'type'   			=> $typeval,
							'starting_reading'  => $startingreading,
							'endby_reading'   		=> $endbyreading,
							'next_trigger_reading'  => $nexttriggerval
			
						);

	$dataworkorder=array(
						
						'trigger_code' 			=> $triggercode,
						'schedule_id' 			=> $scheduleid,
						'next_trigger_reading'  => $nexttriggerval,
						'machine_name'   		=> $machineid,
						'wostatus'   			=> $wostatusid,
						'date_time'   			=> $mdate,
						'priority'   			=> $priorityid,
						'maintyp'   			=> $maintypid
					
						);

	$sesio = array(
					'maker_id' 	  => $this->session->userdata('user_id'),
					'author_id'   => $this->session->userdata('user_id'),
					'comp_id'     => $this->session->userdata('comp_id'),
					'divn_id'     => $this->session->userdata('divn_id'),
					'zone_id'     => $this->session->userdata('zone_id'),
					'brnh_id'     => $this->session->userdata('brnh_id'),
					'maker_date'  => date('Y-m-d'),
					'author_date' => date('Y-m-d')
					);
		

		$dataall 		  = array_merge($data,$sesio);
		$dataalllog 	  = array_merge($datashedulinglog,$sesio);
		$dataallworkorder = array_merge($dataworkorder,$sesio);


	if($machinereading>=$nexttriggerval)
	{
	 	//echo "hello1";
	 	if($rwlog>0)
	 	{
	 		$this->Model_admin_login->insert_user($table_name,$dataall);
	 	}
	 	else
	 	{
	 		$this->Model_admin_login->insert_user($table_name,$dataall);
	 		$this->Model_admin_login->insert_user($table_name_log,$dataalllog);
	 		$this->Model_admin_login->insert_user($table_name_workorder,$dataallworkorder);
	 		
	 		$nextTrg=$nexttriggerval + $everyreading;

	 		if($endbyreading == '')
	 		{
	 			$this->db->query("update tbl_schedule_triggering set next_trigger_reading
=$nextTrg where id='$schdlTrgId'");
	 		}
	 		elseif($nextTrg <= $endbyreading)
	 		{
	 			$this->db->query("update tbl_schedule_triggering set next_trigger_reading
=$nextTrg where id='$schdlTrgId'");
	 		}
	 		
	 	}
	}
	else
	{
	  	//echo "hello2";
	  	$this->Model_admin_login->insert_user($table_name,$dataall);
	}	
	
  redirect("assets/machine/get_spared?id=".$_GET['machine_name']);

}

/*=========================Close machine metering==========================================*/

public function manage_spare_map()
{
	if($this->session->userdata('is_logged_in'))
	{
		//$data=$this->user_function();// call permission fnctn
		//$data['result'] = $this->model_master->getSpareData();
		$this->load->view('machine/manage-spare-map');
	}
	else
	{
		redirect('index');
	}
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


public function ajax_productlists()
{
	$result = $this->model_master->mod_productList($this->input->post('value')); 
	if(sizeof($result) > 0)
	{
		foreach ($result as  $dt) 
		{
			if($dt['productname']!= "")
			{
				echo "<a class='form-control listpro' jsvalue='".json_encode($dt)."' onclick='selectLists(this)'>".$dt['productname']."</a>";
		    }
		}
    }
    else
	  echo "<a class='form-control' value='Not Found !'> Not Found !</a>";	
		    
}



public function get_spare()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getSpareData();
	$this->load->view("machine/get-spare",$data);	
}

public function get_spared()
{
	//echo "eufjbnej";
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getSpareDataunit();
	$this->load->view("machine/get-spared",$data);	
}

public function codevalidation()
{

	$data['prd']=$_GET['codeval'];

	$this->load->view('assets/machine/validate-spare-value',$data);

}


public function check_machine_code()
{
	$id=$this->input->post('id');
	$abc=$this->db->query("select * from tbl_machine where code='$id' ");
	$count=$abc->num_rows();

	if($count > 0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}



}
?>