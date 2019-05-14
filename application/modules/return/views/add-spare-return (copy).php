<?php
$this->load->view("header.php");
?>
<form id="f1" name="f1" method="POST" action="insertSpareReturn" onSubmit="return checkKeyPressed(a)">
<!-- Main content -->

<!-- <script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=42epwf1jarbwose89sqt3dztyfu7961g4cs5xoib4kordvbd"></script>
  <script>tinymce.init({ selector:'#tem' });</script> -->

<div class="main-content">
<?php if(@$_GET['popup'] == 'True') {} else {?>
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
	<li><a href="#">Parts & Supplies Return</a></li> 
	<li class="active"><strong><a href="#">Add Parts & Supplies Return</a></strong></li> 
	<div class="pull-right">
	<a class="btn btn-sm" href="<?=base_url();?>return/spareReturn/manage_spare_return">Manage Parts & Supplies Return</a>
	</div>
</ol>
<?php }?>

<div class="row">
<div class="col-lg-12">
<div class="heading">
<h4 class="panel-title"><strong>Add Parts & Supplies Return</strong></h4>
							
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="margin-bottom:20px;">
<tbody>

<tr>
<select name="bin_card_type" style="display:none;" class="form-control"  />
<option value="">--Select--</option>
<option value="Receipt">Receipt</option>
<option value="Return" selected="selected">Return</option>
</select>	

<th>Vendor Name</th>
<th>
<select name="vendor_id" id="vendor_id" class="form-control" required>
<option value="">--Select--</option>
<?php
$vendorQuery=$this->db->query("select *from tbl_contact_m where status='A' and group_name = '5'");
foreach($vendorQuery->result() as $getVendor){
?>
<option value="<?=$getVendor->contact_id;?>"><?=$getVendor->first_name;?></option>
<?php }?>
</select>
<th>Return Date</th>
<th><input type="date" name="return_date" class="form-control"  /></th>
<!-- <th>Type</th>
<th>
<select name="type" class="select2 form-control" id="type" style="width:100%;" >	
<option value="">--Select--</option>
<?php
$abc=$this->db->query("select distinct(via_type) from tbl_product_stock where status='A' ");
foreach ($abc->result() as $value) { ?>
<option value="<?=$value->via_type?>"><?=$value->via_type?></option>
<?php } ?>
</th> -->
<th></th>
<th></th>
</th>
</tr>

<tr>
<th>P.O. NO.</th>
<th><input type="number" name="po_no" class="form-control" required /></th>
<th>P.O. Date</th>
<th><input type="date" name="po_date" class="form-control" required /></th>
<th>Remarks</th>
<th><textarea name="remarks" class="form-control"></textarea></th>
</tr>
</tbody>
</div>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="margin-bottom:20px;">
<thead>
<tr class="gradeA">
<th>Parts & Supplies Name </th>
<th>Type</th>
<th>Qty in Stock</th>
<th>Usages Unit</th>
<th style="display:none;">Main Location</th>
<th>Location</th>
<th>Rack No.</th>
<th>Purchase Price</th>
<th>Enter Qty</th>
<th>Action</th>
</tr>
</thead>
<tbody id="getDataTable">
<tr class="gradeA">
<th style="width:280px;">
<div class="input-group"> 
<div style="width:100%; height:28px;" >
<input type="text" name="prd[]"  onkeyup="getdata()" class="form-control" onkeypress="getdata()" onClick="getdata()" id="prd" style=" width:230px;"  placeholder=" Search Items..." />
 <input type="hidden"  name="pri_id" id='pri_id'  value="" style="width:80px;"  />
</div>

</div>
<div id="prdsrch" style="color:black;padding-left:0px; width:30%; overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;">
<?php
//include("getproduct.php");
$this->load->view('getproduct');

?>
</div>
</th>
<th><input type="text" readonly="" id="type" style="width:70px;" class="form-control"></th>
<th><input type="text" readonly="" id="quantity" style="width:70px;" class="form-control"></th>
<th><input type="text" readonly="" id="usunit" style="width:70px;" class="form-control"> </th>
<th style="display:none;">
<select  name="main_loc" id="main_loc" class="form-control"  style="width:70px;"/ >
<?php
 $queryMainLocation=$this->db->query("select *from tbl_location where status='A'");
