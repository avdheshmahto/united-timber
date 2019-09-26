<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>
<?php 
$crYr=date('Y'); 
$qry ="select * from tbl_machine where status='A' ";

    if($section_id != '')
      $qry .=" AND m_type='$section_id' ";

    if($machine_id != '')
      $qry .=" AND id='$machine_id' ";

    $machine=$this->db->query($qry);

  
    foreach($machine->result() as $fetch_list) 
    { 


      $machineName=$fetch_list->machine_name;

      if($date_from != '' && $date_to != '')
      {
        $spent=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where machine_id='$fetch_list->id' AND log_date >='$date_from' and log_date <='$date_to' "); 
      }
      else if($date_from != '')
      {
      	$spent=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where machine_id='$fetch_list->id' AND log_date >='$date_from' "); 
      }
      else if($date_to != '')
      {
      	$spent=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where machine_id='$fetch_list->id' AND log_date <='$date_to' "); 
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