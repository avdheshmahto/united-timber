<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Mainlocation extends my_controller {

function __construct()
{
   
   parent::__construct();
   $this->load->model('model_main_location');
   $this->load->library('pagination');

}     


public function manage_main_location()
{
	
	if($this->session->userdata('is_logged_in'))
	{
		$data=$this->user_function();// call permission fnctn
		$data = $this->manageItemJoinfun();
		//$data['result'] = $this->model_locationrack->locationrack();
		$this->load->view('manage-main-location',$data);
	}
	else
	{
		redirect('index');
	}
		
}


public function manageItemJoinfun()
{
    
		  $table_name='tbl_master_data';
    	  $data['result'] = "";
		  ////Pagination start ///
		  $url   = site_url('/rack/Mainlocation/manage_main_location?');
		  $sgmnt = "4";

		  if($_GET['entries']!="")
		  	$showEntries = $_GET['entries'];
		  else
		  	$showEntries = 10;
		 
		 
		 $totalData   = $this->model_main_location->count_allproduct($table_name,'A',$this->input->get());

		  
		  if($_GET['entries']!="" && $_GET['filter'] == ""){
			 $url   = site_url('/rack/Mainlocation/manage_main_location?entries='.$_GET['entries']);
		  }elseif($_GET['filter'] != ""){
		  	 $url   = site_url('/rack/Mainlocation/manage_main_location?entries='.$_GET['entries'].'&location_rack_id='.$_GET['location_rack_id'].'&rack_name='.$_GET['rack_name'].'&filter='.$_GET['filter']);
		  	 // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
		  }



		  $pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
          $data       = $this->user_function();
	      //////Pagination end ///
 		  $data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
		  $data['pagination']        = $this->pagination->create_links();
		
		  if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
			$data['result']          = $this->model_main_location->filterListproduct($pagination['per_page'],$pagination['page'],$this->input->get());
		  else	
			$data['result']          = $this->model_main_location->location($pagination['per_page'],$pagination['page']);

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
	if($this->session->userdata('is_logged_in'))
	{
		$this->load->view('add-location-rack');
	}
	else
	{
		redirect('index');
	}
}


public function insert_main_location()
{
	
		@extract($_POST);
		$table_name ='tbl_master_data';
		$pri_col ='serial_number';
	 	$serial_number= $serial_number;
		$param_id = '21';
		$data= array(
					
					'param_id' => ('21'),
					'keyvalue' => $this->input->post('loc_name')
		      	);
		

	$sesio = array(
					
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

		$this->load->model('Model_admin_login');
	
		if($id!='')
		{
		
			$this->Model_admin_login->update_user($pri_col,$table_name,$id,$dataall);
			redirect('/rack/Mainlocation/manage_main_location');
			//echo "<script type='text/javascript'>";
			//echo "window.close();";
			//echo "window.opener.location.reload();";
					
		}             
		else
		{
									
		    $this->Model_admin_login->insert_user($table_name,$dataall);			
			redirect('/rack/Mainlocation/manage_main_location');		
		
		}
}



public function getmainLocationPage()
{
	
	if($this->session->userdata('is_logged_in'))
	{
		 $data=array(
		 'id' => $_GET['id'],
		 'type' => $_GET['type']
		 );
		$this->load->view('edit-main-location',$data);
	}
	else
	{
		redirect('index');
	}

}


public function Insert_Location()
{

		//echo "hello insert_location";die;		
		$pri_col="serial_number";
		$table_name="tbl_master_data";
		$id=$_POST['id'];

		$location=array(
				
					'param_id'    => ('21'),
					'keyvalue'    => $_POST["loc_name"],
					
					'maker_id'    => $this->session->userdata('maker_id'),
					'comp_id'     => $this->session->userdata('comp_id'),
					'divn_id'     => $this->session->userdata('divn_id'),
					'zone_id'     => $this->session->userdata('zone_id'),
					'brnh_id'     => $this->session->userdata('brnh_id'),
					'maker_id'    => $this->session->userdata('user_id'),
					'author_id'   => $this->session->userdata('user_id'),
					'maker_date'  => date('y-m-d'),
					'author_date' => date('y-m-d')
				
				);

		if($id !='')
		{
			$this->model_main_location->update_user($table_name,$pri_col,$id,$location);
			echo "1";
		}	
		else
		{
			$this->model_main_location->insert_user($table_name,$location);
			echo "0";
		}

}

function LocationTable()
{
		//echo "table";
		$data=$this->manageItemJoinfun();
		$this->load->view("rack/LocationTable",$data);
}

}

?>