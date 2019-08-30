<?php $this->load->view("header.php");?>

<!DOCTYPE HTML>
<html>
<head>

<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js">
</script>

<style type="text/css">
	.new-form{
		margin-bottom: 0px !important;
		border-bottom: 0px !important;
	}
	.new-form-default{
		margin-top: 75px !important;
    	margin-bottom: 0px !important;
    	border: 0px !important;
	}
</style>

</head>
<body>

<!-- ==============================chart======================================= -->

<?php  
$crYr=date('Y');
if($_GET['fyear'] != '')
{
  $myear=$_GET['fyear'];
}
else
{
  $myear=$crYr;
}

if($_GET['hyear'] != '')
{
  $byear=$_GET['hyear'];
}
else
{
  $byear=$crYr;
}

?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default new-form-default">
<div class="panel-body panel-center new-form">
 <form class="form-horizontal" method="get" action="">
    <div class="form-group panel-body-to">
       <label class="col-sm-2 control-label">Section</label> 
       <div class="col-sm-3">
          <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;">
             <option value="" class="listClass">------Section-----</option>
             <?php
                $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                foreach($sql->result() as $getSql) { ?>
             <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['m_type']) { ?> selected <?php } ?> ><?=$getSql->name?></option>
             <?php } ?>
          </select>
       </div>
        <label class="col-sm-2 control-label">Year</label> 
        <div class="col-sm-3">
          <select name="fyear" id="fyear" class="select2 form-control">
            <option value="">----Select Year----</option>
            <option value="2018" <?php if($_GET['fyear'] == '2018') { ?> selected <?php } ?> >2018</option>
            <option value="2019" <?php if($_GET['fyear'] == '2019') { ?> selected <?php } ?> >2019</option>
            <option value="2020" <?php if($_GET['fyear'] == '2020') { ?> selected <?php } ?> >2020</option>
            <option value="2021" <?php if($_GET['fyear'] == '2021') { ?> selected <?php } ?> >2021</option>
            <option value="2022" <?php if($_GET['fyear'] == '2022') { ?> selected <?php } ?> >2022</option>
            <option value="2023" <?php if($_GET['fyear'] == '2023') { ?> selected <?php } ?> >2023</option>
            <option value="2024" <?php if($_GET['fyear'] == '2024') { ?> selected <?php } ?> >2024</option>
            <option value="2025" <?php if($_GET['fyear'] == '2025') { ?> selected <?php } ?> >2025</option>
          </select>
        </div>
       <div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
          <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
          <button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
       </div>
    </div>
 </form>
<h4 style="margin: -10px 0px 0px 440px;font-weight: 200;font-size: x-large;">
	<?=$myear?>
</h4>
</div>
</div>
</div>
</div>

