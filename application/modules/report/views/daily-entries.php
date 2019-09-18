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
?>

<div class="row">
<div class="col-lg-12">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <h4 class="panel-title">DAILY ENTRIES REPORT (<?=$crDate=date('Y-m-d');?>)</h4>
      <ul class="panel-tool-options">
        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
      </ul>
    </div>
    <div class="panel-body panel-center">
      <form class="form-horizontal" method="get" action="">
        <div class="form-group">
          <label class="col-sm-2 control-label">From Date</label> 
          <div class="col-sm-3"> 
            <input type="date" name="f_date" class="form-control" value="<?php echo $_GET['f_date']; ?>" /> 
          </div>
          <label class="col-sm-2 control-label">To Date</label> 
          <div class="col-sm-3"> 
            <input type="date" name="t_date" class="form-control" value="<?php echo $_GET['t_date']; ?>" /> 
          </div>
        </div>
        <div class="form-group panel-body-to" style="padding: 0px 14px 0px 0px">
          <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
          <button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" >
            <span>Search</span>
        </div>
    </div>
    </form>
    <div class="row">
    <div class="col-sm-12">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="html5buttons">
    <div class="dt-buttons">
    <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('tblData')">Excel</button>  &nbsp;&nbsp;
    </div>
    </div>
    <div class="dataTables_length" id="DataTables_Table_0_length">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Show<label>
    <select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/daily_entries_report?<?='f_date='.$_GET['f_date'].'&t_date='.$_GET['t_date'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
    <option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
    <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
    <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
    <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
    <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
    <option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
    <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
    </select>
    entries</label>
    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -5px;margin-left: 12px;float: right;">
    Showing <?=$dataConfig['page']+1;?> to 
    <?php
      $m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
      echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
      ?> of <?=$dataConfig['total'];?> entries
    </div>
    </div>
    <div id="DataTables_Table_0_filter" class="dataTables_filter">
    <label>Search:
    <input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
    </label>
    </div>
    </div>
    </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example1" id="tblData">
          <thead>
            <tr>
              <th>S. No.</th>
              <th>Date</th>
              <th>Type</th>
              <th>Log Id</th>
            </tr>
          </thead>
          <tbody id="getDataTable" >
            <tr style="display: none;">
              <td></td>
              <td></td>
              <td></td>
              <td></td>         
            </tr>
            <?php 
              $i=1;
              foreach($result as $fetch) { ?>
            <tr class="gradeC record">
              <th><?php echo $i++;  ?></th>
              <th><?php echo $fetch->maker_date; ?></th>
              <th><?php echo $fetch->log_type;  ?></th>
              <th><?php echo $fetch->log_id; ?></th>

            </tr>
            <?php  }  ?>
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
<script>
  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/daily_entries_report');?>";
  }
</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>