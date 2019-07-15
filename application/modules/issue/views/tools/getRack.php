<option value="">----Select ----</option>
<?php
$rackQuery=$this->db->query("select *from tbl_location_rack where location_rack_id='$id'");
foreach($rackQuery->result() as $getRac){
?>
<option value="<?=$getRac->id;?>"><?=$getRac->rack_name;?></option>
<?php }?>
