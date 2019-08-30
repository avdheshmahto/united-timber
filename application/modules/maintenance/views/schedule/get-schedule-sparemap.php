<table class="table table-striped table-bordered table-hover dataTables-example1" >
  <thead>
    <tr>
      <th>Trigger Code</th>
      <th>Action</th>
      <!--<th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>-->
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
      	
        foreach($result as $fetch_map_spare);
        {
         $sparemapNamestock=$this->db->query("select *from tbl_product_stock where Product_id='$fetch_map_spare->spare_id'");
         $getSparemapstock=$sparemapNamestock->row();
         $sparemaptrigName=$this->db->query("select * from tbl_schedule_triggering where id='$fetch_map_spare->trigger_code' and status = 'A'");
      	$getSparetrigmap=$sparemaptrigName->row();
        // echo "select * from tbl_schedule_triggering where id='$fetch_map_spare->trigger_code' and status = 'A' GROUP BY trigger_code ";
      $sparemapNamemul=$this->db->query("select T.spare_id,T.quantity,S.productname from tbl_schedule_spare_triggering T ,tbl_product_stock S where T.trigger_code = '$fetch_map_spare->trigger_code'  and T.status = 'A' AND S.Product_id = T.spare_id ");
      
       $ssss =  $sparemapNamemul->result();
       if($ssss != "")
       	$ssss  =  json_encode($ssss);
      
        
      ?>
    <tr class="gradeU record">
      <td>
        <a class="modalMapSpare"   onclick="view_spare_mapp_trig(this);"   arrt= '<?=json_encode($getSparetrigmap);?>' attr='<?=$ssss;?>' data-target="#mapSpare_view_trigger" data-toggle="modal" data-backdrop='static' data-keyboard='false'  id="formreset">
          <?= $getSparetrigmap->trigger_code; ?>
      </td>
      <td><?php $pri_col='id';
        $table_name='tbl_schedule_spare_triggering';
        ?>
      <?php if($edit!=''){ ?>
      <!--	<button type="button" class="btn btn-default"  data-backdrop='static' data-keyboard='false'  data-toggle="modal" data-target="#myModal_edit" arrt= '<?=json_encode($fetch_map_spare);?>' onclick="editSparetrigger(this);"><i class="icon-pencil"></i></button>-->
      <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_map_spare->id;?>" href='#myModal_edit' onclick="editSparetrigger('<?php echo $fetch_map_spare->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="icon-pencil"></i></button>
      <button class="btn btn-default delbutton" id="<?php echo $fetch_map_spare->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>	
      <?php }?>
      </td>
    </tr>
    <?php }?>
    <tr class="gradeU">
    <td>
    <a data-toggle="modal" data-target="#myModal" class="btn btn-default modalMapSpare"  id="popupAdd"><img src="<?=base_url();?>assets/images/plus.png" /> </a>
    <!--<button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_map_spare->id;?>" href='#mapSpare_spare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'  id="formreset"><img src="<?=base_url();?>assets/images/plus.png" /></button>-->
    </td>
    <td>&nbsp;</td>
    </tr>
  </tbody>
  <!--<tbody>
    <tr class="gradeX">
    <td>Misc</td>
    <td>Lynx</td>
    <td>Text only</td>
    <td>-</td>
    <td>X</td>
    </tr>
    
    
    
    </tbody>-->
</table>