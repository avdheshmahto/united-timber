<?php
$this->load->view("header.php");
$Query=$this->db->query("select * from tbl_tools_issue_hdr where issue_id='".$_GET['id']."' and status = 'A'");
$getQuery=$Query->row();

$facility=$this->db->query("select * from tbl_category where id='".$getQuery->section."'");
$getFacility = $facility->row();

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
<h4 class="panel-title">TOOLS LIST</h4>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>

<div class="row centered-form">
<div class="col-xs-12 col-sm-12">
<div class="panel panel-default">
<div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
<h3 class="panel-title" style="float: initial;">Tools Issue Details:-  <?=$getQuery->issue_id?>
<a href="<?=base_url('issue/ToolsIssue/manage_tools_issue');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>
<div class="panel-body">
<form role="form">

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Section Name</h4>
<input type="text" name="" value="<?=$getFacility->name;?>" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Total Issued Quantity</h4>
<?php 
$qty=$this->db->query("select SUM(qty) as totalqty from tbl_tools_issue_dtl where issue_id_hdr='$getQuery->issue_id'");
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


<div id="AjaxData">
<div class="tabs-container">
<ul class="nav nav-tabs">
<li class="active"><a href="#part_issue" data-toggle="tab">Tools Issue</a></li>
<li><a href="#part_return" data-toggle="tab">Tools Return</a></li>
<li><a href="#part_return_log" data-toggle="tab">Tools Return Log</a></li>
</ul>

<div class="tab-content">

<div class="tab-pane active" id="part_issue">
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
$Query2=$this->db->query("select * from tbl_tools_issue_hdr where issue_id='".$_GET['id']."' and status = 'A'");
$getQuery2=$Query2->row();

$spareq=$this->db->query("select * from tbl_tools_issue_dtl where issue_id_hdr='$getQuery2->issue_id' AND type='Tools' ");
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
<tr class="gradeU">
<td>
 <button  class="btn btn-default" href='#partsReturn' onclick="viewPartsReturn('<?=$fetch_spares->issue_id_hdr;?>','<?=$getQuery2->section;?>','<?=$getQuery2->type;?>','<?=$getQuery2->issue_status;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Tools Return"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>

</table>
</div>

</div>
</div>

<div class="tab-pane" id="part_return">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlogspare" >
<thead>
<tr>
<th>Product Id</th>
<th>Product Name</th>
<th>Type</th>
<th>Issue Qty</th>
<th>Return Qty</th>
<th>Location</th>
<th>Rack</th>
<th>Vendor</th>
<th>Purchase Price</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$Query3=$this->db->query("select * from tbl_tools_return_hdr where issue_id='".$_GET['id']."' and status = 'A'");
$getQuery3=$Query3->row();

$spareq=$this->db->query("select * from tbl_tools_return_dtl where return_id_hdr='$getQuery3->return_id' ");
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

  $qtty=$this->db->query("select SUM(qty) as totalqty from tbl_tools_issue_dtl where issue_id_hdr='".$_GET['id']."' AND spare_id='$fetch_spares->spare_id' ");
  $getQty=$qtty->row();

?>

<tr class="gradeU record">
   
    <td><?=sprintf('%03d',$fetch_spares->spare_id); ?></td>       
    <td><?php echo $getPrd->productname; ?></td>
    <td><?php echo $getPrd->via_type; ?></td>
    <td><?php echo $getQty->totalqty; ?></td>    
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



<div class="tab-pane" id="part_return_log">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlogspare" >
<thead>
<tr>
<th>Product Id</th>
<th>Product Name</th>
<th>Type</th>
<th>Return Qty</th>
<th>Location</th>
<th>Rack</th>
<th>Vendor</th>
<th>Purchase Price</th>
<th>Return Date</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$Query4=$this->db->query("select * from tbl_tools_return_hdr where issue_id='".$_GET['id']."' and status='A'");
$getQuery4=$Query4->row();

$spareq=$this->db->query("select * from tbl_tools_return_log where return_id_hdr='$getQuery4->return_id' ");
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
    <td><?php echo $fetch_spares->maker_date; ?></td>

</tr>
<?php } ?>

</tbody>

</table>
</div>

</div>
</div>

</div>
</div><!--tabs-container close-->

</div>  <!-- close AajaxData -->

</div>
</div>
</div>
</div>

<form class="form-horizontal" role="form" id="formedPartsReturn" method="post">      
<div id="partsReturn" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
         
        <div class="modal-parts-issue" id="modal-parts-issue">

        </div>
    </div>   
</div>
</form>

<script type="text/javascript">

function viewPartsReturn(v,x,y,z)
{
  //alert(v);
  var pro=v; 
  var fro=x;
  var tro=y;
  var sro=z;
  var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "return_parts?ISD="+ pro + "&"+"FID="+ fro + "&"+"PTP="+ tro + "&"+"STS="+ sro, false);
  //xhttp.open("GET", "return_parts?ISD="+pro, false);
  // alert(xhttp.open);
  xhttp.send();
  //alert(xhttp.responseText);
  document.getElementById("modal-parts-issue").innerHTML = xhttp.responseText;

} 

function returnQtyFunc(v) 
{
  
  var zz=document.getElementById(v).id;
  //alert(zz);
  var myarra = zz.split("return_qty");
  var asx= myarra[1];
  //alert(asx);

    var rmqty1 = $("#remain_qty"+asx).val();
    var RTqty1 = $("#return_qty"+asx).val();

 
    if(Number(RTqty1) > Number(rmqty1))
    {
      alert("Return Qty Can Not Be Greater Than Issue Qty");
      $("#returnButton").attr('disabled',true);
    }
    else
    {
      $("#returnButton").removeAttr('disabled',false);
    }
  
}

</script>



<?php
$this->load->view("footer.php");
?>