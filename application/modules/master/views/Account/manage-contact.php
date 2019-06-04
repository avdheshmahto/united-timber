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

<!-- Main content -->
<div class="main-content">

<div id="Contactmodal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"><span class="top_title" >Add </span>Contact</h4>
<div id="resultareacontact" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>
<form class="form-horizontal" role="form"  id="contactForm" style="margin-bottom:0px;">
<div class="modal-body overflow">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Name:</label> 
<div class="col-sm-4"> 				
<input type="hidden" name="contact_id" id="contact_id" value="<?=$branchFetch->contact_id; ?>" />
<input type="text" name="first_name" id="first_name" value="" class="form-control" >
</div> 
<label class="col-sm-2 control-label">*Group Name:</label> 
<div class="col-sm-4"> 
<select name="groupName" class="form-control"  id="groupName" required style="width:100%;">
  <option value="">-------select---------</option>
  <?php
   $ugroup2=$this->db->query("select * from tbl_account_mst where status='A'");
   foreach ($ugroup2->result() as $fetchunit){
  ?>
   <option value="<?=$fetchunit->account_id ;?>"><?=$fetchunit->account_name;?></option>
<?php } ?>
</select>
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">Contact Person:</label> 
<div class="col-sm-4"> 
<input type="text" name="contact_person" id="contact_person" value=""  class="form-control">
</div> 
<label class="col-sm-2 control-label">Email Id:</label> 
<div class="col-sm-4"> 
<input type="email" name="email" value="" id = "email" class="form-control">
</div> 
</div>
<div class="form-group"> 
<label class="col-sm-2 control-label">Mobile No.:</label> 
<div class="col-sm-4"> 
<input type="tel" minlength="10" maxlength="10" id="mobile" name="mobile" title="Enter 10 digit mobile number"  value=""  class="form-control" >
</div> 

<label class="col-sm-2 control-label">Phone No.:</label> 
<div class="col-sm-4" id="regid"> 
 <input type="text" maxlength="10"  pattern="[0-9]{10}" title="Enter Your Phone Number" id="phone" name="phone" value="" class="form-control">
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">Pan No:</label> 
<div class="col-sm-4" id="regid"> 
<input type="text" name="pan_no" pattern1=".{10,10}" maxlength="10" id="pan_no" placeholder="PAN No 10 digist" title="PAN Number must be 10 character" value=""  class="form-control">
</div> 
<label class="col-sm-2 control-label">GSTIN No:</label> 
<div class="col-sm-4" id="regid"> 
<input type="text" name="gstin" id="gstin"  placeholder="GSTIN" value=""  class="form-control">

</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">Address1:</label> 
<div class="col-sm-4" id="regid"> 
<textarea class="form-control" name="address1" id="address1"></textarea>
</div>  
<label class="col-sm-2 control-label">Address2:</label> 
<div class="col-sm-4" id="regid"> 
<textarea class="form-control" name="address3" id="address3"></textarea>
</div> 
</div>

<div class="form-group" > 
<label class="col-sm-2 control-label">City:</label> 
<div class="col-sm-4" id="regid"> 
<input type="text" name="city" id="city" value="" class="form-control">
</div> 
<label class="col-sm-2 control-label">State:</label> 
<div class="col-sm-4" id="regid"> 
<select name="state_id" class="form-control" id="state_id" style="width:100%;">
<option value="">--Select--</option>
<?php 
$stnm=$this->db->query("select * from tbl_state_m order by stateName asc");
foreach($stnm->result() as $stdata)
{
?>
<option value="<?=$stdata->code;?>"><?=$stdata->stateName;?></option>
<?php } ?>
</select>
</div> 
</div>

<div class="form-group" > 
<label class="col-sm-2 control-label">Pin Code:</label> 
<div class="col-sm-4" id="regid"> 
<input type="number" name="pin_code" id="pin_code" value=""  class="form-control">
</div> 
</div>

</div>
<div class="modal-footer button" >
<input type="submit" class="btn btn-sm"  value="Save"  id="contactForm1"/>
<span id="saveload" style="display: none;">
<img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
</span>
<button type="button" class="btn btn-secondary btn-sm" id="buttonnn" data-dismiss="modal">Cancel</button>
</div>
</form>
</div><!-- /.modal-content -->

