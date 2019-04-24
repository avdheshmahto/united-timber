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
<h4 class="panel-title">MANAGE STOCK TRANSFER </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
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

	<th>Code</th>
	<th>Part & Supplies Name</th>   
	<th>Type</th>
	<th>Category</th>
	<th>Uses Unit</th>
	<th>Quantity In Stock</th>
		
</tr>
</thead>
<tbody id="getDataTable" >
<?php
$yy=1;
if(!empty($result)) {
foreach($result as $rows) {
?>
<tr class="gradeC record">

<th><?php echo $rows->sku_no; ?></th>
<th><a href="<?=base_url();?>stocks/stockTransfer/stock_transfer_map?id=<?=$rows->Product_id?>">
	<?php echo $rows->productname; ?></a></th>
<th>
<?php
	$proQ1=$this->db->query("select * from tbl_master_data where serial_number='$rows->type_of_spare'");
	$fProQ12=$proQ1->row();
	echo $fProQ12->keyvalue; 
?>
</th>	
<th><?php echo $rows->via_type; ?></th>
<th>
<?php
	$proQ1=$this->db->query("select * from tbl_master_data where serial_number='$rows->usageunit'");
	$fProQ12=$proQ1->row();
	echo $fProQ12->keyvalue; 
?>
</th>	
<th><?php echo round($rows->quantity,2); ?></th>
</tr>
<?php } } ?>
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

</script>
