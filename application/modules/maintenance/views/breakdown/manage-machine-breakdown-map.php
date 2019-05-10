<?php
$this->load->view("header.php");
$idd=$_GET['id'];
$scheQuery=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' and status='A'");
$getsched=$scheQuery->row();

$sqlunitmachine=$this->db->query("select * from tbl_machine where id='".$getsched->machine_name."'");
$compRowmachine = $sqlunitmachine->row();

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
<div class="panel-body panel panel-default">		
<div class="row">
<div class="col-lg-12">
<div class="panel-body">
<div class="row centered-form">
<div class="col-xs-12 col-sm-12">
<div class="panel panel-default">
<div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
<h3 class="panel-title" style="float: initial;">Work Order Details:-WO<?=$getsched->id;?>
<a href="<?=base_url('maintenance/machine_breakdown/manage_break');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>
<div class="panel-body">
<form role="form">
<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Machine Name</h4>

<input type="text" name="" value="<?=$compRowmachine->machine_name;?>" id="first_name" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Priority</h4>
<?php 
$queryType100=$this->db->query("select *from tbl_master_data where serial_number='$getsched->priority'");
$getType100=$queryType100->row();

?>
<input type="text" name="" class="form-control" value="<?=$getType100->keyvalue;?>" readonly >
</div>
</div>
</div>


<div class="row">

<div class="col-xs-6 col-sm-6 col-md-6">
<?php if($getsched->trigger_code !=''){ ?>
<h4>Trigger Code</h4>
<div class="form-group">

<input type="text" name="" value="<?="TR".$getsched->trigger_code;?>" class="form-control" readonly>

</div>
<?php } ?>
</div>

<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Maintenance Type</h4>
<?php 
$queryType=$this->db->query("select *from tbl_master_data where serial_number='$getsched->maintyp'");
$getType=$queryType->row();

?>
<input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Work Order Status</h4>
<?php 
$queryType=$this->db->query("select *from tbl_master_data where serial_number='$getsched->wostatus'");
$getType=$queryType->row();

?>
<input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>

</div>
</div>

<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Completed Date</h4>

<input type="text" name=""  value="<?=$getsched->date_time;?>" class="form-control" readonly>

</div>
</div>
</div>

</form>
</div>
</div>
</div>
</div>


<div class="tabs-container">
<ul class="nav nav-tabs">
<li class="active"><a href="#labour_task" data-toggle="tab">Labour Tasks</a></li>
<li><a href="#spare" data-toggle="tab">Parts & Supplies</a></li>
<!-- <li><a href="#tools" data-toggle="tab">Tools</a></li> -->
<!-- <li><a href="#meterreading" data-toggle="tab">Meter Readings</a></li> 
<li><a href="#misccosts" data-toggle="tab">Misc Costs</a></li>-->
<li><a href="#filesid" data-toggle="tab">Files</a></li>
<li><a href="#break_down" data-toggle="tab">Breakdown Hours</a></li>
<!-- <li class=""><a href="#work_order" data-toggle="tab">Work Order Log</a></li> -->
</ul>
<div class="tab-content">
<div class="tab-pane  active" id="labour_task">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadlabortasks">
<thead>
	<tr>
		<th>Task</th>
		<th>Start Date</th>
		<th>Hrs Estimate</th>
		<th>Hrs Spent</th>
		<th>Cost Estimate</th>
		<th>Cost Spent</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php

$i=1;

$laborqry=$this->db->query("select * from  tbl_workorder_labor_task where labor_type='A' and work_order_id='".$_GET['id']."'");

foreach($laborqry->result() as $fetch_list)
{
 
?>

    <tr class="gradeU record">	
	<?php 
	$task=$this->db->query("select * from tbl_master_data where serial_number='$fetch_list->task_name' ");
	$getTask=$task->row();
	?>
	<td><?=$getTask->keyvalue;?></td>
     <td><?=$fetch_list->start_date;?></td>
	 <td><?=$fetch_list->time_estimate;?></td>
     <td><?=$fetch_list->time_spent;?></td>		
     <td><?=$fetch_list->cost_estimate;?></td>
     <td><?=$fetch_list->cost_spent;?></td>
     <td><?php $pri_col='id';
          $table_name='tbl_workorder_labor_task';
		?>
		<?php if($view!=''){ ?>
				
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
		<?php }?>
	</td>
    </tr>

<?php } ?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#labortasksid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Labor Tasks"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>

