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
<h4 class="panel-title">PARTS & SUPPLIES ISSUE</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>


<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">&nbsp;
	<a style="display: none;" href="<?=base_url();?>report/Report/excel_spare_machine_mapping_report?<?='&m_name='.$_GET['m_name'].'&sp_name='.$_GET['sp_name'].'&filter='.'filter'?>" class="btn btn-sm" >Excel</a></div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>issue/SpareIssue/manage_spare_issue?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
</div>

	 
</div>
</div>

<div class="panel-body">
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
<thead>
<tr>
<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
  <th>Code </th>
  <th>Trigger</th>
  <th>Machine Name</th>
  <th>Work Order Status</th>
  <th>Priority</th>
  <th>Maintenance Type</th>
 
</tr>
</thead>
<tbody id = "getDataTable"> 
                    
<?php  

$i=1;
// $sqlord=$this->db->query("select * from tbl_work_order_maintain where status='A' Order by id desc");
// foreach($sqlord->result() as $fetch_list)
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">

<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>

<th>
  <?php

   if($fetch_list->trigger_code!=''){
    ?>
    <a href="<?=base_url();?>issue/SpareIssue/add_spare_sm_issue?id=<?php echo $fetch_list->id; ?>">
  <?php   echo "WO".$fetch_list->id."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SM".$fetch_list->schedule_id;  ?></a>

  <?php
  }else{
  ?>
  <a href="<?=base_url();?>issue/SpareIssue/add_spare_issue?id=<?php echo $fetch_list->id; ?>"><?php  echo "WO".$fetch_list->id;  ?></a>

  <?php } ?>

</th>

<th><?php

  if($fetch_list->trigger_code!=''){
    
    echo "TR".$fetch_list->trigger_code;
    
    }
    ?>
   </th>
    
<th>

<a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $fetch_list->machine_name; ?>" title="Machine Spare Details">
<?php 

  $sqlunit=$this->db->query("select * from tbl_machine where id='".$fetch_list->machine_name."'");
  $compRow = $sqlunit->row();
  echo $compRow->machine_name;
    ?>
</a></th>
<th>
<?php 
  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->wostatus."'");
  $compRow = $sqlunit->row();
  echo $compRow->keyvalue;
    ?>
</th>
<th>
<?php 
  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->priority."'");
  $compRow = $sqlunit->row();
  echo $compRow->keyvalue;
    ?>

</th>


<th>
<?php 
  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->maintyp."'");
  $compRow = $sqlunit->row();
  echo $compRow->keyvalue;
    ?>

</th>

</tr>

<?php $i++; } ?>
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
