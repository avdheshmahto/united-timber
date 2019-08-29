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
      <h4 class="panel-title">BREAKDOWN WORKORDER REPORT </h4>
      <ul class="panel-tool-options">
        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
      </ul>
    </div>
    <div class="panel-body panel-center">
      <form class="form-horizontal" method="get" action="">
        <div class="form-group panel-body-to">
          <label class="col-sm-2 control-label">Section</label> 
          <div class="col-sm-3">
            <select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);" required="">
              <option value="0" class="listClass">------Section-----</option>
              <?php
                $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                foreach($sql->result() as $getSql) { ?>
              <option value="<?=$getSql->id?>" <?php if($getSql->id == $_GET['m_type']) { ?> selected <?php } ?> ><?=$getSql->name?></option>
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
          <button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" >
            <span>Search</span>
        </div>
      </form>
    </div>
    </form>
    <div class="row">
    <div class="col-sm-12">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="html5buttons">
    <div class="dt-buttons">
    <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button> &nbsp; &nbsp;
    </div>
    </div>
    <div class="dataTables_length" id="DataTables_Table_0_length">&nbsp; &nbsp;Show<label>
    <select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/breakdown_report?<?='&n_o_breakdown='.$_GET['n_o_breakdown'].'&o_name='.$_GET['o_name'].'&f_date='.$_GET['f_date'].'&t_date='.$_GET['t_date'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
    <option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
    <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
    <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
    <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
    <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
    <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>
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
        <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
          <thead>
            <tr>
              <th>Breakdown Code</th>
              <th>Nature of breakdown </th>
              <th>BreakDown Time</th>
              <th>Machine Name</th>
              <th>Section</th>
              <th>Operator Name</th>
              <th>Breakdown Hours</th>
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
            </tr>
            <?php
              foreach($result as $fetch_list)
              {
              ?>
            <tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
              <th><?=$fetch_list->code ?></th>
              <th>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->nature_of_breakdown."'");
                  $compRow = $sqlunit->row();
                  echo $compRow->keyvalue; ?>
              </th>
              <th><?php echo $fetch_list->break_time; ?></th>
              <th>
                <?php 
                  $machineQuery = $this ->db->query("select * from tbl_machine where id='".$fetch_list->machine_id."'");
                  $getMachine = $machineQuery->row();
                  echo $getMachine->machine_name; ?>
              </th>
              <th>
                <?php 
                  $sqlunits=$this->db->query("select * from tbl_category where id='".$fetch_list->section."'");
                  $compRows = $sqlunits->row();
                  echo $compRows->name;  ?>
              </th>
              <th>
                <?php 
                  $cont = $this ->db->query("select * from tbl_contact_m where contact_id='".$fetch_list->operator_id."'");
                  $getCnt = $cont->row();
                  echo $getCnt->first_name; ?>
              </th>
              <th><?php     
                $time1 = $fetch_list->start_time;
                $time2 = $fetch_list->end_time;
                
                $diff = abs(strtotime($time1) - strtotime($time2));
                
                $tmins = $diff/60;
                
                $hours = floor($tmins/60);
                
                $mins = $tmins%60;
                
                
                echo "<b>$hours</b> Hours | <b>$mins</b> Minutes</b>";
                
                ?>  </th>
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
  function exportTableToExcel(tableID, filename = ''){
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'BREAKDOWN REPORT <?php echo date('d-m-Y');?>.xls';
     
     // Create download link element
     downloadLink = document.createElement("a");
     
     document.body.appendChild(downloadLink);
     
     if(navigator.msSaveOrOpenBlob){
         var blob = new Blob(['\ufeff', tableHTML], {
             type: dataType
         });
         navigator.msSaveOrOpenBlob( blob, filename);
     }else{
  
         // Create a link to the file
         downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
     
         // Setting the file name
         downloadLink.download = filename;
         
         //triggering the function
         downloadLink.click();
     }
  }
  
  function ResetLead()
  {
    location.href="<?=base_url('/report/Report/breakdown_report');?>";
  }
  
</script>
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>/assets/daterangepicker/daterangepicker.css">
<script type="text/javascript">
  window.onload=function(){
    getmachinelist(<?=$_GET['m_type']?>);
  };
  
  function getmachinelist(v)
  {
  
    ur="<?=base_url();?>report/Report/get_machine_list";
    //alert(v);
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