<div class="tab-pane" id="spare">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadspareparts" >
<thead>
<tr>
<th>Order No.</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php 

$i=1;

$sparemapName=$this->db->query("select * from tbl_workorder_spare_hdr where type='Parts' and work_order_id='".$_GET['id']."'");

foreach($sparemapName->result() as $fetch_map_spare)
{

?>

<tr class="gradeU record">
   
   <td>
   <a  class="modalMapSpare" href='#viewspareorder' onclick="viewspareorder('<?php echo  $fetch_map_spare->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts & Supplies Order">
   <?=sprintf('%03d',$fetch_map_spare->spare_hdr_id); ?></a></td>
	     
	<td><?=$fetch_map_spare->maker_date; ?></td>
	<td><?=$fetch_map_spare->work_order_status; ?></td>
	<td> 

	<a  class="modalMapSpare" href='#viewspareorder' onclick="viewspareorder('<?php echo  $fetch_map_spare->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts & Supplies Order"> <i class="fa fa-eye"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;

	<?php $pri_col='spare_hdr_id';
	$table_name='tbl_workorder_spare_hdr';
	?>
	<?php if($view!=''){ ?>

	<button class="btn btn-default delbutton" id="<?php echo $fetch_map_spare->spare_hdr_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
	<?php }?>

	</td>
   
</tr>

<?php }?>
<tr class="gradeU">
<td>
<button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#spareid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' data-refresh="true" title="Add Spare" onclick="refreshData();"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</tbody>

</table>
</div>

</div>
</div>
<div class="tab-pane" id="tools">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadtools" >
<thead>
<tr>
<th>Order No.</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php 

$i=1;

$toolName=$this->db->query("select * from tbl_workorder_spare_hdr where type='Tools' and work_order_id='".$_GET['id']."'");

foreach($toolName->result() as $fetch_map_tool)
{

?>

    <tr class="gradeU record">
       
	   <td>
	   <a  class="modalMapSpare" href='#viewtoolsorder' onclick="viewtoolsorder('<?php echo  $fetch_map_tool->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Tools Order">
	   <?=sprintf('%03d',$fetch_map_tool->spare_hdr_id); ?></a></td>
		     
		<td><?=$fetch_map_tool->maker_date; ?></td>
		<td><?=$fetch_map_tool->work_order_status; ?></td>
		<td><a  class="modalMapSpare" href='#viewtoolsorder' onclick="viewtoolsorder('<?php echo $fetch_map_tool->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Tools Order"><i class="fa fa-eye"></i></a></td>
       
    </tr>
<?php }?>

<tr class="gradeU">
<td>
<button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#toolsid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Tools"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</tbody>

</table>
</div>

</div>
</div>

<!-- ======================================Breakdown Hours====================================== -->
<div class="tab-pane" id="break_down">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadHours" >
<thead>
<tr>
<th>Breakdown Start Time</th>
<th>Breakdown End Time</th>
<th>Breakdown Total Hours</th>
<!-- <th>Action</th> -->
</tr>
</thead>

<tbody>
<?php 

$i=1;

$miscName=$this->db->query("select * from tbl_machine_breakdown where workorder_id='".$_GET['id']."' and status='A'");
  foreach($miscName->result() as $fetch_hours)
  {
   
?>

<tr class="gradeU record">

	<td><?=$fetch_hours->start_time; ?></td>
	<td><?=$fetch_hours->end_time; ?></td>
    <td><?php     
	$day2 = strtotime( $fetch_hours->end_time );
	$day1 = strtotime( $fetch_hours->start_time );
	$diff = round(($day2 - $day1) / 3600);
	echo $diff." Hours"; ?>    	
    </td>
    <!-- <td>
    	<?php $pri_col='id';
		$table_name='tbl_machine_breakdown';
		?>
		<?php if($view!=''){ ?>

		<button class="btn btn-default delbutton" id="<?php echo $fetch_hours->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
		<?php }?>
    </td> -->	

</tr>

<?php } ?>
<tr class="gradeU">
<td>
<button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#breakDownId'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Breakdown Hours"><img src="<?=base_url();?>assets/images/plus.png" /></button>  
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</tbody>

