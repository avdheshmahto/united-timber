<?php
$this->load->view("header.php");
$contactQuery=$this->db->query("select *from tbl_contact_m where contact_id='".$_GET['id']."'");
$getcontact=$contactQuery->row();
?>

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
<h3 class="panel-title" style="float: initial;">CONTACT :- <?=$getcontact->first_name;?>
	<a href="<?=base_url('master/Account/manage_contact');?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
</h3>
</div>

<div class="panel-body">
<form role="form">

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Name</h4>
<input type="text" name="" value="<?=$getcontact->first_name;?>" id="first_name" class="form-control" readonly >
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<div class="form-group">
<h4>Group Name</h4>
<?php 
$queryType=$this->db->query("select *from tbl_account_mst where account_id='$getcontact->group_name'");
$getType=$queryType->row();

?>
<input type="text" name="" id="last_name" class="form-control" value="<?=$getType->account_name;?>" readonly >
</div>
</div>
</div>


<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Contact Person</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->contact_person;?>" id="facility" class="form-control" readonly>
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Email</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->email;?>" id="m_unit" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Mobile No.</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->mobile;?>" id="facility" class="form-control" readonly>
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Phone No.</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->phone;?>" id="facility" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Pan No..</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->IT_Pan;?>" id="facility" class="form-control" readonly>
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>GST No.</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->gst;?>" id="facility" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Address1</h4>
<div class="form-group">
<textarea class="form-control" readonly><?=$getcontact->address1;?></textarea>
</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>Address2</h4>
<div class="form-group">
<textarea class="form-control" readonly><?=$getcontact->address3;?></textarea>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>City</h4>
<div class="form-group">
<?php 
// $querycity=$this->db->query("select *from tbl_city_m where cityid='$getcontact->state_id'");
// $getcity=$querycity->row();
?>
<input type="text" name="" value="<?=$getcontact->city;?>" id="facility" class="form-control" readonly>
</div>
</div>	
<div class="col-xs-6 col-sm-6 col-md-6">
<h4>State</h4>
<div class="form-group">
<?php 
$querystate=$this->db->query("select *from tbl_state_m where stateid='$getcontact->state_id'");
$getstate=$querystate->row();

?>
<input type="text" name="" value="<?=$getstate->stateName;?>" id="facility" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<h4>Pin Code</h4>
<div class="form-group">
<input type="text" name="" value="<?=$getcontact->pin_code;?>" id="facility" class="form-control" readonly>
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

<li class="active"><a href="#sparepricemapping" data-toggle="tab">Price Mapping</a></li>
<!-- <li class=""><a href="#mappedmachine" data-toggle="tab">Mapped Machine</a></li> -->
<li class=""><a href="#files" data-toggle="tab">Files</a></li>
<li class=""><a href="#stock_in" data-toggle="tab">Stock In</a></li>
<li class=""><a href="#stock_out" data-toggle="tab">Stock Out</a></li>
</ul>
<div class="tab-content">
<!-- ============================================= manage spare price mapping ============= -->
<div class="tab-pane active" id="sparepricemapping">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadsparepricemapping" >
<thead>
<tr>
	<th>NAME</th>
	<th>RATE</th>
</tr>
</thead>
<tbody>
<?php 

$sparequery = $this->db->query("select * from tbl_product_stock where supp_name = '".$_GET['id']."' ");

$i=1;
foreach($sparequery->result() as $result1)
{
		
?>
<tr>	
	<td><?=$result1->productname;?></td>
	<td><?=$result1->unitprice_purchase;?></td>	
</tr>
<?php  $i++;  }  ?>

<!-- <tr class="gradeU">
<td>
 <button  class="btn btn-default modalMapSpare" data-a="<?=$fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare Price Mapping"><img src="<?=base_url();?>assets/images/plus.png" /></button>
</td>
<td>&nbsp;</td>
</tr>
 -->
</tbody>
</table>
</div>
</div>
</div>

<!-- ============================================= manage mapped machine ============= -->
<div class="tab-pane" id="mappedmachine">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadSpare" >
<thead>
<tr>
	<!--<th>Spare</th>-->
	<th>MACHINE CODE</th>
	<th>MACHINE NAME</th>
	<th>FACILITIES</th>
	<th>CAPACITY</th>
	<th>DESCRIPTION</th>

