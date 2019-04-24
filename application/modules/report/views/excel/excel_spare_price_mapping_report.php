<?php
@extract($_GET);
 
$contents="S NO.,VENDOR NAME,SPARE NAME,RATE,DATE\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							
				$qry ="select * from tbl_vendor_spare_price_map V,tbl_contact_m C where V.vendor_id = C.contact_id AND V.status='A'  AND C.status='A'";
								
				if($_GET['v_name'] != "")
			$qry .= " AND V.vendor_id LIKE '%".$_GET['v_name']."%'";

		
		if($_GET['sp_name'] != "")
		{
			$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$_GET['sp_name']."%'");
			$getUnit2   = $unitQuery2->row();
			$sr_no2     = $getUnit2->Product_id;
			
			$qry       .= " AND V.spare_id ='$sr_no2'";
		
		}
		
		
		if($_GET['f_date']!='')
		{
		    $t_date=explode("-",$_GET['t_date']);
			$f_date=explode("-",$_GET['f_date']);
      		$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
	        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
			$qry .=" and C.maker_date >='$f_date1' and C.maker_date <='$t_date1'";
		}
		
				}
		

				
				else

					
				
				$qry ="select * from tbl_vendor_spare_price_map V,tbl_contact_m C where V.vendor_id = C.contact_id AND V.status='A'  AND C.status='A'";
 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch)
					    {
								
								
								$vendorQuery = $this->db->query("select * from tbl_contact_m where contact_id='".$fetch->vendor_id."'");
								$getvendor = $vendorQuery->row();

								$spareQuery = $this->db->query("select * from tbl_product_stock where Product_id='".$fetch->spare_id."'");
								$getspare = $spareQuery->row();





$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$getvendor->first_name).",";
$contents.=str_replace(',',' ',$getspare->productname).",";
$contents.=str_replace(',',' ',$fetch->price).",";
$contents.=str_replace(',',' ',$fetch->maker_date).",\n";
  $i++;
} 


$filename = "Spare_Price_Mapping_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		