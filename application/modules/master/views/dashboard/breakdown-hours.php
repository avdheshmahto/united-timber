<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>
<?php

    $query="select * from tbl_machine_breakdown where status='A' ";

      if($bdsection != '')
        $query.=" AND section='$bdsection' ";
      
      if($byear != '')
        $query.=" AND EXTRACT(YEAR FROM breakdown_date)='$byear' ";

        $query .=" GROUP BY section ";
  
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