<?php
 if($_GET['filter']=='filter')
 {
    
    $query=("select * from tbl_software_cost_log where status='A'  ");
    
    if($_GET['m_type'] != '')
       $query.=" AND section_id='".$_GET['m_type']."' ";
  
    if($_GET['fyear'] != '')
       $query.=" AND EXTRACT(YEAR FROM log_date)='".$_GET['fyear']."'";

    $query .=" GROUP BY main_section ";

 }
 else
 {
   $query=("select * from tbl_software_cost_log where status='A' AND EXTRACT(YEAR FROM log_date)='$crYr' GROUP BY main_section ");  
 }
 
 $result=$this->db->query($query)->result();
 //echo date('m');
 foreach($result as $fetch) {

	$sec=$this->db->query("select * from tbl_category where id='$fetch->main_section'");
	$getSec=$sec->row(); 
	$sectionName=$getSec->name;

	$january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=01 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section'");    
	$getJanuaryData=$january->row();
	$januarySec=round($getJanuaryData->totalamt,2);

	$february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=02 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' ");   
	$getFebruaryData=$february->row();
	$februarySec=round($getFebruaryData->totalamt,2);

	$march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=03 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getMarchData=$march->row();
	$marchSec=round($getMarchData->totalamt,2);

	$april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=04 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getAprilData=$april->row();
	$aprilSec=round($getAprilData->totalamt,2); 

	$may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=05 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getMayData=$may->row();
	$maySec=round($getMayData->totalamt,2);

	$june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=06 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section'");    
	$getJuneData=$june->row();
	$juneSec=round($getJuneData->totalamt,2);

	$july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=07 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getJulyData=$july->row();
	$julySec=round($getJulyData->totalamt,2);

	$august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=08 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getAugustData=$august->row();
	$augustSec=round($getAugustData->totalamt,2);

	$september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=09 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getSeptemberData=$september->row();
	$septemberSec=round($getSeptemberData->totalamt,2);

	$october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=10 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getOctoberData=$october->row();
	$octoberSec=round($getOctoberData->totalamt,2);

	$novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=11 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getNovemberData=$novermber->row();
	$novemberSec=round($getNovemberData->totalamt,2);

	$december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=12 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
	$getDecemberData=$december->row();
	$decemberSec=round($getDecemberData->totalamt,2);

//==========================Bar Chart Calculation======================

$dJan=array(
	'y' => $januarySec,
	'label' => "January"
);

$dFeb=array(
	'y' => $februarySec,
	'label' => "February"
);

$dMarch=array(
	'y' => $marchSec,
	'label' => "March"
);

$dApril=array(
	'y' => $aprilSec,
	'label' => "April"
);

$dMay=array(
	'y' => $maySec,
	'label' => "May"
);

$dJune=array(
	'y' => $juneSec, 
	'label' => "June"
);

$dJuly=array(
	'y' => $julySec,
	'label' => "July"
);

$dAug=array(
	'y' => $augustSec,
	'label' => "August"
);

$dSep=array(
	'y' => $septemberSec,
	'label' => "September"
);

$dOct=array(
	'y' => $octoberSec,
	'label' => "October"
);

$dNov=array(
	'y' => $novemberSec,
	'label' => "November"
);

$dDec=array(
	'y' => $decemberSec,
	'label' => "December"
);



$dataAll=[$dJan,$dFeb,$dMarch,$dApril,$dMay,$dJune,$dJuly,$dAug,$dSep,$dOct,$dNov,$dDec];

$data=array(
	'name' => $sectionName,
	'dataPoints' => $dataAll
);

$datas[]=$data;


} ?>
 
<div id="chartContainer" style="height: 400px; width: 100%;"> </div>

<!-- ==============================chart1======================================= -->

<div class="row" style="margin-top: -70px;">
<div class="col-lg-12">
<div class="panel panel-default new-form-default">
<div class="panel-body panel-center new-form">
 <form class="form-horizontal" method="get" action="">
    <div class="form-group panel-body-to">
       <label class="col-sm-2 control-label">Section</label> 
       <div class="col-sm-3">
          <select name="s_type" class="select2 form-control" id="s_type" style="width:100%;">
             <option value="" class="listClass">------Section-----</option>
             <?php
                $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                foreach($sql->result() as $getSql) { ?>
             <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['s_type']) { ?> selected <?php } ?> ><?=$getSql->name?></option>
             <?php } ?>
          </select>
       </div>
        <label class="col-sm-2 control-label">&nbsp;</label> 
        <div class="col-sm-3"></div>
       <div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
          <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
          <button type="submit" class="btn btn-sm pull-right" name="filter1" value="filter1" ><span>Search</span>
       </div>
    </div>
 </form>
</h4>
</div>
</div>
</div>
</div>

<?php

if($_GET['filter1'] == 'filter1')
{

	$qry="select * from tbl_category where inside_cat='0' AND id='".$_GET['s_type']."'" ;
    
}
else
{
	$qry="select * from tbl_category where inside_cat='0'" ;
}

$data = $this->db->query($qry);
foreach($data->result() as $fetch) 
{

	$machine=$this->db->query("select COUNT(machine_name) as totalmachine from tbl_machine where m_type='$fetch->id' ");
	$getMachine=$machine->row();

	$section_name=$fetch->name;
	$machine_total=$getMachine->totalmachine;



$secData=array(

		'section' => $section_name,
		'mcount'=> $machine_total

	);

$macData[]=$secData;


}

?>

<div id="chartContainer1" style="height: 300px; width: 100%;"></div>


<!-- ==============================chart2======================================= -->

