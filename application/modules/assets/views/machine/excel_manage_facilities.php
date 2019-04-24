<?php
@extract($_GET);
 
$contents="S NO.,CODE,NAME\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							$qry ="select * from tbl_facilities where status='A'";

								
						if($_GET['fac_loc'] != "")
		{
			$unitQuery2=$this->db->query("select * from  tbl_master_data where keyvalue LIKE '%".$_GET['fac_loc']."%'  and param_id='21'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->serial_number;
			
			$qry .= " AND fac_loc ='$sr_no2'";
		
		}
		


		if($_GET['fac_code'] != "")
			$qry .= " AND fac_code LIKE '%".$_GET['fac_code']."%'";


		if($_GET['fac_name'] != "")
			$qry .= " AND fac_name LIKE '%".$_GET['fac_name']."%'";

		
		
	
}
		

				
				else

					$qry ="select * from tbl_facilities where status='A'";

 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch_list)
					    {
					    	$facilityQuery = $this ->db->query("select * from tbl_master_data where serial_number='".$fetch_list->fac_loc."'");
         
$getfacility = $facilityQuery->row();

 
								

$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$fetch_list->fac_code).",";
$contents.=str_replace(',',' ',$fetch_list->fac_name).",\n";



  $i++;
} 


$filename = "Manage_Facilities"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		