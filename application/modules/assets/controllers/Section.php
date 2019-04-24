<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Section extends my_controller {

function __construct()
{
	parent::__construct(); 
	$this->load->model('model_master_section');
	$this->load->model('model_admin_login');
	$this->load->library('pagination'); 
}


public function manage_section($param = FALSE,$param2 = FALSE){  ///manage_Category

	 //echo $param;
     $table_name = 'tbl_category';
	 if($this->session->userdata('is_logged_in')){
	 
	  $data1['result'] = "";
	  $data1["getEdit"]= "";
      
      ////Pagination start ///

	  //$url   = site_url('/master/ProductCategory/manage_section?');
	  $sgmnt = "4";
	 
	  if($_GET['entries'] != '')
	  {
	  	$showEntries = $_GET['entries'];
	  }
	  else
	  {
	  	$showEntries= 10;
	  }
     
	  $totalData   = $this->model_master_section->count_all($table_name,1,$this->input->get());
      //$showEntries= $_GET['entries']?$_GET['entries']:'12';

      if($_GET['entries'] != '' && $_GET['filter'] != 'filter')
	  {
         $url = site_url('/assets/Section/manage_section?entries='.$_GET['entries']);
      }
	  elseif($_GET['filter'] == 'filter' || $_GET['entries'] != '')
	  {
	  	$url = site_url('/assets/Section/manage_section?filtername='.$_GET['filtername'].'&filterdate='.$_GET['filterdate'].'&filter='.$_GET['filter'].'&entries='.$_GET['entries']);
	  }
	  else
	  {
	  	$url = site_url('/assets/Section/manage_section?');
	  }
      
	  $pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);

      //////Pagination end ///
     
      $result           = $this->model_master_section->tree_all();
      $data1['alldata'] = $result;  
      $itemsByReference = array();

      if($result != ""){
        $data1['result'] =  $this->changeTreeFormat($result);
      }
      /*if($this->input->post('submit') == "delete"){
        $result = $this->model_master_section->get_child_data($this->input->post('id'));
        $result_delete = $this->model_master_section->delete_data($this->input->post('id'),$result);
       }*/
      $data1['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
      $data1['categorySelectbox'] = $this->model_master_section->categorySelectbox();
      $data1['pagination']        = $this->pagination->create_links();
      
	  if($this->input->get('filter') == 'filter')   ////filter start ////
          $data1['result_list']       = $this->model_admin_login->filterList($pagination['per_page'],$pagination['page'],$this->input->get());
          else	
          $data1['result_list']       = $this->model_master_section->category_all($pagination['per_page'],$pagination['page']);
      
      $this->load->view('section/manage-section',$data1);	
	 }
	 else
	 {
	 	redirect('index');
	 }
}

function changeTreeFormat($result){
	 // Build array of item references:
        foreach($result as $key => &$item) {
             $itemsByReference[$item['id']] = &$item;
        // Children array:
            $itemsByReference[$item['id']]['children'] = array();
        // Empty data class (so that json_encode adds "data: {}" )
            $itemsByReference[$item['id']]['data'] = new StdClass();
        }

      // Set items as children of the relevant parent item.
        foreach($result as $key => &$item)
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;

        // Remove items that were added to parents elsewhere:
        foreach($result as $key => &$item) {
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($result[$key]);
        }
       
        foreach ($result as $row) {
            $data[] = $row;
        }
       return    json_encode($data);
}



function ajex_formsubmit(){
	//print_r($this->input->post());die;
	if($this->input->post('type') == "save"){
       $result =  $this->model_master_section->insert_value($this->input->post());
       echo "Add Data Successfully !";
	}else if($this->input->post('type') == "edit"){
		//print_r($this->input->post());
      $this->model_master_section->edit_Category($this->input->post());
      echo "Update  Data Successfully !";
	}
}

function ajaxShowParent(){
	//print_r($this->input->post());
	$arrid = $this->model_master_section->treeGetParentValue($this->input->post('id'));
	//$result = $this->model_master_section->treeGetParentValue($arrid);
    $spacing = "";
    //$arrid = ksort($arrid);
    $arrid = array_reverse($arrid);
    echo "<ul>";
    foreach ($arrid as $key => $value) {
    	$spacing = $spacing . '&nbsp;&nbsp;';
        echo "<li>".$spacing . '&nbsp;&nbsp;'.$value['name']."</li>";
	}
	echo "</ul>";
}

  function ajex_loadListData(){
	//echo $param;
     $table_name = 'tbl_category';
	 if($this->session->userdata('is_logged_in')){
	  $data1['result'] = "";
	  $data1["getEdit"]= "";
      
      ////Pagination start ///

	  $url   = site_url('/assets/Section/manage_section?');
	  $sgmnt = "4";
	  $showEntries = 10;
      $totalData   = $this->model_master_section->count_all($table_name,1,$this->input->get());
      //$showEntries= $_GET['entries']?$_GET['entries']:'12';

      if($_GET['entries']!=""){
         $showEntries = $_GET['entries'];
         $url   = site_url('/assets/Section/manage_section?entries='.$_GET['entries']);
      }
         $pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);

      //////Pagination end ///
     
      $result           = $this->model_master_section->tree_all();
      $data1['alldata'] = $result;  
      $itemsByReference = array();

      if($result != ""){
        $data1['result'] =  $this->changeTreeFormat($result);
      }
     /*if($this->input->post('submit') == "delete"){
        $result = $this->model_master_section->get_child_data($this->input->post('id'));
        $result_delete = $this->model_master_section->delete_data($this->input->post('id'),$result);
      }*/
       $data1['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
       $data1['categorySelectbox'] = $this->model_master_section->categorySelectbox();
       $data1['pagination']        = $this->pagination->create_links();
     if($this->input->get('filter') == 'filter')   ////filter start ////
       $data1['result_list']       = $this->model_master_section->filterList($pagination['per_page'],$pagination['page'],$this->input->get());
     else	
       $data1['result_list']       = $this->model_master_section->category_all($pagination['per_page'],$pagination['page']);
      
       $this->load->view('section/load-section',$data1);	
  }
}

  function ajexShowTree(){
  	 $result = $this->model_master_section->tree_all();
     $data1['result'] =  $this->changeTreeFormat($result);
  }
	
}
?>