</table>
</div>

</div>
</div>

<!-- ================================Start files================================== -->
<div class="tab-pane" id="filesid">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadfileupload" >
<thead>
<tr>
<th>S.No.</th>
<th>File Name</th>
<th>Description</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php
$i=1;
$supplieraName=$this->db->query("select * from tbl_machine_files_uploads where module_type ='Breakdown' AND file_log_id='".$_GET['id']."' and status = 'A' ");
foreach($supplieraName->result() as $fetch_list)
{
?>

<tr class="gradeU record">
<td><?=$i;?></td>
<td><a href="<?=base_url('filesimages/breakdown_files');?>/<?=$fetch_list->file_name;?>" target="blank"><?=$fetch_list->file_name;?></a></td>
<td><?=$fetch_list->desc_id;?></td>		 
<td><?php $pri_col='id';
$table_name='tbl_machine_files_uploads';
?>
<?php if($view!=''){ ?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
<?php }?>
</td>
</tr>

<?php $i++; }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#addfiles'   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Files"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!-- =======================================Log====================================== -->
<div class="tab-pane" id="work_order">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
<th>S.No.</th>
<th>Date</th>
<th>Completion Notes</th>
</tr>
</thead>
<?php
 $triggerlog=$this->db->query("select * from tbl_schedule_triggering_log where schedule_id = '$getsched->id' and status = 'A' GROUP BY id ");
  foreach($triggerlog->result() as $fetch_map_triggerlog)
  {
?>
<tbody>
<tr class="gradeA">
<td><?=$fetch_map_triggerlog->trigger_code;?></td>
<td><?=$fetch_map_triggerlog->next_trigger_reading;?></td>
<td><?=$fetch_map_triggerlog->author_date;?></td>
</tr>

</tbody>
<?php }?>

</table>
</div>
</div>
</div>
<!-- ======================================= Add Labor Tasks =============================== -->
<div id="labortasksid" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" style="padding: 10px;">Add Labor Tasks</h4>
			<div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div> 
			<form id="formlabortaskid" method="post">
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<input type="hidden" name="brekdown_id" value="<?php echo $_GET['id'];?>">
					<!-- <input type="hidden" name="labor_type" value="A"> -->
					<tr class="gradeA">
						<th>*Task Name</th>
						<th>
						<select name="task_name" id="task_name" class="form-control" required="">
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
						<th>*Description</th>
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
			  </tbody>
		  </table>
		  </form>
		</div>
	</div>	 
</div>
</div>

<!-- ======================================= Add Spare =============================== -->
<div id="spareid" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add Parts And Supplies</h4>
			<div id="resultareaspare" class="text-center " style="font-size: 15px;color: red;"></div> 
					<form class="form-horizontal"  role="form" id="formspareid" method="post">
							<table class="table table-striped table-bordered table-hover">
							<input type="hidden" name="spare_work_order_id" value="<?php echo $_GET['id'];?>">
								
								<tr class="gradeA">
									<th>*Parts And Supplies Name</th>
									<th>
										<select name="spare_name" id="spare_nameid"  class="select2 form-control" onchange="via_type_func(this.value)" >
										<option value="">---select---</option>
										<?php 
											$sqlunit=$this->db->query("select * from tbl_product_stock where via_type='Spare' and status='A'");
											foreach ($sqlunit->result() as $fetchunit){
										?>
										<option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
											<?php } ?>
									</select>
									<input type="hidden" id="product_type" name="product_type">
									</th>
								
									<th>*Quantity</th>
									<th>
									<input type="number" name="qtyname" id="qtyid" class="form-control" >
									</th>
									<th style="width: 150px;"><button  class="btn btn-default" id="plusIcon" type="button" onclick="addrows();"><img src="<?=base_url();?>assets/images/plus.png" />
									</button>
									</th>
									
								</tr>
								<tr class="gradeA">
									<th colspan="5">&nbsp;</th>
								</tr>
						    <tbody>
								<tr class="gradeA">
									<th>Parts And Supplies Name</th>
									<th>Quantity</th>
									<th>Action</th>
									<th colspan="2">&nbsp;</th>
								</tr>

							</tbody>
							<tbody id="dataTable">
								<input type="hidden" id="countRow" value="">
							</tbody>
							<tr>
								<th colspan="4">&nbsp;</th>
								<th>
									<input type="button" id="saveSpare" class="btn btn-sm savebutton" value="Save" onclick="checkrows();">
									<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
								</th>									
							</tr>
					  </table>
			 </form>

		</div>
	</div>	 
