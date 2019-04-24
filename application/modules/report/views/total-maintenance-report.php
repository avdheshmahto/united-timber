<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">

<style type="text/css">
.listClass{position: relative;right: 12px font-size: 15px;    font-weight: 600;
height: 90px !important;border-left: 2px solid red; padding: 14px 20px 14px 20px; }
.displayclass{display: none;}
</style>

<?php
$this->load->view("header.php");
$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}


?>
<!-- Main content -->
<div class="main-content">

<?php
$this->load->view("reportheader");
?>
<div class="row">

<div class="col-lg-3">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link href="<?=base_url();?>assets/report/bootstrap.min_.css" type="text/css" rel="stylesheet"> -->
    <link href="<?=base_url();?>assets/report/style.css" type="text/css" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <!-- <title>Hello, world!</title> -->
  </head>

  <body>
	<div class="container" style="margin-top:10px;">
	    <div class="row">
	        <div class="col-md-3">
	            <ul id="tree2">
	                <!-- <li> -->

                  <li><a href="<?=base_url();?>report/Report/total_maintenance?id=0">UNITED TIMBER</a>
                  </li>
	                <ul>                    		
      				    <?php foreach ($categorySelectbox as $key => $dt) { ?>
      				    <li id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>"><a href="<?=base_url();?>report/Report/total_maintenance?id=<?=$dt['id'];?>&name=<?=$dt['name'];?>" >
      				   		<?=$dt['name'];?></a></li>
      				    <?php } ?>                    		
      	          </ul>     

	                <!-- </li> -->
	            </ul>
	        </div>
	    </div>
	</div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <!-- <script src="<?=base_url();?>assets/report/bootstrap.min.js"></script> -->
    <script src="<?=base_url();?>assets/report/script.js"></script>
  </body>
</html>

</div>

<div class="col-lg-9">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">TOTAL MAINTENANCE REPORT <?php if($_GET['id']==0){ ?>( All Section ) <?php } else {?>(&nbsp;&nbsp;<?=$_GET['name'];?>&nbsp;&nbsp;)<?php }?></h4>

<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">

<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Section</label> 
<div class="col-sm-3"> 
<select name="m_type" required class="select2 form-control" id="m_type" style="width:100%;">
<option value="0" class="listClass">------Section-----</option>
<?php
foreach ($categorySelectbox as $key => $dt) { ?>
<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
<?php } ?>
</select>
</div>	

<label class="col-sm-2 control-label">Machine</label> 
<div class="col-sm-3"> 
<select name="machine" class="select2 form-control">
<option value="">----Machine----</option>
<?php $qry="select * from tbl_machine where status='A'";
$qryres=$this->db->query($qry)->result();
foreach($qryres as $res) { 
$fac=$this->db->query("select * from tbl_category where id='$res->m_type'");
$getFac=$fac->row(); ?>
<option value="<?=$res->id?>" <?php if($_GET['machine'] == $res->id) {?>selected <?php } ?>><?php echo $res->machine_name."(". $getFac->name.")"?></option>	
<?php } ?>
</select>	
</div>
</div>

<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Date </label> 
<div class="col-sm-3">
<div class="input-group">
<input type="text" class="form-control reportrange" name="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width:100%" value="<?=$_GET['date_range'];?>">
<span class="input-group-addon">
 <span class="fa fa-calendar"></span>
</span>	
</div>
</div>

</div>
<div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button> 	
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</form>
</div>



<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('tblData')">Excel</button>  &nbsp;&nbsp;
<!-- <a href="<?=base_url();?>report/Report/excel_spare_location_report?<?='date_range='.$_GET['date_range'].'&section='.$_GET['section'].'&machine='.$_GET['machine'].'&filter='.$_GET['filter']?>" class="btn btn-sm" >Excel</a> -->
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>&nbsp; &nbsp; Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/total_maintenance?<?='date_range='.$_GET['date_range'].'&section='.$_GET['section'].'&machine='.$_GET['machine'].'&filter='.$_GET['filter']?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>

</select>
entries</label>
<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -5px;margin-left: 12px;float: right;">
Showing <?=$dataConfig['page']+1;?> to 
<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
?> of <?=$dataConfig['total'];?> entries
</div>
</div>
<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm" name="filter" class="search_box form-control input-sm" onkeyup="doSearch();" placeholder="What you looking for?">
</label>
</div>
</div>

</div>
</div>


<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="tblData">

<thead>
<tbody>
<th></th>
<th></th>
<th></th>	
<th></th>	
<th>Total Workorder Amount =</th>
<th><span id="workorder_total"> </span></th>
</tbody>
</thead>

