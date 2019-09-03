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
      <h4 class="panel-title">FREQUENCY OF SPARES SECTION (<?php echo $getWO->name; ?>) </h4>
      <a href="<?=base_url();?>report/Report/comparison_section_spares?sid=<?=$_GET['sid']?>&year=<?=$_GET['year']?>&month=<?=$_GET['month']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example1"  >
          <thead>
            <tr>
              <th>S. No.</th>
              <th>Parts & Supplies Name</th>
              <th>Frequency Count</th>
            </tr>
          </thead>
          <tbody id="getDataTable" >
            <?php
              if($_GET['filter'] == 'filter') 
              {

                $qry ="select *,COUNT(product_id) as frequncyofspares from tbl_software_cost_log where section_id='".$_GET['sid']."' AND machine_id='' AND log_type!='Labour'";
                
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

                $qry .= " GROUP BY product_id";

                $sftcostlog=$this->db->query($qry);
                
              }
              else
              {

                $qry="select *,COUNT(product_id) as frequncyofspares from tbl_software_cost_log where section_id='".$_GET['sid']."' AND machine_id='' AND log_type!='Labour' AND EXTRACT(MONTH FROM log_date)='".$_GET['month']."' AND EXTRACT(YEAR FROM log_date)='".$_GET['year']."' GROUP BY product_id";  
                 
                $sftcostlog=$this->db->query($qry);                   
                    
              }
              
              $count=$sftcostlog->num_rows();
              $z=1;
              foreach($sftcostlog->result() as $fetch_list) {
              ?>
            <tr class="gradeC record">
              <th><?php echo $z++; ?></th>
              <th>
                <?php
                  $prd=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->product_id'");
                  $getPrd=$prd->row();
                  echo $getPrd->productname; ?>
              </th>
              <th><?php echo $fetch_list->frequncyofspares ;?></th>
              <?php } ?>
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
  document.getElementById("section_total").value = id1;
  
</script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">