</div>
</div>


<!-- ======================================= Add Tools =============================== -->
<div id="toolsid" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add Tools</h4>
			<div id="resultareatools" class="text-center " style="font-size: 15px;color: red;"></div> 
			<form id="formtoolsid" method="post">
				<table class="table table-striped table-bordered table-hover">
							<input type="hidden" name="tools_work_order_id" value="<?php echo $_GET['id'];?>">
								
								<tr class="gradeA">
									<th>*Tool Name</th>
									<th>
										<select name="spare_name" id="tool_nameid"  class="select2 form-control" onchange="via_type_func_tools(this.value)">
										<option value="">---select---</option>
										<?php 
											$sqlunit=$this->db->query("select * from tbl_product_stock where via_type='Tools' and status='A'");
											foreach ($sqlunit->result() as $fetchunit){
										?>
										<option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
											<?php } ?>
										</select>
										<input type="hidden" name="product_type_tools" id="product_type_tools">
								    </th>
								
									<th>*Quantity</th>
									<th><input type="number" name="qtyname" id="tool_qtyid" class="form-control"></th>
									<th style="width: 150px;"><button  class="btn btn-default"  type="button" onclick="addtoolrows()"><img src="<?=base_url();?>assets/images/plus.png" />
									</button>
									</th>
									
								</tr>
								<tr class="gradeA">
									<th colspan="5">&nbsp;</th>
								</tr>
						  <tbody>
								<tr class="gradeA">
									<th>Tools Name</th>
									<th>Quantity</th>
									<th>Action</th>
									<th colspan="2">&nbsp;</th>
								</tr>

							</tbody>
							<tbody id="tooldataTable">
							</tbody>
							<tr>
									<th colspan="4">&nbsp;</th>
									<th>
										<input type="submit" name="" class="btn btn-sm savebutton" value="Save">
										<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
									</th>
									
								</tr>
					  </table>
		  </form>
		</div>
	</div>	 
</div>
</div>

<!-- ======================================= Add Meter Reading =============================== -->
<div id="meterreadingid" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add Meter Reading</h4>
			<div id="resultareameterreading" class="text-center " style="font-size: 15px;color: red;"></div> 
			<form id="formMeterReadingid" method="post">
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<input type="hidden" name="work_order_id" value="<?php echo $_GET['id'];?>">
					<tr class="gradeA">
						<th>Machine Name</th>
						<th>
						<?php	
						$wrorQuery=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' and status = 'A'");
						$getwror=$wrorQuery->row();

						$sqlmachine=$this->db->query("select * from tbl_machine where id='".$getwror->machine_name."'");
						$machinedata = $sqlmachine->row();

						echo $machinedata->machine_name;
   						?>
						</th>
						
						<th>*Meter Reading</th>
						<th><input type="text" name="meter_reading" class="form-control"></th>
					</tr>
					<tr>
						<th>Meter Reading Units</th>
						<th>
							<select name="meter_unite" class="form-control">
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
						<th colspan="3">&nbsp;</th>
						<th>
							<input type="submit" class="btn btn-sm savebutton" value="Save">
							<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
						</th>
					</tr>
			  </tbody>
		  </table>
		  </form>
		</div>
	</div>	 
</div>
</div>

