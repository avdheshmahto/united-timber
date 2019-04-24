<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">

<?php
$this->load->view("header.php");
require_once(APPPATH.'core/my_controller.php');
$obj=new my_controller();
$CI =& get_instance();

$entries = "";
if($this->input->get('entries')!=""){
  $entries = $this->input->get('entries');
}

?>
<div class="main-content">


<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">TOOLS CURRENT STOCK </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>


<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
	<a href="<?=base_url();?>report/Report/excel_spare_machine_mapping_report?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'].'&filter='.'filter'?>" class="btn btn-sm" >Excel</a></div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>stocks/current_stock/manage_tools_current_stock?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
		<th>Tools Name</th>
		<th>Location</th>
		<th>Rack</th>
		<th>Quantity On Hand</th>
		<th>Minimum Quantity</th>
        
		
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

$main_locQuery = $this->db->query("select * from tbl_master_data where serial_number='".$fetch->loc."'");
$getmain_loc = $main_locQuery->row();


$main_rackQuery = $this->db->query("select * from tbl_location_rack where id='".$fetch->rack_id."'");
$getmain_rack = $main_rackQuery->row();

?>
<th><?php echo $getlocate->productname; ?></th>

<th><?php 

echo $getmain_loc->keyvalue;

?></th>



<th><?php 

echo $getmain_rack->rack_name;
?></th>


<th><?php 
echo $fetch->quantity;
?></th>





<th><?php 

echo $getlocate->min_re_order_level;

?></th>

</tr>
<?php  }  ?>
</tbody>
</table>


</div>

<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> 
		<!-- <h6>Showing 1 to 10 of <?php echo $totalrow; ?> entries</h6> -->
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
