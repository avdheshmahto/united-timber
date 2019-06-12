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
<h4 class="panel-title">TOOLS ISSUE</h4>
<div class="pull-right">
<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#PartsIssuemodal" title="Add Tools Issue" onclick="refreshData();">Add Tools Issue</button>
</div>
<!-- <ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul> -->
</div>


<div class="modal fade" id="PartsIssuemodal" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Tools Issue</h4>
<div id="resultareaissue" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
</div>
    <div class="modal-body overflow">
    <form class="form-horizontal" role="form" id="PartsIssueForm" method="post">
        <table class="table table-striped table-bordered table-hover">
          <tr class="gradeA">
            <th><h4>*Section</h4> </th>
            <th colspan="2">Machine</th>
            <th colspan="1">Issue Date</th>
            <th colspan="1">Shift</th>
            <th colspan="2"><h4>*Tools Name</h4></th>
          </tr>
          <tr>
            <th>
                <select name="section" class="select2 form-control" id="section" onchange="getmachinelist(this.value);" required>
                <option value="0" class="listClass">-----Section-----</option>
                <?php
                $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                foreach($sql->result() as $getSql) {
                //foreach ($categorySelectbox as $key => $dt) { ?>
                <!-- <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option> -->

                  <option value="<?php echo $getSql->id;?>"><?php echo $getSql->name; ?></option>

                <?php } ?>
                </select>
            </th>            
            <th colspan="2">
              <select name="machineid" id="machineid" class="form-control">
              <option>-----------Select--------</option>  
              </select>
            </th>
            <th colspan="1"><input type="date" name="issue_date" class="form-control" style="width: 115px;"></th>
            <th colspan="1">
              <select name="shift" id="shift" class="form-control">
                <option>-----Select----</option>
                <option value="Day">Day</option>
                <option value="Night">Night</option>
              </select>
            </th>
            <th colspan="2">
                <select name="spare_name" id="spare_nameid" class="select2 form-control" onchange="viewToolsIssuePage(this.value);">
                  <option value="">---select---</option>
                  <?php 
                    $sqlunit=$this->db->query("select * from tbl_product_stock where via_type='Tools' ");
                    foreach ($sqlunit->result() as $fetchunit){
                  ?>
                  <option value="<?php echo $fetchunit->Product_id;?>"><?php echo $fetchunit->productname; ?></option>
                    <?php } ?>
                </select>
            </th>
          </tr>           
          <tr class="gradeA">
            <th colspan="4">&nbsp;</th>
          </tr>
        <tbody>
          <tr class="gradeA">
            <th>Location</th>
            <th>Rack</th>
            <th>Vendor Name</th>  
            <th>Purchase Price</th>          
            <th>Qnty In Stock</th>
            <th>Enter Issue Qty</th>
            <th>Action</th>
          </tr>
        </tbody>
        <tbody id="dataTablePage">
        </tbody>


        <tr class="gradeA">
            <th colspan="4">&nbsp;</th>
          </tr>
        <tbody>
          <tr class="gradeA">
            <th>Tools Name</th>
            <th>Location</th>
            <th>Rack</th>
            <th>Vendor Name</th>  
            <th>Purchase Price</th>          
            <th>Issue Qnty</th>
            <th>Action</th>
          </tr>
        </tbody>
        <tbody id="dataTable">
          <input type="text" id="countRow" style="display: none;">
        </tbody>
        <tr>
          <th colspan="5">&nbsp;</th>
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
<div class="dt-buttons" style="display: none;">&nbsp;
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>issue/ToolsIssue/manage_tools_issue?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>
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
  <th>Issue Id</th>
  <th>Section</th>
  <th>Type</th>  
  <th>Issued Qty</th>
  <th>Returned Qty</th>
  <th>Remaining Qty</th>
  <th>Status</th>
  <th>Action</th>
 </tr>
</thead>
<tbody id = "getDataTable"> 

<tr style="display: none;">                    
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>

<?php  
$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->issue_id; ?>">
<th><?php  //echo $i; ?><?=sprintf('%03d',$fetch_list->issue_id); ?></th>
<th><a href="<?=base_url();?>issue/ToolsIssue/view_parts_issue?id=<?=$fetch_list->issue_id?>"><?php 
  $sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->section."'");
  $compRow = $sqlunit->row();
  echo $compRow->name;    ?></a>
