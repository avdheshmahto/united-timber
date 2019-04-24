<?php
//$prorack=$_GET['prorack'];
//$racks=$_GET['selectval'];

//$loc=$_GET['loc'];
  ?>

  <Select class="form-control " name="category" >

    <option value="">--Select--</option>

  <?php
			//echo "dwbjf";
			
			$cateQuery=$this->db->query("select * from tbl_location_rack where location_rack_id='$id'");
			  foreach($cateQuery->result() as $getTypeQuery ){
			  ?>
			  <option value="<?php echo $getTypeQuery->id;?>" <?php if($racks == $getTypeQuery->id){ ?>selected<?php } ?>><?php echo $getTypeQuery->rack_name;?></option>
              
			  <?php }?>
  </Select>
?>