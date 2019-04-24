<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadmeterreading" >
<thead>
<tr>
<th>Date Submitted</th>
<th>Last Reading</th>
<th>Meter Units</th>
</tr>
</thead>
<tbody>
<?php 

$i=1;

 $sparemapName=$this->db->query("select * from tbl_work_order_meter_reading where work_order_id='$id' and status = 'A' ");
  foreach($sparemapName->result() as $fetch_meter_reading)
  {

  $sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and serial_number='$fetch_meter_reading->meter_unit'");
  $fetch_unit_list=$sqlunit->row();
  
?>

    <tr class="gradeU record">
       
	    <td><?=$fetch_meter_reading->maker_date; ?></td>     
		<td><?=$fetch_meter_reading->meter_reading; ?></td>
		<td><?=$fetch_unit_list->keyvalue; ?></td>
      
    </tr>
<?php }?>
<tr class="gradeU">
<td>
<button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#meterreadingid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Meter Reading"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>