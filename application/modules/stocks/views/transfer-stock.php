<?php 
  $Query=$this->db->query("select * from tbl_product_serial where product_id='$pid' AND serial_number='$sno' AND module_status='$typ' ");
  $getQuery=$Query->row();
  
  $prd = $this->db->query("select * from tbl_product_stock where Product_id='".$getQuery->product_id."'");
  $getPrd = $prd->row();
  
  $vnd=$this->db->query("select * from tbl_contact_m where contact_id = '".$getQuery->supp_name."' ");
  $getVndr=$vnd->row();
  
  $loc = $this->db->query("select * from tbl_master_data where serial_number='".$getQuery->loc."'");
  $getLoc = $loc->row();
  
  $rack = $this->db->query("select * from tbl_location_rack where id='".$getQuery->rack_id."'");
  $getRack = $rack->row();
  
  ?>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Add Stock Transfer</h4>
    <div id="resultareatransfer" class="text-center " style="font-size: 15px;color: red;"></div>
  </div>
</div>
<div class="modal-body overflow">
  <table class="table table-striped table-bordered table-hover">
    <tr class="gradeA">
      <th>
        <div style1="width: 100px;">Parts & Supplies Name</div>
      </th>
      <th>Type</th>
      <th>Location</th>
      <th>Rack</th>
      <th>Vendor Name</th>
      <th>Purchase Price</th>
      <th>Qty In Stock</th>
      <th>Enter Qty</th>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="product_id1" id="product_id1" class="form-control" value="<?=$getPrd->Product_id?>"><?=$getPrd->productname?>
      </td>
      <td>
        <input type="hidden" name="via_type1" id="via_type1" class="form-control" value="<?=$getPrd->via_type?>"><?=$getPrd->via_type?>
      </td>
      <td>
        <input type="hidden" name="location_id1" id="location_id1" class="form-control" value="<?=$getQuery->loc?>"><?=$getLoc->keyvalue?>
      </td>
      <td>
        <input type="hidden" name="rack_id1"  id="rack_id1" class="form-control" value="<?=$getQuery->rack_id?>"><?=$getRack->rack_name?>
      </td>
      <td>
        <input type="hidden" name="vendor_id1" id="vendor_id1" class="form-control" value="<?=$getQuery->supp_name?>"><?=$getVndr->first_name?>
      </td>
      <td>
        <input type="hidden" name="purchase_price1" id="purchase_price1" class="form-control" value="<?=$getQuery->purchase_price?>"><?=$getQuery->purchase_price?>
      </td>
      <td>
        <input type="hidden" name="stock_qty1" id="stock_qty1" class="form-control" value="<?=$getQuery->quantity?>"><?=$getQuery->quantity?>
      </td>
      <td>
      </td>
    </tr>
    <tr>
      <th><input type="hidden" name="product_id" id="product_id" class="form-control" value="<?=$getPrd->Product_id?>"><?=$getPrd->productname?>
      </th>
      <th>
        <input type="hidden" name="via_type" id="via_type" class="form-control" value="<?=$getPrd->via_type?>"><?=$getPrd->via_type?>
      </th>
      <th>
        <select name="location_id" id="location_rack_id" onchange="getRackFun(this.id);" class="form-control" >
          <option value="">----Select ----</option>
          <?php
            $bookingType=$this->db->query("select *from tbl_master_data  where param_id='21'");
            foreach($bookingType->result() as $getBooking){
            ?>
          <option value="<?=$getBooking->serial_number;?>"><?=$getBooking->keyvalue;?></option>
          <?php }?>
        </select>
        <p id="qty_pallet"></p>
      </th>
      <th>
        <select name="rack_id" class="form-control" id="rack_id" onchange="getQty(this.id);vendor_func(this.value);checkLoc();" >
          <option value="">----Select ----</option>
        </select>
      </th>
      <th>
        <select name="vendor_id" id="vendor_id" class="form-control" required="">
          <option value="">----Select ----</option>
        </select>
      </th>
      <th>
        <input type="text" name="purchase_price" id="purchase_price" class="form-control" required="">
      </th>
      <th>
        <p id="getQn" value=""></p>
      </th>
      <th>
        <input type="number" name="qtyid" id="qtyid" onkeyup="checkQtyVal()" class="form-control" required="">
      </th>
    </tr>
    <tr>
      <th colspan="6">&nbsp;</th>
      <th>
        <input type="submit" id="stockSubmit" class="btn btn-sm savebutton pull-right" value="Save"> 
      </th>
      <th>
        <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
      </th>
    </tr>
  </table>
</div>