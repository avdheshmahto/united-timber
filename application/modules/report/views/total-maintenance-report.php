<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<style type="text/css">
  .listClass{position: relative;right: 12px font-size: 15px;    font-weight: 600;
  height: 90px !important;border-left: 2px solid red; padding: 14px 20px 14px 20px; }
  .displayclass{display: none;}
</style>
<?php
  $this->load->view("header.php");
  $entries = "";
  if($this->input->get('entries')!="")
  {
    $entries = $this->input->get('entries');
  }
  
  
  ?>
<!-- Main content -->
<div class="main-content">
<?php
  $this->load->view("reportheader");
  ?>
<div class="row">
<div class="col-lg-3">
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="<?=base_url();?>assets/report/style.css" type="text/css" rel="stylesheet">
      <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    </head>
    <body>
      <div class="container" style="margin-top:10px;">
        <div class="row">
          <div class="col-md-3">
            <ul id="tree2">
              <li><a href="<?=base_url();?>report/Report/total_maintenance?sid=0">ALL SECTION</a>
              </li>
              <ul>
                <?php 
                  $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                  foreach($sql->result() as $getSql) { ?>                 
                <li><a href="<?=base_url();?>report/Report/total_maintenance?sid=<?=$getSql->id?>"><?=$getSql->name?></a></li>
                <?php } ?>                        
              </ul>
            </ul>
          </div>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="<?=base_url();?>assets/report/script.js"></script>
    </body>
  </html>
