
<thead>
<tr>
<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>

  <th>Section</th>
  <th>Task Name</th>
  <th>Start Date</th>
  <th>End Date</th>  
  <th>Time Estimate</th>
  <th>Time Spent</th>
  <th>Cost Estimate</th>
  <th>Cost Spent</th>
 </tr>
</thead>
<tbody id = "getDataTable"> 
                    
<?php  

$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">

<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>

<th><?php 
  $sqlunit=$this->db->query("select * from tbl_category where id='$fetch_list->section'");
  $compRow = $sqlunit->row();
  echo $compRow->name;    ?>
</th>
<th><?php  
  $tname=$this->db->query("select * from tbl_master_data where serial_number='$fetch_list->task_type'");
  $getTname=$tname->row();
  echo $getTname->keyvalue; ?>
</th>
<th><?php echo $fetch_list->start_date; ?></th>
<th><?php echo $fetch_list->date_completed; ?></th>

<th><?php echo $fetch_list->time_estimate; ?></th>
<th><?php echo $fetch_list->time_spent; ?></th>

<th><?php echo $fetch_list->cost_estimate; ?></th>
<th><?php echo $fetch_list->cost_spent; ?></th>
</tr>

<?php $i++; } ?>
</tbody>
