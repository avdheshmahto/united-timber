<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>
<?php 
  
  $crYr=date('Y'); 
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

        $qry="select SUM(total_spent) as totalamt from tbl_software_cost_log where status='A' ";

          if($section_id != '')
            $qry .=" AND main_section='$section_id' ";

          if($machine_id != '')
            $qry .=" AND machine_id='$machine_id' ";
          
          if($date_from != '' && $date_to != ''){
            $qry .="AND log_date >='$date_from' and log_date <='$date_to' ";
          }else if($date_from != ''){
            $qry .="AND log_date >='$date_from' ";
          }else if($date_to != ''){
            $qry .="AND log_date <='$date_to' ";
          }else{
            $qry .=" AND EXTRACT(YEAR FROM log_date)='$crYr' ";
          }      

            $qry .=" AND product_id IN ($prdIDs)";

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