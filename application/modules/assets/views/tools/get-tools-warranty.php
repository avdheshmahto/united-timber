<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadwarranties" >
  <thead>
    <tr>
      <!--<th>Spare</th>-->
      <th>Date Added</th>
      <th>Expiry Date</th>
      <th>Certificate Number</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
      
      foreach($result as $fetch_list)
      {
      
      ?>
    <tr class="gradeU record">
      <td><?=$fetch_list->date_added;?></td>
      <td><?=$fetch_list->expiry_date;?></td>
      <td><?=$fetch_list->certificate_number;?></td>
      <td><?php $pri_col='warranty_id';
        $table_name='tbl_tools_warranty';
        ?>
        <?php if($view!=''){ ?>
        <button class="btn btn-default delbutton" id="<?php echo $fetch_list->warranty_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Metering"><i class="icon-trash"></i></button>	
        <?php }?>
      </td>
    </tr>
    <?php }?>
    <tr class="gradeU">
      <td>
        <button  class="btn btn-default modalmechinewarranties" data-a="<?php echo $fetch_list->id;?>" href='#machinewarranties' onclick="addMachineWarranties('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Warranties"><img src="<?=base_url();?>assets/images/plus.png" /></button>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>