<?
  $ID=$_GET['ID'];
  ?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Map Spare</h4>
<table class="table table-striped table-bordered table-hover" >
  <tbody>
    <tr class="gradeA">
      <th>Product Name</th>
      <th>Quantity In Stock</th>
    </tr>
    <tr class="gradeA">
      <th style="width:280px;">
        <div class="input-group">
          <div style="width:100%; height:28px;" >
            <input type="text" name="prd"  onkeyup="getdata()" onClick="getdata()" id="prd" style=" width:230px;" class="form-control"  placeholder=" Search Items..." tabindex="5" >
            <input type="hidden"  name="pri_id" id='pri_id'  value="" style="width:80px;"  />
          </div>
          <div id="prdsrch" style="color:black;padding-left:0px; width:30%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;">
            <?php
              //include("getproduct.php");
              $this->load->view('getproduct');
              
              ?>
          </div>
      </th>
      <th>
      <input type="text"  id="qn" style="width:70px;" class="form-control"> 
      </th>
    </tr>
  </tbody>
</table>
<div style="width:100%; background:#dddddd; padding-left:0px; color:#000000; border:2px solid ">
<table id="invo" style="width:100%;  background:#dddddd;  height:70%;" title="Invoice"  >
<tr>
<td style="width:1%;"><div align="center"><u>Sl No</u>.</div></td>
<td style="width:11%;"><div align="center"><u>Item</u></div></td>
<td style="width:3%;"> <div align="center"><u>Action</u></div></td>
</tr>
</table>
<div style="width:100%; background:white;   color:#000000;  max-height:170px; overflow-x:auto;overflow-y:auto;" id="m">
<table id="invoice"  style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" title="Invoice" class="table table-bordered blockContainer lineItemTable ui-sortable"  >
<tr></tr>
</table>
<input type="hidden" name="rows" id="rows">
<!--//////////ADDING TEST/////////-->
<input type="hidden" name="spid" id="spid" value="d1"/>
<input type="hidden" name="ef" id="ef" value="0" />
</div>
</div>
</div>