<?php
  $this->load->view("header.php");
  $entries = "";
  if($this->input->get('entries')!=""){
    $entries = $this->input->get('entries');
  }
?>

<!-- Main content -->
<div class="main-content">
<?php
  $this->load->view("reportheader");
  ?>
<div class="row">
<div class="col-lg-12">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <?php 
        $wo=$this->db->query("select * from tbl_work_order_maintain where id='".$_GET['id']."' ");
        $getWO=$wo->row();
        if($getWO->trigger_code != '') { ?>
      <h4 class="panel-title">WORKORDER MAINTENANCE DETAILS (<?php echo 'WO'.$getWO->id.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SM'.$getWO->trigger_code;?>)</h4>
      <?php } else { ?>
      <h4 class="panel-title">WORKORDER MAINTENANCE DETAILS (<?php echo 'WO'.$getWO->id; ?>) </h4>
      <?php } ?>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example1"  >
          <thead>
          <tbody>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Workorder Total Amount =</th>
            <th><input type="text" name="workorder_total" id="workorder_total" class="form-control" style="width: 100px;" readonly=""/></th>
          </tbody>
          </thead>
          <thead>
            <tr>
              <th>S. No.</th>
              <th>Date</th>
              <th>Parts & Supplies Name</th>
              <th>Type</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Parts & Supplies Amount</th>
              <th>Labor Cost</th>
            </tr>
          </thead>
          <tbody id="getDataTable" >
            <?php
              $issuehdr=$this->db->query("select * from tbl_spare_issue_hdr where workorder_id='".$_GET['id']."' ");
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
              
              $issuedtl=$this->db->query("select * from tbl_spare_issue_dtl where issue_id_hdr IN ($IssueIdHdr) ");
              $count=$issuedtl->num_rows();
              
              if($count > 0)
              {
              
              $z=1;
              $i=0;
              foreach($issuedtl->result() as $fetch_list) {
              ?>
            <tr class="gradeC record">
              <th><?php echo $z++; ?></th>
              <th><?php echo $fetch_list->author_date ?></th>
              <th>
                <?php
                  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->spare_id'");
                  $getPrd=$prd->row();
                  echo $getPrd->productname; ?>
              </th>
              <th><?=$getPrd->via_type?></th>
              <th><?php echo $fetch_list->price ;?></th>
              <th><?php echo $fetch_list->qty; ?></th>
              <th><?php echo $totalprice = $fetch_list->price * $fetch_list->qty?></th>
              <?php 
                $laborCost=$this->db->query("select SUM(cost_spent) as totalcost from tbl_workorder_labor_task where work_order_id='".$_GET['id']."' ");
                $getCost=$laborCost->row();
                
                if($i == 0)
                { ?>
              <th rowspan="<?=$count?>">
                <div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
                  <?php echo $cost=$getCost->totalcost; ?>
                </div>
              </th>
              <?php
                }
                else
                {
                	$cost=0;
                }
                
                $total=$totalprice + $cost;
                ?>	
            </tr>
            <?php 
              $sum=$sum+$total;
              $i++;
              } ?>
            <?php 
              } 
              	
              else 
              { 
              	$count=1;
              
              ?>
            <tr>
              <th>1</th>
              <th colspan="6"></th>
              <?php 
                $laborCost=$this->db->query("select SUM(cost_spent) as totalcost from tbl_workorder_labor_task where work_order_id='".$_GET['id']."' ");
                $getCost=$laborCost->row();
                
                if($i == 0)
                { ?>
              <th rowspan="<?=$count?>">
                <div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
                  <?php echo $cost=$getCost->totalcost; ?>
                </div>
              </th>
              <?php
                }
                else
                {
                	$cost=0;
                }
                
                $total=$cost;
                ?>	
            </tr>
            <?php 
              $sum=$total;
              } ?>
            <input type="hidden" name="totalprice" id="totalprice" class="form-control" value="<?php echo $sum;?>" />
          </tbody>
        </table>
      </div>
    </div>
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
  <?php
    $this->load->view("footer.php");
    ?>
</div>
<script type="text/javascript">
  var id1=document.getElementById("totalprice").value;
  document.getElementById("workorder_total").value = id1;
  
</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">