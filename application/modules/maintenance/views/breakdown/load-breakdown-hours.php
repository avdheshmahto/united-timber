
<thead>
<tr>
<th>Breakdown Start Time</th>
<th>Breakdown End Time</th>
<th>Breakdown Total Hours</th>
</tr>
</thead>

<tbody>
<?php 

$i=1;

$miscName=$this->db->query("select * from tbl_machine_breakdown where workorder_id='$id' and status='A'");
  foreach($miscName->result() as $fetch_hours)
  {
   
?>

<tr class="gradeU record">

	<td><?=$fetch_hours->start_time; ?></td>
	<td><?=$fetch_hours->end_time; ?></td>
    <td></td>	

</tr>

<?php } ?>
<tr class="gradeU">
<td>
<button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#breakDownId'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Breakdown Hours"><img src="<?=base_url();?>assets/images/plus.png" /></button>  
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</tbody>

