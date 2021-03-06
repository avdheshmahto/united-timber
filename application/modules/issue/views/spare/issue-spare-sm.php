<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">PARTS & SUPPLIES ISSUE SM</h4>
  </div>
</div>
<div class="modal-body overflow">
  <div id="resultspare" class="text-center " style="font-size: 15px;color: red;"></div>
  <table class="table table-striped table-bordered table-hover">
    <?php 
      $spHdr=$this->db->query("select * from tbl_spare_issue_hdr where spare_id='$pid' AND workorder_id='$wid' AND workorder_spare_id='$hid'");
      $getSpHdr=$spHdr->row();
      
      $sidtl=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='$hid' AND spare_id='$pid' ");
      $getDtl=$sidtl->row();
      
      $prd=$this->db->query("select * from tbl_product_stock where product_id='$getDtl->spare_id' ");
      $getPrd=$prd->row();
      
      ?>
    <input type="text" name="workorder_id" id="workorder_id" value="<?=$wid?>" style="display: none;">
    <input type="text" name="workorder_spare_id" id="workorder_spare_id" value="<?=$hid?>" style="display: none;">
    <input type="text" name="spareids" id="spareids" value="<?=$pid?>" style="display: none;">
    <input type="text" name="via_types" id="via_types" value="<?=$getPrd->via_type?>" style="display: none;">
    <input type="text" name="reqstQty" id="reqstQty" value="<?=$getDtl->qty_name?>" style="display: none;">
    <tr>
      <th colspan="2">Parts & Supplies Name</th>
      <th colspan="2">Type</th>
      <th>Issue Date</th>
      <th>Shift</th>
    <tr>
    <tr>
      <td colspan="2"><?=$getPrd->productname?></td>
      <td colspan="2"><?=$getPrd->via_type?></td>
      <td><input type="date" name="issue_date" class="form-control"  <?php if($getSpHdr->issue_date != '') { ?> value="<?=$getSpHdr->issue_date ?>" readonly <?php } ?> ></td>
      <td>
        <select name="shift" id="shift" class="form-control" <?php if($getSpHdr->shift != '') { ?> disabled <?php } ?>
          >
          <option>--Select--</option>
          <option value="Day" <?php if($getSpHdr->shift == 'Day') { ?> selected <?php } ?> >Day</option>
          <option value="Night" <?php if($getSpHdr->shift == 'Night') { ?> selected <?php } ?> >Night</option>
        </select>
      </td>
    </tr>
    <?php 
      $remainQty=$getDtl->qty_name - $getDtl->issue_qty;
      ?>
    <tr style="height: 25px;">
      <th colspan="6"></th>
    </tr>
    <tr>
      <th>Requested Qty</th>
      <td><?=$getDtl->qty_name?></td>
      <th>Issued Qty</th>
      <td><?=$getDtl->issue_qty?></td>
      <th>Remaining Qty</th>
      <td><?=$remainQty?></td>
      <input type="hidden" name="remainQty" id="remainQty" value="<?=$remainQty?>">
    </tr>
    <tr style="height: 25px;">
      <th colspan="6"></th>
    </tr>
    <tr>
      <th>Location</th>
      <th>Rack</th>
      <th>Vendor Name</th>
      <th>Purchase Price</th>
      <th>Qty In Stock</th>
      <th>Enter Issue Qty</th>
    </tr>
    <?php 
      $z=0;
      $key=$this->db->query("select * from tbl_product_serial where product_id='$pid'");
      $cnt=$key->num_rows();
      foreach ($key->result() as $value) { 
      
      $loc=$this->db->query("select * from tbl_master_data where serial_number='$value->loc' AND param_id='21' ");
      $getLoc=$loc->row();
      
      $rack=$this->db->query("select * from tbl_location_rack where id='$value->rack_id' ");
      $getRack=$rack->row();
      
      $vndr=$this->db->query("select * from tbl_contact_m where contact_id='$value->supp_name' ");
      $getVndr=$vndr->row();
      ?>
    <tr>
      <td>
        <input type="hidden" name="location_id[]" id="location_rack_id<?php echo $z;?>" class="form-control" value="<?=$value->loc?>"><?=$getLoc->keyvalue?>
      </td>
      <td>
        <input type="hidden" name="rack_id[]"  id="rack_id<?php echo $z;?>" class="form-control" value="<?=$value->rack_id?>"><?=$getRack->rack_name?>
      </td>
      <td>
        <input type="hidden" name="vendor_id[]" id="vendor_id<?php echo $z;?>" class="form-control" value="<?=$value->supp_name?>"><?=$getVndr->first_name?>
      </td>
      <td>
        <input type="hidden" name="purchase_price[]" id="purchase_price<?php echo $z;?>" class="form-control" value="<?=$value->purchase_price?>"><?=$value->purchase_price?>
      </td>
      <td>
        <input type="hidden" name="stk_qty[]" id="stk_qty<?php echo $z;?>" class="form-control" value="<?=$value->quantity?>"><?=$value->quantity?>
      </td>
      <td>
        <input type="number" name="spare_qty[]" id="spare_qty<?php echo $z;?>" onkeyup="qtyfunc(this.id);" class="form-control" value="">
      </td>
    </tr>
    <?php $z++; } ?>
    <input type="hidden" name="cntVal" id="cntVal" value="<?=$cnt;?>" />
    <tr>
      <th colspan="4">&nbsp;</th>
      <th>
        <input type="submit" id="issueButton" class="btn btn-sm savebutton pull-right" value="Save"> 
      </th>
      <th>
        <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
      </th>
    </tr>
  </table>
</div>