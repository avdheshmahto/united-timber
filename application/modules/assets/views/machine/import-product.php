<?php
$this->load->view("header.php");
$tableName='tbl_product_stock';
$location='manage_item';
		
		$userQuery = $this -> db
           -> select('*')
		   -> where('Product_id',$_GET['id'])
		   -> or_where('Product_id',$_GET['view'])
           -> get('tbl_product_stock');
		  $branchFetch = $userQuery->row();

?>
	<!-- Main content -->
	<div class="main-content">
		
		<?php if(@$_GET['popup'] == 'True') {} else {?>
		<ol class="breadcrumb breadcrumb-2"> 
			
			<li><a class="btn btn-success" href="<?=base_url();?>master/Item/manage_item">Manage Product</a></li> 
			
		</ol>
		<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
				<li><a href="#">Master</a></li> 
				<li><a href="#">Product</a></li> 
				<li class="active"><strong><a href="#">Import Product</a></strong></li> 
			</ol>
		<?php }?>
		
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php if($_GET['id']!=''){ ?>
		<h4 class="panel-title">Update Product</h4>
		<?php }elseif($_GET['view']!=''){ ?>
		<h4 class="panel-title">View Product</h4>
		<?php }else{ ?> 
		<h4 class="panel-title"><strong>Import Product</strong></h4>
		<?php } ?>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<form action="import_item" method="post" enctype="multipart/form-data">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Import CSV:</label> 
<div class="col-sm-4"> 
	
			
<input type="hidden"  name="Product_id" value="<?php echo $branchFetch->Product_id; ?>" />
<input type="file" name="file" class="form-control" required> 
</div> 
<label class="col-sm-2 control-label">*Sample:</label> 
<div class="col-sm-4"> 
<a href="<?php echo base_url();?>assets/images/product_format.csv">Download Sample CSV Format</a>
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
       <a href="<?=base_url();?>master/Item/manage_item" class="btn btn-blue">Cancel</a>

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

<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
