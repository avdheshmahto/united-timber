<?php
$this->load->view("header.php");
$Query=$this->db->query("select * from tbl_consum_issue_hdr where issue_id='".$_GET['id']."' and status = 'A'");
$getQuery=$Query->row();

$facility=$this->db->query("select * from tbl_category where id='".$getQuery->section."'");
$getFacility = $facility->row();

$mach=$this->db->query("select * from tbl_machine where id='$getQuery->machine'");
$getMachine=$mach->row();

?>

<style type="text/css">

	.select2-container--open {
       z-index: 99999999 !important;
	 }
	 .select2-container {
       min-width: 256px !important;
     }

</style>


<div class="main-content">
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">

<div class="panel-heading clearfix">
<h4 class="panel-title">CONSUMABLE LIST</h4>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>

<div class="row centered-form">
<div class="col-xs-12 col-sm-12">
<div class="panel panel-default">
<div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
<h3 class="panel-title" style="float: initial;">Consumable Issue Details:-  <?=$getQuery->issue_id?>
<a href="<?=base_url('issue/ConsumIssue/manage_consumable_issue');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>
<div class="panel-body">
<form role="form">

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Section Name </h4>
<input type="text" name="" value="<?=$getFacility->name;?>" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Machine Name</h4>
<input type="text" name="" value="<?=$getMachine->machine_name;?>" class="form-control" readonly >
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Issue Date</h4>
<input type="text" name="" value="<?=$getQuery->issue_date;?>" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Total Issued Quantity</h4>
<?php 
$qty=$this->db->query("select SUM(qty) as totalqty from tbl_consum_issue_dtl where issue_id_hdr='$getQuery->issue_id'");
$getQty=$qty->row(); ?>
<input type="text" name="" class="form-control" value="<?=$getQty->totalqty;?>" readonly >
</div>
</div>
</div>

</form>
</div>
</div>
</div>
</div>



<div class="tabs-container">
<ul class="nav nav-tabs">
<li class="active"><a href="#consumable_issue" data-toggle="tab">Consumable Issue</a></li>
</ul>

<div class="tab-content">


<div class="tab-pane active" id="consumable_issue">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlogspare" >
<thead>
<tr>
<th>Product Id</th>
<th>Product Name</th>
<th>Via Type</th>
<th>Issue Qty</th>
<th>Location</th>
<th>Rack</th>
<th>Vendor</th>
<th>Purchase Price</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$Query2=$this->db->query("select * from tbl_consum_issue_hdr where issue_id='".$_GET['id']."' and status='A'");
$getQuery2=$Query2->row();

$spareq=$this->db->query("select * from tbl_consum_issue_dtl where issue_id_hdr='$getQuery2->issue_id' AND type='Consumable'");
foreach($spareq->result() as $fetch_spares)
{
  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_spares->spare_id' ");
  $getPrd=$prd->row();

  $hdr=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='$getIssueHdr->workorder_spare_id' AND spare_id='$fetch_spares->spare_id' ");
  $getHdr=$hdr->row();

  $loc=$this->db->query("select * from tbl_master_data where serial_number='$fetch_spares->location' AND param_id='21' ");
  $getLoc=$loc->row();

  $rack=$this->db->query("select * from tbl_location_rack where id='$fetch_spares->rack' ");
  $getRack=$rack->row();

  $vndr=$this->db->query("select * from tbl_contact_m where contact_id='$fetch_spares->vendor' ");
  $getVndr=$vndr->row();

?>

<tr class="gradeU record">
   
    <td><?=sprintf('%03d',$fetch_spares->spare_id); ?></td>       
    <td><?php echo $getPrd->productname; ?></td>
    <td><?php echo $getPrd->via_type; ?></td>
    <td><?php echo $fetch_spares->qty; ?></td>
    <td><?=$getLoc->keyvalue?></td>
    <td><?=$getRack->rack_name?></td>
    <td><?=$getVndr->first_name?></td>
    <td><?=$fetch_spares->price?></td>

</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>
</div>


</div>
</div><!--tabs-container close-->



</div>
</div>
</div>
</div>


<?php
$this->load->view("footer.php");
?>