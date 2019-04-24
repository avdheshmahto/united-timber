<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>
<div class="main-content">
<?php
$this->load->view("reportheader");
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">WORK ORDER DETAILS REPORT </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Date </label> 
<div class="col-sm-3">
<div class="input-group">
<input type="text" class="form-control reportrange" name="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width:100%" value="<?=$_GET['date_range'];?>">
<span class="input-group-addon">
 <span class="fa fa-calendar"></span>
</span> 
</div>
</div>
<label class="col-sm-2 control-label">Type</label> 
<div class="col-sm-3"> 
<select name="type" class="select2 form-control">
<option value="">--select--</option>
<option value="Spare" <?php if($_GET['type'] == 'Spare') { ?> selected <?php } ?>>Spare</option>
<option value="Consumable" <?php if($_GET['type'] == 'Consumable') { ?> selected <?php } ?>>Consumable</option>
<option value="Tools" <?php if($_GET['type'] == 'Tools') { ?> selected <?php } ?>>Tools</option>
</select>
</div>
</div>

<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Pats & Supplies Name</label> 
<div class="col-sm-3"> 
<select name="sp_name"  class="select2 form-control" id="sp_name"  value="" >
<option value="">--select--</option>
<?php $getProductName=$this->db->query("select * from tbl_product_stock where status='A'");
$ProductName=$getProductName->result();
foreach($ProductName as $p) { ?>
<option value="<?=$p->Product_id?>" <?php if($_GET['sp_name'] == $p->Product_id) { ?> selected <?php } ?>><?=$p->productname?></option>
<?php } ?>
</select>
</div>
</div>
<div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</div>
</div> 
</form>

<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
	<!-- <a href="<?=base_url();?>report/Report/excel_location_rack_report?<?='date_range='.$_GET['date_range'].'&type='.$_GET['type'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']?>" class="btn btn-sm" >Excel</a> -->

<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('tblData')">Excel</button>  &nbsp;&nbsp;

</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp; Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/detailed_workorder?<?='date_range='.$_GET['date_range'].'&type='.$_GET['type'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
</select>
entries</label>

<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -5px;margin-left: 12px;float: right;">
Showing <?=$dataConfig['page']+1;?> to 
<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
?> of <?=$dataConfig['total'];?> entries
</div>
</div>
<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
</label>
</div>
</div>

</div>
</div>


<div class="panel-body">
<div class="table-responsive" >
<table class="table table-striped table-bordered table-hover dataTables-example1" id="tblData">

<thead>
<tbody>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th> 
<th></th> 
<th>Workorder Total Amount =</th>
<th><span id="workorder_total">  </span> </th>
</tbody>
</thead>

<thead>
<tr>

  <th>S. No.</th>
  <th>Work Order Id</th>
  <th>Parts & Supplies Name</th>
  <th>Price</th>
  <th>Qty</th>
  <th>Parts & Supplies Amount</th>
  <th>Type</th>
  <th>Labour Cost</th>
    
</tr>
</thead>

<tbody id="getDataTable" >
<?php

//$i=0;
$z=1;
foreach($result as $fetch_list) {  ?>
<tr class="gradeC record">
<th><?=$z++?></th>
<th><?=$fetch_list->workorder_id?></th>
<th>
<?php
  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->spare_id'");
  $getPrd=$prd->row();
  echo $getPrd->productname; ?>
</th>
<th><?php echo $fetch_list->price; ?></th>   
<th><?php echo $fetch_list->qty; ?></th>
<th><?php echo $totalprice = $fetch_list->price * $fetch_list->qty?></th>
<th><?=$getPrd->via_type?></th>
<?php 

  $laborCost=$this->db->query("select SUM(cost_spent) as totalcost,work_order_id as wid from tbl_workorder_labor_task where work_order_id='$fetch_list->workorder_id' ");
  $getCost=$laborCost->row();
  
  $cost=0;

    if($i == 0)  {  ?>

    <th><?php echo $cost=$getCost->totalcost ?></th>
 
    <?php } else { ?>

    <th><?php echo $cost=''; ?></th>
    
    <?php }

    $total=$totalprice + $cost;
    
    ?>  

</tr>
<?php 

$totalCost=$totalCost+$total;
$spareCost=$spareCost + $totalprice;
$labourCost=$labourCost + $cost;

 if($fetch_list->workorder_id == $getCost->wid)
 {

   $i++;
 }
 else
 {
   $i=0;
 }

} ?>
</tbody>

<tbody>
<th></th>
<th></th>
<th></th>
<th></th> 
<th>Total Pars & Supplies Amount =</th>
<th><span id="parts_total"></span></th>
<th>Total Labour Cost =</th>
<th><span id="labour_total"></span></th>
</tbody>

<input type="hidden" name="totalprice" id="totalprice" class="form-control" value="<?=$totalCost;?>" />
<input type="hidden" name="spare_price" id="spare_price" class="form-control" value="<?=$spareCost;?>" />
<input type="hidden" name="labour_cost" id="labour_cost" class="form-control" value="<?=$labourCost;?>" />

</table>


</div>
</div>


</div>
</div>
</div>

<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> 
		</div>
		<div class="col-md-6"> 
			<?php echo $pagination; ?>
		</div>
	</div>
</div>

<?php
$this->load->view("footer.php");
?>

<script type="text/javascript">

var id1=document.getElementById("totalprice").value;
document.getElementById("workorder_total").innerHTML = id1;

var id12=document.getElementById("spare_price").value;
document.getElementById("parts_total").innerHTML = id12;

var id123=document.getElementById("labour_cost").value;
document.getElementById("labour_total").innerHTML = id123;


function ResetLead()
{
  location.href="<?=base_url('/report/Report/detailed_workorder');?>";
}

</script>


<script type="text/javascript">

function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'WORK ORDER DETAILS REPORT (<?php echo date('d-m-Y');?>).xls';
   
   // Create download link element
   downloadLink = document.createElement("a");
   
   document.body.appendChild(downloadLink);
   
   if(navigator.msSaveOrOpenBlob){
       var blob = new Blob(['\ufeff', tableHTML], {
           type: dataType
       });
       navigator.msSaveOrOpenBlob( blob, filename);
   }else{

       // Create a link to the file
       downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
   
       // Setting the file name
       downloadLink.download = filename;
       
       //triggering the function
       downloadLink.click();
   }
}

</script>

<script type="text/javascript">

$(function() {

   var start = moment().subtract(29, 'days');
   var end = moment();

   function cb(start, end) {
       $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
   }

   $('.reportrange').daterangepicker({
       // startDate: start,
       // endDate: end,
       ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
       }
   }, cb);

   cb(start, end);

});

</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">