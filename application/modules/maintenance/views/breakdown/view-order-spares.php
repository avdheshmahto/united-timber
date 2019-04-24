<?php
$scheduleQuery=$this->db->query("select * from tbl_workorder_spare_hdr where spare_hdr_id='$id' AND type='Parts'");
$getSchedule=$scheduleQuery->row();
?>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">View Parts & Supplies (<?=sprintf('%03d',$id); ?>)</h4>
</div>
</div>

<div class="modal-body overflow">
<table class="table table-striped table-bordered table-hover">
				  <tbody>
			   		<tr class="gradeA">
						<th colspan="5"><center>Parts & Supplies List</center></th>
					</tr>
					<tr class="gradeA">
						
						<th>S.No.</th>
						<th>Parts & Supplies Name</th>
						<th>Type</th>
						<th>Request Quantity</th>
						<th>Receive Quantity</th>	
						
					</tr>
			<?php
			$i=1;
				
				$smsparelogQuery=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='$getSchedule->spare_hdr_id'");
				foreach($smsparelogQuery->result() as $getSmlog){

					$sqlunit=$this->db->query("select * from tbl_product_stock where via_type!='Tools' and status='A' and Product_id='$getSmlog->spare_id'");
					$fetchunit=$sqlunit->row();
			?>
					<tr class="gradeA">
					
						<th><?php echo $i;?></th>
						<th><?php echo $fetchunit->productname;?></th>
						<th><?php echo $fetchunit->via_type;?></th>
						<th><?php echo $getSmlog->qty_name;?></th>
						<th><?php if($getSmlog->issue_qty != '')
						{ 
							echo $getSmlog->issue_qty; 
						} else { 
							echo 0; 
						} ?>
							
						</th>
						
					</tr>
			<?php $i++; } ?>			
				</tbody>
		  </table>
</div>

<div class="modal-footer" id="button">
<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>

</div><!-- /.modal-content -->

