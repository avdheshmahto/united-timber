<?php

$ID=$_GET['ID'];
//echo $type;
?>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php if($type=='view')
{?>
<h4 class="modal-title">View Location</h4>
<?php }if($type=='edit'){?>
<h4 class="modal-title">Update Location</h4>
<?php } ?>
<div id="operationarea" style="color: red;text-align: center;font-size:12px"></div>
</div>
<?php
	 $ItemQuery=$this->db->query("select * from tbl_location_rack where id='$ID'");
         $fetch_list=$ItemQuery->row();

?>
<div class="modal-body overflow">
<div class="form-group"> 

<label class="col-sm-2 control-label">*Location Name:</label> 

<input type="hidden" name="id" value="<?=$ID;?>" />
<div class="col-sm-4"> 
	
			<select style="display:none" name="location_id"  class="form-control"   >
	
	<?php 
						$sqlloc=$this->db->query("select * from tbl_location");
						foreach ($sqlloc->result() as $fetchloc){
							
					?>
					
	<option value="<?php echo $fetchloc->id; ?>" <?php if($branchFetch->location_id==$fetchloc->id){ ?> selected <?php } ?>><?php echo $fetchloc->location_name; ?></option>
<?php } ?>	
</select>

<select name="location_rack_id" id="location_rack_id" required class="form-control ui fluid search dropdown" <?=$type=='view'?'disabled':''?> onchange="Validatehide();validationfunc();"> 
						<option value="">----Select ----</option>
					<?php 
						$sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
						foreach ($sqlgroup->result() as $fetchgroup){						
					?>					
    <option value="<?php echo $fetchgroup->serial_number; ?>" <?php if($fetchgroup->serial_number==$fetch_list->location_rack_id){?> selected="selected" <?php }?>><?php echo $fetchgroup->keyvalue; ?></option>

    <?php } ?></select> 
<div id="Location_Validation" style="color: red;font-size: 12px"></div>

</div> 
<label class="col-sm-2 control-label">*Rack Name:</label> 
<div class="col-sm-4"> 
<input name="rack_name"  type="text" value="<?php echo $fetch_list->rack_name; ?>" class="form-control" required  <?=$type=='view'?'disabled':''?> onkeyup="validationfunc();" id="rack_name"> 
</div> 
</div>

<!--============================================================-->

<!--===========================================================-->






</div>
<div class="modal-footer">
<?php if($type != "view"){ ?>
<input type="submit" class="btn btn-sm" data-dismiss="modal1" value="Save">
<?php } ?>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>