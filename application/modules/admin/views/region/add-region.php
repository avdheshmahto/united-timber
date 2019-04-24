<?php
$this->load->view("header.php");
$tableName='tbl_enterprise_mst';
$location='manage_enterprise';
		
		$userQuery = $this -> db
           -> select('*')
		   -> where('zone_id',$_GET['id'])
		   -> or_where('zone_id',$_GET['view'])
           -> get('tbl_region_mst');
		  $branchFetch = $userQuery->row();

?>
	<!-- Main content -->
	<div class="main-content">
		
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			
			<li><a class="btn btn-success" href="<?=base_url();?>admin/region/manage_region">Manage Region</a></li>
			 
			
		</ol>
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Admin Setup</a></li> 
				 <li><a href="#">Region</a></li> 
				<li class="active"><strong><a href="#">Add Region</a></strong></li> 
			</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title"><strong>Update Region</strong></h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title"><strong>View Region</strong></h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Add Region</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<form class="form-horizontal" method="post" action="insert_region">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Region Code:</label> 
<div class="col-sm-4"> 
<input type="hidden" name="zone_id" value="<?php echo $branchFetch->zone_id; ?>" />
<input type="text" name="code" value="<?php echo $branchFetch->code; ?>" <?php if($_GET['view']!='') {?> readonly="" <?php }?> class="form-control" required> 
</div> 
<label class="col-sm-2 control-label">*Region Name:</label> 
<div class="col-sm-4"> 
<input name="zone_name" type="text" placeholder="Placeholder" value="<?php echo $branchFetch->zone_name; ?>" class="form-control" <?php if($_GET['view']!='') {?> readonly="" <?php }?> required> 
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">*Enterprise:</label> 
<div class="col-sm-4"> 
<select name="comp_id" class="form-control" required <?php if(@$_GET['view']!=''){ ?>disabled <?php } ?>>
<option value="">--select--</option>
<?php
@$comp_sql = $this->db->query("SELECT * FROM tbl_enterprise_mst");
foreach (@$comp_sql->result() as $comp_fetch){

 ?>

<option value="<?php echo @$comp_fetch->comp_id;?>" <?php if(@$_GET['id']!='' || @$_GET['view']!=''){ if(@$comp_fetch->comp_id==@$branchFetch->comp_id){ ?> selected <?php }}?>><?php echo @$comp_fetch->comp_name;?></option>

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
       <a href="<?=base_url();?>admin/region/manage_region" class="btn btn-blue">Cancel</a>

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