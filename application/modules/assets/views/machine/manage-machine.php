<link rel="stylesheet" href="<?php echo base_url();?>assets/css/vendor/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/chosen/chosen.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
<link rel="stylesheet" href="<?=base_url();?>assets/tooltips/main.css">
<?php
$this->load->view("header.php");

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

<form class="form-horizontal" role="form"  enctype="multipart/form-data">			
<div id="editItem" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-contentitem" id="modal-contentitem">

        </div>
    </div>	 
</div>
</form>

<div class="panel-default">
<form class="form-horizontal" role="form" method="post" id="formMachine" action="insert_machine">			
<ol class="breadcrumb breadcrumb-2"> 
<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
<li><a href="#">Assets</a></li> 
<li class="active"><strong>Manage Machine</strong></li>
<div class="pull-right">
<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#Machinemodal" formid="#formMachine" id="formreset" title="Add Machine" >Add Machine</button>
<div id="Machinemodal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content" >
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Machine</h4>
<div id="resultareamachine" class="text-center " style="font-size: 15px;color: red;"></div> 
</div>

<div class="modal-body overflow">

<div class="form-group"> 
<label class="col-sm-2 control-label">*Code:</label> 
<div class="col-sm-4"> 
<input type="hidden" id="id" name="id" value="" />
<input type="text" class="form-control" name="code" id="code" onkeyup="checkMachineCode(this.value);"> 
<span class="c-validation c-error" style="text-align:center; color:#F00" id="codemsg"></span>
</div> 
<label class="col-sm-2 control-label">*Section:</label> 
<div class="col-sm-4"> 
<select name="m_type" required class="select2 form-control" id="m_type" style="width:100%;">
<option value="0" class="listClass">-----Section-----</option>
<?php
foreach ($categorySelectbox as $key => $dt) { ?>
<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
<?php } ?>
</select>
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">*Machine Name:</label> 
<div class="col-sm-4"> 
<input name="machine_name"  type="text" id="machine_name" class="form-control" required> 
</div> 
<label class="col-sm-2 control-label">*Capacity:</label> 
<div class="col-sm-4"> 
<input type="text" id="capacity" name="capacity" class="form-control"  />          
</div>
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">*Metering Unit:</label> 
<div class="col-sm-4"> 
<select name="m_unit" required class="select2 form-control" id="m_unit" style="width:100%;">
	<option value="" >----Select----</option>
	<?php 
		$sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
		foreach ($sqlunit->result() as $fetchunit){
	?>
	<option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
		<?php } ?>
</select>
</div>
<label class="col-sm-2 control-label">*Machine Description:</label> 
<div class="col-sm-4"> 
<textarea name="machine_des" class="form-control" id="machine_des"></textarea>
</div>  
</div>

</div>

<div class="modal-footer">
<button type="button" id="saveButton" onclick="saveData()" class="btn btn-sm"  >Save</button>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<a href="#/" class="btn btn-secondary btn-sm delete_all" title="Delete Multiple"><i class="fa fa-trash-o"></i> Delete All</a>
</div>
</ol>
</form>	

<?php if($this->session->flashdata('flash_msg')!='') { ?>
<div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
<strong>Well done! &nbsp;<?php echo $this->session->flashdata('flash_msg');?></strong> 
</div>	
<?php } ?>		

<div class="row">
<div class="col-lg-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

<div class="row">
<div class="col-sm-12" id="listingData">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?=base_url();?>assets/machine/manage_machine?<?='codee='.$_GET['codee'].'&m_type='.$_GET['m_type'].'&machine_name='.$_GET['machine_name'].'&machine_description='.$_GET['machine_description'].'&capacity='.$_GET['capacity'].'&m_type='.$_GET['m_type'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
	<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
	<option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
	<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
</select>
Entries</label>
<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -6px;margin-left: 12px;float: right;">
Showing <?=$dataConfig['page']+1;?> to 
<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
?> of <?=$dataConfig['total'];?> Entries
</div>
</div>

<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
</label>
</div>
</div>

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
<thead>
<tr>
	<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
	<th>Code</th>
	<th>Section</th>
	<th>Machine Name</th>
	<th>Machine Description</th>
	<th>Capacity</th>
	<th>Action</th>
</tr>
</thead>

<tbody id = "getDataTable">	
<tr>
<form method="get">	
	<td>&nbsp;</td>
	<td><input name="codee"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="m_type"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="machine_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><input name="machine_description"  type="text"  class="search_box form-control input-sm"  /></td>
	<td><input name="capacity"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
</form>	
</tr>
										
<?php  
/*echo "<pre>";
print_r($result);
echo "</pre>";*/

$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>
<th><?php echo $fetch_list->code; ?></th>
<th><?php 
	$sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->m_type."'");
	$compRow = $sqlunit->row();
	echo $compRow->name;
