<div class="panel-body">
<div class="row">
<div class="col-sm-12">
<ol class="breadcrumb"> 
<li class="active">Manage Parts & Supplies</li> 
</ol>
</div>
</div>

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('getDataTable')" title="Excel">Excel</button>
<a class="btn btn-sm" data-toggle="modal"  formid = "#ItemForm" data-target="#modal-0" id="formreset" title="Add Spare" onclick="sparerowdel();"><i class="fa fa-arrow-circle-left"></i> Add Parts & Supplies</a>
<a class="btn btn-secondary btn-sm delete_all" title="Multiple Delete" ><span><i class="fa fa-trash-o"></i> Delete</span></a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>master/Item/manage_item?<?='sku_no='.$_GET['sku_no'].'&category='.$_GET['category'].'&productname='.$_GET['productname'].'&usages_unit='.$_GET['usages_unit'].'&purchase_price='.$_GET['purchase_price'].'&type_of_spare='.$_GET['type_of_spare'].'&filter='.$_GET['filter'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">

		<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
		<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
		<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
		<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
		<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
		<option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
		<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>

</select>
entries</label>
<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -5px;margin-left: 12px;float: right;">
Showing <?=$dataConfig['page']+1;?> to 
<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
?> of <?=$dataConfig['total'];?> entries
</div>
</div>

<div id="DataTables_Table_0_filter" class="dataTables_filter">
	<label>Search:
	<input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
	</label>
</div>
</div><!--row close-->

<div class="table-responsive">			
<table class="table table-striped table-bordered table-hover dataTables-example_"  id="getDataTable">
<thead bgcolor="#CCCCCC">
<tr>
	<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
	<th>Code </th>
	<th>Type</th>
	<th>Sub-Type</th>	
	<th>Priority</th>
	<th>Name</th>
	<th>Usages Unit</th>
	<th>Purchase Price</th>
	<th>Quantity</th>
	<th><div style="width: 100px;"> Action</div></th>
</tr>
</thead>

<tbody id = "getDataTable">
	
<tr>
<form method="get">
	<td>&nbsp;</td>
	<td><input name="sku_no" type="text"  class="search_box form-control input-sm" value="" /></td>
	<td><input name="category" type="text"  class="search_box form-control input-sm" value="" /></td>
	<td><input name="type_of_spare" type="text" class="search_box form-control input-sm" value="" /></td>
	<td><input name="sub_type" type="text" class="search_box form-control input-sm" value="" /></td>
	<td><input name="productname" type="text" class="search_box form-control input-sm" value="" /></td>
	<td><input name="usages_unit" type="text" class="search_box form-control input-sm" value="" /></td>
	<td><input name="purchase_price" type="text" class="search_box form-control input-sm" value="" /></td>
	<td><input name="qtty" type="text"  class="search_box form-control input-sm" value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
</form>
</tr>	
	
<?php  
$i=1;
if($result != ""){
foreach($result as $fetch_list)
{
?>
<tr class="gradeC record" data-row-id="<?php echo $fetch_list->Product_id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->Product_id; ?>" value="<?php echo $fetch_list->Product_id;?>" /></th>
<?php
$queryType=$this->db->query("select *from tbl_master_data where serial_number='$fetch_list->type'");
$getType=$queryType->row();


?>

<th><?=$fetch_list->sku_no;?></th>


<th><?php $compQuery1 = $this -> db
		   -> select('*')
		   -> where('serial_number',$fetch_list->type_of_spare)
		   -> get('tbl_master_data');
		  $keyvalue1 = $compQuery1->row();
echo $keyvalue1->keyvalue;		  
?></th>
<th><?=$fetch_list->via_type;?></th>
<th><?php $compQuery1 = $this -> db
		   -> select('*')
		   -> where('serial_number',$fetch_list->priority)
		   -> get('tbl_master_data');
		  $keyvalue1 = $compQuery1->row();
echo $keyvalue1->keyvalue; ?></th>
 </th>
 
<?php 
$size=$this->db->query("select *from tbl_master_data where serial_number='$fetch_list->size'");
$psize=$size->row();
if($psize->keyvalue !='')
{
?>
<th><?php echo $fetch_list->productname .'   ( '.$psize->keyvalue .')' ; } else { ?></th>
<th>
<!-- <a class="modalMapSpare"   onclick="viewItem(<?=$fetch_list->Product_id;?>);"  data-toggle="modal" data-target="#modal-1" data-backdrop='static' data-keyboard='false'  id="formreset" title="View Machine Details"> -->
<a href="<?=base_url();?>master/Item/manage_item_map?id=<?php echo $fetch_list->Product_id; ?>" title="Spare Details"><?php echo $fetch_list->productname; } ?></a></th>

<th>
<?php
$compQuery1 = $this -> db
		   -> select('*')
		   -> where('serial_number',$fetch_list->usageunit)
		   -> get('tbl_master_data');
		  $keyvalue1 = $compQuery1->row();
echo $keyvalue1->keyvalue;		  


?></th>
<th><?=$fetch_list->unitprice_purchase?></th>
<th><?=$fetch_list->quantity?></th>
<th class="bs-example">
<?php if($view!=''){ ?>


<!-- <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->Product_id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->Product_id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Spare Details"><i class="fa fa-eye"></i></button> -->


<?php } if($edit!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->Product_id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->Product_id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Spare"><i class="icon-pencil"></i></button>


<?php }
$pri_col='Product_id';
$table_name='tbl_product_stock';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->Product_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Spare"><i class="icon-trash"></i></button>		
<?php
  ?>
 
 
 

 
</th>
</tr>

<?php $i++; }} ?>
</tbody>
<input type="text" style="display:none;" id="table_name" value="tbl_product_stock">  
<input type="text" style="display:none;" id="pri_col" value="Product_id">
</table>

</div>

<div class="row">
  <div class="col-md-12 text-right">
    <div class="col-md-6 text-left"> </div>
    <div class="col-md-6"> <?php echo $pagination; ?></div>
  </div>
</div>

</div>
</div>
</div>
</div>
<div id="modal-1" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		<button  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Machine Details</h4>
		<!-- <div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div>  -->
		</div>
        <div class="modal-body overflow"  id="viewData">
        </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
    </div>
</div>
</div>
</div>

</div><!-- /.panel-body -->
</div><!-- /.panel -->