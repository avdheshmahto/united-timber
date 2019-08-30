<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Add Labor Tasks</h4>
    <div id="resultaddlabortaskssm" class="text-center " style="font-size: 15px;color: red;"></div>
  </div>
</div>
<div class="modal-body overflow">
  <table class="table table-striped table-bordered table-hover" >
    <tbody>
      <input type="hidden" name="work_order_id" value="<?php echo $id;?>">
      <tr class="gradeA">
        <th>*Task Type</th>
        <th>
          <select name="task_type" id="task_typeid" onchange="tasktype()" class="form-control">
            <option value="">---select---</option>
            <option value="general">General</option>
            <option value="text">Text</option>
            <option value="meter_reading">Meter Reading</option>
          </select>
        </th>
        <th>&nbsp;</th>
        <th>
          <select name="meter_unite" id="unitid" style="display: none;" class="form-control">
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
        <th>*Description</th>
        <th><textarea name="des_name" class="form-control"></textarea></th>
        <th>*Start Date</th>
        <th><input type="date" name="start_date" class="form-control"></th>
      </tr>
      <tr>
        <th>Time Estimate(hours)</th>
        <th><input type="text" name="time_estimate" class="form-control"></th>
        <th>Date Completed</th>
        <th><input type="date" name="date_completed" class="form-control"></th>
      </tr>
      <tr>
        <th>Time Spent(hours)</th>
        <th><input name="time_spent" class="form-control"></th>
        <th>Task Completion Notes</th>
        <th><textarea name="task_notes" class="form-control"></textarea></th>
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
</div>
</div><!-- /.modal-content -->