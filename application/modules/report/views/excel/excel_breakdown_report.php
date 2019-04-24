<?php
@extract($_GET);
 
$contents="S NO.,NATURE OF BREAKDOWN,SECTION,DATE,TIME,BREAKDOWN TIME,MACHINE NAME,SPARE NAME,OPERATOR NAME,BREAKDOWN DESCRIPTION\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
			$qry ="select * from tbl_machine_breakdown where status='A'";

								
			if($_GET['n_o_breakdown'] != "")
			$qry .= " AND nature_of_breakdown LIKE '%".$_GET['n_o_breakdown']."%'";


		if($_GET['m_name'] != "")
		{
			$unitQuery=$this->db->query("select * from tbl_machine where machine_name LIKE '%".$_GET['m_name']."%'");
			$getUnit=$unitQuery->row();
			$sr_no=$getUnit->id;
		
			$qry .= " AND machine_id ='$sr_no'";
		}
		
		if($_GET['s_name'] != "")
			$qry .= " AND part_id LIKE '%".$_GET['s_name']."%'";

		if($_GET['o_name'] != "")
			$qry .= " AND operator_id LIKE '%".$_GET['o_name']."%'";
			
		if($_GET['break_time'] != "")
			$qry .= " AND break_time LIKE '%".$_GET['break_time']."%'";

		if($_GET['section'] != "")
			$qry .= " AND section LIKE '%".$_GET['section']."%'";
		

		if($_GET['f_date']!='')
	{
	    $t_date = explode("-",$_GET['t_date']);
		$f_date = explode("-",$_GET['f_date']);
        $t_date1= $t_date[0]."-".$t_date[1]."-".$t_date[2];
        $f_date1= $f_date[0]."-".$f_date[1]."-".$f_date[2];
		$qry   .=" and date >='$f_date1' and date <='$t_date1'";
	}

				}
		

				
				else

					
				$qry ="select * from tbl_machine_breakdown where status='A'";

 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch_list)
					    {
								
								$sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->nature_of_breakdown."'");
								$compRow = $sqlunit->row();
								
								$sqlunits=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->section."'");
								$compRows = $sqlunits->row();

								$machineQuery = $this ->db->query("select * from tbl_machine where id='".$fetch_list->machine_id."'");
         
								$getMachine = $machineQuery->row();

								$machinesQuery = $this ->db->query("select * from tbl_product_stock where Product_id='".$fetch_list->part_id."'");
         
								$getMachines = $machinesQuery->row();

								$machinecontactQuery = $this ->db->query("select * from tbl_contact_m where contact_id='".$fetch_list->operator_id."'");
         
								$getcontactMachine = $machinecontactQuery->row();






		

$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$compRow->keyvalue).",";
$contents.=str_replace(',',' ',$compRows->keyvalue).",";
$contents.=str_replace(',',' ',$fetch_list->date).",";
$contents.=str_replace(',',' ',$fetch_list->time).",";
$contents.=str_replace(',',' ',$fetch_list->break_time).",";
$contents.=str_replace(',',' ',$getMachine->machine_name).",";
$contents.=str_replace(',',' ',$getMachines->productname).",";
$contents.=str_replace(',',' ',$getcontactMachine->first_name).",";
$contents.=str_replace(',',' ',$fetch_list->breakdown_description).",\n";
  $i++;
} 


$filename = "Breakdown_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		