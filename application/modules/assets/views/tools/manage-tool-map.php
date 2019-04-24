<?php
$this->load->view("header.php");
$toolsQuery=$this->db->query("select *from tbl_product_stock where Product_id='".$_GET['id']."'");
$getTool=$toolsQuery->row();
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
<div class="panel-body panel panel-default">		
<div class="row">
<div class="col-lg-12">
<div class="panel-body">
<div class="row centered-form">
<div class="col-xs-12 col-sm-12">
<div class="panel panel-default">
<div class="panel-heading" style="background-color: #F5F5F5; color:#000000; border-color:#DDDDDD;">
<h3 class="panel-title" style="float: initial;">Tool:-<?=$getTool->productname;?>
	
	<a href="<?=base_url('assets/tools/manage_tools');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>
<div class="panel-body">
<form role="form">
<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Tool Name</h4>
<input type="text" name="" value="<?=$getTool->productname;?>" id="first_name" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Tool Code</h4>
<input type="text" name="" id="last_name" class="form-control" value="<?=$getTool->sku_no;?>" readonly >
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Type Of Tool</h4>
<div class="form-group">
<?php 
$queryType=$this->db->query("select *from tbl_master_data where serial_number='$getTool->type_of_spare'");
$getType=$queryType->row();

?>
<input type="text" name="" value="<?=$getType->keyvalue;?>" id="facility" class="form-control" readonly>
</div>
</div>


<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Priority</h4>
<div class="form-group">
<?php 
$queryTypeunit=$this->db->query("select *from tbl_master_data where serial_number='$getTool->priority'");
$getTypeunit=$queryTypeunit->row();

?>
<input type="text" name="" value="<?=$getTypeunit->keyvalue;?>" id="m_unit" class="form-control" readonly>
</div>
</div>

</div>
<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Usages Unit</h4>
<?php 
$queryUsageunit=$this->db->query("select *from tbl_master_data where serial_number='$getTool->usageunit'");
$getUsagasunit=$queryUsageunit->row();

?>
<input type="text" name="" value="<?=$getUsagasunit->keyvalue;?>" id="first_name" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Total Quantity</h4>
<input type="text" name="" id="last_name" class="form-control" value="<?=$getTool->quantity;?>" readonly >
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
<li class="active"><a href="#home" data-toggle="tab">Mapped Locations</a></li>
<!-- <li><a href="#metering" data-toggle="tab">Metering</a></li> -->
<li><a href="#suppliers" data-toggle="tab">Suppliers</a></li>
<li><a href="#warranties" data-toggle="tab">Warranties</a></li>
<li><a href="#filesid" data-toggle="tab">Files</a></li>
<li><a href="#openworkorderhistory" data-toggle="tab">Work Order Log</a></li>
</ul>
<div class="tab-content">

<div class="tab-pane  active" id="home">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadSpare">
<thead>
	<tr>
		<th>Location</th>
		<th>Rack</th>
		<th>Quantity</th>
		
	</tr>
</thead>
<tbody>
<?php

$i=1;
$serialQuery=$this->db->query("select * from tbl_product_serial where status='A' and product_id='$getTool->Product_id'");
foreach($serialQuery->result() as $tools_list)
{

?>

<tr class="gradeU record">

	<td><?php 
		 $compQuery = $this -> db
		           -> select('*')
		           -> where('serial_number',$tools_list->loc)
		           -> get('tbl_master_data');
		 $compRow = $compQuery->row();

		echo $compRow->keyvalue;
		?>
	</td>
	
    <td><?php 
		 $compQuery = $this -> db
		           -> select('*')
		           -> where('id',$tools_list->rack_id)
		           -> get('tbl_location_rack');
		 $compRow = $compQuery->row();

		echo $compRow->rack_name;
		?>
	</td>
	
    <td><?=$tools_list->quantity;?></td>
   		
</tr>

<?php } ?>


</tbody>
<tfoot>

</tfoot>
</table>
</div>
</div>
</div>

<!-- <div class="tab-pane" id="metering">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadmeteing" >
<thead>
<tr>
<th>Last Reading</th>
<th>Unit</th>
<th>Date And Time</th>
<th>Action</th>
</tr>
</thead>


<tbody>
<?php

$i=1;
	 $sparemacName=$this->db->query("select * from tbl_machine_spare_unit_map where machine_id='".$_GET['id']."' and status = 'A' ");
