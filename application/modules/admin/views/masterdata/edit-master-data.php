<?php
$ID=$_GET['ID'];
//echo $type;
?>

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

<?php if($type=='view')
{?>
<h4 class="modal-title">View Master Data</h4>
<?php }if($type=='edit'){?>
<h4 class="modal-title">Update Master Data</h4>
<?php } ?>
</div>

</div>


<?php $query=$this->db->query("select * from tbl_master_data where  serial_number = '$ID' and status='A' ");
	$fetch_list=$query->row();
	

 ?>
 <div class="modal-body overflow">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Value Name:</label> 
<div class="col-sm-4"> 				
		
<input type="hidden" name="id" value="<?php echo $fetch_list->serial_number; ?>"  />
<select name="param_id" class="form-control" <?=$type=='view'?'disabled':''?> >
<option value="">----Select----</option>
<?php 
$comp_sql = $this->db->query("select * FROM tbl_master_data_mst where status='A'");

foreach ($comp_sql->result() as $comp_fetch){
?>
<option value="<?php echo $comp_fetch->param_id;?>"<?php if($comp_fetch->param_id==$fetch_list->param_id){?>selected<?php }?>><?php echo @$comp_fetch->keyname;?></option>
<?php } ?>
</select>
</div> 
<label class="col-sm-2 control-label">*Key Value</label> 
<div class="col-sm-4"> 
<input name="keyvalue"  type="text" value="<?=$fetch_list->keyvalue;?>" class="form-control" <?=$type=='view'?'disabled':''?> > 
</div> 
</div>


<div class="form-group"> 
<label class="col-sm-2 control-label">Description:</label> 
<div class="col-sm-4"> 
<textarea class="form-control" name="description" <?=$type=='view'?'disabled':''?> ><?=$fetch_list->description;?></textarea>
</div>  
</div>

</div>
<div class="modal-footer">
<?php if($type != "view"){ ?>
<input type="submit" class="btn btn-sm" data-dismiss="modal1" value="Save"  >
<?php } ?>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>

</div><!-- /.modal-content -->
