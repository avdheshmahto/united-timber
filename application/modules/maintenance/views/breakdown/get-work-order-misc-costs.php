<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadmisc" >
   <thead>
      <tr>
         <th>Type</th>
         <th>Description</th>
         <th>Est Quantity</th>
         <th>Est Unit Cost</th>
         <th>Est Total Cost</th>
         <th>Actual Quantity</th>
         <th>Actual Unit Cost</th>
         <th>Actual Total Cost</th>
      </tr>
   </thead>
   <tbody>
      <?php 
         $i=1;
         
         $miscName=$this->db->query("select * from tbl_work_order_misc_costs where work_order_id='$id' and status='A'");
           foreach($miscName->result() as $fetch_misc)
           {
            
         ?>
      <tr class="gradeU record">
         <td><?=$fetch_misc->type_name; ?></td>
         <td><?=$fetch_misc->desc_name; ?></td>
         <td><?=$fetch_misc->est_qty; ?></td>
         <td><?=$fetch_misc->est_unit_cost; ?></td>
         <td><?=$fetch_misc->est_total_cost; ?></td>
         <td><?=$fetch_misc->act_qty; ?></td>
         <td><?=$fetch_misc->act_unit_cost; ?></td>
         <td><?=$fetch_misc->act_total_cost; ?></td>
      </tr>
      <?php } ?>
      <tr class="gradeU">
         <td>
            <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#misccostid'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Misc Costs"><img src="<?=base_url();?>assets/images/plus.png" /></button>  
         </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
   </tbody>
</table>