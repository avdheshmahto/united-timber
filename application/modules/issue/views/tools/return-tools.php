<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">TOOLS RETURN</h4>
  </div>
</div>
<div class="modal-body overflow">
  <div id="resultreturn" class="text-center " style="font-size: 15px;color: red;"></div>
  <table class="table table-striped table-bordered table-hover">
    <input type="hidden" name="issue_id" id="issue_id" value="<?=$sid?>">
    <input type="hidden" name="section" id="section" value="<?=$fid?>">
    <input type="hidden" name="type_id" id="type_id" value="<?=$tid?>">
    <input type="hidden" name="status" id="status" value="<?=$sts?>">
    <input type="hidden" name="machine" id="machine" value="<?=$mac?>">
    <tr>
      <th>Product Name</th>
      <th>Type</th>
      <th>Location</th>
      <th>Rack</th>
      <th>Vendor Name</th>
      <th>Purchase Price</th>
      <th>Issued Qty</th>
      <th>Returned Qty</th>
      <th>Remaining Qty</th>
      <th>Enter Return Qty</th>
    </tr>
    <?php 
      $z=0;
      $key=$this->db->query("select * from tbl_tools_issue_dtl where issue_id_hdr='$sid' ");
      $cnt=$key->num_rows();
      
      foreach ($key->result() as $value) { 
      
      $prd=$this->db->query("select * from tbl_product_stock where product_id='$value->spare_id' ");
      $getPrd=$prd->row();
      
      $loc=$this->db->query("select * from tbl_master_data where serial_number='$value->location' AND param_id='21' ");
      $getLoc=$loc->row();
      
      $rack=$this->db->query("select * from tbl_location_rack where id='$value->rack' ");
      $getRack=$rack->row();
      
      $vndr=$this->db->query("select * from tbl_contact_m where contact_id='$value->vendor' ");
      $getVndr=$vndr->row();
      
      $rtqty=$this->db->query("select * from tbl_tools_return_hdr where issue_id='$sid'");
      $getRt=$rtqty->row();
      
      $ttlqty=$this->db->query("select SUM(qty) as totalreturnqty from tbl_tools_return_dtl where return_id_hdr='$getRt->return_id' AND spare_id='$value->spare_id'");
      $getTtlrtQty=$ttlqty->row();
      
      ?>
    <tr>
      <td>
        <input type="hidden" name="product_id[]" id="product_id<?php echo $z;?>" class="form-control" value="<?=$value->spare_id?>"><?=$getPrd->productname?>
      </td>
      <td>
        <input type="hidden" name="via_type[]" id="via_type<?php echo $z;?>" class="form-control" value="<?=$value->type?>"><?=$value->type?>
      </td>
      <td>
        <input type="hidden" name="location_id[]" id="location_id<?php echo $z;?>" class="form-control" value="<?=$value->location?>"><?=$getLoc->keyvalue?>
      </td>
      <td>
        <input type="hidden" name="rack_id[]"  id="rack_id<?php echo $z;?>" class="form-control" value="<?=$value->rack?>"><?=$getRack->rack_name?>
      </td>
      <td>
        <input type="hidden" name="vendor_id[]" id="vendor_id<?php echo $z;?>" class="form-control" value="<?=$value->vendor?>"><?=$getVndr->first_name?>
      </td>
      <td>
        <input type="hidden" name="purchase_price[]" id="purchase_price<?php echo $z;?>" class="form-control" value="<?=$value->price?>"><?=$value->price?>
      </td>
      <td>
        <input type="hidden" name="issue_qty[]" id="issue_qty<?php echo $z;?>" class="form-control" value="<?=$value->qty?>"><?=$value->qty?>
      </td>
      <td>
        <input type="hidden" name="returned_qty[]" id="returned_qty<?php echo $z;?>" class="form-control" value="<?=$getTtlrtQty->totalreturnqty?>"><?=$getTtlrtQty->totalreturnqty?>
      </td>
      <td>
        <input type="hidden" name="remain_qty[]" id="remain_qty<?php echo $z;?>" class="form-control" value="<?=$value->qty - $getTtlrtQty->totalreturnqty?>"><?=$value->qty - $getTtlrtQty->totalreturnqty?>
      </td>
      <td>
        <input type="number" name="return_qty[]" id="return_qty<?php echo $z;?>" onkeyup="returnQtyFunc(this.id);" class="form-control">
      </td>
    </tr>
    <?php $z++; } ?>
    <input type="hidden" value="<?=$cnt?>" name="cntVal" id="cntVal">
    <tr>
      <th colspan="8">&nbsp;</th>
      <th>
        <input type="submit" id="returnButton" class="btn btn-sm savebutton pull-right" value="Save"> 
      </th>
      <th>
        <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
      </th>
    </tr>
  </table>
</div>