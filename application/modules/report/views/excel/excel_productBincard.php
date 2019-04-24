<?php
@extract($_GET);
 
$contents="S NO.,BIN CARD ID,BIN CARD TYPE,TYPE OF SPARE,PRODUCT NAME,MACHINE NAME,VENDOR NAME,DATE,GRN NO.,GRN DATE,REMARKS,QUANTITY IN STOCK\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							
				$qry ="select * from tbl_bin_card_dtl D,tbl_bin_card_hdr H where H.rflhdrid = D.refillhdr AND D.status='A' AND H.status='A'";

								
				if($_GET['temp_id'] != "")
				$qry .= " AND H.bin_card_type = '".$_GET['temp_id']."'";
		
		
				if($_GET['p_name'] != "")
				{
					$unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$_GET['p_name']."%'");
					$getUnit2   = $unitQuery2->row();
					$sr_no2     = $getUnit2->contact_id;
					
					$qry  .= " AND H.vendor_id ='$sr_no2'";
				
				}
				
				if($_GET['type_of_spare'] != "")
				{
					$unitQuery2 =$this ->db->query("select * from tbl_product_stock S where  S.type_of_spare = '".$_GET['type_of_spare']."'");
					$getUnit2   = $unitQuery2->row();
					$sr_no2     = $getUnit2->Product_id;
					
					$qry       .= " AND D.product_id ='$sr_no2'";
				
				}
				
				
				if($_GET['sp_name'] != "")
				{
					$unitQuery2 = $this->db->query("select * from  tbl_product_stock where productname LIKE '%".$_GET['sp_name']."%'");
					$getUnit2   = $unitQuery2->row();
					$sr_no2     = $getUnit2->Product_id;
					
					$qry       .= " AND D.Product_id ='$sr_no2'";
				
				}
				
				
				if($_GET['quantity'] != "")
					$qry .= " AND D.quantity = '".$_GET['quantity']."'";
				
				if($_GET['grn_no'] != "")
					$qry .= " AND grn_no LIKE '%".$_GET['grn_no']."%'";
				
					
					
				
				if($_GET['f_date']!='')
				{
				    $t_date=explode("-",$_GET['t_date']);
					$f_date=explode("-",$_GET['f_date']);
		      		$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
			        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
					$qry .=" and H.date >='$f_date1' and H.date <='$t_date1'";
				}
				}
		

				
				else

					
				$qry ="select * from tbl_bin_card_dtl D,tbl_bin_card_hdr H where H.rflhdrid = D.refillhdr AND D.status='A' AND H.status='A'";

 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch)
					    {
								
								$bincardQuery = $this ->db->query("select * from tbl_bin_card_hdr where rflhdrid='".$fetch->refillhdr."'");

								$getbincard = $bincardQuery->row();
								 $compQuery1 = $machineQuery = $this ->db->query("select * from tbl_master_data D,tbl_product_stock S where D.serial_number = S.type_of_spare  AND S.Product_id='".$fetch->product_id."'");
          						$keyvalue1 = $compQuery1->row();	
          						$productQuery = $this ->db->query("select * from tbl_product_stock where Product_id='".$fetch->product_id."'");
          						$getproduct = $productQuery->row();



								$getMachine = $machineQuery->row();
								$machineQuery = $this ->db->query("select * from tbl_machine where id='".$fetch->machine_id."'");
           
								$getMachine = $machineQuery->row();
								$bincardContactQuery = $this ->db->query("select * from tbl_contact_m where contact_id='".$fetch->vendor_id."'");
								$getbincardContact = $bincardContactQuery->row();


								$getbincard = $bincardQuery->row();
								$bincardQuery = $this ->db->query("select * from tbl_bin_card_hdr where rflhdrid='".$fetch->refillhdr."'");
           						$getbincard = $bincardQuery->row();


$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$fetch->refillhdr).",";
$contents.=str_replace(',',' ',$getbincard->bin_card_type).",";
$contents.=str_replace(',',' ',$keyvalue1->keyvalue).",";
$contents.=str_replace(',',' ',$getproduct->productname).",";
$contents.=str_replace(',',' ',$getMachine->machine_name).",";
$contents.=str_replace(',',' ',$getbincardContact->first_name).",";
$contents.=str_replace(',',' ',$getbincard->date).",";
$contents.=str_replace(',',' ',$getbincard->grn_no).",";
$contents.=str_replace(',',' ',$getbincard->grn_date).",";
$contents.=str_replace(',',' ',$getbincard->remarks).",";
$contents.=str_replace(',',' ',$fetch->quantity).",\n";
  $i++;
} 


$filename = "ProductBinCard_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		