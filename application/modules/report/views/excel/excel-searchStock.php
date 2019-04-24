<?php
@extract($_GET);
 
$contents="S NO.,CODE,SPARE NAME,CATEGORY,UNIT,UNIT PRICE PURCHASE,UNIT PRICE SALE,QUANTITY IN STOCK\n";	

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

								$proQ1=$this->db->query("select * from tbl_master_data where serial_number='$rows->usageunit'");
								$fProQ12=$proQ1->row();
 								


$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$rows->sku_no).",";
$contents.=str_replace(',',' ',$pname).",";
$contents.=str_replace(',',' ',$sql2->name).",";
$contents.=str_replace(',',' ',$fProQ12->keyvalue).",";
$contents.=str_replace(',',' ',$rows->unitprice_purchase).",";
$contents.=str_replace(',',' ',$rows->unitprice_sale).",";
$contents.=str_replace(',',' ',round($rows->quantity,2)).",\n";

  $i++;
} 


$filename = "Search_Stock_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		
	
