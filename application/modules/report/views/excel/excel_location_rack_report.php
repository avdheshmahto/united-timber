<?php
@extract($_GET);
 
$contents="S NO.,LOCATION NAME,LOCATION RACK\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							
				$qry ="select * from tbl_location_rack where status='A'";
								
				if($_GET['l_name'] != "")
					{
					
						
					$qry .= " AND location_rack_id ='".$_GET['l_name']."'";
					
					}
					
					if($_GET['l_rack'] != "")
						$qry .= " AND rack_name LIKE '%".$_GET['l_rack']."%'";
				
				}
		

				
				else

					
				$qry ="select * from tbl_location_rack where status='A'";
 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch)
					    {
								
								$compQuery = $this -> db
					           -> select('*')
					           -> where('serial_number',$fetch->location_rack_id)
					           -> get('tbl_master_data');
							  $compRow = $compQuery->row();

$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$compRow->keyvalue).",";
$contents.=str_replace(',',' ',$fetch->rack_name).",\n";
  $i++;
} 


$filename = "LocationRack_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		