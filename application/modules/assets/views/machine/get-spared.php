<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadmeteing" >
<thead>
<tr>
<th>Last Reading</th>
<th>Unit</th>
<th>Date</th>
<!-- <th>Action</th> -->
</tr>
</thead>


<tbody>
<?php

$i=1;
	 $sparemacName=$this->db->query("select * from tbl_machine_reading where machine_id='".$_GET['id']."' and status = 'A'");
  foreach($sparemacName->result() as $fetch_list)
  {
   $spareName=$this->db->query("select *from tbl_product_stock where Product_id='$fetch_list->spare_id'");
   $getSpareD=$spareName->row();
?>

    <tr class="gradeU record">
       
		 <td><?=$fetch_list->reading;?></td>
		 		 
        <td><?php 
			 $compQuery = $this -> db
			           -> select('*')
			           -> where('serial_number',$fetch_list->unit)
			           -> get('tbl_master_data');
			 $compRow = $compQuery->row();

			echo $compRow->keyvalue;
			?>
		</td>
		  <td><?=$fetch_list->date_time;?></td>
		       
      <!--  <td><?php $pri_col='id';
                  $table_name='tbl_machine_reading';
         ?>
        <?php if($view!=''){ ?>
	    		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>	
		<?php }?>
		</td> -->

    </tr>
<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#machinemetering' onclick="addMachineMetering('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Metering"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

</tbody>

</table>