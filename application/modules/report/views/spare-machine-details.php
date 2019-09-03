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
    
    $cat=$this->db->query("select * from tbl_category where id='".$_GET['sid']."' ");
    $fetch=$cat->row();
    ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">SPARE TO MACHINE DETAILS REPORT ( <?=$fetch->name;?> )</h4>
            <a href="<?=base_url();?>report/Report/spare_machine_report" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
        </div>
      <div class="panel-body panel-center">
        <form class="form-horizontal" method="get" action="">
          <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">From Date</label> 
          <div class="col-sm-3">
            <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>"> 
            <input type="date" name="from_date" id='from_date' value="<?=$_GET['from_date'];?>" class="form-control"> 
          </div>
          <label class="col-sm-2 control-label">To Date</label> 
          <div class="col-sm-3">
            <input type="date" name="to_date" id='to_date' value="<?=$_GET['to_date'];?>" class="form-control"> 
          </div>
        </div>
          <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">Type Of Spare</label> 
          <div class="col-sm-3">
            <select name="spare_type" class="select2 form-control" id="spare_type" style="width:100%;" onchange="getSpareList(this.value);">
              <option value="">--select--</option>
              <?php $getProductName=$this->db->query("select * from tbl_master_data where param_id='26'");
                $ProductName=$getProductName->result();
                foreach($ProductName as $p) { ?>
              <option value="<?=$p->serial_number?>"  <?php if($_GET['spare_type'] == $p->serial_number) { ?> selected <?php } ?> ><?=$p->keyvalue?></option>
              <?php } ?>
            </select>
          </div>
          <label class="col-sm-2 control-label">Parts & Supplies</label> 
          <div class="col-sm-3">
            <select name="spare_id" id="spare_id" class="select2 form-control">
              <option value="">----Select----</option>
            </select>
          </div>
            <div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px"> 
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
                  <th>S. No.</th>
                  <th>Type Of Spare</th>
                  <th>Parts & Supplies</th>
                  <th>Total Machine</th>
                </tr>
              </thead>
              <tbody id="getDataTable" >
                <?php 
                  if($_GET['filter'] == 'filter')
                  {

                    $qry="select * from tbl_software_cost_log where main_section='".$_GET['sid']."' ";
                    
                    if($_GET['from_date'] && $_GET['to_date'] != '') 
                    {
                        
                      /*$t_date = explode("-", $_GET['to_date']);
                      $f_date = explode("-", $_GET['from_date']);
                      $t_date1 = $t_date[0] . "-" . $t_date[1] . "-" . $t_date[2];
                      $f_date1 = $f_date[0] . "-" . $f_date[1] . "-" . $f_date[2];*/
                      $qry .= " AND log_date >='".$_GET['from_date']."' and log_date <='".$_GET['to_date']."'";
                    }
                    
                    if($_GET['spare_type'] != '')
                    {

                      $prd=$this->db->query("select * from tbl_product_stock where type_of_spare='".$_GET['spare_type']."' ");
                      foreach ($prd->result() as $key)
                      {
                        $idd[]=$key->Product_id;
                      }

                      if($idd != '')
                      {
                        $ids=implode(',', $idd);
                      }
                      else
                      {
                        $ids='99999';
                      }


                      $qry .=" AND product_id IN ($ids)";
                       
                    }


                    if($_GET['spare_id'] != '')  
                      $qry .=" AND product_id='".$_GET['spare_id']."' ";

                      $qry .=" GROUP BY product_id";

                    $spare=$this->db->query($qry);

                  }
                  else
                  {

                    $qry="select * from tbl_software_cost_log where main_section='".$_GET['sid']."' GROUP BY product_id "; 

                    $spare=$this->db->query($qry);

                  }
                  
                  $z=1;
                  foreach($spare->result() as $getSpare)
                  {
                    
                    $prd=$this->db->query("select * from tbl_product_stock where Product_id='$getSpare->product_id' ");
                    $getPrd=$prd->row();

                    $mst=$this->db->query("select * from tbl_master_data where serial_number='$getPrd->type_of_spare' ");
                    $getKey=$mst->row();
                  ?>
                <tr class="gradeC record">
                  <th><?php echo $z++; ?></th>
                  <th><?php echo $getKey->keyvalue; ?></th>
                  <th><a href="<?=base_url();?>report/Report/spares_machine_log?sid=<?=$getSpare->main_section?>&pid=<?=$getSpare->product_id?>"> <?php echo $getPrd->productname;?> </a>
                  </th>
                  <?php 
                    $ssftCstLog=$this->db->query("select product_id,machine_id from tbl_software_cost_log where main_section='".$_GET['sid']."' AND product_id='$getSpare->product_id' AND machine_id !='' group by machine_id");
                    $getCostLog=$ssftCstLog->row();
                    $count=$ssftCstLog->num_rows();
                    //echo $count;
                  ?> 
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
  function getSpareList(v)
  {

    $.ajax({
      
      url  : "<?=base_url();?>report/Report/get_spare_list_data",
      type : "POST",
      data : {'typId':v},
      success:function(data)
      {
        if(data != '')
        {
          $("#spare_id").empty().append(data);
        }
      }

    })
  }

  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/spare_machine_details?sid=');?><?=$_GET['sid']?>";
  }

   window.onload = function() {
      getSpareList(<?=$_GET['spare_type']?>);
  };
</script>