foreach($queryMainLocation->result() as $getMainLocation){
?>
<option value="<?=$getMainLocation->id;?>"><?=$getMainLocation->location_name;?></option>
<?php } ?>
</select>
</th>
<th>
<input type="hidden" id="locationVal" />
<select name="loc[]" id="loc" onChange="getPallet(this.value);" class="form-control" style="width:70px;"/>
<!-- <p id="qty_pallet"></p> -->
<option>--Select--</option>
<?php
$queryMainLocation=$this->db->query("select *from tbl_master_data where status='A' and param_id='21'");
foreach($queryMainLocation->result() as $getMainLocation){
?>
<option value="<?=$getMainLocation->serial_number;?>"><?=$getMainLocation->keyvalue;?></option>
<?php }?>
</select>
<p id="qty_pallet"></p>
</th>

<th>
<input type="hidden" id="rackVal" />
<select name="rack_id[]" id="rack_id" onclick="getrackQty1(this.value);" onChange="validaterack(this);validatePrice();" class="form-control"   style="width:70px;"/ >
<option>--Select--</option>
<?php
$queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A'");
foreach($queryMainLocation1->result() as $getMainLocation1){
?>
<option value="<?php echo $getMainLocation1->id;?>"><?=$getMainLocation1->rack_name;?>
</option>
<?php } ?>
</select>
</th>
<th>
<!-- <input type="number" step="any" id="price" min="1"  value="" class="form-control" > -->
<select name="price" id="price" class="form-control" style="width:70px;"> 
<option>--Select--</option>
<?php 
$abc=$this->db->query("select purchase_price from tbl_product_serial where status='A' ");
foreach ($abc->result() as $value) { ?>
<option value="<?=$value->purchase_price;?>"><?=$value->purchase_price;?></option>	
<?php } ?>
</select>
</th>
<th><input type="number" id="qn" min="1" style="width:70px;"   class="form-control"></th>
<th><a href="#" onclick="adda();" class="btn btn-sm">Add</a></th>

</tr>
</tbody>
</table>
</div>

<div style="width:100%; background:#dddddd; padding-left:0px; color:#000000; border:1px solid ">
<table id="invo" style="width:100%;  background:#1ABC9C;  height:70%;" title="Invoice"  >
<tr>
<td style="width:1%;"><div align="center"><u>S. No.</u>.</div></td>
<td style="width:9%;"><div align="center"><u>Parts & Supplies Name</u></div></td>
<td style="width:3%;display:none;"> <div align="center"><u>Main Location</u></div></td>
<td style="width:3%;"> <div align="center"><u>Location </u></div></td>
<td style="width:3%;"> <div align="center"><u>Rack</u></div></td>
<td style="width:3%;"> <div align="center"><u>Purchase Price</u></div></td>
<td style="width:3%;"> <div align="center"><u>Quantity</u></div></td>
<td style="width:3%;"> <div align="center"><u>Action</u></div></td>
</tr>
</table>


<div style="width:100%; background:white;   color:#000000;  max-height:170px; overflow-x:auto;overflow-y:auto;" id="m">
<table id="invoice"  style="width:100%;background:white;margin-bottom:0px;margin-top:0px;min-height:30px;" title="Invoice" class="table table-bordered blockContainer lineItemTable ui-sortable"  >

<tr></tr>
</table>



</div>


</div>

<input type="hidden" name="rows" id="rows">
<!--//////////ADDING TEST/////////-->
<input type="hidden" name="spid" id="spid" value="d1"/>
<input type="hidden" name="ef" id="ef" value="0" />


<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" >
<tbody>
<tr class="gradeA">
<th>
<div class="pull-right">
<input class="btn btn-sm" type="button" name="save" value="SAVE"   id="sv1" onclick="fsv(this)" >&nbsp;<a href="<?=base_url();?>return/spareReturn/manage_spare_return" class="btn btn-secondary  btn-sm">Cancel</a>
</div>
</th>
</tr>
</tbody>
</table>
</div>

</div>
</div>
</div>
</div>


<script type="text/javascript">


