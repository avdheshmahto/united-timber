<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
  <thead>
    <tr>
      <th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
      <th>Nature of breakdown </th>
      <th>Section</th>
      <th>Date</th>
      <th>Time</th>
      <th>BreakDown Time</th>
      <th>Machine Name</th>
      <th>Spare Name</th>
      <th>Operator Name</th>
      <th>BreakDown Description</th>
      <th style="width:110px;">Action</th>
    </tr>
  </thead>
  <tbody id="getDataTable">
    <tr>
      <form method="get">
        <td>&nbsp;</td>
        <td><input name="n_o_breakdown"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="section"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="date"  type="date"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="time"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="break_time"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="m_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="s_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="o_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="machine_des"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Search</span></button></td>
      </form>
    </tr>
    <?php  
      /*echo "<pre>";
      print_r($result);
      echo "</pre>";*/
      
      
        foreach($result as $fetch_list)
        {
        ?>
    <tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
      <th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>
      <th><?php 
        $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->nature_of_breakdown."'");
        $compRow = $sqlunit->row();
        echo $compRow->keyvalue;
        ?>
      </th>
      <th><?php 
        $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->section."'");
        $compRow = $sqlunit->row();
        echo $compRow->keyvalue; ?></th>
      <th><?php echo $fetch_list->date; ?></th>
      <th><?php echo $fetch_list->time; ?></th>
      <th><?php echo $fetch_list->break_time; ?></th>
      <th>
        <?php 
          $machineQuery = $this ->db->query("select * from tbl_machine where id='".$fetch_list->machine_id."'");
                   
          $getMachine = $machineQuery->row();
          
          echo $getMachine->machine_name;  ?>
      </th>
      <th><?php 
        $machineQuery = $this ->db->query("select * from tbl_product_stock where Product_id='".$fetch_list->part_id."'");
                 
        $getMachine = $machineQuery->row();
        
        echo $getMachine->productname;  ?>
      </th>
      <th><?php 
        $machineQuery = $this ->db->query("select * from tbl_contact_m where contact_id='".$fetch_list->operator_id."'");
                 
        $getMachine = $machineQuery->row();
        
        echo $getMachine->first_name;?>
      </th>
      <th><?=$fetch_list->breakdown_description;?></th>
      <th class="bs-example">
        <?php if($view!=''){ ?>
        <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i> </button>
        <?php } if($edit!=''){ ?>
        <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="icon-pencil"></i></button>
        <?php }
          $pri_col='id';
          $table_name='tbl_machine_breakdown';
          ?>
        <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>		
        <?php
          ?>
        <button style="display:none" class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'>MAP SPARE</button>
      </th>
    </tr>
    <?php  } ?>
  </tbody>
</table>
<input type="text" style="display:none;" id="table_name" value="tbl_machine_breakdown">  
<input type="text" style="display:none;" id="pri_col" value="id">