foreach($sparemacName->result() as $fetch_list)
{
$spareName=$this->db->query("select *from tbl_product_stock where Product_id='$fetch_list->spare_id'");
$getSpareD=$spareName->row();
?>

    <tr class="gradeU record">
       
       	<td><?=$fetch_list->reading;?></td>
		 		 
        <td><?php 
			 $compQuery = $this -> db
			           -> select('*')
			           -> where('serial_number',$fetch_list->unit)
			           -> get('tbl_master_data');
			 $compRow = $compQuery->row();

			echo $compRow->keyvalue;
			?>
		</td>
		  <td><?=$fetch_list->date_time;?></td>
		
       
       <td><?php $pri_col='id';
                  $table_name='tbl_machine_spare_unit_map';
         ?>
        <?php if($view!=''){ ?>
	   		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Metering"><i class="icon-trash"></i></button>	
		<?php }?>
		</td>

    </tr>
<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#machinemetering' onclick="addMachineMetering('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Metering"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

</tbody>

</table>

</div>

</div>
</div> -->

<!-- ======================== Start Warranty =================================================== -->

<div class="tab-pane" id="warranties">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadwarranties" >
<thead>
<tr>
<!--<th>Spare</th>-->
<th>Date Added</th>
<th>Expiry Date</th>
<th>Certificate Number</th>
<th>Action</th>
</tr>
</thead>


<tbody>
<?php

$i=1;
	 $macwarrantyName=$this->db->query("select * from tbl_tools_warranty where tools_id='".$_GET['id']."' and status = 'A' ");
  foreach($macwarrantyName->result() as $fetch_list)
  {
   
?>

   <tr class="gradeU record">
       
       	<td><?=$fetch_list->date_added;?></td>
		<td><?=$fetch_list->expiry_date;?></td>		 
		<td><?=$fetch_list->certificate_number;?></td>
		
       
       <td><?php $pri_col='warranty_id';
                  $table_name='tbl_tools_warranty';
         ?>
        <?php if($view!=''){ ?>
	   		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->warranty_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete"><i class="icon-trash"></i></button>	
		<?php }?>
		</td>

    </tr>

<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default modalmechinewarranties" data-a="<?php echo $fetch_list->id;?>" href='#machinewarranties' onclick="addToolWarranties('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Warranties"><img src="<?=base_url();?>assets/images/plus.png" /></button>
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

<!-- ================================Start suppliers================================== -->

<div class="tab-pane" id="suppliers">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadsuppliers" >
<thead>
<tr>
<th>Suppliers Name</th>
<th>Suppliers Type</th>
<th>Supplier Part Number</th>
<th>Catalog</th>
<th>Action</th>
</tr>
</thead>


<tbody>
<?php

$i=1;
$supplieraName=$this->db->query("select * from tbl_machine_suppliers where machine_id='".$_GET['id']."' and status = 'A' ");
foreach($supplieraName->result() as $fetch_list)
{

$contactQ=$this->db->query("select * from tbl_contact_m where contact_id='$fetch_list->suppliers_name'");
$contactlist=$contactQ->row();

$contactgroup=$this->db->query("select * from tbl_account_mst where status='A' and account_id='$fetch_list->suppliers_type'");
$listcontactgroup=$contactgroup->row();
   
?>

   <tr class="gradeU record">
       
       	<td><?=$contactlist->first_name;?></td>
		<td><?=$listcontactgroup->account_name;?></td>		 
		<td><?=$fetch_list->supplier_part_number;?></td>
		<td><?=$fetch_list->catalog_name;?></td>
     
        <td><?php $pri_col='id';
                  $table_name='tbl_machine_suppliers';
         ?>
        <?php if($view!=''){ ?>
	   		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Suppliers"><i class="icon-trash"></i></button>	
		<?php }?>
		</td>

    </tr>

<?php } ?>
<tr class="gradeU">

<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#machinesuppliers' onclick="addToolSuppliers('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Suppliers"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>

</tr>

</tbody>

</table>

</div>

</div>
</div>
<!-- ============================================================================= -->

<!-- ================================Start files================================== -->
<div class="tab-pane" id="filesid">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadfiles" >
<thead>
<tr>
<th>S.No.</th>
<th>File Name</th>
<th>Description</th>
<th>Action</th>
</tr>
</thead>


<tbody>
<?php

$i=1;
$supplieraName=$this->db->query("select * from tbl_machine_files_uploads where tools_id='".$_GET['id']."' and type = 'tools' ");
foreach($supplieraName->result() as $fetch_list)
{

  
?>

   <tr class="gradeU record">
       <td><?=$fetch_list->id;?></td>
       	<td><a target="blank" href="<?=base_url('filesimages/toolsfiles');?>/<?=$fetch_list->file_id;?>"><?=$fetch_list->file_id;?></a></td>
		<td><?=$fetch_list->desc_id;?></td>		 
		     
       <td><?php $pri_col='id';
                  $table_name='tbl_machine_files_uploads';
         ?>
        <?php if($view!=''){ ?>
	   		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
		<?php }?>
		</td>

    </tr>

<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#addfiles'   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Files"><img src="<?=base_url();?>assets/images/plus.png" /></button>
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
<!-- ========================================================================================== -->

<!-- ================================ Start Scheduled Maintenance ==================== -->
<!-- <div class="tab-pane" id="scheduledmaintenance">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadlog" >
<thead>
<tr>
<th>When</th>
<th>Code</th>
<th>Description</th>
<th>Action</th>
</tr>
</thead>


<tbody>
<?php

$i=1;
$supplieraName=$this->db->query("select * from tbl_machine_suppliers where machine_id='".$_GET['id']."' and status = 'A' ");
foreach($supplieraName->result() as $fetch_list)
{

$contactQ=$this->db->query("select * from tbl_contact_m where contact_id='$fetch_list->suppliers_name'");
$contactlist=$contactQ->row();

$contactgroup=$this->db->query("select * from tbl_account_mst where status='A' and account_id='$fetch_list->suppliers_type'");
$listcontactgroup=$contactgroup->row();
   
?>

   <tr class="gradeU record">
       
       	<td><?=$contactlist->first_name;?></td>
		<td><?=$listcontactgroup->account_name;?></td>		 
		<td><?=$fetch_list->supplier_part_number;?></td>
     
       <td><?php $pri_col='id';
                  $table_name='tbl_machine_suppliers';
         ?>
        <?php if($view!=''){ ?>
	   		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Suppliers"><i class="icon-trash"></i></button>	
		<?php }?>
		</td>

    </tr>

<?php }?>
<tr class="gradeU">
<td>
 <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#machinesuppliers' onclick="addMachineSuppliers('<?php echo $_GET['id'];?>')"   type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Machine Suppliers"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

</tbody>

</table>

</div>

</div>
</div> -->
<!-- ========================================================================================== -->

</div>
</div><!--tabs-container close-->
</div>
</div>
</div>
</div>
</div><!--main-content close-->

<?php

$this->load->view("footer.php");
?>

<style>
.c-error .c-validation{ 
  background: #c51244 !important;
  padding: 10px !important;
  border-radius: 0 !important;
  position: relative; 
  display: inline-block !important;
  box-shadow: 1px 1px 1px #aaaaaa;
  margin-top: 10px;
}
.c-error  .c-validation:before{ 
  content: ''; 
  width: 0; 
  height: 0; 
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid #c51244;
  position: absolute; 
  top: -10px; 
}
.c-label:after{
  color: #c51244 !important;
}
.c-error input, .c-error select, .c-error .c-choice-option{ 
  background: #fff0f4; 
  color: #c51244;
}
.c-error input, .c-error select{ 
  border: 1px solid #c51244 !important; 
}

</style>


			
<div id="mapSpare" class="modal fade modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-contentMap" id="modal-contentMap">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Map Spare</h4>
			<div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div> 
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<tr class="gradeA">
						<th>Spare Name</th>
						<th>Reading Value</th>
						<th>Unit</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr>
					<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="mapSpareForm">
					<tr class="gradeA">
						<th style="width:280px;">
							<div class="input-group"> 
								<div style="width:100%; height:28px;" >
								<input type="text" name="prd"  onkeyup="getdataSP(this.value);" onClick="getdataSP(this.value);" id="prd" style=" width:230px;" class="form-control"  placeholder=" Search Items..." tabindex="5" autocomplete="off" >
								 <input type="hidden" class="hiddenField"  name="pri_id" id='pri_id'  value="" style="width:80px;"  /> 
                                 <input type="hidden"   name="machine_name" id='machine_name'  value="<?php echo $_GET['id'];?>" style="width:80px;"  /> 
								 <div  style="color:black;padding-left:0px; width:100%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;margin:31px 0 0 0px;">
								<ul style="position: absolute;z-index: 999999;" id="productList">
									
								</ul>
								</div>
							</div>
							<!--<div id="prdsrch" style="color:black;padding-left:0px; width:30%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;">
                             <?php
						      $this->load->view('getproduct');
                             ?>
						    </div>-->
					  </th>
					  
					  <th>
					  <input type="number" name="reading" placeholder = "0.0" id="reading"  style="width:90px;" class="form-control" >
					  </th>
					  
					  <th>
					  <select name="unitt" required class="select2 form-control" id="unitt" style="width:100%;">
						<option value="" >----Select----</option>
						<?php 
							$sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
							foreach ($sqlunit->result() as $fetchunit){
						?>
						<option value="<?php echo $fetchunit->serial_number;?>"<?php if($fetchunit->serial_number == $getMachine->m_unit){ ?> selected <?php } ?>><?php echo $fetchunit->keyvalue; ?></option>
							<?php } ?>
				 </select>
					  <!--<input type="number" name="unitt" id="unitt"  style="width:90px;" class="form-control" >-->
					  </th>
                       
					  
					  <th>
					  <input type="number" name="qty" id="qty"  style="width:90px;" class="form-control" >
					  </th>
                        <th>
						<input type="button"  id="qn" style="width:70px;" onclick="saveData();" value="Add" class="form-control"> 
                       

					   </th>
					</tr>
			     </form>
			  </tbody>
		  </table>
		</div>
	</div>	 
</div>
</div>
</div>

<!-- ==================================================================================== -->


<form class="form-horizontal" role="form"  enctype="multipart/form-data" id="ItemForm12" >			
<div id="editItem" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-contentitem" id="modal-contentitem">

        </div>
    </div>	 
</div>
</form>


<form class="form-horizontal" role="form"  enctype="multipart/form-data" id="meteringform" >			
<div id="machinemetering" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-machinemetering" id="modal-machinemetering">

        </div>
    </div>	 
</div>
</form>

<form class="form-horizontal" role="form"  enctype="multipart/form-data" id="warrantiesform" >			
<div id="machinewarranties" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-machinewarranties" id="modal-machinewarranties">

        </div>
    </div>	 
</div>
</form>

<form class="form-horizontal" role="form"  enctype="multipart/form-data" id="suppliersform" >			
<div id="machinesuppliers" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
	
        <div class="modal-machine-suppliers" id="modal-machine-suppliers">

        </div>
    </div>	 
</div>
</form>

<!-- ================================Add Files Uploads ================================== -->

<div id="addfiles" class="modal fade modal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-contentMap" id="modal-contentMapunit">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">UPLOADS FILE</h4>
<div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div> 
<table class="table table-striped table-bordered table-hover" >
<tbody>
<form class="form-horizontal" role="form"  enctype="multipart/form-data"   id ="myProduction_purchase_grn" action="#" onsubmit="return submitrawMaterialReceive();" method="POST">

<tr class="gradeA"><th colspan="3">&nbsp;</th></tr>
<tr class="gradeA">
<input type="hidden" name="tools_id" id="tools_id" value="<?php echo $_GET['id']; ?>">
<th><input type="file" name="image_name" id="image_name"></th>
<th>Description</th>
<th><textarea class="form-control" id="desc_id" name="desc_id"></textarea></th>
</tr>
<tr class="gradeA">

<th>
&nbsp;
</th>
<th>
<input type="submit" style="width:70px;" value="Save" class="form-control"> 
</th>
<th>&nbsp;</th>
</tr>
</form>
</tbody>
</table>
</div>
</div>	 
</div>
</div>

<!-- ==================================================================================== -->

</div>

<script>
function hidetrfunction() {
  var warranty_term_type=document.getElementById("warranty_usage_term_type").value;
 if(warranty_term_type=='132' || warranty_term_type==''){
 	document.getElementById("rowhiddenid").style.display = "none";
 }else{
 	document.getElementById("rowhiddenid").style.display = "block";
 }
}
</script>

<script>

function getEditItem(v){

var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getMachinePage?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
 }


function addToolWarranties(v){

var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getToolWarranty?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-machinewarranties").innerHTML = xhttp.responseText;
 } 	

 function addToolSuppliers(v){

 var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getToolSuppliers?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-machine-suppliers").innerHTML = xhttp.responseText;
 } 	


function getSpareMap(v){

var pro=v;

 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getSpare?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-contentMap").innerHTML = xhttp.responseText;
 } 	

function getSpareMapunit(v){

var pro=v;

 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getSpare?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-contentMapunit").innerHTML = xhttp.responseText;
 } 	




function showviatype(v)
{
//alert(v);
	if(v==14){
		document.getElementById("viatype").style.display="Block";
	}else{
		document.getElementById("viatype").style.display="none";
	}
}

function showviatype11(v)
{
//alert(v);
	if(v==14){
		document.getElementById("viatypeeee").style.display="Block";

	}else{
		document.getElementById("viatypeeee").style.display="none";
		document.getElementById("via_type").value='';

	}
}

function getEditItem(v){

var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getMachinePage?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
 } 	

</script>	

<script>

$('#datetimepicker_mask').datetimepicker({
	mask:'9999/19/39 29:59',
});
$('#datetimepicker').datetimepicker();
$('#datetimepicker').datetimepicker({value:'2015/04/15 05:06'});
$('#datetimepicker1').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});

function addMachineMetering(v){

var pro=v;
 var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getMachineMetering?ID="+pro, false);
  xhttp.send();
  
  document.getElementById("modal-machinemetering").innerHTML = xhttp.responseText;
 } 	

</script>

<script>
function saveData()
 {

 var pri_id= document.getElementById("pri_id").value;
 var prd= document.getElementById("prd").value;
 var qty= document.getElementById("qty").value;
  var unitt= document.getElementById("unitt").value;
 var reading= document.getElementById("reading").value;
if(prd=='')
{
alert("Please Enter Spare");
return false;
}
if(qty=='')
{
alert("Please Enter Quantity");
return false;
}
 var machine_name= document.getElementById("machine_name").value;
 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "insert_spare?code="+pri_id+"&machine_name="+machine_name+"&unitt="+unitt+"&reading="+reading+"&qty="+qty, false);
 xhttp.send();
 $("#mapSpare .close").click();	   
  document.getElementById("loadSpare").innerHTML = xhttp.responseText;

  console.log(xhttp.responseText);

 }
 
 
function saveDataa()
 {
//alert("wf");

var x = document.getElementById("readingg").value;
	var y = document.getElementById("lastreadingmeter").value;
//	alert(x);
//	alert(y);
	if(Number(x)<=Number(y)){
	alert("Enter More Than Last Reading Value")
	//return false;
	}else{

 var pri_id= document.getElementById("pri_id").value;

 
 var datetimepicker_mask= document.getElementById("datetimepicker_mask").value;

 //var prdd= document.getElementById("prdd").value;
 //var qty= document.getElementById("qty").value;
 var unittt= document.getElementById("unittt").value;
 var readingg= document.getElementById("readingg").value;

if(unittt=='')
{
alert("Please Enter Unit");
return false;
}else if(!Date.parse(datetimepicker_mask)){
alert("Please Enter Date");
}else if(readingg==''){
alert("Please Enter Reading");
return false;
}else{
 var machine_name= document.getElementById("machine_name").value;

 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "insert_spare_unit?code="+pri_id+"&machine_name="+machine_name+"&datetimepicker_mask="+datetimepicker_mask+"&unittt="+unittt+"&readingg="+readingg, false);
 xhttp.send();
 $("#machinemetering .close").click();	   
  $('#meteringform')[0].reset(); 
  document.getElementById("loadmeteing").innerHTML = xhttp.responseText;

  console.log(xhttp.responseText);
	}
  }
 } 


