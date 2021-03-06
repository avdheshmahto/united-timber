<?php
  $this->load->view("header.php");
  if($this->input->get('entries')!=""){
    $entries = $this->input->get('entries');
  }
  ?>
<style type="text/css">
  .select2-container--open {
  z-index: 99999999 !important;
  }
  .select2-container {
  min-width: 256px !important;
  }
</style>
<!-- Main content -->
<div class="main-content">
  <form class="form-horizontal" role="form"  enctype="multipart/form-data">
    <div id="editItem" class="modal fade modal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-contentitem" id="modal-contentitem">
        </div>
      </div>
    </div>
  </form>
  <div class="panel-default">
    <form class="form-horizontal" role="form" method="post" action="insert_schedule">
      <ol class="breadcrumb breadcrumb-2">
        <li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
        <li><a href="#">Maintenance</a></li>
        <li class="active"><strong>Manage Schedule</strong></li>
        <div class="pull-right">
          <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modal-0" >Add Schedule</button>
          <div id="modal-0" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content" >
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Add Schedule</h4>
                  <div id="resultareaschedule" class="text-center " style="font-size: 15px;color: red;"></div>
                </div>
                <div class="modal-body overflow">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">*Code:</label> 
                    <div class="col-sm-4"> 
                      <input type="hidden" id="id" name="id" value="" />
                      <input type="text" class="form-control" name="code" id="code" > 
                      <span class="c-validation c-error" style="text-align:center; color:#F00" id="codemsg"></span>
                    </div>
                    <label class="col-sm-2 control-label">*Section:</label> 
                    <div class="col-sm-4">
                      <select name="m_type" required class="select2 form-control" id="m_type" onChange="getCat(this.id)" style="width:100%;">
                        <option value="0" class="listClass">----------------Select----------------</option>
                        <?php
                          $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                             foreach($sql->result() as $getSql) { ?>                        
                        <option value="<?php echo $getSql->id;?>"><?php echo $getSql->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">*Machine Name:</label> 
                    <div class="col-sm-4">
                      <select name="machine_name" id="machine_name" class="select2 form-control" style="width:100%;" >
                        <option value=""selected disabled>----Select ----</option>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">*Work Order Status:</label> 
                    <div class="col-sm-4">
                      <select name="wostatus" required class="select2 form-control" id="wostatus" style="width:100%;">
                        <option value="" >----Select----</option>
                        <?php 
                          $sqlunit=$this->db->query("select * from tbl_master_data where param_id='29'");
                          
                          foreach ($sqlunit->result() as $fetchunit){
                          ?>
                        <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">*Priority:</label> 
                    <div class="col-sm-4">
                      <select name="priority" required class="select2 form-control" id="priority" style="width:100%;">
                        <option value="" >----Select----</option>
                        <?php 
                          $sqlunit=$this->db->query("select * from tbl_master_data where param_id='27'");
                          
                          foreach ($sqlunit->result() as $fetchunit){
                          ?>
                        <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">*Maintenance Type:</label> 
                    <div class="col-sm-4">
                      <select name="maintyp" required class="select2 form-control" id="maintyp" style="width:100%;">
                        <option value="" >----Select----</option>
                        <?php 
                          $sqlunit=$this->db->query("select * from tbl_master_data where param_id='31'");
                          foreach ($sqlunit->result() as $fetchunit){
                          ?>
                        <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="saveData()" class="btn btn-sm code_aa"  >Save</button>
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        </div>
      </ol>
    </form>
    <div class="row">
      <div class="col-sm-12" id="listingData">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
          <div class="html5buttons">
            <div class="dt-buttons">
              <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')">Excel</button>
            </div>
          </div>
          <div class="dataTables_length" id="DataTables_Table_0_length">
            <label>
              Show
              <select name="DataTables_Table_0_length" url="<?=base_url();?>maintenance/schedule/manage_schedule?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
                <option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
                <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
                <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
                <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
                <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
                <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>
              </select>
              Entries
            </label>
            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -6px;margin-left: 12px;float: right;">
              Showing <?=$dataConfig['page']+1;?> to 
              <?php
                $m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
                echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
                ?> of <?=$dataConfig['total'];?> Entries
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
        <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
          <thead>
            <tr>
              <th>Schedule Code </th>
              <th>Section</th>
              <th>Machine Name</th>
              <th>Work Order Status</th>
              <th>Priority</th>
              <th>Maintenance Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id = "getDataTable">
            <tr style="display: none;">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php
              
              $i=1;
              foreach($result as $fetch_list)
              {
              ?>
            <tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
              <th><a href="<?=base_url();?>maintenance/schedule/manage_schedule_map?id=<?php echo $fetch_list->id; ?>"><?php echo "SM".$fetch_list->code; ?></a></th>
              <th><?php 
                $sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->m_type."'");
                $compRow = $sqlunit->row();
                echo $compRow->name;
                ?></th>
              <th><a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $fetch_list->machine_name; ?>" title="Machine Spare Details">
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_machine where id='".$fetch_list->machine_name."'");
                  $compRow = $sqlunit->row();
                  echo $compRow->machine_name;
                  	?>
                </a>
              </th>
              <th>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->wostatus."'");
                  $compRow = $sqlunit->row();
                  echo $compRow->keyvalue;
                  	?>
              </th>
              <th>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->priority."'");
                  $compRow = $sqlunit->row();
                  echo $compRow->keyvalue;
                  	?>
              </th>
              <th>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where serial_number='".$fetch_list->maintyp."'");
                  $compRow = $sqlunit->row();
                  echo $compRow->keyvalue;
                  	?>
              </th>
              <th class="bs-example">
                <?php if($view!=''){ ?>
                <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i> </button>
                <?php } if($edit!=''){ ?>
                <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="icon-pencil"></i></button>
                <?php }
                  $pri_col='id';
                  $table_name='tbl_schedule_maintain';
                  ?>
                <button style="display:none" class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>		
                <?php
                  ?>
                <button style="display:none" class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'>MAP SPARE</button>
              </th>
            </tr>
            <?php  } ?>
          </tbody>
        </table>
        <input type="text" style="display:none;" id="table_name" value="tbl_machine">  
        <input type="text" style="display:none;" id="pri_col" value="id">
      </div>
      <div class="row">
        <div class="col-md-12 text-right">
          <div class="col-md-6 text-left"> </div>
          <div class="col-md-6"> <?php echo $pagination; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  $this->load->view("footer.php");
  ?>
<script>
  function getEditItem(v,button_type){
   var pro=v;
   var xhttp = new XMLHttpRequest();
   xhttp.open("GET", "getSchedulePage?ID="+pro+"&type="+button_type, false);
   xhttp.send();
  
   document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
   } 	
  
  
  function getSpareMap(v){
    var pro=v;
    var xhttp = new XMLHttpRequest();
   
    xhttp.open("GET", "getSpare?ID="+pro, false);
    xhttp.send();
    document.getElementById("modal-contentMap").innerHTML = xhttp.responseText;
  
   } 	
  function showviatype(v)
  {
  //alert(v);
  	if(v==14){
  		document.getElementById("viatype").style.display="Block";
  	}else{
  		document.getElementById("viatype").style.display="none";
  	}
  }
  
  function showviatype11(v)
  {
  //alert(v);
  	if(v==14){
  		document.getElementById("viatypeeee").style.display="Block";
  
  	}else{
  		document.getElementById("viatypeeee").style.display="none";
  		document.getElementById("via_type").value='';
  
  	}
  }
</script>	
<SCRIPT language="javascript">
  function saveData()
  {
  	
    var code         = document.getElementById("code").value;
  	var id           = document.getElementById("id").value;
  	var machine_name = document.getElementById("machine_name").value;
  	var wostatus  = document.getElementById("wostatus").value;
  	var maintyp     = document.getElementById("maintyp").value;
  	var priority     = document.getElementById("priority").value;
  	var m_type       = document.getElementById("m_type").value;
  
    if(code=='')
    {
    
      document.getElementById("codemsg").innerHTML = "Please Enter Code";
      return false;

    }
  
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "insert_schedule?id="+id+"&code="+code+"&machine_name="+machine_name+"&priority="+priority+"&maintyp="+maintyp+"&m_type="+m_type+"&wostatus="+wostatus, false);
    xhttp.send();
  
  
    $("resultareaschedule").html("Schedule Added Successfully !");
    $("#modal-0 .close").click();	   

    // document.getElementById("loadData").innerHTML = xhttp.responseText;
    // document.getElementById("code").value='';
    window.location.reload();
  	
  	
  }
  
  function editData()
  {
  	
    //var code         = document.getElementById("code").value;
  	var id           = document.getElementById("id").value;
  	var code           = document.getElementById("code").value;
  	var machine_name = document.getElementById("machine_name").value;
  	var wostatus  = document.getElementById("wostatus").value;
  	var maintyp     = document.getElementById("maintyp").value;
  	var priority     = document.getElementById("priority").value;
  	var m_type       = document.getElementById("m_type").value;
  	
    if(wostatus=='')
    {
    
      document.getElementById("codemsg").innerHTML = "Please Enter Status";
      return false;

    }
  
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "insert_schedule?id="+id+"&code="+code+"&machine_name="+machine_name+"&priority="+priority+"&maintyp="+maintyp+"&m_type="+m_type+"&wostatus="+wostatus, false);
    xhttp.send();


    $("resultareaschedule").html("Schedule Updated Successfully !");
    $("#editItem .close").click();	   
  
    // document.getElementById("loadData").innerHTML = xhttp.responseText;
    // document.getElementById("code").value='';
    // document.getElementById("id").value='';
    window.location.reload();
  	
  	
  }
  
