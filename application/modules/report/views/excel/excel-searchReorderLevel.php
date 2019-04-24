<?php
@extract($_GET);
 
$contents="S NO.,CODE,SPARE NAME,CATEGORY,MINIMUM ORDER RELEVEL,QUANTITY IN STOCK\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							$qry ="select * from tbl_product_stock where status='A'";

					
						if($_GET['code'] != "")
							$qry .= " AND sku_no LIKE '%".$_GET['code']."%'";

						

						
						if($_GET['sp_name'] != "")
							$qry .= " AND productname LIKE '%".$_GET['sp_name']."%'";

				 }

				
				else

					$qry ="select * from tbl_product_stock where status='A'";

 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $rows)
					    {
						
 
                               $size=$this->db->query("select *from tbl_master_data where serial_number='$rows->size'");
								$psize=$size->row();
								if($psize->keyvalue !='')
								{
									$pname=$rows->productname .'   ( '.$psize->keyvalue .')' ;
								}
								else
									$pname=$rows->productname;
							
								$sql1 = $this->db->query("select * from tbl_category where id='".$rows->category."' ");
								$sql2 = $sql1->row();

								


$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$rows->sku_no).",";
$contents.=str_replace(',',' ',$pname).",";
$contents.=str_replace(',',' ',$sql2->name).",";
if(($rows->min_re_order_level)>(round($rows->quantity,2))){
$contents.=str_replace(',',' ',$rows->min_re_order_level).",";
}
else
$contents.=str_replace(',',' '," ").",";	
$contents.=str_replace(',',' ',round($rows->quantity,2)).",\n";

  $i++;
} 


$filename = "Search_Reorder_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		
	
