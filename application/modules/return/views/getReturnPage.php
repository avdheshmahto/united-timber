<table class="table table-striped table-bordered table-hover"> 
<?php 

  $z=0;
  $key=$this->db->query("select * from tbl_product_serial where product_id='$pid'");
  $cnt=$key->num_rows();
  foreach ($key->result() as $value) { 

  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$value->product_id' ");
  $getPrd=$prd->row();

  $loc=$this->db->query("select * from tbl_master_data where serial_number='$value->loc' AND param_id='21' ");
  $getLoc=$loc->row();

  $rack=$this->db->query("select * from tbl_location_rack where id='$value->rack_id' ");
  $getRack=$rack->row();

  $vndr=$this->db->query("select * from tbl_contact_m where contact_id='$value->supp_name' ");
  $getVndr=$vndr->row();
  
?>

<tr>    
    <input type="hidden" name="product_id" id="product_id<?php echo $z; ?>" class="form-control" value="<?=$value->Product_id?>">
    <input type="hidden" name="product" id="product<?php echo $z; ?>" class="form-control" value="<?=$value->productname?>">
    <input type="hidden" name="product_type" id="product_type<?php echo $z; ?>" class="form-control" value="<?=$getPrd->via_type?>">  
  
  <td>
    <input type="hidden" name="location_id" id="location_id<?php echo $z; ?>" class="form-control" value="<?=$value->loc?>">
    <input type="hidden" name="location" id="location<?php echo $z; ?>" class="form-control" value="<?=$getLoc->keyvalue?>"><?=$getLoc->keyvalue?>
  </td>            
  
  <td>
    <input type="hidden" name="rack_id"  id="rack_id<?php echo $z; ?>" class="form-control" value="<?=$value->rack_id?>">
    <input type="hidden" name="rack"  id="rack<?php echo $z; ?>" class="form-control" value="<?=$getRack->rack_name?>"><?=$getRack->rack_name?>
  </td>        
  
  <!--<td>
   <input type="hidden" name="vendor_id" id="vendor_id<?php echo $z; ?>" class="form-control" value="<?=$value->supp_name?>">
   <input type="hidden" name="vendor" id="vendor<?php echo $z; ?>" class="form-control" value="<?=$getVndr->first_name?>"><?=$getVndr->first_name?>
  </td> -->

  <td>
    <input type="hidden" name="purchase_price" id="purchase_price<?php echo $z; ?>" class="form-control" value="<?=$value->purchase_price?>"><?=$value->purchase_price?>
  </td>
  
  <td>
   <input type="hidden" name="stk_qty" id="stk_qty<?php echo $z; ?>" class="form-control" value="<?=$value->quantity?>"><?=$value->quantity?>
  </td>
  
  <td>
    <input type="number" name="rtrn_qty" id="rtrn_qty<?php echo $z; ?>" onkeyup="qtyfunction(this.id);" class="form-control" value="">
  </td>    
  
  <td>
  </td>

</tr>

<?php $z++; } ?>
<tr>
  <td colspan="5">
  </td>
  
  <td>
    <button  class="btn btn-default"  type="button" onclick="addMultiReturn()"><img src="<?=base_url();?>assets/images/plus.png" />
  </button>
  </td>

</tr>

<input type="hidden" name="cntVal" id="cntVal" value="<?=$cnt;?>" />

</table>
