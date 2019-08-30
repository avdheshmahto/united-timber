<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData"  >
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
            <td><button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Search</span></button></td>
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
               <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem'onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i> </button>
               <?php }  ?>
               <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem'onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="icon-pencil"></i></button>
               <?php 
                  $pri_col='id';
                  $table_name='tbl_location_rack';
                  ?>
               <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>		
               <?php
                  ?>
            </th>
         </tr>
         <div id="modal-<?php echo $i; ?>" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title">VIew Spare</h4>
                  </div>
                  <div class="modal-body overflow">
                     <div class="form-group">
                        <label class="col-sm-2 control-label">*Code:</label> 
                        <div class="col-sm-4"> 	
                           <input type="text" class="form-control" name="sku_no[]" value="<?php echo $fetch_list->sku_no; ?>" readonly> 
                        </div>
                        <label class="col-sm-2 control-label">*Spare Name:</label> 
                        <div class="col-sm-4"> 
                           <input name="item_name[]"  type="text" value="<?php echo $fetch_list->productname; ?>" readonly class="form-control" required> 
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">*Category:</label> 
                        <div class="col-sm-4">
                           <select name="category[]" class="form-control ui fluid search dropdown email1" disabled="disabled">
                              <option value="">----Select ----</option>
                              <?php 
                                 $sqlgroup=$this->db->query("select * from tbl_prodcatg_mst where prodcatg_id!='121'");
                                 foreach ($sqlgroup->result() as $fetchgroup){						
                                 ?>					
                              <option value="<?php echo $fetchgroup->prodcatg_id; ?>"<?php if($fetchgroup->prodcatg_id==$fetch_list->category){?>selected<?php }?>><?php echo $fetchgroup->prodcatg_name ; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <label class="col-sm-2 control-label">*Usages Unit:</label> 
                        <div class="col-sm-4" >
                           <select name="unit[]" class="form-control" disabled="disabled">
                              <option value="">----Select Unit----</option>
                              <?php 
                                 $sqlunit=$this->db->query("select * from tbl_master_data where param_id=16");
                                 foreach ($sqlunit->result() as $fetchunit){
                                 
                                 ?>
                              <option value="<?php echo $fetchunit->serial_number;?>" <?php if($fetchunit->serial_number==$fetch_list->usageunit){ ?> selected <?php }?>><?php echo $fetchunit->keyvalue; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">*Purchase Price:</label> 
                        <div class="col-sm-4" id="regid"> 
                           <input type="number" step="any" name="unitprice_purchase[]" value="<?php echo $fetch_list->unitprice_purchase; ?>" readonly="" class="form-control" required>
                        </div>
                        <label class="col-sm-2 control-label">Minimum Reorder Level:</label> 
                        <div class="col-sm-4" id="regid"> 
                           <input type="number" name="min_re_order_level[]" value="<?php echo $fetch_list->min_re_order_level; ?>" readonly="" class="form-control" required>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
         <!-- /.modal -->
         <?php $i++; } ?>
         <input type="text" style="display:none;" id="table_name" value="tbl_location_rack">  
         <input type="text" style="display:none;" id="pri_col" value="id">
      </form>
   </tbody>
</table>