<div class="row" style="margin-top: -70px;">
<div class="col-lg-12">
<div class="panel panel-default new-form-default">
<div class="panel-body panel-center new-form">
 <form class="form-horizontal" method="get" action="">
    <div class="form-group panel-body-to">
       <label class="col-sm-2 control-label">Section</label> 
       <div class="col-sm-3">
          <select name="b_type" class="select2 form-control" id="b_type" style="width:100%;">
             <option value="" class="listClass">------Section-----</option>
             <?php
                $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                foreach($sql->result() as $getSql) { ?>
             <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['m_type']) { ?> selected <?php } ?> ><?=$getSql->name?></option>
             <?php } ?>
          </select>
       </div>
        <label class="col-sm-2 control-label">Year</label> 
        <div class="col-sm-3">
          <select name="hyear" id="hyear" class="select2 form-control">
            <option value="">----Select Year----</option>
            <option value="2018" <?php if($_GET['hyear'] == '2018') { ?> selected <?php } ?> >2018</option>
            <option value="2019" <?php if($_GET['hyear'] == '2019') { ?> selected <?php } ?> >2019</option>
            <option value="2020" <?php if($_GET['hyear'] == '2020') { ?> selected <?php } ?> >2020</option>
            <option value="2021" <?php if($_GET['hyear'] == '2021') { ?> selected <?php } ?> >2021</option>
            <option value="2022" <?php if($_GET['hyear'] == '2022') { ?> selected <?php } ?> >2022</option>
            <option value="2023" <?php if($_GET['hyear'] == '2023') { ?> selected <?php } ?> >2023</option>
            <option value="2024" <?php if($_GET['hyear'] == '2024') { ?> selected <?php } ?> >2024</option>
            <option value="2025" <?php if($_GET['hyear'] == '2025') { ?> selected <?php } ?> >2025</option>
          </select>
        </div>
       <div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
          <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
          <button type="submit" class="btn btn-sm pull-right" name="filter2" value="filter2" ><span>Search</span>
       </div>
    </div>
 </form>
<h4 style="margin: -10px 0px 0px 440px;font-weight: 200;font-size: x-large;">
	<?=$byear?>
</h4>
</div>
</div>
</div>
</div>

<?php

  if($_GET['filter2'] == 'filter2')
  {
    $query="select * from tbl_machine_breakdown where status='A' ";

    if($_GET['b_type'] != '')
      $query.=" AND section='".$_GET['b_type']."'";
    
    if($_GET['hyear'] != '')
      $query.=" AND EXTRACT(YEAR FROM breakdown_date)='".$_GET['hyear']."'";

    $query .=" GROUP BY section ";
  }
  else
  {
    $query=("select * from tbl_machine_breakdown where status='A' AND EXTRACT(YEAR FROM breakdown_date)='$crYr' GROUP BY section ");
  }
  
  $result=$this->db->query($query)->result();

  foreach($result as $fetch) 
  { 

	$sec=$this->db->query("select * from tbl_category where id='$fetch->section'");
    $getSec=$sec->row();
    $bsection=$getSec->name;

      $january=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=01 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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
      $janHours=$hours01.".".$mins01; 

      
      $february=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=02 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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
      
      $febHours=$hours02.".".$mins02;

  
      $march=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=03 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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

      $marchHours=$hours03.".".$mins03; 
		

	$april=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=04 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section' "); 
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

      $aprilHours=$hours4.".".$mins4;


      $may=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=05 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'"); 
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
        
      $mayHours=$hours5.".".$mins5;

      $june=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=06 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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
      
      $juneHours=$hours6.".".$mins6; 

      $july=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=07 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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
      
      $julyHours=$hours7.".".$mins7;

      $august=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=08 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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

      $augustHours=$hours8.".".$mins8;

      $september=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=09 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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

      $septHours=$hours9.".".$mins9;

      $october=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=10 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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

      $octHours=$hours10.".".$mins10;

      $november=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=11 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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

      $novHours=$hours11.".".$mins11;

      $december=$this->db->query("select * from tbl_machine_breakdown where EXTRACT(MONTH FROM breakdown_date)=12 AND EXTRACT(YEAR FROM breakdown_date)='$byear' AND section='$fetch->section'");
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

      $decHours=$hours12.".".$mins12;

//echo $hours7.".".$mins7 ."<br>";
//==========================Bar Chart Calculation======================

$bJan=array(
	'y' => $janHours,
	'label' => "January"
);

$bFeb=array(
	'y' => $febHours,
	'label' => "February"
);

$bMarch=array(
	'y' => $marchHours,
	'label' => "March"
);

$bApril=array(
	'y' => $aprilHours,
	'label' => "April"
);

$bMay=array(
	'y' => $mayHours,
	'label' => "May"
);

$bJune=array(
	'y' => $juneHours, 
	'label' => "June"
);

$bJuly=array(
	'y' => $julyHours,
	'label' => "July"
);

$bAug=array(
	'y' => $augustHours,
	'label' => "August"
);

$bSep=array(
	'y' => $septHours,
	'label' => "September"
);

$bOct=array(
	'y' => $octHours,
	'label' => "October"
);

$bNov=array(
	'y' => $novHours,
	'label' => "November"
);

$bDec=array(
	'y' => $decHours,
	'label' => "December"
);



$dataBreak=[$bJan,$bFeb,$bMarch,$bApril,$bMay,$bJune,$bJuly,$bAug,$bSep,$bOct,$bNov,$bDec];

$hoursData=array(
	'sectioname' => $bsection,
	'dataPoints' => $dataBreak
);

$breakData[]=$hoursData;

}
?>