</div>
<div class="col-lg-9">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <?php $sql=$this->db->query("select * from tbl_category where inside_cat='0' AND id='".$_GET['sid']."' ");
        $getSec=$sql->row();
       ?>
      <h4 class="panel-title">MAINTENANCE REPORT <?php if($_GET['sid']==0){ ?>( All Section ) <?php } else {?>(&nbsp;&nbsp;<?=$getSec->name;?>&nbsp;&nbsp;)<?php }?></h4>
      <ul class="panel-tool-options">
        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
      </ul>
    </div>
    <div class="panel-body panel-center">
      <form class="form-horizontal" method="get" action="">
        <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">Section</label> 
          <div class="col-sm-3">
            <input type="hidden" name="sid" id='sid' value="<?php echo $_GET['sid']; ?>">
            <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);" <?php if($_GET['sid'] == 0 ) { ?> <?php } else { ?> disabled="" <?php } ?> >
              <option value="0" class="listClass">------Section-----</option>
              <?php
                $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                foreach($sql->result() as $getSql) { ?>
              <?php if($_GET['sid'] == 0 ) { ?>
              <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['m_type'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
              <?php } else { ?>
              <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['sid'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          <label class="col-sm-2 control-label">Machine</label> 
          <div class="col-sm-3">
            <select name="machineid" id="machineid" class="select2 form-control">
              <option value="">----Machine----</option>
            </select>
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
        <table class="table table-striped table-bordered table-hover dataTables-example1"  id="tblData">
          <thead>
          <tbody>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total Workorder Amount =</th>
            <th><span id="workorder_total"> </span></th>
          </tbody>
          </thead>
          <thead>
            <tr>
              <th>Workorder No.</th>
              <th>Workorder Date</th>
              <th>Schedule No.</th>
              <th>Trigger No.</th>
              <th>Section</th>
              <th>Machine</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody id="getDataTable" >
            <tr style="display: none;">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php
              if($_GET['sid']== 0)
              {
                
                if($_GET['filter'] == 'filter')
                {
                  
                  $query="select * from tbl_work_order_maintain where status='A' ";
              
                  if($_GET['m_type'] != '')
                    $query .= " AND m_type='".$_GET['m_type']."' ";
              
                  if($_GET['machineid'] != '')
                     $query .= " AND machine_name='".$_GET['machineid']."' "; 
              
              
              
                     $query .= " Order by id DESC ";
                    
                }
                else
                {
                  $query=("select * from tbl_work_order_maintain where status='A' Order by id DESC ");
                }
                
                $getQuery = $this->db->query($query);
                $result=$getQuery->result();
              }
              else
              {
                
                if($_GET['filter'] == 'filter')
                {
                  $query=("select * from tbl_work_order_maintain where m_type='".$_GET['sid']."' AND machine_name='".$_GET['machineid']."' Order by id DESC ");  
                }
                else
                {
                  $query=("select * from tbl_work_order_maintain where m_type='".$_GET['sid']."' Order by id DESC ");
                }
                
                $getQuery = $this->db->query($query);
                $result=$getQuery->result();
              }
              
              foreach($result as $fetch_list) {
              ?>
            <tr class="gradeC record">
              <th>
                <?php
                  if($fetch_list->trigger_code!='') { ?>
                <a href="<?=base_url();?>report/Report/maintenance_details?sid=<?=$_GET['sid']?>&wid=<?=$fetch_list->id;?>" >
                <?php   echo "WO".$fetch_list->id."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SM".$fetch_list->schedule_id;  ?></a>
                <?php } else { ?>
                <a href="<?=base_url();?>report/Report/maintenance_details?sid=<?=$_GET['sid']?>&wid=<?=$fetch_list->id;?>" >
                <?php   echo "WO".$fetch_list->id;  ?></a>
                <?php } ?>
              </th>
              <th><?php echo $fetch_list->maker_date; ?></th>
              <th>  
                <?php
                  if($fetch_list->schedule_id!='')
                  {
                    echo "SM".$fetch_list->schedule_id;
                  }
                  ?>
              </th>
              <th>  
                <?php
                  if($fetch_list->trigger_code!='')
                  {
                    echo "TR".$fetch_list->trigger_code;
                  }
                  ?>
              </th>
              <th>
                <?php
                  $mac=$this->db->query("select * from tbl_machine where id='$fetch_list->machine_name'");
                  $getMac=$mac->row();
                  
                  $fac=$this->db->query("select * from tbl_category where id='$getMac->m_type' ");
                  $getFac=$fac->row();
                  
                  echo $getFac->name;
                  //echo $getFac->fac_name."(".$getMac->machine_name.")";
                  ?>  
              </th>
              <th>
                <?php
                  echo $getMac->machine_name;
                  ?>  
              </th>
              <th>
                <?php 
                  $issuehdr=$this->db->query("select * from tbl_spare_issue_hdr where workorder_id='$fetch_list->id' ");
                  //echo "select * from tbl_spare_issue_hdr where workorder_id='$fetch_list->id'";
                  $count=$issuehdr->num_rows();
                  
                  $ishdrid=array();
                  foreach ($issuehdr->result() as $value) 
                  {
                    array_push($ishdrid, $value->issue_id);   
                  }
                  
                  if($count > 0)
                  {
                    $IssueIdHdr=implode(',', $ishdrid);
                  }
                  else
                  {
                    $IssueIdHdr='999999';
                  }
                  
                  $issuedtl=$this->db->query("select SUM(price * qty) as totalkharcha from tbl_spare_issue_dtl where issue_id_hdr IN ($IssueIdHdr)");
                  $getIssueDtl=$issuedtl->row();
                  
                  $total = $getIssueDtl->totalkharcha;
                  
                  
                  $laborCost=$this->db->query("select SUM(cost_spent) as totalcost from tbl_workorder_labor_task where work_order_id='$fetch_list->id' ");
                  $getCost=$laborCost->row();
                  
                  $cost=$getCost->totalcost;
                  
                  $toatalSpent=$cost + $total;
                  
                  echo $toatalSpent;
                  
                  
                  ?>
              </th>
            </tr>
            <?php 
              $sum=$sum+$toatalSpent;
              
              }  ?>
            <input type="hidden" name="totalprice" id="totalprice" class="form-control" value="<?php echo $sum;?>" />
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php
    $this->load->view("footer.php");
    ?>
</div>
<script type="text/javascript">
  var id1=document.getElementById("totalprice").value;
  document.getElementById("workorder_total").innerHTML = id1;
  //alert(id);
  
  
  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/total_maintenance?sid=');?><?=$_GET['sid']?>";
  }
</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
<script type="text/javascript">
  window.onload = function() {
  
    <?php if($_GET['sid'] == 0 ) { ?>
      getmachinelist(<?=$_GET['m_type']?>);
    <?php } else { ?>
      getmachinelist(<?=$_GET['sid']?>);
    <?php } ?>
  
  };
  
</script>
<script type="text/javascript">
  function getmachinelist(v)
  {
  
    ur="<?=base_url();?>report/Report/get_machine_list";
    //alert(ur);
    $.ajax({
  
        url   : ur,
        type  : "POST",
        data  : {'mid':v},
        success:function(data)
        {
  
          //alert(data);
          if(data != '')
          {
            $("#machineid").empty().append(data);
          }
        }
    })
  
  }
</script>