<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">

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

	$ps=$this->db->query("select * from tbl_product_stock where Product_id='".$_GET['id']."'");
	$getPs=$ps->row();
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">CONSUMPTION REPORT (<?=$getPs->productname?>) </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<!-- <div class="panel-body panel-center" >
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Machine Name</label> 
<div class="col-sm-3"> 
 <select name="m_name"  class="select2 form-control" id="m_name">
		<option value="" >----Select Unit----</option>
		<?php 
			$sqlunit=$this->db->query("select * from tbl_machine where status='A'");
			foreach ($sqlunit->result() as $fetchunit){
		?>
		<option value="<?php echo $fetchunit->id;?>"><?php echo $fetchunit->machine_name; ?></option>
		<?php } ?>
 </select>
</div>

<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Parts & Supplies Name</label> 
<div class="col-sm-3"> 
<select name="sp_name"  class="select2 form-control" id="sp_name"  value="" >
<option value="">--select--</option>
<?php $getProductName=$this->db->query("select * from tbl_product_stock where status='A'");
$ProductName=$getProductName->result();
foreach($ProductName as $p) { ?>
<option value="<?=$p->Product_id?>"><?=$p->productname?></option>
<?php } ?>
</select>
</div>
<label>
	<button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Search</span></button></label>
</div>

</div>
</form>
</div>

 <div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
	<a href="<?=base_url();?>report/Report/excel_spare_machine_mapping_report?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'].'&filter='.'filter'?>" class="btn btn-sm" >Excel</a></div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/spare_machine_mapping_report?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
</div> -->

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>
		<th>Date</th>
		<th>Vendor</th>
		<th>Type</th>
		<!-- <th>Type Id</th> -->
		<th colspan="2" class="text-center">Inwards</th>
		<th colspan="2" class="text-center">Outwards</th>
		<th colspan="2" class="text-center">Closing</th>
        		
</tr>
<tr>
		<th></th>
		<th></th>
		<th></th>
		<!-- <th></th> -->
		<th class="blank_right text-center">Quantity</th>
		<th class="blank_left text-center">Price</th>
		<th class="blank_right text-center">Quantity</th>
		<th class="blank_left text-center">Price</th>
		<th class="blank_right text-center">Quantity</th>
		<th class="blank_left text-center">Price</th>
        		
</tr>
</thead>
<tbody id="getDataTable" >
<?php 

$prd=$this->db->query("select *,SUM(quantity) as totalQty from tbl_product_serial_log where product_id='".$_GET['id']."' AND name_role='product opening stock' "); 
$getPrd=$prd->row();

?>
<tr>
		<td><?php echo $getPrd->maker_date;?></td>
		<th colspan="2" class="text-center"><?php echo $getPrd->type;?></th>
		<!-- <th></th>
		<th></th> -->
		<td class="blank_right text-center"><?php echo $getPrd->totalQty; ?></td>
		<th class="blank_left text-center"><?php echo $getPrd->totalQty * $getPrd->purchase_price; ?></th>
		<th colspan="2"></th>
		<!-- <th></th> -->
		<td class="blank_right text-center"><?php echo $opQty=$getPrd->totalQty; ?></td>
		<th class="blank_left text-center"><?php echo $oPrc=$getPrd->totalQty * $getPrd->purchase_price; ?></th>
        		
</tr>

<?php

// $frstdate=date('Y-m-01');
// $lastdate=date('Y-m-t');

 // date_default_timezone_set("Asia/Kolkata");
 // echo $crdtTm=date('Y-m-d G:i:s');

$i=1;
$data=$this->db->query("select * from tbl_software_stock_log where product_id='".$_GET['id']."' ");
foreach($data->result() as $fetch) { ?>

<tr class="gradeC record">
<td><?php echo $fetch->maker_date; ?></td>
<th><?php 
$vndr=$this->db->query("select * from tbl_contact_m where contact_id='$fetch->vendor_id' ");
$getVndr=$vndr->row();
echo $getVndr->first_name; ?></th>
<th><?php echo $fetch->log_type; ?></th>
<!-- <td><?php echo $fetch->log_id; ?></td> -->

<?php 
  if($fetch->log_type == 'Receipt' || $fetch->log_type == 'Return' || $fetch->log_type == 'Tools Return' ) { ?>
<td class="blank_right text-center"><?php echo $innnQttty=$fetch->qty; ?></td>
<th class="blank_left text-center"><?php echo $innPrrrc=$fetch->total_price; ?></th>

<td class="blank_right text-center"></td>
<th class="blank_left text-center"></th>

<?php 
$sum1+=$innnQttty;
$sum2+=$innPrrrc;
?>

<?php if($i==1){ ?>
<td class="blank_right text-center"><?php echo $inQty=$opQty + $fetch->qty; ?></td>
<th class="blank_left text-center"><?php echo $inPric=$oPrc + $fetch->total_price; ?></th>
<?php } else { ?>
<td class="blank_right text-center"><?php echo $inQty=$inQty + $fetch->qty; ?></td>
<th class="blank_left text-center"><?php echo $inPric=$inPric + $fetch->total_price; ?></th>
<?php } ?>

<?php } ?>

<?php 
  if($fetch->log_type == 'Issue' || $fetch->log_type == 'Tools Issue' || $fetch->log_type == 'Consumable Issue' ) { ?>

<td class="blank_right text-center"></td>
<th class="blank_left text-center"></th>

<td class="blank_right text-center"><?php echo $outQttty=$fetch->qty; ?></td>
<th class="blank_left text-center"><?php echo $outPrrrc=$fetch->total_price; ?></th>

<?php 
$sum3+=$outQttty;
$sum4+=$outPrrrc;
?>

<?php if($i==1){ ?>
<td class="blank_right text-center"><?php echo $inQty=$opQty - $fetch->qty; ?></td>
<th class="blank_left text-center"><?php echo $inPric=$oPrc - $fetch->total_price; ?></th>
<?php } else { ?>
<td class="blank_right text-center"><?php echo $inQty=$inQty - $fetch->qty; ?></td>
<th class="blank_left text-center"><?php echo $inPric=$inPric - $fetch->total_price; ?></th>
<?php } ?>

<?php } ?>

</tr>
<?php $i++; } 

$sum1=$sum1+$opQty;
$sum2=$sum2+$oPrc;
$sum5=$inQty;
$sum6=$inPric;
 ?>


<tr>
	<th colspan="3" class="text-center">Totals :</th>
	<td class="blank_right text-center"><?php echo $sum1; ?></td>
	<th class="blank_left text-center"><?php echo $sum2; ?></th>
	<td class="blank_right text-center"><?php echo $sum3; ?></td>
	<th class="blank_left text-center"><?php echo $sum4; ?></th>
	<td class="blank_right text-center"><?php echo $sum5; ?></td>
	<th class="blank_left text-center"><?php echo $sum6; ?></th>
</tr>

</tbody>
</table>


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

</div>
</div>
</div>
</div>
<?php

$this->load->view("footer.php");
?>






<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Machine Spare Mapping Report<?php echo date('d-m-Y');?>.xls';
   
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

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
