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
</div>
<?php
	 $ItemQuery=$this->db->query("select * from tbl_master_data where param_id = '21' and serial_number='$ID'");
         $fetch_list=$ItemQuery->row();

?>
<div class="modal-body overflow">
<div class="form-group"> 

<label class="col-sm-2 control-label">*Location Name:</label> 
<div class="col-sm-4"> 
<input name="loc_name"  type="text" value="<?php echo $fetch_list->keyvalue; ?>" class="form-control" required  <?=$type=='view'?'disabled':''?>> 
<input type="hidden"  name="id" value="<?php echo $ID; ?>" />
</div> 
</div>

<!--============================================================-->

<!--===========================================================-->






</div>
<div class="modal-footer">
<?php if($type != "view"){ ?>
<input type="submit" class="btn btn-sm" data-dismiss="modal1" value="Save" onclick="editData()">
<?php } ?>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>