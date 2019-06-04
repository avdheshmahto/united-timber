<?php
$this->load->view("header.php");
$entries = "";
if($this->input->get('entries')!=""){
  $entries = $this->input->get('entries');
}
?>
<div class="main-content">
<div class="panel-default">

<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a href="#">Parts & Supplies Return</a></li> 
	
	<li class="active"><strong><a href="#">Manage Parts & Supplies Return</a></strong></li> 
	<div class="pull-right">
	<li><a class="btn btn-sm" href="<?=base_url();?>return/spareReturn/add_spare_return" title="Add Spare Return">Add Parts & Supplies Return</a></li> 
	</div>
</ol>
		
<div class="row">
<div class="col-sm-12" id="listingData">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">

<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
	<label>Show
	<select name="DataTables_Table_0_length" url="<?=base_url();?>return/spareReturn/manage_spare_return?<?='rflhdrid='.$_GET['rflhdrid'].'&return_date='.$_GET['return_date'].'&vendor_id='.$_GET['vendor_id'].'&po_no='.$_GET['po_no'].'&po_date='.$_GET['po_date'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
		<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
		<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
		<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
		<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
		<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
		<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>
		
	</select>
	entries</label>
	<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="    margin-top: -5px;margin-left: 12px;float: right;">Showing <?=$dataConfig['page']+1;?> to 
	<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
	?> of <?=$dataConfig['total'];?> entries
	</div>
	</div>
	
	<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm" name="filter"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
</label>
</div>
</div>

<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadData">

<thead>
<tr>
		<th>Return Id</th>
        <th>Return Date</th>
        <th>Vendor Name</th>
        <th>P.O. No.</th>
        <th>P.O. date</th>        
		<th>Action</th>
</tr>
</thead>

<tbody id="getDataTable">
<tr>

	<form method="get">
	<td><input name="rflhdrid"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="return_date"  type="date"  class="search_box form-control input-sm"  value=""/></td>
	<td><input name="vendor_id"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="po_no"  type="text"  class="search_box form-control input-sm"   value="" /></td>
	<td><input name="po_date"  type="date"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search">
		<span>Search</span></button></td>
</form>
</tr>


<?php

$query=("select * from tbl_spare_return_hdr where status='A' ");
$seQu=$this->db->query($query);

$i=1;
foreach($result as $fetch){

?>

<tr class="gradeC record">
<th><?php echo $fetch->rflhdrid;  ?></th>
<th><?php echo $fetch->return_date;  ?></th>
<th><?php 

$machineQuery = $this -> db
           -> select('*')
           -> where('contact_id',$fetch->vendor_id)
           -> get('tbl_contact_m');
		   $getMachine=$machineQuery->row(); ?>

<a href="<?=base_url()?>return/spareReturn/edit_spare_return?id=<?=$fetch->rflhdrid?>"><?php echo $getMachine->first_name; ?></th>
<th><?php echo $fetch->po_no;  ?></th>
<th><?php echo $fetch->po_date;  ?></th>

<th>
<?php
$pri_col='rflhdrid';
$table_name='tbl_spare_return_hdr'; ?>
<button class="btn btn-default delbutton_return" id="<?php echo $fetch->rflhdrid."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Spare Return"><i class="icon-trash"></i>
</button>
</th>

</tr>
<?php $i++; }  ?>
</tbody>
</table>
<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> 
		</div>
	<div class="col-md-6"> 
			<?php echo $pagination; ?>
	</div>


<script>
function stockdelfun()
{
	alert("Product Has Been Stocked In");
}
</script>
</div>
</div>
</form>
</div>
</div>
</div><!--panel-default close-->
</div><!--main-content close-->

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
   filename = filename?filename+'.xls':'Spare Return <?php echo date('d-m-Y');?>.xls';
   
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