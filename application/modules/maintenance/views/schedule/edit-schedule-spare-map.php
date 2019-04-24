<?php //************************************Edit Spare Map Schedule Multiple ************************* 

$abc=$this->db->query("select * from tbl_schedule_spare_triggering where id='$id'");
$getData=$abc->row();

$scheduleQuery=$this->db->query("select * from tbl_schedule_triggering where trigger_code='$getData->trigger_code'");
$getSchedule=$scheduleQuery->row();

//echo "select * from tbl_schedule_triggering where trigger_code='$getData->trigger_code'";
?>
<style type="text/css">

	.select2-container--open {
       z-index: 99999999 !important;
	 }
	 .select2-container {
       min-width: 256px !important;
     }

</style>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Edit Parts And Supplies</h4>
<div id="resultarea567" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
<div class="panel-body">
<table class="table table-striped table-bordered table-hover">
		<tbody>
		<input type="hidden" name="scheduling_id" value="<?php echo $getData->schedule_id;?>">
		<input type="hidden" name="machine_id" value="<?php echo $getData->machine_id; ?>">
		<input type="hidden" name="next_trigge_val_id" id="next_trigge_val_id" value="">
		<tr class="gradeA">
		<?php 

			$sqlQueryMachineId=$this->db->query("select * from tbl_machine_spare_unit_map where machine_id ='$getData->machine_id'  and status = 'A' order by id desc limit 0,1");
			
			$getMachineId=$sqlQueryMachineId->row();
		?>

			<th style="width: 84px;">*Trigger Code </th>
			<th>
			  <input type="number" name="trigger_code" id="etrigger_codeid" onchange="samecodefun(this.value)" placeholder = "0.0" readonly  value="<?php echo $getSchedule->trigger_code;?>"  class="form-control">
			  <p id="existcodeid" style="font-size: 10px;color: red;"></p>
			</th>
			<th>Machine Current Reading :- </th>
			<th>
			  <input type="text" name="machine_current_reading" placeholder = "0.0"  value="<?php echo $getSchedule->machine_current_reading; ?>" readonly class="form-control">
			</th>
			<?php 

			$sqlQueryscheduletr=$this->db->query("select * from tbl_schedule_triggering where machine_id ='$getsched->machine_name'  and status = 'A' order by id desc limit 0,1");
			
			$getScheduletr=$sqlQueryscheduletr->row();
		    
		    if($getSchedule->type=='End_By'){
		    ?>
			<th style="width: 168px;">Last End By Trigger Reading :-  </th>
			<th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getSchedule->endby_reading; ?>"  class="form-control" readonly ></th>	
			<?php }else{ ?>
			<th style="width: 128px;">Last Trigger Reading :- </th>
			<th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getSchedule->next_trigger_reading; ?>"  class="form-control" readonly ></th><?php } ?>
					
		</tr>
		<tr>
			<th>*Every</th>
			<th><input type="number" name="every_name" id="every_id" onkeyup="nexttrigger()" placeholder = "0.0"  value="<?php echo $getSchedule->every_reading; ?>" readonly  class="form-control"></th>
			<th>
			<select name="unit_meter" class="form-control" disabled="disabled" style="width: 190px;">
				<?php 
				$sqlunitt=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A' and serial_number='$getSchedule->unit'");
				foreach ($sqlunitt->result() as $fetchunitt){
				?>
				<option value="<?php echo $fetchunitt->serial_number;?>"><?php echo $fetchunitt->keyvalue; ?></option>
				<?php } ?>
			</select>
			</th>
			<th colspan="3">&nbsp;</th>
		</tr>
		<tr>
			<th>*Start At</th>
			<th><input type="number" readonly name="start_at" id="start_at_id" placeholder = "0.0"  value="<?php echo $getSchedule->starting_reading; ?>"  class="form-control"></th>
			<th>
			<select name="end_by" id="end_by_id" class="form-control" disabled="disabled">
				<option value="No_End_Reading">
				<?php if($getSchedule->type=='End_By'){ echo "End By"; }else{ echo "No End Reading"; } ?></option>
			</select>
			</th>
			<th>
			<?php 
			if($getSchedule->type=='End_By'){
			?>
			<input type="number" name="end_by_reading_meter" placeholder = "0.0"  id="end_by_reading_meter" value="<?php echo $getSchedule->endby_reading; ?>" readonly  class="form-control">
			<?php } ?>
			</th>
			<th colspan="2">&nbsp;</th>
		</tr>	
		<tr class="gradeA">
			<th colspan="6"><h3 class="panel-title" style="float: initial;"><center>Add New Parts & Supplies</center></h3></th>
		</tr>	
  </tbody>


  <tbody>
  		
  		<input type="hidden" id="escheduled_id" name="scheduled_id" value="<?php echo $getSchedule->schedule_id;?>">
		
		<tr class="gradeA">
			<th colspan="2">*Parts And Supplies Name</th>
			<th>
				<select name="spare_name" id="spare_nameid" onchange="sparevalidation();" class="select2 form-control">
				<option value="">---select---</option>
				<?php 
					$sqlunit=$this->db->query("select * from tbl_product_stock where via_type!='Tools' and status='A'");
					foreach ($sqlunit->result() as $fetchunit){
				?>
				<option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
					<?php } ?>
			</select>
			<p id="existidspare" class="text-center " style="font-size: 12px;color: red;"></p>
			</th>			
			<th>*Quantity</th>
			<th><input type="number" name="qtyname" id="qtyid" class="form-control"></th>
			<th><button  class="btn btn-default"  type="button" onclick="addrowsSpare();"><img src="<?=base_url();?>assets/images/plus.png" />
			</button>
			</th>
			
		</tr>
		<tr class="gradeA">
			<th colspan="6">&nbsp;</th>
		</tr>
		<tr class="gradeA">
			<th colspan="6"><h3 class="panel-title" style="float: initial;"><center>View Parts And Supplies</center></h3></th>
		</tr>
  </tbody>

   <tbody>
   							
		<tr class="gradeA">
			<th colspan="2">Parts And Supplies Name</th>
			<th>Quantity</th>					
			<th>Action</th>
			<th colspan="3">&nbsp;</th>
		</tr>
	</tbody>	
<?php
$i=1;
	// $smspareQuery=$this->db->query("select *from tbl_schedule_spare_triggering where trigger_code='$getSchedule->trigger_code'");
	// $getsmspare=$smspareQuery->row();

	$smsparelogQuery=$this->db->query("select * from tbl_work_order_spare_parts where smsparetrigger_hdr_id='$getData->id'");
	foreach($smsparelogQuery->result() as $getSmlog)
	{

	$sqlunit=$this->db->query("select * from tbl_product_stock where Product_id='$getSmlog->spare_id'");
	$fetchunit=$sqlunit->row();
	?> 	
	 <tbody id="dataTable">
	 </tbody>
	 <tbody>
		<tr class="gradeA">
			<th colspan="2"><?php echo $fetchunit->productname;?></th>
			<input type="hidden" id="espare_nameid" value="<?=$fetchunit->Product_id;?>">
			<th><?php echo $getSmlog->suggested_qty;?></th>
			<th><i spareId="<?=$fetchunit->Product_id; ?>" spareName="<?=$fetchunit->productname;?>" class="fa fa-trash  fa-2x" id="quotationdel" aria-hidden="true"></i></th>
			<th colspan="2">&nbsp;</th>
		</tr>
<?php $i++; } ?>			
	</tbody>
</table>
</div>


<div class="modal-footer" id="button">
<input type="submit" name="submitformspare" id="submitformspare" class="btn btn-sm" value="Save">
<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>

