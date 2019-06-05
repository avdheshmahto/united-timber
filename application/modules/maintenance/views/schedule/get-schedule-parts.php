
<thead>
<tr>
<th>Order No.</th>
<th>Order Date</th>
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
    <td><?php
	$dtl=$this->db->query("select *,SUM(qty_name) as reqstQty,SUM(issue_qty) as issueQty from tbl_workorder_spare_dtl where spare_hdr_id='$fetch_map_spare->spare_hdr_id'");
	$getDtl=$dtl->row();
		
	if($getDtl->issueQty == 0)
	{
		echo "Open";
	}
	else if($getDtl->issueQty < $getDtl->reqstQty)
	{
		echo "Partial Completed";
	}
	else if($getDtl->issueQty == $getDtl->reqstQty)
	{
		echo "Completed";
	}
	?></td>
    <td><a  class="modalMapSpare" href='#viewschedulepartsid' onclick="viewscheduleparts('<?php echo $fetch_spares->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts And Supplies"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;

    <?php $pri_col='spare_hdr_id';
	$table_name='tbl_workorder_spare_hdr';
	?>
	<?php if($getDtl->issue_qty == ''){ ?>
	<button class="btn btn-default delbutton_spare_order" id="<?php echo $fetch_map_spare->spare_hdr_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
	<?php } else { ?>
	<button class="btn btn-default" type="button" title="Delete Parts & Supplies Order" onclick="return confirm('Parts & Supplies Issued. You can not delete it ?');"><i class="icon-trash"></i></button>	
	<?php } ?>	
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

