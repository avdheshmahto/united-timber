<link rel="stylesheet" href="<?=base_url();?>assets/css/vendor/bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url();?>assets/js/vendor/chosen/chosen.css">
<link rel="stylesheet" href="<?=base_url();?>assets/css/main.css">


<?php
$ID=$_GET['ID'];
//echo $type;
?>
<style type="text/css">

	.select2-container--open {
       z-index: 99999999 !important;
	 }
	 .select2-container {
       min-width: 256px !important;
     }
</style>


<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php if($type=='view')
{?>
<h4 class="modal-title">View Machine</h4>
<?php }elseif($type=='edit'){?>
<h4 class="modal-title">Update Machine<span style="background-color: red;width: 100px;text-align: center;"><p id="mssg100" style="color: #F00;"></p></span></h4>
<?php } ?>
</div>
<div class="modal-body overflow">
<?php
	 $ItemQuery=$this->db->query("select * from tbl_machine where id='$ID'");
         $fetch_list=$ItemQuery->row();

?>
<div class="form-group"> 
<label class="col-sm-2 control-label">*Code:</label> 
<div class="col-sm-4"> 	
<input type="hidden" id="editid"  name="id" class="form-control"  value="<?php echo $fetch_list->id; ?>" />
<input type="text" class="form-control" id="editcode" name="code" value="<?php echo $fetch_list->code; ?>"<?=$type=='view'?'disabled':''?> > 
</div> 

<label class="col-sm-2 control-label">*Section:</label> 
<div class="col-sm-4"> 
<select name="m_type" required class="select2 form-control" id="editm_type" <?=$type=='view'?'disabled':''?>>
	<option value="0" class="listClass">-----Section-----</option>
	<?php
	foreach ($categorySelectbox as $key => $dt) { ?>
	<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" <?php if($dt['id'] == $fetch_list->m_type){ ?> selected <?php } ?>> <?=$dt['name'];?></option>
	<?php } ?>
</select>
            
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">*Machine Name:</label> 
<div class="col-sm-4"> 
<input name="machine_name" id="editmachine_name" type="text" value="<?php echo $fetch_list->machine_name; ?>" class="form-control" required <?=$type=='view'?'disabled':''?>> 
</div> 
<label class="col-sm-2 control-label">Capacity:</label> 
<div class="col-sm-4" id="regid"> 
<input type="text" name="capacity" id="editcapacity" value="<?php echo $fetch_list->capacity; ?>" class="form-control" <?=$type=='view'?'disabled':''?>>
</div>
</div>


<div class="form-group"> 
<label class="col-sm-2 control-label">*Metering Unit:</label> 
<div class="col-sm-4"> 
	  <select name="m_unit" required class="select2 form-control" id="m_unit" <?=$type=='view'?'disabled':''?> style="width:100%;">
			<option value="" >----Select----</option>
			<?php 
				$sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
				foreach ($sqlunit->result() as $fetchunit){
			?>
			<option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetchunit->serial_number == $fetch_list->m_unit){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
				<?php } ?>
	 </select>
	<span id="err_unit1"></span>
</div> 
<label class="col-sm-2 control-label">*Machine Description:</label> 
<div class="col-sm-4" id="regid"> 
<textarea name="machine_des" id="editmachine_des" class="form-control" <?=$type=='view'?'disabled':''?>> 
<?php echo $fetch_list->machine_des; ?>
</textarea> 
</div>  
</div>
</div>


<div class="modal-footer">
<?php if($type != "view") { ?>
<input type="button" class="btn btn-sm" id="editButton" value="Save"  onclick="editData()">
<?php } ?>
<span id="saveload" style="display: none;">
<img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
</span>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>
