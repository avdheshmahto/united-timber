<?php
$this->load->view("header.php");
$idd=$_GET['id'];
$scheQuery=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' and status='A'");
$getsched=$scheQuery->row();

$sqlunitmachine=$this->db->query("select * from tbl_machine where id='".$getsched->machine_name."'");
$compRowmachine = $sqlunitmachine->row();

?>

<div class="main-content">
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">

<div class="panel-heading clearfix">
<h4 class="panel-title">PARTS & SUPPLIES ISSUE</h4>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>

<div class="row centered-form">
<div class="col-xs-12 col-sm-12">
<div class="panel panel-default">
<div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
<h3 class="panel-title" style="float: initial;">Work Order Details:-WO<?=$getsched->id;?>
<a href="<?=base_url('issue/SpareIssue/manage_spare_issue');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>
<div class="panel-body">
<form role="form">
<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Machine Name</h4>

<input type="text" name="" value="<?=$compRowmachine->machine_name;?>" id="first_name" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Priority</h4>
<?php 
$queryType100=$this->db->query("select *from tbl_master_data where serial_number='$getsched->priority'");
$getType100=$queryType100->row();

?>
<input type="text" name="" class="form-control" value="<?=$getType100->keyvalue;?>" readonly >
</div>
</div>
</div>


<div class="row">

<div class="col-xs-6 col-sm-6 col-md-6">
<?php if($getsched->trigger_code !=''){ ?>
<h4>Trigger Code</h4>
<div class="form-group">

<input type="text" name="" value="<?="TR".$getsched->trigger_code;?>" class="form-control" readonly>

</div>
<?php } ?>
</div>

<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Maintenance Type</h4>
<?php 
$queryType=$this->db->query("select *from tbl_master_data where serial_number='$getsched->maintyp'");
$getType=$queryType->row();

?>
<input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Work Order Status</h4>
<?php 
$queryType=$this->db->query("select *from tbl_master_data where serial_number='$getsched->wostatus'");
$getType=$queryType->row();

?>
<input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>

</div>
</div>

<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Completed Date</h4>

<input type="text" name=""  value="<?=$getsched->date_time;?>" class="form-control" readonly>

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
<li class="active"><a href="#spare" data-toggle="tab">Workorder Parts & Supplies</a></li>
</ul>

<div class="tab-content">


<div class="tab-pane active" id="spare">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadspareparts" >
<thead>
<tr>
<th>Order No.</th>
<th>Order Date</th>
<th>Status</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$spareq=$this->db->query("select * from tbl_workorder_spare_hdr where work_order_id='$getsched->id' and type = 'Parts'");
foreach($spareq->result() as $fetch_spares)
{
?>

<tr class="gradeU record">
   
    <td>
		<a href="<?=base_url();?>issue/SpareIssue/view_spare_issue?id=<?=$getsched->id?>&shid=<?=$fetch_spares->spare_hdr_id?>" title="View Parts And Supplies"> <?=sprintf('%03d',$fetch_spares->spare_hdr_id); ?></a>
    </td>
	     
    <td><?php echo $fetch_spares->maker_date; ?></td>
    <td><?php
	$dtl=$this->db->query("select *,SUM(qty_name) as reqstQty,SUM(issue_qty) as issueQty from tbl_workorder_spare_dtl where spare_hdr_id='$fetch_spares->spare_hdr_id'");
	$getDtl=$dtl->row();
		
	if($getDtl->issueQty == 0)
	{
		echo "Open";
	}
	else if($getDtl->issueQty < $getDtl->reqstQty)
	{
		echo "Partial Completed";
	}
	else if($getDtl->issueQty == $getDtl->reqstQty)
	{
		echo "Completed";
	}
	?></td>
</tr>
<?php } ?>
<tr class="gradeU" style="display: none;">
<td>
<button  class="btn btn-default" href='#spareIssue'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare Issue"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

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