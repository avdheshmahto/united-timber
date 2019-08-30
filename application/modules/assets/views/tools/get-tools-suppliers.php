<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadsuppliers" >
  <thead>
    <tr>
      <th>Suppliers Name</th>
      <th>Suppliers Type</th>
      <th>Supplier Part Number</th>
      <th>Catalog</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
        
        foreach($result as $fetch_list)
        {
         
         $contactQ=$this->db->query("select * from tbl_contact_m where contact_id='$fetch_list->suppliers_name'");
         $contactlist=$contactQ->row();
      
          $contactgroup=$this->db->query("select * from tbl_account_mst where status='A' and account_id='$fetch_list->suppliers_type'");
         $listcontactgroup=$contactgroup->row();
         
      ?>
    <tr class="gradeU record">
      <td><?=$contactlist->first_name;?></td>
      <td><?=$listcontactgroup->account_name;?></td>
      <td><?=$fetch_list->supplier_part_number;?></td>
      <td><?=$fetch_list->catalog_name;?></td>
      <td><?php $pri_col='id';
        $table_name='tbl_machine_suppliers';
        ?>
        <?php if($view!=''){ ?>
        <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Suppliers"><i class="icon-trash"></i></button> 
        <?php }?>
      </td>
    </tr>
    <?php }?>
    <tr class="gradeU">
      <td>
        <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#machinesuppliers' onclick="addMachineSuppliers('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Suppliers"><img src="<?=base_url();?>assets/images/plus.png" /></button>
      </td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>