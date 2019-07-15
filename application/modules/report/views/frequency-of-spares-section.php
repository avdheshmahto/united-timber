
<?php
$this->load->view("header.php");
$entries = "";
if($this->input->get('entries')!=""){
  $entries = $this->input->get('entries');
}


?>
<!-- Main content -->
<div class="main-content">

<?php
$this->load->view("reportheader");
?>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<?php 
$wo=$this->db->query("select * from tbl_category where id='".$_GET['id']."'");
$getWO=$wo->row(); ?>
<h4 class="panel-title">FREQUENCY OF SPARES (<?php echo $getWO->name; ?>) </h4>	
</div>

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  >
<thead>
<tr>

	<th>S. No.</th>
	<th>Parts & Supplies Name</th>
	<th>Frequency Count</th>
		
</tr>
</thead>

<tbody id="getDataTable" >

<?php
$sftcostlog=$this->db->query("select *,COUNT(product_id) as frequncyofspares from tbl_software_cost_log where section_id='".$_GET['id']."' AND machine_id='' AND log_type!='Labour' GROUP BY product_id");
$count=$sftcostlog->num_rows();
$z=1;
foreach($sftcostlog->result() as $fetch_list) {
?>
<tr class="gradeC record">
<th><?php echo $z++; ?></th>	
<th>
<?php
	$prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->product_id'");
	$getPrd=$prd->row();
	echo $getPrd->productname; ?>
</th>
<th><?php echo $fetch_list->frequncyofspares ;?></th>	 
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12 text-right">
	<div class="col-md-6 text-left"> 
	</div>
	<div class="col-md-6"> 
		<?php echo $pagination; ?>
	</div>
</div>
</div>

<?php
$this->load->view("footer.php");
?>
</div>







<script type="text/javascript">

var id1=document.getElementById("totalprice").value;
document.getElementById("section_total").value = id1;

</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">