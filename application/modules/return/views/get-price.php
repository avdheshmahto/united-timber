<?php
$loc = $_GET['loc'];
$rack_id = $_GET['rack_id'];
$main_id = $_GET['main_id'];
$vendor_id = $_GET['vendor_id'];
?>
<!-- <select name="price" id="price" class="form-control" style="width:70px;">  
<option>--Select--</option> -->
<?php 
$xyz=$this->db->query("select * from tbl_product_serial where product_id='$main_id' AND supp_name='$vendor_id' AND loc='$loc' AND rack_id='$rack_id' ");
$count=$xyz->num_rows();
if($count > 0){
foreach ($xyz->result() as $values) { ?>
<option value="<?=$values->purchase_price;?>"><?=$values->purchase_price;?></option>	
<?php } } else {?>
<!-- </select> -->
<option value="">--Nothing Map--</option>
<?php } ?>