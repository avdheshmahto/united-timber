<?php $this->load->view("header.php");?>

<!DOCTYPE HTML>
<html>
<head>

<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>

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

<!-- ==============================chart1======================================= -->

<?php  
  
  $crYr=date('Y');
  $myear=date('Y');

?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default new-form-default">
<div class="panel-body panel-center new-form">
 <form class="form-horizontal sectionexpense" method="get" action="">
    <div class="form-group panel-body-to">
       <label class="col-sm-2 control-label">Section</label> 
       <div class="col-sm-3">
          <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;">
             <option value="" class="listClass">All Section</option>
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
            <option value="2018" <?php if(date('Y')==2018) { ?> selected <?php } ?> >2018</option>
            <option value="2019" <?php if(date('Y')==2019) { ?> selected <?php } ?> >2019</option>
            <option value="2020" <?php if(date('Y')==2020) { ?> selected <?php } ?> >2020</option>
            <option value="2021" <?php if(date('Y')==2021) { ?> selected <?php } ?> >2021</option>
            <option value="2022" <?php if(date('Y')==2022) { ?> selected <?php } ?> >2022</option>
            <option value="2023" <?php if(date('Y')==2023) { ?> selected <?php } ?> >2023</option>
            <option value="2024" <?php if(date('Y')==2024) { ?> selected <?php } ?> >2024</option>
            <option value="2025" <?php if(date('Y')==2025) { ?> selected <?php } ?> >2025</option>
          </select>
        </div>
    </div>
 </form>
</div>
</div>
</div>
</div>

<?php
 
  $query=("select * from tbl_software_cost_log where status='A' AND EXTRACT(YEAR FROM log_date)='$crYr' GROUP BY main_section ");  

 
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
 
<div id="chartContainer1" style="height: 400px; width: 100%;"> </div>

