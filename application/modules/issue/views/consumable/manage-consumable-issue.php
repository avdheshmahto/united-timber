<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

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
<h4 class="panel-title">CONSUMABLE ISSUE</h4>
<div class="pull-right">
<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#ConsumIssuemodal" title="Add Tools Issue" onclick="refreshData();">Add Consumable Issue</button>
</div>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>


<div class="modal fade" id="ConsumIssuemodal" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Consumable Issue</h4>
<div id="resultareaconsumable" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
    <div class="modal-body overflow">
    <form class="form-horizontal" role="form" id="ConsumIssueForm" method="post">
        <table class="table table-striped table-bordered table-hover">
          <tr class="gradeA">
            <h4><center>*Section
             <!--  <select name="facilities" id="facilities" class="select2 form-control">
              <option value="">---select---</option>
              <?php 
                // $sqltr=$this->db->query("select * from tbl_facilities where status='A'");
                // foreach ($sqltr->result() as $fetchtr){
              ?>
              <option value="<?php echo $fetchtr->id;?>"><?php echo $fetchtr->fac_name; ?></option>
                <?php //} ?>
            </select> -->
            <select class="select2 form-control" name="section" id="section" required>
            <option value="0" class="listClass">----------------Select----------------</option>
            <?php
            foreach ($categorySelectbox as $key => $dt) { ?>
            <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
            <?php } ?>
            </select>
          </center></h4>
          </tr> 
          <tr class="gradeA">
            <th><div style1="width: 100px;">Consumable Name</div></th>
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
                $sqlunit=$this->db->query("select * from tbl_product_stock where via_type='Consumable' ");
                foreach ($sqlunit->result() as $fetchunit){
              ?>
              <option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
                <?php } ?>
            </select>
            <input type="hidden" id="product_types" name="product_types">
            </th>
            <th><select name="location_id" id="location_rack_id" onchange="getRackFun(this.id);" class="form-control">
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
            <th><select name="rack_id" class="form-control" id="rack_id" onchange="getQty(this.id);vendor_func(this.value);"   >
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
            <th><p id="getQn" value=""></p></th>
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
            <th><div style1="width: 100px;">Consumable Name</div></th>
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
          <input type="hidden" id="countRow">
        </tbody>
        <tr>
          <th colspan="6">&nbsp;</th>
          <th>
          <input type="button" id="Psubmitform" class="btn btn-sm savebutton pull-right" value="Save" onclick="checkrows();"> 
          </th>
          <th>
          <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button></th>            
        </tr>
      </table>
 </form>
</div>
</div><!-- /.modal-content -->
</div>
<!-- </div> -->

<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">&nbsp;
	<a style="display: none;" href="<?=base_url();?>report/Report/excel_spare_machine_mapping_report?" class="btn btn-sm" >Excel</a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>SpareIssue/manage_spare_issue?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
</select>
entries</label>

<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -5px;margin-left: 12px;float: right;">
Showing <?=$dataConfig['page']+1;?> to 
	<?php
		$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
		echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
	?> of <?=$dataConfig['total'];?> entries
</div>
</div>
<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
</label>
</div>
</div>

	 
</div>
</div>

<div class="panel-body">
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover dataTables-example1" id="listingData" >
<thead>
<tr>
<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
  <th>Issue Id</th>
  <th>Section</th>
  <th>Type</th>  
  <th>Issued Qty</th>
  <th>Status</th>
  <th>Action</th>
 </tr>
</thead>
<tbody id = "getDataTable"> 
                    
<?php  

 $i=1;
 //$sqlord=$this->db->query("select * from tbl_work_order_maintain where status='A'");
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->issue_id; ?>">

<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->issue_id; ?>" value="<?php echo $fetch_list->issue_id;?>" /></th>

<th><?php // echo "CB".$fetch_list->issue_id; ?><?=sprintf('%03d',$fetch_list->issue_id); ?></th>
<th><a href="<?=base_url();?>issue/ConsumIssue/view_consumable_issue?id=<?=$fetch_list->issue_id?>"><?php 
  $sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->section."'");
  $compRow = $sqlunit->row();
  echo $compRow->name;    ?></a>
</th>
<th><?php echo $fetch_list->type; ?></th>
<th><?php 
$qty=$this->db->query("select SUM(qty) as totalqty from tbl_consum_issue_dtl where issue_id_hdr='$fetch_list->issue_id'");
$getQty=$qty->row();

echo $getQty->totalqty; ?></th>
<th><?php echo $fetch_list->issue_status; ?></th>
<th><?php 
$pri_col='issue_id';
$table_name='tbl_consum_issue_hdr';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->issue_id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>
</th>
</tr>

