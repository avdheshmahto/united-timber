<thead>
   <tr>
      <th style="width:22px;"><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
      <th>Location Name </th>
      <th>Location Rack</th>
      <th style="width:110px;">Action</th>
   </tr>
</thead>
<tbody id = "getDataTable">
   <tr>
      <form method="get">
         <td>&nbsp;</td>
         <td><input name="location_rack_id"  type="text"  class="search_box form-control input-sm"   value="" /></td>
         <td><input name="rack_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
         <td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
      </form>
   </tr>
   <form class="form-horizontal" method="post" action="update_item"  enctype="multipart/form-data">
      <?php  
         $i=1;
         foreach($result as $fetch_list)
         {
         ?>
      <tr class="gradeC record" data-row-id="<?php echo $fetch_list->id; ?>">
         <th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>
         <?php 
            $compQuery = $this -> db
                      -> select('*')
                      -> where('serial_number',$fetch_list->location_rack_id)
                      -> get('tbl_master_data');
            	  $compRow = $compQuery->row();
            
            
            ?>
         <th><?php echo $compRow->keyvalue;?></th>
         <th><?php echo $fetch_list->rack_name;?></th>
         <th class="bs-example">
            <?php if($view!=''){ ?>
            <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem'onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Location Rack"> <i class="fa fa-eye"></i> </button>
            <?php } if($edit!=''){ ?>
            <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem'onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Location Rack"><i class="icon-pencil"></i></button>
            <?php }
               $pri_col='id';
               $table_name='tbl_location_rack';
               ?>
            <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Location Rack"><i class="icon-trash"></i></button>		
         </th>
      </tr>
      <?php $i++; } ?>
      <input type="text" style="display:none;" id="table_name" value="tbl_location_rack">  
      <input type="text" style="display:none;" id="pri_col" value="id">
   </form>
</tbody>