<script type="text/javascript">
  
  var options1 = {
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

$("#chartContainer1").CanvasJSChart(options1);

</script>

<!-- ==============================chart4======================================= -->

<?php 
  
  $secIds=1;

?>
<div class="row" style="margin-top: -70px;">
  <div class="col-lg-12">
    <div class="panel panel-default new-form-default">
      <div class="panel-body panel-center new-form">
        <form class="form-horizontal machine_expense" method="get" action="">
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">Section</label> 
            <div class="col-sm-3">
              <select name="sec_id" class="select2 form-control" id="sec_id" style="width:100%;" onchange="getmachinelist(this.value);">
                <option value="1" class="listClass">FINISHING SECTION</option>
                <?php
                  $sql=$this->db->query("select * from tbl_category where inside_cat='0' AND id != 1 ");
                  foreach($sql->result() as $getSql) {  ?>
                <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['sec_id'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">Machine</label> 
            <div class="col-sm-3">
              <select name="machineid" id="machineid" class="select2 form-control">
                <option value="">All Machine</option>
              </select>
            </div>
          </div>
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">From Date</label> 
            <div class="col-sm-3">
              <input type="date" name="from_date" id='from_date' class="form-control"> 
            </div>
            <label class="col-sm-2 control-label">To Date</label> 
            <div class="col-sm-3">
              <input type="date" name="to_date" id='to_date' class="form-control"> 
            </div>
          </div>                    
        </form>
      </div>
    </div>
  </div>
</div>

<?php 
  
  if($_GET['filter4'] == 'filter4')
  {
    $qry ="select * from tbl_machine where status='A' ";

    if($_GET['sec_id'] != '')
      $qry .=" AND m_type='".$_GET['sec_id']."' ";

    if($_GET['machineid'] != '')
      $qry .=" AND id='".$_GET['machineid']."' ";

    $machine=$this->db->query($qry);
  }
  else
  {
    $machine=$this->db->query("select * from tbl_machine where m_type='$secIds' "); 
  }
  
    foreach($machine->result() as $fetch_list) 
    { 


      $machineName=$fetch_list->machine_name;

      if($_GET['filter4'] == 'filter4' && $_GET['from_date'] != '' && $_GET['to_date'] != '')
      {
        $spent=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where machine_id='$fetch_list->id' AND log_date >='".$_GET['from_date']."' and log_date <='".$_GET['to_date']."' "); 
      }
      else
      {
        $spent=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(YEAR FROM log_date)='$crYr' AND machine_id='$fetch_list->id' "); 
      }

      $totalSpent=$spent->row();

      if($totalSpent->totalamt != '')
      {
        $macSpent=round($totalSpent->totalamt,2);
      }
      else
      {
        $macSpent=0;
      }

      $machData=array(

        'machin' => $machineName,
        'tspent'=> $macSpent

      );

      $machineSpent[]=$machData;

  
    }  ?>

<div id="chartContainer4" style="height: 300px; width: 100%;"></div>

<script type="text/javascript">
  
  var options4 = {
  title: {
    text: "Machine Total Expenses"
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

          foreach ($machineSpent as $sKey => $mValue) 
          {
            $machine=$mValue['machin'];
            $mspent=$mValue['tspent'];
        ?>
        
        { label: "<?=$machine?>", y: <?=$mspent?> },

        <?php } ?>         
      ]
  }]
};

$("#chartContainer4").CanvasJSChart(options4);

</script>

<!-- ==============================chart5======================================= -->

<?php 
  
  $typeSecIds=1;

?>
<div class="row" style="margin-top: -70px;">
  <div class="col-lg-12">
    <div class="panel panel-default new-form-default">
      <div class="panel-body panel-center new-form">
        <form class="form-horizontal type_expense" method="get" action="">
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">Section</label> 
            <div class="col-sm-3">
              <select name="typeSec_id" class="select2 form-control" id="typeSec_id" style="width:100%;" onchange="setMachinelist(this.value);">
                <option value="1" class="listClass">FINISHING SECTION</option>
                <?php
                  $sql=$this->db->query("select * from tbl_category where inside_cat='0' AND id != 1 ");
                  foreach($sql->result() as $getSql) {  ?>
                <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['typeSec_id'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">Machine</label> 
            <div class="col-sm-3">
              <select name="typemachine" id="typemachine" class="select2 form-control">
                <option value="">All Machine</option>
              </select>
            </div>
          </div>
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">From Date</label> 
            <div class="col-sm-3">
              <input type="date" name="from_date1" id='from_date1' class="form-control"> 
            </div>
            <label class="col-sm-2 control-label">To Date</label> 
            <div class="col-sm-3">
              <input type="date" name="to_date1" id='to_date1' class="form-control"> 
            </div>
          </div>                             
        </form>
      </div>
    </div>
  </div>
</div>

<?php 

    $typeQuery=$this->db->query("select * from tbl_master_data where param_id='26' "); 
  
    foreach($typeQuery->result() as $fetch_list) 
    { 

      $prd=$this->db->query("select * from tbl_product_stock where type_of_spare='$fetch_list->serial_number' ");
      foreach($prd->result() as $getPrd)
      {
        $prds[]=$getPrd->Product_id;
      }

      if($prds != '')
      {
        $prdIDs=implode(',', $prds);
      }
      else
      {
        $prdIDs="99999999";
      }

      $qry="select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(YEAR FROM log_date)='$crYr' AND main_section='$typeSecIds' AND product_id IN ($prdIDs) ";               
      $spent=$this->db->query($qry);
      $totalSpent=$spent->row();

      $type=$fetch_list->keyvalue;
      
      if($totalSpent->totalamt != '')
      {
        $macSpent=round($totalSpent->totalamt,2);
      }
      else
      {
        $macSpent=0;
      }

      $machData=array(

        'stype' => $type,
        'tspents'=> $macSpent

      );

      $typeSpent[]=$machData;

      unset($prds);
      
    }  ?>

<div id="chartContainer5" style="height: 300px; width: 100%;"></div>

<script type="text/javascript">
  
  var options5 = {
  title: {
    text: "Type Wise Total Expenses"
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

          foreach ($typeSpent as $sKey => $mValue) 
          {
            $type=$mValue['stype'];
            $tspent1=$mValue['tspents'];
        ?>
        
        { label: "<?=$type?>", y: <?=$tspent1?> },

        <?php } ?>         
      ]
  }]
};

$("#chartContainer5").CanvasJSChart(options5);

</script>

<!-- ==============================chart6======================================= -->

<?php 
  
  $spSecId=1;

?>
<div class="row" style="margin-top: -70px;">
  <div class="col-lg-12">
    <div class="panel panel-default new-form-default">
      <div class="panel-body panel-center new-form">
        <form class="form-horizontal spare_expense" method="get" action="">
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">Section</label> 
            <div class="col-sm-3">
              <select name="spareSec_id" class="select2 form-control" id="spareSec_id" style="width:100%;" onchange="putMachineList(this.value);">
                <option value="1" class="listClass">FINISHING SECTION</option>
                <?php
                  $sql=$this->db->query("select * from tbl_category where inside_cat='0' AND id != 1 ");
                  foreach($sql->result() as $getSql) {  ?>
                <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['spareSec_id'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">Machine</label> 
            <div class="col-sm-3">
              <select name="mid" class="select2 form-control" id="mid" style="width:100%;">
                <option value="" class="listClass">All Machine</option>                
              </select>
            </div>
          </div>
          <div class="form-group panel-body-to">            
            <label class="col-sm-2 control-label">Type Of Spare</label> 
            <div class="col-sm-3">
              <select name="spare_type" id="spare_type" class="select2 form-control">
                <option value="">All Type</option>
                <?php
                  $sql=$this->db->query("select * from tbl_master_data where param_id='26'");
                  foreach($sql->result() as $getSql) {  ?>
                  <option value="<?=$getSql->serial_number?>" <?php if($getSql->serial_number == $_GET['spare_type'] ) { ?> selected <?php } ?> ><?=$getSql->keyvalue?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">From Date</label> 
            <div class="col-sm-3">
              <input type="date" name="from_date3" id='from_date3' class="form-control"> 
            </div>
            <label class="col-sm-2 control-label">To Date</label> 
            <div class="col-sm-3">
              <input type="date" name="to_date3" id='to_date3' class="form-control"> 
            </div>
          </div>                    
        </form>
      </div>
    </div>
  </div>
</div>

<?php

    $qry="select * from tbl_software_cost_log where main_section='$spSecId' group by product_id";
    $ssftCstLog=$this->db->query($qry);

    foreach($ssftCstLog->result() as $getCostLog)
    {
      $prd_id[]=$getCostLog->product_id;
    }

    if($prd_id != '')
    {
      $prdID=implode(",", $prd_id);
    }
    else
    {
      $prdID='9999999999';
    }

  $prdName=$this->db->query("select * from tbl_software_cost_log where machine_id !='' AND product_id IN ($prdID) group by product_id");
  foreach($prdName->result() as $fetch_list) 
  { 

    $slog=$this->db->query("select *,SUM(qty) as totalQty,SUM(total_spent) as spareAmt from tbl_software_cost_log where product_id='$fetch_list->product_id' AND main_section='$spSecId' ");
    $getLogQty=$slog->row();

    $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->product_id'");
    $getPrd=$prd->row();

    $prdnames=$getPrd->productname;
    $prdQtyss=$getLogQty->totalQty;
  

     $spTypeData=array(

        'spname' => $prdnames,
        'spqtys' => $prdQtyss

      );

      $spareData[]=$spTypeData;

  }

?>

<div id="chartContainer6" style="height: 300px; width: 100%;"></div>

<script type="text/javascript">
  
  var options6 = {
  title: {
    text: "Total Spare Consume"
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

          foreach ($spareData as $sKey => $mValue) 
          {
            $sparenm=$mValue['spname'];
            $spareQt=$mValue['spqtys'];
        ?>
        
        { label: "<?=$sparenm?>", y: <?=$spareQt?> },

        <?php } ?>         
      ]
  }]
};

$("#chartContainer6").CanvasJSChart(options6);

</script>

<!-- ==============================chart3======================================= -->

<?php

  $byear=date('Y');

?>
<div class="row" style="margin-top: -70px;">
<div class="col-lg-12">
<div class="panel panel-default new-form-default">
<div class="panel-body panel-center new-form">
 <form class="form-horizontal breakdown_hours" method="get" action="">
    <div class="form-group panel-body-to">
       <label class="col-sm-2 control-label">Section</label> 
       <div class="col-sm-3">
          <select name="b_type" class="select2 form-control" id="b_type" style="width:100%;">
             <option value="" class="listClass">All Section</option>
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
            <option value="2018" <?php if(date('Y') == '2018') { ?> selected <?php } ?> >2018</option>
            <option value="2019" <?php if(date('Y') == '2019') { ?> selected <?php } ?> >2019</option>
            <option value="2020" <?php if(date('Y') == '2020') { ?> selected <?php } ?> >2020</option>
            <option value="2021" <?php if(date('Y') == '2021') { ?> selected <?php } ?> >2021</option>
            <option value="2022" <?php if(date('Y') == '2022') { ?> selected <?php } ?> >2022</option>
            <option value="2023" <?php if(date('Y') == '2023') { ?> selected <?php } ?> >2023</option>
            <option value="2024" <?php if(date('Y') == '2024') { ?> selected <?php } ?> >2024</option>
            <option value="2025" <?php if(date('Y') == '2025') { ?> selected <?php } ?> >2025</option>
          </select>
        </div>
    </div>
 </form>
</div>
</div>
</div>
</div>

<?php

  $query=("select * from tbl_machine_breakdown where status='A' AND EXTRACT(YEAR FROM breakdown_date)='$crYr' GROUP BY section ");

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
        $diff01=(int)$diff01 + (int)$delta_01;
      }
      
      $tmins01 = (int)$diff01/60;
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
      $diff02=(int)$diff02 + (int)$delta_02;
      }
      
      $tmins02 = (int)$diff02/60;
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
        $diff03=(int)$diff03 + (int)$delta_03;
      }
      
      $tmins03 = (int)$diff03/60;
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
        $diff4=(int)$diff4 + (int)$delta_4;
      }
      
      $tmins4 = (int)$diff4/60;
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
        $diff5=(int)$diff5 + (int)$delta_5;
      }
      
      $tmins5 = (int)$diff5/60;
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
        $diff6=(int)$diff6 + (int)$delta_6;
      }
      
      $tmins6 = (int)$diff6/60;
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
        $diff7=(int)$diff7 + (int)$delta_7;
      }
      
      $tmins7 = (int)$diff7/60;
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
        $diff8=(int)$diff8 + (int)$delta_8;
      }
      
      $tmins8 = (int)$diff8/60;
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
        $diff9=(int)$diff9 + (int)$delta_9;
      }
      
      $tmins9 = (int)$diff9/60;
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
        $diff10=(int)$diff10 + (int)$delta_10;
      }
      
      $tmins10 = (int)$diff10/60;
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
        $diff11=(int)$diff11 + (int)$delta_11;
      }
      
      $tmins11 = (int)$diff11/60;
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
        $diff12=(int)$diff12 + (int)$delta_12;
      }
      
      $tmins12 = (int)$diff12/60;
      $hours12 = floor($tmins12/60);
      $mins12 = $tmins12%60;

      $decHours=$hours12.".".$mins12;

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