<?php $i++; } ?>
</tbody>
</table>

<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> 
		</div>
		<div class="col-md-6"> 
			<?php echo $pagination; ?>
		</div>
	</div>
</div>

</div>
</div>

</div>
</div>
</div>
</div>


<?php
$this->load->view("footer.php");
?>


<script type="text/javascript">
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Machine Spare Mapping Report<?php echo date('d-m-Y');?>.xls';
   
   // Create download link element
   downloadLink = document.createElement("a");
   
   document.body.appendChild(downloadLink);
   
   if(navigator.msSaveOrOpenBlob){
       var blob = new Blob(['\ufeff', tableHTML], {
           type: dataType
       });
       navigator.msSaveOrOpenBlob( blob, filename);
   }else{

       // Create a link to the file
       downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
   
       // Setting the file name
       downloadLink.download = filename;
       
       //triggering the function
       downloadLink.click();
   }
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
  var pri_id=document.getElementById("spare_nameid").value;
  
  getPalletQty(loc,pri_id);

  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "getRack?location_rack_id="+loc, false);
  xhttp.send();
  document.getElementById("rack_id").innerHTML = xhttp.responseText;
  //alert(xhttp.responseText);
  
}

function getQty(v) 
{
  
  //var zz=document.getElementById(v).id;
  //alert(zz);
  //var myarra = zz.split("rack_id");
  //var asx= myarra[1];

  var pri=document.getElementById("rack_id").value;
  var pId=document.getElementById("spare_nameid").value;
 
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "getRackQty?location_rack_id="+pri+"&pid="+pId, false);
  xhttp.send();
  document.getElementById("getQn").value = xhttp.responseText;
  document.getElementById("getQn").innerHTML = xhttp.responseText;
  //alert(xhttp.responseText);
  
}




function checkQtyVal(v) 
{
  
  //var zz=document.getElementById(v).id;
  //alert(zz);
  //getQty();

  //var myarra = zz.split("new_qty");
  //var asx= myarra[1];
  //alert(asx);
  var rack_id=document.getElementById("rack_id").value;
  var location_rack_id=document.getElementById("location_rack_id").value;
  var new_qty=document.getElementById("qtyid").value;
  var qty_stk=document.getElementById("getQn").value;
  //alert(qty_stk);

  if(new_qty!='')
  {
    if(location_rack_id=='')
    {
      alert("Please Select Location");
      document.getElementById("location_rack_id").focus();
    }

    if(rack_id=='')
    {
      alert("Please Select Rack");
      document.getElementById("rack_id").focus();
    }
  }

  if(Number(new_qty) > Number(qty_stk))
  {
    alert("Please Enter Qty Less Than Qty In Stock");
    document.getElementById("qtyid").focus();
    $("#Psubmitform").attr("disabled",true);
  }
  else
  {
    $("#Psubmitform").removeAttr("disabled"); 
  }
  // else if(Number(new_qty) > Number(rem_qty))
  // {
  //   alert("Please Enter Qty Less Than Remaining Qty");
  //   document.getElementById("new_qty").focus(); 
  // }
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
  
  var pids = $("#spare_nameid").val();
  var locs  = $("#location_rack_id").val();
  var racks = $("#rack_id").val();

  $.ajax({
    url  : "<?=base_url();?>issue/ConsumIssue/get_vendor_list",
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
  var pid  = $("#spare_nameid").val();
  var loct  = $("#location_rack_id").val();
  var rackt = $("#rack_id").val();
  var vndr = $("#vendor_id").val();
  //alert(pid);
  $.ajax({
    url  : "<?=base_url();?>issue/ConsumIssue/get_price_list",
    type : "POST",
    data : {'prid':pid,'loc':loct,'rack':rackt,'vid':vndr},
    success:function(data)
    {
      //alert(data);
      $("#purchase_price").empty().append(data)
    }
  })
}


function via_type_func(v)
{
  //alert(v);
  ur="<?=base_url();?>issue/ConsumIssue/check_product_type";
  $.ajax({
    url  : ur,
    type : "POST",
    data : {'pid':v},
    success:function(data)
    {
      //alert(data);
      if(data !='')
      {
        $("#product_types").val(data);
      }
    }
    
    })
}


function checkrows()
{

  var count=$("#countRow").val();
  if(count > 0)
  {
    //v.type=submit;
    $('#Psubmitform').attr('type', 'submit');
  }
  else
  {
    //v.type=button;
    $('#Psubmitform').attr('type', 'button');
    alert("Nothing To Save ! Please Add Row !");
  }

}


function refreshData()
{

  $("#dataTable").empty();
  $("#countRow").val('');
  
}

</script>