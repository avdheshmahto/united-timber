
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
<h4 class="panel-title">BREAKDOWN HOURS REPORT (APRIL 2019 - MARCH 2020)</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Section</label> 
<div class="col-sm-3"> 
<select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);" required="">
<option value="0" class="listClass">------Section-----</option>
<?php
$sql=$this->db->query("select * from tbl_category where inside_cat='0'");
foreach($sql->result() as $getSql) { 
//foreach ($categorySelectbox as $key => $dt) { ?>
<!-- <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option> -->
<option value="<?=$getSql->id?>"><?=$getSql->name?></option>
<?php } ?>
</select>
</div>  

<label class="col-sm-2 control-label" style="display: none;">Machine</label> 
<div class="col-sm-3" style="display: none;"> 
<select name="machineid" id="machineid" class="select2 form-control">
<option value="">----Machine----</option>
<?php 
// $qry="select * from tbl_machine where status='A'";
// $qryres=$this->db->query($qry)->result();
// foreach($qryres as $res) { 
// $fac=$this->db->query("select * from tbl_category where id='$res->m_type'");
// $getFac=$fac->row(); ?>
<!-- <option value="<?=$res->id?>" <?php if($_GET['machine'] == $res->id) {?>selected <?php } ?>><?php echo $res->machine_name."(". $getFac->name.")"?></option>  -->
<?php //} ?>
</select> 
</div>
<div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</div> 
</form>
</div>
                                                                                            
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
if($_GET['filter'] == 'filter')
{
  $query=("select * from tbl_machine_breakdown where status='A' AND section='".$_GET['m_type']."' GROUP BY section ");
}
else
{
  $query=("select * from tbl_machine_breakdown where status='A' GROUP BY section ");
}

