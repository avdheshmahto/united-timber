<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>
<?php 
  
  $wyear=date('Y');

  $wo="select * from tbl_machine_breakdown where start_time !='' AND end_time !='' ";
  
    if($section_id != '')
      $wo .=" AND section='$section_id' ";
  
    if($machine_id != '')
      $wo .=" AND machine_id='$machine_id' ";
  
    if($date_from7 && $date_to7 != ''){
      $wo .=" AND maker_date >='$date_from7' AND maker_date <='$date_to7' ";      
    }else if($date_from7 != ''){
      $wo .=" AND maker_date >='$date_from7' ";      
    }else if($date_to7 != ''){
      $wo .=" AND maker_date <='$date_to7' ";      
    }else{
      $wo .=" AND EXTRACT(YEAR FROM maker_date)='$wyear' ";
    } 
      
    $query=$this->db->query($wo);

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