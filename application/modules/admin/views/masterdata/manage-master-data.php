<?php
$this->load->view("header.php");
$this->load->view("javascriptPage.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>

<style type="text/css">

	.select2-container--open {
       z-index: 99999999 !important;
	 }
	 .select2-container {
       min-width: 256px !important;
     }

</style>

<!-- Main content -->
<div class="main-content">
<div class="panel-default">	
<form class="form-horizontal" method="post" action="update_master_data" role="form"  enctype="multipart/form-data">			
<div id="editItem" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-contentitem" id="modal-contentitem">

        </div>
    </div>	 
</div>
</form>
<form class="form-horizontal" method="post" action="<?=base_url();?>admin/masterdata/insert_master_data">	
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a href="#">Admin Setup</a></li> 
	<li><a href="#">Master Data</a></li>
	<li class="active"><strong><a href="#">Manage Master Data</a></strong></li> 
	<div class="pull-right">
<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modal-0"><i class="fa fa-plus" aria-hidden="true" title="Add MasterData"></i>Add Master Data</button>
<div id="modal-0" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Master Data</h4>
</div>
<div class="modal-body overflow">

<div class="form-group"> 
<label class="col-sm-2 control-label">*Key Name:</label> 
<div class="col-sm-4"> 				
		
<input type="hidden" name="serial_number" value="" />
<select name="param_id" class="select2 form-control" requried style="width:100%;">
<option value="">----Select----</option>
<?php 
$comp_sql = $this->db->query("select * FROM tbl_master_data_mst where status='A' AND param_id!='21'");

foreach ($comp_sql->result() as $comp_fetch){
?>
<option value="<?php echo @$comp_fetch->param_id;?>"><?php echo @$comp_fetch->keyname;?></option>
<?php } ?>
</select>
</div> 

<label class="col-sm-2 control-label">*Key Value</label> 
<div class="col-sm-4"> 
<input name="keyvalue"  type="text" value="" class="form-control" required > 
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">Description:</label> 
<div class="col-sm-4"> 
<textarea class="form-control" name="description" ></textarea>
</div>  
</div>

</div>
<div class="modal-footer">
<input type="submit" class="btn btn-sm" data-dismiss="modal1" value="Save">
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
</ol>
</form>

<div class="row">
<div class="col-lg-12">
<div class="panel-body">
<div class="table-responsive">

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons" style="display: none1;">
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
</div>
</div>	
<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>admin/masterdata/manage_master_data?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">

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
	<input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
	</label>
</div>
</div><!--row close-->
</div>
</div>
</div>
</div>

<form class="form-horizontal" method="post" action="<?=base_url();?>admin/masterdata/insert_master_data" >
<table class="table table-striped table-bordered table-hover dataTables-example11" id="loadData">
<thead>
<tr>
 		<th>Value Name</th>
		<th>Added value</th>
		<th>Description</th>
        <th style="width:120px;">Action</th>
</tr>
</thead>

<tbody id="getDataTable">
<tr style="display: none;">
	<th></th>
	<th></th>
	<th></th>
</tr>	
<?php
$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record" data-row-id="<?php echo $fetch_list->serial_number; ?>">
<?php 
 $compQuery = $this -> db
           -> select('*')
           -> where('param_id',$fetch_list->param_id)
           -> get('tbl_master_data_mst');
		  $compRow = $compQuery->row();
?>
		
<th><?=$compRow->keyname;?></th>
<th><?=$fetch_list->keyvalue;?></th>
<th><?=$fetch_list->description;?></th>
<th class="bs-example">
<?php if($view!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->serial_number;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->serial_number;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View MasterData"> <i class="fa fa-eye"></i> </button>

<?php } if($edit!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->serial_number;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->serial_number;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit MasterData"><i class="icon-pencil"></i></button>
<?php } ?>

<?php if($delete!=''){
$pri_col='serial_number';
$table_name='tbl_master_data';
?>
<button class="btn btn-default delbutton" id="<?=$fetch_list->serial_number."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete MasterData"><i class="icon-trash"></i></button>
<?php } ?>
</th>
</tr>
<?php $i++;} ?>
</tbody>
<input type="text" style="display:none;" id="table_name" value="tbl_master_data">  
<input type="text" style="display:none;" id="pri_col" value="serial_number">
</table>
</form>

<div class="row">
  <div class="col-md-12 text-right">
    <div class="col-md-6 text-left"> </div>
    <div class="col-md-6"> <?php echo $pagination; ?></div>
  </div>
</div>


</div><!--panel-default close-->
</div><!--main-content close-->

<script>

function target1(v)
{
	
				
}

function getEditItem(v,button_type)
{

 var pro=v;
 //alert(button_type);
 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "edit_master_data?ID="+pro+"&type="+button_type, false);
 xhttp.send();

 document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
 
} 	



</script>


<?php
$this->load->view("footer.php");
?>


<script type="text/javascript">
	function exportTableToExcel(tableID, filename = '')
{

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Master Data <?php echo date('d-m-Y');?>.xls';
   
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