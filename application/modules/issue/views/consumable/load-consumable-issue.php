
<thead>
<tr>
<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
  <th>Issue Id</th>
  <th>Section</th>
  <th>Type</th>  
  <th>Issued Qty</th>
  <th>Status</th>
 </tr>
</thead>
<tbody id = "getDataTable"> 
                    
<?php  

 $i=1;
 //$sqlord=$this->db->query("select * from tbl_work_order_maintain where status='A'");
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->issue_id; ?>">

<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->issue_id; ?>" value="<?php echo $fetch_list->issue_id;?>" /></th>

<th><?php // echo "CB".$fetch_list->issue_id; ?><?=sprintf('%03d',$fetch_list->issue_id); ?></th>
<th><a href="<?=base_url();?>issue/ConsumIssue/view_consumable_issue?id=<?=$fetch_list->issue_id?>"><?php 
  $sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->section."'");
  $compRow = $sqlunit->row();
  echo $compRow->name;    ?></a>
</th>
<th><?php echo $fetch_list->type; ?></th>
<th><?php 
$qty=$this->db->query("select SUM(qty) as totalqty from tbl_consum_issue_dtl where issue_id_hdr='$fetch_list->issue_id'");
$getQty=$qty->row();

echo $getQty->totalqty; ?></th>
<th><?php echo $fetch_list->issue_status; ?></th>
</tr>

<?php $i++; } ?>
</tbody>
