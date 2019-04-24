<table class="table table-striped table-bordered table-hover dataTables-example1"  >
<thead>
<tr>
<th>S.No.</th>
<th>File Name</th>
<th>Description</th>
<th>Action</th>
</tr>
</thead>


<tbody>
<?php

$i=1;
$fileQ=$this->db->query("select * from tbl_machine_files_uploads where file_log_id='$id' and module_type='Machine'");
foreach($fileQ->result() as $fetch_list)
{

?>

   <tr class="gradeU record">
       
   <td><?=$fetch_list->id;?></td>
    <td><a target="blank" href="<?=base_url('filesimages/machinefiles');?>/<?=$fetch_list->file_name;?>"><?=$fetch_list->file_name;?></a></td>
    <td><?=$fetch_list->desc_id;?></td> 

       <td><?php $pri_col='id';
                  $table_name='tbl_machine_files_uploads';
         ?>
        <?php if($view!=''){ ?>
        
     <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button> 
    <?php }?>
    </td>

    </tr>

<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#addfiles'   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Files"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

</tbody>

</table>