<!-- ======================================= Add Misc Costs =============================== -->
<div id="misccostid" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add Misc Costs</h4>
			<div id="resultareamisc" class="text-center " style="font-size: 15px;color: red;"></div> 
			<form id="formMiscCostid" method="post">
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<input type="hidden" name="work_order_id" value="<?php echo $_GET['id'];?>">
					<tr class="gradeA">
						<th>Type</th>
						<th><input type="text" name="type_name" class="form-control"></th>
						<th>Description</th>
						<th><textarea name="desc_name" class="form-control"></textarea></th>
						<th colspan="2">&nbsp;</th>						
					</tr>
					<tr class="gradeA">
						<th>Est Quantity</th>
						<th><input type="number" name="est_qty" id="est_qtyid" onkeyup="totalestcosts()" class="form-control"></th>
						<th>Est Unit Cost</th>
						<th><input type="number" name="est_unit_cost"  id="est_unit_costid" onkeyup="totalestcosts()" class="form-control"></th>
						<th>Est Total Cost</th>
						<th><input type="number" name="est_total_cost" id="est_total_costid" class="form-control" readonly="true"></th>
					</tr>
					<tr class="gradeA">
						<th>Actual Quantity</th>
						<th><input type="number" name="act_qty" id="act_qtyid" onkeyup="totalactqty()" class="form-control"></th>
						<th>Actual Unit Cost</th>
						<th><input type="number" name="act_unit_cost" id="act_unit_costid" onkeyup="totalactqty()" class="form-control"></th>
						<th>Actual Total Cost</th>
						<th><input type="number" readonly="true" name="act_total_cost" id="act_total_costid" class="form-control"></th>	
					</tr>
					
					<tr>
						<th colspan="3">&nbsp;</th>
						<th>
							<input type="submit" class="btn btn-sm savebutton" value="Save">
							<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
						</th>
						<th colspan="2">&nbsp;</th>
					</tr>
			  </tbody>
		  </table>
		  <script type="text/javascript">
			function totalestcosts(){
				var est_qtyid=document.getElementById("est_qtyid").value;
				var est_unit_costid=document.getElementById("est_unit_costid").value;
				var sumtotalestcost=Number(est_qtyid)*Number(est_unit_costid);
				document.getElementById("est_total_costid").value=sumtotalestcost;
			}

			function totalactqty(){
				var act_qtyid=document.getElementById("act_qtyid").value;
				var act_unit_cost=document.getElementById("act_unit_costid").value;
				var sumtotalactcost=Number(act_qtyid)*Number(act_unit_cost);
				document.getElementById("act_total_costid").value=sumtotalactcost;
			}

		</script>
		  </form>
		</div>
	</div>	 
</div>
</div>

<!-- =========================================Breakdown Hours====================================== -->

<div id="breakDownId" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add Breakdown Time</h4>
			<div id="resultareahours" class="text-center " style="font-size: 15px;color: red;"></div> 
			<form id="formBreakDown" method="post">
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<input type="hidden" name="work_order_id_hours" value="<?php echo $_GET['id'];?>">
					<tr class="gradeA">
						<th>Breakdown Machine</th>
						<th>

							<input type="hidden" name="code" id="code" value="<?=$getsched->code; ?>">	
							<input type="text" value="<?=$compRowmachine->machine_name;?>" class="form-control" readonly="">
						</th>
						<th>Breakdown Start Time</th>
						<th>
							<input type="text" value="" name="breakdown_start_time" id="datetimepicker_mask1" class="form-control" style="width:100%;" required="" />
						</th>
						<th>Breakdown End Time</th>
						<th>
							<input type="text" name="breakdown_end_time" id="datetimepicker_mask3" class="form-control" style="width:100%;" required="" />
						</th>						
					</tr>					
					<tr>
						<th colspan="5">&nbsp;</th>
						<th>
							<input type="button" class="btn btn-sm savebutton" id="saveHours" onclick="hoursfunc();" value="Save">
							<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
						</th>
					</tr>
			  </tbody>
		  </table>
		  </form>
		</div>
	</div>	 
</div>
</div>


<!-- ================================Add Files Uploads ================================== -->

<div id="addfiles" class="modal fade modal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-contentMap" id="modal-contentMapunit">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">UPLOADS FILE</h4>
<div id="resultareafileupload" class="text-center " style="font-size: 15px;color: red;"></div> 
<table class="table table-striped table-bordered table-hover" >
<tbody>
<form class="form-horizontal" role="form"  enctype="multipart/form-data"   id ="formfileuploads" action="#" onsubmit="return submitworkorderfilesupload();" method="POST">

<tr class="gradeA"><th colspan="3">&nbsp;</th></tr>
<tr class="gradeA">
<input type="hidden" name="breakdown_id" value="<?php echo $_GET['id']; ?>">
<th><input type="file" name="image_name"></th>
<th>Description</th>
<th><textarea class="form-control" name="desc_id"></textarea></th>
</tr>
<tr class="gradeA">

