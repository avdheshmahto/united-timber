<?php
$this->load->view("header.php");
$entries = "";
if($this->input->get('entries')!=""){
  $entries = $this->input->get('entries');
}

?>
<!-- Main content -->
<div class="main-content">
<div class="panel-default">

<form class="form-horizontal" id="LocationRackFormEdit">			
<div id="editItem" class="modal fade modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-contentitem" id="modal-contentitem">

        </div>
    </div>	 
</div>
</form>

<form class="form-horizontal" id="LocationRackForm" >
<ol class="breadcrumb breadcrumb-2"> 
<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
<li><a href="#">Location</a></li> 
<li class="active"><strong><a href="#">Add Location Rack</a></strong></li>
<div class="pull-right">
<button type="button" class="btn btn-sm addlocationRack" data-toggle="modal" data-target="#modal-0" title="Add Rack">Add Rack</button>

<div id="modal-0" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Location Rack</h4><div id="operationarea" style="color: red;text-align: center;font-size:12px"></div>
</div>

<div class="modal-body overflow-">
<div class="form-group"> 
<label class="col-sm-2 control-label">*Location Name:</label> 
<div class="col-sm-4"> 
<!-- <select style="display:none" name="location_id"  class="form-control" >
</select> -->  
<input type="hidden"  name="id" value="<?php echo $branchFetch->id; ?>" />
<select name="location_rack_id" id="location_rack_id"  class="form-control ui fluid email search dropdown" onchange="Validatehide();validationfunc();" required>
<option value="">----Select ----</option>
<?php 
$sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
foreach ($sqlgroup->result() as $fetchgroup){						
?>					
<option value="<?php echo $fetchgroup->serial_number; ?>"><?php echo $fetchgroup->keyvalue; ?></option>
<?php } ?>
</select> 
<div id="Location_Validation" style="color: red;font-size: 12px"></div>
</div> 
<label class="col-sm-2 control-label">*Rack Name:</label> 
<div class="col-sm-4"> 
<input name="rack_name"  type="text" value="" class="form-control" id="rack_name" onkeyup="validationfunc();"> 
</div> 
</div>
</div>

<div class="modal-footer"><button type="submit" id="racksave" class="btn btn-sm" >Save</button>
<span id="saveload" style="display: none;">
<img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
</span>
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<a href="#/" class="btn btn-secondary btn-sm delete_all" title="Multiple Delete">
	<i class="fa fa-trash-o"></i> Delete All</a>
</div>
</ol>
</form>	
		
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
	<select name="DataTables_Table_0_length" url="<?=base_url();?>locationRack/manage_location_rack?<?='location_rack_id='.$_GET['location_rack_id'].'&rack_name='.$_GET['rack_name'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
		<option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
		<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
		<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
		<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
		<option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
		<option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
		<option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
		
	</select>
	entries</label>
	<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="    margin-top: -5px;margin-left: 12px;float: right;">Showing <?=$dataConfig['page']+1;?> to 
	<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
	?> of <?=$dataConfig['total'];?> entries
	</div>
</div>
	
<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm" name="filter"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
</label>
</div>

</div>

<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData"  >
<thead>
<tr>
		<th style="width:22px;"><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
	   <th>Location Name </th>       
		 <th>Location Rack</th>             
		 <th style="width:110px;">Action</th>
</tr>
</thead>

<tbody id = "getDataTable">
<tr>

	<form method="get">
	<td>&nbsp;</td>
	<td><input name="location_rack_id"  type="text"  class="search_box form-control input-sm"   value="" /></td>
	<td><input name="rack_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
</form>
</tr>

<form class="form-horizontal" method="post" action="update_item"  enctype="multipart/form-data">

<?php  
$i=1;
foreach($result as $fetch_list)
{
?>

<tr class="gradeC record" data-row-id="<?php echo $fetch_list->id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>
<?php 
 $compQuery = $this -> db
           -> select('*')
           -> where('serial_number',$fetch_list->location_rack_id)
           -> get('tbl_master_data');
		  $compRow = $compQuery->row();
?>

<th><?php echo $compRow->keyvalue;?></th>
<th><?php echo $fetch_list->rack_name;?></th>
 
<th class="bs-example">
<?php if($view!=''){ ?>

<button class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#editItem'onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Location Rack"> <i class="fa fa-eye"></i> </button>

<?php } if($edit!=''){ ?>

<button class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#editItem'onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Location Rack"><i class="icon-pencil"></i></button>

<?php }
$pri_col='id';
$table_name='tbl_location_rack';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Location Rack"><i class="icon-trash"></i></button>		
 
</th>
</tr>


<?php $i++; } ?>

<input type="text" style="display:none;" id="table_name" value="tbl_location_rack">  
<input type="text" style="display:none;" id="pri_col" value="id">
</form>
</tbody>

</table>
<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"></div>
	<div class="col-md-6"> 
	 	<?php echo $pagination; ?>
	</div>
</div>
</div>

</div>
</div>
</div><!--panel-default close-->
</div><!--main-content close-->


<script type="text/javascript">

function getEditItem(v,button_type)
{

	var pro=v;
	//alert(button_type);
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "getLocationRackPage?ID="+pro+"&type="+button_type, false);
	xhttp.send();
	document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;

} 		
 
 
function editData()
{
	
  var location_rack_id = document.getElementById("location_rack_id").value;
  var id          	 = document.getElementById("id").value;
  var rack_name    	 = document.getElementById("rack_name").value;
  
 	var xhttp = new XMLHttpRequest();
  	xhttp.open("GET", "<?=base_url()?>rack/insert_location_rack?id="+id+"&location_rack_id="+location_rack_id+"&rack_name="+rack_name, false);
 	xhttp.send();


	$("#editItem .close").click();	   
	document.getElementById("loadData").innerHTML = xhttp.responseText;
	document.getElementById("sec").value='';
	document.getElementById("id").value='';
	
	
}	
	
</script>	

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
   filename = filename?filename+'.xls':'Location Rack <?php echo date('d-m-Y');?>.xls';
   
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

//---------------------------------------------Validation Function close------------------------------------

function validationfunc()
{
    
    //alert('olkz');
    var val1=document.getElementById("location_rack_id").value;
    var val2=document.getElementById("rack_name").value;
    var valdata="&val1="+val1+"&val2="+val2;
    ur="validationdata";
    $.ajax({
              type:"POST",
              url:ur,
              data:valdata,
              success:function(data)
              {
                if(data==3)
                {
                  document.getElementById("Location_Validation").innerHTML="Select Location....";
                }
                else if(data==1)
                {
                  document.getElementById("Location_Validation").innerHTML="Rack on this location with same name already exists....";
                  $('#LocationRackForm :input[type="submit"]').attr('disabled',true);
                }
                else if(data==0)
                {
                  document.getElementById("Location_Validation").innerHTML=""; 
                  $('#LocationRackForm :input[type="submit"]').attr('disabled',false);
                }
            }
        });
}


function Validatehide()
{
	//alert();
	document.getElementById("Location_Validation").innerHTML="";
}


</script>
