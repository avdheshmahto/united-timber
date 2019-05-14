<?php
$this->load->view("header.php");
?>
<form id="f1" name="f1" method="POST" action="insertSpareReturn" onSubmit="return checkKeyPressed(a)">

<div class="main-content">
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a href="#">Parts & Supplies Return</a></li> 
	<li class="active"><strong><a href="#">Add Parts & Supplies Return</a></strong></li> 
	<div class="pull-right">
	<a class="btn btn-sm" href="<?=base_url();?>return/spareReturn/manage_spare_return">Manage Parts & Supplies Return</a>
	</div>
</ol>

<div class="row">
<div class="col-lg-12">
<div class="heading">
<h4 class="panel-title"><strong>Add Parts & Supplies Return</strong></h4>
							
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="margin-bottom:20px;">
<tbody>

<tr>
<select name="bin_card_type" style="display:none;" class="form-control"  />
<option value="">--Select--</option>
<option value="Receipt">Receipt</option>
<option value="Return" selected="selected">Return</option>
</select>	

<th>Vendor Name</th>
<th>
<select name="vendor_id" id="vendor_id" class="form-control" onchange="getSpare(this.value)"required>
<option value="">--Select--</option>
<?php
$vendorQuery=$this->db->query("select *from tbl_contact_m where status='A' and group_name = '5'");
foreach($vendorQuery->result() as $getVendor){
?>
<option value="<?=$getVendor->contact_id;?>"><?=$getVendor->first_name;?></option>
<?php }?>
</select>
</th>
<th>Parts & Supplies Name</th>
<th>
	<select name="spareName" id="spareName" class="select2 form-control" onchange="getLocationData(this.value);">
		<option value="">--Select---</option>
	</select>
</th>
<th>Return Date</th>
<th><input type="date" name="return_date" class="form-control"  /></th>
</th>
</tr>

<tr>
<th>P.O. NO.</th>
<th><input type="number" name="po_no" class="form-control" required /></th>
<th>P.O. Date</th>
<th><input type="date" name="po_date" class="form-control" required /></th>
<th>Remarks</th>
<th><textarea name="remarks" class="form-control"></textarea></th>
</tr>
</tbody>
</div>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="margin-bottom:20px;">
<thead>
<tr class="gradeA">
<th>Location </th>
<th>Rack</th>
<th>Vendor Name</th>
<th>Purchase Price</th>
<th>Qty in Stock</th>
<th>Enter Return Qty</th>
<th>Action</th>
</tr>
</thead>
<tbody id="getDataTablePage">
</tbody>
</table>
</div>

<table class="table table-striped table-bordered table-hover">
<tr>
<td><u>Parts & Supplies Name</u></td>
<td><u>Location</u></td>
<td><u>Rack</u></td>
<th><u>Vendor Name</u></th>
<td><u>Purchase Price</u></td>
<td><u>Quantity</u></td>
<td><u>Action</u></td>
</tr>
<tbody id="getDataTable">
</tbody>
</table>


<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" >
<tbody>
<tr class="gradeA">
<th>
<div class="pull-right">
<input class="btn btn-sm" type="button" name="save" value="SAVE"   id="sv1" onclick="fsv(this)" >&nbsp;<a href="<?=base_url();?>return/spareReturn/manage_spare_return" class="btn btn-secondary  btn-sm">Cancel</a>
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
</form>

<script type="text/javascript">


function getSpare(v)
{

  var prod=v;
  var xhttp = new XMLHttpRequest();
   xhttp.open("GET", "spare_dropdown?vid="+ prod, false);
  xhttp.send();
  $("#spareName").empty().trigger('change').append(xhttp.responseText);

}

function getLocationData(v)
{
 
  var prod=v;
  var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "spare_return_page?PID="+ prod, false);
  xhttp.send();
  document.getElementById("getDataTablePage").innerHTML = xhttp.responseText;
  //$("#getDataTablePage").empty().append(xhttp.responseText);

}
      
</script>


<?php
$this->load->view("footer.php");
?>