$result=$this->db->query($query)->result();
foreach($result as $fetch) { ?>

<tr class="gradeC record">
    
    <th>
        <?php $sec=$this->db->query("select * from tbl_category where id='$fetch->section'");
        $getSec=$sec->row(); ?>
        <a target="_blank" href="<?=base_url('report/Report/breakdown_hours_details?id=')?><?=$fetch->section?>"> <?php echo $getSec->name;?> </a>
    </th>
    
    <th>
        <?php $april=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=04 AND section='$fetch->section' "); 
        $diff4='';
        foreach($april->result() as $getAprilData)
        {
        	$from_time4 = strtotime($getAprilData->start_time);
        	$to_time4 = strtotime($getAprilData->end_time);	
        	$delta_4 = ($to_time4 - $from_time4);
			$diff4=$diff4 + $delta_4;
        }

        $tmins4 = $diff4/60;
  		$hours4 = floor($tmins4/60);
  		$mins4 = $tmins4%60;
  		echo "<b>$hours4</b> Hours | <b>$mins4</b> Minutes</b>";
       
        ?>
    </th>
    
    <th>
        <?php
        $may=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=05 AND section='$fetch->section'"); 
        $diff5='';
        foreach($may->result() as $getMayData)
        {
        	$from_time5 = strtotime($getMayData->start_time);
        	$to_time5 = strtotime($getMayData->end_time);	
        	$delta_5 = ($to_time5 - $from_time5);
			$diff5=$diff5 + $delta_5;
        }

        $tmins5 = $diff5/60;
  		$hours5 = floor($tmins5/60);
  		$mins5 = $tmins5%60;
  		echo "<b>$hours5</b> Hours | <b>$mins5</b> Minutes</b>";
        ?>
    </th>

    <th>
        <?php
        $june=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=06 AND section='$fetch->section'");
        $diff6='';    
        foreach($june->result() as $getJuneData)
        {
        	$from_time6 = strtotime($getJuneData->start_time);
        	$to_time6 = strtotime($getJuneData->end_time);	
        	$delta_6 = ($to_time6 - $from_time6);
			$diff6=$diff6 + $delta_6;
        }

        $tmins6 = $diff6/60;
  		$hours6 = floor($tmins6/60);
  		$mins6 = $tmins6%60;
  		echo "<b>$hours6</b> Hours | <b>$mins6</b> Minutes</b>";
        ?>
    </th>

    <th>
        <?php
        $july=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=07 AND section='$fetch->section'");
        $diff7='';    
        foreach($july->result() as $getJulyData)
        {
        	$from_time7 = strtotime($getJulyData->start_time);
        	$to_time7 = strtotime($getJulyData->end_time);	
        	$delta_7 = ($to_time7 - $from_time7);
			$diff7=$diff7 + $delta_7;
        }

        $tmins7 = $diff7/60;
  		$hours7 = floor($tmins7/60);
  		$mins7 = $tmins7%60;
  		echo "<b>$hours7</b> Hours | <b>$mins7</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $august=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=08 AND section='$fetch->section'");
        $diff8='';    
        foreach($august->result() as $getAugustData)
        {
        	$from_time8 = strtotime($getAugustData->start_time);
        	$to_time8 = strtotime($getAugustData->end_time);	
        	$delta_8 = ($to_time8 - $from_time8);
			$diff8=$diff8 + $delta_8;
        }

        $tmins8 = $diff8/60;
  		$hours8 = floor($tmins8/60);
  		$mins8 = $tmins8%60;
  		echo "<b>$hours8</b> Hours | <b>$mins8</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $september=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=09 AND section='$fetch->section'");
        $diff9='';    
        foreach($september->result() as $getSeptemberData)
        {
        	$from_time9 = strtotime($getSeptemberData->start_time);
        	$to_time9 = strtotime($getSeptemberData->end_time);	
        	$delta_9 = ($to_time9 - $from_time9);
			$diff9=$diff9 + $delta_9;
        }

        $tmins9 = $diff9/60;
  		$hours9 = floor($tmins9/60);
  		$mins9 = $tmins9%60;
  		echo "<b>$hours9</b> Hours | <b>$mins9</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $october=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=10 AND section='$fetch->section'");
        $diff10='';    
        foreach($october->result() as $getOctoberData)
        {
        	$from_time10 = strtotime($getOctoberData->start_time);
        	$to_time10 = strtotime($getOctoberData->end_time);	
        	$delta_10 = ($to_time10 - $from_time10);
			$diff10=$diff10 + $delta_10;
        }

        $tmins10 = $diff10/60;
  		$hours10 = floor($tmins10/60);
  		$mins10 = $tmins10%60;
  		echo "<b>$hours10</b> Hours | <b>$mins10</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $november=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=11 AND section='$fetch->section'");
        $diff11='';    
        foreach($november->result() as $getNovemberData)
        {
        	$from_time11 = strtotime($getNovemberData->start_time);
        	$to_time11 = strtotime($getNovemberData->end_time);	
        	$delta_11 = ($to_time11 - $from_time11);
			$diff11=$diff11 + $delta_11;
        }

        $tmins11 = $diff11/60;
  		$hours11 = floor($tmins11/60);
  		$mins11 = $tmins11%60;
  		echo "<b>$hours11</b> Hours | <b>$mins11</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $december=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=12 AND section='$fetch->section'");
        $diff12='';    
        foreach($december->result() as $getDecemberData)
        {
        	$from_time12 = strtotime($getDecemberData->start_time);
        	$to_time12 = strtotime($getDecemberData->end_time);	
        	$delta_12 = ($to_time12 - $from_time12);
			$diff12=$diff12 + $delta_12;
        }

        $tmins12 = $diff12/60;
  		$hours12 = floor($tmins12/60);
  		$mins12 = $tmins12%60;
  		echo "<b>$hours12</b> Hours | <b>$mins12</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $january=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=01 AND section='$fetch->section'");
        $diff01='';    
        foreach($january->result() as $getJanuaryData)
        {
        	$from_time01 = strtotime($getJanuaryData->start_time);
        	$to_time01 = strtotime($getJanuaryData->end_time);	
        	$delta_01 = ($to_time01 - $from_time01);
			$diff01=$diff01 + $delta_01;
        }

        $tmins01 = $diff01/60;
  		$hours01 = floor($tmins01/60);
  		$mins01 = $tmins01%60;
  		echo "<b>$hours01</b> Hours | <b>$mins01</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $february=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=02 AND section='$fetch->section'");
        $diff02='';    
        foreach($february->result() as $getFebruaryData)
        {
        	$from_time02 = strtotime($getFebruaryData->start_time);
        	$to_time02 = strtotime($getFebruaryData->end_time);	
        	$delta_02 = ($to_time02 - $from_time02);
			$diff02=$diff02 + $delta_02;
        }

        $tmins02 = $diff02/60;
  		$hours02 = floor($tmins02/60);
  		$mins02 = $tmins02%60;
  		echo "<b>$hours02</b> Hours | <b>$mins02</b> Minutes</b>";
        ?>    	
    </th>

    <th>    	
        <?php
        $march=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=03 AND section='$fetch->section'");
        $diff03='';    
        foreach($march->result() as $getMarchData)
        {
        	$from_time03 = strtotime($getMarchData->start_time);
        	$to_time03 = strtotime($getMarchData->end_time);	
        	$delta_03 = ($to_time03 - $from_time03);
			$diff03=$diff03 + $delta_03;
        }

        $tmins03 = $diff03/60;
  		$hours03 = floor($tmins03/60);
  		$mins03 = $tmins03%60;
  		echo "<b>$hours03</b> Hours | <b>$mins03</b> Minutes</b>";
        ?>    	
    </th>

</tr>
<?php }  ?>


</tbody>
</table>
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
  location.href="<?=base_url('/report/Report/breakdown_hours_report');?>";
}

</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>


<script type="text/javascript">
function getmachinelist(v)
{

  ur="<?=base_url();?>report/Report/get_machine_list";
  //alert(v);
  $.ajax({

      url   : ur,
      type  : "POST",
      data  : {'mid':v},
      success:function(data)
      {

        //alert(data);
        if(data != '')
        {
          $("#machineid").empty().append(data);
        }
      }
  })

}
</script>