<?php
@extract($_GET);
 
$contents="S NO.,BIN CARD ID,BIN CARD TYPE,MACHINE NAME,VENDOR NAME,DATE,GRN NO.,GRN DATE,REMARKS\n";	

				 if($_GET["filter"]=="filter")
				 {
				 
							
							$qry ="select * from tbl_bin_card_hdr where status='A'";

								
						if($_GET['temp_id'] != "")
						$qry .= " AND bin_card_type = '".$_GET['temp_id']."'";
					
					
					if($_GET['p_name'] != "")
					{
						$unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%".$_GET['p_name']."%'");
						$getUnit2   = $unitQuery2->row();
						$sr_no2     = $getUnit2->contact_id;
						
						$qry       .= " AND vendor_id ='$sr_no2'";
					
					}
					
					if($_GET['f_date']!='')
					{
					
						$t_date=explode("-",$_GET['t_date']);
						
						$f_date=explode("-",$_GET['f_date']);

						$t_date1=$t_date[0]."-".$t_date[1]."-".$t_date[2];
				        $f_date1=$f_date[0]."-".$f_date[1]."-".$f_date[2];
						$qry .=" and date >='$f_date1' and date <='$t_date1'";
					}
				}
		

				
				else

					$qry ="select * from tbl_bin_card_hdr where status='A'";

 
$result=$this->db->query($qry)->result();


						$i=1;
						foreach($result as $fetch)
					    {
								$machineQuery = $this ->db->query("select * from tbl_machine where id='".$fetch->machine_id."'");

								$getMachine = $machineQuery->row();
 								$vendorQuery = $this -> db
					           -> select('*')
					           -> where('contact_id',$fetch->vendor_id)
					           -> get('tbl_contact_m');
							   $getVendor=$vendorQuery->row();


$contents.=str_replace(',',' ',$i).",";
$contents.=str_replace(',',' ',$fetch->rflhdrid).",";
$contents.=str_replace(',',' ',$fetch->bin_card_type).",";
$contents.=str_replace(',',' ',$getMachine->machine_name).",";
$contents.=str_replace(',',' ',$getVendor->first_name).",";
$contents.=str_replace(',',' ',$fetch->date).",";
$contents.=str_replace(',',' ',$fetch->grn_no).",";
$contents.=str_replace(',',' ',$fetch->grn_date).",";
$contents.=str_replace(',',' ',$fetch->remarks).",\n";

  $i++;
} 


$filename = "Search_BinCard_Report"."_".@date('Y-m-d');
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;" . @date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $contents;
exit;

?>		