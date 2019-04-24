<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
<thead>
<tr>
	<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
	<th>Code </th>
	<th>Section</th>
	<th>Machine Name</th>
	<th>Machine Description</th>
	<th>Capacity</th>
	<th>Action</th>
</tr>
</thead>

<tbody id = "getDataTable">	
<tr>
<form method="get">	
	<td>&nbsp;</td>
	<td><input name="codee"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="m_type"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="machine_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="machine_description"  type="text"  class="search_box form-control input-sm"  /></td>
	<td><input name="capacity"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
</form>	
</tr>
										
<?php  
/*echo "<pre>";
print_r($result);
echo "</pre>";*/

$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>
<th><?php echo $fetch_list->code; ?></th>
<th><?php 
	$sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->m_type."'");
	$compRow = $sqlunit->row();
	echo $compRow->name;
?>
</th>
<th><a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $fetch_list->id; ?>" title="Machine Spare Details"><?=$fetch_list->machine_name;?></a></th>
<th>
<div class="tooltip-col">
<?php 
   $big = $fetch_list->machine_des;  
$big = strip_tags($big);
$small = substr($big, 0, 20);
echo strtolower($small ."....."); ?>
<span class="tooltiptext3"><?=$big;?> </span>
</div>
</th>
<th><?=$fetch_list->capacity;?></th>

<th class="bs-example"><div style="width: 110px;">
<?php if($view!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Machine"> <i class="fa fa-eye"></i> </button>
 
<?php } if($edit!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Machine"><i class="icon-pencil"></i></button>

<?php }
$pri_col='id';
$table_name='tbl_machine';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Machine"><i class="icon-trash"></i></button>		

<button style="display:none" class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'>MAP SPARE</button>

</div>
</th>
</tr>

<?php  } ?>
</tbody>
</table>