//add item into showling list
window.addEventListener("keydown", checkKeyPressed, false);
//funtion to select product
function checkKeyPressed(e) 
{
	
	var s=e.keyCode;
	var ppp=document.getElementById("prd").value;
	var sspp=document.getElementById("spid").value;//
	var ef=document.getElementById("ef").value;
	ef=Number(ef);
	var countids=document.getElementById("countid").value;

	//if(countids==''){
	//countids=1;
	//}

	for(n=1;n<=countids;n++)
	{

		document.getElementById("tyd"+n).onkeyup  = function (e) 
		{
			var entr =(e.keyCode);
			if(entr==13)
			{
				document.getElementById("loc").focus();
				document.getElementById("prdsrch").innerHTML=" ";

			}
		}
	}

	document.getElementById("price").onkeydown = function (e) 
	{
		var entr =(e.keyCode);
		if(entr==13)
		{	
			var sprice=document.getElementById("price").value;
			if(sprice=='')
			{
				alert("Please Select Purchase Price");
				document.getElementById("price").focus();	
			}
			else
			{
				document.getElementById("qn").focus();			
			}

		}
	}

	document.getElementById("loc").onkeydown = function (e) 
	{

		var entr =(e.keyCode);
		if(entr==13)
		{
			
			var locA=document.getElementById("loc").value;
			if(locA=='')
			{
				alert("Please Select Location");
				document.getElementById("loc").focus();
			}
			else
			{
				var e = document.getElementById("loc");
				var strMake = e.options[e.selectedIndex].text;
				document.getElementById("locationVal").value=strMake;
				document.getElementById("rack_id").focus();	
			}
			

		}

	}

	document.getElementById("rack_id").onkeydown = function (e) 
	{
		var entr =(e.keyCode);
		if(entr==13)
		{
			var rack_id=document.getElementById("rack_id").value;
			if(rack_id=='')
			{
				alert("Please Select Rack");	
				document.getElementById("rack_id").focus();
			}
			else
			{
				var e = document.getElementById("rack_id");
				var strMake = e.options[e.selectedIndex].text;
				document.getElementById("rackVal").value=strMake;
				document.getElementById("price").focus();
			}
		}
	}



	document.getElementById("qn").onkeydown = function (e) 
	{
		
		var entr =(e.keyCode);
		if(document.getElementById("qn").value=="" && entr==08)
		{

		}
	   	if (e.keyCode == "13")
		{
		
			e.preventDefault();
		    e.stopPropagation();
			
			if(ppp!=='' || ef==1)
			{
			
				adda();	  											
				var ddid=document.getElementById("spid").value;
				var ddi=document.getElementById(ddid);
				ddi.id="d";
				
			}
			else
			{
				alert("Enter Correct Product");
			}
			return false;
		}
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


function getdata()
{
	 
	currentCell = 0;
	var product1=document.getElementById("prd").value;	 
	var vendor_id=document.getElementById("vendor_id").value;
	//var type = document.getElementById("type").value;
	var product=product1;
	 
	//alert(type);	
 	if(vendor_id == '')
	{
		alert("Please Select Vendor Name !");
		return false;
	}
	else
	{
	    if(xobj)
		{
		
			var obj=document.getElementById("prdsrch");			
		 	xobj.open("GET","getproduct?con="+product+"&vendor_id="+vendor_id,true);
		 	xobj.onreadystatechange=function()
		  	{
			  	if(xobj.readyState==4 && xobj.status==200)
			   	{
			    	obj.innerHTML=xobj.responseText;
			   	}
		  	}
		}

	 xobj.send(null);

	}

}
  
////////////////////////////////////////////////////

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

	var main_loc=document.getElementById("main_loc").value;	
	var loc=document.getElementById("loc").value;		
    var rack_id=document.getElementById("rack_id").value;
	var qn=document.getElementById("qn").value;
	var unit=document.getElementById("usunit").value;
	var price=document.getElementById("price").value;
	var quantity=document.getElementById("quantity").value;
	var locationVal=document.getElementById("locationVal").value;
	var rackVal=document.getElementById("rackVal").value;
			  	
	//default
	var rows=document.getElementById("rows").value;
	var pri_id=document.getElementById("pri_id").value;
	var pd=document.getElementById("prd").value;
	var table = document.getElementById("invoice");

	if(loc == '')
	{
		alert("Enter Location!!!");
		$( "#loc" ).focus();
		//$("#addas").hide();
		return false;
	}
			
	if(rack_id == '')
	{
		alert("Enter Rack!!!");
		$( "#rack_id" ).focus();
		//$("#addas").hide();
		return false;
	}

	if(price == '')
	{
		alert("Enter Price");
		$("#price").focus();
		return false;
	}

	var rid =Number(rows)+1;
	document.getElementById("rows").value=rid;
	
						
	//totalSum();	
	//serviceChargeCal();
	//grossDiscountCal();				
	clear();
			
	currentCell = 0;
	if(pd!="" && qn!=0)
	{
		
		var indexcell=0;
		var row = table.insertRow(-1);
		rw=rw+0;

		//cell 0st
		var cell=cell+indexcell;		
		cell = row.insertCell(0);
		cell.style.width=".20%";
		cell.align="center"
		cell.innerHTML=rid;


		//cell 1st item name
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;	
		
	    cell = row.insertCell(indexcell);
				cell.style.width="9%";
				cell.align="center";
																
				//============================item text ============================
				var prd = document.createElement("input");
							prd.type="text";
							prd.border ="0";
							prd.value=pd;	
							prd.name='pd[]';//
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
							priidid.name='product_id[]';//
							priidid.id='main_id'+rid;//
							priidid.readOnly = true;
							priidid.style="text-align:center";  
							priidid.style.width="100%";
							priidid.style.border="hidden"; 
							cell.appendChild(priidid);
							
							
				var unitt = document.createElement("input");
							unitt.type="hidden";
							unitt.border ="0";
							unitt.value=unit;	
							unitt.name='unit[]';//
							unitt.id='unit'+rid;//
							unitt.readOnly = true;
							unitt.style="text-align:center";  
							unitt.style.width="100%";
							unitt.style.border="hidden"; 
							cell.appendChild(unitt);
							
							
				var qttyyy = document.createElement("input");
							qttyyy.type="hidden";
							qttyyy.border ="0";
							qttyyy.value=quantity;	
							qttyyy.name='qttyyyy[]';//
							qttyyy.id='qttyyyy'+rid;//
							qttyyy.readOnly = true;
							qttyyy.style="text-align:center";  
							qttyyy.style.width="100%";
							qttyyy.style.border="hidden"; 
							cell.appendChild(qttyyy);
					
						// ends here
										
	
	//#################cell 2nd starts here####################//
	
	
	
	indexcell=Number(indexcell+1);		
	var cell=cell+indexcell;
        cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.style.display="none";
				cell.align="center"
				var main_locS = document.createElement("input");
							main_locS.type="text";
							main_locS.border ="0";
							main_locS.value=main_loc;	    
							main_locS.name ='main_loc[]';
							main_locS.id='main_loc'+rid;
							main_locS.readOnly = true;
							main_locS.style="text-align:center";
							main_locS.style.width="100%";
							main_locS.style.border="hidden"; 
							cell.appendChild(main_locS);
					
	
	//########s#########//
	
	
	
	//########s#########//
	indexcell=Number(indexcell+1);		
	var cell=cell+indexcell;
        cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.style.display="none";
				cell.align="center"
				var locS = document.createElement("input");
							locS.type="text";
							locS.border ="0";
							locS.value=loc;	    
							locS.name ='loc[]';
							locS.id='loc'+rid;
							locS.readOnly = true;
							locS.style="text-align:center";
							locS.style.width="100%";
							locS.style.border="hidden"; 
							cell.appendChild(locS);
					
	
	//==============================close 2nd cell =========================================
	
	//########s#########//
	indexcell=Number(indexcell+1);		
	var cell=cell+indexcell;
        cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.align="center"
				var locSV = document.createElement("input");
							locSV.type="text";
							locSV.border ="0";
							locSV.value=locationVal;	    
							locSV.name ='locationVal[]';
							locSV.id='locationVal'+rid;
							locSV.readOnly = true;
							locSV.style="text-align:center";
							locSV.style.width="100%";
							locSV.style.border="hidden"; 
							cell.appendChild(locSV);
					

	//==============================close 2nd cell =========================================

	//===================================start 4th cell================================
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;		
	    cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.align="center"	;
				cell.style.display="none";
				
												
				var rack_idS = document.createElement("input");
							rack_idS.type="text";
							rack_idS.border ="0";
							rack_idS.value=rack_id;	
							rack_idS.name ='rack_id[]';
							rack_idS.id='rack_id'+rid;
							rack_idS.readOnly = true;
							rack_idS.style="text-align:center";
							rack_idS.style.width="100%";
							rack_idS.style.border="hidden"; 
							cell.appendChild(rack_idS);
		
		//===============================close 4th cell===============
		
		//===================================start 4th cell================================
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;		
	    cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.align="center"	
				
												
				var rack_idSR = document.createElement("input");
							rack_idSR.type="text";
							rack_idSR.border ="0";
							rack_idSR.value=rackVal;	
							rack_idSR.name ='rackVal[]';
							rack_idSR.id='rackVal'+rid;
							rack_idSR.readOnly = true;
							rack_idSR.style="text-align:center";
							rack_idSR.style.width="100%";
							rack_idSR.style.border="hidden"; 
							cell.appendChild(rack_idSR);
		//===============================close 4th cell===============
		
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;
        cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.align="center";
				//cell.style.display="none";
				var salepr = document.createElement("input");
							salepr.type="text";
							salepr.border ="0";
							salepr.value=price;	    
							salepr.name ='purchase_price[]';
							salepr.id='purchase_price'+rid;
							salepr.readOnly = true;
							salepr.style="text-align:center";
							salepr.style.width="100%";
							salepr.style.border="hidden"; 
							cell.appendChild(salepr);
					

		//#################cell 3rd starts here####################//					
		indexcell=Number(indexcell+1);		
		var cell=cell+indexcell;		
	    cell = row.insertCell(indexcell);
				cell.style.width="3%";
				cell.align="center"
		//========================================start qnty===================================	
				var qtty = document.createElement("input");
							qtty.type="text";
							qtty.border ="0";
							qtty.value=qn;	    
							qtty.name ='new_quantity[]';
							qtty.id='qnty'+rid;
							qtty.readOnly = true;
							qtty.style="text-align:center";
							qtty.style.width="100%";
							qtty.style.border="hidden"; 
							cell.appendChild(qtty);
								
		//======================================close 3rd cell========================================
			
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
						delt.style.border="hidden"; 
						delt.onclick= function() { deleteselectrow(delt.id,delt); };
					    cell.appendChild(delt);
			var edt = document.createElement("img");
						edt.src ="<?=base_url();?>/assets/images/edit.png";
						edt.class ="icon";
						//edt.style.width="60%";
						//edt.style.height="40%";
						edt.border ="0";
						edt.name ='ed';
						edt.id='ed'+rid;
						edt.style.border="hidden"; 
						edt.onclick= function() { editselectrow(delt.id,edt); };
						cell.appendChild(edt);
			

			
			}
			else
			{
				if(qn==0)
				{
					alert('***Quantity Can not be Zero ***');
				}
				else
				{				
					alert('***Please Select PRODUCT ***');
				}
			}

function clear()
{

	// this finction is use for clear data after adding invoice
	document.getElementById("prd").value='';
	document.getElementById("prdsrch").innerHTML='';
	document.getElementById("usunit").value='';
	document.getElementById("price").value='';
	//document.getElementById("lpr").innerHTML ='';
	document.getElementById("qn").value='';
	document.getElementById("quantity").value='';
	document.getElementById("pri_id").value='';	
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
		document.getElementById("qn").focus();
		alert("Product already in edit Mode");
		return false;
	}


		// ####### starts ##############//
		var pd=document.getElementById("pd"+id).value;
		var unit=document.getElementById("unit"+id).value;
		var qn=document.getElementById("qnty"+id).value;
		var price=document.getElementById("purchase_price"+id).value;
		var pri_id=document.getElementById("main_id"+id).value;
		var qnttyy=document.getElementById("qttyyyy"+id).value;
		var locationVal=document.getElementById("locationVal"+id).value;
		var rackVal=document.getElementById("rackVal"+id).value;
		var loc=document.getElementById("loc"+id).value;
		var rack_value=document.getElementById("rack_id"+id).value;
		

		// ####### ends ##############//

		// ####### starts ##############//

		getPallet(loc,rack_value);
		document.getElementById("pri_id").value=pri_id;

		document.getElementById("prd").value=pd;
		document.getElementById("usunit").value=unit;
		document.getElementById("price").value=price;
		document.getElementById("quantity").value=qnttyy;
		document.getElementById("qn").value=qn;
		document.getElementById("locationVal").value=locationVal;
		document.getElementById("rackVal").value=rackVal;
		document.getElementById("loc").value=loc;
		document.getElementById("loc").focus();

		// ####### ends ##############//
		//editDeleteCalculation();

		var i = r.parentNode.parentNode.rowIndex;
		document.getElementById("invoice").deleteRow(i);

}

}

