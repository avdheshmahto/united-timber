
<div class="tabs-container">
<ul class="nav nav-tabs">
<li class="active"><a href="#spare" data-toggle="tab">Parts & Supplies Issue</a></li>
<li><a href="#sparelog" data-toggle="tab">Parts & Supplies Issue Log</a></li>
</ul>

<div class="tab-content">


<div class="tab-pane active" id="spare">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadspareparts" >
<thead>
<tr>
<th>Product Id</th>
<th>Product Name</th>
<th>Requested Qty</th>
<th>Type</th>
<!-- <th>Action</th> -->
</tr>
</thead>

<tbody>
<?php

$i=1;
$spareq=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='$shid' ");
foreach($spareq->result() as $fetch_spares)
{
  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_spares->spare_id' ");
  $getPrd=$prd->row();

$hdr=$this->db->query("select * from tbl_workorder_spare_hdr where spare_hdr_id='$fetch_spares->spare_hdr_id'");
$getHdr=$hdr->row();
?>

<tr class="gradeU record">
   
    <td>
    <!-- <a  href='#spareIssue' data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare Issue"> -->
    <a  href='#spareIssue' onclick="viewSpareIssue('<?=$fetch_spares->spare_id;?>','<?=$fetch_spares->spare_hdr_id;?>','<?=$getHdr->work_order_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Issue Product"> <?=sprintf('%03d',$fetch_spares->spare_id); ?></a>
    </td>
       
    <td><?php echo $getPrd->productname; ?></td>
    <td><?php echo $fetch_spares->qty_name; ?></td>
    <td><?php echo $getPrd->via_type; ?></td>
    <!-- <td><a  href='#spareIssue' data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare Issue">Issue</a></td> -->
</tr>
<?php } ?>

</tbody>

</table>
</div>

</div>
</div>

<div class="tab-pane" id="sparelog">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlogspare" >
<thead>
<tr>
<th>Product Id</th>
<th>Product Name</th>
<th>Request Qty</th>
<th>Issue Qty</th>
<th>Type</th>
<th>Location</th>
<th>Rack</th>
<th>Vendor</th>
<th>Purchase Price</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$spissuehdr=$this->db->query("select * from tbl_spare_issue_hdr where workorder_spare_id='$shid' AND workorder_id='$wids' ");
$count=$spissuehdr->num_rows();
$getIssueHdr=$spissuehdr->row();

$array_id=array();
foreach ($spissuehdr->result() as $key) 
{
  array_push($array_id, $key->issue_id);
}

if($count > 0)
{
  $xyz=implode(',',$array_id);
}
else
{
  $xyz='9999';
}


$spareq=$this->db->query("select * from tbl_spare_issue_log where issue_id_hdr IN ($xyz) ");
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
    <td><?php echo $getHdr->qty_name ?></td>
    <td><?php echo $fetch_spares->qty; ?></td>
    <td><?php echo $getPrd->via_type; ?></td>
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

