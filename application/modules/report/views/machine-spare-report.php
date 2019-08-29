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
      <h4 class="panel-title">MACHINE TO SPARE REPORT</h4>
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
              <option value="<?=$getSql->id?>"><?=$getSql->name?></option>
              <?php } ?>
            </select>
          </div>
          <label class="col-sm-2 control-label" style="display: none;">Machine</label> 
          <div class="col-sm-3" style="display: none;">
            <select name="machineid" id="machineid" class="select2 form-control">
              <option value="">----Machine----</option>
            </select>
          </div>
          <div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px">
            <button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
            <button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" >
              <span>Search</span>
          </div>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col-sm-12">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="html5buttons">
    <div class="dt-buttons">
    <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button> &nbsp;&nbsp; 
    </div>
    </div>
    <div class="dataTables_length" id="DataTables_Table_0_length">
    <label>&nbsp; &nbsp;&nbsp; &nbsp;Show
    <select name="DataTables_Table_0_length" url="<?=base_url();?>report/Report/machine_spare_report?<?='m_type='.$_GET['m_type'].'&machineid='.$_GET['machineid'].'&filter='.$_GET['filter'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
        <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
          <thead>
            <tr>
              <th>S. No.</th>
              <th>Section</th>
              <th>Total Machine</th>
            </tr>
          </thead>
          <tbody id="getDataTable" >
            <?php
              $z=1;
              foreach($result as $fetch) 
              {
              
              $machine=$this->db->query("select COUNT(machine_name) as totalmachine from tbl_machine where m_type='$fetch->id' ");
              $getMachine=$machine->row();
              ?>
            <tr class="gradeC record">
              <th><?php echo $z++; ?></th>
              <th><a target="_blannk" href="<?=base_url();?>report/Report/machine__spare_details?id=<?=$fetch->id?>"><?php echo $fetch->name; ?></a></th>
              <th><?php echo $getMachine->totalmachine; ?></th>
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
<script>
  function exportTableToExcel(tableID, filename = ''){
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'Machine Report<?php echo date('d-m-Y');?>.xls';
     
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
    location.href="<?=base_url('/report/Report/machine_spare_report');?>";
  }
  
</script>
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>
<script type="text/javascript">
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