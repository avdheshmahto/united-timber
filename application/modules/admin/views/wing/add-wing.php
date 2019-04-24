<?php
$this->load->view("header.php");
$tableName='tbl_wing_mst';
$location='manage_wing';
		
		$userQuery = $this -> db
           -> select('*')
		   -> where('divn_id',$_GET['id'])
		   -> or_where('divn_id',$_GET['view'])
           -> get('tbl_wing_mst');
		  $branchFetch = $userQuery->row();

?>
	<!-- Main content -->
	<div class="main-content">
		
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			
			<li><a class="btn btn-success" href="<?=base_url();?>admin/wing/manage_wing">Manage Department/Wing</a></li> 
			
		</ol>
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				 <li><a href="#">Department</a></li> 
				<li class="active"><strong><a href="#">Add Department</a></strong></li> 
			</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title"><strong>Update Department/Wing</strong></h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title"><strong>View Department/Wing</strong></h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Add Department/Wing</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<form class="form-horizontal" method="post" action="insert_wing">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Wing Code:</label> 
<div class="col-sm-4"> 
<input type="hidden" name="divn_id" value="<?php echo $branchFetch->divn_id; ?>" />
<input type="text" name="code" value="<?php echo $branchFetch->code?>" <?php if($_GET['view']!='') {?> readonly="" <?php }?> class="form-control" required> 
</div> 
<label class="col-sm-2 control-label">*Wing Name:</label> 
<div class="col-sm-4"> 
<input name="divn_name" type="text" placeholder="Placeholder" value="<?php echo $branchFetch->divn_name?>" class="form-control" <?php if($_GET['view']!='') {?> readonly="" <?php }?> required> 
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">*Branch Name:</label> 
<div class="col-sm-4"> 
<select name="brnh_id" class="form-control" value="<?php if(@$_GET['view']!='' or @$_GET['id']!=''){echo $branchFetch->brnh_id;}?>" maxlength="20" required aria-required='true' <?php if(@$_GET['view']!=""){ ?> disabled="disabled" <?php } ?>>
		<option value="">-----select----</option>
<?php
$comp_sql = $this->db->query("select * FROM tbl_branch_mst where status='A'");

foreach ($comp_sql->result() as $comp_fetch){

 ?>
		
<option value="<?php  echo @$comp_fetch->brnh_id;?>" <?php if(@$comp_fetch->brnh_id==@$branchFetch->brnh_id){ ?> selected="selected" <?php }?>><?php echo @$comp_fetch->brnh_name;?></option>

<?php } ?>



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
       <a href="<?=base_url();?>admin/wing/manage_wing" class="btn btn-blue">Cancel</a>

       <?php } ?>

</div>
</div>
<script>
function region_fun(){
var contactid=document.getElementById("comp_id").value;
var pro=contactid;
 var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "getregion?zone_id="+pro, false);
  xhttp.send();
  document.getElementById("regid").innerHTML = xhttp.responseText;
} 
</script>
</form>
</div>
</div>
</div>
</div>
<?php
$this->load->view("footer.php");

?>