</tr>
</thead>


<tbody>
<?php 
$supplieraName=$this->db->query("select * from tbl_machine_suppliers where suppliers_name='".$_GET['id']."'");
$supplierslist=$supplieraName->row();

$machineQueryy=$this->db->query("select *from tbl_machine where id='$supplierslist->machine_id'");
foreach($machineQueryy->result() as $machine_qry){ ?>

<tr>
	<td><?=$machine_qry->code;?></td>
	<td>
	<a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $machine_qry->id; ?>">
	<?=$machine_qry->machine_name;?></a></td>
	<td>
	<?php 
	$queryType_macs=$this->db->query("select *from tbl_category where id = '$machine_qry->m_type'");
	$getType_macww=$queryType_macs->row();
	?>	

	<?=$getType_macww->name;?></td>
	<td>
	<?=$machine_qry->capacity;?>
	</td>
	<td><?=$machine_qry->machine_des;?></td>
</tr>
<?php } ?>
</tbody>

</table>

</div>

</div>
</div>

<!-- ============================================= stock out ============= -->
<div class="tab-pane" id="stock_out">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadSpare" >
<thead>
<tr>
	
	<th>Parts & Supplies Name</th>
	<th>Type</th>
	<th>Purchase Price</th>
	<th>Location</th>
	<th>Rack</th>

</tr>
</thead>


<tbody>
<?php 
$supplieraName=$this->db->query("select * from tbl_spare_return_hdr where vendor_id='".$_GET['id']."'");
$count2=$supplieraName->num_rows();

$val2=array();
foreach($supplieraName->result() as $getWosh)
{
  if($getWosh->rflhdrid != '')
  array_push($val2,$getWosh->rflhdrid);
}
if($count2 > 0)
{
  $valXyz=implode(',',$val2);  
}
else
{
  $valXyz='99999999';
}

$machineQueryy=$this->db->query("select * from tbl_spare_return_dtl where refillhdr IN ($valXyz)");
foreach($machineQueryy->result() as $fetch){ ?>

<tr>
	<td><?php 
	$prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch->product_id' ");
	$getPrd=$prd->row();
	echo $getPrd->productname;
	?></td>
	<td><?= $getPrd->via_type;  ?></td>
	<th><?=$fetch->purchase_price;?></td>
	<td><?php
	$loc=$this->db->query("select * from tbl_master_data where serial_number='$fetch->loc' AND param_id=21 ");
	$getLoc=$loc->row();

	echo $getLoc->keyvalue;
	?>
	</td>
	<td><?php
	$rack=$this->db->query("select * from tbl_location_rack where id='$fetch->rack_id' ");
	$getRack=$rack->row();

	echo $getRack->rack_name;
	?>
	</td>
</tr>
<?php } ?>
</tbody>

</table>

</div>

</div>
</div>

<!-- ============================================= stock in ============= -->
<div class="tab-pane" id="stock_in">
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadSpare" >
<thead>
<tr>
	
	<th>Parts & Supplies Name</th>
	<th>Type</th>
	<th>Purchase Price</th>
	<th>Location</th>
	<th>Rack</th>

</tr>
</thead>


<tbody>
<?php 
$supplieraName=$this->db->query("select * from tbl_bin_card_hdr where vendor_id='".$_GET['id']."'");
$count2=$supplieraName->num_rows();

$val2=array();
foreach($supplieraName->result() as $getWosh)
{
  if($getWosh->rflhdrid != '')
  array_push($val2,$getWosh->rflhdrid);
}
if($count2 > 0)
{
  $valXyz=implode(',',$val2);  
}
else
{
  $valXyz='99999999';
}

$machineQueryy=$this->db->query("select * from tbl_bin_card_dtl where refillhdr IN ($valXyz)");
foreach($machineQueryy->result() as $fetch){ ?>

<tr>
	<td><?php 
	$prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch->product_id' ");
	$getPrd=$prd->row();
	echo $getPrd->productname;
	?></td>
	<td><?= $getPrd->via_type;  ?></td>
	<th><?=$fetch->purchase_price;?></td>
	<td><?php
	$loc=$this->db->query("select * from tbl_master_data where serial_number='$fetch->loc' AND param_id=21 ");
	$getLoc=$loc->row();

	echo $getLoc->keyvalue;
	?>
	</td>
	<td><?php
	$rack=$this->db->query("select * from tbl_location_rack where id='$fetch->rack_id' ");
	$getRack=$rack->row();

	echo $getRack->rack_name;
	?>
	</td>
</tr>
<?php } ?>
</tbody>

