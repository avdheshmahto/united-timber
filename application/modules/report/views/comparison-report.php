<?php
   $this->load->view("header.php");
   
   $entries = "";
   if($this->input->get('entries')!="")
   {
     $entries = $this->input->get('entries');
   }
   
   ?>
<div class="main-content">
<?php
   $this->load->view("reportheader");
   ?>
<div class="row">
<div class="col-lg-12">
   <div class="panel panel-default">
      <div class="panel-heading clearfix">
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
         <h4 class="panel-title">COMPARISON REPORT (January <?=$myear?> - December <?=$myear?> )</h4>
         <ul class="panel-tool-options">
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
         </ul>
      </div>
      <div class="panel-body panel-center">
         <form class="form-horizontal" method="get" action="">
            <div class="form-group panel-body-to">
               <label class="col-sm-2 control-label">Section</label> 
               <div class="col-sm-3">
                  <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;">
                     <option value="" class="listClass">------Section-----</option>
                     <?php
                        $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                        foreach($sql->result() as $getSql) { ?>
                     <option value="<?=$getSql->id?>"><?=$getSql->name?></option>
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
      </div>
      <div class="panel-body">
         <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
               <thead>
                  <tr>

                     <th>Particulars</th>
                     <th>January</th>
                     <th>February</th>
                     <th>March</th>
                     <th>April</th>
                     <th>May</th>
                     <th>June</th>
                     <th>July</th>
                     <th>August</th>
                     <th>September</th>
                     <th>October</th>
                     <th>November</th>
                     <th>December</th>
                     
                  </tr>
               </thead>
               <tbody id="getDataTable" >
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
                     foreach($result as $fetch) { ?>
                  <tr class="gradeC record">
                     <th>
                        <?php $sec=$this->db->query("select * from tbl_category where id='$fetch->main_section'");
                           $getSec=$sec->row(); ?>
                        <a target="_blank" href="<?=base_url('report/Report/comparison_details_report?id=')?><?=$fetch->main_section?>&year=<?=$myear?>"> <?php echo $getSec->name;?> </a>
                     </th>
                     <th>
                        <?php
                           $january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=01 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section'");    
                           $getJanuaryData=$january->row();
                           echo (round($getJanuaryData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=02 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' ");   
                           $getFebruaryData=$february->row();
                           echo (round($getFebruaryData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=03 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getMarchData=$march->row();
                           echo (round($getMarchData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php $april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=04 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getAprilData=$april->row();
                           echo (round($getAprilData->totalamt,2)); 
                           ?>
                     </th>
                     <th>
                        <?php
                           $may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=05 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getMayData=$may->row();
                           echo (round($getMayData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=06 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section'");    
                           $getJuneData=$june->row();
                           echo (round($getJuneData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=07 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getJulyData=$july->row();
                           echo (round($getJulyData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=08 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getAugustData=$august->row();
                           echo (round($getAugustData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=09 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getSeptemberData=$september->row();
                           echo (round($getSeptemberData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=10 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getOctoberData=$october->row();
                           echo (round($getOctoberData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=11 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getNovemberData=$novermber->row();
                           echo (round($getNovemberData->totalamt,2));
                           ?>
                     </th>
                     <th>
                        <?php
                           $december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=12 AND EXTRACT(YEAR FROM log_date)='$myear' AND main_section='$fetch->main_section' "); 
                           $getDecemberData=$december->row();
                           echo (round($getDecemberData->totalamt,2));
                           ?>
                     </th>
                     
                  </tr>
                  <?php 
                     $totalcost_april     =$totalcost_april + $getAprilData->totalamt;
                     $totalcost_may       =$totalcost_may + $getMayData->totalamt;
                     $totalcost_june      =$totalcost_june + $getJuneData->totalamt;
                     $totalcost_july      =$totalcost_july + $getJulyData->totalamt;
                     $totalcost_august    =$totalcost_august + $getAugustData->totalamt;
                     $totalcost_september =$totalcost_september + $getSeptemberData->totalamt;
                     $totalcost_october   =$totalcost_october + $getOctoberData->totalamt;
                     $totalcost_november  =$totalcost_november + $getNovemberData->totalamt;
                     $totalcost_december  =$totalcost_december + $getDecemberData->totalamt;
                     $totalcost_january   =$totalcost_january + $getJanuaryData->totalamt;
                     $totalcost_february  =$totalcost_february + $getFebruaryData->totalamt;
                     $totalcost_march     =$totalcost_march + $getMarchData->totalamt;
                     
                     $YearSum=$totalcost_april + $totalcost_may  + $totalcost_june + $totalcost_july + $totalcost_august + $totalcost_september + $totalcost_october + $totalcost_november + $totalcost_december + $totalcost_january + $totalcost_february + $totalcost_march ;
                     
                      }  ?>
                  <tr class="gradeC record">
                     <th>Total</th>
                     <th><?php echo (round($totalcost_january,2)); ?></th>
                     <th><?php echo (round($totalcost_february,2)); ?></th>
                     <th><?php echo (round($totalcost_march,2)); ?></th>
                     <th><?php echo (round($totalcost_april,2)); ?> </th>
                     <th><?php echo (round($totalcost_may,2)); ?></th>
                     <th><?php echo (round($totalcost_june,2)); ?></th>
                     <th><?php echo (round($totalcost_july,2)); ?></th>
                     <th><?php echo (round($totalcost_august,2)); ?></th>
                     <th><?php echo (round($totalcost_september,2)); ?></th>
                     <th><?php echo (round($totalcost_october,2)); ?></th>
                     <th><?php echo (round($totalcost_november,2)); ?></th>
                     <th><?php echo (round($totalcost_december,2)); ?></th>                  
                  </tr>
                  <tr class="gradeC record">
                     <th colspan="13">Grand Total = <?php echo (round($YearSum,2)); ?> </th>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="row">
            <div class="col-md-12 text-right">
               <div class="col-md-6 text-left"> 
               </div>
               <div class="col-md-6"> 
                  <?php echo $pagination; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php
      $this->load->view("footer.php");
      ?>  
</div>
<script>
   function ResetLead()
   {
     location.href="<?=base_url('/report/Report/comparison_report');?>";
   }
   
</script>
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
