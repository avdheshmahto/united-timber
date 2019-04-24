<?php
$scheduleQuery=$this->db->query("select *from tbl_schedule_triggering where id='$id'");
$getSchedule=$scheduleQuery->row();
?>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Edit Generate Work Order By Meter Reading</h4>
<div id="resultareaeditschedule" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>

<div class="modal-body overflow">
	<table class="table table-striped table-bordered table-hover">
	<tbody>
	<input type="hidden" name="scheduling_id_log" value="<?php echo $id;?>">
	<input type="hidden" name="next_trigge_val_id" id="next_trigge_val_id" value="<?php echo $getSchedule->next_trigger_reading;?>">
	<tr class="gradeA">
	<?php 

		$sqlQueryMachineId=$this->db->query("select * from tbl_machine_reading where machine_id ='$getSchedule->machine_id'  and status = 'A' order by id desc limit 0,1");
		
		$getMachineId=$sqlQueryMachineId->row();
	?>

		<th>*Trigger Code </th>
		<th>
		  <input type="number" name="trigger_code" id="trigger_codeid" onchange="samecodefun(this.value)" placeholder = "0.0"  value="<?php echo $getSchedule->trigger_code;?>" readonly class="form-control">
		  <p id="existcodeid" style="font-size: 10px;color: red;"></p>
		</th>
		<th>Machine Current Reading :- </th>
		<th>
		  <input type="text" name="machine_current_reading" placeholder = "0.0"  value="<?php echo $getMachineId->reading; ?>" readonly class="form-control">
		</th>
		<?php 
	    
	    if($getSchedule->type=='End_By'){
	    ?>
		<th>Last End By Trigger Reading :-  </th>
		<th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getSchedule->endby_reading; ?>"  class="form-control" readonly ></th>	
		<?php }else{ ?>
		<th>Last Trigger Reading :- </th>
		<th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getSchedule->next_trigger_reading; ?>"  class="form-control" readonly ></th><?php } ?>
			
	</tr>
	<tr>
		<th>*Every</th>
		<th><input type="number" name="every_name" id="every_id" onkeyup="nexttrigger()" placeholder = "0.0" <?php if($getSchedule->type=='End_By'){?> readonly <?php } ?> value="<?php echo $getSchedule->every_reading; ?>"  class="form-control"></th>
		<th>
		<select name="unit_meter" class="form-control" <?php if($getSchedule->type=='End_By'){?> disabled <?php } ?>>
			<option value="">----Select----</option>
			<?php 
			$sqlunitt=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
			foreach ($sqlunitt->result() as $fetchunitt){
			?>
			<option value="<?php echo $fetchunitt->serial_number;?>" <?php if($fetchunitt->serial_number==$getSchedule->unit){ ?> selected <?php } ?>>

			<?php echo $fetchunitt->keyvalue; ?>
				
			</option>
			<?php } ?>
		</select>
		</th>
		<th colspan="3">&nbsp;</th>
	</tr>
	<tr>
		<th>*Start At</th>
		<th><input type="number" name="start_at" id="start_at_id" onkeyup="nexttrigger()" <?php if($getSchedule->type=='End_By'){?> readonly <?php } ?> onchange="nextvalvalidation()" placeholder = "0.0"  value="<?php echo $getSchedule->starting_reading; ?>"  class="form-control"></th>
		<th>
		<select name="end_by" id="end_by_id" onchange="endbyfun()" class="form-control" <?php if($getSchedule->type=='End_By'){?> disabled <?php } ?>>
			<option value="" >----Select----</option>
			<option value="No_End_Reading" <?php if($getSchedule->type=='No_End_Reading'){ ?> selected <?php } ?>>No End Reading</option>
			<option value="End_By" <?php if($getSchedule->type=='End_By'){ ?> selected <?php } ?>>End By</option>
		</select>
		</th>
		<th>
		<?php if($getSchedule->type=='End_By'){ ?>
		<input type="number" name="end_by_reading_meter" placeholder = "0.0"  id="end_by_reading_meter" readonly value="<?php echo $getSchedule->endby_reading; ?>"   class="form-control">
		<?php }else{ ?>
		<input type="number" name="end_by_reading_meter" placeholder = "0.0"  id="end_by_reading_meter" style="display: none;" value="" class="form-control">
		<?php } ?>
		</th>
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

