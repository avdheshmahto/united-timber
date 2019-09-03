<?php
  $this->load->view("header.php");
  ?>
<div class="main-content">
  <?php
    $this->load->view("reportheader");
    
    $cat=$this->db->query("select * from tbl_machine where id='".$_GET['mid']."' ");
    $fetch=$cat->row();
    ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">MACHINE FILES LOG ( <?=$fetch->machine_name;?> )</h4>
          <a href="<?=base_url();?>report/Report/machine_details_report?sid=<?=$_GET['sid']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadfiles" >
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>File Name</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $i=1;
                  $supplieraName=$this->db->query("select * from tbl_machine_files_uploads where module_type='Machine' AND file_log_id='".$_GET['mid']."' ");
                  foreach($supplieraName->result() as $fetch_list) { ?>
                <tr class="gradeU record">
                  <td><?=$fetch_list->id;?></td>
                  <td><a target="blank" href="<?=base_url('filesimages/machinefiles');?>/<?=$fetch_list->file_name;?>"><?=$fetch_list->file_name;?></a></td>
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