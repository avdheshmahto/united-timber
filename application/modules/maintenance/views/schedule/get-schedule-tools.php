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
      
      $toolName=$this->db->query("select * from tbl_workorder_spare_hdr where type='Tools' and work_order_id='$id'");
      
      foreach($toolName->result() as $fetch_map_tool)
      {
      
      ?>
    <tr class="gradeU record">
      <td>
        <a  class="modalMapSpare" href='#viewscheduletoolsid' onclick="viewscheduletools('<?php echo  $fetch_map_tool->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Tools Order">
        <?=sprintf('%03d',$fetch_map_tool->spare_hdr_id); ?></a>
      </td>
      <td><?=$fetch_map_tool->maker_date; ?></td>
      <td><?=$fetch_map_tool->work_order_status; ?></td>
      <td><a  class="modalMapSpare" href='#viewscheduletoolsid' onclick="viewscheduletools('<?php echo  $fetch_map_tool->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Tools Order"><i class="fa fa-eye"></i></a></td>
    </tr>
    <?php }?>
    <tr class="gradeU">
      <td>
        <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#scheduletoolsid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Tools"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>