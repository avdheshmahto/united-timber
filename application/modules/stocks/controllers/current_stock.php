<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);

class current_stock extends my_controller {
function __construct()
{
	parent::__construct(); 
	$this->load->library('pagination');
	$this->load->model('model_current_stock');	
}     


public function fetchlocationrack_ab()
{
	$location= array('id' =>$_GET['id']);
	$this->load->view('fetchlocationracks',$location);
}	



/*=================================Start Spare Current Stock ================================*/

function manage_current_stock() 
{
	
	extract($_POST);
    if($this->session->userdata('is_logged_in'))
    {
		$data = $this->manageItemJoinfunSearch();
    	$this->load->view('current-stock',$data);
	}
	else
	{
		redirect('index');
	}

}

public function manageItemJoinfunSearch()
{
    
	$table_name='tbl_product_serial';
	$data['result'] = "";
	////Pagination start ///
	$url   = site_url('/stocks/current_stock/manage_current_stock?');
	$sgmnt = "4";

	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;


	$totalData   = $this->model_current_stock->count_allproduct_spare($table_name,'A',$this->input->get());


	if($_GET['entries']!="" && $_GET['filter'] != 'filter'){
	$url   = site_url('/stocks/current_stock/manage_current_stock?entries='.$_GET['entries'].'&code='.$_GET['code'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']);
	}elseif($_GET['filter'] == 'filter' || $_GET['entries'] != ''){
	$url   = site_url('/stocks/current_stock/manage_current_stock?entries='.$_GET['entries'].'&code='.$_GET['code'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']);


	}
	else
	{
	$url = site_url('/stocks/current_stock/manage_current_stock?');
	}


	$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data       = $this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']  = $this->pagination->create_links();

	if($_GET['filter'] != "")   ////filter start ////
	$data['result']  = $this->model_current_stock->filterListproduct_spare($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result']  = $this->model_current_stock->product_spare_get($pagination['per_page'],$pagination['page']);

	// call permission fnctn
	return $data;

}
//******************************************************************************************

/*=================================Start Tools Current Stock ================================*/

function manage_tools_current_stock() 
{
	extract($_POST);
    if($this->session->userdata('is_logged_in'))
    {
		$data = $this->manageToolsJoinfunSearch();
	    $this->load->view('tools-current-stock',$data);
	}
	else
	{
		redirect('index');
	}
}

public function manageToolsJoinfunSearch()
{

	$table_name='tbl_product_serial';
	$data['result'] = "";
	////Pagination start ///
	$url   = site_url('/stocks/current_stock/manage_tools_current_stock?');
	$sgmnt = "4";

	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;


	$totalData   = $this->model_current_stock->count_allproduct_tools($table_name,'A',$this->input->get());


	if($_GET['entries']!="" && $_GET['filter'] != 'filter'){
	$url   = site_url('/stocks/current_stock/manage_tools_current_stock?entries='.$_GET['entries'].'&code='.$_GET['code'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']);
	}elseif($_GET['filter'] == 'filter' || $_GET['entries'] != ''){
	$url   = site_url('/stocks/current_stock/manage_tools_current_stock?entries='.$_GET['entries'].'&code='.$_GET['code'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']);


	}
	else
	{
	$url = site_url('/stocks/current_stock/manage_tools_current_stock?');
	}


	$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data       = $this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']        = $this->pagination->create_links();

	if($_GET['filter'] != "")   ////filter start ////
	$data['result']          = $this->model_current_stock->filterListproduct_tools($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result']          = $this->model_current_stock->product_tools_get($pagination['per_page'],$pagination['page']);

	// call permission fnctn
	return $data;

}
//*******************************************************************************************************




}
?>