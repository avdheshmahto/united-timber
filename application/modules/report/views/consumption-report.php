<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">
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
  
  $ps=$this->db->query("select * from tbl_product_stock where Product_id='".$_GET['sid']."'");
  $getPs=$ps->row();
  ?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h4 class="panel-title">CONSUMPTION REPORT (<?=$getPs->productname?>) </h4>
        <a href="<?=base_url();?>report/Report/searchStock?tid=<?=$_GET['tid']?>" class="btn  btn-sm pull-right" type="button"><i class="icon-left-bold"></i> back</a>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
            <thead>
              <tr>
                <th>Date</th>
                <th>Vendor</th>
                <th>Type</th>
                <th colspan="2" class="text-center">Inwards</th>
                <th colspan="2" class="text-center">Outwards</th>
                <th colspan="2" class="text-center">Closing</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th class="blank_right text-center">Quantity</th>
                <th class="blank_left text-center">Amount</th>
                <th class="blank_right text-center">Quantity</th>
                <th class="blank_left text-center">Amount</th>
                <th class="blank_right text-center">Quantity</th>
                <th class="blank_left text-center">Amount</th>
              </tr>
            </thead>
            <tbody id="getDataTable" >
              <?php 
                $prd=$this->db->query("select *,SUM(quantity) as totalQty from tbl_product_serial_log where product_id='".$_GET['sid']."' AND name_role='product opening stock' "); 
                $getPrd=$prd->row();
                $vndr333=$this->db->query("select * from tbl_contact_m where contact_id='$getPrd->supp_name' ");
                $getVndr22=$vndr333->row();
                ?>
              <tr>
                <td><?php 
                  $abc=explode(" ", $getPrd->maker_date);
                  echo $abc[0];?></td>
                <th><?php echo $getVndr22->first_name;?></th>
                <th>Opening Stock</th>
                <td class="blank_right text-center"><?php echo $getPrd->totalQty; ?></td>
                <th class="blank_left text-center"><?php echo $getPrd->totalQty * $getPrd->purchase_price; ?></th>
                <th colspan="2"></th>
                <td class="blank_right text-center"><?php echo $opQty=$getPrd->totalQty; ?></td>
                <th class="blank_left text-center"><?php echo $oPrc=$getPrd->totalQty * $getPrd->purchase_price; ?></th>
              </tr>
              <?php
                $i=1;
                $data=$this->db->query("select * from tbl_software_stock_log where product_id='".$_GET['sid']."' ");
                foreach($data->result() as $fetch) { ?>
              <tr class="gradeC record">
                <td><?php 
                  $sftCstLog=$this->db->query("select * from tbl_software_cost_log where log_id='$fetch->log_id' AND product_id='$fetch->product_id'");
                  $getLogDate=$sftCstLog->row();
                  echo $getLogDate->log_date; ?></td>
                <th><?php 
                  $vndr=$this->db->query("select * from tbl_contact_m where contact_id='$fetch->vendor_id' ");
                  $getVndr=$vndr->row();
                  echo $getVndr->first_name; ?></th>
                <th><?php 
                  if($fetch->log_type == 'Receipt') { ?>
                  <a href="<?=base_url()?>bincard/binCard/edit_bin_card?id=<?=$fetch->log_id?>" target="_blank"><?php echo $fetch->log_type."(".$fetch->log_id.")"; ?></a>
                  <?php }elseif($fetch->log_type == 'Return') { ?>
                  <a href="<?=base_url()?>return/spareReturn/edit_spare_return?id=<?=$fetch->log_id?>" target="_blank"><?php echo $fetch->log_type."(".$fetch->log_id.")"; ?></a>
                  <?php }elseif($fetch->log_type == 'Parts & Supplies Issue') { 
                    $wo=$this->db->query("select * from tbl_spare_issue_hdr where issue_id='$fetch->log_id'");
                    $getWo=$wo->row();
                    $wrkordrID=$getWo->workorder_id;
                    ?>
                  <a href="<?=base_url()?>issue/SpareIssue/add_spare_issue?id=<?=$wrkordrID?>" target="_blank"><?php echo $fetch->log_type."(WO".$wrkordrID.")"; ?></a>
                  <?php }elseif($fetch->log_type == 'Consumable Issue') { ?>
                  <a href="<?=base_url()?>issue/ConsumIssue/view_consumable_issue?id=<?=$fetch->log_id?>" target="_blank"><?php echo $fetch->log_type."(".$fetch->log_id.")"; ?></a>
                  <?php }elseif ($fetch->log_type == 'Tools Issue') {?> 
                  <a href="<?=base_url()?>issue/ToolsIssue/view_parts_issue?id=<?=$fetch->log_id?>" target="_blank"><?php echo $fetch->log_type."(".$fetch->log_id.")"; ?></a>	
                  <?php }elseif ($fetch->log_type == 'Tools Return') { 
                    $issuehdr=$this->db->query("select * from tbl_tools_return_hdr where return_id='$fetch->log_id'");
                    $getHdr=$issuehdr->row();
                    $issueId=$getHdr->issue_id;
                    ?> 
                  <a href="<?=base_url()?>issue/ToolsIssue/view_parts_issue?id=<?=$issueId?>" target="_blank"><?php echo $fetch->log_type."(".$issueId.")"; ?></a>	
                  <?php } ?>
                </th>
                <?php 
                  if($fetch->log_type == 'Receipt' || $fetch->log_type == 'Tools Return') { ?>
                <td class="blank_right text-center"><?php echo $innnQttty=$fetch->qty; ?></td>
                <th class="blank_left text-center"><?php echo $innPrrrc=$fetch->total_price; ?></th>
                <td class="blank_right text-center"></td>
                <th class="blank_left text-center"></th>
                <?php 
                  $sum1+=$innnQttty;
                  $sum2+=$innPrrrc;
                  ?>
                <?php if($i==1){ ?>
                <td class="blank_right text-center"><?php echo $inQty=$opQty + $fetch->qty; ?></td>
                <th class="blank_left text-center"><?php echo $inPric=$oPrc + $fetch->total_price; ?></th>
                <?php } else { ?>
                <td class="blank_right text-center"><?php echo $inQty=$inQty + $fetch->qty; ?></td>
                <th class="blank_left text-center"><?php echo $inPric=$inPric + $fetch->total_price; ?></th>
                <?php } ?>
                <?php } ?>
                <?php 
                  if($fetch->log_type == 'Parts & Supplies Issue' || $fetch->log_type == 'Tools Issue' || $fetch->log_type == 'Consumable Issue' || $fetch->log_type == 'Return') { ?>
                <td class="blank_right text-center"></td>
                <th class="blank_left text-center"></th>
                <td class="blank_right text-center"><?php echo $outQttty=$fetch->qty; ?></td>
                <th class="blank_left text-center"><?php echo $outPrrrc=$fetch->total_price; ?></th>
                <?php 
                  $sum3+=$outQttty;
                  $sum4+=$outPrrrc;
                  ?>
                <?php if($i==1){ ?>
                <td class="blank_right text-center"><?php echo $inQty=$opQty - $fetch->qty; ?></td>
                <th class="blank_left text-center"><?php echo $inPric=$oPrc - $fetch->total_price; ?></th>
                <?php } else { ?>
                <td class="blank_right text-center"><?php echo $inQty=$inQty - $fetch->qty; ?></td>
                <th class="blank_left text-center"><?php echo $inPric=$inPric - $fetch->total_price; ?></th>
                <?php } ?>
                <?php } ?>
              </tr>
              <?php $i++; } 
                $sum1=$sum1+$opQty;
                $sum2=$sum2+$oPrc;
                $sum5=$inQty;
                $sum6=$inPric;
                 ?>
              <tr>
                <th colspan="3" class="text-center">Totals :</th>
                <td class="blank_right text-center"><?php echo $sum1; ?></td>
                <th class="blank_left text-center"><?php echo $sum2; ?></th>
                <td class="blank_right text-center"><?php echo $sum3; ?></td>
                <th class="blank_left text-center"><?php echo $sum4; ?></th>
                <td class="blank_right text-center"><?php echo $sum5; ?></td>
                <th class="blank_left text-center"><?php echo $sum6; ?></th>
              </tr>
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
  </div>
</div>
<?php
  $this->load->view("footer.php");
  ?>
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>