function saveWarrantiesData()
 {

 var tools_id= document.getElementById("tools_id").value;
 var warranty_type= document.getElementById("warranty_type").value;
 var provider= document.getElementById("provider").value;
 var wrty_term_type= document.getElementById("warranty_usage_term_type").value;
 var meter_limit= document.getElementById("meter_reading_v_limit").value;
 var meter_reading_units= document.getElementById("meter_reading_units").value;
 var expiry_date= document.getElementById("expiry_date").value;
 var certificate_no= document.getElementById("certificate_number").value;
 var desc= document.getElementById("desc").value;
 var date_added= document.getElementById("date_added").value;



if(warranty_type=='')
{
alert("Please Select Warranty Type");
}else if(wrty_term_type==''){
alert("Please Select Warranty Usage Term Type");
}else if(expiry_date==''){
	alert("Please Select Expiry Date");
}else{

 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "insert_tools_warranty?tools_id="+tools_id+"&warranty_type="+warranty_type+"&provider="+provider+"&wrty_term_type="+wrty_term_type+"&meter_limit="+meter_limit+"&meter_reading_units="+meter_reading_units+"&expiry_date="+expiry_date+"&certificate_no="+certificate_no+"&desc="+desc+"&date_added="+date_added, false);
 xhttp.send();
 $("#machinewarranties .close").click();
  $('#warrantiesform')[0].reset(); 	   
  document.getElementById("loadwarranties").innerHTML = xhttp.responseText;

  console.log(xhttp.responseText);

 }
}


