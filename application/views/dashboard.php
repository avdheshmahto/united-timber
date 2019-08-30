<?php $this->load->view("header.php");?>

<!DOCTYPE HTML>
<html>
<head>
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
 

<div id="chartContainer" style="height: 400px; width: 100%;">

</div>
</body>


<!-- ==============================chart======================================= -->

<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js">
</script>
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