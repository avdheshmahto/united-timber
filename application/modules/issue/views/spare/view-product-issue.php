<?php
$this->load->view("header.php");
$scheQuery=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' and status = 'A'");
$getsched=$scheQuery->row();

$sqlunitmachine=$this->db->query("select * from tbl_machine where id='".$getsched->machine_name."'");
$compRowmachine = $sqlunitmachine->row();
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
<h4 class="panel-title">VIEW PARTS & SUPPLIES LIST</h4>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>

<div class="row centered-form">
<div class="col-xs-12 col-sm-12">
<div class="panel panel-default">
<div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
<h3 class="panel-title" style="float: initial;">Work Order Details:-  WO<?=$getsched->id;?>
	
	<a href="<?=base_url('issue/SpareIssue/add_spare_issue?id=');?><?=$getsched->id?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
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


<div id="ajaxContent">
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
<th>Issue Qty</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$spareq=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='".$_GET['shid']."' ");
foreach($spareq->result() as $fetch_spares)
{
  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_spares->spare_id' ");
  $getPrd=$prd->row();

$hdr=$this->db->query("select * from tbl_workorder_spare_hdr where spare_hdr_id='$fetch_spares->spare_hdr_id'");
$getHdr=$hdr->row();
?>

<tr class="gradeU record">
   
    <td>
    <a  href='#spareIssue' onclick="viewSpareIssue('<?=$fetch_spares->spare_id;?>','<?=$fetch_spares->spare_hdr_id;?>','<?=$getHdr->work_order_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Issue Product"> <?=sprintf('%03d',$fetch_spares->spare_id); ?></a>
    </td>
	     
    <td><?php echo $getPrd->productname; ?></td>
    <td><?php echo $fetch_spares->qty_name; ?></td>
    <td><?php 
    if($fetch_spares->issue_qty == '')
    {
      echo 0;
    }
    else
    {
      echo $fetch_spares->issue_qty; 
    }    
    ?>
    </td>
    <td>
      <?php $pri_col='spare_hdr_id';
      $table_name='tbl_workorder_spare_hdr';
      ?>
      <button class="btn btn-default delbutton_spare_issue" id="<?php echo $fetch_spares->spare_hdr_id."^".$table_name."^".$pri_col."^".$fetch_spares->spare_id ; ?>" type="button" title="Delete Parts & Supplies"><i class="icon-trash"></i></button> 
    </td>
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
$spissuehdr=$this->db->query("select * from tbl_spare_issue_hdr where workorder_spare_id='".$_GET['shid']."' AND workorder_id='".$_GET['id']."' ");
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

</div> <!-- close ajaxContent -->

</div>
</div>
</div>
</div>

<form class="form-horizontal" role="form" id="formedSpareIssue" method="post">      
<div id="spareIssue" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
         
        <div class="modal-spare-issue" id="modal-spare-issue">

        </div>
    </div>   
</div>
</form>

<script type="text/javascript">

function viewSpareIssue(v,x,y)
{
  //alert(x);
  var prod=v;
  var sphd=x;
  var word=y
  var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "issue_spare?PID="+ prod + "&"+"HID="+ sphd + "&"+"WID="+ word, false);
  // xhttp.open("GET", "issue_spare_sm?ID="+pro, false);
  // alert(xhttp.open);
  xhttp.send();
  //alert(xhttp.responseText);
  document.getElementById("modal-spare-issue").innerHTML = xhttp.responseText;

} 

function qtyfunction(v) 
{
  
  var zz=document.getElementById(v).id;
  //alert(zz);
  var myarra = zz.split("spare_qty");
  var asx= myarra[1];
  //alert(asx);
  var splgnth=$("#cntVal").val();
  //alert(splgnth);
  var total2 = 0; 
  for(var i=0; i < splgnth; i++)
  {   
      var sum=document.getElementById("spare_qty"+i).value;
      total2 = total2 + Number(sum);
  }
   //alert(total);

    var eqty1 = $("#spare_qty"+asx).val();
    var sqty1 = $("#stk_qty"+asx).val();

    var rqty1  = $("#reqstQty").val();
    var rmQty1 = $("#remainQty").val();
    
    //alert(sqty);

    //if(sqty < eqty)
    if(Number(eqty1) > Number(sqty1))
    {
      alert("Issue Qty Can Not Be Greater Than Stock Qty");
      $("#issueButton").attr('disabled',true);
    }
    //else if(rmQty < total)
    else if(Number(total2) > Number(rmQty1))
    {
      alert("Toatal Issue Qty Can Not Be Greater Than Requested Qty");
      $("#issueButton").attr('disabled',true);
    }
    else
    {
      $("#issueButton").removeAttr('disabled',false);
    }
  
}

</script>



<?php
$this->load->view("footer.php");
?>