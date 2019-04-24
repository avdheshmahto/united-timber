<?php
$this->load->view("header.php");
require_once(APPPATH.'modules/admin/controllers/user.php');
require_once(APPPATH.'core/my_controller.php');
	$obj=new my_controller();
	$CI =& get_instance();





$objj=new user();
$CI =& get_instance();

$list='';

$list=$objj->user_list();	
require_once(APPPATH.'core/my_controller.php');
$obj=new my_controller();
$CI =& get_instance();
$tableName='tbl_user_mst';

?>
	 <!-- Main content -->
	 <div class="main-content">
			
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				
				<?php 
				if($add!='')
				{ ?>
				<li><a class="btn btn-success" href="<?=base_url();?>admin/user/add_user">Add User</a></li> 
				<?php }?>
				<li>
<a type="button" class="btn btn-danger delete_all">Delete Selected</a>
</li>

			</ol>
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				 <li><a href="#">User</a></li> 
				<li class="active"><strong><a href="#">Manage User</a></strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h4 class="panel-title"><strong>Manage User</strong></h4>
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
<th>User Name</th>
<th>Email Id</th>
<th>Phone</th>
<th>Company Name</th>
<th>Division Name</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php
  for($i=0,$j=1;$i<count($list);$i++,$j++)
  {
  
  
  
  
  
  
  $userid= $list[$i]['6'];



  ?>





<tr class="gradeC record" data-row-id="<?=$list[$i]['6'];?>">
<th>
<?php
if($checkUser= $obj->userCheck($userid)=='1')
		{
		?>
   <input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?=$list[$i]['6'];?>" value="<?=$list[$i]['6'];?>" />
    <?php } else{
	?>
	<spam data-id="" title="User Role already created for this User.you can not delete ?"   />*</spam>
	
<?php } ?>
</th> 
<th><?=$list[$i]['1'];?></th>
<th><?=$list[$i]['2'];?></th>
<th><?=$list[$i]['3'];?></th>
<th><?=$list[$i]['4'];?></th>
<th><?=$list[$i]['5'];?></th>
<?php

$pri_col='user_id';
$table_name='tbl_user_mst';
?>
<th>
<?php if($view!=''){ ?>
<a href="#" onClick="openpopup('add_user',1200,500,'view',<?=$list[$i]['6'];?>)"><i class="glyphicon glyphicon-zoom-in"></i></a> <?php }?>&nbsp;&nbsp;&nbsp; <?php  if($edit!=''){ ?><a href="#" onClick="openpopup('add_user',1200,500,'id',<?=$list[$i]['6'];?>)"><i class="glyphicon glyphicon-pencil"></i></a><?php }?> &nbsp;&nbsp;&nbsp;  <?php 
if($delete!=''){ 

if($checkUser= $obj->userCheck($userid)=='1')
{

	?>
<a href="#" id="<?php echo $list[$i]['6']."^".$table_name."^".$pri_col ; ?>" class="delbutton icon"><i class="glyphicon glyphicon-remove"></i></a> 
<?php
}
else
{

?>
<a href="#" onclick="return confirm('User Role already Created for this User.you can not delete ?');" class="icon"><i class="glyphicon glyphicon-remove"></i></a> 
<?php } } }?>
</tr>
<input type="text" style="display:none;" id="table_name" value="tbl_user_mst">  
<input type="text" style="display:none;" id="pri_col" value="user_id">   
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
