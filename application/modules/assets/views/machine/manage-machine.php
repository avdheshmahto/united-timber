<link rel="stylesheet" href="<?php echo base_url();?>assets/css/vendor/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/chosen/chosen.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
<link rel="stylesheet" href="<?=base_url();?>assets/tooltips/main.css">
<?php
  $this->load->view("header.php");
  
  if($this->input->get('entries')!="")
  {
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
  <form class="form-horizontal" role="form" >
    <div id="editItem" class="modal fade modal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-contentitem" id="modal-contentitem">
        </div>
      </div>
    </div>
  </form>
  <div class="panel-default">
    <form class="form-horizontal" role="form" method="post" id="formMachine" action="insert_machine">
      <ol class="breadcrumb breadcrumb-2">
        <li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
        <li><a href="#">Assets</a></li>
        <li class="active"><strong>Manage Machine</strong></li>
        <div class="pull-right">
          <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#Machinemodal" formid="#formMachine" id="formreset" title="Add Machine" >Add Machine</button>
          <div id="Machinemodal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content" >
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Add Machine</h4>
                  <div id="resultareamachine" class="text-center " style="font-size: 15px;color: red;"></div>
                </div>
                <div class="modal-body overflow">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">*Code:</label> 
                    <div class="col-sm-4"> 
                      <input type="hidden" id="id" name="id" value="" />
                      <input type="text" class="form-control" name="code" id="code" onkeyup="checkMachineCode(this.value);"> 
                      <span class="c-validation c-error" style="text-align:center; color:#F00" id="codemsg"></span>
                    </div>
                    <label class="col-sm-2 control-label">*Section:</label> 
                    <div class="col-sm-4">
                      <select name="m_type" required class="select2 form-control" id="m_type" style="width:100%;">
                        <option value="0" class="listClass">-----Section-----</option>
                        <?php
                          $sql=$this->db->query("select * from tbl_category where inside_cat='0'");
                          foreach($sql->result() as $getSql) {
                          //foreach ($categorySelectbox as $key => $dt) { ?>
                        <!-- <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option> -->
                        <option value="<?php echo $getSql->id;?>"><?php echo $getSql->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">*Machine Name:</label> 
                    <div class="col-sm-4"> 
                      <input name="machine_name"  type="text" id="machine_name" class="form-control" required> 
                    </div>
                    <label class="col-sm-2 control-label">*Capacity:</label> 
                    <div class="col-sm-4"> 
                      <input type="text" id="capacity" name="capacity" class="form-control"  />          
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">*Metering Unit:</label> 
                    <div class="col-sm-4">
                      <select name="m_unit" required class="select2 form-control" id="m_unit" style="width:100%;">
                        <option value="" >----Select----</option>
                        <?php 
                          $sqlunit=$this->db->query("select * from tbl_master_data where param_id = '28' and status='A'");
                          foreach ($sqlunit->result() as $fetchunit){
                          ?>
                        <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">*Machine Description:</label> 
                    <div class="col-sm-4"> 
                      <textarea name="machine_des" class="form-control" id="machine_des"></textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" id="saveButton" onclick="saveData()" class="btn btn-sm"  >Save</button>
                  <span id="saveload" style="display: none;">
                  <img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
                  </span>
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
      <div class="col-lg-12">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
          <div class="row">
            <div class="col-sm-12" id="listingData">
              <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="html5buttons">
                  <div class="dt-buttons">
                    <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
                  </div>
                </div>
                <div class="dataTables_length" id="DataTables_Table_0_length">
                  <label>
                    Show
                    <select name="DataTables_Table_0_length" url="<?=base_url();?>assets/machine/manage_machine?" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
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
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
                    <thead>
                      <tr>
                        <th>Code</th>
                        <th>Section</th>
                        <th>Machine Name</th>
                        <th>Machine Description</th>
                        <th>Capacity</th>
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
                      </tr>
                      <?php  
                        /*echo "<pre>";
                        print_r($result);
                        echo "</pre>";*/
                        
                        $i=1;
                        foreach($result as $fetch_list)
                        {
                        ?>
                      <tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
                        <th><?php echo $fetch_list->code; ?></th>
                        <th><?php 
                          $sqlunit=$this->db->query("select * from tbl_category where id='".$fetch_list->m_type."'");
                          $compRow = $sqlunit->row();
                          echo $compRow->name;
                          ?></th>
                        <th><a href="<?=base_url();?>assets/machine/manage_spare_map?id=<?php echo $fetch_list->id; ?>" title="Machine Spare Details"><?=$fetch_list->machine_name;?></a></th>
                        <th>
                          <div class="tooltip-col">
                            <?php 
                              $big = $fetch_list->machine_des;  
                              $big = strip_tags($big);
                              $small = substr($big, 0, 20);
                              echo strtolower($small ."....."); ?>
                            <span class="tooltiptext3"><?=$big;?> </span>
                          </div>
                        </th>
                        <th><?=$fetch_list->capacity;?></th>
                        <th class="bs-example">
                          <div style="width: 110px;">
                            <?php if($view!=''){ ?>
                            <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Machine"> <i class="fa fa-eye"></i> </button>
                            <?php } if($edit!=''){ ?>
                            <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Machine"><i class="icon-pencil"></i></button>
                            <?php }
                              $pri_col='id';
                              $table_name='tbl_machine';
                              
                              $stfCostLog=$this->db->query("select * from tbl_software_cost_log where machine_id='".$fetch_list->id."' ");
                              $numCost=$stfCostLog->num_rows();
                              
                              $sftStkLog=$this->db->query("select * from tbl_work_order_maintain where machine_name='".$fetch_list->id."' ");
                              $numStk=$sftStkLog->num_rows();
                              
                              $countRows=$numCost + $numStk;
                              
                              if($countRows > 0 ) {  ?>
                            <button class="btn btn-default" type="button" title="Delete Machine" onclick="return confirm('Machine already map. You can not delete ?');"><i class="icon-trash"></i></button>
                            <?php } else { ?>
                            <button class="btn btn-default delbutton_machine" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Machine"><i class="icon-trash"></i></button>		
                            <?php  } ?>
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
  function getEditItem(v,button_type)
  {
  
   var pro=v;
   var xhttp = new XMLHttpRequest();
   xhttp.open("GET", "getMachinePage?ID="+pro+"&type="+button_type, false);
   xhttp.send();
  
   document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
  
  } 	
  
  
  function getSpareMap(v)
  {
  
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
<script type="text/javascript">
  function saveData()
  {
  	
      var code         = document.getElementById("code").value;
  	var id           = document.getElementById("id").value;
  	var machine_name = document.getElementById("machine_name").value;
  	var machine_des  = document.getElementById("machine_des").value;
  	var capacity     = document.getElementById("capacity").value;
  	var m_type       = document.getElementById("m_type").value;
  	var m_unit       = document.getElementById("m_unit").value;
  
  	$("#saveload").css("display","inline-block");
  	$("#saveButton").attr("type","button");
  	$("#saveButton").css("display","none");
  
  	if(code=='')
  	{
  	  document.getElementById("codemsg").innerHTML = "Please Enter Code";
  	  return false;
  	}
  
  	var xhttp = new XMLHttpRequest();
  	xhttp.open("GET", "insert_machine?id="+id+"&code="+code+"&machine_name="+machine_name+"&machine_des="+machine_des+"&capacity="+capacity+"&m_type="+m_type+"&m_unit="+m_unit, false);
  	xhttp.send();
  
  	document.getElementById("resultareamachine").innerHTML="Added Successfully";
  	setTimeout(function() {
  	$("#Machinemodal .close").click();
  	document.getElementById("resultareamachine").innerHTML="";	
  	 document.getElementById("code").value='';
  	 document.getElementById("id").value='';
  	 document.getElementById("machine_name").value='';
  	 document.getElementById("machine_des").value='';
  	 document.getElementById("capacity").value='';
  	 document.getElementById("m_type").value='';
  	 document.getElementById("m_unit").value=''; 
  
  	  $("#saveload").css("display","none");
  	  $("#saveButton").css("display","inline-block");
  	  $("#saveButton").attr("type","submit")
  
  	}, 1500 );	
  	
    window.location.reload();   
    
  	// document.getElementById("loadData").innerHTML = xhttp.responseText;
  	// document.getElementById("code").value='';
  	
  }
  
  function editData()
  {
  	
      var code         = document.getElementById("editcode").value;
  	var id           = document.getElementById("editid").value;
  	var machine_name = document.getElementById("editmachine_name").value;
  	var machine_des  = document.getElementById("editmachine_des").value;
  	var capacity     = document.getElementById("editcapacity").value;
  	var m_type       = document.getElementById("editm_type").value;
  	var m_unit       = document.getElementById("m_unit").value;
  
  	$("#saveload").css("display","inline-block");
  	$("#editButton").attr("type","button");
  	$("#editButton").css("display","none");
  	
  	if(code=='')
  	{
  	  document.getElementById("codemsg").innerHTML = "Please Enter Code";
  	  return false;
  	}
  
  	var xhttp = new XMLHttpRequest();
  	xhttp.open("GET", "insert_machine?id="+id+"&code="+code+"&machine_name="+machine_name+"&machine_des="+machine_des+"&capacity="+capacity+"&m_type="+m_type+"&m_unit="+m_unit, false);
  	xhttp.send();
  
  	document.getElementById("mssg100").innerHTML="Updated Successfully";
  	setTimeout(function(){
  	$("#editItem .close").click();	
  
  	$("#saveload").css("display","none");
  	$("#editButton").css("display","inline-block");
  	$("#editButton").attr("type","submit")  
  
  	},1000);
  	
    window.location.reload();   
  	// document.getElementById("loadData").innerHTML = xhttp.responseText;
  	// document.getElementById("code").value='';
  	// document.getElementById("id").value='';
  	
  }
  
</script>
<script type="text/javascript">
  function checkMachineCode(v)
  {
  $.ajax({
  
  	url  : "<?=base_url()?>assets/machine/check_machine_code",
  	type : "POST",
  	data : {'id' : v},
  	success:function(data)
  	{
  		if(data == 1)
  		{
  			$("#codemsg").html("Code Aleready Exists");
  			$("#saveButton").attr("disabled",true);
  		}
  		else
  		{
  			$("#codemsg").html("");
  			$("#saveButton").removeAttr("disabled",false);	
  		}
  	}
  
    });
  
  }
  
</script>
<script>
  function exportTableToExcel(tableID, filename = '')
  {
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'Manage Machine <?php echo date('d-m-Y');?>.xls';
     
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
  
</script>
<script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>
<script src="<?php echo base_url();?>assets/js/vendor/jRespond/jRespond.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vendor/animsition/js/jquery.animsition.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vendor/chosen/chosen.jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>
<script type="text/javascript">
  function exportTableToExcel(tableID, filename = '')
  {
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'Machine <?php echo date('d-m-Y');?>.xls';
     
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
</script>