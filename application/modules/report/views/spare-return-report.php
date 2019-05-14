<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">


<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>
<div class="main-content">
<?php
$this->load->view("reportheader");
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">STOCK RETURN REPORT </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" >
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">PO No.</label> 
<div class="col-sm-3"> 
<input type="text" name="po_no" class="form-control" value="" />
</div>
<label class="col-sm-2 control-label">Vendor Name</label> 
<div class="col-sm-3"> 
<select name="p_name"  class="select2 form-control" >
    <option value="" >----Select Unit----</option>
    <?php 
      $sqlunit=$this->db->query("select * from tbl_contact_m where group_name=5 ");
      foreach ($sqlunit->result() as $fetchunit){
    ?>
    <option value="<?php echo $fetchunit->contact_id;?>"><?php echo $fetchunit->first_name; ?></option>
    <?php } ?>
 </select> 
</div>
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">From Date</label> 
<div class="col-sm-3"> 
<input type="date" name="f_date" class="form-control" value="" /> 
</div>
<label class="col-sm-2 control-label">To Date</label> 
<div class="col-sm-3"> 
<input type="date" name="t_date" class="form-control" value="" /> 
</div>
<!-- <label><button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Search</span></button></label> -->
</div> 
<div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</div>
</form>


<div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('tblData')">Excel</button>  &nbsp;&nbsp;	
<!-- <a href="<?=base_url();?>report/Report/excel_spare_return_report?<?='po_no='.$_GET['po_no'].'&p_name='.$_GET['p_name'].'&p_date='.$_GET['p_date'].'&f_date='.$_GET['f_date'].'&t_date='.$_GET['t_date'].'&filter='.'filter'?>" class="btn btn-sm" >Excel</a> -->

</div>
</div>



<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/spare_return?<?='po_no='.$_GET['po_no'].'&p_name='.$_GET['p_name'].'&p_date='.$_GET['p_date'].'&f_date='.$_GET['f_date'].'&t_date='.$_GET['t_date'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
<table class="table table-striped table-bordered table-hover dataTables-example1" id="tblData">
<thead>
<tr>
  
  <th>S. No.</th>
  <th>Vendor Name</th>
  <th>Po No.</th>
  <th>Po Date</th>
  <th>Parts & Supplies Name</th>
  <th>Type</th>
  <th>Location</th>
  <th>Rack</th>
  <th>Purchase Price</th>
  <th>Quantity</th>
		
</tr>
</thead>

<tbody id="getDataTable" >

<tr style="display: none;">
  <td></td>
  <td></td>
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
foreach($result as $fetch) { ?>

<tr class="gradeC record">
<th><?php echo $i++;  ?></th>
<th>
<?php 
$vendorQuery = $this -> db
   -> select('*')
   -> where('contact_id',$fetch->vendor_id)
   -> get('tbl_contact_m');
$getVendor=$vendorQuery->row();

echo $getVendor->first_name; ?>
</th>
<th><?php echo $fetch->po_no;  ?></th>
<th><?php echo $fetch->po_date;  ?></th>
<th><?php 
$prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch->product_id' ");
$getPrd=$prd->row();
echo $getPrd->productname;

?></th>
<th><?php echo $fetch->type;  ?></th>
<th><?php
$loc=$this->db->query("select * from tbl_master_data where serial_number='$fetch->loc' AND param_id=21 ");
$getLoc=$loc->row();

echo $getLoc->keyvalue;
?>
</th>
<th><?php
$rack=$this->db->query("select * from tbl_location_rack where id='$fetch->rack_id' ");
$getRack=$rack->row();

echo $getRack->rack_name;
?>
</th>
<th><?php echo $fetch->purchase_price;  ?></th>
<th><?php echo $fetch->quantity;  ?></th>

</tr>
<?php  }  ?>
</tbody>
</table>
</div>

</div>
</div>
<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> 
		</div>
		<div class="col-md-6"> 
			<?php echo $pagination; ?>
		</div>
	</div>

</div>
<?php
$this->load->view("footer.php");
?>

</div>





<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'SPARE RETURN REPORT(<?php echo date('d-m-Y');?>).xls';
   
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


function ResetLead()
{
  location.href="<?=base_url('/report/Report/spare_return');?>";
}

</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
