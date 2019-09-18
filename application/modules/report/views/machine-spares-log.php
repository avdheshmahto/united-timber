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
          <h4 class="panel-title">MACHINE TO SPARES LOG ( <?=$fetch->machine_name;?> )</h4>
          <a href="<?=base_url();?>report/Report/machine_spare_details?sid=<?=$_GET['sid']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
        </div>
    <div class="panel-body panel-center">
      <form class="form-horizontal" method="get" action="">
        <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">From Date</label> 
          <div class="col-sm-3">
            <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>"> 
            <input type="hidden" name="mid" value="<?php echo $_GET['mid'];?>"> 
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
          <div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
            <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
            <button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
          </div>
        </div>
      </form>
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

                if($_GET['filter'] == 'filter')
                {

                    $qry="select product_id,machine_id from tbl_software_cost_log where machine_id='".$_GET['mid']."' ";


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

                    $qry .= " group by product_id";

                  $ssftCstLog=$this->db->query($qry);

                }
                else
                {
                 
                  $qry="select product_id,machine_id from tbl_software_cost_log where machine_id='".$_GET['mid']."' group by product_id";

                  $ssftCstLog=$this->db->query($qry);

                }

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

                  if($_GET['from_date'] && $_GET['to_date'] != '') 
                  {
                    $slog=$this->db->query("select SUM(qty) as totalQty from tbl_software_cost_log where product_id='$fetch_list->product_id' AND machine_id='".$_GET['mid']."' AND log_date >='".$_GET['from_date']."' and log_date <='".$_GET['to_date']."' ");
                  }
                  else
                  {
                    $slog=$this->db->query("select SUM(qty) as totalQty from tbl_software_cost_log where product_id='$fetch_list->product_id' AND machine_id='".$_GET['mid']."' "); 
                  }

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
    location.href="<?=base_url('/report/Report/machine_spares_log?sid=');?><?=$_GET['sid']?>&mid=<?=$_GET['mid']?>";
  }

   window.onload = function() {
      getSpareList(<?=$_GET['spare_type']?>);
  };

</script>