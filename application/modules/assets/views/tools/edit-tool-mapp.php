<?php
$ID=$_GET['ID'];
//echo $type;
?>
<div class="modal-content">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php if($type=='view')
{?>
<h4 class="modal-title">View Tool</h4>
<?php }if($type=='edit'){?>
<h4 class="modal-title">Update Tool</h4>
<?php } ?>
<div id="resultarea1" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
<?php
	$ItemQuery=$this->db->query("select * from tbl_product_stock where Product_id='$ID'");
    $fetch_list=$ItemQuery->row();
?>

<div class="modal-body overflow">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Serial Number:</label> 
<div class="col-sm-4"> 	
<input type="hidden" class="hiddenField" name="Product_id" id="Product_id" value="<?=$ID;?>" />
<input type="text" class="form-control" name="sku_no" id="sku_no" value="<?php echo $fetch_list->sku_no; ?>" <?=$type=='view'?'disabled':''?>> 
</div> 
<label class="col-sm-2 control-label">*Tool Name:</label> 
<span id="spare_name"></span>
<div class="col-sm-4"> 
<input name="item_name"  type="text" id="item_name" value="<?php echo $fetch_list->productname; ?>" <?=$type=='view'?'disabled':''?> class="form-control"> 
</div> 
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Type Of Tool:</label> 
<div class="col-sm-4" id="regid"> 
<select name="type_of_spare" required class="form-control" <?=$type=='view'?'disabled':''?> id="type_of_spare">
	<option value="" >----Select ----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id=26");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetch_list->type_of_spare == $fetchunit->serial_number){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
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
<span id="err_unit1"></span>           
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">*Usages Unit:</label> 
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
<span id="err_unit1"></span>           
</div> 
<label class="col-sm-2 control-label">*Purchase Price:</label> 
<div class="col-sm-4" id="regid"> 
<input type="number" step="any" name="unitprice_purchase" <?=$type=='view'?'disabled':''?> id="unitprice_purchase" value="<?php echo $fetch_list->unitprice_purchase; ?>" class="form-control" required>
</div> 
</div>





<div class="table-responsive">
<?php if($type != "view"){ ?>
<INPUT type="button" value="Add Row" class="btn btn-primary "   onclick="addRow_edit('dataTable_edit')" />

	<INPUT type="button" class="btn btn-danger delete_other"   value="Delete Row" onclick="deleteRow_edit('dataTable_edit')" />
	<?php } ?>
<table class="table table-striped table-bordered table-hover" id="dataTable_edit" >
<tbody>
<tr class="gradeA">
<?php if($type != "view"){ ?>
<th> check </th>
	<?php } ?>
<th>Location</th>
<th>Rack</th>
<th >Quantity</th>
<?php if($type != "view"){ ?>
<th>Action</th>
<?php } ?>
<?php

	$m=0;
	 $ItemQuery=$this->db->query("select * from tbl_product_serial_log where product_id='$ID'");
         foreach($ItemQuery->result() as $fetch_list_map){

?>

</tr>
<tr class="gradeC" data-row-id="<?php echo $fetch_list_map->serial_number; ?>">
<?php if($type != "view"){ ?>

	
<th >
   <input type="checkbox" name="chkbox[]" class="sub_chk" id="chk1"  data-id="<?php echo $fetch_list_map->serial_number; ?>"  />
</th>
<?php } ?>

<th>
<input type="hidden"  name="id" value="<?php echo $_GET['id']; ?>" />

<select name="location[]" id="cat_idd<?=$m+1;?>"  class="form-control" <?=$type=='view'?'disabled':''?> onChange="getCatt(this.id)">

	<option value=""selected disabled>----Select ----</option>
				<?php 
					$sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
					foreach ($sqlgroup->result() as $fetchgroup){						
				?>					
    <option value="<?php echo $fetchgroup->serial_number; ?>"<?php if($fetch_list_map->loc == $fetchgroup->serial_number){ ?> selected <?php } ?>><?php echo $fetchgroup->keyvalue; ?></option>
    <?php } ?>
</select> 

</th>

<th>


<select name="rack[]" id="div_cat_idd<?=$m+1;?>" class="form-control" <?=$type=='view'?'disabled':''?> >
<option value=""selected disabled>----Select ----</option>
<?php
$queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A'");
foreach($queryMainLocation1->result() as $getMainLocation1){
?>
<option value="<?php echo $getMainLocation1->id;?>"<?php if($fetch_list_map->rack_id == $getMainLocation1->id){ ?> selected <?php } ?>><?=$getMainLocation1->rack_name;?>

</option>
<?php }?>

</select>
</th>



<th >
<input type="number" step="any"  value="<?php echo $fetch_list_map->quantity; ?>" id="qtyy"  name="qtyy[]"  <?=$type=='view'?'disabled':''?>  class="form-control"> 
</th>
<?php if($type != "view"){ ?>
<th>
<!--<INPUT type="button" class="btn btn-danger" value="Deleteww Row" onclick="deleteselectrow(delt.id,delt)" />-->
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
<input type="submit" class="btn btn-sm"  value="Save">
<?php } ?>
<!-- <a class="btn btn-sm" style="padding:4px;" editvalue=""  submit_value = "save" id="itemSave"> Save </a> -->
<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>
</form>
</div><!-- /.modal-content -->
