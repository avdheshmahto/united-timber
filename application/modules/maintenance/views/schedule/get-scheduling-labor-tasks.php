<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlabortaskschedule" >
<thead>
	<tr>
		<th>Task</th>
		<th>Start Date</th>
		<th>Hrs Estimate</th>
		<th>Hrs Spent</th>
		<th>Cost Estimate</th>
		<th>Cost Spent</th>
	</tr>
</thead>
<tbody>
<?php
$i=1;

$laborqry=$this->db->query("select * from  tbl_workorder_labor_task where labor_type='SM' and work_order_id='$id'");
foreach($laborqry->result() as $fetch_list) { ?>

<tr class="gradeU record">	
<?php 
$task=$this->db->query("select * from tbl_master_data where serial_number='$fetch_list->task_name' ");
$getTask=$task->row();
?>
<td><?=$getTask->keyvalue;?></td>
<td><?=$fetch_list->start_date;?></td>
<td><?=$fetch_list->time_estimate;?></td>
<td><?=$fetch_list->time_spent;?></td>		
<td><?=$fetch_list->cost_estimate;?></td>		
<td><?=$fetch_list->cost_spent;?></td>		
</tr>
<?php } ?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#addlabortaskschedulingid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Labor Tasks"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>