////////////////////////////////// ends edit code ////////////////////////////////




////////////////////////////////// starts delete code ////////////////////////////////

function deleteselectrow(d,r) //delete dyanamicly created rows or product detail
{
 
	var regex = /(\d+)/g;
	nn= d.match(regex)
	id=nn;
	if(document.getElementById("prd").value!='')
	{
	 	document.getElementById("qn").focus();
	    alert("Product already in edit Mode");
		return false;
	}


		var pd=document.getElementById("pd"+id).value;
		var unit=document.getElementById("unit"+id).value;
		var qn=document.getElementById("qnty"+id).value;
		var pri_id=document.getElementById("main_id"+id).value;
	    var i = r.parentNode.parentNode.rowIndex;
	    var cnf = confirm('Are You Sure..??? you want to Delete line no1.'+(id));
		if (cnf== true)
 		{
 			document.getElementById("invoice").deleteRow(i);
  			slr();
  
 		}
	
}
////////////////////////////////// ends delete code ///////////////////////////////

  

function getPallet(loc,selectval){
	
var rack_id=document.getElementById("rack_id").value;
var main_loc=document.getElementById("main_loc").value;
var pri_id=document.getElementById("pri_id").value;


getPalletQty(main_loc,loc,pri_id);

		var strURL="get_rack?loc="+loc+"&rack_id="+rack_id+"&main_loc="+main_loc+"&selectval="+selectval;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					if (req.status == 200) {

					//var price=mtr*ext_per;
					//alert(req.responseText);
						document.getElementById('rack_id').innerHTML=req.responseText;
							
										
					//alert(idm);

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}			

			req.open("GET", strURL, true);

			req.send(null);

		}
		
	
		var e = document.getElementById("loc");
