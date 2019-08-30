<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
  <thead>
    <tr>
      <th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
      <th>Code</th>
      <th>Name</th>
      <th style="display: none;">Location</th>
      <th style="width:110px;">Action</th>
    </tr>
  </thead>
  <tbody id="getDataTable">
    <tr>
      <form method="get">
        <td>&nbsp;</td>
        <td><input name="fac_code"  type="text"  class="search_box form-control input-sm"  value="" /></td>
        <td><input name="fac_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
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
      <th><?php echo $fetch_list->fac_code; ?></th>
      <th><?php echo $fetch_list->fac_name; ?></th>
      <th style="display: none;"><?php 
        $facilityQuery = $this ->db->query("select * from tbl_master_data where serial_number='".$fetch_list->fac_loc."'");
                 
        $getfacility = $facilityQuery->row();
        
        echo $getfacility->keyvalue;  ?>
      </th>
      <th class="bs-example">
        <?php if($view!=''){ ?>
        <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i> </button>
        <?php } if($edit!=''){ ?>
        <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="icon-pencil"></i></button>
        <?php }
          $pri_col='id';
          $table_name='tbl_facilities';
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
<input type="text" style="display:none;" id="table_name" value="tbl_facilities">  
<input type="text" style="display:none;" id="pri_col" value="id">