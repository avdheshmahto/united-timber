<Select  name="zone_id" class="form-control">
  <option value="">--Select--</option>
  <?php
  		   $engQuery = $this -> db
           -> select('*')
           -> where('comp_id',$zone_id)
           -> get('tbl_region_mst');
	
 foreach($engQuery->result() as $custRow){

?>
  <option value="<?php echo $custRow->zone_id; ?>"><?php echo $custRow->zone_name; ?></option>
  <?php } ?>
  </Select>