</th>
<th><?php echo $fetch_list->type; ?></th>
<th><?php 
$qty=$this->db->query("select SUM(qty) as totalqty from tbl_tools_issue_dtl where issue_id_hdr='$fetch_list->issue_id'");
$getQty=$qty->row();

echo $getQty->totalqty; ?></th>

<th>
<?php 
  $rtqty=$this->db->query("select * from tbl_tools_return_hdr where issue_id='$fetch_list->issue_id' ");
  $getRt=$rtqty->row();
  $rtdtl=$this->db->query("select SUM(qty) as dtlqty from tbl_tools_return_dtl where return_id_hdr='$getRt->return_id' ");
  $getDtl=$rtdtl->row();
  echo $getDtl->dtlqty;
?>
</th>
<th><?php echo $remqty=$getQty->totalqty - $getDtl->dtlqty; ?></th>
<th><?php 
  
  if($getQty->totalqty == $getDtl->dtlqty)
  {
    echo "Completed";
  }
  else if($getQty->totalqty > $getDtl->dtlqty)
  {
    echo "Pending";
  }
  else
  {
    echo "Open";
  }

//echo $fetch_list->issue_status; ?></th>

<th><?php 
$pri_col='issue_id';
$table_name='tbl_tools_issue_hdr';


$stfCostLog=$this->db->query("select * from tbl_tools_return_hdr where issue_id='".$fetch_list->issue_id."' ");
$numCost=$stfCostLog->num_rows();

// $sftStkLog=$this->db->query("select * from tbl_work_order_maintain where machine_name='".$fetch_list->id."' ");
// $numStk=$sftStkLog->num_rows();

$countRows=$numCost;

if($countRows > 0 ) {  ?>
<button class="btn btn-default" type="button" title="Delete Tools Issue" onclick="return confirm('Tools already map to return. You can not delete ?');"><i class="icon-trash"></i></button>
<?php } else { ?>  
<button class="btn btn-default delbutton_toolsissue" id="<?php echo $fetch_list->issue_id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>
<?php  } ?>
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
   filename = filename?filename+'.xls':'Tools Issue <?php echo date('d-m-Y');?>.xls';
   
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
    url  : "<?=base_url();?>issue/ToolsIssue/get_vendor_list",
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
    url  : "<?=base_url();?>issue/ToolsIssue/get_price_list",
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
  ur="<?=base_url();?>issue/ToolsIssue/check_product_type";
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

  $("#dataTablePage").empty();
  $("#dataTable").empty();
  $("#countRow").val('');
  $("#section").val('').trigger('change');
  $("#spare_nameid").val('').trigger('change');
  $("#Psubmitform").removeAttr('disabled',false);
  
}


function viewToolsIssuePage(v)
{
 
  //alert(v);
  var prod=v;
  var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "tools_issue_page?PID="+ prod, false);
  // xhttp.open("GET", "issue_spare_sm?ID="+pro, false);
  // alert(xhttp.open);
  xhttp.send();
  //alert(xhttp.responseText);
  document.getElementById("dataTablePage").innerHTML = xhttp.responseText;

} 


function qtyfunction(v) 
{
  
  var zz=document.getElementById(v).id;
  //alert(zz);
  var myarra = zz.split("issue_qty");
  var asx= myarra[1];
  
    var enqty1 = $("#issue_qty"+asx).val();
    var isqty1 = $("#stk_qty"+asx).val();

    if(Number(enqty1) > Number(isqty1))
    {
      alert("Issue Qty Can Not Be Greater Than Stock Qty");
      $("#Psubmitform").attr('disabled',true);
    }
    else
    {
      $("#Psubmitform").removeAttr('disabled',false);
    }
  
}


function getmachinelist(v)
{

  ur="<?=base_url();?>issue/ToolsIssue/get_machine_list";

  $.ajax({

      url   : ur,
      type  : "POST",
      data  : {'mid':v},
      success:function(data)
      {
        if(data != '')
        {
          $("#machineid").empty().append(data);
        }
      }
  })

}


</script>