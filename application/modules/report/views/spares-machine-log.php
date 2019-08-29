<?php
  $this->load->view("header.php");
  ?>
<div class="main-content">
  <?php
    $this->load->view("reportheader");
    
    $cat=$this->db->query("select * from tbl_product_stock where Product_id='".$_GET['pid']."' ");
    $fetch=$cat->row();
    ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">SPARES MACHINE LOG ( <?=$fetch->productname;?> )</h4>
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
                  <th>Machine Code</th>
                  <th>Machine Name</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $i=1;

                  $ssftCstLog=$this->db->query("select product_id,machine_id from tbl_software_cost_log where main_section='".$_GET['sid']."' and product_id='".$_GET['pid']."' AND machine_id !='' GROUP BY machine_id");

                  foreach($ssftCstLog->result() as $fetch_list) { 

                  $mac=$this->db->query("select * from tbl_machine where id='$fetch_list->machine_id'");
                  $getMac=$mac->row();
                  ?>
                <tr class="gradeU record">
                  <td><?=$i++;?></td>
                  <td><?=$getMac->code;?></td>
                  <td><?=$getMac->machine_name;?></td>
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