var strMake = e.options[e.selectedIndex].text;
document.getElementById("locationVal").value=strMake;	
		
		
}


function getrackQty1(val)
{

	var e = document.getElementById("rack_id");
	var strMake = e.options[e.selectedIndex].text;
	document.getElementById("rackVal").value=strMake;		
	
}


function getPalletQty(main_loc,loc,pri_id)
{

		var strURL="getPalletQty?main_loc="+main_loc+"&loc="+loc+"&pri_id="+pri_id;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					if (req.status == 200) {

					//var price=mtr*ext_per;
					//alert(req.responseText);
					
					if(req.responseText=='No Record found' || req.responseText=='0')
					{
					
						document.getElementById("qn").readOnly = true;
						

					}
					else
					{
						document.getElementById("qn").readOnly = false;
					}
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


function validatePrice()
{

	//alert();
	var loc=document.getElementById("loc").value;	
	var rack_id=document.getElementById("rack_id").value;
	var main_id=document.getElementById("pri_id").value;
	var vendor_id=document.getElementById("vendor_id").value;
	//alert(vendor_id);

	//getPalletQty(main_loc,loc,pri_id);

		var strURL="get_price?loc="+loc+"&rack_id="+rack_id+"&main_id="+main_id+"&vendor_id="+vendor_id;
		//alert(strURL);
		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					if (req.status == 200) {

					//var price=mtr*ext_per;
					//alert(req.responseText);
						document.getElementById('price').innerHTML=req.responseText;
							
										
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

function validaterack(ths)
{
			
	var prod=document.getElementById("pri_id").value;
	var loc=document.getElementById("loc").value;
	var rack=document.getElementById("rack_id").value;

	//alert(prod);

	var tabless = document.getElementById('invoice');
    var rowCountt = tabless.rows.length;
	for(var i=1;i<rowCountt;i++)
	{    
	
	var proid=document.getElementById("main_id"+i).value;
	var locid=document.getElementById("loc"+i).value;
	var rackid=document.getElementById("rack_id"+i).value;
	//alert(proid);
	//alert(locid);
	//alert(rackid);
	
		if((prod==proid) && (loc==locid) && (rack==rackid))
		{

			alert("Select Different Rack!!Otherwise Edit This Rack");
			document.getElementById("loc").focus();
			document.getElementById('rack_id').value = "";
		}

	}
}
 
	
 $("#qn").keyup(function(){
	
	var prod=document.getElementById("pri_id").value;
	var loc=document.getElementById("loc").value;
	var rack=document.getElementById("rack_id").value;
	var entqty=document.getElementById("qn").value;
	//alert(rack);

	$.ajax({
		type:"POST",
		url : "check_rack_qty",
		data : {'pid':prod,'loc':loc,'rack':rack,'eqty':entqty},
		success : function(data){
			//alert(data);
			if(data == 0)
			{
				$("#qn").val('');
				alert("Entered Quantity Can't be Greater Than Rack Quantity!");			
			}				
		}

	});
  
});

      
</script>
</form>
<?php
$this->load->view("footer.php");
?>