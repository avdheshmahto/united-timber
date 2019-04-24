<?php
$this->load->view("header.php");
require_once(APPPATH.'modules/admin/controllers/mapuser.php');
$objj=new Mapuser();
$CI =& get_instance();

$list='';

$list=$objj->userroll_list();	
require_once(APPPATH.'core/my_controller.php');
$obj=new my_controller();
$CI =& get_instance();
$tableName='tbl_user_role_mst';

?>
	 <!-- Main content -->
	 <div class="main-content">
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a class="btn btn-success"  href="<?=base_url();?>master/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
				<?php 
				if($add!='')
				{ ?> 
				<li><a class="btn btn-success" href="<?=base_url();?>admin/mapuser/map_user_role">Add User Role</a></li> 
				<?php }?>
				
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
							<h4 class="panel-title"> <strong>Manage User Role</strong></h4>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
		<th>User Name</th>
		<th>Role Name</th>
        <th>Action</th>
</tr>
</thead>

<tbody>
<?php
  for($i=0,$j=1;$i<count($list);$i++,$j++)
  {
  ?>

<tr class="gradeC record">
<th><?=$list[$i]['1'];?></th>
<th><?=$list[$i]['2'];?></th>

<th>
<a href="#" onClick="openpopup('map_user_role',1200,500,'view',<?=$list[$i]['3'];?>)"><i class="glyphicon glyphicon-zoom-in"></i></a>&nbsp;&nbsp;&nbsp;<a href="#" onClick="openpopup('map_user_role',1200,500,'id',<?=$list[$i]['3'];?>)"><i class="glyphicon glyphicon-pencil"></i>
<?php
$pri_col='divn_id';
$table_name='tbl_user_role_mst';
	?>
	&nbsp;&nbsp;&nbsp;<a href="#" id="<?php echo $line->divn_id."^".$table_name."^".$pri_col ; ?>" class="delbutton icon"><i class="glyphicon glyphicon-remove"></i></a> 
	
</th>
</tr>
<?php } ?>
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