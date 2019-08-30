<?php
  $machinQuery=$this->db->query("select *from tbl_machine where id='$id'");
  $getMachine=$machinQuery->row();
  ?>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">ADD SUPPLIERS</h4>
  </div>
</div>
<div class="modal-body overflow">
  <div class="form-group">
    <label class="col-sm-2 control-label">*Machine Name:</label> 
    <div class="col-sm-4">
      <input type="hidden" class="form-control" name="machine_id" id="machine_id" value="<?=$id;?>" />
      <h4 class="panel-title" style="float: initial;"><?=$getMachine->machine_name."(".$getMachine->code.")";?></h4>
    </div>
    <label class="col-sm-2 control-label">*Supplier Name:</label> 
    <span id="spare_name"></span>
    <div class="col-sm-4">
      <select id="supplier_name" required class="form-control">
        <option value="" >----Select----</option>
        <?php 
          $sqlcontact=$this->db->query("select * from tbl_contact_m where group_name='5' AND status='A'");
          foreach ($sqlcontact->result() as $fetchcontact){
          ?>
        <option value="<?php echo $fetchcontact->contact_id;?>"><?php echo $fetchcontact->first_name; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">*Supplier Type:</label> 
    <div class="col-sm-4" id="regid">
      <select id="supplier_type" required class="form-control">
        <option value="" >----Select----</option>
        <?php 
          $sqlunit=$this->db->query("select * from tbl_account_mst where account_id='5' AND status='A'");
          foreach ($sqlunit->result() as $fetchunit){
          ?>
        <option value="<?php echo $fetchunit->account_id;?>" selected>
          <?php echo $fetchunit->account_name; ?>
        </option>
        <?php } ?>
      </select>
    </div>
    <label class="col-sm-2 control-label">Supplier Part Number:</label> 
    <div class="col-sm-4"> 
      <input type="text"  value="" id="Supplier_part_number" class="form-control" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Catalog:</label> 
    <div class="col-sm-4"> 
      <input type="text"  value="" id="catelog_id" class="form-control" />
    </div>
    <label class="col-sm-2 control-label">&nbsp;</label> 
    <div class="col-sm-4" id="regid"> </div>
  </div>
</div>
<div class="modal-footer" id="button">
  <input type="button" class="btn btn-sm savebutton" onclick="saveSupplierData();"  value="Save">
  <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>
</div><!-- /.modal-content -->