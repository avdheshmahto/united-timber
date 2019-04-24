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
												<h4>TOOL NAME :- &nbsp;&nbsp; <span style="color: #1b87d2; font-size:16px;">
										<?php
											
   $toolQuery=$this->db->query("select *from tbl_product_serial where product_id='$ID'");
 $gettool = $toolQuery->row(); 
?>

											<?php $queryType=$this->db->query("select *from tbl_product_stock where Product_id='$gettool->product_id' and type ='tool'");
$getType=$queryType->row();

 ?>	
												
									<?php echo $getType->productname;  ?>
												
												</span></h4>
												
  <div class="row">
<div class="col-lg-12">
									
  <p>TOOL DETAILS</p>
   
  <table class="table">
	<thead>
	  <tr>
		<!--<th>TOOL SERIAL NUMBER</th>
		<th>TOOL TYPE</th>-->
		<th>LOCATION</th>
		<th>RACK</th>
		<th>QUANTITY</th>
		<!--<th>TOTAL QUANTITY</th>-->
	  </tr>
	</thead>
	<tbody>
  <?php 
   $toolQuery=$this->db->query("select *from tbl_product_serial where product_id='$ID'"); 
 	foreach($toolQuery->result() as $gettool){ ?>
	
 	<?php $queryType_tool=$this->db->query("select *from tbl_master_data where serial_number='$gettool->loc'");
			$getType_tool=$queryType_tool->row();

			$queryType_tools=$this->db->query("select *from tbl_location_rack where id='$gettool->rack_id'");
			$getType_tools=$queryType_tools->row();
			
			$queryType_toolss=$this->db->query("select *from tbl_product_stock where Product_id='$gettool->product_id' and type ='tool'");
			$getType_toolss=$queryType_toolss->row();
			
			$queryType_toolty=$this->db->query("select *from tbl_master_data where serial_number='$getType_toolss->type_of_spare'");
			$getType_toolty=$queryType_toolty->row();
 ?>	
			
	  <tr>
		<!--<td><?=$getType_toolss->sku_no;?></td>
		<td><?=$getType_toolty->keyvalue;?></td>-->
		
		<td><?=$getType_tool->keyvalue;?></td>
		<td><?=$getType_tools->rack_name;?></td>
		
		 <td><?=$gettool->quantity;?></td>
		<!-- <td><?=$getType_toolss->quantity;?></td>-->
	  </tr>
 <?php } ?>
	</tbody>
	

	  <tr style="background-color:#ECF0F2;">
	  <td></td>
			<th>TOTAL QUANTITY</th>
			<td><b><?=$getType_toolss->quantity;?></b></td> 
	  </tr>
	  <tbody>
	  <?php $queryType=$this->db->query("select *from tbl_product_stock where Product_id='$gettool->product_id' and type ='tool'");
$getType=$queryType->row();

 ?>	
 <tr>
 
		 
 </tr>
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

