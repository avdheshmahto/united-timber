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
            $wo=$this->db->query("select * from tbl_category where id='".$_GET['sid']."'");
            $getWO=$wo->row(); ?>
          <h4 class="panel-title">COMPARISON SECTION SPARES DETAILS (<?php echo $getWO->name; ?>) </h4>
          <a href="<?=base_url();?>report/Report/comparison_details_report?sid=<?=$_GET['sid']?>&year=<?=$_GET['year']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
        </div>
    <div class="panel-body panel-center">
      <form class="form-horizontal" method="get" action="">
        <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">From Date</label> 
          <div class="col-sm-3">
            <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>"> 
            <input type="hidden" name="year" value="<?php echo $_GET['year'];?>"> 
            <input type="hidden" name="month" value="<?php echo $_GET['month'];?>"> 
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
            <table class="table table-striped table-bordered table-hover dataTables-example1"  >
              <thead>
              <tbody>
                <th></th>
                <th></th>
                <th>
                  <?php if($_GET['filter'] == 'filter') { ?>
                  <a href="<?=base_url('report/Report/frequency_details_section?sid=')?><?=$_GET['sid']?>&year=<?=$_GET['year']?>&month=<?=$_GET['month']?>&from_date=<?=$_GET['from_date']?>&to_date=<?=$_GET['to_date']?>&spare_type=<?=$_GET['spare_type']?>&spare_id=<?=$_GET['spare_id']?>&filter=<?=$_GET['filter']?>" style="font-size: small;">
                  Frequncy Of Spares</a>
                <?php  } else { ?>
                  <a href="<?=base_url('report/Report/frequency_details_section?sid=')?><?=$_GET['sid']?>&year=<?=$_GET['year']?>&month=<?=$_GET['month']?>" style="font-size: small;">Frequncy Of Spares</a>
                  <?php } ?>
                </th>
                <th></th>
                <th>Section Total Amount =</th>
                <th>
                  <input type="text" name="section_total" id="section_total" class="form-control" style="width: 100px;" readonly=""/>
                </th>
                <th></th>
                <th></th>
                <th></th>
              </tbody>
              </thead>
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Date</th>
                  <th>Parts & Supplies Name</th>
                  <th>Type</th>
                  <th>Shift</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Parts & Supplies Amount</th>
                  <th>Labor Cost</th>
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
                  <td></td>
                  <td></td>
                </tr>
                <?php

                if($_GET['filter'] == 'filter')
                {

                  $qry="select * from tbl_software_cost_log where section_id='".$_GET['sid']."' AND log_type!='Labour' AND machine_id='' ";


                    if($_GET['from_date'] && $_GET['to_date'] != '') 
                    {
                        
                      /*$t_date = explode("-", $_GET['to_date']);
                      $f_date = explode("-", $_GET['from_date']);
                      $t_date1 = $t_date[0] . "-" . $t_date[1] . "-" . $t_date[2];
                      $f_date1 = $f_date[0] . "-" . $f_date[1] . "-" . $f_date[2];*/
                      $qry .= " AND log_date >='".$_GET['from_date']."' and log_date <='".$_GET['to_date']."'";
                    }

                    if($_GET['from_date'] == '' && $_GET['to_date'] == '' && ($_GET['spare_type'] != '' || $_GET['spare_id'] != ''))
                    {
                      
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

                      $qry .=" AND EXTRACT(MONTH FROM log_date)='".$_GET['month']."' AND EXTRACT(YEAR FROM log_date)='".$_GET['year']."' ";
                    }


                    if($_GET['from_date'] != '' && $_GET['to_date'] != '' && ($_GET['spare_type'] != '' || $_GET['spare_id'] != ''))
                    {
                      
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

                    }

                    $qry .= " ORDER BY log_date ASC";

                  $sftcostlog=$this->db->query($qry);

                }
                else
                {
                  
                  $qry="select * from tbl_software_cost_log where section_id='".$_GET['sid']."' AND log_type!='Labour' AND machine_id='' AND EXTRACT(MONTH FROM log_date)='".$_GET['month']."' AND EXTRACT(YEAR FROM log_date)='".$_GET['year']."' ";

                  $qry .= " ORDER BY log_date ASC";

                  $sftcostlog=$this->db->query($qry);

                }
                  
                  $count=$sftcostlog->num_rows();
                  if($count > 0)
                  {
                  	$count=$count;
                  
                  $z=1;
                  $i=0;
                  foreach($sftcostlog->result() as $fetch_list) {
                  ?>
                <tr class="gradeC record">
                  <th><?php echo $z++; ?></th>
                  <th><?php echo $fetch_list->log_date; ?></th>
                  <th>
                    <?php
                      $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->product_id'");
                      $getPrd=$prd->row();
                      echo $getPrd->productname; ?>
                  </th>
                  <th><?php 
                    $mst=$this->db->query("select * from tbl_master_data where serial_number='$getPrd->type_of_spare'");
                    $getKey=$mst->row();
                    echo $getKey->keyvalue; ?>                    
                  </th>
                  <th><?=$fetch_list->shift;?></th>
                  <th><?php echo $fetch_list->price ;?></th>
                  <th><?php echo $fetch_list->qty; ?></th>
                  <th><?php echo $totalprice=(int)$fetch_list->qty * (int)$fetch_list->price; ?></th>
                  <?php 
                    $lbr=$this->db->query("select *,SUM(total_spent) as labourcost from tbl_software_cost_log where log_type='Labour' AND section_id='".$_GET['sid']."' AND EXTRACT(MONTH FROM log_date)='".$_GET['month']."' AND EXTRACT(YEAR FROM log_date)='".$_GET['year']."' ");
                    $getLbr=$lbr->row();
                    
                    if($i == 0)
                    { ?>
                  <th rowspan="<?=$count?>">
                    <div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
                      <?php echo $cost=$getLbr->labourcost; ?>
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
                  <th colspan="7"></th>
                  <?php 
                    $lbr=$this->db->query("select *,SUM(total_spent) as labourcost from tbl_software_cost_log where log_type='Labour' AND section_id='".$_GET['sid']."' AND EXTRACT(MONTH FROM log_date)='".$_GET['month']."' AND EXTRACT(YEAR FROM log_date)='".$_GET['year']."' ");
                    $getLbr=$lbr->row();
                    
                    if($i == 0)
                    { ?>
                  <th rowspan="<?=$count?>">
                    <div style="text-align: center;margin: <?php echo $count * 10;?>px 0px 0px 0px;">
                      <?php echo $cost=$getLbr->labourcost; ?>
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
                  
                  }
                  ?>
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
    </div>
  </div>
</div>
<?php
  $this->load->view("footer.php");
  ?>
<script type="text/javascript">
  var id1=document.getElementById("totalprice").value;
  document.getElementById("section_total").value = id1;
  
</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">

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
    location.href="<?=base_url('/report/Report/comparison_section_spares?sid=');?><?=$_GET['sid']?>&year=<?=$_GET['year']?>&month=<?=$_GET['month']?>";
  }

 window.onload = function() {
      getSpareList(<?=$_GET['spare_type']?>);
  };
</script>