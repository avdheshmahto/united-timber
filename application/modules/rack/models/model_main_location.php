<?php
class model_main_location extends CI_Model {
	
function location($last,$strat)
{

	  $query=$this->db->query("select * from tbl_master_data where status='A' and param_id = '21' Order by serial_number desc limit $strat,$last ");	        
	  return $result=$query->result();  

}



function filterListproduct($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_master_data where status='A' and param_id = '21'";

	if(sizeof($get) > 0)
	{
		if($get['loc_name'] != "")
		{
		
			$unitQuery2=$this->db->query("select * from  tbl_master_data where keyvalue like '%".$get['loc_name']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->serial_number;
			
			$qry .= " AND keyvalue like '%".$get['loc_name']."%'";
		
		}	
	}

  $qry .= "  Order by serial_number desc limit $pages,$perpage"; 	
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allproduct($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_master_data where status='A' and param_id = '21'";
    
	if(sizeof($get) > 0)
	{
		if($get['loc_name'] != "")
		{
		
			$unitQuery2=$this->db->query("select * from  tbl_master_data where keyvalue like '%".$get['loc_name']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->serial_number;
			
			$qry .= " AND keyvalue like '%".$get['loc_name']."%'";
		
		}
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}

function insert_user($tableName,$loc)
{
	$this->db->insert($tableName,$loc);
	
}

function update_user($tableName,$match_id,$id,$loc)
{
	
	$this->db->where($match_id,$id);
	$this->db->update($tableName,$loc);
	
}



}
?>