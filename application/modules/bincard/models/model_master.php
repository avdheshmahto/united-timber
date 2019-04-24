<?php
class model_master extends CI_Model {

function product_get($last,$strat)
{
	
	$query=("select *from tbl_bin_card_hdr where status='A' Order by rflhdrid DESC limit $strat,$last ");	
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}


function filterListproduct($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_bin_card_hdr where status='A'";

	if(sizeof($get) > 0)
	{

		if($get['code'] != "")
			$qry .= " AND rflhdrid LIKE '%".$get['code']."%'";
		
		if($get['bin_card_type'] != "")
			$qry .= " AND bin_card_type LIKE '%".$get['bin_card_type']."%'";
		
		if($get['machine_id'] != "")
		{
			
			$unitQuery2=$this->db->query("select * from  tbl_machine where machine_name LIKE '%".$get['machine_id']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->id;
			
			$qry .= " AND machine_id ='$sr_no2'";
		
		}

		if($get['vendor_id'] != "")
		{
			
			$unitQuery2=$this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$get['vendor_id']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->contact_id;
			
			$qry .= " AND vendor_id ='$sr_no2'";
		
		}
		
		if($get['rdate'] != "")
			$qry .= " AND date LIKE '%".$get['rdate']."%'";
		
		if($get['grn_no'] != "")
			$qry .= " AND grn_no LIKE '%".$get['grn_no']."%'";
		
		if($get['grn_date'] != "")
			$qry .= " AND grn_date LIKE '%".$get['grn_date']."%'";
		
		if($get['remarks'] != "")
			$qry .= " AND remarks LIKE '%".$get['remarks']."%'";

	}
  	 
  	  $qry .= "  limit $pages,$perpage";
     $data =  $this->db->query($qry)->result();
    return $data;

}


function count_allproduct($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_bin_card_hdr where status='A'";
    
	if(sizeof($get) > 0)
	{
	
		if($get['code'] != "")
			$qry .= " AND rflhdrid LIKE '%".$get['code']."%'";
		
		if($get['bin_card_type'] != "")
			$qry .= " AND bin_card_type LIKE '%".$get['bin_card_type']."%'";
		
		if($get['machine_id'] != "")
		{
			$unitQuery2=$this->db->query("select * from  tbl_machine where machine_name LIKE '%".$get['machine_id']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->id;
			
			$qry .= " AND machine_id ='$sr_no2'";
		
		}
		if($get['vendor_id'] != "")
		{
			$unitQuery2=$this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$get['vendor_id']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->contact_id;
			
			$qry .= " AND vendor_id ='$sr_no2'";
		
		}
		if($get['rdate'] != "")
			$qry .= " AND date LIKE '%".$get['rdate']."%'";

		if($get['grn_no'] != "")
			$qry .= " AND grn_no LIKE '%".$get['grn_no']."%'";
		
		if($get['grn_date'] != "")
			$qry .= " AND grn_date LIKE '%".$get['grn_date']."%'";
		
		if($get['remarks'] != "")
			$qry .= " AND remarks LIKE '%".$get['remarks']."%'";

					
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}





































}
?>