</div><!-- /.modal-dialog -->
</div>

<div class="row" id="listingData">
<div class="col-lg-12">
<div class="panel panel-default">

<!-- /.panel-heading -->
<div class="panel-body">
<div class="row">
<div class="col-sm-12">
<ol class="breadcrumb"> 
<li class="active">Manage Contact</li> 
</ol>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
  <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
  <a class="btn btn-sm" data-toggle="modal" formid = "#contactForm" data-target="#Contactmodal" id="formreset" title="Add Contact">Add Contact</a>
  <a class="btn btn-secondary btn-sm delete_all" title="Delete Multiple"><span>Delete</span></a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>master/Account/manage_contact?<?='first_namee='.$_GET['first_namee'].'&maingroupname='.$_GET['maingroupname'].'&emailee='.$_GET['emailee'].'&mobile='.$_GET['mobile'].'&phone='.$_GET['phone'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">

	<option value="10">10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>

</select>
entries</label>

<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="    margin-top: -5px;margin-left: 12px;float: right;">
	Showing <?=$dataConfig['page']+1;?> to 
	<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
	?> of <?php echo $dataConfig['total'];?> entries
</div>
</div>
<div id="DataTables_Table_0_filter" class="dataTables_filter" >
<label>Search:
<input type="text" class="form-control input-sm" id="searchTerm"  onkeyup="doSearch()" placeholder="What you looking for?">
</label>
</div>
</div>
</div>
</div>
<!--row close-->

<div class="row">
<div class="col-lg-12">
<div class="table-responsive">
											
<table class="table table-striped table-bordered table-hover dataTables-example11" id="loadData">
<thead bgcolor="#CCCCCC">
<tr>
		<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
	    <th>Name</th>
		<th>Group Name</th>
        <th>Email Id</th>
		<th>Mobile No.</th>
		<th>Phone No.</th>
		<th style="width:110px;">Action</th>
</tr>
</thead>

<tbody id="getDataTable">
<tr>
		<form method="get">
		<th>&nbsp;</th>
		<th><input name="first_namee"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="maingroupname"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="emailee"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="mobile"  type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><input name="phone" type="text"  class="search_box form-control input-sm"  value="" /></th>
		<th><button type="submit" class="btn btn-sm" name="filter" value="filter" style="margin:0 0 0 0px;" title="Search"><span>Search</span></button></th>
		</form>
</tr>


<?php

$i=1;
  foreach($result as $fetch_list)
  {

  ?>

<tr class="gradeC record" data-row-id="<?php echo $fetch_list->contact_id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->contact_id; ?>" value="<?php echo $fetch_list->contact_id;?>" /></th>
<th>
<?php if($fetch_list->group_name=='5'){ ?>
<a href="<?=base_url();?>master/Account/manage_contact_map?id=<?php echo $fetch_list->contact_id; ?>" title="contact Details"><?php echo $fetch_list->first_name; ?></a>
<?php }else{ ?>
<?php echo $fetch_list->first_name; ?>
<?php } ?>
</th>

<?php
  $contactQuery=$this->db->query("select *from tbl_account_mst where account_id='$fetch_list->group_name'");
  $getContact=$contactQuery->row();
?>

<th><?=$getContact->account_name;?></th>

<th><?=$fetch_list->email;?></th>

<th><?=$fetch_list->mobile;?></th>
<th><?=$fetch_list->phone;?></th>

<th>

<?php if($edit!=''){ ?>
<button class="btn btn-default" property=""  data-target="#Contactmodal" data-a="<?=$fetch_list->contact_id;?>"  arrt= '<?=json_encode($fetch_list);?>' onclick="editContact(this);" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Contact"><i class="icon-pencil"></i>
</button>
<?php }
$pri_col='contact_id';
$table_name='tbl_contact_m';

$stfCostLog=$this->db->query("select * from tbl_product_stock where supp_name='$fetch_list->contact_id' ");
$numCost=$stfCostLog->num_rows();

$sftStkLog=$this->db->query("select * from tbl_software_stock_log where vendor_id='$fetch_list->contact_id' ");
$numStk=$sftStkLog->num_rows();

$countRows=$numCost + $numStk;

if($countRows > 0 ) {  ?>
<button class="btn btn-default" type="button" title="Delete Contact" onclick="return confirm('Contact already map. You can not delete ?');"><i class="icon-trash"></i></button>
<?php } else { ?>
<button class="btn btn-default delbutton_contact"  id="<?php echo $fetch_list->contact_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Contact"><i class="icon-trash"></i>
</button>	
<?php } ?>
</th>
</tr>
<?php  $i++; } ?>
</tbody>
<input type="text" style="display:none;" id="table_name" value="tbl_contact_m">  
<input type="text" style="display:none;" id="pri_col" value="contact_id">
</table>

<form class="form-horizontal" role="form"  id="priceMapSpare" style="margin-bottom:0px;">
<div id="modal-1" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div id="sparemapping_price">

        </div>
    </div>	 
</div>
</form>

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
<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>

</div>

	
<?php
$this->load->view("footer.php");
?>


<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Contact <?php echo date('d-m-Y');?>.xls';
   
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

</script>


<script>


function abcd(v){

//alert(v);
	var actiontaken=v.split(",");
	var val1=actiontaken[0];
	var val2=actiontaken[1];
	
var info = 'id=' + val1;
//alert(info);
 if(confirm("Are You Sure..??? You Want To Delete !"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_spare_price_data",
   data: info,
   success: function(){
  
   }
 });

 document.getElementById("record"+val2).style.display = 'none';
 //location.reload();
 }

}


