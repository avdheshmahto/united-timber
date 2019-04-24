
<?php
$this->load->view("header.php");
$entries = "";
if($this->input->get('entries')!=""){
  $entries = $this->input->get('entries');
}


?>
<!-- Main content -->
<div class="main-content">

<?php
$this->load->view("reportheader");
?>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php 
$wo=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' ");
$getWO=$wo->row();
if($getWO->trigger_code != '') { ?>
<h4 class="panel-title">WORKORDER MAINTENANCE DETAILS (<?php echo 'WO'.$getWO->id.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SM'.$getWO->trigger_code;?>)</h4>
<?php } else { ?>
<h4 class="panel-title">WORKORDER MAINTENANCE DETAILS (<?php echo 'WO'.$getWO->id; ?>) </h4>	
<?php } ?>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>

<!-- <div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">

<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Date </label> 
<div class="col-sm-3">
<div class="input-group">
<input type="text" class="form-control reportrange" name="daterangestg" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width:100%" value="<?=$_GET['daterangestg'];?>">
<span class="input-group-addon">
 <span class="fa fa-calendar"></span>
</span>	
</div>
</div>
<label class="col-sm-2 control-label">Type</label> 
<div class="col-sm-3"> 
<select name="type" class="select2 form-control">
<option value="">--select--</option>
<option value="">Spare</option>
<option value="">Consumeable</option>
<option value="">Tools</option>
<option value="">All</option>
</select>
</div>
</div>

<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Section</label> 
<div class="col-sm-3"> 
<select name="section" class="select2 form-control" >
<option value="">--select--</option>
<?php //$qry="select * from tbl_facilities where status='A'";
//$qryres=$this->db->query($qry)->result();
//foreach($qryres as $res) { ?>
<option value="<?=$res->id?>"><?=$res->fac_name?></option>	
<?php// } ?>
</select>
</div>
<label class="col-sm-2 control-label">Machine</label> 
<div class="col-sm-3"> 
<select name="machine" class="select2 form-control">
<option value="">--select--</option>
<?php //$qry="select * from tbl_machine where status='A'";
//$qryres=$this->db->query($qry)->result();
//foreach($qryres as $res) { 
//$fac=$this->db->query("select * from tbl_facilities where id='$res->m_type'");
//$getFac=$fac->row(); ?>
<option value="<?=$res->id?>"><?php echo $res->machine_name."(". $getFac->fac_name.")"?></option>	
<?php //} ?>
</select>
</div>
</div> 

<div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</form>
</div>-->



<div class="row" style="display: none;">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<!-- <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button>  &nbsp;&nbsp; -->
<a href="<?=base_url();?>report/Report/excel_spare_location_report?<?='productname='.$_GET['productname'].'&quantity='.$_GET['quantity'].'&location='.$_GET['location'].'&rack='.$_GET['rack'].'&filter='.$_GET['filter']?>" class="btn btn-sm" >Excel</a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>&nbsp; &nbsp; Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/Spare_Location?<?='productname='.$_GET['productname'].'&quantity='.$_GET['quantity'].'&location='.$_GET['location'].'&rack='.$_GET['rack'].'&filter='.$_GET['filter']?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
<input type="text" id="searchTerm" name="filter" class="search_box form-control input-sm" onkeyup="doSearch();" placeholder="What you looking for?">
</label>
</div>
</div>

</div>
</div>


<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  >

<thead>
<tbody>
<th></th>
<th></th>
<th></th>	
<th></th>	
<th>Workorder Total Amount =</th>
<th><input type="text" name="workorder_total" id="workorder_total" class="form-control" style="width: 100px;" readonly=""/></th>
</tbody>
</thead>

<thead>
<tr>

	<th>Parts & Supplies Name</th>
	<th>Type</th>
	<th>Price</th>
	<th>Qty</th>
	<th>Parts & Supplies Amount</th>
	<th>Labor Cost</th>
		
</tr>
</thead>

<tbody id="getDataTable" >
<?php

	$issuehdr=$this->db->query("select * from tbl_spare_issue_hdr where workorder_id='".$_GET['id']."' ");
	$count=$issuehdr->num_rows();

	$ishdrid=array();
	foreach ($issuehdr->result() as $value) 
	{
		array_push($ishdrid, $value->issue_id);		
	}

	if($count > 0)
	{
		$IssueIdHdr=implode(',', $ishdrid);
	}
	else
	{
		$IssueIdHdr='999999';
	}

$issuedtl=$this->db->query("select * from tbl_spare_issue_dtl where issue_id_hdr IN ($IssueIdHdr) ");
$count=$issuedtl->num_rows();
$i=0;
foreach($issuedtl->result() as $fetch_list) {
?>
<tr class="gradeC record">
<th>
<?php
	$prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->spare_id'");
	$getPrd=$prd->row();
	echo $getPrd->productname; ?>
</th>
<th><?=$getPrd->via_type?></th>
<th><?php echo $fetch_list->price ;?></th>	 
<th><?php echo $fetch_list->qty; ?></th>
<th><?php echo $totalprice = $fetch_list->price * $fetch_list->qty?></th>
<?php 
	
	$laborCost=$this->db->query("select SUM(cost_spent) as totalcost from tbl_workorder_labor_task where work_order_id='".$_GET['id']."' ");
	$getCost=$laborCost->row();

	if($i == 0)
	{ ?>
		<th rowspan="<?=$count?>">
		<div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
			<?php echo $cost=$getCost->totalcost; ?>
		</div>	
		</th>
	<?php
	}
	else
	{
		$cost=0;
	}

	$total=$totalprice + $cost;
?>	

</tr>
<?php 
$sum=$sum+$total;
$i++;
} ?>

<input type="hidden" name="totalprice" id="totalprice" class="form-control" value="<?php echo $sum;?>" />

</tbody>
</table>
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
</div>







<script type="text/javascript">

var id1=document.getElementById("totalprice").value;
document.getElementById("workorder_total").value = id1;

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