<?php
$this->load->view("header.php");

if($_GET['id']!='')
{
	$query=$this->db->query("select * from tbl_spare_return_hdr where rflhdrid='".$_GET['id']."' ");	
	$fetchq=$query->row();
}

?>

<div class="main-content_ popup">
<ol class="breadcrumb breadcrumb-2"> 
	<li><a class="btn btn-success" href="<?=base_url();?>master/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a class="btn btn-success" href="<?=base_url();?>StockRefillNew/manage_stock_refill">Manage Parts And Supplies Return </a></li> 
</ol>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title"><strong> View Parts & Supplies Return</strong></h4>
<ul class="panel-tool-options"> 
	<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body">
<div class="table-responsive" style="margin-bottom:20px;">
<table class="table table-striped table-bordered table-hover">
<tbody>
<tr>
<th>Vendor Name</th>
<th>
<select name="vendor_id" class="select2 form-control" style="width:100%;" disabled="">
<option value="">--Select--</option>
<?php
$vendorQuery=$this->db->query("select *from tbl_contact_m where status='A'");
foreach($vendorQuery->result() as $getVendor){
?>
<option value="<?=$getVendor->contact_id;?>" <?php if($getVendor->contact_id==$fetchq->vendor_id){ ?> selected="selected" <?php }?>><?=$getVendor->first_name;?></option>
<?php }?>
</select>
</th>
<th></th>
<th></th>
<th>Return Date</th>
<th><input type="date" name="return_date" class="form-control" value="<?=$fetchq->return_date;?>" style="width:100%;" readonly  /></th>
</tr>
<tr>
<th valign="top">P.O. NO.</th>
<th><input type="number" name="po_no" class="form-control" value="<?=$fetchq->po_no;?>" readonly /></th>
<th valign="top">P.O. Date</th>
<th><input type="date" name="po_date" class="form-control" value="<?=$fetchq->po_date;?>" readonly /></th>
<th valign="top">Remarks</th>
<th><textarea name="remarks" class="form-control" readonly><?=$fetchq->remarks;?></textarea>
</th>
</tr>
</tbody>

</table>
</div>

<div style="width:100%; background:#dddddd; padding-left:0px; color:#000000; border:1px solid #1ABC9C">
<table style="width:100%;  background:#1ABC9C; color:#FFFFFF;  height:70%;" >
<tr>
<td><div style="text-align: center;"><u>S No.</u></div></td>
<td><div style="text-align: center;"><u>Parts And Supplies Name</u></div></td>
<td><div style="text-align: center;"><u>Location</u></div></td>
<td><div style="text-align: center;"><u>Rack</u></div></td>
<td><div style="text-align: center;"><u>Purchase Price</u></div></td>
<td><div style="text-align: center;"><u>Quantity</u></div></td>
</tr>
</table>


<div style="width:100%; background:white; color:#000000; max-height:170px;" >
<table style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" class="table table-bordered blockContainer lineItemTable ui-sortable"  >

<tr></tr>
<?php
$z=1;
$query_dtl=$this->db->query("select * from tbl_spare_return_dtl where refillhdr='".$_GET['id']."' ");
foreach($query_dtl->result() as $invoiceFetch)
{

$productQuery=$this->db->query("select *from tbl_product_stock where Product_id='$invoiceFetch->product_id'");
$getProductName=$productQuery->row();

$typeQuery=$this->db->query("select *from tbl_master_data where serial_number='$getProductName->usageunit'");
$gettype=$typeQuery->row();

?>
<tr>
<td align="center" style="width: 1%;"><?php echo $z++;?></td>
<td align="center" style="width: 7%;"><input type="text" name="pd[]" id="pd<?php echo $z;?>" value="<?php echo $getProductName->productname;?>" readonly="" style="text-align: center; width: 100%; border:hidden;">
</td>

<?php 
	$productQuery=$this->db->query("select * from tbl_master_data where serial_number='$invoiceFetch->loc'");
	$getProductName=$productQuery->row();
?>
<td align="center" style="width: 3%;">  <input type="text" name="locf[]" id="locdfsd<?php echo $z;?>" value="<?php echo $getProductName->keyvalue;?>"readonly="" style="text-align: center; width: 100%; border: hidden;">
</td>
<?php 
$productQuery=$this->db->query("select * from tbl_location_rack where id='$invoiceFetch->rack_id'");
$getProductName=$productQuery->row();
?>

<td align="center" style="width: 3%;"><input type="text" name="rack_idggg[]" id="qntybb<?php echo $z;?>" value="<?php echo $getProductName->rack_name;?>"readonly="" style="text-align: center; width: 100%; border: hidden;"></td>

<td align="center" style="width: 3%;">
<input type="text" name="purchase_price[]" id="purchase_price<?php echo $z;?>" value="<?php echo $invoiceFetch->purchase_price;?>" readonly="" style="text-align: center; width: 100%; border: hidden;"></td>

<td align="center" style="width: 3%;"><input type="text" name="new_quantity[]" id="qnty<?php echo $z;?>" value="<?php echo $invoiceFetch->quantity;?>"readonly="" style="text-align: center; width: 100%; border: hidden;"></td>

</tr>
<?php } ?>
</table>
</div>
</div>

<br>
<tbody>
<tr class="gradeA">
<th>
<div class="pull-right">
<a href="<?=base_url();?>return/spareReturn/manage_spare_return" class="btn btn-secondary  btn-sm">Cancel</a>
</div>
</th>
</tr>
</tbody>


</div>
</div>
</div>
</div>
</div>

<?php
$this->load->view("footer.php");
?>