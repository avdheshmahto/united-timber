<?php
$scheduleQuery=$this->db->query("select *from tbl_schedule_spare_hdr where sm_hdr_id='$id'");
$getSchedule=$scheduleQuery->row();
?>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">View Spare</h4>
</div>
</div>

<div class="modal-body overflow">
<table class="table table-striped table-bordered table-hover">
				  <tbody>
			   		<tr class="gradeA">
						<th colspan="3"><center>Spare List (<?=sprintf('%03d',$id); ?>)</center></th>
					</tr>
					<tr class="gradeA">
						
						<th>S.No.</th>
						<th>Spare Name</th>
						<th>Quantity</th>					
						
					</tr>
			<?php
			$i=1;
				
				$smsparelogQuery=$this->db->query("select *from tbl_schedule_spare_dtl where sm_hdr_id='$getSchedule->sm_hdr_id'");
				foreach($smsparelogQuery->result() as $getSmlog){

					$sqlunit=$this->db->query("select * from tbl_product_stock where type='spare' and status='A' and Product_id='$getSmlog->spare_id'");
					$fetchunit=$sqlunit->row();
			?>
					<tr class="gradeA">
					
						<th><?php echo $i;?></th>
						<th><?php echo $fetchunit->productname;?></th>
						<th><?php echo $getSmlog->qty_name;?></th>
						
					</tr>
			<?php $i++; } ?>			
				</tbody>
		  </table>
</div>

<div class="modal-footer" id="button">
<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
</div>

</div><!-- /.modal-content -->

