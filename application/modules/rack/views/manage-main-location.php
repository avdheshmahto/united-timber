<?php
$this->load->view("header.php");
$entries = "";

if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>

<!-- Main content -->
<div class="main-content">
<div class="panel-default">
<form class="form-horizontal"  id="Location_form">			
<ol class="breadcrumb breadcrumb-2"> 
<li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li> 
<li><a href="#">Location</a></li> 
<li class="active"><strong><a href="#">Add Location</a></strong></li>
<div class="pull-right">
<button type="button" class="btn btn-sm addlocation" data-toggle="modal" data-target="#editlocation" title="Add Location">Add Location</button>
<div id="editlocation" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
	<strong><div id="title">Add Location</div></strong>
	<span style="font-size: 14px;text-align: center;color: red">
	<div id="success-message"></div>
	</span>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"  id="closes"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"><div id="title" style="font-size: 14px;"></div></h4>
</div>

<div class="modal-body overflow-">
<div class="form-group">
<label class="col-sm-2 control-label">*Location Name:</label> 
<div class="col-sm-4"> 
<input name="loc_name" id="loc_det" type="text" value="" class="form-control" onkeyup="validationfunc();">
<input type="hidden" value="" name="id" id="id"> 
</div> 
</div>
<div id="Location_Validation" style="font-size: 12px;color: red"></div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary btn-sm save" id="locationSave">Save</button>
<span id="saveload" style="display: none;">
<img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
</span>
<button  class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
</div>

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<a href="#/" class="btn btn-secondary btn-sm delete_all" title="Multiple Delete"><i class="fa fa-trash-o"></i> Delete All</a>
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
	<select name="DataTables_Table_0_length" url="<?=base_url();?>locationRack/manage-main-location?<?='loc_name='.$_GET['loc_name']?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
   <th>Serial Number</th>	   
   <th>Location Name </th>
   <th style="width:110px;">Action</th>
</tr>
</thead>

<tbody id = "getDataTable">
<tr>
<form method="get">
	<td>&nbsp;</td>
	<td><input name="serial_no"  type="text"  class="search_box form-control input-sm"   value="" readonly="" style="background-color: white;" /></td>
	<td><input name="loc_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
	<td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
</form>
</tr>

<form class="form-horizontal" method="post" action="update_item"  enctype="multipart/form-data">

<?php  
$i=1;
foreach($result as $fetch_list)  {
?>

<tr class="gradeC record" data-row-id="<?php echo $fetch_list->id; ?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>


<th><?php echo ($dataConfig['page']+$i)?></th>
<th><?=$fetch_list->keyvalue;?></th>
<th class="bs-example">
<?php if($view!=''){ ?>


<button class="btn btn-default" property="view" attr='<?php echo json_encode($fetch_list)?>' onclick="editlocation(this);" href='#editlocation' type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Main Location"> <i class="fa fa-eye"></i> </button>

<?php } if($edit!=''){ ?>

<button class="btn btn-default" property="edit" attr='<?php echo json_encode($fetch_list)?>' onclick="editlocation(this);" href='#editlocation' type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Main Location"><i class="icon-pencil"></i></button>

<?php }
$pri_col='serial_number';
$table_name='tbl_master_data';
?>
<button class="btn btn-default delbutton" id="<?php echo $fetch_list->serial_number."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Main Location"><i class="icon-trash"></i></button>		
<?php
 $i++;
 }
  ?>
 
</th>
</tr>

</form>
</tbody>
</table>

<div class="row">
	<div class="col-md-12 text-right">
	<div class="col-md-6 text-left"> </div>
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
 xhttp.open("GET", "getmainLocationPage?ID="+pro+"&type="+button_type, false);
 xhttp.send();

 document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;

} 		
 
 
function editData()
{
    
   var id          	 = document.getElementById("id").value;
   var loc_name    	 = document.getElementById("loc_name").value;
  
 	var xhttp = new XMLHttpRequest();
  	xhttp.open("GET", "insert_main_location?id="+id+"&loc_name="+loc_name, false);
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


<script type="text/javascript">

function exportTableToExcel(tableID, filename = '')
{

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Locations  <?php echo date('d-m-Y');?>.xls';
   
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
	

//----------------------------Location Form Validation Start----------------------------------------

function validationfunc()
{
    var val1=document.getElementById("loc_det").value;
    var valdata="&val1="+val1;
    ur="singlevalidation";
    $.ajax({
              type:"POST",
              url:ur,
              data:valdata,
              success:function(data)
              {
              
                if(data==1)
                {
                   document.getElementById("Location_Validation").innerHTML="Location with same name already exists....";
                   $('#Location_form :input[type="submit"]').attr('disabled',true);
                }
                else if(data==0)
                {
                  document.getElementById("Location_Validation").innerHTML=""; 
                  $('#Location_form :input[type="submit"]').attr('disabled',false);          
                }
              }
        });
}

   


</script>

