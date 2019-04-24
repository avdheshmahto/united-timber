<?php
$ID=$id;
?>
     <div class="row">
			<div class="col-lg-12">
        <div class="row">
		 <div class="panel-body">
          <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
											<div class="panel-body">
												<h4>SPARE NAME :- <br/> <span style="color: #1b87d2;;">
										<?php
											
   $machineQuery=$this->db->query("select *from tbl_machine_spare_map where spare_id='$ID'");
 $getMachine = $machineQuery->row(); 
?>

											<?php $queryType=$this->db->query("select *from tbl_product_stock where Product_id='$getMachine->spare_id'");
$getType=$queryType->row();

 ?>	
												
									<?php echo $getType->productname;  ?>
												
												</span></h4>
												
  <div class="row">
<div class="col-lg-12">
									
  <h5>MACHINE DETAILS</h5>
   
  <table class="table">
	<thead>
	  <tr>
		<th>MACHINE CODE</th>
		<th>MACHINE NAME</th>
		<th>FACILITIES</th>
		<th>CAPACITY</th>
		<th>DESCRIPTION</th>
	  </tr>
	</thead>
	<tbody>
  <?php 
   $machineQueryy=$this->db->query("select *from tbl_machine_spare_map where spare_id='$ID'");
 foreach($machineQueryy->result() as $machine_qry){ ?>
 	<?php $queryType_mac=$this->db->query("select *from tbl_machine where id='$machine_qry->machine_id'");
$getType_mac=$queryType_mac->row();

 ?>	
			
	  <tr>
		<td><?=$getType_mac->code;?></td>
		<td>
		<a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $getType_mac->id; ?>">
		<?=$getType_mac->machine_name;?></a></td>
		<td><?php $queryType_macs=$this->db->query("select *from tbl_facilities where id = '$getType_mac->m_type'");
$getType_macww=$queryType_macs->row();

 ?>	
		
		<?=$getType_macww->fac_name;?></td>
		<td>
			<?=$getType_mac->capacity;?>
		 </td>
		 <td><?=$getType_mac->machine_des;?></td>
	  </tr>
 <?php } ?>
	</tbody>
  </table>

</div></div>                                           



</div>
</div>
</div>
</div>

	<!-- <div class="table-responsive-">
   </div> -->
  </div>

    

   </div>
     
   <div class ="pull-right">
    
		<a  class="btn btn-sm btn-black btn-outline"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancel</a>
    </div>
</div>
</div> 

