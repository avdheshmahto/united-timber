<?php
$ID=$_GET['ID'];
//echo $type;
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php if($type=='view')
{?>
<h4 class="modal-title">View Schedule</h4>
<?php }elseif($type=='edit'){?>
<h4 class="modal-title">Update Schedule</h4>
<?php } ?>
<div id="resultareabreak" class="text-center " style="font-size: 15px;color: red;"></div> 
<div id="resultareabreakhours" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
<div class="modal-body overflow">
<?php

$ItemQuery=$this->db->query("select * from tbl_work_order_maintain where id='$ID'");
$fetch_list=$ItemQuery->row();
$brk=$this->db->query("select * from tbl_machine_breakdown where code='$fetch_list->code' ");
$getBrk=$brk->row();

?>
<div class="form-group"> 
<label class="col-sm-2 control-label">*Code:</label> 
<div class="col-sm-4"> 	
<input type="hidden" id="id"  name="id" class="form-control"  value="<?php echo $fetch_list->id; ?>" />
<input type="text" class="form-control" id="code" name="code" value="<?php echo $fetch_list->code; ?>"<?=$type=='view'?'disabled':''?> readonly> 
</div> 

<label class="col-sm-2 control-label">*Section:</label> 
<div class="col-sm-4"> 
<select name="m_type" required class="select2 form-control" id="m_type"  <?=$type=='view'?'disabled':''?> onChange="getCatt(this.id)" style="width:100%;">
	<option value="0" class="listClass">-----Section-----</option>
	<?php
	foreach ($categorySelectbox as $key => $dt) { ?>
	<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" <?php if($dt['id'] == $fetch_list->m_type){ ?> selected <?php } ?>> <?=$dt['name'];?></option>
	<?php } ?>
</select>
</div> 
</div>

<?php
$ItemQuery=$this->db->query("select * from tbl_machine where id='$fetch_list->machine_name'");
$fetch_aat=$ItemQuery->row();
?>
<div class="form-group"> 
<label class="col-sm-2 control-label">*Machine Name:</label> 
<div class="col-sm-4"> 
<select name="machine_name" id="machine_name" class="form-control" <?=$type=='view'?'disabled':''?> >
<option value="">----Select ----</option>
<option value="<?php echo $fetch_aat->id;?>" <?php if( $fetch_aat->id == $fetch_list->machine_name){ ?> selected <?php } ?>><?php echo $fetch_aat->machine_name; ?></option>
</select>
</div> 
<label class="col-sm-2 control-label">*Work Order Status:</label> 
<div class="col-sm-4"> 
<select name="wostatus" required class="form-control" id="wostatus"  <?=$type=='view'?'disabled':''?> style="width:100%;" onchange="checkBreakdownHours(this.value);">
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id='29'");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>" <?php if( $fetchunit->serial_number == $fetch_list->wostatus){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select>         
</div> 
</div>


<div class="form-group">
 <label class="col-sm-2 control-label">*Priority:</label> 
<div class="col-sm-4"> 
<select name="priority" required class="form-control" id="priority" style="width:100%;" <?=$type=='view'?'disabled':''?>>
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id='27'");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"<?php if( $fetchunit->serial_number == $fetch_list->priority){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select>         
</div>
<label class="col-sm-2 control-label">*Maintenance Type:</label> 
<div class="col-sm-4"> 
<select name="maintyp" required class="form-control" id="maintyp" style="width:100%;" <?=$type=='view'?'disabled':''?>>
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id='31'");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"<?php if( $fetchunit->serial_number == $fetch_list->maintyp){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select>  
</div> 
</div>

<div class="form-group">
<label class="col-sm-2 control-label">*Operator:</label> 
<div class="col-sm-4">
<input type="text" name="operator" id="operator" class="form-control" <?=$type=='view'?'disabled':''?> value="<?=$getBrk->operator_id?>"> 
<!-- <select name="operator1" id="operator11" required class="select2 form-control" style="width:100%;" <?=$type=='view'?'disabled':''?>>
		<option value="" >----Select----</option>
		<?php 
			$sqlunit3=$this->db->query("select * from tbl_contact_m where group_name=6 ");
			foreach ($sqlunit3->result() as $fetchunit3){
		?>
		<option value="<?php echo $fetchunit3->contact_id;?>" <?php if( $fetchunit3->contact_id == $getBrk->operator_id) { ?> selected <?php } ?> ><?php echo $fetchunit3->first_name; ?></option>
		<?php } ?>
</select> -->
</div>	
 <label class="col-sm-2 control-label">*Suggested Completion Date:</label> 
<div class="col-sm-4"> 
 <input type="text"  id="datetimepicker_mask" class="form-control datetimepicker_maskedit" value="<?php echo $fetch_list->date_time; ?>" <?=$type=='view'?'disabled':''?> style="width:100%;"/>
</div>
</div>

</div>


<div class="modal-footer">
<?php if($type != "view"){ ?>
<input type="button" class="btn btn-sm" id="saveButton" data-dismiss="modal1" value="Save"  onclick="editData()">
<?php } ?>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>