function saveSupplierData()
 {

 var machine_id= document.getElementById("machine_id").value;
 var supplier_name= document.getElementById("supplier_name").value;
 var supplier_type= document.getElementById("supplier_type").value;
 var Supplier_part_number= document.getElementById("Supplier_part_number").value;
 var catelog_id= document.getElementById("catelog_id").value;
 

if(supplier_name=='')
{
alert("Please Select Supplier Name");
}else if(supplier_type==''){
alert("Please Select Supplier Type");
}else{

 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "insert_machine_suppliers?machine_id="+machine_id+"&supplier_name="+supplier_name+"&supplier_type="+supplier_type+"&Supplier_part_number="+Supplier_part_number+"&catelog_id="+catelog_id, false);
 xhttp.send();
 $("#machinesuppliers .close").click();
  $('#suppliersform')[0].reset(); 	   
  document.getElementById("loadsuppliers").innerHTML = xhttp.responseText;

  console.log(xhttp.responseText);

 }
}


function submitrawMaterialReceive() {
        
  var form_data = new FormData(document.getElementById("myProduction_purchase_grn"));
  form_data.append("label", "WEBUPLOAD");

  $.ajax({
      url: "insert_tools_files",
      type: "POST",
      data: form_data,
      processData: false,  // tell jQuery not to process the data
      contentType: false   // tell jQuery not to set contentType
  }).done(function( data ) {
	
	$("#addfiles .close").click();
	$('#myProduction_purchase_grn')[0].reset(); 	
  	ajex_RawMatData(<?=$_GET['id'];?>);
	 
    console.log(data);
    //Perform ANy action after successfuly post data
       
  });
  return false;     
}
// ends
function ajex_RawMatData(production_id){
//alert(production_id);
 ur = "get_tools_files";
   $.ajax({
     url: ur,
     data: { 'id' : production_id },
     type: "POST",
     success: function(data){
      // alert(data);
       //alert("jkhkjh"+type);
       //$("#listingData").hide();
       $("#loadfiles").empty().append(data).fadeIn();

    }
   });
}
</script>