<th>
&nbsp;
</th>
<th>
<input type="submit" style="width:70px;" value="Save" class="form-control"> 
</th>
<th>&nbsp;</th>
</tr>
</form>
</tbody>
</table>
</div>
</div>	 
</div>
</div>
<!-- =================================== Start View Scheduling =============================== -->
<form class="form-horizontal" role="form"  enctype="multipart/form-data">			
<div id="viewspareorder" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-spare-order" id="modal-spare-order">

        </div>
    </div>	 
</div>
</form>

<form class="form-horizontal" role="form"  enctype="multipart/form-data">			
<div id="viewtoolsorder" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-tool-order" id="modal-tool-order">

        </div>
    </div>	 
</div>
</form>
<!-- =================================== Close View Scheduling =============================== -->

<script type="text/javascript">

function viewspareorder(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "vieworderspares?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-spare-order").innerHTML = xhttp.responseText;
 } 	

 function viewtoolsorder(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "viewordertools?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-tool-order").innerHTML = xhttp.responseText;
 } 	

</script>
<!-- ==================================================================================== -->

</div>
</div><!--tabs-container close-->
</div>
</div>
</div>
</div>
</div><!--main-content close-->
<?php
$this->load->view("footer.php");
?>

<script type="text/javascript">
function submitworkorderfilesupload() 
{
        
	var form_data = new FormData(document.getElementById("formfileuploads"));
	form_data.append("label", "WEBUPLOAD");

	$.ajax({
		      url: "insert_breakdown_files",
		      type: "POST",
		      data: form_data,
		      processData: false,  // tell jQuery not to process the data
		      contentType: false   // tell jQuery not to set contentType
		  }).done(function( data ) {
	
	$("#addfiles .close").click();
	$('#formfileuploads')[0].reset(); 	
  	ajex_RawMatData(<?=$_GET['id'];?>);	 
    //console.log(data);
    //Perform ANy action after successfuly post data       
  });
  return false;     
}
// ends

function ajex_RawMatData(production_id)
{
	//alert(production_id);
 	ur = "get_breakdown_files";
    $.ajax({
			url: ur,
			data: { 'id' : production_id },
			type: "POST",
			
			success: function(data)
			{
				// alert(data);
				//alert("jkhkjh"+type);
				//$("#listingData").hide();
				$("#loadfileupload").empty().append(data).fadeIn();
		    }
		   });

}

function via_type_func(v)
 {
 	//alert(v);
 	ur="<?=base_url();?>maintenance/schedule/check_product_type";
 	$.ajax({
 		url  : ur,
 		type : "POST",
 		data : {'pid':v},
 		success:function(data)
 		{
 			//alert(data);
 			if(data !='')
 			{
 				$("#product_type").val(data);
 			}
 		}
 		
 		})
 }


 function via_type_func_tools(v)
 {
 	//alert(v);
 	ur="<?=base_url();?>maintenance/schedule/check_product_type";
 	$.ajax({
 		url  : ur,
 		type : "POST",
 		data : {'pid':v},
 		success:function(data)
 		{
 			//alert(data);
 			if(data !='')
 			{
 				$("#product_type_tools").val(data);
 			}
 		}
 		
 		})
 }


 function hoursfunc() 
 {

    //your code here
   	var fromDate = $("#datetimepicker_mask1").val();
	var toDate 	 = $("#datetimepicker_mask3").val();

	//alert(toDate);

	if(toDate < fromDate)
	{
		alert("End Date Can't Be Smaller Than Start Date !");
		$("#saveHours").attr('disabled',true);
		$('#saveHours').attr('type', 'button');
	}
	else
	{
		$("#saveHours").removeAttr('disabled',false);
		$('#saveHours').attr('type', 'submit');	
	}

}




function checkrows()
{

	var count=$("#countRow").val();
	if(count > 0)
	{
		//v.type=submit;
		$('#saveSpare').attr('type', 'submit');
	}
	else
	{
		//v.type=button;
		$('#saveSpare').attr('type', 'button');
		alert("Nothing To Save ! Please Add Row !");
	}

}


function refreshData()
{

	$("#dataTable").empty();
	$("#countRow").val('');
	
}

</script>