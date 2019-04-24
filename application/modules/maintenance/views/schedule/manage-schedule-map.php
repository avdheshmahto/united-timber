<?php
$this->load->view("header.php");
$scheQuery=$this->db->query("select * from tbl_schedule_maintain where id='".$_GET['id']."' and status = 'A'");
$getsched=$scheQuery->row();

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
<h3 class="panel-title" style="float: initial;">Scheduled Maintenance Details:-<?="SM".$getsched->code;?>
	
	<a href="<?=base_url('maintenance/schedule/manage_schedule');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>
<div class="panel-body">
<form role="form">
<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Machine Name</h4>
<?php 
$queryType101=$this->db->query("select * from tbl_machine where id='$getsched->machine_name'");
$getType101=$queryType101->row();

?>
<input type="text" name="" value="<?=$getType101->machine_name;?>" id="first_name" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Facilities</h4>
<div class="form-group">
<?php 
$queryType=$this->db->query("select * from tbl_category where id='$getsched->m_type'");
$getType=$queryType->row();

?>
<input type="text" name="" value="<?=$getType->name;?>" class="form-control" readonly>

</div>
</div>
</div>


<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Priority</h4>
<?php 
$queryType100=$this->db->query("select * from tbl_master_data where serial_number='$getsched->priority'");
$getType100=$queryType100->row();

?>
<input type="text" name="" class="form-control" value="<?=$getType100->keyvalue;?>" readonly >
</div>
</div>

<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Maintenance Type</h4>
<?php 
$queryType=$this->db->query("select * from tbl_master_data where serial_number='$getsched->maintyp'");
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
$queryType=$this->db->query("select * from tbl_master_data where serial_number='$getsched->wostatus'");
$getType=$queryType->row();
?>
<input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>

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
<li class="active"><a href="#schedule" data-toggle="tab">Scheduling</a></li>
<li><a href="#spare" data-toggle="tab">Parts & Supplies Scheduling</a></li>
<!--<li><a href="#orderbyspare" data-toggle="tab">Order By Spare</a></li>
<li><a href="#labortask" data-toggle="tab">Labor Tasks</a></li>
<li><a href="#filesid" data-toggle="tab">Files</a></li> -->
<li class=""><a href="#work_order" data-toggle="tab">Work Order Log</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane  active" id="schedule">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadscheduling">
<thead>
	<tr>
		<th>Trigger Code</th>
		<th>Trigger Description</th>
		<th>Current Machine Reading</th>
		<th>Next Trigger Threshold</th>
		
	</tr>
</thead>
<tbody>
<?php