?>
</th>
<th><a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $fetch_list->id; ?>" title="Machine Spare Details"><?=$fetch_list->machine_name;?></a></th>
<th>
<div class="tooltip-col">
<?php 
   $big = $fetch_list->machine_des;  
$big = strip_tags($big);
$small = substr($big, 0, 20);
echo strtolower($small ."....."); ?>
<span class="tooltiptext3"><?=$big;?> </span>
</div>
</th>
<th><?=$fetch_list->capacity;?></th>

<th class="bs-example"><div style="width: 110px;">
<?php if($view!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Machine"> <i class="fa fa-eye"></i> </button>
 
<?php } if($edit!=''){ ?>

<button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Machine"><i class="icon-pencil"></i></button>

<?php }
$pri_col='id';
$table_name='tbl_machine';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Machine"><i class="icon-trash"></i></button>		

<button style="display:none" class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'>MAP SPARE</button>
</div>
</th>
</tr>

<?php  } ?>
</tbody>
</table>

<input type="text" style="display:none;" id="table_name" value="tbl_machine">  
<input type="text" style="display:none;" id="pri_col" value="id">

</div>

<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> </div>
		<div class="col-md-6"> <?php echo $pagination; ?></div>
	</div>
</div>

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

<!-- <form class="form-horizontal" role="form" method="post" action="insert_spare">			
<div id="mapSpare" class="modal fade modal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-contentMap" id="modal-contentMap">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Map Spare</h4>
<table class="table table-striped table-bordered table-hover" >
<tbody>
<tr class="gradeA">
<th>Spare Name</th>
<th>Action</th>
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
<input type="button"  id="qn" style="width:70px;" onclick="adda()" value="Add" class="form-control"> 
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
<?php
// $z=1;
// $query_dtl=$this->db->query("select * from tbl_machine_spare_map   ");
// foreach($query_dtl->result() as $invoiceFetch)
// {

// $productQuery=$this->db->query("select *from tbl_product_stock where Product_id='$invoiceFetch->spare_id'");
// $getProductName=$productQuery->row();

?>
<tr>
<td align="center" style="width: 0.2%;"><?php echo $z;?></td>
<td align="center" style="width: 11%;"><input type="text" name="pd[]" id="pd<?php echo $z;?>" value="<?php echo $getProductName->productname;?>^<?php echo $invoiceFetch->product_id;?>" readonly="" style="text-align: center; width: 100%; border:hidden;">
<input type="hidden" name="main_id[]" id="main_id<?php echo $z;?>" value="<?php echo $invoiceFetch->product_id;?>" readonly="" style="text-align: center; width: 100%; border:hidden;"><input type="hidden" value="Box" name="unit[]" id="unit<?php echo $z;?>" readonly="" style="text-align: center; width: 100%; border: hidden;">
</td>
<td align="center" style="width: 3%;"><img src="<?php echo base_url();?>assets/images/delete.png" border="0" name="dlt" id="dlt<?php echo $z;?>" onclick="deleteselectrow(this.id,this);"  readonly style="border: hidden;"><img src="<?php echo base_url();?>assets/images/edit.png" border="0" name="ed" id="ed<?php echo $z;?>" onclick="editselectrow(this.id,this);" style=" border: hidden;"></td>
</tr>
<?php //$row=$z; $z++;  } ?>
</table>



</div>


<input type="hidden" name="rows" id="rows" value="<?php echo $row;?>">

<input type="hidden" name="spid" id="spid" value="d1"/>
<input type="hidden" name="ef" id="ef" value="0" />

