<div class="modal-dialog modal-lg">
<div class="modal-contentMap" id="modal-contentMapunit">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Machine Metering</h4>
<div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div> 
<table class="table table-striped table-bordered table-hover" >
<tbody>
<tr class="gradeA">
<!--<th>Spare Name</th>-->
<th>Reading</th>
<th>Unit</th>
<th>Date With Time</th>
<th>Action</th>
</tr>
<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="mapSpareFormunit">
<tr class="gradeA">
<?php 
//echo "select * from tbl_schedule_triggering where status = 'A' order by id desc limit 0,1";
$sqlQuerymeteringId=$this->db->query("select * from tbl_machine_reading where machine_id='$id' and status = 'A' order by id desc limit 0,1");
	
$getmeteringId=$sqlQuerymeteringId->row();
//echo "jjytyut".$getTriggerId->endby_reading;

$machinQ=$this->db->query("select *from tbl_machine where id='$id'");
$machinelist=$machinQ->row();

?>

<th>
<input type="hidden" name="lastreadingmeter" placeholder = "0.0" id="lastreadingmeter"  style="width:90px;" class="form-control" value="<?=$getmeteringId->reading; ?>" >

<input type="hidden" name="mach_id" id="mach_id" placeholder = "0.0" style="width:90px;" class="form-control" value="<?=$id; ?>" >


<input type="number" name="readingg" placeholder = "0.0" onchange="myFunction_meter()" id="readingg"  style="width:90px;" class="form-control" >
</th>

<th>
<select name="unittt" required class="select2 form-control" id="unittt" style="width:100%;">
<option value="" >----Select----</option>
<?php 
$sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
foreach ($sqlunit->result() as $fetchunit){
?>
<option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetchunit->serial_number == $machinelist->m_unit){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
<?php } ?>
</select>
<!--<input type="number" name="unitt" id="unitt"  style="width:90px;" class="form-control" >-->
</th>
<th>
<input type="date" value="" class="form-control datetimepicker_mask" id="datetimepicker_mask" />
</th>
<th>
<input type="button"  id="qn" style="width:70px;" onclick="saveDataa();" value="Add" class="form-control"> 


</th>
</tr>
</form>
</tbody>
</table>
</div>
</div>	

</div>