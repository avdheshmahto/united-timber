<?php
  $this->load->view("header.php");
  $Query=$this->db->query("select * from tbl_product_stock where product_id='".$_GET['id']."'");
  $getQuery=$Query->row();
  
  $usut = $this->db->query("select * from tbl_master_data where serial_number='".$getQuery->usageunit."'");
  $getUnt = $usut->row();
  
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
          <h4 class="panel-title">STOCK TANSFER LIST</h4>
        </div>
        <div class="row centered-form">
          <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
                <h3 class="panel-title" style="float: initial;">Stock Transfer Details:-  <?=$getQuery->product_id?>
                  <a href="<?=base_url('stocks/stockTransfer/manage_stock_transfer');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
                </h3>
              </div>
              <div class="panel-body">
                <form role="form">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Parts & Supplies Name</h4>
                        <input type="text" name="" value="<?=$getQuery->productname;?>" class="form-control" readonly >
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Type</h4>
                        <input type="text" name="" class="form-control" value="<?=$getQuery->via_type;?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Uses Unit</h4>
                        <input type="text" name="" value="<?=$getUnt->keyvalue;?>" class="form-control" readonly >
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <h4>Quantity</h4>
                        <input type="text" name="" class="form-control" value="<?=$getQuery->quantity;?>" readonly >
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div id="loadAjax">
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
                          
                          $result=$this->db->query("select * from tbl_product_serial where product_id='".$_GET['id']."' ")->result();
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
                          
                          $result=$this->db->query("select * from tbl_stock_transfer_log where product_id='".$_GET['id']."' AND type='stock transfer' order by serial_number asc ")->result();
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
        </div>
      </div>
    </div>
  </div>
</div>
<!-- loadAjax close -->
<form class="form-horizontal" role="form" id="fromStockTransfer" method="post">
  <div id="StockTransfer" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-stock-transfer" id="modal-stock-transfer">
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  function stockTransfer(x,y,z)
  {
    //alert(v);
    var slno=x;
    var pid=y;
    var type=z;
    var xhttp = new XMLHttpRequest();
   
    xhttp.open("GET", "stock_transfer?SNO="+ slno + "&"+"PID="+ pid + "&"+"TYP="+ type, false);
    //xhttp.open("GET", "return_parts?ISD="+pro, false);
    // alert(xhttp.open);
    xhttp.send();
    //alert(xhttp.responseText);
    document.getElementById("modal-stock-transfer").innerHTML = xhttp.responseText;
  
  } 
  
  
  function getRackFun(v) 
  {
    
    //var zz=document.getElementById(v).id;
  
    //var myarra = zz.split("location_rack_id");
    //var asx= myarra[1];
    //alert(asx);
  
    var loc=document.getElementById("location_rack_id").value;
    //var main_loc=document.getElementById("main_loc"+asx).value;
    //alert(loc);
    var pri_id=document.getElementById("product_id").value;
    
    getPalletQty(loc,pri_id);
  
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "getRack?location_rack_id="+loc, false);
    xhttp.send();
    document.getElementById("rack_id").innerHTML = xhttp.responseText;
    //alert(xhttp.responseText);
    
  }
  
  function getPalletQty(loc,pri_id)
  {
    
      var strURL="getPalletQty?loc="+loc+"&pri_id="+pri_id;
  
      //alert(strURL);
      
      var req = getXMLHTTP();
      if (req) {
        req.onreadystatechange = function() {
        if (req.readyState == 4) {
          if (req.status == 200) {
            //var price=mtr*ext_per;
            //alert(req.responseText);
            document.getElementById('qty_pallet').innerHTML=req.responseText;
            
            //alert(idm);
            } else {
            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
            }
          }       
        }     
        req.open("GET", strURL, true);
        req.send(null);
      }
  }
  
  
  function vendor_func(v)
  {
    
    var pids = $("#product_id").val();
    var locs  = $("#location_rack_id").val();
    var racks = $("#rack_id").val();
  
    $.ajax({
      url  : "<?=base_url();?>stocks/stockTransfer/get_vendor_list",
      type : "POST",
      data : {'pid':pids,'loc':locs,'rack':racks},
      success:function(data)
      {
        //alert(data);
        $("#vendor_id").empty().append(data);
      }
  
    });
  
  }
  
  
  function price_func(v)
  {
    var pid  = $("#product_id").val();
    var loct  = $("#location_rack_id").val();
    var rackt = $("#rack_id").val();
    var vndr = $("#vendor_id").val();
    //alert(pid);
    $.ajax({
      url  : "<?=base_url();?>stocks/stockTransfer/get_price_list",
      type : "POST",
      data : {'prid':pid,'loc':loct,'rack':rackt,'vid':vndr},
      success:function(data)
      {
        //alert(data);
        $("#purchase_price").empty().append(data)
      }
    })
  }
  
  function getQty(v) 
  {
    
    //var zz=document.getElementById(v).id;
    //alert(zz);
    //var myarra = zz.split("rack_id");
    //var asx= myarra[1];
  
    var pri=document.getElementById("rack_id").value;
    var pId=document.getElementById("product_id").value;
   
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "getRackQty?location_rack_id="+pri+"&pid="+pId, false);
    xhttp.send();
    document.getElementById("getQn").value = xhttp.responseText;
    document.getElementById("getQn").innerHTML = xhttp.responseText;
    //alert(xhttp.responseText);
    
  }
  
  
  function checkLoc()
  {
    
    var oldLoc=$("#location_id1").val();
    var newLoc=$("#location_rack_id").val();
  
    var oldRack=$("#rack_id1").val();
    var newRack=$("#rack_id").val();
  
    if(Number(oldLoc) == Number(newLoc) && Number(oldRack) == Number(newRack) )
    {    
      $("#stockSubmit").attr('disabled',true); 
      $("#location_rack_id").val('');
      $("#rack_id").val('');
      // $("#qty_pallet").empty();
       $("#qty_pallet").hide();
      //$("p").remove();
      alert("Transfer location & rack Can't be same");
    }
    else
    {
      $("#stockSubmit").removeAttr('disabled',false);    
      //$("p").append();
      $("#qty_pallet").show();
    }
  
  }
  
  function checkQtyVal() 
  {
    
    var new_qty=$("#qtyid").val();
    var qty_stk=$("#stock_qty1").val();
      //alert(new_qty);
  
    if(Number(new_qty) > Number(qty_stk))
    {
      alert("Please Enter Qty Less Than Qty In Stock");
      $("#qtyid").focus();
      $("#stockSubmit").attr("disabled",true);
    }
    else
    {
      $("#stockSubmit").removeAttr("disabled"); 
    }
  
  }
  
  
</script>
<?php
  $this->load->view("footer.php");
  ?>