<script>

function getEditItemm(v,button_type){
 var pro=v;
 //alert(button_type);
 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "<?=base_url();?>master/Item/edit_map_item?ID="+pro+"&type="+button_type, false);
 xhttp.send();

 document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
 } 	



$(document).ready(function(){

$("#prd").keyup(function(){
/*$(".savebutton").keyup(function(){*/

var datas=$("#prd").val();
//alert(datas);
		$.ajax({
			
			url:"<?php echo base_url();?>assets/machine/codevalidation",
			data:{"codeval":datas},
			success:function(data){
						
				if(data==1)
				{
					
					$("#codee").html("Code Already Exists");
					$(".savebutton").prop("disabled",true);
					

					//$("#codee").val("Code already exists");
				}
				else
				{
					$("#codee").html("");
					$(".savebutton").attr("disabled",false);
				}
			}
			
		});

});



});



  
 function getdataSPd(val){
    //alert(val);
    $('#productLists').css('display','block');
    ur = "<?=base_url('assets/machine/ajax_productlists');?>"
    $.ajax({
      type: "POST",
      url: ur,
      data: {'value':val},
      success: function(data){
          console.log(data);
          $('#productLists').html(data);
      }
    });
  }


function selectLists(ths){
 var data =  $(ths).attr('jsvalue');
   if(data !== undefined)
     var data = JSON.parse(data);
  $('#productLists').css('display','none');
  $('#prdd').val(data.productname);
  $('#pri_id').val(data.Product_id);
}


</script>


<script>

function myFunction_meter() {

    var x = document.getElementById("readingg").value;
	var y = document.getElementById("lastreadingmeter").value;
	if(Number(x)<=Number(y)){
	alert("Enter More Than Last Reading Value");
	return false;
	}
    //x.value = x.value.toUpperCase();
}


</script>