/////////////////////////////////////////////

function fsv(v)
{

	var rc=document.getElementById("rows").value;

	if(rc!=0)
	{
		v.type="submit";
	}
	else
	{
		alert('No Item To Save..');	
	}

}



function slr()
{
		var table = document.getElementById('invoice');
        var rowCount = table.rows.length;
		  for(var i=1;i<rowCount;i++)
		  {    
              table.rows[i].cells[0].innerHTML=i;
		  }
}  

//////////////////////////////////////////////////////////////

var rw=0;

function adda()
  { 
		
			//alert();
		var rate = document.getElementById("rate").value;
		//default
		
		var rows = document.getElementById("rows").value;
	
		var pri_id=document.getElementById("pri_id").value;
		
		var pd=document.getElementById("prd").value;
		
	    var table = document.getElementById("invoice");
			
			
			
				
				clear();
				
  			    currentCell = 0;
		
		if(pd!="" )
					{
					
					var rid =Number(rows)+1;
			
					document.getElementById("rows").value=rid;
						
						
				     var indexcell=0;
					 var row = table.insertRow(-1);
						rw=rw+0;
						
						//cell 0st
				 var cell=cell+indexcell;		
				 cell = row.insertCell(0);
				 cell.style.width="1.20%";
				 cell.align="center"
				 cell.innerHTML=rid;
				
				
				//cell 1st item name
			 indexcell=Number(indexcell+1);		
			 var cell=cell+indexcell;	
					
				cell = row.insertCell(indexcell);
						cell.style.width="10%";
						cell.align="center";
				
				
				//============================item text ============================
				var prd = document.createElement("input");
							prd.type="text";
							prd.border ="0";
							prd.value=pd;	
							prd.name='pd';//
							prd.id='pd'+rid;//
							prd.readOnly = true;
							prd.style="text-align:center";  
							prd.style.width="100%";
							prd.style.border="hidden"; 
							cell.appendChild(prd);
				var priidid = document.createElement("input");
							priidid.type="hidden";
							priidid.border ="0";
							priidid.value=pri_id;	
							priidid.name='pri_id[]';//
							priidid.id='pri_id'+rid;//
							priidid.readOnly = true;
							priidid.style="text-align:center";  
							priidid.style.width="100%";
							priidid.style.border="hidden"; 
							cell.appendChild(priidid);
							
							
	
		//==============================close 2nd cell =========================================
		
					
									
		//============================================start 7th cell================================	
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;	
		   cell = row.insertCell(indexcell);
					cell.style.width="3%";
					cell.align="center"
			
				var netprice = document.createElement("input");
							netprice.type="text";
							netprice.border ="0";
							netprice.value=rate;	    
							netprice.name ='rate[]';
							netprice.id='rate'+rid;
							netprice.readOnly = true;
							netprice.style="text-align:center";
							netprice.style.width="100%";
							netprice.style.align="center";
							netprice.style.border="hidden"; 
							cell.appendChild(netprice);							
											
		//======================================close net price====================================							
		//cell 3st
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;
		var imageloc="/mr_bajaj/";
		var cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.align="center";
				var delt =document.createElement("img");
						delt.src ="<?=base_url();?>assets/images/delete.png";
						delt.class ="icon";
						delt.border ="0";
						//delt.style.width="30%";
						//delt.style.height="20%";
						delt.name ='dlt';
						delt.id='dlt'+rid;
						delt.style="text-align:center";
						delt.style.border="hidden"; 
						delt.onclick= function() { deleteselectrow(delt.id,delt); };
					    cell.appendChild(delt);
				//var edt = document.createElement("img");
//						edt.src ="<?=base_url();?>/assets/images/edit.png";
//						edt.class ="icon";
//						//edt.style.width="60%";
//						//edt.style.height="40%";
//						edt.border ="0";
//						edt.name ='ed';
//						edt.id='ed'+rid;
//						edt.style.border="hidden"; 
//						edt.onclick= function() { editselectrow(delt.id,edt); };
//						cell.appendChild(edt);
			

			
			}
			else
			{
			if(rate == 0)
				{
					alert('***Rate Can not be Zero ***');
					
					
				}
				else
				{
				
					alert('***Please Select Product ***');
			
				}
			}

}