</div>
</div>
</div>	 
</div>
</form>-->



<script type="text/javascript">

function getEditItem(v,button_type)
{

 var pro=v;
 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "getMachinePage?ID="+pro+"&type="+button_type, false);
 xhttp.send();

 document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;

} 	


function getSpareMap(v)
{

  var pro=v;
  var xhttp = new XMLHttpRequest();
 
  xhttp.open("GET", "getSpare?ID="+pro, false);
  xhttp.send();
  document.getElementById("modal-contentMap").innerHTML = xhttp.responseText;

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

</script>	

<script type="text/javascript">

function saveData()
{
	
    var code         = document.getElementById("code").value;
	var id           = document.getElementById("id").value;
	var machine_name = document.getElementById("machine_name").value;
	var machine_des  = document.getElementById("machine_des").value;
	var capacity     = document.getElementById("capacity").value;
	var m_type       = document.getElementById("m_type").value;
	var m_unit       = document.getElementById("m_unit").value;

	if(code=='')
	{
	  document.getElementById("codemsg").innerHTML = "Please Enter Code";
	  return false;
	}

	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "insert_machine?id="+id+"&code="+code+"&machine_name="+machine_name+"&machine_des="+machine_des+"&capacity="+capacity+"&m_type="+m_type+"&m_unit="+m_unit, false);
	xhttp.send();

	document.getElementById("resultareamachine").innerHTML="Added Successfully";
	setTimeout(function() {
	$("#Machinemodal .close").click();
	document.getElementById("resultareamachine").innerHTML="";	
	 document.getElementById("code").value='';
	 document.getElementById("id").value='';
	 document.getElementById("machine_name").value='';
	 document.getElementById("machine_des").value='';
	 document.getElementById("capacity").value='';
	 document.getElementById("m_type").value='';
	 document.getElementById("m_unit").value='';   
	}, 1500 );	
	
	document.getElementById("loadData").innerHTML = xhttp.responseText;
	document.getElementById("code").value='';
	
}

function editData()
{
	
    var code         = document.getElementById("editcode").value;
	var id           = document.getElementById("editid").value;
	var machine_name = document.getElementById("editmachine_name").value;
	var machine_des  = document.getElementById("editmachine_des").value;
	var capacity     = document.getElementById("editcapacity").value;
	var m_type       = document.getElementById("editm_type").value;
	var m_unit       = document.getElementById("m_unit").value;

	if(code=='')
	{
	  document.getElementById("codemsg").innerHTML = "Please Enter Code";
	  return false;
	}

	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "insert_machine?id="+id+"&code="+code+"&machine_name="+machine_name+"&machine_des="+machine_des+"&capacity="+capacity+"&m_type="+m_type+"&m_unit="+m_unit, false);
	xhttp.send();

	document.getElementById("mssg100").innerHTML="Updated Successfully";
	setTimeout(function(){
	$("#editItem .close").click();	   	
	},1000);
	
	document.getElementById("loadData").innerHTML = xhttp.responseText;

	document.getElementById("code").value='';
	document.getElementById("id").value='';
	
}

</script>


<script type="text/javascript">
	function checkMachineCode(v)
	{
		$.ajax({

				url  : "<?=base_url()?>assets/machine/check_machine_code",
				type : "POST",
				data : {'id' : v},
				success:function(data)
				{
					if(data == 1)
					{
						$("#codemsg").html("Code Aleready Exists");
						$("#saveButton").attr("disabled",true);
					}
					else
					{
						$("#codemsg").html("");
						$("#saveButton").removeAttr("disabled",false);	
					}
				}

			  });

	}

</script>
<script>
function exportTableToExcel(tableID, filename = '')
{

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Manage Machine <?php echo date('d-m-Y');?>.xls';
   
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

<script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>
<script src="<?php echo base_url();?>assets/js/vendor/jRespond/jRespond.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vendor/animsition/js/jquery.animsition.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vendor/chosen/chosen.jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>

<script>
/*$(document).ready(function() {
  $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
  setInterval(function() {
    //$('#getDataTable').load('get_machine');
  }, 3000); // the "3000" 
});
*/
</script>


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