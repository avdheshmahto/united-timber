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
    $sec=$this->db->query("select * from tbl_category where id='".$_GET['sid']."' ");
    $getSec=$sec->row();

    $mac=$this->db->query("select * from tbl_machine where id='".$_GET['mid']."'");
    $fetch=$mac->row();
    ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">BREAKDOWN WORKORDER DETAILS ( <?=$getSec->name;?> )( <?=$fetch->machine_name;?> )</h4>
          <a href="<?=base_url();?>report/Report/breakdown_hours_details?sid=<?=$_GET['sid']?>&year=<?=$_GET['year']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
        </div>
      <div class="panel-body panel-center">
      <form class="form-horizontal" method="get" action="">
        <div class="form-group panel-body-to">          
          <label class="col-sm-2 control-label">Workorder</label> 
          <div class="col-sm-3">
            <input type="hidden" name="sid" id='sid' value="<?=$_GET['sid']; ?>">
            <input type="hidden" name="mid" id='mid' value="<?=$_GET['mid']; ?>">
            <input type="hidden" name="year" id='year' value="<?=$_GET['year']; ?>">
            <select name="wo_id" id="wo_id" class="select2 form-control">
              <option value="">----Select----</option>
              <option value="1" <?php if($_GET['wo_id'] == 1) { ?> selected <?php } ?> >Workorder With Hours</option>
              <option value="2" <?php if($_GET['wo_id'] == 2) { ?> selected <?php } ?> >Workorder Without Hours</option>
            </select>
          </div>
        </div>
        <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">From Date</label> 
            <div class="col-sm-3">
              <input type="date" name="from_date" id='from_date' value="<?=$_GET['from_date']?>" class="form-control"> 
            </div>
          <label class="col-sm-2 control-label">To Date</label> 
          <div class="col-sm-3">
            <input type="date" name="to_date" id='to_date' value="<?=$_GET['to_date']?>" class="form-control"> 
          </div>
        </div> 
        <div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
          <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
          <button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
        </div>
      </form>
    </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
              <thead>
                <tr>
                  <th>Workorder No.</th>
                  <th>Workorder Status</th>
                  <th>Spare Name</th>
                  <th>Breakdown Hours</th>
                </tr>
              </thead>
              <tbody id="getDataTable" >
                <?php 
                $wyear=date('Y');

                if($_GET['filter'] == 'filter')
                {
                  
                  $wo="select * from tbl_machine_breakdown where section='".$_GET['sid']."' AND machine_id='".$_GET['mid']."' ";

                  if($_GET['wo_id']== 1){

                    $wo .=" AND start_time !='' AND end_time !='' ";
                  }

                  if($_GET['wo_id'] == 2){
                    $wo .= "AND start_time ='' AND end_time ='' ";
                  }

                  if($_GET['from_date'] && $_GET['to_date'] != ''){
                    $wo .=" AND maker_date >='".$_GET['from_date']."' AND maker_date <='".$_GET['to_date']."' ";
                  }
                  
                  $query=$this->db->query($wo);

                }
                else
                {
                  $query=$this->db->query("select * from tbl_machine_breakdown where section='".$_GET['sid']."' AND machine_id='".$_GET['mid']."' AND EXTRACT(YEAR FROM maker_date)='$wyear' ");
                }
                  
                  
                  $z=1;
                  foreach($query->result() as $getWo)
                  {
                  ?>
                <tr class="gradeC record">
                  <th><a target="_blank" href="<?=base_url();?>maintenance/machine_breakdown/manage_machine_breakdown_map?id=<?php echo $getWo->id; ?>"><?php  echo "WO".$getWo->id;  ?></a></th>
                  <th><?php 
                    $wm=$this->db->query("select * from tbl_work_order_maintain where id='$getWo->workorder_id'");
                    $getWm=$wm->row();
                    $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$getWm->wostatus."'");
                    $compRow = $sqlunit->row();
                    echo $compRow->keyvalue; ?>
                  </th>

                  <th><?php
                    $ws=$this->db->query("select * from tbl_workorder_spare_hdr where work_order_id='$getWo->workorder_id' ");
                    $getWhdr=$ws->row();

                    $wd=$this->db->query("select * from tbl_workorder_spare_dtl where spare_hdr_id='$getWhdr->spare_hdr_id' ");
                    $getWdtl=$wd->row();

                    $prd=$this->db->query("select * from tbl_product_stock where Product_id='$getWdtl->spare_id' ");
                    $getPrd=$prd->row();

                    echo $getPrd->productname;
                  ?>
                  </th>

                  <th><?php 
                    $from_time5 = strtotime($getWo->start_time);
                    $to_time5 = strtotime($getWo->end_time); 
                    $delta_5 = ($to_time5 - $from_time5);
                    $diff5=$delta_5;
                    
                    $tmins5 = $diff5/60;
                    $hours5 = floor($tmins5/60);
                    $mins5 = $tmins5%60;
                    echo "<b>$hours5</b> Hours | <b>$mins5</b> Minutes</b>";
                    ?>
                  </th>
                </tr>
                <?php  }  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php
        $this->load->view("footer.php");
        ?>  
    </div>
  </div>
</div>

<script type="text/javascript">
  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/breakdown_workorder?sid=');?><?=$_GET['sid']?>&mid=<?=$_GET['mid']?>&year=<?=$_GET['year']?>";
  }
</script>