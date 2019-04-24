<?php
  $tableName="tbl_region_mst";

 //$zone_id=$_GET['search_user'];
  //primary ref id 
  ?>
  <Select class="rounded" id="url" name="zone_id" class="form-control" onChange="getBranch(this.value)" >
    <option value="">--Select--</option>
  <?php
  $engQuery=$this->db->query("select * from $tableName where comp_id = '$zone_id'");
 //while($custRow=mysql_fetch_array($engQuery))
 foreach($engQuery->result() as $custRow){

?>
  <option value="<?php echo $custRow->zone_id; ?><?php  if($custRow->zone_id==$zone_id) {  ?> selected <?php } ?>"><?php echo $custRow->zone_name; ?></option>
  <?php } ?>
  </Select>