</table>

</div>

</div>
</div>

<!-- ============================================= manage contact files ============= -->
<div class="tab-pane" id="files">
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
$supplieraName=$this->db->query("select * from tbl_machine_files_uploads where file_log_id='".$_GET['id']."' and module_type='Contact' ");
foreach($supplieraName->result() as $fetch_list)

{ ?>

   <tr class="gradeU record">
       <td><?=$i;?></td>
       	<td><a target="blank" href="<?=base_url('filesimages/contactfiles');?>/<?=$fetch_list->file_name;?>"><?=$fetch_list->file_name;?></a></td>
		<td><?=$fetch_list->desc_id;?></td>		 
		     
       <td><?php $pri_col='id';
                  $table_name='tbl_machine_files_uploads';
         ?>
        <?php if($view!=''){ ?>
	   		
		 <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete file"><i class="icon-trash"></i></button>	
		<?php }?>
		</td>

    </tr>

<?php $i++; }?>
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


<!-- ============================Add spare price mapping ============================== -->
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
			<h4 class="modal-title">Spare Price Mapping</h4>
			<div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div> 
				<table class="table table-striped table-bordered table-hover" >
					<tbody>
					<tr class="gradeA">
						<th>Spare Name</th>
						<th>Rate</th>
						<th>Action</th>
					</tr>
					<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="sparePriceMapForm">
					<tr class="gradeA">
						<th style="width:280px;">
							<div class="input-group"> 
								<div style="width:100%; height:28px;" >
								<input type="text" name="prd"  onkeyup="getdatasparepricemapping(this.value);" onClick="getdatasparepricemapping(this.value);" id="prd" style=" width:230px;" class="form-control"  placeholder=" Search Items..." tabindex="5" autocomplete="off" >
								 <input type="hidden" class="hiddenField"  name="pri_id" id='pri_id'  value="" style="width:80px;"  /> 
                                 <input type="hidden"   name="vendorid" id='vendorid'  value="<?php echo $_GET['id'];?>" style="width:80px;"  /> 
								 <div  style="color:black;padding-left:0px; width:100%; height:110px; max-height:110px;overflow-x:auto;overflow-y:auto;padding-bottom:5px;padding-top:0px; position:absolute;margin:31px 0 0 0px;">
								<ul style="position: absolute;z-index: 999999;" id="sparelist">
									
								</ul>
								</div>
							</div>
							
					  </th>
					  
					  <th>
					  <input type="number" name="rate" placeholder = "0.0" id="rate"  style="width:90px;" class="form-control" >
					  </th>
					  
					 
                        <th>
						<input type="submit"  style="width:70px;" value="Add" class="form-control"> 
					   </th>
					</tr>
			     </form>
			  </tbody>
		  </table>
		</div>
	</div>	 
</div>
</div>
<!-- ======================================================================================== -->

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
<input type="hidden" name="contact_id" id="contact_id" value="<?php echo $_GET['id']; ?>">
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
</div><!--tabs-container close-->
</div>
</div>
</div>
</div>
</div><!--main-content close-->

<?php
 $this->load->view("footer.php");
?>

<script type="text/javascript">
	

function submitrawMaterialReceive() {
        
  var form_data = new FormData(document.getElementById("myProduction_purchase_grn"));
  form_data.append("label", "WEBUPLOAD");

  $.ajax({
      url: "insert_contact_files",
      type: "POST",
      data: form_data,
      processData: false,  // tell jQuery not to process the data
      contentType: false   // tell jQuery not to set contentType
  	}).done(function( data ) {
	
	$("#addfiles .close").click();
	$('#myProduction_purchase_grn')[0].reset(); 	
  	ajex_RawMatData(<?=$_GET['id'];?>);
	 

    //console.log(data);
    //Perform ANy action after successfuly post data
       
  });
  return false;     
}
// ends
function ajex_RawMatData(production_id){
//alert(production_id);
 ur = "get_contact_files";
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
</div>

</div>
