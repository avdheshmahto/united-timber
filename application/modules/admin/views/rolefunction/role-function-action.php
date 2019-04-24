<?php
$this->load->view("header.php");
$tableName='tbl_role_func_action';
$location='role_function_action';
		
		/*$userQuery = $this -> db
           -> select('*')
		   -> where('brnh_id',$_GET['id'])
		   -> or_where('brnh_id',$_GET['view'])
           -> get('tbl_branch_mst');
		  $branchFetch = $userQuery->row();*/

?>
	<!-- Main content -->
	<div class="main-content">
	<div class="panel-default">	
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				
				<li class="active"><strong><a href="#">Role Function Action</a></strong></li> 
				<div class="pull-right">
				<a class="btn btn-sm" href="<?=base_url();?>admin/rolefunction/role_function_action">Role Function Action</a>
				</div>
			</ol>
		
		
<div class="row">
<div class="col-lg-12">
<div class="panel-body">

<h4 class="panel-title heading"><strong>Add Role Function Action</strong></h4>

<form class="form-horizontal" method="post">
<div class="form-group"> 
<label class="col-sm-2 control-label">Role</label> 
<div class="col-sm-3"> 
<select name="role_id" id="role_id" class="select2 form-control">

<option value="">--Select--</option>

<?php
		  $sqlrole = $this -> db
           -> select('*')
           -> where('status','A')
           -> get('tbl_role_mst');
		   
foreach (@$sqlrole->result() as $role_fetch){
 ?>
<option value="<?php echo @$role_fetch->role_id ; ?>"><?php echo @$role_fetch->role_name ; ?></option>
<?php } ?>
</select>
</div>
<label class="col-sm-2 control-label">Module</label> 
<div class="col-sm-3"> 
<select class="select2 form-control" name="module_id" id="module_id">
<option value="">--Select--</option>
<?php
 		   $sqlmodule = $this -> db
           -> select('*')
           -> where('status','A')
           -> get('tbl_module_mst');
		   
foreach (@$sqlmodule->result() as $module_fetch){
 ?>
<option value="<?php echo @$module_fetch->module_id; ?>"><?php echo @$module_fetch->module_name ; ?></option>
<?php } ?>
</select> 
</div>
<label class="col-sm-2 control-label"><button type="submit" name="Show" class="btn btn-sm" value="Show">Show</button></label>  
</div>
</form>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<h4 class="panel-title heading"><strong>View Role Function Action</strong></h4>
<div class="panel-body">
<div class="form-group">
<label class="col-sm-4 control-label"><strong style="font-size:14px;margin: 0px 0px 0px -15px;">Module Name</strong></label>
<label class="col-sm-6 control-label"><strong style="font-size:14px">Status</strong></label>
</div>
<br />
<br />

<form class="form-horizontal" id="form_id" name="form_id" method="post">
 <?php 
 
extract(@$_POST);
  if(@$Show!='')
  {
    $mod_sql= $this->db
	-> select('*')
	-> where('module_name',$module_id,'status','A')
	-> get('tbl_module_function');

	foreach (@$mod_sql->result() as $line)
			{
			
    $sr= $this->db
	-> select('*')
	-> where('function_url',$line->func_id,'module_id',$module_id,'role_id',$role_id,'status','A')
	-> get('tbl_role_func_action');
	@$linesr=@$sr->row();			
	?>	
<div class="form-group"> 
<label class="col-sm-4 "><?php echo $line->function_name ;?></label> 
<div class="col-sm-6"> 
<select name="drid[]" class="form-control">
            <option value="Inactive" <?php if(@$linesr->action_id =='Inactive'){ echo "selected" ; } ?>>Inactive</option >
	<option value="Active" <?php if(@$linesr->action_id =='Active'){ echo "selected";} ?> >Active</option>
	</select>
	<input name="cid[]" type="hidden" value="<?php echo @$line->func_id ;?>"/>
	
	<input name="module_id" type="hidden" value="<?php echo $module_id ;?>"/>
	<input name="role_id" type="hidden" value="<?php echo $role_id ;?>"/>
</div> 
</div>
<?php } } ?>
<div class="col-sm-8" style="margin: 20px 0px 0px 355px;">
<button type="button" class="btn btn-sm" onclick="myfunction()">Save</button>&nbsp;&nbsp;
<button type="submit" class="btn btn-secondary btn-sm">Cancel</button>
</div>
</form>
<br />
<br />
<script>
function myfunction() {
document.getElementById("form_id").action = "role_function_permision"; // Setting form action to "role_function_permision" page
document.getElementById("form_id").submit();
}
</script>

</div>
</div>
</div>
</div><!--panel-default close-->
</div><!--main-content close-->

<?php
$this->load->view("footer.php");

?>