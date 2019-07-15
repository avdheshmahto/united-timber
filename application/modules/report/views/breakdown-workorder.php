
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

$mac=$this->db->query("select * from tbl_machine where id='".$_GET['id']."'");
$fetch=$mac->row();
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">BREAKDOWN WORKORDER DETAILS( <?=$fetch->machine_name;?> )</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>

		<th>Workorder No.</th>
		<th>Workorder Status</th>
    <th>Breakdown Hours</th>

</tr>
</thead>
<tbody id="getDataTable" >
<?php 

$wo=$this->db->query("select * from tbl_machine_breakdown where machine_id='".$_GET['id']."' ");

$z=1;
foreach($wo->result() as $getWo)
{
?>

<tr class="gradeC record">  
  <th><a target="_blank" href="<?=base_url();?>maintenance/machine_breakdown/manage_machine_breakdown_map?id=<?php echo $getWo->id; ?>"><?php  echo "WO".$getWo->id;  ?></a></th>
  <th><?php 
  $wm=$this->db->query("select * from tbl_work_order_maintain where id='$getWo->workorder_id'");
  $getWm=$wm->row();
  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$getWm->wostatus."'");
  $compRow = $sqlunit->row();
  echo $compRow->keyvalue;
  ?></th>
  <th><?php 
          $from_time5 = strtotime($getWo->start_time);
          $to_time5 = strtotime($getWo->end_time); 
          $delta_5 = ($to_time5 - $from_time5);
          $diff5=$delta_5;

        $tmins5 = $diff5/60;
      $hours5 = floor($tmins5/60);
      $mins5 = $tmins5%60;
      echo "<b>$hours5</b> Hours | <b>$mins5</b> Minutes</b>";
        ?>
    </th>

</tr>
<?php  }  ?>
</tbody>
</table>
</div>
</div>
</div>
	
<?php
$this->load->view("footer.php");
?>	
</div>
</div>
</div>
