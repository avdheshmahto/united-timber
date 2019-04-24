
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
<h4 class="panel-title">COMPARISON REPORT (APRIL 2019 - MARCH 2020)</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Section</label> 
<div class="col-sm-3"> 
<select name="m_type" required class="select2 form-control" id="m_type" style="width:100%;">
<option value="0" class="listClass">------Section-----</option>
<?php
foreach ($categorySelectbox as $key => $dt) { ?>
<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
<?php } ?>
</select>
</div>  

<label class="col-sm-2 control-label">Machine</label> 
<div class="col-sm-3"> 
<select name="machine" class="select2 form-control">
<option value="">----Machine----</option>
<?php $qry="select * from tbl_machine where status='A'";
$qryres=$this->db->query($qry)->result();
foreach($qryres as $res) { 
$fac=$this->db->query("select * from tbl_category where id='$res->m_type'");
$getFac=$fac->row(); ?>
<option value="<?=$res->id?>" <?php if($_GET['machine'] == $res->id) {?>selected <?php } ?>><?php echo $res->machine_name."(". $getFac->name.")"?></option> 
<?php } ?>
</select> 
</div>
<div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</div> 
</form>
</div>

<!-- <div class="row">
<div class="col-sm-12">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<a href="<?=base_url();?>report/Report/excel_productBincard?<?='temp_id='.$_GET['temp_id'].'&p_name='.'&f_date='.$_GET['f_date'].'&t_date='.$_GET['t_date'].'&filter='.$_GET['filter']?>" class="btn btn-sm" >Excel</a>

