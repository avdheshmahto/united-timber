<?php
  $this->load->view("header.php");
  ?>
<div class="main-content">
  <?php
    $this->load->view("reportheader");
    
    $cat=$this->db->query("select * from tbl_machine where id='".$_GET['id']."' ");
    $fetch=$cat->row();
    ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">MACHINE TO SPARES LOG ( <?=$fetch->machine_name;?> )</h4>
          <ul class="panel-tool-options">
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
          </ul>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadfiles" >
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Type</th>
                  <th>Part & Supplies Name</th>
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $i=1;

                  $ssftCstLog=$this->db->query("select product_id,machine_id from tbl_software_cost_log where machine_id='".$_GET['id']."' group by product_id");

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
                  foreach($prdName->result() as $fetch_list) { 

                  $slog=$this->db->query("select *,SUM(qty) as totalQty from tbl_software_cost_log where product_id='$fetch_list->product_id' AND machine_id='".$_GET['id']."' ");
                  $getLogQty=$slog->row();

                  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->product_id'");
                  $getPrd=$prd->row();

                  $mst=$this->db->query("select * from tbl_master_data where serial_number='$getPrd->type_of_spare'");
                  $getType=$mst->row();
                  ?>
                <tr class="gradeU record">
                  <td><?=$i++;?></td>
                  <td><?=$getType->keyvalue;?></td>
                  <td><?php echo $getPrd->productname;?></td>
                  <td><?php echo $getLogQty->totalQty; ?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <?php
          $this->load->view("footer.php");
          ?>  
      </div>
    </div>
  </div>
</div>