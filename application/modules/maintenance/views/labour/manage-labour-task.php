<?php
$this->load->view("header.php");

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


<div class="main-content">

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">LABOUR TASK</h4>
<div class="pull-right">
<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#LabouTaskModal" title="Add Labour Task" >Add Labour Task</button>
</div>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>


<div class="modal fade" id="LabouTaskModal" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Labour Task</h4>
<div id="resultarealabour" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
    <div class="modal-body overflow">
    <form class="form-horizontal" role="form" id="SectionLabourTask" method="post">
        <table class="table table-striped table-bordered table-hover">
          <tr class="gradeA">
            <h4><center>*Section
            <select name="section" required class="select2 form-control" id="section">
            <option value="0" class="listClass">-----Section-----</option>
            <?php
            foreach ($categorySelectbox as $key => $dt) { ?>
            <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
            <?php } ?>
            </select>
          </center></h4>

          </tr>         
          <tr>
            <th>*Task Name</th>
            <th>
            <select name="task_name" id="task_name" class="form-control">
              <option value="">---select---</option>
              <?php 
                $abx=$this->db->query("select * from tbl_master_data where param_id=33");
                foreach ($abx->result() as $key) { ?>
                <option value="<?=$key->serial_number;?>"><?=$key->keyvalue;?></option> 
                <?php } ?>
              
              
            </select>
            </th>
            <th>Task Type</th>
            <th>
            <select name="task_type" id="task_type" class="form-control">
              <option value="">--select--</option>  
              <?php 
                $sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
                foreach ($sqlunit->result() as $fetchunit){
              ?>
              <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                <?php } ?>
            </select>
            </th>           
          </tr>          
        <tr>
            <th>*Start Date</th>
            <th><input type="date" name="start_date" class="form-control"></th>
            <th>Date Completed</th>
            <th><input type="date" name="date_completed" class="form-control"></th>

          </tr>
          <tr>
            <th>Time Estimate(hours)</th>
            <th><input type="number" name="time_estimate" class="form-control"></th>      
            <th>Time Spent(hours)</th>
            <th><input type="number" name="time_spent" class="form-control"></th>
          </tr>
          <tr>
            <th>Cost Estimate</th>
            <th><input type="number" name="cost_estimate" class="form-control"></th>      
            <th>Cost Spent</th>
            <th><input type="number" name="cost_spent" class="form-control"></th>
          </tr>
          <tr>
            <th>*Task Description</th>
            <th><textarea name="des_name" class="form-control"></textarea></th>
            <th>Task Completion Notes</th>
            <th><textarea name="task_notes" class="form-control"></textarea></th>
          </tr>
          <tr>
            <th colspan="3">&nbsp;</th>
            <th>
              <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
              <input type="submit" class="btn btn-sm savebutton  pull-right" value="Save">
              
            </th>
          </tr>
      </table>
 </form>
</div>
</div><!-- /.modal-content -->
</div>
<!-- </div> -->

<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">&nbsp;
	<a style="display: none;" href="<?=base_url();?>report/Report/excel_spare_machine_mapping_report?" class="btn btn-sm" >Excel</a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>maintenance/labour/manage_labor_task?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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

<table class="table table-striped table-bordered table-hover dataTables-example1" id="listingData" >
<thead>
<tr>
<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
  
  <th>S. No.</th>
  <th>Section</th>
  <th>Task Name</th>
  <th>Start Date</th>
  <th>End Date</th>  
  <th>Time Estimate</th>
  <th>Time Spent</th>
  <th>Cost Estimate</th>
  <th>Cost Spent</th>
  <th>Action</th>
 </tr>
</thead>
<tbody id = "getDataTable"> 
                    
<?php  
$z=1;
$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">

<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>

<th><?php echo $z++; ?></th>
<th><?php 
  $sqlunit=$this->db->query("select * from tbl_category where id='$fetch_list->section'");
  $compRow = $sqlunit->row();
  echo $compRow->name;    ?>
</th>
<th><?php  
  $tname=$this->db->query("select * from tbl_master_data where serial_number='$fetch_list->task_type'");
  $getTname=$tname->row();
  echo $getTname->keyvalue; ?>
</th>
<th><?php echo $fetch_list->start_date; ?></th>
<th><?php echo $fetch_list->date_completed; ?></th>

<th><?php echo $fetch_list->time_estimate; ?></th>
<th><?php echo $fetch_list->time_spent; ?></th>

<th><?php echo $fetch_list->cost_estimate; ?></th>
<th><?php echo $fetch_list->cost_spent; ?></th>

<th><?php
$pri_col='id';
$table_name='tbl_workorder_labor_task';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button></th>
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


<script type="text/javascript">
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