</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Show<label>
<select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/productBincard?<?='temp_id='.$_GET['temp_id'].'&p_name='.$_GET['p_name'].'&type_of_spare='.$_GET['type_of_spare'].'&sp_name='.$_GET['sp_name'].'&quantity='.$_GET['quantity'].'&grn_no='.$_GET['grn_no'].'&f_date='.$_GET['f_date'].'&t_date='.$_GET['t_date'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
</div> -->

<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>

		<th>Particulars</th>
		<th>April</th>
		<th>May</th>
    <th>June</th>
    <th>July</th>
    <th>August</th>
    <th>September</th>
    <th>October</th>
		<th>November</th>
		<th>December</th>
    <th>January</th>
    <th>February</th>
    <th>March</th>
		
</tr>
</thead>
<tbody id="getDataTable" >
<?php

$query=("select * from tbl_software_cost_log L,tbl_category C where L.section_id=C.id GROUP BY L.section_id ");
$result=$this->db->query($query)->result();
//echo date('m');
foreach($result as $fetch) { ?>

<tr class="gradeC record">

    <th><?php 
    if($fetch->inside_cat == 0){
      $sec=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $getSec=$sec->row(); ?>
    <a target="_blank" href="<?=base_url('report/Report/comparison_details_report?id=')?><?=$fetch->section_id?>"> <?php echo $getSec->name;?> </a> <?php
    }else{
      $sec=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
      $getSec=$sec->row();
    
      $sxc=$this->db->query("select * from tbl_category where id='$getSec->inside_cat'");
      $getSxc=$sxc->row(); ?>
      <a target="_blank" href="<?=base_url('report/Report/comparison_details_report?id=')?><?=$fetch->section_id?>"><?php echo $getSxc->name; ?> </a> <?php
      
    }     
    ?>      
    </th>

    <th>
    <?php 

    if($fetch->inside_cat == 0){
      $april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=04 AND section_id='$fetch->section_id' "); 
   
    $getAprilData=$april->row();
    echo $getAprilData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=04 AND section_id IN ($sec_id) "); 
   
    $getAprilData=$april->row();
    echo $getAprilData->totalamt;  
    
    } ?>
    
    </th>
   
    <th>      
    <?php 

    if($fetch->inside_cat == 0){
      $may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=05 AND section_id='$fetch->section_id' "); 
   
    $getMayData=$may->row();
    echo $getMayData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=05 AND section_id IN ($sec_id) "); 
   
    $getMayData=$may->row();
    echo $getMayData->totalamt;  
    
    } ?>
    
    </th>
    
    <th>
    <?php 

    if($fetch->inside_cat == 0){
      $june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=06 AND section_id='$fetch->section_id' "); 
   
    $getJuneData=$june->row();
    echo $getJuneData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=06 AND section_id IN ($sec_id) "); 
   
    $getJuneData=$june->row();
    echo $getJuneData->totalamt;  
    
    } ?>
    

    </th>


    <th>

    <?php 

    if($fetch->inside_cat == 0){
      $july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=07 AND section_id='$fetch->section_id' "); 
   
    $getJulyData=$july->row();
    echo $getJulyData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=07 AND section_id IN ($sec_id) "); 
   
    $getJulyData=$july->row();
    echo $getJulyData->totalamt;  
    
    } ?>
              
    </th>

    <th>
      
    <?php 

    if($fetch->inside_cat == 0){
      $august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=08 AND section_id='$fetch->section_id' "); 
   
    $getAugustData=$august->row();
    echo $getAugustData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=08 AND section_id IN ($sec_id) "); 
   
    $getAugustData=$august->row();
    echo $getAugustData->totalamt;  
    
    } ?>
              
    </th>
    
    <th>
    
    <?php 

    if($fetch->inside_cat == 0){
      $september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=09 AND section_id='$fetch->section_id' "); 
   
    $getSeptemberData=$september->row();
    echo $getSeptemberData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=09 AND section_id IN ($sec_id) "); 
   
    $getSeptemberData=$september->row();
    echo $getSeptemberData->totalamt;  
    
    } ?>
    
    </th>
    

    <th>
    
    <?php 

    if($fetch->inside_cat == 0){
      $october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=10 AND section_id='$fetch->section_id' "); 
   
    $getOctoberData=$october->row();
    echo $getOctoberData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=10 AND section_id IN ($sec_id) "); 
   
    $getOctoberData=$october->row();
    echo $getOctoberData->totalamt;  
    
    } ?>
    
    </th>


    <th>    

    <?php 

    if($fetch->inside_cat == 0){
      $novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=11 AND section_id='$fetch->section_id' "); 
   
    $getNovemberData=$novermber->row();
    echo $getNovemberData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=11 AND section_id IN ($sec_id) "); 
   
    $getNovemberData=$novermber->row();
    echo $getNovemberData->totalamt;  
    
    } ?>
                  
    </th>

    <th>
            
    <?php 

    if($fetch->inside_cat == 0){
      $december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=12 AND section_id='$fetch->section_id' "); 
   
    $getDecemberData=$december->row();
    echo $getDecemberData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=12 AND section_id IN ($sec_id) "); 
   
    $getDecemberData=$december->row();
    echo $getDecemberData->totalamt;  
    
    } ?>
                  
    </th>

    <th>        
    <?php 

    if($fetch->inside_cat == 0){
      $january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=01 AND section_id='$fetch->section_id' "); 
   
    $getJanuaryData=$january->row();
    echo $getJanuaryData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=01 AND section_id IN ($sec_id) "); 
   
    $getJanuaryData=$january->row();
    echo $getJanuaryData->totalamt;  
    
    } ?>
    
    </th>
    
    <th>
            
    <?php 

    if($fetch->inside_cat == 0){
      $february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=02 AND section_id='$fetch->section_id' "); 
   
    $getFebruaryData=$february->row();
    echo $getFebruaryData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=02 AND section_id IN ($sec_id) "); 
   
    $getFebruaryData=$february->row();
    echo $getFebruaryData->totalamt;  
    
    } ?>
    
    </th>
    
    <th>

    <?php 

    if($fetch->inside_cat == 0){
      $march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=03 AND section_id='$fetch->section_id' "); 
   
    $getMarchData=$march->row();
    echo $getMarchData->totalamt;

    }else{


    $chkCtg=$this->db->query("select * from tbl_category where id='$fetch->section_id' ");
    $count=$chkCtg->result_array();
    $s_id=array();
    foreach ($chkCtg->result() as $value) {

      array_push($s_id,$value->inside_cat);
      
    }

    if(sizeof($count) > 0)
    {
      $sec_id=implode(',', $s_id);
      $sec_id=$sec_id.",".$fetch->section_id;
    }
    else
    {
      $sec_id='99999999';
    }

    //echo $sec_id;
    $march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM maker_date)=03 AND section_id IN ($sec_id) "); 
   
    $getMarchData=$march->row();
    echo $getMarchData->totalamt;  
    
    } ?>
                  
    </th>

</tr>
<?php 

$totalcost_april     =$totalcost_april + $getAprilData->totalamt;
$totalcost_may       =$totalcost_may + $getMayData->totalamt;
$totalcost_june      =$totalcost_june + $getJuneData->totalamt;
$totalcost_july      =$totalcost_july + $getJulyData->totalamt;
$totalcost_august    =$totalcost_august + $getAugustData->totalamt;
$totalcost_september =$totalcost_september + $getSeptemberData->totalamt;
$totalcost_october   =$totalcost_october + $getOctoberData->totalamt;
$totalcost_november  =$totalcost_november + $getNovemberData->totalamt;
$totalcost_december  =$totalcost_december + $getDecemberData->totalamt;
$totalcost_january   =$totalcost_january + $getJanuaryData->totalamt;
$totalcost_february  =$totalcost_february + $getFebruaryData->totalamt;
$totalcost_march     =$totalcost_march + $getMarchData->totalamt;


 }  ?>

<tr class="gradeC record">

    <th>Totals</th>
    <th><?php echo $totalcost_april; ?> </th>
    <th><?php echo $totalcost_may; ?></th>
    <th><?php echo $totalcost_june; ?></th>
    <th><?php echo $totalcost_july; ?></th>
    <th><?php echo $totalcost_august; ?></th>
    <th><?php echo $totalcost_september; ?></th>
    <th><?php echo $totalcost_october; ?></th>
    <th><?php echo $totalcost_november; ?></th>
    <th><?php echo $totalcost_december; ?></th>
    <th><?php echo $totalcost_january; ?></th>
    <th><?php echo $totalcost_february; ?></th>
    <th><?php echo $totalcost_march; ?></th>

</tr>

</tbody>
</table>
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
   filename = filename?filename+'.xls':'Product Bin Card Report<?php echo date('d-m-Y');?>.xls';
   
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
  location.href="<?=base_url('/report/Report/comparison_report');?>";
}

</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