<div id="chartContainer3" style="height: 300px; width: 100%;"></div>

<script type="text/javascript">
  
  var options3 = {
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

$("#chartContainer3").CanvasJSChart(options3);

</script>


<!-- ===============================chart7===================== -->

<?php 

  $bsecIds=1;
  $wyear=date('Y');

?>
<div class="row" style="margin-top: -70px;">
  <div class="col-lg-12">
    <div class="panel panel-default new-form-default">
      <div class="panel-body panel-center new-form">
        <form class="form-horizontal spares_hours" method="get" action="">
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">Section</label> 
            <div class="col-sm-3">
              <select name="bsec_id" class="select2 form-control" id="bsec_id" style="width:100%;" onchange="show_machineList(this.value);">
                <option value="1" class="listClass">FINISHING SECTION</option>
                <?php
                  $sql=$this->db->query("select * from tbl_category where inside_cat='0' AND id != 1 ");
                  foreach($sql->result() as $getSql) {  ?>
                <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['bsec_id'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">Machine</label> 
            <div class="col-sm-3">
              <select name="bmachineid" id="bmachineid" class="select2 form-control">
                <option value="">All Machine</option>
              </select>
            </div>
          </div>
          <div class="form-group panel-body-to">
            <label class="col-sm-2 control-label">From Date</label> 
            <div class="col-sm-3">
              <input type="date" name="from_date7" id='from_date7' class="form-control"> 
            </div>
            <label class="col-sm-2 control-label">To Date</label> 
            <div class="col-sm-3">
              <input type="date" name="to_date7" id='to_date7' class="form-control"> 
            </div>
          </div>                    
        </form>
      </div>
    </div>
  </div>
</div>

<?php 
 
  $query=$this->db->query("select * from tbl_machine_breakdown where start_time !='' AND end_time !='' AND section='$bsecIds' AND EXTRACT(YEAR FROM maker_date)='$wyear' ");

  foreach($query->result() as $getWo)
  {
  
      $wm=$this->db->query("select * from tbl_workorder_spare_hdr where work_order_id='$getWo->workorder_id'");
      $getWm=$wm->row();
      $sqlunit=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='".$getWm->spare_hdr_id."'");
      $compRow = $sqlunit->row();
      $prd=$this->db->query("select * from tbl_product_stock where Product_id='$compRow->spare_id' ");
      $getPrd=$prd->row();

      $Product_Name=$getPrd->productname;

      $from_time5 = strtotime($getWo->start_time);
      $to_time5 = strtotime($getWo->end_time); 
      $delta_5 = (int)$to_time5 - (int)$from_time5;
      $diff5=$delta_5;
      
      $tmins5 = (int)$diff5/60;
      $hours5 = floor($tmins5/60);
      $mins5 = $tmins5%60;
      $toatalHours= $hours5.".".$mins5;
  
      $woData=array(

        'spare' => $Product_Name,
        'hours' => $toatalHours

      );

      $spareHours[]=$woData;

  }  

//print_r(json_encode($spareHours));

?>


<div id="chartContainer7" style="height: 300px; width: 100%;"></div>

<script type="text/javascript">
  
  var options7 = {
  title: {
    text: "Workorder Spare Hours"
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

          foreach ($spareHours as $sKey => $mValue) 
          {
            $spare=$mValue['spare'];
            $hours=$mValue['hours'];
        ?>
        
        { label: "<?=$spare?>", y: <?=$hours?> },

        <?php } ?>         
      ]
  }]
};

$("#chartContainer7").CanvasJSChart(options7);

</script>

  <!-- ================================================================= -->

</body>
<br>
<br>
</html>


<?php $this->load->view("footer.php");?>

<script type="text/javascript">

window.onload = function() {
      var a = $("#sec_id").val();
      var b = $("#typeSec_id").val();
      var c = $("#bsec_id").val();
      var d = $("#spareSec_id").val();
      getmachinelist(a);
      setMachinelist(b);
      show_machineList(c);
      putMachineList(d);
  };

  function getmachinelist(v)
  {
  
    ur="<?=base_url();?>report/Report/get_machine_list";
    //alert(ur);
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


  function setMachinelist(v)
  {
  
    ur="<?=base_url();?>report/Report/get_machine_list";
    //alert(ur);
    $.ajax({
  
        url   : ur,
        type  : "POST",
        data  : {'mid':v},
        success:function(data)
        {
  
          //alert(data);
          if(data != '')
          {
            $("#typemachine").empty().append(data);
          }
        }
    })
  
  }

  function show_machineList(v)
  {
  
    ur="<?=base_url();?>report/Report/get_machine_list";
    //alert(ur);
    $.ajax({
  
        url   : ur,
        type  : "POST",
        data  : {'mid':v},
        success:function(data)
        {
  
          //alert(data);
          if(data != '')
          {
            $("#bmachineid").empty().append(data);
          }
        }
    })
  
  }

  function putMachineList(v)
  {
  
    ur="<?=base_url();?>report/Report/get_machine_list";
    //alert(ur);
    $.ajax({
  
        url   : ur,
        type  : "POST",
        data  : {'mid':v},
        success:function(data)
        {
  
          //alert(data);
          if(data != '')
          {
            $("#mid").empty().append(data);
          }
        }
    })
  
  }

</script>


<script type="text/javascript">
  
$( ".sectionexpense" ).change(function() {
  
  $.ajax({

    url    : "<?=base_url();?>master/filterSectionExpense",
    type   : "POST",
    data   : {

            'section' : $("#m_type").val(),
            'year'    : $("#fyear").val(),
        },

    success:function(data){

      $("#chartContainer1").html(data);

    }

  });

});



$( ".machine_expense" ).change(function() {
  
  $.ajax({

    url    : "<?=base_url();?>master/filterMachineExpense",
    type   : "POST",
    data   : {

            'section' : $("#sec_id").val(),
            'machine' : $("#machineid").val(),
            'fromdate': $("#from_date").val(),
            'todate'  : $("#to_date").val(),
        },

    success:function(data){

      //alert(data);
      $("#chartContainer4").html(data);

    }

  });

});


$( ".type_expense" ).change(function() {
  
  $.ajax({

    url    : "<?=base_url();?>master/filterTypeExpense",
    type   : "POST",
    data   : {

            'section1' : $("#typeSec_id").val(),
            'machine1' : $("#typemachine").val(),
            'fromdate1': $("#from_date1").val(),
            'todate1'  : $("#to_date1").val(),
        },

    success:function(data){

      //alert(data);
      $("#chartContainer5").html(data);

    }

  });

});



$( ".spare_expense" ).change(function() {
  
  $.ajax({

    url    : "<?=base_url();?>master/filterSpareExpense",
    type   : "POST",
    data   : {

            'spsection' : $("#spareSec_id").val(),
            'machineid' : $("#mid").val(),
            'sparetype' : $("#spare_type").val(),
            'date_from' : $("#from_date3").val(),
            'date_to'   : $("#to_date3").val(),
        },

    success:function(data){

      //alert(data);
      $("#chartContainer6").html(data);

    }

  });

});


$( ".breakdown_hours" ).change(function() {
  
  $.ajax({

    url    : "<?=base_url();?>master/filterBreakdownHours",
    type   : "POST",
    data   : {

            'bsection' : $("#b_type").val(),
            'bkdnyear' : $("#hyear").val(),

        },

    success:function(data){

      //alert(data);
      $("#chartContainer3").html(data);

    }

  });

});


$( ".spares_hours" ).change(function() {
  
  $.ajax({

    url    : "<?=base_url();?>master/filterSparesHours",
    type   : "POST",
    data   : {

            'section'   : $("#bsec_id").val(),
            'machine'   : $("#bmachineid").val(),
            'date_from' : $("#from_date7").val(),
            'date_to'   : $("#to_date7").val(),
        },

    success:function(data){

      //alert(data);
      $("#chartContainer7").html(data);

    }

  });

});

</script>