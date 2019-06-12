<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class model_report extends CI_Model {


//****************************************************************************************

function product_type_get($last,$strat)
{
	
	$query=("select * from tbl_master_data where param_id='26' Order by serial_number DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}


function filterProductType($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_master_data where param_id='26'";

	if(sizeof($get) > 0)
	{
		
		if($get['type'] != "")			
			$qry       .= " AND serial_number ='".$get['type']."'";

	}
  
  	$qry .= "  Order by serial_number DESC limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_ProductType($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_master_data where param_id='26'";
    
	if(sizeof($get) > 0)
	{
		
		if($get['type'] != "")
		{
		
			if($get['type'] != "")			
				$qry       .= " AND serial_number ='".$get['type']."'";
					
		}
		
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}


//**********************************************************************
function product_get($last,$strat)
{
	
	$query=("select *from tbl_product_stock where status='A' Order by Product_id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}


function filterListproduct($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_product_stock where status='A'";

	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		if($get['sp_name'] != "")
		{
			// $unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}
		
	}
  
  	$qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allproduct($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_product_stock where status='A'";
    
	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		if($get['sp_name'] != "")
		{
			// $unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}
		
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}

//============================================

function Spare_Get($last,$strat)
{
	
	$query=("select *from tbl_product_stock where status='A' Order by Product_id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}


function filterSpareList($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_product_stock where status='A'";

	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		if($get['sp_name'] != "")
		{
			// $unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}
		
	}
  
  	$qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_Spare($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_product_stock where status='A'";
    
	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";

		if($get['sp_name'] != "")
		{
			// $unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}
		
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}


//***********************************************************************************************

function product_reorder_get($last,$strat)
{
	
	$query=("select * from tbl_product_stock where quantity < min_re_order_level Order by Product_id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}



function filterListproduct_reorder($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_product_stock where quantity < min_re_order_level ";

	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";
			
		if($get['sp_name'] != "")
		{
			// $unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}
				
	}

    $qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allproduct_reorder($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_product_stock where quantity < min_re_order_level ";
    
	if(sizeof($get) > 0)
	{
		
		if($get['code'] != "")
			$qry .= " AND sku_no LIKE '%".$get['code']."%'";
			
		if($get['sp_name'] != "")
		{
			// $unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND Product_id ='".$get['sp_name']."'";
		
		}
				
	}
		 
		 //echo $qry;
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}



//*******************************************************************************************************************************************************************************
function bincard_get($last,$strat)
{
	
	$query=("select * from tbl_bin_card_hdr H,tbl_bin_card_dtl D where H.rflhdrid=D.refillhdr Order by H.rflhdrid DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}


function filterListbincard($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_bin_card_hdr H,tbl_bin_card_dtl D where H.rflhdrid=D.refillhdr";

	if(sizeof($get) > 0)
	{		
		
		if($get['p_name'] != "")
		{
		
			// $unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$get['p_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->contact_id;
			
			$qry       .= " AND vendor_id ='".$get['p_name']."'";
		
		}
		
		if($get['f_date']!='')
		{
		
			$t_date=explode("-",$get['t_date']);
			
			$f_date=explode("-",$get['f_date']);

			$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and grn_date >='$f_date1' and grn_date <='$t_date1'";
		}
	
	}
  
  	$qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;
}


function count_allbincard($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_bin_card_hdr H,tbl_bin_card_dtl D where H.rflhdrid=D.refillhdr ";

    if(sizeof($get) > 0)
	{		
		
		if($get['p_name'] != "")
		{
		
			// $unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$get['p_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->contact_id;
			
			$qry       .= " AND vendor_id ='".$get['p_name']."'";
		
		}
		
		if($get['f_date']!='')
		{
		
			$t_date=explode("-",$get['t_date']);
			
			$f_date=explode("-",$get['f_date']);

			$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and grn_date >='$f_date1' and grn_date <='$t_date1'";
		}
	
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}




//*************************************************************************************************************************************************************************************



function workorder_get($last,$strat)
{
	
	$query=("select * from tbl_work_order_maintain where status='A' Order by id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}


function filterWorkorder($perpage,$pages,$get)
{
 	

	$qry ="select * from tbl_work_order_maintain where status='A'";

	if(sizeof($get) > 0)
	{


		if($get['date_range']!='')
		{	
			$daterage=explode("-",$get['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND maker_date >='$fdate1' AND maker_date <='$todate1'";
		}

		if($get['section'] != "")
		{
			$abc=$this->db->query("select * from tbl_machine where m_type='".$get['section']."'");
			$getAbc=$abc->row();
			$qry .= " AND machine_name ='".$getAbc->id."'";
		}

		if($get['machine'] != "")
		{
			$qry .= " AND machine_name='".$get['machine']."'";
		}
	}
  
      $qry .= "  limit $pages,$perpage";
    $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allWorkorder($tableName,$status=0,$get)
{

    $qry ="select count(*) as countval from tbl_work_order_maintain where status='A'";

 	if(sizeof($get) > 0)
	{


		if($get['date_range']!='')
		{	
			$daterage=explode("-",$get['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND maker_date >='$fdate1' AND maker_date <='$todate1'";
		}

		if($get['section'] != "")
		{
			$abc=$this->db->query("select * from tbl_machine where m_type='".$get['section']."'");
			$getAbc=$abc->row();
			$qry .= " AND machine_name ='".$getAbc->id."'";
		}

		if($get['machine'] != "")
		{
			$qry .= " AND machine_name='".$get['machine']."'";
		}
	}

   $query=$this->db->query($qry,array($status))->result_array();
   
   return $query[0]['countval'];

}


//****************************************************************************************************************************************************************************************************************


function breakdown_get($last,$strat)
{
	
	$query=("select *from tbl_machine_breakdown where status='A' Order by id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}




function filterListbreakdown($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_machine_breakdown where status='A'";

	if(sizeof($get) > 0)
	{
			

		if($get['m_type'] != "")
			$qry .= " AND section = '".$get['m_type']."'";
		
		if($get['machineid'] != "")
		{
		
			$qry .= " AND machine_id ='".$get['machineid']."'";
		}

		/*if($get['date_range']!='')
		{	
			$daterage=explode("-",$_GET['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND maker_date >='$fdate1' AND maker_date <='$todate1'";
		}*/
			
	}

    $qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allbreakdown($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_machine_breakdown where status='A'";

    if(sizeof($get) > 0)
	{
			

		if($get['m_type'] != "")
			$qry .= " AND section = '".$get['m_type']."'";
		
		if($get['machineid'] != "")
		{
		
			$qry .= " AND machine_id ='".$get['machineid']."'";
		}

		/*if($get['date_range']!='')
		{	
			$daterage=explode("-",$_GET['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND maker_date >='$fdate1' AND maker_date <='$todate1'";
		}*/
			
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   
   return $query[0]['countval'];

}

//===

function scheduled_get($last,$strat)
{
	
	$query=("select * from tbl_work_order_maintain where trigger_code!='' Order by id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}




function filterListScheduled($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_work_order_maintain where trigger_code!='' ";

	if(sizeof($get) > 0)
	{
		
		if($get['m_type'] != "")
		{
			$qry .= " AND m_type ='".$get['m_type']."'";
		}

		if($get['machineid'] != "")
		{
			$qry .= " AND machine_name ='".$get['machineid']."'";
		}
		
		/*if($get['date_range']!='')
		{	
			$daterage=explode("-",$_GET['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND maker_date >='$fdate1' AND maker_date <='$todate1'";
		}*/
			
	}

    $qry .= "  Order by id DESC limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allScheduled($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_work_order_maintain where trigger_code!=''";

    if(sizeof($get) > 0)
	{
		
		if($get['m_type'] != "")
		{
			$qry .= " AND m_type ='".$get['m_type']."'";
		}

		if($get['machineid'] != "")
		{
			$qry .= " AND machine_name ='".$get['machineid']."'";
		}
		
		/*if($get['date_range']!='')
		{	
			$daterage=explode("-",$_GET['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND maker_date >='$fdate1' AND maker_date <='$todate1'";
		}*/
			
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   
   return $query[0]['countval'];

}

//********************************************************************************************************************************************************************************************************



function spare_mapping_get($last,$strat)
{
	
	$query=("select * from tbl_vendor_spare_price_map V,tbl_contact_m C where V.vendor_id = C.contact_id AND V.status='A'  AND C.status='A' Order by V.id DESC limit $strat,$last ");

	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}




function filterList_spare_mapp($perpage,$pages,$get){
 	
	$qry ="select * from tbl_vendor_spare_price_map V,tbl_contact_m C where V.vendor_id = C.contact_id AND V.status='A'  AND C.status='A'";

	if(sizeof($get) > 0)
	{
			
		if($get['v_name'] != "")
			$qry .= " AND V.vendor_id='".$get['v_name']."'";

		
		if($get['sp_name'] != "")
		{
			$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND V.spare_id ='".$get['sp_name']."'";
		
		}
		
		
		if($get['f_date']!='')
		{
		    $t_date=explode("-",$get['t_date']);
			$f_date=explode("-",$get['f_date']);
      		$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and C.maker_date >='$f_date1' and C.maker_date <='$t_date1'";
		}
		
				
	
}
  $qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;
}


function count_all_spare_map($tableName,$status = 0,$get){
    $qry ="select count(*) as countval from $tableName V,tbl_contact_m C where V.vendor_id = C.contact_id AND V.status='A'  AND C.status='A'";

    if(sizeof($get) > 0)
	{
			
		if($get['v_name'] != "")
			$qry .= " AND V.vendor_id='".$get['v_name']."'";
			
		
		if($get['sp_name'] != "")
		{
			$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND V.spare_id ='".$get['sp_name']."'";
		
		}
		
		
		
		if($get['f_date']!='')
		{
		    $t_date=explode("-",$get['t_date']);
			$f_date=explode("-",$get['f_date']);
      		$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and C.maker_date >='$f_date1' and C.maker_date <='$t_date1'";
		}


	}
	
	
		 
   $query=$this->db->query($qry,array($status))->result_array();
   
   return $query[0]['countval'];

}


//********************************************************************************************************************************************************************************************************



function spare_machine_get($last,$strat){
	
	$query=("select * from tbl_machine_spare_map M,tbl_machine MM where M.spare_id = MM.id AND M.status='A'  AND MM.status='A' Order by M.id DESC limit $strat,$last ");
	
	$getQuery = $this->db->query($query);
  return $result=$getQuery->result();
  
}




function filterList_machine_spare_mapp($perpage,$pages,$get){
 	
	$qry ="select * from tbl_machine_spare_map where status='A' ";

	if(sizeof($get) > 0)
	{
			
		if($get['m_name'] != "")
			 $qry .= " AND machine_id = '".$get['m_name']."'";

		
		if($get['sp_name'] != "")
		{
			$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND spare_id ='".$get['sp_name']."'";
		
		}
		
		
		
		
				
	
}
  $qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;
}


function count_all_spare_machine_map($tableName,$status = 0,$get){
    $qry ="select count(*) as countval from $tableName where status='A' ";

    if(sizeof($get) > 0)
	{
			
		if($get['m_name'] != "")
			$qry .= " AND machine_id = '".$get['m_name']."'";

			
		
		if($get['sp_name'] != "")
		{
			$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$get['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND spare_id ='$sr_no2'";
		
		}
		
		
		
	}
	
	
		 
   $query=$this->db->query($qry,array($status))->result_array();
   
   return $query[0]['countval'];

}



//*********************************************************************************************************************************************************************************************

function getSoftwareCost($last,$strat){
	
	$query=("select *,SUM(total_spent) from tbl_software_cost_log GROUP BY section_id ORDER BY id DESC limit $strat,$last ");
	
	$getQuery = $this->db->query($query);
  return $result=$getQuery->result();
  
}




function filterSoftwareCost($perpage,$pages,$get){
 	
	$qry ="select *,SUM(total_spent) from tbl_software_cost_log ";

	if(sizeof($get) > 0)
	{

	}
 
  $qry .= "  GROUP BY section_id ORDER BY id DESC limit $strat,$last";
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allSoftwareCost($tableName,$status = 0,$get){
    
    $qry ="select count(*) as countval from tbl_software_cost_log GROUP BY section_id ";

    if(sizeof($get) > 0)
	{}
	
	//echo $qry; 	 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'] * 2;

}




//********************************************************************************************************************************************************************************************************



function sparereturn_get($last,$strat)
{
	
	$query=("select * from tbl_spare_return_hdr H,tbl_spare_return_dtl D where H.rflhdrid=D.refillhdr Order by H.rflhdrid DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
  	return $result=$getQuery->result();
  
}


function filterListsparereturn($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_spare_return_hdr H,tbl_spare_return_dtl D where H.rflhdrid=D.refillhdr ";

	if(sizeof($get) > 0)
	{		

		if($get['po_no'] != "")
			$qry .= " AND po_no LIKE '%".$get['po_no']."%'";
		
		
		if($get['p_name'] != "")
		{
			
			// $unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$get['p_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->contact_id;
			
			$qry       .= " AND vendor_id ='".$get['p_name']."'";
		
		}
		
		// if($get['p_date'] != "")
		// 	$qry .= " AND po_date LIKE '%".$get['p_date']."%'";
			
		
		if($get['f_date']!='')
		{
		
			$t_date=explode("-",$get['t_date']);
			
			$f_date=explode("-",$get['f_date']);

			$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and return_date >='$f_date1' and return_date <='$t_date1'";
		}
					
	}

    $qry .= "  limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allsparereturn($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_spare_return_hdr H,tbl_spare_return_dtl D where H.rflhdrid=D.refillhdr ";

    
	if(sizeof($get) > 0)
	{		

		if($get['po_no'] != "")
			$qry .= " AND po_no LIKE '%".$get['po_no']."%'";
		
		
		if($get['p_name'] != "")
		{
			
			// $unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$get['p_name']."%'");
			// $getUnit2   = $unitQuery2->row();
			// $sr_no2     = $getUnit2->contact_id;
			
			$qry       .= " AND vendor_id ='".$get['p_name']."'";
		
		}
		
		// if($get['p_date'] != "")
		// 	$qry .= " AND po_date LIKE '%".$get['p_date']."%'";
			
		
		if($get['f_date']!='')
		{
		
			$t_date=explode("-",$get['t_date']);
			
			$f_date=explode("-",$get['f_date']);

			$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and return_date >='$f_date1' and return_date <='$t_date1'";
		}
					
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}




//**************************************************************************************************************************************************************************************************************************

function detailed_workorderGet($last,$strat)
{

	$serial_query="select * from tbl_spare_issue_hdr H,tbl_spare_issue_dtl D  where H.issue_id=D.issue_id_hdr Order by H.workorder_id ASC limit $strat,$last";	
	$serial_product=$this->db->query($serial_query)->result();
	return $serial_product;

}

function filterDetailedWorkorder($perpage,$pages,$get)
{

	$qry="select * from tbl_spare_issue_hdr H,tbl_spare_issue_dtl D  where H.issue_id=D.issue_id_hdr ";

	if(@$get['filter'] == 'filter')
	{

		if($get['date_range']!='')
		{	
			$daterage=explode("-",$_GET['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND H.maker_date >='$fdate1' AND H.maker_date <='$todate1'";
		}

		if($get['type'] != "")
		{			
			$qry .= " AND D.type ='".$get['type']."'";
		}

		if($get['sp_name'] != "")
		{
			$qry .= " AND D.spare_id='".$get['sp_name']."'";
		}

	}
	
	  $qry .= "  limit $pages,$perpage";

	$data=$this->db->query($qry)->result();
	return $data;

}

function count_allDetailedWorkorder($table_name,$status=0,$get)
{

	$qry="select count(*) as countvalue from tbl_spare_issue_hdr H,tbl_spare_issue_dtl D  where H.issue_id=D.issue_id_hdr ";

	if($_GET['filter'] == 'filter')
	{

		if($get['date_range']!='')
		{	
			$daterage=explode("-",$get['date_range']);
			
			$fdate=$daterage[0];
			$fdate = str_replace(' ','',$fdate);
			$tdate=$daterage[1];
			$tdate = str_replace(' ','',$tdate);

			$frmdtrng=explode("/",$fdate);
			$todtrng=explode("/",$tdate);

			$fdate1=$frmdtrng[2]."-".$frmdtrng[0]."-".$frmdtrng[1];
			$todate1=$todtrng[2]."-".$todtrng[0]."-".$todtrng[1];
	        
			$qry .=" AND H.maker_date >='$fdate1' AND H.maker_date <='$todate1'";
		}

		if($get['type'] != "")
		{			
			$qry .= " AND D.type ='".$get['type']."'";
		}

		if($get['sp_name'] != "")
		{
			$qry .= " AND D.spare_id='".$get['sp_name']."'";
		}

	}

	$queryres=$this->db->query($qry)->result_array();
	return $queryres[0]['countvalue'];

} 


//============================================================

function machine_get($last,$strat)
{
	
	$query=("select * from tbl_category where inside_cat='0' Order by id ASC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
  
}



function filterList_machine($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_category where inside_cat='0' ";

	if(sizeof($get) > 0)
	{
		
		if($get['m_type'] != "")
			$qry .= " AND id='".$get['m_type']."'";
					
	}

    $qry .= "  Order by id ASC limit $pages,$perpage";
 
  $data =  $this->db->query($qry)->result();
  return $data;

}


function count_all_machine($tableName,$status = 0,$get)
{

    $qry ="select count(*) as countval from tbl_category where inside_cat='0' ";
    
	if(sizeof($get) > 0)
	{
		
		if($get['m_type'] != "")
			$qry .= " AND id='".$get['m_type']."'";
					
	}
		 
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}


//==========================================================

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
         $user_tree_array = $this->categorySelectbox($row['id'],$spacing.'&nbsp;&nbsp;&nbsp;&nbsp;',$user_tree_array);
       }
     }
   return $user_tree_array;
 }


}
?>