<thead>
  <tr>
    <th>Breakdown Date</th>
    <th>Breakdown Start Time</th>
    <th>Breakdown End Time</th>
    <th>Breakdown Total Hours</th>
  </tr>
</thead>
<tbody>
  <?php 
    $i=1;
    
    $miscName=$this->db->query("select * from tbl_machine_breakdown where workorder_id='$id' and status='A'");
      foreach($miscName->result() as $fetch_hours)
      {
       
    ?>
  <tr class="gradeU record">
    <td><?=$fetch_hours->breakdown_date?></td>
    <td><?=$fetch_hours->start_time; ?></td>
    <td><?=$fetch_hours->end_time; ?></td>
    <td>
      <?php     
        // $day2 = strtotime( $fetch_hours->end_time );
        // $day1 = strtotime( $fetch_hours->start_time );
        // $diff = round(($day2 - $day1) / 3600);
        // echo $diff." Hours"; 
        $time1 = $fetch_hours->start_time;
        $time2 = $fetch_hours->end_time;
        
        $diff = abs(strtotime($time1) - strtotime($time2));
        
        $tmins = $diff/60;
        
        $hours = floor($tmins/60);
        
        $mins = $tmins%60;
        
        
        echo "<b>$hours</b> Hours | <b>$mins</b> Minutes</b>";
        
        
        
        ?>    	
    </td>
  </tr>
  <?php } ?>
  <tr class="gradeU">
    <td>
      <button  class="btn btn-default" data-a="<?php echo $fetch_list->id;?>" href='#breakDownId'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Add Breakdown Hours"><img src="<?=base_url();?>assets/images/plus.png" /></button>  
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</tbody>