function clear()
{
	// this finction is use for clear data after adding invoice
		document.getElementById("prd").value='';
		document.getElementById("pri_id").value='';
		document.getElementById("rate").value='';
		document.getElementById("prd").focus();	
}


////////////////////////////////// starts edit code ////////////////////////////////


function editselectrow(d,r) //modify dyanamicly created rows or product detail
{
 
	var regex = /(\d+)/g;
	nn= d.match(regex)
	id=nn;
	if(document.getElementById("prd").value!='')
	{
		document.getElementById("rate").focus();
		alert("Product Already In Edit Mode");
		return false;
	}

// ####### starts ##############//
		var pd=document.getElementById("pd"+id).value;
		var rate=document.getElementById("rate"+id).value;
		var pri_id=document.getElementById("pri_id"+id).value;
// ####### ends ##############//

// ####### starts ##############//
	document.getElementById("pri_id").value=pri_id;
	var rate=document.getElementById("rate").value=rate;
	document.getElementById("prd").value=pd;
	document.getElementById("prd").focus();
// ####### ends ##############//

	//editDeleteCalculation();

    var i = r.parentNode.parentNode.rowIndex;
	document.getElementById("invoice").deleteRow(i);
}

////////////////////////////////// ends edit code ////////////////////////////////




////////////////////////////////// starts delete code ////////////////////////////////

function deleteselectrow(d,r) //delete dyanamicly created rows or product detail
{
 
 
 
var regex = /(\d+)/g;
nn= d.match(regex)
	id=nn;
	//alert(nn);
	if(document.getElementById("prd").value!='')
	{
 		document.getElementById("prd").focus();
    	 alert("Product Already In Edit Mode");
		return false;
	}
		
		//alert();
		
		var pd=document.getElementById("pd"+id).value;
		var pri_id=document.getElementById("pri_id"+id).value;
	    var i = r.parentNode.parentNode.rowIndex;
   	    var cnf = confirm('Are You Sure..??? You Want To Delete !');
 if (cnf== true)
  {
	 document.getElementById("invoice").deleteRow(i);
  	slr();
  
 	//editDeleteCalculation();
	//serviceChargeCal();	
	//grossDiscountCal();
  }
	
}
////////////////////////////////// ends delete code ////////////////////////////////


</script>