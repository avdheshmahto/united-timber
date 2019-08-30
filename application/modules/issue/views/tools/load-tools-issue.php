<thead>
  <tr>
    <th>Issue Id</th>
    <th>Section</th>
    <th>Tools Issue</th>
    <th>Issued Date</th>
    <th>Issued Qty</th>
    <th>Returned Qty</th>
    <th>Remaining Qty</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
</thead>
<tbody id = "getDataTable">
  <tr style="display: none;">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <?php  
    $i=1;
    foreach($result as $fetch_list)
    {
    ?>
  <tr class="gradeC record " data-row-id="<?php echo $fetch_list->issue_id; ?>">
    <th><?php  //echo $i; ?><?=sprintf('%03d',$fetch_list->issue_id); ?></th>
    <th><a href="<?=base_url();?>issue/ToolsIssue/view_parts_issue?id=<?=$fetch_list->issue_id?>"><?php 
      $sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->section."'");
      $compRow = $sqlunit->row();
      echo $compRow->name;    ?></a></th>
    <th><?php 
      $chdr=$this->db->query("select * from tbl_tools_issue_dtl where issue_id_hdr='$fetch_list->issue_id' ");
          $count=$chdr->num_rows();
      
          $var = array();
          foreach($chdr->result() as $getHdr)
          {
            array_push($var, $getHdr->spare_id);
          }
      
          if($count > 0)
          {
            $sp_id=implode(',', $var);
          }
          else
          {
            $sp_id='99999999';
          }
      
          $prd=$this->db->query("select * from tbl_product_stock where Product_id IN ($sp_id) ");
      
          $sp_name=array();
          foreach($prd->result() as $getPrd)
          {
            array_push($sp_name, $getPrd->productname);
          }
      
          echo $sp_name[0];
          //print_r($sp_name);
      
       ?></th>
    <th><?php echo $fetch_list->issue_date; ?></th>
    <th><?php 
      $qty=$this->db->query("select SUM(qty) as totalqty from tbl_tools_issue_dtl where issue_id_hdr='$fetch_list->issue_id'");
      $getQty=$qty->row();
      
      echo $getQty->totalqty; ?></th>
    <th>
      <?php 
        $rtqty=$this->db->query("select * from tbl_tools_return_hdr where issue_id='$fetch_list->issue_id' ");
        $getRt=$rtqty->row();
        $rtdtl=$this->db->query("select SUM(qty) as dtlqty from tbl_tools_return_dtl where return_id_hdr='$getRt->return_id' ");
        $getDtl=$rtdtl->row();
        echo $getDtl->dtlqty;
        ?>
    </th>
    <th><?php echo $remqty=$getQty->totalqty - $getDtl->dtlqty; ?></th>
    <th><?php 
      if($getQty->totalqty == $getDtl->dtlqty)
      {
        echo "Completed";
      }
      else if($getQty->totalqty > $getDtl->dtlqty)
      {
        echo "Pending";
      }
      else
      {
        echo "Open";
      }
      
      //echo $fetch_list->issue_status; ?></th>
    <th><?php 
      $pri_col='issue_id';
      $table_name='tbl_tools_issue_hdr';
      
      
      $stfCostLog=$this->db->query("select * from tbl_tools_return_hdr where issue_id='".$fetch_list->issue_id."' ");
      $numCost=$stfCostLog->num_rows();
      
      // $sftStkLog=$this->db->query("select * from tbl_work_order_maintain where machine_name='".$fetch_list->id."' ");
      // $numStk=$sftStkLog->num_rows();
      
      $countRows=$numCost;
      
      if($countRows > 0 ) {  ?>
      <button class="btn btn-default" type="button" title="Delete Tools Issue" onclick="return confirm('Tools already map to return. You can not delete ?');"><i class="icon-trash"></i></button>
      <?php } else { ?>  
      <button class="btn btn-default delbutton_toolsissue" id="<?php echo $fetch_list->issue_id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>
      <?php  } ?>
    </th>
  </tr>
  <?php $i++; } ?>
</tbody>