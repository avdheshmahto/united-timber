<?php
@extract($_GET);
 
$contents="S NO.,MACHINE TYPE,MACHINE NAME,SPARE NAME,PURCHASE PRICE\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							
				$qry ="select * from tbl_machine_spare_map where status='A' ";
								
				if($_GET['m_name'] != "")
				 $qry .= " AND machine_id = '".$_GET['m_name']."'";

		
				if($_GET['sp_name'] != "")
				{
					$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$_GET['sp_name']."%'");
					$getUnit2   = $unitQuery2->row();
					$sr_no2     = $getUnit2->Product_id;
					
					$qry       .= " AND spare_id ='$sr_no2'";
				
				}

				}
				else

					
				$qry ="select * from tbl_machine_spare_map where status='A' ";
 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch)
					    {
								
								$vendorQuery = $this->db->query("select * from tbl_machine where id='".$fetch->machine_id."'");
								$getvendor = $vendorQuery->row();

								$sparesQuery = $this->db->query("select * from tbl_master_data where param_id='23' AND serial_number='".$getvendor->m_type."'");
								$getspares = $sparesQuery->row();

								$spareQuery = $this->db->query("select * from tbl_product_stock where Product_id='".$fetch->spare_id."'");
								$getspare = $spareQuery->row();

								

$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$getspares->keyvalue).",";
$contents.=str_replace(',',' ',$getvendor->machine_name).",";
$contents.=str_replace(',',' ',$getspare->productname).",";
$contents.=str_replace(',',' ',$getspare->unitprice_purchase).",\n";
  $i++;
} 


$filename = "SPARE_MACHINE_MAPPING_REPORT"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		