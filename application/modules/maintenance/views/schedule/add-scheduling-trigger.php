<?php
$scheQueryto=$this->db->query("select *from tbl_schedule_maintain where id='$id' and status = 'A'");
$getschedto=$scheQueryto->row();
?>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Generate Work Order By Meter Reading</h4>
<div id="resultareaschedule" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
<div class="modal-body overflow">
	<table class="table table-striped table-bordered table-hover">
	<tbody>
	<input type="hidden" name="scheduling_id" value="<?php echo $id;?>">
	<input type="hidden" name="machine_id" value="<?php echo $getschedto->machine_name; ?>">
	<input type="hidden" name="next_trigge_val_id" id="next_trigge_val_id" value="">
	<tr class="gradeA">
	<?php 

		$sqlQueryMachineId=$this->db->query("select * from tbl_machine_reading where machine_id ='$getschedto->machine_name'  and status = 'A' order by id desc limit 0,1");
		$getMachineId=$sqlQueryMachineId->row();

		$mac=$this->db->query("select * from tbl_machine where id='$getschedto->machine_name' ");
		$getMac=$mac->row();
	?>

		<th>*Trigger Code </th>
		<th>
		 <input type="number" name="trigger_code" id="trigger_codeid" onkeyup="samecodefun(this.value,'<?=$id?>')" placeholder = "0.0"  value=""  class="form-control">
		  <p id="existcodeid" style="font-size: 10px;color: red;"></p>
		</th>
		<th>Machine Current redading :- </th>
		<th>
		  <input type="text" name="machine_current_reading" placeholder = "0.0"  value="<?php echo $getMachineId->reading; ?>" readonly class="form-control">
		</th>
		<?php 

		$sqlQueryscheduletr=$this->db->query("select * from tbl_schedule_triggering where machine_id ='$getschedto->machine_name'  and status = 'A' order by id desc limit 0,1");
		
		$getScheduletr=$sqlQueryscheduletr->row();
	    
	    if($getScheduletr->type=='End_By'){
	    ?>
		<th>Last End By Trigger Reading :-  </th>
		<th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getScheduletr->endby_reading; ?>"  class="form-control" readonly ></th>	
		<?php }else{ ?>
		<th>Last Trigger Reading :- </th>
		<th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getScheduletr->next_trigger_reading; ?>"  class="form-control" readonly ></th><?php } ?>
			
	</tr>
	<tr>
		<th>*Every</th>
		<th><input type="number" name="every_name" id="every_id" onkeyup="nexttrigger()" placeholder = "0.0"  value=""  class="form-control"></th>
		<th>
		<select name="unit_meter" class="form-control" >
			<option value="">----Select----</option>
			<?php 
			$sqlunitt=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
			foreach ($sqlunitt->result() as $fetchunitt){
			?>
			<option value="<?php echo $fetchunitt->serial_number;?>" <?php if($fetchunitt->serial_number == $getMac->m_unit) { ?> selected <?php } ?> ><?php echo $fetchunitt->keyvalue; ?></option>
			<?php } ?>
		</select>
		</th>
		<th colspan="3">&nbsp;</th>
	</tr>
	<tr>
		<th>*Start At</th>
		<th><input type="number" name="start_at" id="start_at_id" onkeyup="nexttrigger()"  onchange="nextvalvalidation()" placeholder = "0.0"  value=""  class="form-control"></th>
		<th>
		<select name="end_by" id="end_by_id" onchange="endbyfun()" class="form-control">
			<option value="" >----Select----</option>
			<option value="No_End_Reading">No End Reading</option>
			<option value="End_By">End By</option>
		</select>
		</th>
		<th><input type="number" name="end_by_reading_meter" placeholder = "0.0"  id="end_by_reading_meter" style="display: none;"  class="form-control"></th>
		<th colspan="2">&nbsp;</th>
	</tr>		
	<tr>
		<th colspan="4">&nbsp;</th>
		<th colspan="2">
			<input type="submit" id="submitid" style="display: none;" class="btn btn-sm savebutton" name="submitform" value="Save">
			<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
		</th>
	</tr>
</tbody>
</table>
</div>
</div><!-- /.modal-content -->