<div id="chartContainer2" style="height: 300px; width: 100%;"></div>

</body>





<!-- ==============================chart======================================= -->
<script type="text/javascript">
	
	var options = {
	animationEnabled: true,
	title:{
		text: "Section Expenses of United Timber"   
	},
	axisY:{
		title:"Section (Expense In Rupees)"
	},
	toolTip: {
		shared: true,
		reversed: true
	},
	data: [
	<?php foreach ($datas as $key => $value) {
		$name=$value['name'];
		$data=$value['dataPoints'];
	 ?>
		{
			type: "stackedColumn",
			name: "<?=$name?>",
			showInLegend: "true",
			yValueFormatString: "#,##0 ",
			dataPoints: [<?php foreach ($data as $keyss => $get) { 
				$y=$get['y'];
				$label=$get['label'];
				?>
				{ 
					y: <?=$y?> , 
					label: "<?=$label?>" 
				},
			<?php } ?>]
		},
	<?php } ?>
	]
};

$("#chartContainer").CanvasJSChart(options);

</script>



<!-- ==============================chart1======================================= -->
<script type="text/javascript">

var options1 = {
	title: {
		text: "Section Total Machine"
	},
	data: [{
			type: "pie",
			startAngle: 45,
			showInLegend: "true",
			legendText: "{label}",
			indexLabel: "{label} ({y})",
			yValueFormatString:"#,##0.#"%"",
			dataPoints: [

				<?php 

					foreach ($macData as $sKey => $mValue) 
					{
						$section=$mValue['section'];
						$mtotal=$mValue['mcount'];
				?>
				
				{ label: "<?=$section?>", y: <?=$mtotal?> },

				<?php } ?>				 
			]
	}]
};
$("#chartContainer1").CanvasJSChart(options1);
</script>


<!-- ==============================chart2======================================= -->
<script type="text/javascript">
	
	var options2 = {
	animationEnabled: true,
	title:{
		text: "Section Machine Breakdown Hours"   
	},
	axisY:{
		title:"Section (Breakdown Hours)"
	},
	toolTip: {
		shared: true,
		reversed: true
	},
	data: [
	<?php foreach ($breakData as $key => $value) {
		$name1=$value['sectioname'];
		$data1=$value['dataPoints'];
	 ?>
		{
			type: "stackedColumn",
			name: "<?=$name1?>",
			showInLegend: "true",
			yValueFormatString: "#,##0 ",
			dataPoints: [<?php foreach ($data1 as $keyss => $get) { 
				$y=$get['y'];
				$label=$get['label'];
				?>
				{ 
					y: <?=$y?> , 
					label: "<?=$label?>" 
				},
			<?php } ?>]
		},
	<?php } ?>
	]
};

$("#chartContainer2").CanvasJSChart(options2);

</script>
<br>
<br>
</html>



<?php $this->load->view("footer.php");?>

<script>

   function ResetLead()
   {
     location.href="<?=base_url('/master/Item/dashboar');?>";
   }
   
</script>