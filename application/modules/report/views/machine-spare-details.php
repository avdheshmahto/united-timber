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
    
    $cat=$this->db->query("select * from tbl_category where id='".$_GET['id']."' ");
    $fetch=$cat->row();
    ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">MACHINE TO SPARE DETAILS REPORT ( <?=$fetch->name;?> )</h4>
          <ul class="panel-tool-options">
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
          </ul>
        </div>
        <div class="panel-body panel-center">
          <form class="form-horizontal" method="get" action="">
            <div class="form-group panel-body-to">
              <label class="col-sm-2 control-label">Section</label> 
              <div class="col-sm-3">
                <input type="hidden" name="id" id='id' value="<?php echo $_GET['id']; ?>">
                <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);" <?php if($_GET['id'] == 0 ) { ?> <?php } else { ?> disabled="" <?php } ?> >
                  <option value="0" class="listClass">------Section-----</option>
                  <?php
                    $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                    foreach($sql->result() as $getSql) {  ?>
                  <?php if($_GET['id'] == 0 ) { ?>
                  <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['m_type'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
                  <?php } else { ?>
                  <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['id'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
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
            <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Machine Code</th>
                  <th>Machine Name</th>
                  <th>Total Parts & Supplies</th>
                </tr>
              </thead>
              <tbody id="getDataTable" >
                <?php 
                  if($_GET['filter'] == 'filter')
                  {
                    $machine=$this->db->query("select * from tbl_machine where m_type='".$_GET['id']."' AND id='".$_GET['machineid']."' ");
                  }
                  else
                  {
                    $machine=$this->db->query("select * from tbl_machine where m_type='".$_GET['id']."' "); 
                  }
                  
                  $z=1;
                  foreach($machine->result() as $getMachine)
                  {
                  ?>
                <tr class="gradeC record">
                  <th><?php echo $z++; ?></th>
                  <th><?php echo $getMachine->code;?></th>
                   <?php 
                    $ssftCstLog=$this->db->query("select product_id,machine_id from tbl_software_cost_log where machine_id='$getMachine->id' group by product_id");
                    $getCostLog=$ssftCstLog->row();
                    $count=$ssftCstLog->num_rows();
                    //echo $count;
                    ?>         
                  <th><a target="_blank" href="<?=base_url();?>report/Report/machine_spares_log?id=<?=$getMachine->id?>"> <?php echo $getMachine->machine_name; ?> </a></th>
                  
                  <th><?php echo $count; ?></th>
                </tr>
                <?php  }  ?>
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
  </div>
</div>
<script type="text/javascript">
  window.onload = function() {
  
    <?php if($_GET['id'] == 0 ) { ?>
      getmachinelist(<?=$_GET['m_type']?>);
    <?php } else { ?>
      getmachinelist(<?=$_GET['id']?>);
    <?php } ?>
  
  };
  
  
  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/machine_details_report?id=');?><?=$_GET['id']?>";
  }
  
  
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