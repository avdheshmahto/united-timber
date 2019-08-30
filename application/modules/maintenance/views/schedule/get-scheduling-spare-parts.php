<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadsparescheduling" >
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
      $spareq=$this->db->query("select * from tbl_schedule_spare_hdr where schedule_id='$id' and status = 'A'");
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
      <td>
        <?php $pri_col='id';
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