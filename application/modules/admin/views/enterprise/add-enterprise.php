<?php
$this->load->view("header.php");
$tableName='tbl_enterprise_mst';
$location='manage_enterprise';
		
		$userQuery = $this -> db
           -> select('*')
		   -> where('comp_id',$_GET['id'])
		   -> or_where('comp_id',$_GET['view'])
           -> get('tbl_enterprise_mst');
		  $branchFetch = $userQuery->row();

?>
	<!-- Main content -->
	<div class="main-content">
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			
			<li><a class="btn btn-success" href="<?=base_url();?>admin/enterprise/manage_enterprise">Manage Enterprise</a></li> 
			
		</ol>
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				 <li><a href="#">Enterprise</a></li> 
				<li class="active"><strong><a href="#">Add Enterprise</a></strong></li> 
			</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
	<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title"><strong>Update Enterprise</strong></h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title"><strong>View Enterprise</strong></h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Add Enterprise</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<form class="form-horizontal" method="post" action="insert_enterprise">
<div class="form-group"> 
<label class="col-sm-2 control-label">* Enterprise Code:</label> 
<div class="col-sm-4"> 
<input type="hidden" name="comp_id" value="<?php echo $branchFetch->comp_id; ?>" />
<input type="text" name="code" value="<?php echo $branchFetch->code; ?>" <?php if($_GET['view']!='') {?> readonly="" <?php }?> class="form-control" required> 
</div> 
<label class="col-sm-2 control-label">* Enterprise Name:</label> 
<div class="col-sm-4"> 
<input name="comp_name" type="text" placeholder="Placeholder" value="<?php echo $branchFetch->comp_name; ?>" class="form-control" <?php if($_GET['view']!='') {?> readonly="" <?php }?> required> 
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
       <a href="<?=base_url();?>admin/enterprise/manage_enterprise" class="btn btn-blue">Cancel</a>

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