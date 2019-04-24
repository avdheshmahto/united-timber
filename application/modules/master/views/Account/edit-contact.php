
<div class="col-lg-12">
<div class="panel panel-default">

<!-- /.panel-heading -->
<div class="panel-body">
<div class="row">
<div class="col-sm-12">
<ol class="breadcrumb"> 
<li class="active">Manage Contact</li> 
</ol>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
  <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
  <a class="btn btn-sm" data-toggle="modal" formid = "#contactForm" data-target="#Contactmodal" id="formreset" title="Add Contact">Add Contact</a>
  <a class="btn btn-secondary btn-sm delete_all" title="Delete Multiple"><span>Delete</span></a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>master/Account/manage_contact?<?='first_namee='.$_GET['first_namee'].'&maingroupname='.$_GET['maingroupname'].'&emailee='.$_GET['emailee'].'&mobile='.$_GET['mobile'].'&phone='.$_GET['phone'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">

	<option value="10">10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>

</select>
entries</label>

<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="    margin-top: -5px;margin-left: 12px;float: right;">
	Showing <?=$dataConfig['page']+1;?> to 
	<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
	?> of <?php echo $dataConfig['total'];?> entries
</div>
</div>
<div id="DataTables_Table_0_filter" class="dataTables_filter" >
<label>Search:
<input type="text" class="form-control input-sm" id="searchTerm"  onkeyup="doSearch()" placeholder="What you looking for?">
</label>
</div>
</div>
</div>
</div>
<!--row close-->

<div class="row">
<div class="col-lg-12">
<div class="table-responsive">
<!--<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data">-->											
<table class="table table-striped table-bordered table-hover dataTables-example11" id="loadData">
<thead bgcolor="#CCCCCC">
<tr>
		<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
	    <th>Name</th>
		<th>Group Name</th>
        <th>Email Id</th>
		<th>Mobile No.</th>
		<th>Phone No.</th>
		<th style="width:110px;">Action</th>
</tr>
</thead>

<tbody id="getDataTable">
<tr>
		<form method="get">
		<th>&nbsp;</th>
		<th><input name="first_namee"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="maingroupname"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="emailee"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="mobile"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="phone" type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><button type="submit" class="btn btn-sm" name="filter" value="filter" style="margin:0 0 0 0px;" title="Search"><span>Search</span></button></th>
		</form>
</tr>


<?php

$i=1;
  foreach($result as $fetch_list)
  {

  ?>

<tr class="gradeC record" data-row-id="<?php echo $fetch_list->contact_id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->contact_id; ?>" value="<?php echo $fetch_list->contact_id;?>" /></th>
<th>
<?php if($fetch_list->group_name=='5'){ ?>
<a href="<?=base_url();?>master/Account/manage_contact_map?id=<?php echo $fetch_list->contact_id; ?>" title="contact Details"><?php echo $fetch_list->first_name; ?></a>
<?php }else{ ?>
<?php echo $fetch_list->first_name; ?>
<?php } ?>
</th>

<?php
  $contactQuery=$this->db->query("select *from tbl_account_mst where account_id='$fetch_list->group_name'");
  $getContact=$contactQuery->row();
?>

<th><?=$getContact->account_name;?></th>

<th><?=$fetch_list->email;?></th>

<th><?=$fetch_list->mobile;?></th>
<th><?=$fetch_list->phone;?></th>

<th>
<?php if($view!=''){ ?>
<!-- <button class="btn btn-default" property="view" type="button" data-toggle="modal" data-target="#Contactmodal" arrt= '<?=json_encode($fetch_list);?>' onclick="editContact(this);" data-backdrop='static' data-keyboard='false' title="View Contact"> <i class="fa fa-eye"></i> </button> -->
<?php } if($edit!=''){ ?>
<button class="btn btn-default" property=""  data-target="#Contactmodal" data-a="<?=$fetch_list->contact_id;?>"  arrt= '<?=json_encode($fetch_list);?>' onclick="editContact(this);" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Contact"><i class="icon-pencil"></i>
</button>
<?php }
$pri_col='contact_id';
$table_name='tbl_contact_m';
	?>
<button class="btn btn-default delbutton"  id="<?php echo $fetch_list->contact_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Contact"><i class="icon-trash"></i>
</button>	
</th>
</tr>
<?php  $i++; } ?>
</tbody>
<input type="text" style="display:none;" id="table_name" value="tbl_contact_m">  
<input type="text" style="display:none;" id="pri_col" value="contact_id">
</table>

<form class="form-horizontal" role="form"  id="priceMapSpare" style="margin-bottom:0px;">
<div id="modal-1" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div id="sparemapping_price">

        </div>
    </div>	 
</div>
</form>

<div class="row">
  <div class="col-md-12 text-right">
    <div class="col-md-6 text-left"> 
   	  </div>
    	  <div class="col-md-6"> 
             <?php echo $pagination; ?>
          </div>
     </div>
</div>
   
</div>
</div>
</div>


</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