$i=1;
foreach($result as $fetch_list)
{
$unitName=$this->db->query("select * from  tbl_master_data where serial_number='$fetch_list->unit'");
$getunitD=$unitName->row();
?>

	<tr class="gradeU record">

	<td><?="TR".$fetch_list->trigger_code;?></td>
	<td>		
	<a  class="modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#viewscheduling' onclick="viewtrigger('<?php echo  $fetch_list->id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Triggers">Every&nbsp;&nbsp;<?=$fetch_list->every_reading;?>&nbsp;&nbsp;<?=$getunitD->keyvalue;?></a>
	</td>
	<?php 	
	$sqlQuery=$this->db->query("select * from tbl_machine_reading where machine_id='$fetch_list->machine_id'  and status = 'A' order by id desc limit 0,1");
	$getMachine=$sqlQuery->row();	
	?>

	<td><?=$getMachine->reading;?></td>

	<td>
	<a  class="modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#editscheduling' onclick="edittrigger('<?php echo  $fetch_list->id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Triggers">
	<?=$fetch_list->next_trigger_reading;?></a>
	</td>

</tr>
<?php  }?>
<tr class="gradeU">
<td>
<?php 
	
	$sqlSchedulingview=$this->db->query("select * from tbl_schedule_triggering where schedule_id ='".$_GET['id']."'  and status = 'A' order by id desc limit 0,1");

	$getScheduling=$sqlSchedulingview->row();
	$rws=$sqlSchedulingview->num_rows();

	$sqlMachineIdview=$this->db->query("select * from tbl_machine_reading where machine_id ='$getScheduling->machine_id'  and status = 'A' order by id desc limit 0,1");
	
	$getMachine=$sqlMachineIdview->row();	
/*
if($getScheduling->type=='End_By'){
	 $nexttriggerval=$getScheduling->endby_reading;
}else{
	 $nexttriggerval=$getScheduling->next_trigger_reading;
}*/

if($getScheduling->type=='End_By' || $rws==0) { ?>

<button  class="btn btn-default modalMapSpare" href='#addscheduling' onclick="addSchedulingTrigger('<?php echo  $_GET['id'];?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Schedule Trigger"><img src="<?=base_url();?>assets/images/plus.png" /></button> 

<?php } else { ?>
<button class="btn btn-default"title="Add Schedule Trigger"><a onclick="return confirm('No End Reading Set ! That is Why You Can Not Add More Scheduling');" ><img src="<?=base_url();?>assets/images/plus.png" /></button> 
<?php  }
//if($rws==0){ ?>
<!-- <button  class="btn btn-default modalMapSpare" href='#addscheduling' onclick="addSchedulingTrigger('<?php echo  $_GET['id'];?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Schedule Trigger"><img src="<?=base_url();?>assets/images/plus.png" /></button>  -->
<?php //} ?>
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
<div class="tab-pane" id="spare">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadsparescheduling">
<thead>
<tr>
<th>Trigger Code</th>
<!--<th>Parts And Supplies Name</th>
<th>Type</th>
<th>Quantity</th>-->
 <th>Action</th> 
</tr>
</thead>

<tbody>
<?php

$i=1;
$spareq=$this->db->query("select * from tbl_schedule_spare_hdr where schedule_id='".$_GET['id']."' and status = 'A'");
foreach($spareq->result() as $fetch_spares)
{

// $sparemaptrigName=$this->db->query("select * from tbl_schedule_triggering where id='$fetch_spares->trigger_code' and status = 'A'");
// $getSparetrigmap=$sparemaptrigName->row();

// $parts=$this->db->query("select * from tbl_schedule_spare_dtl where smsparetrigger_hdr_id='$fetch_spares->id' ");
// $getParts=$parts->row();

// $pname=$this->db->query("select * from tbl_product_stock where Product_id='$getParts->spare_id'");
// $getPname=$pname->row();
  
?>

    <tr class="gradeU record">
       
	    <td>
			<a  class="modalMapSpare" data-a="<?php echo $fetch_spares->id;?>" href='#viewsparescheduling' onclick="viewspareschedule('<?php echo  $fetch_spares->trigger_code;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Triggers"> <?="TR".$fetch_spares->trigger_code; ?></a>
	    </td>

	    <!-- <td><?=$getPname->productname;?></td>
	    <td><?=$getPname->via_type;?></td>
	    <td><?=$getParts->suggested_qty;?></td> -->
		     
       	<td><?php $pri_col='id';
                  $table_name='tbl_schedule_spare_triggering';
         ?>
        
		<!-- <button class="btn btn-default modalEditItem"  onclick="return open_a_window('<?php echo $getSparetrigmap->id; ?>');" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Spare Scheduling"><i class="icon-pencil"></i></button> -->
		<!-- <button class="btn btn-default" href='#editspareschedulingid' onclick="editSpareScheduling('<?php echo $fetch_spares->id; ?>')" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Spare Scheduling"><i class="icon-pencil"></i></button> -->

		<button class="btn btn-default delbutton__" id="<?php echo $fetch_spares->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Schedule Spare Map"><i class="icon-trash"></i></button> 
		</td> 

    </tr>
<?php } ?>
<tr class="gradeU">
<td>
 <a data-toggle="modal" data-target="#myModal" class="btn btn-default modalMapSpare"  id="popupAdd" title="Schedule Spare Map"><img src="<?=base_url();?>assets/images/plus.png" /> </a>
</td>
<td>&nbsp;</td>

</tr>
</tbody>
</table>
</div>
</div>
</div>
<script language="javascript">

function open_a_window(v) 
{
	//alert(v);
   window.open("editschedulingspare?id="+v); 

   return false;
}

</script>
<!-- ===================================================================== -->
<div class="tab-pane" id="orderbyspare">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadsparescheduling">
<thead>
<tr>
<th>Order No.</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
	 $spareq=$this->db->query("select * from tbl_schedule_spare_hdr where schedule_id='".$_GET['id']."' and status = 'A'");
  foreach($spareq->result() as $fetch_spares)
  {
     
?>

<tr class="gradeU record">

	<td>
	<a  class="modalMapSpare" data-a="<?php echo $fetch_spares->id;?>" href='#viewsparescheduling' onclick="vieworderspare('<?php echo  $fetch_spares->sm_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Spares"> <?=sprintf('%03d',$fetch_spares->sm_hdr_id); ?></a>
	</td>
	<td><?php echo $fetch_spares->maker_date; ?></td>
	<td><?php echo $fetch_spares->sm_status; ?></td>

</tr>
<?php } ?>

</tbody>
</table>
</div>
</div>
</div>
<!-- ===================================================================== -->

<div class="tab-pane" id="labortask">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadlabortaskschedule">
<thead>
	<tr>
		<th>Description</th>
		<th>Start Date</th>
		<th>Hrs Estimate</th>
		<th>Hrs Spent</th>
	</tr>
</thead>
<tbody>
<?php

$i=1;

  $laborqry=$this->db->query("select * from  tbl_workorder_labor_task where labor_type='SM' and work_order_id='".$_GET['id']."'");

  foreach($laborqry->result() as $fetch_list)
  {
 
?>

    <tr class="gradeU record">	
	 <td><?=$fetch_list->desc_name;?></td>
     <td><?=$fetch_list->start_date;?></td>
	 <td><?=$fetch_list->time_estimate;?></td>
     <td><?=$fetch_list->time_spent;?></td>		
    </tr>

<?php } ?>
<tr class="gradeU">
<td>
 
 <a  class="modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#addlabortaskschedulingid' onclick="addlabortaskschedule('<?php echo $_GET['id'];?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Labor Tasks"><img src="<?=base_url();?>assets/images/plus.png" /></a>
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
<!-- ========================================================================== -->

<!-- ================================Start files================================== -->
<div class="tab-pane" id="filesid">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadfiles" >
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
$supplieraName=$this->db->query("select * from tbl_machine_files_uploads where module_type ='Scheduled' AND file_log_id='".$_GET['id']."' and status = 'A' ");
foreach($supplieraName->result() as $fetch_list)
{

?>
<tr class="gradeU record">
<td><?=$fetch_list->id;?></td>
<td><?=$fetch_list->file_name;?></td>
<td><?=$fetch_list->desc_id;?></td>		 

<td><?php $pri_col='id';
$table_name='tbl_machine_files_uploads';
?>
<?php if($view!=''){ ?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
<?php }?>
</td>

</tr>

<?php }?>
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
<!-- ========================================================================================== -->
<div class="tab-pane" id="work_order">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
<th>Trigger Code</th>
<th>Updated Trigger Value</th>
<th>Date Of Created Work Order</th>
</tr>
</thead>
<?php
 $triggerlog=$this->db->query("select * from tbl_schedule_triggering_log where schedule_id = '$getsched->id' and status = 'A' ORDER BY next_trigger_reading DESC ");
  foreach($triggerlog->result() as $fetch_map_triggerlog)
  {
?>
<tbody>
<tr class="gradeA">
<td><?="TR".$fetch_map_triggerlog->trigger_code;?></td>
<td><?=$fetch_map_triggerlog->next_trigger_reading;?></td>
<td><?=$fetch_map_triggerlog->author_date;?></td>
</tr>
</tbody>
<?php } ?>
</table>
</div>
</div>
</div>
<!-- ======================================= Add Scheduling =============================== -->
<form class="form-horizontal" role="form" id="formschedulingid" method="post">			
<div id="addscheduling" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-add-scheduling-trigger" id="modal-add-scheduling-trigger">

        </div>
    </div>	 
</div>
</form>
<!-- =================================== Close Add Scheduling =============================== -->
<!-- =================================== Start View Scheduling =============================== -->
<form class="form-horizontal" role="form"  enctype="multipart/form-data">			
<div id="viewscheduling" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-scheduling-trigger" id="modal-scheduling-trigger">

        </div>
    </div>	 
</div>
</form>
<!-- =================================== Close View Scheduling =============================== -->
<!-- =================================== Start Edit Scheduling =============================== -->
<form class="form-horizontal" role="form" id="formeditschedulingid" method="post">			
<div id="editscheduling" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-edit-scheduling-trigger" id="modal-edit-scheduling-trigger">

        </div>
    </div>	 
</div>
</form>
<!-- =================================== Close Edit Scheduling =============================== -->

<!-- ============================== Start Add Spare Scheduling =============================== -->
<!-- <form class="form-horizontal" role="form" id="formaddspareschedulingid" method="post">			
<div id="addsparescheduling" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-add-spare-scheduling" id="modal-add-spare-scheduling">

        </div>
    </div>	 
</div>
</form> -->
<!-- ============================ Close Add Spare Scheduling =============================== -->
<!-- ============================== Start Edit Spare Scheduling ============================= -->
<form class="form-horizontal" role="form" id="formeditspareschedulingid" method="post">			
<div id="editspareschedulingid" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-edit-spare-scheduling" id="modal-edit-spare-scheduling">

        </div>
    </div>	 
</div>
</form>
<!-- ============================== Close Edit Spare Scheduling ============================= -->
<!-- ========================= Start Add Labor Tasks Scheduling ============================= -->
<form class="form-horizontal" role="form" id="formaddlabortaskschedulingid" method="post">		
<div id="addlabortaskschedulingid" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-add-labor-tasks-scheduling" id="modal-add-labor-tasks-scheduling">

        </div>
    </div>	 
</div>
</form>
<!-- ========================= Close Add Labor Tasks Scheduling ============================= -->

<?php //*********************************Spare Map Schedule Multiple ********************************* ?>


<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Parts & Supplies</h4>
<div id="resultareaaddspareschedule" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
		<div class="modal-body overflow">
		<form class="form-horizontal" role="form" id="formaddspareschedulingid" method="post">
				<table class="table table-striped table-bordered table-hover">
					<input type="hidden" id="scheduled_id" name="scheduled_id" value="<?php echo $_GET['id'];?>">
					<tr class="gradeA">
						<h4><center>*Trigger Code
						
							<select name="triggercode" id="trigger_codeid" onchange="SpareTrgCodefun(this.value,'<?=$_GET['id']?>');" class="select2 form-control">
							<option value="">---select---</option>
							<?php 
								$sqltr=$this->db->query("select * from tbl_schedule_triggering where schedule_id='".$_GET['id']."'");
								foreach ($sqltr->result() as $fetchtr){
							?>
							<option value="<?php echo $fetchtr->trigger_code;?>"><?php echo 'TR'.$fetchtr->trigger_code; ?></option>
								<?php } ?>
						</select></center></h4>
						<p id="existcodeid" class="text-center " style="font-size: 12px;color: red;"></p>
					</tr>	
					<tr class="gradeA">
						<th>*Parts & Supplies Name</th>
						<th>
							<select name="spare_name" id="spare_nameid" class="select2 form-control" onchange="via_type_func(this.value)">
							<option value="">---select---</option>
							<?php 
								$sqlunit=$this->db->query("select * from tbl_product_stock where via_type!='Tools' and status='A'");
								foreach ($sqlunit->result() as $fetchunit){
							?>
							<option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
								<?php } ?>
						</select></th>
						<p id="existid" class="text-center " style="font-size: 12px;color: red;"></p>
						<input type="hidden" id="product_type" name="product_type">
						<th>*Quantity</th>
						<th><input type="number" name="qtyname" id="qtyid" class="form-control"></th>
						<th style="width: 150px;"><button  class="btn btn-default"  type="button" onclick="addrows()"><img src="<?=base_url();?>assets/images/plus.png" />
						</button>
						</th>
						
					</tr>
					<tr class="gradeA">
						<th colspan="5">&nbsp;</th>
					</tr>
			  <tbody>
					<tr class="gradeA">
						<th>Parts & Supplies Name</th>
						<th>Quantity</th>
						<th>Action</th>
						<th colspan="2">&nbsp;</th>
					</tr>

				</tbody>
				<tbody id="dataTable">
				</tbody>
				<tr>
						<th colspan="4">&nbsp;</th>
						<th>
							<input type="submit" name="Psubmitform" class="btn btn-sm savebutton" value="Save">
							<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
						</th>
						
					</tr>
		  </table>
 </form>
</div>
</div><!-- /.modal-content -->
</div>
</div>
<!-- =========================== View Spare Scheduling ================================================== -->
<form class="form-horizontal" role="form"  enctype="multipart/form-data">			
<div id="viewsparescheduling" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-scheduling-spares" id="modal-scheduling-spares">

        </div>
    </div>	 
</div>
</form>
<!-- =========================== View Spare Scheduling ================================================== -->

<?php //************************************Spare Map Schedule Edit **************************?>
	<script>

			function endbyfun(){
			   var endval=document.getElementById("end_by_id").value;
			   if(endval=='End_By'){
			   		document.getElementById("end_by_reading_meter").style='';
			   }else{			   		
			   		document.getElementById("end_by_reading_meter").style='display:none';
			   }
			}

			function tasktype(){
			   var endval=document.getElementById("task_typeid").value;
			   if(endval=='meter_reading'){
			   		document.getElementById("unitid").style='';
			   }else{			   		
			   		document.getElementById("unitid").style='display:none';
			   }
			}

			function nexttrigger(){
				var everval=document.getElementById("every_id").value;
				var startatval=document.getElementById("start_at_id").value;
				//alert(startatval);
				var sumnexttrigger=Number(everval)+Number(startatval);
				document.getElementById("next_trigge_val_id").value=sumnexttrigger;
			}

			function nextvalvalidation(){
				var lasttriggerval=document.getElementById("last_trigger_reading").value;
				var startatval=document.getElementById("start_at_id").value;

				if(Number(startatval)>Number(lasttriggerval)){
					document.getElementById("submitid").style='';
				}else{
					alert("Enter More Than Last Trigger Value");
					document.getElementById("submitid").style='display:none';
				}
			}

			function samecodefun(trcode,shcode){
				  ur = "<?=base_url('maintenance/schedule/trigger_code_validation');?>";
				  //var abc=$("#scheduling_id").val();
				    $.ajax({
				      url: ur,
				      data: { 'tid' : trcode,'sid' : shcode },
				      type: "POST",
				      success: function(data){
				       //alert(data);
				        if(data==1){
				        	$("#existcodeid").empty().append("Trigger Code already exists").fadeIn();
				        	$('input[name="submitform"]').attr('disabled', 'disabled');
				        }else{
				        	$("#existcodeid").empty();
				        	$('input[name="submitform"]').removeAttr('disabled');
				        }              
				     }
				    });
			}


			function SpareTrgCodefun(trcode,shcode){
				  ur = "<?=base_url('maintenance/schedule/PartsTriggerCode');?>";
				    $.ajax({
				      url: ur,
				      data: { 'tid' : trcode, 'sid' : shcode },
				      type: "POST",
				      success: function(data){
				       //alert(data);
				        if(data==1){
				        	$("#existcodeid").empty().append("Trigger Code already exists").fadeIn();
				        	$('input[name="Psubmitform"]').attr('disabled', 'disabled');
				        }else{
				        	$("#existcodeid").empty();
				        	$('input[name="Psubmitform"]').removeAttr('disabled');
				        }              
				     }
				    });
			}
	</script>
<script type="text/javascript">

function sparevalidation(){

var scheduled_id=document.getElementById("escheduled_id").value;
var trigger_codeid=document.getElementById("etrigger_codeid").value;
var spare_nameid=document.getElementById("espare_nameid").value;

//alert(spare_nameid);
ur = "<?=base_url('maintenance/schedule/scheduling_spare_validation');?>";
	    $.ajax({
	      url: ur,
	      data: { 'scheduled_id' : scheduled_id, 'trigger_codeid' : trigger_codeid, 'spare_nameid' : spare_nameid },
	      type: "POST",
	      success: function(data){
	       //alert(data);
	        if(data==0){
	        	$("#existidspare").empty();
	        	$('input[name="submitformspare"]').attr('disabled', 'disabled');      	
	        }else{
	        	$("#existidspare").empty().append("Spare already exists").fadeIn();
	        	$('input[name="submitformspare"]').removeAttr('disabled');
	        }              
	     }
	    });

}	

</script>
<script type="text/javascript">

function addSchedulingTrigger(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();

  xhttp.open("GET", "addschedulingtrigger?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-add-scheduling-trigger").innerHTML = xhttp.responseText;
 } 	

function viewtrigger(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getschedulingtrigger?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-scheduling-trigger").innerHTML = xhttp.responseText;
 } 	

 function viewspareschedule(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getschedulingspare?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-scheduling-spares").innerHTML = xhttp.responseText;
 } 	

 function vieworderspare(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "vieworderspare?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-scheduling-spares").innerHTML = xhttp.responseText;
 } 	

function edittrigger(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "editschedulingtrigger?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-edit-scheduling-trigger").innerHTML = xhttp.responseText;
 } 	 

function addspareschedule(v){
//alert(v);
		 var id = $(this).attr('data-id');
		 alert(id);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "addspareschedulingparts?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-add-spare-scheduling").innerHTML = xhttp.responseText;
 } 	 

function editSpareScheduling(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "editspareschedulingparts?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-edit-spare-scheduling").innerHTML = xhttp.responseText;
 } 	 

function addlabortaskschedule(v){
//alert(v);
var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "addlabortasksscheduling?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-add-labor-tasks-scheduling").innerHTML = xhttp.responseText;
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


</script>
<!-- =================================== Close View Scheduling =============================== -->
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