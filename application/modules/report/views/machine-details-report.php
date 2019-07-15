
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
  <th><a target="_blank" href="<?=base_url();?>report/Report/machine_files_log?id=<?=$getMachine->id?>"> <?php echo $getMachine->machine_name; ?> </a></th>
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
</div>
</div>
