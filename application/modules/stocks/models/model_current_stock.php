<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class model_current_stock extends CI_Model {

function getSearchStock($p_id,$p_name) 
{
	
    $select_query = "Select * from tbl_product_stock where status='A' and type='spare'";
    if($p_id!='')
		{				
			$select_query.=" and Product_id = '$p_id'";	  
		}
		if($p_name!='')
		{				
			$select_query.=" and type  ='$p_name'";	  
		}
	
	$query = $this->db->query($select_query);
    return $query->result();

}

//******************************************************************************************************

function product_spare_get($last,$start)
{
	
	$query=("select * from tbl_product_stock where status='A' ORDER BY Product_id DESC limit $start, $last");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();

}


function filterListproduct_spare($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_product_stock where status='A'";

	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no = '".$get['code']."'";
		
		if($get['sp_name'] != "")
		{
		
			/*$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;*/
			
			$qry       .= " AND Product_id = '".$get['sp_name']."'";
		
		}
							
	}
  
  $qry .= "  ORDER BY Product_id DESC limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allproduct_spare($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_product_stock where status='A'";
    
	if(sizeof($get) > 0)
	{
	
		if($get['code'] != "")
			$qry .= " AND sku_no = '".$get['code']."'";
		
		if($get['sp_name'] != "")
		{
	
			/*$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;*/
			
			$qry       .= " AND Product_id = '".$get['sp_name']."'";
		
		}
							
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}


//***************************************************************************************************

//**********************Start Tools functions ***************************************************

function product_tools_get($last,$strat)
{
	
	//echo "select *from tbl_product_serial where status='A' Order by serial_number DESC limit $strat,$last ";
	$query=("select *from tbl_product_serial where status='A' and module_status='tool'");
	
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}




function filterListproduct_tools($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_product_stock where status='A' and type='tool'";

	if(sizeof($get) > 0)
	{
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";
		
		if($get['sp_name'] != "")
		{
			
			$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}						
	
	}
  	
  	$qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;
}


function count_allproduct_tools($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_product_serial where status='A' and module_status='tool'";
    
		if(sizeof($get) > 0)
		 {
			   if($get['code'] != "")
				  $qry .= " AND sku_no LIKE '%".$get['code']."%'";
			   
			   if($get['sp_name'] != "")
				  $qry .= " AND productname LIKE '%".$get['sp_name']."%'";
	     }
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}


//**************************************************************************************************


}
?>