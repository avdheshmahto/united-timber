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
          <a href="<?=base_url();?>report/Report/spare_machine_details?sid=<?=$_GET['sid']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
        </div>
        <div class="panel-body panel-center">
          <form class="form-horizontal" method="get" action="">
            <div class="form-group panel-body-to">
              <label class="col-sm-2 control-label">Section</label> 
              <div class="col-sm-3">
                <input type="hidden" name="sid" id='sid' value="<?php echo $_GET['sid']; ?>">
                <input type="hidden" name="pid" id='pid' value="<?php echo $_GET['pid']; ?>">
                <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);"  disabled="" >
                  <option value="0" class="listClass">------Section-----</option>
                  <?php
                    $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                    foreach($sql->result() as $getSql) {  ?>
                  <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['sid'] ) { ?> selected <?php } ?> ><?=$getSql->name?></option>
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

                  if($_GET['filter'] == 'filter')
                  {
                    $ssftCstLog=$this->db->query("select product_id,machine_id from tbl_software_cost_log where main_section='".$_GET['sid']."' and product_id='".$_GET['pid']."' AND machine_id ='".$_GET['machineid']."' GROUP BY machine_id");
                  }
                  else
                  {
                    $ssftCstLog=$this->db->query("select product_id,machine_id from tbl_software_cost_log where main_section='".$_GET['sid']."' and product_id='".$_GET['pid']."' AND machine_id !='' GROUP BY machine_id");
                  }


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

<script type="text/javascript">
  window.onload = function() {
  
      getmachinelist(<?=$_GET['sid']?>);
  
  };
  
  
  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/spares_machine_log?sid=');?><?=$_GET['sid']?>&pid=<?=$_GET['pid']?>";
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