<thead>
<tr>

	<th>Workorder No.</th>
	<th>Schedule No.</th>
	<th>Trigger No.</th>
	<th>Section</th>
	<th>Machine</th>
	<th>Amount</th>
		
</tr>
</thead>
<tbody id="getDataTable" >
<?php
if($_GET['id']== 0){
$query=("select * from tbl_work_order_maintain where status='A' Order by id DESC ");
	$getQuery = $this->db->query($query);
$result=$getQuery->result();
}else{
	$mc=$this->db->query("select * from tbl_machine where m_type='".$_GET['id']."' ");
	$getSec=$mc->row();
	$query=("select * from tbl_work_order_maintain where machine_name='$getSec->id' Order by id DESC ");
	$getQuery = $this->db->query($query);
$result=$getQuery->result();
}

foreach($result as $fetch_list) {
?>
<tr class="gradeC record">
<th>
<?php
if($fetch_list->trigger_code!='') { ?>
<a target="_blank" href="<?=base_url();?>report/Report/maintenance_details?id=<?php echo $fetch_list->id;?>" >
<?php 	echo "WO".$fetch_list->id."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SM".$fetch_list->schedule_id;  ?></a>
<?php } else { ?>
<a target="_blank" href="<?=base_url();?>report/Report/maintenance_details?id=<?php echo $fetch_list->id;?>">
<?php 	echo "WO".$fetch_list->id;  ?></a>
<?php } ?>
</th>

<th>	
<?php

if($fetch_list->schedule_id!='')
{
	echo "SM".$fetch_list->schedule_id;
}
?>
</th>	 

<th>	
<?php

if($fetch_list->trigger_code!='')
{
	echo "TR".$fetch_list->trigger_code;
}
?>
</th>

<th>
<?php
$mac=$this->db->query("select * from tbl_machine where id='$fetch_list->machine_name'");
$getMac=$mac->row();

$fac=$this->db->query("select * from tbl_category where id='$getMac->m_type' ");
$getFac=$fac->row();

echo $getFac->name;
//echo $getFac->fac_name."(".$getMac->machine_name.")";
?>	
</th>
<th>
<?php
echo $getMac->machine_name;
?>	
</th>
<th>
<?php 
	$issuehdr=$this->db->query("select * from tbl_spare_issue_hdr where workorder_id='$fetch_list->id' ");
	//echo "select * from tbl_spare_issue_hdr where workorder_id='$fetch_list->id'";
	$count=$issuehdr->num_rows();

	$ishdrid=array();
	foreach ($issuehdr->result() as $value) 
	{
		array_push($ishdrid, $value->issue_id);		
	}

	if($count > 0)
	{
		$IssueIdHdr=implode(',', $ishdrid);
	}
	else
	{
		$IssueIdHdr='999999';
	}

	$issuedtl=$this->db->query("select SUM(price * qty) as totalkharcha from tbl_spare_issue_dtl where issue_id_hdr IN ($IssueIdHdr)");
	$getIssueDtl=$issuedtl->row();

	$total = $getIssueDtl->totalkharcha;


	$laborCost=$this->db->query("select SUM(cost_spent) as totalcost from tbl_workorder_labor_task where work_order_id='$fetch_list->id' ");
	$getCost=$laborCost->row();

	$cost=$getCost->totalcost;

	$toatalSpent=$cost + $total;

	echo $toatalSpent;


?>
</th>
</tr>
<?php 
$sum=$sum+$toatalSpent;

}  ?>

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

<?php
$this->load->view("footer.php");
?>
</div>


<script type="text/javascript">

function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'TOTAL MAINTENANCE REPORT (<?php echo date('d-m-Y');?>).xls';
   
   // Create download link element
   downloadLink = document.createElement("a");
   
   document.body.appendChild(downloadLink);
   
   if(navigator.msSaveOrOpenBlob){
       var blob = new Blob(['\ufeff', tableHTML], {
           type: dataType
       });
       navigator.msSaveOrOpenBlob( blob, filename);
   }else{

       // Create a link to the file
       downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
   
       // Setting the file name
       downloadLink.download = filename;
       
       //triggering the function
       downloadLink.click();
   }
}

</script>

<script type="text/javascript">
var id1=document.getElementById("totalprice").value;
document.getElementById("workorder_total").innerHTML = id1;
//alert(id);


function ResetLead()
{
  location.href="<?=base_url('/report/Report/total_maintenance?id=');?><?=$_GET['id']?>&name=<?=$_GET['name']?>";
}
</script>

<script type="text/javascript">

$(function() {

   var start = moment().subtract(29, 'days');
   var end = moment();

   function cb(start, end) {
       $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
   }

   $('.reportrange').daterangepicker({
       // startDate: start,
       // endDate: end,
       ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
       }
   }, cb);

   cb(start, end);

});

</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>