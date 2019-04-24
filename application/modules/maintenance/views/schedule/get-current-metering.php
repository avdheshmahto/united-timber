

<?php
$scheQuery=$this->db->query("select *from tbl_schedule_maintain where id='".$_GET['id']."' and status = 'A'");
$getsched=$scheQuery->row();

 
$queryType101=$this->db->query("select *from tbl_machine where id='$getsched->machine_name'");
$getType101=$queryType101->row();

?>

<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadSpareMetering" >
<thead>
<tr>
<!--<th>Spare</th>-->
<th>Last Reading</th>
<th>Unit</th>
<th>Date</th>
<!--<th>Action</th>-->
</tr>
</thead>


<tbody>
<?php

$i=1;

	 $sparemacNamef=$this->db->query("select * from tbl_machine_reading where machine_id='$machine_id' and status = 'A'");
	
  foreach($sparemacNamef->result() as $fetch_list_metering)
  {
 
?>

    <tr class="gradeU record">
       
      
		 <td><?=$fetch_list_metering->reading;?></td>
		 
		 
        <td><?php 
			 $compQuery = $this -> db
			           -> select('*')
			           -> where('serial_number',$fetch_list_metering->unit)
			           -> get('tbl_master_data');
			 $compRow = $compQuery->row();

			echo $compRow->keyvalue;
			?>
		</td>
		  <td><?=$fetch_list_metering->maker_date;?></td>
		
      

    </tr>
<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpareunit'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareFormunit" id="formreset"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<!--<td>&nbsp;</td>
<td>&nbsp;</td>-->
</tr>

</tbody>

</table>