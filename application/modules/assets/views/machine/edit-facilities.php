<?php
  $ID=$_GET['ID'];
  //echo $type;
  ?>
<div class="modal-content" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php if($type=='view')
      {?>
    <h4 class="modal-title">View Facilities</h4>
    <?php }if($type=='edit'){?>
    <h4 class="modal-title">
      Update Facilities
      <span style="background-color: red;width: 100px;text-align: center;">
        <p id="mssg100" style="color: #F00;"></p>
      </span>
    </h4>
    <?php } ?>
    <!-- <p id="mssg100" style="background-color: red;width: 100px;text-align: center;"></p>
      -->
  </div>
  <?php
    $ItemQuery=$this->db->query("select * from tbl_facilities where id='$ID'");
           $fetch_list=$ItemQuery->row();
    
    ?>
  <div class="modal-body overflow">
    <div class="form-group">
      <label class="col-sm-2 control-label">*Code:</label> 
      <div class="col-sm-4"> 
        <input type="text" name="fac_code" id="fac_code" class="form-control" <?=$type=='view'?'disabled':''?> value="<?php echo $fetch_list->fac_code; ?>" onclick="editalert();" required> 
        <span class="c-validation c-error" style="text-align:center; color:#F00" id="codee"></span>
        <span id="err_unit1"></span>
        <input type="hidden" id="id"  name="id" class="form-control" <?=$type=='view'?'disabled':''?>  value="<?php echo $fetch_list->id; ?>" />
      </div>
      <label class="col-sm-2 control-label">*Name:</label> 
      <div class="col-sm-4"> 
        <input type="text" name="fac_name" id="fac_name" class="form-control" <?=$type=='view'?'disabled':''?> value="<?php echo $fetch_list->fac_name; ?>" required />
        <span class="c-validation c-error" style="text-align:center; color:#F00" id="namee"></span>
        <span id="err_unit1"></span>         
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" style="display: none;">*Location:</label> 
      <div class="col-sm-4" style="display: none;">
        <select name="fac_loc" required class="select2 form-control" id="fac_loc"  <?=$type=='view'?'disabled':''?>>
          <option value="" >----Select----</option>
          <?php 
            $sqlunit=$this->db->query("select * from tbl_master_data where param_id = 21 AND status='A'");
            foreach ($sqlunit->result() as $fetchunit){
            ?>
          <option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetchunit->serial_number == $fetch_list->fac_loc){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
          <?php } ?>
        </select>
        <span class="c-validation c-error" style="text-align:center; color:#F00" id="locee"></span>
        <span id="err_unit1"></span>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php if($type != "view"){ ?>
    <input type="button" class="btn btn-sm savebutton" data-dismiss="modal1" value="Save"  onclick="editData()">
    <?php } ?>
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
  </div>
</div>
<!-- /.modal-content -->