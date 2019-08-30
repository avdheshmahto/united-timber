<?php
  $scheduleQuery=$this->db->query("select * from tbl_schedule_triggering where id='$id'");
  $getSchedule=$scheduleQuery->row();
  ?>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Generate Work Order By Meter Reading</h4>
  </div>
</div>
<div class="modal-body overflow">
  <table class="table table-striped table-bordered table-hover">
    <tbody>
      <input type="hidden" name="scheduling_id" value="<?php echo $_GET['id'];?>">
      <input type="hidden" name="machine_id" value="<?php echo $getsched->machine_name; ?>">
      <input type="hidden" name="next_trigge_val_id" id="next_trigge_val_id" value="">
      <tr class="gradeA">
        <?php 
          $sqlQueryMachineId=$this->db->query("select * from tbl_machine_reading where machine_id ='$getsched->machine_name'  and status = 'A' order by id desc limit 0,1");
          
          $getMachineId=$sqlQueryMachineId->row();
          ?>
        <th style="width: 84px;">*Trigger Code </th>
        <th>
          <input type="number" name="trigger_code" id="trigger_codeid" onchange="samecodefun(this.value)" placeholder = "0.0" readonly  value="<?php echo $getSchedule->trigger_code;?>"  class="form-control">
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
        <th><input type="text" id="last_trigger_reading" placeholder = "0.0"  value="<?php echo $getSchedule->next_trigger_reading; ?>"  class="form-control" readonly ></th>
        <?php } ?>
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
              <?php if($getSchedule->type=='End_By'){ echo "End By"; }else{ echo "No End Reading"; } ?>
            </option>
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
    </tbody>
  </table>
</div>
<div class="modal-footer" id="button">
  <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>
</div><!-- /.modal-content -->