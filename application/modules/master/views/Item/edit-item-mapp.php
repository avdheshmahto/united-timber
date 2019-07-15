<?php
  $ID=$_GET['ID'];
  //echo $type;
  ?>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php if($type=='view')
      {?>
    <h4 class="modal-title">View Parts And Supplies</h4>
    <?php }if($type=='edit'){?>
    <h4 class="modal-title">Update Parts And Supplies</h4>
    <?php } ?>
    <div id="resultarea1" class="text-center " style="font-size: 15px;color: red;"></div>
  </div>
</div>
<?php
  $lock=0;
  
  $ItemQuery=$this->db->query("select * from tbl_product_stock where Product_id='$ID' " );
  $fetch_list=$ItemQuery->row();
  
  ?>
<div class="modal-body overflow">
  <div class="form-group">
    <label class="col-sm-2 control-label">*Code:</label> 
    <div class="col-sm-4"> 	
      <input type="hidden" class="hiddenField" name="Product_id" id="Product_id" value="<?=$ID;?>" />
      <input type="text" class="form-control" name="sku_no" id="sku_no1" value="<?php echo $fetch_list->sku_no; ?>" <?=$type=='view'?'disabled':''?> onkeyup="editcheckSpareCode()"> 
    </div>
    <label class="col-sm-2 control-label">*Name :</label> 
    <span id="spare_name"></span>
    <div class="col-sm-4"> 
      <input name="item_name"  type="text" id="item_name" value="<?php echo $fetch_list->productname; ?>" <?=$type=='view'?'disabled':''?> class="form-control"> 
      <span class="c-validation c-error" style="text-align:center; color:#F00" id="err_sku1"></span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Type :</label> 
    <div class="col-sm-4" id="regid"> 
      <?php 
        $sqlunit=$this->db->query("select * from tbl_master_data where param_id=26 AND serial_number='$fetch_list->type_of_spare' ");
        $fetchunit=$sqlunit->row();		
        ?>
      <input type="hidden" name="type_of_spare" class="form-control" id="type_of_spare1" value="<?php echo $fetchunit->serial_number; ?>" >	
      <input type="text" class="form-control" value="<?php echo $fetchunit->keyvalue; ?>" onchange="editsubtype(this.value)" readonly="">
      </select>
    </div>
    <label class="col-sm-2 control-label">Sub-Type :</label> 
    <div class="col-sm-4" id="regid"> 
      <input type="text" name="sub_type" id="sub_type1" value="<?=$fetch_list->via_type?>" class="form-control" readonly="">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">*Usages Unit :</label> 
    <div class="col-sm-4">
      <select name="unit" required class="form-control" id="unit1" <?=$type=='view'?'disabled':''?>>
        <option value="" >----Select Unit----</option>
        <?php 
          $sqlunit=$this->db->query("select * from tbl_master_data where param_id=16");
          foreach ($sqlunit->result() as $fetchunit){
          ?>
        <option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetch_list->usageunit == $fetchunit->serial_number){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
        <?php } ?>
      </select>
    </div>
    <label class="col-sm-2 control-label">*Priority:</label> 
    <div class="col-sm-4">
      <select name="priority" required class="form-control" <?=$type=='view'?'disabled':''?> id="priority">
        <option value="" >----Select----</option>
        <?php 
          $sqlunit=$this->db->query("select * from tbl_master_data where param_id=27");
          foreach ($sqlunit->result() as $fetchunit){
          ?>
        <option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetch_list->priority == $fetchunit->serial_number){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">*Vendor Name:</label> 
    <div class="col-sm-4"> 
      <?php
        $vendorQuery=$this->db->query("select *from tbl_contact_m where group_name = '5' and status='A' AND  contact_id='$fetch_list->supp_name' ");
        $getVendor=$vendorQuery->row();
        ?>
      <input type="hidden" name="vendor_name" id="vendor_name" class="form-control" value="<?php echo $getVendor->contact_id; ?>">
      <input type="text" class="form-control" value="<?php echo $getVendor->first_name; ?>" readonly>
      </select>   
    </div>
    <label class="col-sm-2 control-label">*Purchase Price:</label> 
    <div class="col-sm-4" id="regid"> 
      <input type="number" step="any" name="unitprice_purchase" id="unitprice_purchase" value="<?php echo $fetch_list->unitprice_purchase; ?>" class="form-control" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">*Minimum Order:</label> 
    <div class="col-sm-4"> 
      <input type="text" name="min_order" id="min_order" <?=$type=='view'?'disabled':''?> class="form-control" value="<?php echo $fetch_list->min_order; ?>" required="">
    </div>
    <label class="col-sm-2 control-label">*Minimum Reorder Level:</label> 
    <div class="col-sm-4" id="regid"> 
      <input type="text" name="min_re_order_level" <?=$type=='view'?'disabled':''?> id="min_re_order_level" value="<?php echo $fetch_list->min_re_order_level; ?>" class="form-control" required="">
    </div>
  </div>
  <div class="table-responsive">
    <?php if($type != "edit"){ ?>
    <INPUT type="button" value="Add Row" class="btn btn-primary" onclick="addRow_edit('dataTable_edit')" />
    <!-- <INPUT type="button" class="btn btn-danger delete_other" value="Delete Row" onclick="deleteRow_edit('dataTable_edit')" /> -->
    <?php } ?>
    <table class="table table-striped table-bordered table-hover" id="dataTable_edit" >
      <tbody>
        <tr class="gradeA">
          <?php if($type != "edit"){ ?>
          <th>Check </th>
          <?php } ?>
          <th>Location</th>
          <th>Rack</th>
          <th >Quantity</th>
          <!-- <th>Minimum Reorder Level</th>
            <th>Minimum Order</th> -->
          <?php if($type != "edit"){ ?>
          <th>Action</th>
          <?php } ?>
          <?php
            $locvalue=0;
            $m=0;
            //$ItemQuery=$this->db->query("select * from tbl_product_serial_log where product_id='$ID' AND type='opening stock'");
            $ItemQuery=$this->db->query("select * from tbl_product_serial where product_id='$ID'");
            foreach($ItemQuery->result() as $fetch_list_map){
            
            ?>
        </tr>
        <tr class="gradeC" data-row-id="<?php echo $fetch_list_map->serial_number; ?>">
          <?php if($type != "edit"){ ?>
          <th >
            <input type="checkbox" name="chkbox[]" class="sub_chk" id="chk1"  data-id="<?php echo $fetch_list_map->serial_number; ?>"  />
          </th>
          <?php } ?>
          <th>
            <select name="location[]" id="cat_idd<?=$m+1;?>"  class="form-control" <?=$type=='edit'?'disabled':''?> onChange="getCatt(this.id)">
              <option value=""selected disabled>----Select ----</option>
              <?php 
                $sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
                foreach ($sqlgroup->result() as $fetchgroup){						
                ?>					
              <option value="<?php echo $fetchgroup->serial_number; ?>"<?php if($fetch_list_map->loc == $fetchgroup->serial_number){ ?> selected <?php } ?>><?php $locvalue=$fetch_list_map->loc;echo $fetchgroup->keyvalue; ?></option>
              <?php } ?>
            </select>
          </th>
          <th style="display: none;">
            <select name="location_php[]" id="cat_idd<?=$m+1;?>"  class="form-control" <?=$type=='edit'?'disabled':''?> onChange="getCatt(this.id)">
              <option value=""selected disabled>----Select ----</option>
              <?php 
                $sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
                foreach ($sqlgroup->result() as $fetchgroup){						
                ?>					
              <option value="<?php echo $fetchgroup->serial_number; ?>"<?php if($fetch_list_map->loc == $fetchgroup->serial_number){ ?> selected <?php } ?>><?php echo $fetchgroup->keyvalue  ?></option>
              <?php } ?>
            </select>
          </th>
          <th>
            <input type="hidden" name="location_id" value="<?php echo $locvalue; ?>">
            <select name="rack[]" id="div_cat_idd<?=$m+1;?>" class="form-control" <?=$type=='edit'?'disabled':''?>  onchange="validatephprack(this);" attri="<?php echo $locvalue; ?>">
              <option value=""selected disabled>----Select ----</option>
              <?php
                $queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A' and location_rack_id='$locvalue'");
                foreach($queryMainLocation1->result() as $getMainLocation1){
                ?>
              <option value="<?php echo $getMainLocation1->id;?>"<?php if($fetch_list_map->rack_id == $getMainLocation1->id){ ?> selected <?php } ?>><?=$getMainLocation1->rack_name;?></option>
              <?php }?>
            </select>
          </th>
          <th style="display: none;">
            <select name="rack_php[]" id="div_cat_idd<?=$m+1;?>" class="form-control" <?=$type=='edit'?'disabled':''?> >
              <option value=""selected disabled>----Select ----</option>
              <?php
                $queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A'");
                foreach($queryMainLocation1->result() as $getMainLocation1){
                ?>
              <option value="<?php echo $getMainLocation1->id;?>"<?php if($fetch_list_map->rack_id == $getMainLocation1->id){ ?> selected <?php } ?>><?=$getMainLocation1->rack_name;?></option>
              <?php }?>
            </select>
          </th>
          <th>
            <input type="number" step="any"  value="<?php echo $fetch_list_map->quantity; ?>" id="qtyy"  name="qtyy[]"  <?=$type=='edit'?'disabled':''?>  class="form-control"> 
          </th>
          <!-- <th>
            <input type="number" step="any"  value="<?php echo $fetch_list_map->min_re_order_level; ?>" id="min_re_order_level"  name="min_re_order_level[]"  <?=$type=='edit'?'disabled':''?>  class="form-control"> 
            </th>
            <th>
            <input type="number" step="any"  value="<?php echo $fetch_list_map->min_order; ?>" id="min_order"  name="min_order[]" class="form-control"> 
            </th> -->
          <th style="display: none;">
            <input type="text" name="pr_id[]" id="pr_id" value="<?=$fetch_list_map->serial_number;?>" class="form-control" readonly="true">
          </th>
          <?php if($type != "edit"){ ?>
          <th>
            <img src="<?=base_url("assets/images/delete.png");?>" onclick="deletevalfunc(this);" attrid="<?=$fetch_list_map->serial_number?>" />
          </th>
          <?php } ?>
        </tr>
        <?php
          $cnt=$m+$m;
          $m++;
          ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-footer" id="button">
  <?php if($type != "view"){ ?>
  <input type="submit" class="btn btn-sm" id="saveItem1" value="Save">
  <?php } ?>
  <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
  <span id="saveload" style="display: none;">
  <img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
  </span>
</div>