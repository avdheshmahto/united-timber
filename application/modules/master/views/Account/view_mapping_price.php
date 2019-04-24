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
                                 <input type="hidden" class="hiddenField"  name="pri_id" id='pri_id'  value="" style="width:80px;"  /> 
                                 <input type="hidden" class="hiddenField"  name="pri_ide" id='machine_name'  value="<?=$_GET['id'];?>" style="width:80px;"  /> 
								<ul style="position: absolute;z-index: 999999;top: 31px;" id="productList">
									
								</ul>
							</div>
							<div id="prdsrch" style="color:black;padding-left:0px; width:30%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;">
                             <?php
						      $this->load->view('getproduct');
                             ?>
						   
						    <input type="hidden" class="hiddenField" name="hiddenVandorId" id="hiddenVandorId"   style="width:230px;" class="form-control">
							 </div>
						  </th>
                          <th>
                          <input type="text" name="rate" id="rate"   style=" width:230px;" class="form-control"   >
                          </th>
                        <th>
						<input type="button"  id="qn" style="width:70px;" onclick="adda();" value="Add" class="form-control"> 
                      </th>
					</tr>
			     <!-- </form> -->
			  </tbody>
		  </table>

<div style="width:100%; background:#dddddd; padding-left:0px; color:#000000; border:2px solid ">
<table id="invo" style="width:100%;  background:#dddddd;  height:70%;" title="Invoice"  >
<tr>
<td style="width:1%;"><div align="center"><u>Sl No</u>.</div></td>
<td style="width:11%;"><div align="center"><u>Spare</u></div></td>
<td style="width:3%;"> <div align="center"><u>Rate</u></div></td>
<td style="width:3%;"> <div align="center"><u>Action</u></div></td>
</tr>


</table>


<div style="width:100%; background:white;   color:#000000;  max-height:170px; overflow-x:auto;overflow-y:auto;" id="m">
<table id="invoice221"  style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" title="Invoice" class="table table-bordered blockContainer lineItemTable ui-sortable"  >

	<tr>
    	<td><input type="text" class="form-control" name="si[]" id="si" value="<?php ?>" ></td>
		<td><input type="text" class="form-control" name="spare[]" id="spare" value="<?php ?>"></td>
		<td><input type="text" class="form-control" name="rate[]" id="rate" value="<?php ?>"></td>
		<td><input type="button" class="form-control" name="edit" id="edit" value="edit"></td>
		<td><input type="button" class="form-control" name="delete" id="delete" value="delete"></td>
    </tr>
</table>

<table id="invoice"  style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" title="Invoice" class="table table-bordered blockContainer lineItemTable ui-sortable"  >

</table>
</div>


<input type="hidden" name="rows" id="rows">
<!--//////////ADDING TEST/////////-->
<input type="hidden" name="spid" id="spid" value="d1"/>
<input type="hidden" name="ef" id="ef" value="0" />

</div>
</div>
<div class="modal-footer" id="button">
<input type="submit" class="btn btn-sm" value="Save"  id="spareMap"/>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>
</form>
</div>