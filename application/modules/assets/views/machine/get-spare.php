<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadSpare">
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th>Priority</th>
      <th>Reading</th>
      <th>Unit</th>
      <th>Purchase Price</th>
      <th>Quantity</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
        foreach($result as $fetch_list)
        {
         $spareName=$this->db->query("select *from tbl_product_stock where Product_id='$fetch_list->spare_id'");
         $getSpareD=$spareName->row();
      ?>
    <tr class="gradeU record">
      <td><?=$getSpareD->sku_no;?></td>
      <td><a class="modalMapSpare" data-a="<?php echo $getSpareD->Product_id;?>" href='#editItem' onclick="getEditItemm('<?php echo $getSpareD->Product_id;?>','view')" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Spare Details"><?=$getSpareD->productname;?></a></td>
      <td><?php 
        $compQuery = $this -> db
                  -> select('*')
                  -> where('serial_number',$getSpareD->priority)
                  -> get('tbl_master_data');
        $compRow = $compQuery->row();
        
        echo $compRow->keyvalue;
        ?>
      </td>
      <td><?=$fetch_list->reading;?></td>
      <td><?php 
        $compQuery = $this -> db
                  -> select('*')
                  -> where('serial_number',$fetch_list->unit)
                  -> get('tbl_master_data');
        $compRow = $compQuery->row();
        
        echo $compRow->keyvalue;
        ?>
      </td>
      <!--<td><?php 
        $compQuery = $this -> db
                  -> select('*')
                  -> where('serial_number',$getSpareD->type_of_spare)
                  -> get('tbl_master_data');
        $compRow = $compQuery->row();
        
        echo $compRow->keyvalue;
        ?>
        </td>-->
      <td><?=$getSpareD->unitprice_purchase;?></td>
      <td><?=$fetch_list->quantity;?></td>
      <td>
        <?php $pri_col='id';
          $table_name='tbl_machine_spare_map';
          ?>
        <?php if($view!=''){ ?>
        <!---<a  arrt= '<?=json_encode($getSpareD);?>'  onclick ="editRow(this);" class="btn btn-default"  data-toggle="modal" data-target="#modal-0" >&nbsp; <i class="icon-eye"></i>&nbsp; </a> 
          </td>-->		
        <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>	
        <?php }?>
      </td>
    </tr>
    <?php }?>
    <tr class="gradeU">
      <td>
        <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset"><img src="<?=base_url();?>assets/images/plus.png" /></button>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
  <tfoot>
  </tfoot>
</table>