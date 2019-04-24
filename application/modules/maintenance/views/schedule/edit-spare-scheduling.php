<?php
$scheduleQuery=$this->db->query("select *from tbl_work_order_spare_parts where id='$id'");
$getSchedule=$scheduleQuery->row();
?>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Edit Spare</h4>
<div id="resultareaeditspareschedule" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
		<div class="modal-body overflow">
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<input type="hidden" id="scheduled_id" name="scheduled_id" value="<?php echo $id;?>">
					<tr class="gradeA">
						<th>*Trigger Code</th>
						<th>
						<select name="trigger_code" id="trigger_codeid" onchange="sparevalidation()" class="form-control" disabled="disabled">
							<option value="">---select---</option>
							<?php 
								$sqltr=$this->db->query("select * from tbl_schedule_triggering where status='A' order by id desc");
								foreach ($sqltr->result() as $fetchtr){
							?>
							<option value="<?php echo $fetchtr->id;?>" <?php if($fetchtr->id==$getSchedule->trigger_code){ ?> selected <?php } ?>><?php echo 'TR'.$fetchtr->trigger_code; ?></option>
								<?php } ?>
						</select>
						</th>
						<th>*Spare Name</th>
						<th>
						<select name="spare_name" id="spare_nameid" class="form-control" onchange="sparevalidation()" disabled="disabled">
							<option value="">---select---</option>
							<?php 
								$sqlunit=$this->db->query("select * from tbl_product_stock where type='spare' and status='A'");
								foreach ($sqlunit->result() as $fetchunit){
							?>
							<option value="<?php echo $fetchunit->Product_id;?>" <?php if($fetchunit->Product_id==$getSchedule->spare_id){ ?> selected <?php } ?>><?php echo $fetchunit->productname; ?></option>
								<?php } ?>
						</select>
						<p id="existcodeid" class="text-center " style="font-size: 12px;color: red;"></p>
						</th>
					</tr>
					<tr>
						<th>*Quantity</th>
						<th><input type="number" name="suggested_qty" value="<?php echo $getSchedule->suggested_qty; ?>" class="form-control"></th>
					</tr>
					
					<tr>
						<th colspan="3">&nbsp;</th>
						<th>
							<input type="submit" class="btn btn-sm savebutton" value="Save">
							<button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
						</th>
					</tr>
			  </tbody>
		  </table>
</div>
</div><!-- /.modal-content -->

