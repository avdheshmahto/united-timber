
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
<h4 class="panel-title">WORKORDER MAINTENANCE DETAILS (<?php echo $getWO->name; ?>) </h4>	
</div>

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  >

<thead>
<tbody>
<th></th>
<th></th>
<th><a target="_blank" href="<?=base_url('report/Report/frequency_details_section?id=')?><?=$getWO->id?>" style="font-size: small;">Frequncy Of Spares</a></th>	
<th></th>	
<th>Section Total Amount =</th>
<th>
	<input type="text" name="section_total" id="section_total" class="form-control" style="width: 100px;" readonly=""/>
</th>
<th></th>
<th></th>
<th></th>
</tbody>
</thead>

<thead>
<tr>

	<th>S. No.</th>
	<th>Date</th>
	<th>Parts & Supplies Name</th>
	<th>Type</th>
	<th>Shift</th>
	<th>Price</th>
	<th>Qty</th>
	<th>Parts & Supplies Amount</th>
	<th>Labor Cost</th>
		
</tr>
</thead>

<tbody id="getDataTable" >

<tr style="display: none;">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<?php
$sftcostlog=$this->db->query("select * from tbl_software_cost_log where section_id='".$_GET['id']."' AND log_type!='Labour' AND machine_id='' ");
$count=$sftcostlog->num_rows();
if($count > 0)
{
	$count=$count;

$z=1;
$i=0;
foreach($sftcostlog->result() as $fetch_list) {
?>
<tr class="gradeC record">
<th><?php echo $z++; ?></th>	
<th><?php echo $fetch_list->log_date; ?></th>
<th>
<?php
	$prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->product_id'");
	$getPrd=$prd->row();
	echo $getPrd->productname; ?>
</th>
<th><?=$getPrd->via_type?></th>
<th><?=$fetch_list->shift;?></th>
<th><?php echo $fetch_list->price ;?></th>	 
<th><?php echo $fetch_list->qty; ?></th>
<th><?php echo $totalprice=$fetch_list->qty * $fetch_list->price; ?></th>
<?php 
	$lbr=$this->db->query("select *,SUM(total_spent) as labourcost from tbl_software_cost_log where log_type='Labour' AND section_id='".$_GET['id']."' ");
	$getLbr=$lbr->row();

	if($i == 0)
	{ ?>
		<th rowspan="<?=$count?>">
		<div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
			<?php echo $cost=$getLbr->labourcost; ?>
		</div>	
		</th>
	<?php
	}
	else
	{
		$cost=0;
	}

	$total=$totalprice + $cost;
?>	

</tr>
<?php 
$sum=$sum+$total;
$i++;
} ?>

<?php 
}
else
{
	$count=1;

?>
<tr>
	<th>1</th>
	<th colspan="7"></th>
  
  <?php 
	$lbr=$this->db->query("select *,SUM(total_spent) as labourcost from tbl_software_cost_log where log_type='Labour' AND (section_id='".$_GET['id']."' OR machine_id='".$_GET['id']."') ");
	$getLbr=$lbr->row();

	if($i == 0)
	{ ?>
		<th rowspan="<?=$count?>">
		<div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
			<?php echo $cost=$getLbr->labourcost; ?>
		</div>	
		</th>
	<?php
	}
	else
	{
		$cost=0;
	}

	$total=$cost;
?>	

</tr>
<?php 

$sum=$total;

}
?>
<input type="hidden" name="totalprice" id="totalprice" class="form-control" value="<?php echo $sum;?>" />

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

</div>
</div>

</div>
<?php
$this->load->view("footer.php");
?>







<script type="text/javascript">

var id1=document.getElementById("totalprice").value;
document.getElementById("section_total").value = id1;

</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">