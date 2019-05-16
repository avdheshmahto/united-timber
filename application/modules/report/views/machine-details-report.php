
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

$cat=$this->db->query("select * from tbl_category where id='".$_GET['id']."' ");
$fetch=$cat->row();
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">MACHINE DETAILS REPORT ( <?=$fetch->name;?> )</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>
		
    <th>S. No.</th>
		<th>Machine Code</th>
		<th>Machine Name</th>
    <th>Machine Unit</th>

</tr>
</thead>
<tbody id="getDataTable" >
<?php 

$catg=$this->db->query("select * from tbl_category where inside_cat='$fetch->id' ");
$count=$catg->num_rows();

$ctgarray=array();
foreach ($catg->result() as $key) 
{
  $ctgId=$key->id;
  array_push($ctgarray, $ctgId);
}

if($count > 0)
{
  $ctIds=implode(', ',$ctgarray);
}
else
{
  $ctIds='999999999';
}

$machine=$this->db->query("select * from tbl_machine where (m_type='$fetch->id' OR m_type IN ($ctIds)) ");

$z=1;
foreach($machine->result() as $getMachine)
{
?>

<tr class="gradeC record">  
  <th><?php echo $z++; ?></th>
  <th><?php echo $getMachine->code;?></th>
  <th><?php echo $getMachine->machine_name; ?></th>
  <th><?php 
      $master=$this->db->query("select * from tbl_master_data where serial_number='$getMachine->m_unit'");
      $getMaster=$master->row();
      echo $getMaster->keyvalue;
   ?></th>
</tr>
<?php  }  ?>
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
	
<?php
$this->load->view("footer.php");
?>	
</div>





<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Product Bin Card Report<?php echo date('d-m-Y');?>.xls';
   
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



function ResetLead()
{
  location.href="<?=base_url('/report/Report/comparison_details_report?id=');?><?=$_GET['id']?>";
}

</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
