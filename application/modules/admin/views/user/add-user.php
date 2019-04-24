<?php
$this->load->view("header.php");
$tableName='tbl_user_mst';
$location='manage_user';
$userQuery = $this->db->query("SELECT * FROM $tableName where status='A' and user_id='".$_GET['id']."' or user_id='".$_GET['view']."'");
$userFetch = $userQuery->row();
?>
	<!-- Main content -->
	<div class="main-content">
		
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			
			<li><a class="btn btn-success" href="<?=base_url();?>admin/user/manage_user">Manage User</a></li> 
			
		</ol>
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				<li><a href="#">User</a></li> 
				<li class="active"><strong><a href="#">Add User</a></strong></li> 
			</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title"><strong>Update User</strong></h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title"><strong>View User</strong></h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Add User</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<form class="form-horizontal" method="post" action="insert_user">
<div class="form-group"> 
<label class="col-sm-2 control-label">* User Name:</label> 
<div class="col-sm-4"> 
<input type="text" name="user_name" value="<?php echo $userFetch->user_name?>" <?php if($_GET['view']!='') {?> readonly="" <?php }?> class="form-control" required> 
</div> 
<label class="col-sm-2 control-label">*Password:</label> 
<div class="col-sm-4"> 
<input name="password" type="password" placeholder="Placeholder" value="<?php echo $userFetch->password?>" class="form-control" <?php if($_GET['view']!='') {?> readonly="" <?php }?> required> 
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">* Email :</label> 
<div class="col-sm-4"> 
<input name="email_id" type="email" class="form-control" <?php if(@$_GET['view']!=""){ ?> readonly <?php } ?> value="<?php  echo $userFetch->email_id;?>" > 
</div> 
<label class="col-sm-2 control-label">*Phone Number:</label> 
<div class="col-sm-4"> 

<input name="phone_no" type="number" class="form-control" value="<?php echo $userFetch->phone_no;?>" required <?php if(@$_GET['view']!=""){ ?> readonly <?php } ?>/>
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">*Company Name :</label> 
<div class="col-sm-4"> 
<select name="comp_id" class="form-control" id="comp_id"  onChange="getregion(this.value)" required <?php if($_GET['view']!=""){ ?> disabled="disabled" <?php } ?> >

<option value="">--Select--</option>

<?php
$comp_sql = $this->db->query("select * FROM tbl_enterprise_mst where status='A'");

foreach ($comp_sql->result() as $comp_fetch){

 ?>

<option value="<?php  echo @$comp_fetch->comp_id;?>" <?php if(@$comp_fetch->comp_id==@$userFetch->comp_id){ ?> selected="selected" <?php }?>><?php echo @$comp_fetch->comp_name;?></option>
<?php }?>
</select> 
</div> 
<label class="col-sm-2 control-label">*Zone Name:</label> 
<div class="col-sm-4"> 
<select name="zone_id" id="zone_id" onClick="getdata()" onchange="getBranch(this.value)"  class="form-control" required <?php if($_GET['view']!=""){ ?> disabled="disabled" <?php } ?>>

<option value="">--Select--</option>

<?php
$sqlzone = $this->db->query("select * FROM tbl_region_mst where status='A'");

foreach ($sqlzone->result() as $zone_fetch){

 ?>

<option value="<?php echo @$zone_fetch->zone_id;?>" <?php if(@$zone_fetch->zone_id==@$userFetch->zone_id){ ?> selected="selected" <?php }?> ><?php echo $zone_fetch->zone_name;?></option>

<?php } ?>

</select> 
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">*Branch Name:</label> 
<div class="col-sm-4"> 
<select name="brnh_id" id="branch_id" onClick="getdata()" class="form-control" onChange="getDivision(this.value)" required <?php if($_GET['view']!=""){ ?> disabled="disabled" <?php } ?>>

<option >--Select--</option>

<?php
$sqlBrnch = $this->db->query("SELECT * FROM tbl_branch_mst where status='A' and comp_id=comp_id='".$this->session->userdata('comp_id')."'");

foreach ($sqlBrnch->result() as $sqlBrcFetch){


 ?>

<option value="<?php echo @$sqlBrcFetch->brnh_id;?>" <?php if(@$sqlBrcFetch->brnh_id==@$userFetch->brnh_id){ ?> selected <?php }?>><?php echo @$sqlBrcFetch->brnh_name;?></option>

<?php } ?>

</select> 
</div> 
<label class="col-sm-2 control-label">*Division Name:</label> 
<div class="col-sm-4"> 
<select  placeholder="Enter text" onchange="getdata()" onClick="getdata()" class="form-control" name="divn_id"  id="divn_id" required <?php if($_GET['view']!=""){ ?> disabled="disabled" <?php } ?>>



<option value="">--Select--</option>

<?php

$sqlDiv = $this->db->query("select divn_id,divn_name from tbl_wing_mst where  status='A'");

foreach ($sqlDiv->result() as $sqlDivFetch){

?>

<option value="<?php echo @$sqlDivFetch->divn_id;?>" <?php if(@$sqlDivFetch->divn_id==@$userFetch->divn_id){ ?> selected <?php }?>><?php echo @$sqlDivFetch->divn_name;?></option>

<?php }?>

</select>
</div> 
</div>

<div class="form-group">
<div class="col-sm-4 col-sm-offset-2">
<?php if(@$_GET['view']== '') {?>
<input type="submit" class="btn btn-primary" value="Save">
<?php }?>

<?php if(@$_GET['popup'] == 'True') {?>

<a href="" onclick="popupclose(this.value)"  title="Cancel" class="btn btn-blue"> Cancel</a>

	   	 <?php }else {  ?>

       <a href="<?=base_url();?>admin/user/manage_user" class="btn btn-blue">Cancel</a>

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