<?php
@extract($_GET);
 
$contents="S NO.,SPARE RETURN ID,RETURN DATE,VENDOR NAME,PO NUMBER,PO DATE\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							
				$qry ="select * from tbl_spare_return_hdr where status='A'";
								
				if($_GET['po_no'] != "")
			$qry .= " AND po_no LIKE '%".$_GET['po_no']."%'";
		
		
		if($_GET['p_name'] != "")
		{
			$unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$_GET['p_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->contact_id;
			
			$qry       .= " AND vendor_id ='$sr_no2'";
		
		}
		
		if($_GET['p_date'] != "")
			$qry .= " AND po_date LIKE '%".$_GET['p_date']."%'";
			
		
		if($_GET['f_date']!='')
		{
		
			$t_date=explode("-",$_GET['t_date']);
			
			$f_date=explode("-",$_GET['f_date']);

			$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and return_date >='$f_date1' and return_date <='$t_date1'";
		}
				}
		

				
				else

					
				$qry ="select * from tbl_spare_return_hdr where status='A'";
 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch)
					    {
								
								
								$machineQuery = $this -> db
								           -> select('*')
								           -> where('contact_id',$fetch->vendor_id)
								           -> get('tbl_contact_m');
										   $getMachine=$machineQuery->row();



$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$fetch->rflhdrid).",";
$contents.=str_replace(',',' ',$fetch->return_date).",";
$contents.=str_replace(',',' ',$getMachine->first_name).",";
$contents.=str_replace(',',' ',$fetch->po_no).",";
$contents.=str_replace(',',' ',$fetch->po_date).",\n";
  $i++;
} 


$filename = "Spare_Return_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		