<!--<div id="modal-1" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Spare Price Mapping</h4>
    <div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div>
  </div>
  <!--<form class="form-horizontal" role="form"  id="priceMapSpare" style="margin-bottom:0px;">-->
  <div class="modal-body">
    <table class="table table-striped table-bordered table-hover" >
      <tbody>
        <tr class="gradeA">
          <th>Spare Name</th>
          <th>Rate</th>
          <th>Action</th>
        </tr>
        <!-- <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="mapSpareForm"> -->
        <tr class="gradeA">
          <th style="width:280px;">
            <div class="input-group">
              <div style="width:100%; height:28px;" >
                <input type="text" name="prd"  onkeyup="getdataSP(this.value);" onClick="getdataSP(this.value);" id="prd" style=" width:230px;" class="form-control"  placeholder=" Search Items..." tabindex="5" autocomplete="off" >
                <input type="hidden"  name="pri_id" id='pri_id'  value="" style="width:80px;"  /> 
                <div  style="color:black;padding-left:0px; width:100%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute; 
                  margin:31px 0 0 0px;">
                  <ul style="position: absolute;z-index: 999999;" id="productList"></ul>
                </div>
              </div>
              <!--<div id="prdsrch" style="color:black;padding-left:0px; width:30%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;">
                <?php
                  //$this->load->view('getproduct');
                  ?>
                </div>-->
              <input type="hidden"  value="<?=$_GET['ID'];?>" name="vendorid" id="hiddenVandorId"    class="form-control">
          </th>
          <th><input type="number" name="rate" id="rate"   style=" width:230px;" class="form-control"   ></th>
          <th><input type="button"  style="width:70px;" onclick="adda();" value="Add" class="form-control"> </th>
        </tr>
        <!-- </form> -->
      </tbody>
    </table>
    <div style="width:100%; background:#dddddd; padding-left:0px; color:#000000; border:2px solid ">
    <table id="invo" style="width:100%;  background:#dddddd;  height:70%;" title="Invoice"  >
    <tr>
    <td style="width:1%;"><div align="center"><u>Serial No</u>.</div></td>
    <td style="width:11%;"><div align="center"><u>Spare</u></div></td>
    <td style="width:3%;"> <div align="center"><u>Rate</u></div></td>
    <td style="width:3%;"> <div align="center"><u>Action</u></div></td>
    </tr>
    </table>
    <div style="width:100%; background:white;   color:#000000;  max-height:170px; overflow-x:auto;overflow-y:auto;" id="m">
    <table id="invoice"  style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" title="Invoice" class="table table-bordered blockContainer lineItemTable ui-sortable"  >
    <?php 
      //echo "select * from tbl_vendor_spare_price_map where status = 'A' AND vendor_id = '".$_GET['vndr_id']."' ";
      $sparequery = $this->db->query("select * from tbl_vendor_spare_price_map where status = 'A' AND vendor_id = '".$_GET['ID']."' ");
      
      $i=1;
      foreach($sparequery->result() as $result1)
      {
      	
      $pname=$this->db->query("select * from tbl_product_stock where Product_id='$result1->spare_id' ");
      $getPname=$pname->row();
      //$cntrow=$pname->num_rows();
      
      
      ?>
    <tr id="record<?=$i;?>">
    <td style="text-align:center;"><?=$i;?></td>
    <td style="text-align:center;"><?=$getPname->productname;?></td>
    <td style="text-align:center;"><?=$result1->price;?></td>
    <td style="text-align:center;">
    <?php 
      $pri_col='id';
      $table_name='tbl_vendor_spare_price_map';
       ?>
    <img src="<?=base_url();?>assets/images/delete.png"; id="<?php echo $result1->id."^".$table_name."^".$pri_col.",".$i ; ?>" onclick="abcd(this.id)" >
    </td>
    </tr>
    <?php  $i++;  }  ?>
    </table>
    <table id="invoice"  style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" title="Invoice" class="table table-bordered blockContainer lineItemTable ui-sortable"  >
    </table>
    </div>
    <input type="hidden" name="rows" id="rows" value="">
    <!--//////////ADDING TEST/////////-->
    </div>
    </div>
    <div class="modal-footer" id="button">
      <input type="button" class="btn btn-sm" value="Save"  onclick="fsv(this)"/>
      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
    </div>
    <!--</form>-->
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<!--</div>
  </div>-->