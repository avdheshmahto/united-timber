<?php
@extract($_GET);
 
$contents="S NO.,SPARE NAME,CATEGORY,USAGE UNIT,LOCATION,RACK,QUANTITY\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
					$qry="select * from tbl_product_serial where status='A'";				
			
				if($_GET['productname']!='')
					{
						$qry.="AND product_id='".$_GET['productname']."'";
						
					}	
				if($_GET['quantity']!='')
						{
							$qry.=" AND quantity='".$_GET['quantity']."'";
						}
				
				if($_GET['location']!='')
						{
							$qry.=" AND loc='".$_GET['location']."'";
						}

				if($_GET['rack']!='')
						{
							$qry.=" AND rack_id='".$_GET['rack']."'";
						}

				}
		

				
				else

					
				$qry="select * from tbl_product_serial where status='A'";

 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $rows)
					    {
								
								$getProductName=$this->db->query("select * from tbl_product_stock where Product_id='$rows->product_id'");
								$ProductName=$getProductName->row();
								 
								 $compQuery = $this -> db
										   -> select('*')
										   -> where('id',$ProductName->category)
										   -> get('tbl_category');
								 $compRow = $compQuery->row();

								 $compQuery1 = $this -> db
							   -> select('*')
							   -> where('serial_number',$ProductName->usageunit)
							   -> get('tbl_master_data');
							  $keyvalue1 = $compQuery1->row();
								
								$location=$this->db
								-> select('*')
								->where('serial_number',$rows->loc)
								->get('tbl_master_data');
								$loc=$location->row();

								$locationrack=$this->db
								-> select('*')
								->where('id',$rows->rack_id)
								->get('tbl_location_rack');
								$locationrackres=$locationrack->row();



$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$ProductName->productname).",";
$contents.=str_replace(',',' ',$compRow->name).",";
$contents.=str_replace(',',' ',$keyvalue1->keyvalue).",";
$contents.=str_replace(',',' ',$loc->keyvalue).",";
$contents.=str_replace(',',' ',$locationrackres->rack_name).",";
$contents.=str_replace(',',' ',$rows->quantity).",\n";
  $i++;
} 


$filename = "Spare_Location_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		