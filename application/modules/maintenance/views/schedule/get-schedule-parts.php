
<thead>
<tr>
<th>Order No.</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php

$i=1;
$spareq=$this->db->query("select * from tbl_workorder_spare_hdr where work_order_id='$id' and type = 'Parts'");
foreach($spareq->result() as $fetch_spares)
{
?>

<tr class="gradeU record">
   
    <td>
		<a  class="modalMapSpare" href='#viewschedulepartsid' onclick="viewscheduleparts('<?php echo  $fetch_spares->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts And Supplies"> <?=sprintf('%03d',$fetch_spares->spare_hdr_id); ?></a>
    </td>
	     
    <td><?php echo $fetch_spares->maker_date; ?></td>
    <td><?php echo $fetch_spares->work_order_status; ?></td>
    <td><a  class="modalMapSpare" href='#viewschedulepartsid' onclick="viewscheduleparts('<?php echo $fetch_spares->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts And Supplies"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;

    <?php $pri_col='spare_hdr_id';
	$table_name='tbl_workorder_spare_hdr';
	?>
	<?php if($view!=''){ ?>

	<button class="btn btn-default delbutton" id="<?php echo $fetch_spares->spare_hdr_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
	<?php }?>	
    </td>

</tr>
<?php } ?>
<tr class="gradeU">
<td>
<button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#schedulespareid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare" onclick="refreshData();"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
	
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

</tbody>

