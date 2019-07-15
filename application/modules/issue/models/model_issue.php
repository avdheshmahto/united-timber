<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class model_issue extends CI_Model {

//===============================Consumable===========================

function getConsumIssueData($last,$strat)
{

	$parts=$this->db->query("select * from tbl_consum_issue_hdr where status='A' ORDER BY issue_id DESC LIMIT $strat,$last ");
	return $result=$parts->result();

}


function filterConsumList($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_consum_issue_hdr where status='A'";

	if(sizeof($get) > 0)
	{
		
		// if($get['code'] != "")
		// 	$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		// if($get['sp_name'] != "")
		// {

		// 	$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
		// 	$getUnit2   = $unitQuery2->row();
		// 	$sr_no2     = $getUnit2->Product_id;
			
		// 	$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		// }
	
	}
  
  	$qry .= "  limit $pages,$perpage";
   $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allConsum($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_consum_issue_hdr where status='A'";
    
		if(sizeof($get) > 0)
		{

			// if($get['code'] != "")
			// 	$qry .= " AND sku_no LIKE '%".$get['code']."%'";
			   
			// if($get['sp_name'] != "")
			// 	$qry .= " AND productname LIKE '%".$get['sp_name']."%'";
			 
	    }
		 
   	$query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}	


//************************************Tools Issue**********************************


function getToolsIssueData($last,$strat)
{

	$parts=$this->db->query("select * from tbl_tools_issue_hdr where status='A' ORDER BY issue_id DESC LIMIT $strat,$last ");
	return $result=$parts->result();

}


function filterToolsList($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_tools_issue_hdr where status='A'";

	if(sizeof($get) > 0)
	{
		
		// if($get['code'] != "")
		// 	$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		// if($get['sp_name'] != "")
		// {

		// 	$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
		// 	$getUnit2   = $unitQuery2->row();
		// 	$sr_no2     = $getUnit2->Product_id;
			
		// 	$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		// }
	
	}
  
  	$qry .= "  limit $pages,$perpage";
   $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allTools($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_tools_issue_hdr where status='A'";
    
		if(sizeof($get) > 0)
		{

			// if($get['code'] != "")
			// 	$qry .= " AND sku_no LIKE '%".$get['code']."%'";
			   
			// if($get['sp_name'] != "")
			// 	$qry .= " AND productname LIKE '%".$get['sp_name']."%'";
			 
	    }
		 
   	$query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}

//==================================Spare=========================================

function getSpare($last,$strat)
{

	$query=("select * from tbl_work_order_maintain where status='A' ORDER BY id DESC limit $strat, $last");	
	$getQuery = $this->db->query($query);
  	return $result=$getQuery->result();

}



function filterSpareList($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_work_order_maintain where status='A'";

	if(sizeof($get) > 0)
	{
		
		// if($get['code'] != "")
		// 	$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		// if($get['sp_name'] != "")
		// {

		// 	$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
		// 	$getUnit2   = $unitQuery2->row();
		// 	$sr_no2     = $getUnit2->Product_id;
			
		// 	$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		// }
	
	}
  
  	$qry .= "  limit $pages,$perpage";
   $data =  $this->db->query($qry)->result();
  return $data;
  
}


function count_allSpare($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_work_order_maintain where status='A'";
    
		if(sizeof($get) > 0)
		{

			// if($get['code'] != "")
			// 	$qry .= " AND sku_no LIKE '%".$get['code']."%'";
			   
			// if($get['sp_name'] != "")
			// 	$qry .= " AND productname LIKE '%".$get['sp_name']."%'";
			 
	    }
		 
   	$query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}



function categorySelectbox($parent = 0, $spacing = '', $user_tree_array = ''){
      if (!is_array($user_tree_array))
        $user_tree_array = array();
   
        $sql = "select * from tbl_category where status = 1 AND inside_cat = $parent";
        $query = $this->db->query($sql);
        $data  = $query->result_array();
         if (sizeof($data) > 0) {
           foreach($data as $row) {
             // echo "<option>".$spacing . $row['name']."</option>";
             $user_tree_array[] = array("id" => $row['id'], "name" => $spacing . $row['name'],'praent' => $row['inside_cat']);
             $user_tree_array = $this->categorySelectbox($row['id'],$spacing . '&nbsp;&nbsp;&nbsp;&nbsp;',$user_tree_array);
           }
         }
       return $user_tree_array;
     }
     

}
?>