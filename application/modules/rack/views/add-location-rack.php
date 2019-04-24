<?php
$this->load->view("header.php");

		$userQuery = $this -> db
           -> select('*')
		   -> where('id',$_GET['id'])
		   -> or_where('id',$_GET['view'])
           -> get('tbl_location_rack');
		  $branchFetch = $userQuery->row();

?>
	<!-- Main content -->
	<div class="main-content">
		
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			
			<li><a class="btn btn-success" href="<?=base_url();?>location/Location/manage_location">Manage Location</a></li> 
			
		</ol>
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Master</a></li> 
				<li><a href="#">Location</a></li> 
				<li class="active"><strong><a href="#">Add Location</a></strong></li> 
			</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title">Update Location</h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title">View Location</h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Add Location</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<?php echo $this->session->flashdata('message_name'); ?>
<form class="form-horizontal" id="myForm" name="myForm" method="post" action="insert_location_rack">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Main Location:</label> 
<div class="col-sm-4"> 
				
<input type="hidden"  name="id" value="<?php echo $_GET['id'] ?>" />
<select name="location_id"  class="form-control" required>
	<option value="">--select--</option>
	<?php 
						$sqlloc=$this->db->query("select * from tbl_location");
						foreach ($sqlloc->result() as $fetchloc){
							
					?>
					
	<option value="<?php echo $fetchloc->id; ?>" <?php if($branchFetch->location_id==$fetchloc->id){ ?> selected <?php } ?>><?php echo $fetchloc->location_name; ?></option>
<?php } ?>	
</select>
</div> 
<label class="col-sm-2 control-label">*Location Name:</label> 
<div class="col-sm-4"> 
<select name="location_rack_id"  class="form-control ui fluid search dropdown email"  <?php if(@$_GET['view']!=''){ ?> disabled="disabled" <?php }?> >
    <option value="">----Select ----</option>
    <?php
	$bookingType=$this->db->query("select *from tbl_master_data  where param_id='29'");
	foreach($bookingType->result() as $getBooking){
	?>
   <option value="<?=$getBooking->serial_number;?>" <?php if($getBooking->serial_number==$branchFetch->location_rack_id){?> selected <?php }?>><?=$getBooking->keyvalue;?></option>
   <?php }?>
  </select>

	

</div> 
</div>



<div class="form-group"> 
<label class="col-sm-2 control-label">*Rack Name:</label> 
<div class="col-sm-4"> 
				

<input name="rack_name"  class="form-control" value="<?=$branchFetch->rack_name;?>" required>
	
</div> 
<label class="col-sm-2 control-label">&nbsp;</label> 
<div class="col-sm-4"> 
&nbsp;

	
<input type="hidden" id="tableid" value="tbl_location_rack^id" />
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
		 
		 
		<input type="submit" class="btn btn-primary" value="Save" >
       <a href="<?=base_url();?>locationRack/manage_location_rack" class="btn btn-blue">Cancel</a>

       <?php } ?>

</div>
</div>
<script>
function validationfun(){	
	 var loc_id=document.getElementById("locationid").value;
	 var branch_id=document.getElementById("branchid").value;
	  var tableid=document.getElementById("tableid").value;		
	  var data=tableid+"^"+loc_id+"^"+branch_id;
   location.assign("<?=base_url();?>location/Location/formvalidation?con="+data);
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