</SCRIPT>
<script>
  function exportTableToExcel(tableID, filename = ''){
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'Manage Schedule <?php echo date('d-m-Y');?>.xls';
     
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
  
  
  
  
  function getCat()
  {
  
  	var loc=document.getElementById("m_type").value;
  	var xhttp = new XMLHttpRequest();
  	xhttp.open("GET", "getcat?loc="+loc, false);
  	xhttp.send();
  	document.getElementById("machine_name").innerHTML = xhttp.responseText;
  
  }
  
  function getCatt()
  {
  
  	var loc=document.getElementById("m_type").value;
  	var xhttp = new XMLHttpRequest();
  	xhttp.open("GET", "getcatt?loc="+loc, false);
  	xhttp.send();
  	document.getElementById("machine_name").innerHTML = xhttp.responseText;
  
  }
  
  
  
  $(document).ready(function(){
  
  $("#code").keyup(function(){
  var datas=$("#code").val();
  
  		$.ajax({
  			
  			url  :"<?php echo base_url();?>maintenance/schedule/scheduleCode_validate",
  			type : "GET",
  			data : {"codeval":datas},
  			success:function(data){
  					
  				if(data>0)
  				{
  					
  					//alert(" Code Already Exist");
  					$("#codemsg").html("Code Already Exists");
  					$(".code_aa").attr("disabled", true);
  				}
  				else
  				{
  					$("#codemsg").html("");
  					$(".code_aa").attr("disabled", false);
  				}
  				
  			}
  			
  		});
  
  });
  
  
  
  });
  
</script>