
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
$Query2=$this->db->query("select * from tbl_tools_issue_hdr where issue_id='$id' and status = 'A'");
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
 <button  class="btn btn-default" href='#partsIssue' onclick="viewPartsReturn('<?=$fetch_spares->issue_id_hdr;?>','<?=$getQuery2->section;?>','<?=$getQuery2->type;?>','<?=$getQuery2->issue_status;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Tools Return"><img src="<?=base_url();?>assets/images/plus.png" /></button>
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
$Query3=$this->db->query("select * from tbl_tools_return_hdr where issue_id='$id' and status = 'A'");
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
$Query4=$this->db->query("select * from tbl_tools_return_hdr where issue_id='$id' and status='A'");
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

