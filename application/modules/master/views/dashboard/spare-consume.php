<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.canvasjs.min.js"></script>
<?php
    
    $crYr=date('Y');

    $qry="select * from tbl_software_cost_log where status='A' ";

      if($section_ids != '')
      {
        $qry .=" AND main_section='$section_ids'";
      }

      if($machine_ids != '')
      {
        $qry .=" AND machine_id='$machine_ids' ";
      }

      if($date_from3 != '' && $date_to3 != ''){
        $qry .= " AND log_date >='$date_from3' and log_date <='$date_to3' ";
      }else if($date_from3 != ''){
        $qry .= " AND log_date >='$date_from3' ";
      }else if($date_to3 != ''){
        $qry .= " AND log_date <='$date_to3' ";
      }else{
        $qry .=" AND EXTRACT(YEAR FROM log_date)='$crYr' ";
      }

      if($spare_types != '')
      {

        $prd=$this->db->query("select * from tbl_product_stock where type_of_spare='$spare_types' ");
        foreach ($prd->result() as $key)
        {
          $idd[]=$key->Product_id;
        }

        if($idd != '')
        {
          $ids=implode(',', $idd);
        }
        else
        {
          $ids='99999';
        }


        $qry .=" AND product_id IN ($ids)";

      }

      $qry .= " group by product_id";

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

  $prdName=$this->db->query("select * from tbl_software_cost_log where product_id IN ($prdID) group by product_id");
  foreach($prdName->result() as $fetch_list) 
  { 

    $slog="select *,SUM(qty) as totalQty,SUM(total_spent) as spareAmt from tbl_software_cost_log where product_id='$fetch_list->product_id' ";
    
      if($section_ids != '')
      {
        $slog .=" AND main_section='$section_ids'";
      }

      if($machine_ids != '')
      {
        $slog .=" AND machine_id='$machine_ids' ";
      }
    
      if($date_from3 != '' && $date_to3 != '')
      {
        $slog .="AND log_date >='$date_from3' AND log_date <='$date_to3' ";
      }

      if($date_from3 != '')
      {
        $slog .=" AND log_date >='$date_from3' ";
      }
      
      if($date_to3 != '')
      {
        $slog .=" AND log_date <='$date_to3' ";
      }

      $query=$this->db->query($slog);
      $getLogQty=$query->row();

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

//print_r(json_encode($spareData));

?>

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
