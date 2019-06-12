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
<h4 class="panel-title">CURRENT STOCK REPORT </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<!-- <label class="col-sm-2 control-label">Code</label> 
<div class="col-sm-3"> 
<input name="code"  type="text"  class="search_box form-control input-sm" value="<?=$_GET['code']?>"  />
</div> -->
<label class="col-sm-2 control-label">Pats & Supplies Type</label> 
<div class="col-sm-3"> 
<select name="type"  class="select2 form-control" id="type"  >
<option value="">--select--</option>
<?php $getProductName=$this->db->query("select * from tbl_master_data where param_id='26'");
$ProductName=$getProductName->result();
foreach($ProductName as $p) { ?>
<option value="<?=$p->serial_number?>"  <?php if($_GET['type'] == $p->serial_number) { ?>selected <?php } ?> ><?=$p->keyvalue?></option>
<?php } ?>
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
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button>
&nbsp;&nbsp;
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>&nbsp; &nbsp; Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/searchStock?<?='code='.$_GET['code'].'&sp_name='.$_GET['sp_name'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>

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
<input type="text" id="searchTerm" name="filter" class="search_box form-control input-sm" onkeyup="doSearch()" placeholder="What you looking for?">
</label>
</div>
</div>

</div>
</div>


<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
<thead>
<tr>

	<th>S. No</th>
	<th>Part & Supplies Type</th>   		
</tr>
</thead>
<tbody id="getDataTable" >

<tr style="display: none;">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>	

<?php
$yy=1;
if(!empty($result)) {
foreach($result as $rows) {
?>
<tr class="gradeC record">

<th><?php echo $yy++; ?></th>
<th>
<a href="<?=base_url('report/Report/searchStock?id=');?><?php echo $rows->serial_number; ?>" target="blank">
	<?php echo $rows->keyvalue; ?></a></th>
</tr>
<?php } } ?>
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









<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'CURRENT STOCK REPORT(<?php echo date('d-m-Y');?>).xls';
   
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
  location.href="<?=base_url('/report/Report/currentStock');?>";
}
</script>