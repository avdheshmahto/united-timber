<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">

<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}
?>

<div class="main-content">

<?php
	$this->load->view("reportheader");

	$ps=$this->db->query("select * from tbl_product_stock where Product_id='".$_GET['id']."'");
	$getPs=$ps->row();
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">FREQUENCY OF SPARES DETAILS ( <?=$getPs->productname?> ) </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>
		<th>Date</th>
		<th>Section</th>
		<th>Machine</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Amount</th>
        		
</tr>
</thead>
<tbody id="getDataTable" >
<?php 

$i=1;
$data=$this->db->query("select * from tbl_software_cost_log where product_id='".$_GET['id']."' ");
foreach($data->result() as $fetch) { ?>

<tr class="gradeC record">
<th><?php echo $fetch->log_date; ?></th>
<th>
<?php 
	$sec=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
	$getSec=$sec->row();
	echo $getSec->name; ?>
</th>
<th>
<?php 
	$mac=$this->db->query("select * from tbl_machine where id='$fetch->machine_id'");
	$getMac=$mac->row();
	echo $getMac->machine_name; ?>
</th>
<th><?php echo $fetch->qty; ?></th>
<th><?php echo $fetch->price; ?></th>
<th><?php echo $fetch->total_spent; ?></th>
</tr>
<?php $i++; } 
 ?>


<!-- <tr style="display: none;">
	<th colspan="5" class="text-center">Totals :</th>
	<td class="blank_right text-center"><?php echo $sum1; ?></td>
</tr> -->

</tbody>
</table>


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
</div>
<?php

$this->load->view("footer.php");
?>






<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Machine Spare Mapping Report<?php echo date('d-m-Y');?>.xls';
   
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

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
