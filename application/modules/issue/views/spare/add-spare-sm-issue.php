<?php
  $this->load->view("header.php");
  $scheQuery=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' and status = 'A'");
  $getsched=$scheQuery->row();
  
  $sqlunitmachine=$this->db->query("select * from tbl_machine where id='".$getsched->machine_name."'");
  $compRowmachine = $sqlunitmachine->row();
  ?>
<style type="text/css">
  .select2-container--open {
  z-index: 99999999 !important;
  }
  .select2-container {
  min-width: 256px !important;
  }
</style>
<div class="main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">PARTS & SUPPLIES ISSUE</h4>
          <!-- <ul class="panel-tool-options"> 
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
            </ul> -->
        </div>
        <div class="row centered-form">
          <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
                <h3 class="panel-title" style="float: initial;">Work Order Details:-  WO<?=$getsched->id."&nbsp;&nbsp;SM".$getsched->schedule_id;?>
                  <a href="<?=base_url('issue/SpareIssue/manage_spare_issue');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
                </h3>
              </div>
              <div class="panel-body">
                <form role="form">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Machine Name</h4>
                        <input type="text" name="" value="<?=$compRowmachine->machine_name;?>" id="first_name" class="form-control" readonly >
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Priority</h4>
                        <?php 
                          $queryType100=$this->db->query("select * from tbl_master_data where serial_number='$getsched->priority'");
                          $getType100=$queryType100->row();
                          ?>
                        <input type="text" name="" class="form-control" value="<?=$getType100->keyvalue;?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <?php if($getsched->trigger_code !=''){ ?>
                      <h4>Trigger Code</h4>
                      <div class="form-group">
                        <input type="text" name="" value="<?="TR".$getsched->trigger_code;?>" class="form-control" readonly>
                      </div>
                      <?php } ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Maintenance Type</h4>
                        <?php 
                          $queryType=$this->db->query("select *from tbl_master_data where serial_number='$getsched->maintyp'");
                          $getType=$queryType->row();
                          
                          ?>
                        <input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Work Order Status</h4>
                        <?php 
                          $queryType=$this->db->query("select *from tbl_master_data where serial_number='$getsched->wostatus'");
                          $getType=$queryType->row();
                          ?>
                        <input type="text" name="" value="<?=$getType->keyvalue;?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Completed Date</h4>
                        <input type="text" name=""  value="<?=$getsched->date_time;?>" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs-container">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#spare" data-toggle="tab">Workorder Parts & Supplies</a></li>
            <!-- <li><a href="#sparelog" data-toggle="tab">Spare Issue Log</a></li> -->
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="spare">
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadspareparts" >
                    <thead>
                      <tr>
                        <th>Order No.</th>
                        <th>Order Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=1;
                        $spareq=$this->db->query("select * from tbl_workorder_spare_hdr where work_order_id='$getsched->id' and type = 'Parts'");
                        foreach($spareq->result() as $fetch_spares)
                        {
                        ?>
                      <tr class="gradeU record">
                        <td>
                          <a href="<?=base_url();?>issue/SpareIssue/view_spare_sm_issue?id=<?=$getsched->id?>&shid=<?=$fetch_spares->spare_hdr_id?>" title="View Parts And Supplies"> <?=sprintf('%03d',$fetch_spares->spare_hdr_id); ?></a>
                        </td>
                        <td><?php echo $fetch_spares->maker_date; ?></td>
                        <td><?php
                          $dtl=$this->db->query("select *,SUM(qty_name) as reqstQty,SUM(issue_qty) as issueQty from tbl_workorder_spare_dtl where spare_hdr_id='$fetch_spares->spare_hdr_id'");
                          $getDtl=$dtl->row();
                            
                          if($getDtl->issueQty == 0)
                          {
                            echo "Open";
                          }
                          else if($getDtl->issueQty < $getDtl->reqstQty)
                          {
                            echo "Partial Completed";
                          }
                          else if($getDtl->issueQty == $getDtl->reqstQty)
                          {
                            echo "Completed";
                          }
                          ?></td>
                      </tr>
                      <?php } ?>
                      <tr class="gradeU" style="display: none;">
                        <td>
                          <button  class="btn btn-default" href='#spareIssue'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare Issue"><img src="<?=base_url();?>assets/images/plus.png" /></button> 
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- ======================================= Add Spare =============================== -->
            <div id="spareIssue" class="modal fade modal" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-contentMap" id="modal-contentMap">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Spare Issue</h4>
                    <br>
                    <div id="resultareaissue" class="text-center " style="font-size: 15px;color: red;"></div>
                    <form id="formspareissue" method="post">
                      <table class="table table-striped table-bordered table-hover">
                        <tr class="gradeA">
                          <th>
                            <div style1="width: 100px;">Parts & Supplies Name</div>
                          </th>
                          <th>Location</th>
                          <th>Rack</th>
                          <th>Vendor Name</th>
                          <th>Purchase Price</th>
                          <th>Qty In Stock</th>
                          <th>Enter Qty</th>
                          <th></th>
                        </tr>
                        <tr>
                          <th>
                            <select name="spare_name" id="spare_nameid" class="select2 form-control" onchange="via_type_func(this.value);">
                              <option value="">---select---</option>
                              <?php 
                                $sqlunit=$this->db->query("select * from tbl_product_stock where via_type!='Spare' and status='A'");
                                foreach ($sqlunit->result() as $fetchunit){
                                ?>
                              <option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
                              <?php } ?>
                            </select>
                            <input type="hidden" id="product_types" name="product_types">
                          </th>
                          <th>
                            <select name="location_id" id="location_rack_id" onchange="getRackFun(this.id);" class="form-control">
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
                            <select name="rack_id" class="form-control" id="rack_id" onchange="getQty(this.id);vendor_func(this.value);"   >
                              <option value="">----Select ----</option>
                            </select>
                          </th>
                          <th>
                            <select name="vendor_id" id="vendor_id" class="form-control" onchange="price_func(this.value)">
                              <option value="">----Select ----</option>
                            </select>
                          </th>
                          <th>
                            <select name="purchase_price" id="purchase_price" class="form-control">
                              <option value="">---Select---</option>
                            </select>
                          </th>
                          <th>
                            <p id="getQn" value=""></p>
                          </th>
                          <th><input type="number" name="qtyname" id="qtyid" onkeyup="checkQtyVal()" class="form-control"></th>
                          <th><button  class="btn btn-default"  type="button" onclick="addrowsIssue()"><img src="<?=base_url();?>assets/images/plus.png" />
                            </button>
                          </th>
                        </tr>
                        <tr class="gradeA">
                          <th colspan="5">&nbsp;</th>
                        </tr>
                        <tbody>
                          <tr class="gradeA">
                            <th>
                              <div style1="width: 100px;">Parts & Supplies Name</div>
                            </th>
                            <th>Location</th>
                            <th>Rack</th>
                            <th>Vendor Name</th>
                            <th>Purchase Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                            <th></th>
                          </tr>
                        </tbody>
                        <tbody id="dataTable">
                        </tbody>
                        <tr>
                          <th colspan="6">&nbsp;</th>
                          <th>
                            <input type="submit" id="Psubmitform" class="btn btn-sm savebutton pull-right" value="Save"> 
                          </th>
                          <th>
                            <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
                          </th>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- ==================================================================================== -->
          </div>
        </div>
        <!--tabs-container close-->
      </div>
    </div>
  </div>
</div>
<?php
  $this->load->view("footer.php");
  ?>