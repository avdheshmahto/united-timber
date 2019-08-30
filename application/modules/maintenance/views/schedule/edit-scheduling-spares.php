<?php
  $this->load->view("header.php");
  
  $scheduleQuery=$this->db->query("select *from tbl_schedule_triggering where id='".$_GET['id']."'");
  $getSchedule=$scheduleQuery->row();
  
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
                  <h3 class="panel-title" style="float: initial;">Generate Work Order By Meter Reading
                    <a  onclick="close_a_window();" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
                  </h3>
                </div>
                <div class="panel-body">
                  <form role="form">
                    <table class="table table-striped table-bordered table-hover">
                      <tbody>
                        <input type="hidden" name="scheduling_id" value="<?php echo $_GET['id'];?>">
                        <input type="hidden" name="machine_id" value="<?php echo $getsched->machine_name; ?>">
                        <input type="hidden" name="next_trigge_val_id" id="next_trigge_val_id" value="">
                        <tr class="gradeA">
                          <?php 
                            $sqlQueryMachineId=$this->db->query("select * from tbl_machine_spare_unit_map where machine_id ='$getsched->machine_name'  and status = 'A' order by id desc limit 0,1");
                            
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
                        <tr class="gradeA">
                          <th colspan="6">
                            <h3 class="panel-title" style="float: initial;">
                              <center>Add New Parts & Supplies</center>
                            </h3>
                          </th>
                        </tr>
                      </tbody>
                      <tbody>
                        <input type="hidden" id="scheduled_spare_tr_id" name="scheduled_id" value="<?php echo $_GET['id'];?>">
                        <tr class="gradeA">
                          <th>*Spare Name</th>
                          <th>
                            <select name="spare_name" id="spare_nameid"  class="select2 form-control">
                              <option value="">---select---</option>
                              <?php 
                                $sqlunit=$this->db->query("select * from tbl_product_stock where via_type!='Tools' and status='A'");
                                foreach ($sqlunit->result() as $fetchunit){
                                ?>
                              <option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
                              <?php } ?>
                            </select>
                          </th>
                          <th>*Quantity</th>
                          <th><input type="number" name="qtyname" id="qtyid" class="form-control"></th>
                          <th colspan="2"><button  class="btn btn-default"  type="button" onclick="addrowssasa()"><img src="<?=base_url();?>assets/images/plus.png" />
                            </button>
                          </th>
                        </tr>
                        <tr class="gradeA">
                          <th colspan="6">&nbsp;</th>
                        </tr>
                        <tr class="gradeA">
                          <th colspan="6">
                            <h3 class="panel-title" style="float: initial;">
                              <center>View Spare</center>
                            </h3>
                          </th>
                        </tr>
                      </tbody>
                      <tbody>
                        <tr class="gradeA">
                          <th>&nbsp;</th>
                          <th>S.No.</th>
                          <th>Spare Name</th>
                          <th>Quantity</th>
                          <th colspan="2">&nbsp;</th>
                        </tr>
                        <?php
                          $i=1;
                          	$smspareQuery=$this->db->query("select *from tbl_schedule_spare_triggering where trigger_code='".$_GET['id']."'");
                          	$getsmspare=$smspareQuery->row();
                          
                          	$smsparelogQuery=$this->db->query("select *from tbl_work_order_spare_parts where smsparetrigger_hdr_id='$getsmspare->id'");
                          	foreach($smsparelogQuery->result() as $getSmlog){
                          
                          		$sqlunit=$this->db->query("select * from tbl_product_stock where type='spare' and status='A' and Product_id='$getSmlog->spare_id'");
                          		$fetchunit=$sqlunit->row();
                          ?>
                        <tr class="gradeA">
                          <th>&nbsp;</th>
                          <th><?php echo $i;?></th>
                          <th><?php echo $fetchunit->productname;?></th>
                          <th><?php echo $getSmlog->suggested_qty;?></th>
                          <th colspan="2">&nbsp;</th>
                        </tr>
                        <?php $i++; } ?>			
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <script language="javascript">
            function close_a_window(v) 
            {
            	//alert(v);
               window.close(); 
            
              // return false;
            }
            
          </script>
        </div>
      </div>
    </div>
  </div>
</div>
<!--main-content close-->
<?php
  $this->load->view("footer.php");
  ?>