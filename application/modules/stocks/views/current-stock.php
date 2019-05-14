<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>
<div class="main-content">

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">CURRENT STOCK </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Pats & Supplies Name</label> 
<div class="col-sm-3"> 
<select name="sp_name"  class="select2 form-control" id="sp_name"  >
<option value="">--select--</option>
<?php $getProductName=$this->db->query("select * from tbl_product_stock where status='A'");
$ProductName=$getProductName->result();
foreach($ProductName as $p) { ?>
<option value="<?=$p->Product_id?>"  <?php if($_GET['sp_name'] == $p->Product_id) { ?>selected <?php } ?> ><?=$p->productname?></option>
<?php } ?>
</select>
</div>
<label class="col-sm-2 control-label">Type</label> 
<div class="col-sm-3"> 
<select name="type" class="select2 form-control" >
	<option value="">---Select----</option>
	<option value="Spare" <?php if($_GET['type']=='Spare') {?> selected <?php } ?> >Spare</option>
	<option value="Tools" <?php if($_GET['type']=='Tools') {?> selected <?php } ?>>Tools</option>
	<option value="Consumable" <?php if($_GET['type']=='Consumable') {?> selected <?php } ?>>Consumable</option>
</select>
</div>
</div>
<div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button> 	
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</form>
</div>

<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
	<!-- <a href="<?=base_url();?>report/Report/excel_spare_machine_mapping_report?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'].'&filter='.'filter'?>" class="btn btn-sm" >Excel</a> -->
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button>
&nbsp;&nbsp;		
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>stocks/current_stock/manage_current_stock?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>	
		<th>Date</th>
		<th>Parts And Supplies Name</th>
		<th>Type</th>
		<th>Sub-Type</th>		
		<th>Location</th>
		<th>Rack</th>
		<th>Quantity</th>        
		<th>Vendor Name</th>
		<th>Purchase Price</th>
		
</tr>
</thead>
<tbody id="getDataTable" >
<?php
foreach($result as $fetch){
?>
<tr class="gradeC record">
<?php  

$locaquery = $this->db->query("select * from tbl_product_stock where Product_id='".$fetch->product_id."'");
$getlocate = $locaquery->row();

$type=$this->db->query("select * from tbl_master_data where serial_number='$getlocate->type_of_spare'");
$getType=$type->row();

$vnd=$this->db->query("select * from tbl_contact_m where contact_id = '$fetch->supp_name' ");
$getVnd=$vnd->row();

$main_locQuery = $this->db->query("select * from tbl_master_data where serial_number='".$fetch->loc."'");
$getmain_loc = $main_locQuery->row();

$main_rackQuery = $this->db->query("select * from tbl_location_rack where id='".$fetch->rack_id."'");
$getmain_rack = $main_rackQuery->row();

?>
<th><?php echo $fetch->maker_date ?> </th>
<th><?php echo $getlocate->productname; ?></th>
<th><?php echo $getType->keyvalue; ?></th>
<th><?php echo $fetch->module_status; ?></th>
<th><?php echo $getmain_loc->keyvalue; ?></th>
<th><?php echo $getmain_rack->rack_name; ?></th>
<th><?php echo $fetch->quantity; ?></th>
<th><?php echo $getVnd->first_name; ?></th>
<th><?php echo $fetch->purchase_price; ?></th>
</tr>
<?php  }  ?>
</tbody>
</table>
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
   filename = filename?filename+'.xls':'LOCATION WISE CURRENT STOCK REPORT(<?php echo date('d-m-Y');?>).xls';
   
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

function ResetLead()
{
  location.href="<?=base_url('/stocks/current_stock/manage_current_stock');?>";
}
</script>
