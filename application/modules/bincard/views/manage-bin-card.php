<?php
$this->load->view("header.php");
$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>
<div class="main-content">
<div class="panel-default">
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a href="#">Bin Card</a></li> 
	
	<li class="active"><strong><a href="#">Manage Bin Card</a></strong></li> 
	<div class="pull-right">
	<li><a class="btn btn-sm" href="<?=base_url();?>bincard/binCard/add_bin_card" title="Add BinCard">Add Bin Card</a></li> 
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
	<select name="DataTables_Table_0_length" url="<?=base_url();?>bincard/binCard/manage_bin_card?<?='code='.$_GET['code'].'&bin_card_type='.$_GET['bin_card_type'].'&machine_id='.$_GET['machine_id'].'&vendor_id='.$_GET['vendor_id'].'&rdate='.$_GET['rdate'].'&grn_no='.$_GET['grn_no'].'&grn_date='.$_GET['grn_date'].'&remarks='.$_GET['remarks'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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

<div class="table-responsive" style="overflow-x:auto;">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>
		<th>Bin Card Id</th>
        <th>Bin Card Type</th>
        <th>Vendor Name</th>
        <th>GRN No.</th>
        <th>GRN Date</th>
		<th>Action</th>
</tr>
</thead>

<tbody id="getDataTable">
<tr>

	<form method="get">
	<td><input name="code"  type="text"  class="search_box form-control input-sm" style="width:60px;"  value="" /></td>
	<td><input name="bin_card_type"  type="text"  class="search_box form-control input-sm" style="width:100px;" value="" /></td>
	<td><input name="vendor_id"  type="text"  class="search_box form-control input-sm" style="width:100px;" value="" /></td>
	<td><input name="grn_no"  type="text"  class="search_box form-control input-sm" style="width:100px;"  value="" /></td>
	<td><input name="grn_date"  type="date"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
	</form>
</tr>
</tbody>


<?php

$i=1;
foreach($result as $fetch){

?>

<tr class="gradeC record">
<th><?php echo $fetch->rflhdrid;  ?></th>
<th><?php echo $fetch->bin_card_type;  ?></th>
<th>
<?php 
$vendorQuery = $this -> db
           -> select('*')
           -> where('contact_id',$fetch->vendor_id)
           -> get('tbl_contact_m');
		   $getVendor=$vendorQuery->row();?>
<a href="<?base_url();?>edit_bin_card?id=<?=$fetch->rflhdrid?>" ><?php echo $getVendor->first_name;?> </a>
</th>
<th><?php echo $fetch->grn_no;  ?></th>
<th><?php echo $fetch->grn_date;  ?></th>
<th>
<!-- <button class="btn btn-default" type="button" data-toggle="modal" onClick="openpopup('<?=base_url();?>bincard/binCard/edit_bin_card',1400,600,'view',<?=$fetch->rflhdrid;?>)" data-backdrop='static' data-keyboard='false' title="View BinCard"> <i class="fa fa-eye"></i> </button> -->

<?php
$pri_col='rflhdrid';
$table_name='tbl_bin_card_hdr';

$stfCostLog=$this->db->query("select * from tbl_software_stock_log where log_id='".$fetch_list->rflhdrid."' AND log_type='Return' AND vendor_id='$' ");
$numCost=$stfCostLog->num_rows();

// $sftStkLog=$this->db->query("select * from tbl_work_order_maintain where machine_name='".$fetch_list->id."' ");
// $numStk=$sftStkLog->num_rows();

$countRows=$numCost;

if($countRows > 0 ) {  ?>
<button class="btn btn-default" type="button" title="Delete BinCard" onclick="return confirm('BinCard already map to return. You can not delete ?');"><i class="icon-trash"></i></button>
<?php } else { ?>
<button class="btn btn-default delbutton_bincard" id="<?php echo $fetch->rflhdrid."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete BinCard"><i class="icon-trash"></i></button>
<?php  } ?>
</th>

</tr>
<?php $i++; }  ?>

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
   filename = filename?filename+'.xls':'Manage BinCard<?php echo date('d-m-Y');?>.xls';
   
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
