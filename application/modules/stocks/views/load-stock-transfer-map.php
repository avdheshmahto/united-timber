<div class="tabs-container">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#stock_transfer" data-toggle="tab">Stock Transfer</a></li>
    <li><a href="#stock_transfer_log" data-toggle="tab">Stock Transfer Log</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="stock_transfer">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlogspare" >
            <thead>
              <tr>
                <th>S. No.</th>
                <th>Parts & Supplies Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Rack</th>
                <th>Vendor Name</th>
                <th>Purchase Price</th>
                <th>Quantity</th>
                <th>Stock Transfer</th>
              </tr>
            </thead>
            <tbody id="getDataTable" >
              <?php
                $z=1;
                
                $result=$this->db->query("select * from tbl_product_serial where product_id='$id' ")->result();
                foreach($result as $fetch){
                ?>
              <tr class="gradeC record">
                <?php  
                  $locaquery = $this->db->query("select * from tbl_product_stock where Product_id='".$fetch->product_id."'");
                  $getlocate = $locaquery->row();
                  
                  $vnd=$this->db->query("select * from tbl_contact_m where contact_id = '$fetch->supp_name' ");
                  $getVnd=$vnd->row();
                  
                  $main_locQuery = $this->db->query("select * from tbl_master_data where serial_number='".$fetch->loc."'");
                  $getmain_loc = $main_locQuery->row();
                  
                  $main_rackQuery = $this->db->query("select * from tbl_location_rack where id='".$fetch->rack_id."'");
                  $getmain_rack = $main_rackQuery->row();
                  
                  ?>
                <th><?php echo $z++; ?></th>
                <th><?php echo $getlocate->productname; ?></th>
                <th><?php echo $fetch->module_status; ?></th>
                <th><?php echo $getmain_loc->keyvalue; ?></th>
                <th><?php echo $getmain_rack->rack_name; ?></th>
                <th><?php echo $getVnd->first_name; ?></th>
                <th><?php echo $fetch->purchase_price; ?></th>
                <th><?php echo $fetch->quantity; ?></th>
                <td>
                  <button  class="btn btn-default" href='#StockTransfer' onclick="stockTransfer('<?=$fetch->serial_number;?>','<?=$fetch->product_id;?>','<?=$fetch->module_status;?>')"  data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Stock Transfer"><img src="<?=base_url();?>assets/images/plus.png" /></button>
                </td>
              </tr>
              <?php  }  ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="tab-pane" id="stock_transfer_log">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadlogspare" >
            <thead>
              <tr>
                <th>S. No.</th>
                <th>Parts & Supplies Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Rack</th>
                <th>Vendor Name</th>
                <th>Purchase Price</th>
                <th>Quantity</th>
                <th>Transfer Date</th>
                <th>Transfer Status</th>
              </tr>
            </thead>
            <tbody id="getDataTable" >
              <?php
                $y=1;
                
                $result=$this->db->query("select * from tbl_stock_transfer_log where product_id='$id' AND type='stock transfer' order by serial_number asc ")->result();
                foreach($result as $fetch){
                ?>
              <tr class="gradeC record">
                <?php  
                  $locaquery = $this->db->query("select * from tbl_product_stock where Product_id='".$fetch->product_id."'");
                  $getlocate = $locaquery->row();
                  
                  $vnd=$this->db->query("select * from tbl_contact_m where contact_id = '$fetch->supp_name' ");
                  $getVnd=$vnd->row();
                  
                  $main_locQuery = $this->db->query("select * from tbl_master_data where serial_number='".$fetch->loc."'");
                  $getmain_loc = $main_locQuery->row();
                  
                  $main_rackQuery = $this->db->query("select * from tbl_location_rack where id='".$fetch->rack_id."'");
                  $getmain_rack = $main_rackQuery->row();
                  
                  ?>
                <th><?php echo $y++; ?></th>
                <th><?php echo $getlocate->productname; ?></th>
                <th><?php echo $fetch->module_status; ?></th>
                <th><?php echo $getmain_loc->keyvalue; ?></th>
                <th><?php echo $getmain_rack->rack_name; ?></th>
                <th><?php echo $getVnd->first_name; ?></th>
                <th><?php echo $fetch->purchase_price; ?></th>
                <th><?php echo $fetch->quantity; ?></th>
                <th><?php echo $fetch->maker_date; ?></th>
                <th><?php echo $fetch->name_role; ?></th>
              </tr>
              <?php  }  ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!--tabs-container close-->