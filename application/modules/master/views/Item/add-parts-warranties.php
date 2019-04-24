<?php
$machinQuery=$this->db->query("select *from tbl_product_stock where Product_id='$id'");
$getMachine=$machinQuery->row();
?>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">WARRANTY CERTIFICATE</h4>
</div>
</div>

<div class="modal-body overflow">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Name:</label> 
<div class="col-sm-4"> 	
<input type="hidden" class="form-control" name="parts_supllies_id" id="parts_supllies_id" value="<?=$id;?>" />
<h4 class="panel-title" style="float: initial;"><?=$getMachine->productname."(".$getMachine->sku_no.")";?>
</h4>
</div> 
<label class="col-sm-2 control-label">*Warranty Type:</label> 
<span id="spare_name"></span>
<div class="col-sm-4"> 
<select id="warranty_type" required class="form-control">
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id=22");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select> 
</div> 
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Provider:</label> 
<div class="col-sm-4" id="regid"> 
<select id="provider" required class="form-control">
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_contact_m where group_name='5'");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->contact_id;?>"><?php echo $fetchunit->first_name; ?></option>
		<?php } ?>
</select>
</div> 
<label class="col-sm-2 control-label">*Warranty Usage Term Type:</label> 
<div class="col-sm-4"> 
<select name="warranty_usage_term_type" id="warranty_usage_term_type" onchange="hidetrfunction()" required class="form-control">
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id='32'");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select>
</div> 
</div>

<div class="form-group" style="display: none;" id="rowhiddenid"> 
<label class="col-sm-2 control-label">Meter Reading Value Limit:</label> 
<div class="col-sm-4"> 
<input type="text" class="form-control" id="meter_reading_v_limit" value="">    
</div> 
<label class="col-sm-2 control-label">Meter Reading Units:</label> 
<div class="col-sm-4" id="regid"> 
<select id="meter_reading_units" class="form-control">
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id=28");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select>
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">Expiry Date:</label> 
<div class="col-sm-4"> 
<input type="date"  value="" id="expiry_date" class="form-control" />
</div> 
<label class="col-sm-2 control-label">Certificate Number:</label> 
<div class="col-sm-4" id="regid"> 
<input type="text"  id="certificate_number" value="" class="form-control">
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">Description:</label> 
<div class="col-sm-4"> 
<textarea class="form-control" id="desc"></textarea>
</div> 
<label class="col-sm-2 control-label">Date Added:</label> 
<div class="col-sm-4" id="regid"> 
<?php
date_default_timezone_set('Asia/Kolkata');
$dt = new DateTime();
$currentdate=$dt->format('d/m/Y h:i:s');	

?>
<input type="text" id="date_added" value="<?php echo $currentdate; ?>" class="form-control" readonly="true">
</div> 
</div>
</div>

<div class="modal-footer" id="button">
<input type="button" class="btn btn-sm savebutton" onclick="saveWarrantiesData();"  value="Save">
<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>

</div><!-- /.modal-content -->

