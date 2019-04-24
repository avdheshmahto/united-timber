<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class facilities extends my_controller {


function __construct()
{
    parent::__construct(); 
    $this->load->library('pagination');
    $this->load->model('model_master_facilities');	
}


public function manage_facilities()
{
	
	if($this->session->userdata('is_logged_in'))
	{	
		$data = $this->manageItemJoinfun();
		//$data['result'] = $this->model_master_breakdown->getbreakdownData();	
		$this->load->view('machine/manage-facilities',$data);
	}
	else
	{
		redirect('index');
	}
		
}


public function manageItemJoinfun()
{
    
		  $table_name='tbl_facilities';
    	  $data['result'] = "";
		  ////Pagination start ///
		  $url   = site_url('/assets/facilities/manage_facilities?');
		  $sgmnt = "4";

		  if($_GET['entries']!="")
		  	$showEntries = $_GET['entries'];
		  else
		  	$showEntries = 10;
		 
		 
		 $totalData   = $this->model_master_facilities->count_allfacility($table_name,'A',$this->input->get());

		  
		  if($_GET['entries']!="" && $_GET['filter'] == ""){
			 $url   = site_url('/assets/facilities/manage_facilities?entries='.$_GET['entries']);
		  }elseif($_GET['filter'] != ""){
		  	 $url   = site_url('/assets/facilities/manage_facilities?entries='.$_GET['entries'].'&fac_code='.$_GET['fac_code'].'&fac_name='.$_GET['fac_name'].'&fac_loc='.$_GET['fac_loc'].'&filter='.$_GET['filter']);
		  	 // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
		  }



		  $pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
          $data       = $this->user_function();
	      //////Pagination end ///
 		  $data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
		  $data['pagination']        = $this->pagination->create_links();
		
		  if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
			$data['result']          = $this->model_master_facilities->filterListfacility($pagination['per_page'],$pagination['page'],$this->input->get());
		  else	
			$data['result']          = $this->model_master_facilities->getfacilityData($pagination['per_page'],$pagination['page']);

          // call permission fnctn
	      return $data;

}



public function insert_facilities()
{
	
	@extract($_GET);
	//echo $id ."hgsfgh";die;	
	$table_name='tbl_facilities';
	$id=$this->input->get('id');
	$pri_col='id';	
	

	$data=array(
	  'fac_code' 	=> $fac_code,
	  'fac_name' 	=> $fac_name,
	  'fac_loc' 	=> $fac_loc,
    );

   $sesio = array(
		'maker_id' 		=> $this->session->userdata('comp_id'),
		'comp_id' 		=> $this->session->userdata('comp_id'),
		'divn_id' 		=> $this->session->userdata('divn_id'),
		'zone_id' 		=> $this->session->userdata('zone_id'),
		'brnh_id' 		=> $this->session->userdata('brnh_id'),
		'maker_date'	=> date('Y-m-d'),
		'author_date'	=> date('Y-m-d')
		);
		
   $dataall = array_merge($data,$sesio);

  if($id!='')
   {
	
	$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
	echo 2;
  }else
   {
   
	$this->Model_admin_login->insert_user($table_name,$dataall);
   echo 1;
   }
  //echo 1;
  redirect("assets/facilities/get_manage_facilities");
  //$this->load->view('assets/machine/get_machine');

}

public function get_manage_facilities()
{
	
	if($this->session->userdata('is_logged_in'))
	{	
		$data = $this->manageItemJoinfun();
		//$data['result'] = $this->model_master_breakdown->getbreakdownData();	
		$this->load->view('machine/get-facilities',$data);
	}
	else
	{
		redirect('index');
	}
		
}


public function getfacility_edit()
{

	$data=array(
	'id' => $_GET['id'],
	'type' => $_GET['type']
	);	
		//print_r($data);
	$this->load->view("assets/machine/edit-facilities",$data);	
	
}

public function dropdown_func()
{
	$this->load->view('assets/machine/dropdown');
}

public function manage_spare_map()
{

	if($this->session->userdata('is_logged_in'))
	{
		$data=$this->user_function();// call permission fnctn
	    $data['result'] = $this->model_master->getSpareData($this->input->get('id'));
		$this->load->view('machine/manage-spare-map',$data);
	}
	else
	{
		redirect('index');
	}
	
}

public function codevalidation()
{
		
	$data['code']=$_GET['codeval'];
	$this->load->view('assets/machine/validate-code-value',$data);

}

public function excel_manage_facilities()
{
	$this->load->view('assets/machine/excel_manage_facilities');		
}




}
?>