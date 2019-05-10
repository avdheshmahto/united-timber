
<thead>
<tr>
   <th style="width:22px;"><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
   <th>Serial Number</th>	   
   <th>Location Name </th>
   <th style="width:110px;">Action</th>
</tr>
</thead>

<tbody id = "getDataTable">
<tr>
<form method="get">
	<td>&nbsp;</td>
	<td><input name="serial_no"  type="text"  class="search_box form-control input-sm"   value="" readonly="" style="background-color: white;" /></td>
	<td><input name="loc_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
</form>
</tr>

<form class="form-horizontal" method="post" action="update_item"  enctype="multipart/form-data">

<?php  
$i=1;
foreach($result as $fetch_list)  {
?>

<tr class="gradeC record" data-row-id="<?php echo $fetch_list->id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>


<th><?php echo ($dataConfig['page']+$i)?></th>
<th><?=$fetch_list->keyvalue;?></th>
<th class="bs-example">
<?php if($view!=''){ ?>


<button class="btn btn-default modalEditItem" property="view" attr='<?php echo json_encode($fetch_list)?>' onclick="editlocation(this);" href='#editlocation' type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Main Location"> <i class="fa fa-eye"></i> </button>

<?php } if($edit!=''){ ?>

<button class="btn btn-default modalEditItem" property="edit" attr='<?php echo json_encode($fetch_list)?>' onclick="editlocation(this);" href='#editlocation' type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Main Location"><i class="icon-pencil"></i></button>

<?php }
$pri_col='serial_number';
$table_name='tbl_master_data';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->serial_number."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Main Location"><i class="icon-trash"></i></button>		
<?php
 $i++;
 }
  ?>
 
</th>
</tr>

</form>
</tbody>
