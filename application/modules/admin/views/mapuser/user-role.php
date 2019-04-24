<?php
$this->load->view("header.php");
$tableName='tbl_user_role_mst';
$location='mapped_user_role';
		
		$userQuery = $this -> db
           -> select('*')
		   -> where('user_role_id',$_GET['id'])
		   -> or_where('user_role_id',$_GET['view'])
           -> get('tbl_user_role_mst');
		  $branchFetch = $userQuery->row();

?>
	<!-- Main content -->
	<div class="main-content">
		
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			<li><a class="btn btn-success" href="<?=base_url();?>master/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
			<li><a class="btn btn-success" href="<?=base_url();?>admin/mapuser/mapped_user_role">Manage User Role</a></li> 
			
		</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title"><strong>Update User Role</strong></h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title"><strong>View User Role</strong></h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Add User Role</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<form class="form-horizontal" method="post" action="insert_user_role">
<div class="form-group"> 
<label class="col-sm-2 control-label">*User Name:</label> 
<div class="col-sm-4"> 
<input type="hidden" name="user_role_id" value="<?php echo $branchFetch->user_role_id; ?>" />
<select  placeholder="Enter text" class="form-control" name="user_id" required <?php if($_GET['view']!=''){?>disabled<?php } ?>>

<option value="">--Select--</option>
<?php
 $user=$this->db->query("select * from tbl_user_mst");

foreach ($user->result() as $user_add){
?>
<option value="<?php echo $user_add->user_id;?>" <?php if($_GET['id']!='' || $_GET['view']!=''){ if($user_add->user_id==$branchFetch->user_id){ ?> selected <?php }}?>><?php echo $user_add->user_name;?>(<?php echo $user_add->user_id ?>)</option>
<?php }?>
</select>
</div> 
<label class="col-sm-2 control-label">*Role Name:</label> 
<div class="col-sm-4"> 
<select  placeholder="Enter text" class="form-control" name="role_id" required <?php if($_GET['view']!=''){?>disabled<?php } ?>>

<option value="">--Select--</option>
<?php
$ro= $this->db->query("select * from tbl_role_mst");
	foreach ($ro->result() as $role){
?>
<option value="<?php echo $role->role_id;?>" <?php if($_GET['id']!='' || $_GET['view']!=''){ if($role->role_id==$branchFetch->role_id){ ?> selected <?php }}?>><?php echo $role->role_name;?>(<?php echo $role->role_id;?>)</option>
<?php }?>
</select>
</div> 
</div>
<div class="form-group">
<div class="col-sm-4 col-sm-offset-2">
<?php if(@$_GET['popup'] == 'True') {
if($_GET['id']!=''){
?>
<input type="submit" class="btn btn-primary" value="Save">
<?php } ?>
<a href="" onclick="popupclose(this.value)"  title="Cancel" class="btn btn-blue"> Cancel</a>

	   	 <?php }else {  ?>
		 
		<input type="submit" class="btn btn-primary" value="Save">
       <a href="<?=base_url();?>admin/mapuser/mapped_user_role" class="btn btn-blue">Cancel</a>

       <?php } ?>

</div>
</div>
</form>
</div>
</div>
</div>
</div>
<?php
$this->load->view("footer.php");

?>