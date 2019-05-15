<?php
$this->load->view("header.php");
$id=$_GET['id'];

if($_GET['id']!='')
{
	$query=$this->db->query("select * from tbl_bin_card_hdr where rflhdrid='$id'");	
	$fetchq=$query->row();
}

?>

<div class="main-content_ popup">

<ol class="breadcrumb breadcrumb-2"> 
	<li><a class="btn btn-success" href="<?=base_url();?>master/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a class="btn btn-success" href="<?=base_url();?>StockRefillNew/manage_stock_refill">Manage Bin Card </a></li> 
</ol>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
	<h4 class="panel-title"><strong> View Bin Card</strong></h4>
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
<select disabled name="vendor_id_spare" id="vendor_id_spare" class="select2 form-control input-sm" readonly=""  style="width:100%;">
<option value="">--Select--</option>
<?php
$vendorQuery=$this->db->query("select *from tbl_contact_m where group_name = '5' and status='A'");
foreach($vendorQuery->result() as $getVendor){
?>
<option value="<?=$getVendor->contact_id;?>" <?php if($getVendor->contact_id==$fetchq->vendor_id){?> selected="selected" <?php }?>><?=$getVendor->first_name;?></option>
<?php }?>
</select>
</th>

<th>GRN No.</th>
<th><input type="text" name="grn_no" class="form-control input-sm" value="<?=$fetchq->grn_no;?>" readonly="" /></th>
<th>GRN Date</th>
<th><input type="date" name="grn_date" class="form-control input-sm" value="<?=$fetchq->grn_date;?>"readonly="" />
</th>	
</tr>

<tr>
<th>Po No.</th>
<th><input type="text" name="po_no" class="form-control input-sm" value="<?=$fetchq->po_no;?>" readonly="" /></th>
<th>Po Date</th>
<th><input type="date" name="po_date" class="form-control input-sm" value="<?=$fetchq->po_date;?>"readonly="" /></th>	
<th valign="top">Remarks</th>
<th><textarea name="remarks" class="form-control input-sm" readonly=""><?php echo $fetchq->remarks;?></textarea></th>
</tr>

</tbody>
</table>
</div>
<div style="width:100%; background:#dddddd; padding-left:0px; color:#000000; border:1px solid #1ABC9C;">
<table id="invo" style="width:100%;  background:#1ABC9C; color:#FFFFFF;  height:70%;"  >
<tr>
<td><div align="center"><u>Sl No</u>.</div></td>
<td><div align="center"><u>Parts & Supplies Name</u></div></td>
<td><div align="center"><u>Location </u></div></td>
<td><div align="center"><u>Rack</u></div></td>
<td><div align="center"><u>Purchase Price</u></div></td>
<td><div align="center"><u>Quantity</u></div></td>
</tr>
</table>

<div style="width:100%; background:white; color:#000000;  max-height:170px;">
<table id="invoice"  style="width:100%;background:white;margin-bottom:0px;" class="table table-bordered blockContainer lineItemTable ui-sortable"  >
<tr></tr>
<?php
$z=1;
$query_dtl=$this->db->query("select * from tbl_bin_card_dtl where refillhdr='".$_GET['id']."' ");
foreach($query_dtl->result() as $invoiceFetch)
{

	$productQuereey=$this->db->query("select *from tbl_product_stock where Product_id='$invoiceFetch->product_id'");
	$getProductNamea=$productQuereey->row();

	$typeQuery=$this->db->query("select *from tbl_master_data where serial_number='$getProductNamea->usageunit'");
	$gettype=$typeQuery->row();

?>
<tr>
<td align="center" style="width: 1%;"><?php echo $z++;?></td>
<td align="center" style="width: 7%;">
<input type="text" name="pd[]" id="pd<?php echo $z;?>" value="<?php echo $getProductNamea->productname;?>" readonly="" style="text-align: center; width: 100%; border:hidden;">
</td>

<?php 
$productQuery=$this->db->query("select * from tbl_master_data where serial_number='$invoiceFetch->loc'");
$getProductName=$productQuery->row();
?>
<td align="center" style="width: 3%;"><input type="text" name="locff[]" id="locat<?php echo $z;?>" value="<?php echo $getProductName->keyvalue;?>"readonly="" style="text-align: center; width: 100%; border: hidden;"></td>

<?php 
$productQuerys=$this->db->query("select * from tbl_location_rack where id='$invoiceFetch->rack_id'");
$getProductNamrtre=$productQuerys->row();
?>
<td align="center" style="width: 3%;"><input type="text" name="rack_id22[]" id="rackloc<?php echo $z;?>" value="<?php echo $getProductNamrtre->rack_name;?>"readonly="" style="text-align: center; width: 100%; border: hidden;"></td>

<td align="center" style="width: 3%;">
<input type="text" name="price[]" id="price<?php echo $z;?>" value="<?php echo $invoiceFetch->purchase_price;?>" readonly="" style="text-align: center; width: 100%; border: hidden;">
</td>

<td align="center" style="width: 3%;"><input type="text" name="new_quantity[]" id="qnty<?php echo $z;?>" value="<?php echo $invoiceFetch->quantity;?>"readonly="" style="text-align: center; width: 100%; border: hidden;"></td>

</tr>
<?php } ?>
</table>
</div>
</div>

<div class="table-responsive" style="margin-bottom:20px;">
<table class="table table-striped table-bordered table-hover" >
<tbody>
<tr class="gradeA">
<th>
<div class="pull-right">
<a href="<?=base_url();?>bincard/binCard/manage_bin_card" class="btn btn-secondary  btn-sm">Cancel</a>
</div>
</th>
</tr>
</tbody>
</table>
</div>

</div>
</div>
</div>
</div>
<?php
$this->load->view("footer.php");
?>
