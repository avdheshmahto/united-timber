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
      $queryschedule=$this->db->query("select *from  tbl_schedule_triggering where schedule_id='$id' order by id desc");
        
        foreach($queryschedule->result() as $fetch_list)
        {
        
        $unitName=$this->db->query("select *from  tbl_master_data where serial_number='$fetch_list->unit'");
         $getunitD=$unitName->row();
      ?>
    <tr class="gradeU record">
      <td><?="TR".$fetch_list->trigger_code;?></td>
      <td>		
        <a  class="modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#viewscheduling' onclick="viewtrigger('<?php echo  $fetch_list->id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Triggers">Every&nbsp;&nbsp;<?=$fetch_list->every_reading;?>&nbsp;&nbsp;<?=$getunitD->keyvalue;?></a>
      </td>
      <?php 
        $sqlQueryMachineIdview=$this->db->query("select * from tbl_machine_reading where machine_id ='$fetch_list->machine_id'  and status = 'A' order by id desc limit 0,1");
        
        $getMachineIdview=$sqlQueryMachineIdview->row();
        
        ?>
      <td><?=$fetch_list->machine_current_reading;?></td>
      <td>
        <a  class="modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#editscheduling' onclick="edittrigger('<?php echo  $fetch_list->id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Triggers">
        <?=$fetch_list->next_trigger_reading;?></a>
      </td>
    </tr>
    <?php  } ?>
    <tr class="gradeU">
      <td>
        <?php 
          $sqlSchedulingview=$this->db->query("select * from tbl_schedule_triggering where schedule_id ='$id'  and status = 'A' order by id desc limit 0,1");
          
          $getScheduling=$sqlSchedulingview->row();
          
          $sqlMachineIdview=$this->db->query("select * from tbl_machine_reading where machine_id ='$getScheduling->machine_id'  and status = 'A' order by id desc limit 0,1");
          
          $getMachine=$sqlMachineIdview->row();
          /*
          if($getScheduling->type=='End_By'){
          $nexttriggerval=$getScheduling->endby_reading;
          }else{
          $nexttriggerval=$getScheduling->next_trigger_reading;
          }*/
          
          if($getScheduling->type=='End_By'){
          
          ?>
        <button  class="btn btn-default modalMapSpare" href='#addscheduling' onclick="addSchedulingTrigger('<?php echo  $id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Schedule Trigger"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
        <?php
          }else{	}
           ?>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>