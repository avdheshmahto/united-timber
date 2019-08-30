<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
  <thead>
    <tr>
      <th>Code </th>
      <!-- <th>Trigger</th> -->
      <th>Part & Supplies Issue</th>
      <th>Machine Name</th>
      <th>Work Order Status</th>
      <th>Priority</th>
      <th>Maintenance Type</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id = "getDataTable">
    <tr style="display: none;">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <?php  
      $i=1;
      foreach($result as $fetch_list)
      {
      ?>
    <tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
      </th>
      <th>
        <?php
          if($fetch_list->trigger_code!=''){
            ?>
        <a href="<?=base_url();?>maintenance/machine_breakdown/manage_machine_breakdown_sm_map?id=<?php echo $fetch_list->id; ?>" onclick='yourFunct(<?=$fetch_list->id?>,<?=$fetch_list->trigger_code?>)' >
        <?php   echo "WO".$fetch_list->id."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SM".$fetch_list->schedule_id;  ?></a>
        <?php
          }else{
          ?>
        <a href="<?=base_url();?>maintenance/machine_breakdown/manage_machine_breakdown_map?id=<?php echo $fetch_list->id; ?>"><?php  echo "WO".$fetch_list->id;  ?></a>
        <?php } ?>
      </th>
      <th>  
        <?php
          $whdr=$this->db->query("select * from tbl_workorder_spare_hdr where work_order_id='$fetch_list->id' ");
          $count=$whdr->num_rows();
          
          
          $val=array();
          foreach($whdr->result() as $getHdr)
          {
            if($getHdr->spare_hdr_id != ''){
              array_push($val,$getHdr->spare_hdr_id);
            }
          }
          
          if($count > 0)
          {
            $valAbc=implode(',', $val);  
          }
          else
          {
            $valAbc='99999999';
          }
          
          $wdtl=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id IN ($valAbc)");
          $count2=$wdtl->num_rows();
          
          $val2=array();
          foreach($wdtl->result() as $getDtl)
          {
            if($getDtl->spare_id != ''){
              array_push($val2,$getDtl->spare_id);
            }
          }
          if($count2 > 0)
          {
            $valXyz=implode(',',$val2);  
          }
          else
          {
            $valXyz='99999999';
          }
          
          $prd=$this->db->query("select * from tbl_product_stock where Product_id IN ($valXyz) ");
          $values4=array();
          foreach($prd->result() as $value) {
            
            array_push($values4, $value->productname);
          }
          
            echo $values4[0];
            //print_r($values4);
                      ?>
      </th>
      <th>
        <a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $fetch_list->machine_name; ?>" title="Machine Spare Details">
        <?php 
          $sqlunit=$this->db->query("select * from tbl_machine where id='".$fetch_list->machine_name."'");
          $compRow = $sqlunit->row();
          echo $compRow->machine_name;
            ?>
        </a>
      </th>
      <th>
        <?php 
          $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->wostatus."'");
          $compRow = $sqlunit->row();
          echo $compRow->keyvalue;
            ?>
      </th>
      <th>
        <?php 
          $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->priority."'");
          $compRow = $sqlunit->row();
          echo $compRow->keyvalue;
            ?>
      </th>
      <th>
        <?php 
          $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->maintyp."'");
          $compRow = $sqlunit->row();
          echo $compRow->keyvalue;
            ?>
      </th>
      <th class="bs-example">
        <?php
          if($fetch_list->trigger_code!=''){
          
          }else{
            ?>
        <?php if($view!=''){ ?>
        <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i> </button>
        <?php } if($edit!=''){ ?>
        <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit');datetimeplugin();" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="icon-pencil"></i></button>
        <?php }
          $pri_col='id';
          $table_name='tbl_work_order_maintain';
          ?>
        <button style="display:none" class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>    
        <?php
          ?>
        <button style="display:none" class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'>MAP SPARE</button>
        <?php } ?>
      </th>
    </tr>
    <?php $i++; } ?>
  </tbody>
</table>