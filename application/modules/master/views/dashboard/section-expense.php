<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>
<?php 

if($section_id != '')
{
	$query=("select * from tbl_software_cost_log where status='A' AND section_id='$section_id' AND EXTRACT(YEAR FROM log_date)='$myear' GROUP BY main_section");	
}
else
{
	$query=("select * from tbl_software_cost_log where status='A' AND EXTRACT(YEAR FROM log_date)='$myear' GROUP BY main_section");
}


$result=$this->db->query($query)->result();

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