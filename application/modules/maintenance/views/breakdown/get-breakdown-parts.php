<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadspareparts" >
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

$sparemapName=$this->db->query("select * from tbl_workorder_spare_hdr where type='Parts' and work_order_id='$id'");

foreach($sparemapName->result() as $fetch_map_spare)
{

?>

    <tr class="gradeU record">
       
	   <td>
	   <a  class="modalMapSpare" href='#viewspareorder' onclick="viewspareorder('<?php echo  $fetch_map_spare->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts And Supplies Order">
	   <?=sprintf('%03d',$fetch_map_spare->spare_hdr_id); ?></a></td>
		     
		<td><?=$fetch_map_spare->maker_date; ?></td>
		<td><?=$fetch_map_spare->work_order_status; ?></td>
		<td> <a  class="modalMapSpare" href='#viewspareorder' onclick="viewspareorder('<?php echo  $fetch_map_spare->spare_hdr_id;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Parts And Supplies Order"> <i class="fa fa-eye"></i></a></td>
       
    </tr>
<?php }?>
<tr class="gradeU">
<td>
<button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#spareid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' data-refresh="true" formid = "#mapSpareForm" id="formreset" title="Add Spare"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
 
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</tbody>

</table>