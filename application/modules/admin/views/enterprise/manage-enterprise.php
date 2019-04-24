<?php
$this->load->view("header.php");
$this->load->view("javascriptPage.php");
require_once(APPPATH.'modules/admin/controllers/enterprise.php');
$objj=new Enterprise();
$CI =& get_instance();

	

$list='';

$list=$objj->enterprice_list();	
require_once(APPPATH.'core/my_controller.php');
$obj=new my_controller();
$CI =& get_instance();
$tableName='tbl_enterprise_mst';

?>
	 <!-- Main content -->
	 <div class="main-content">
			
			<ol class="breadcrumb breadcrumb-2"> 
				
<?php				if($add!='')
{ ?>
<li><a class="btn btn-success" href="<?=base_url();?>admin/enterprise/add_enterprise">Add Enterprise</a></li> 
<?php }?><li>
				<a type="button" class="btn btn-danger delete_all">Delete Selected</a>
			</li>
				
			</ol>
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				 <li><a href="#">Enterprise</a></li> 
				<li class="active"><strong><a href="#">Manage Enterprise</a></strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h4 class="panel-title"><strong>Manage Enterprise</strong></h4>
							<ul class="panel-tool-options"> 
								
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								
							</ul>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
		<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
 		<th>Company ID</th>
        <th>Enterprise Code</th>
		<th>Enterprise Name</th>
        <th>Action</th>
</tr>
</thead>

<tbody>
<?php
	for($i=0,$j=1;$i<count($list);$i++,$j++)
	{
		$compId= $list[$i]['1'];
		$checkEnterPrice= $obj->enterPriceCheck($compId);
  ?>

<tr class="gradeC record" data-row-id="<?=$list[$i]['1'];?>">
<th>
<?php
if($checkUser= $obj->userCheck($compId)=='1')
		{
		?>
   <input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?=$list[$i]['1'];?>" value="<?=$list[$i]['1'];?>" />
    <?php } else{
	?>
	<spam data-id="" title="User Role already created for this User.you can not delete ?"   />*</spam>
	
<?php } ?>
</th> 
<th><?=$list[$i]['1'];?></th>
<th><?=$list[$i]['2'];?></th>
<th><?=$list[$i]['3'];?></th>
<th>
<?php if($view!='')
{ ?>
	<a href="#" onClick="openpopup('add_enterprise',1200,500,'view',<?=$list[$i]['1'];?>)"><i class="glyphicon glyphicon-zoom-in"></i></a>
	&nbsp;&nbsp;&nbsp;
<?php 
} 
if($edit!='')
{ ?>
	<a href="#" onClick="openpopup('add_enterprise',1200,500,'id',<?=$list[$i]['1'];?>)"><i class="glyphicon glyphicon-pencil"></i></a>
<?php }
if($delete!='')
{
	if($checkEnterPrice=='1')
	{
	$pri_col='comp_id';
	$table_name='tbl_enterprise_mst';
	?>
	&nbsp;&nbsp;&nbsp;
	<a href="#" id="<?php echo $list[$i]['1']."^".$table_name."^".$pri_col ; ?>" class="delbutton icon"><i class="glyphicon glyphicon-remove"></i></a> 
	<?php
	}
	else
	{?>
		<a href="#" onclick="return confirm('Region already Created for this Enterprice.you can not delete ?');" class="icon"><i class="glyphicon glyphicon-remove"></i></a> 
	<?php 
	} 
} ?>

</th>
</tr>
<?php } ?>

<input type="text" style="display:none;" id="table_name" value="tbl_enterprise_mst">  
<input type="text" style="display:none;" id="pri_col" value="comp_id">  
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<?php

$this->load->view("footer.php");
?>