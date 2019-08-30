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
  .msg{
  background: #CCF5CC;
</style>
<!-- Main content -->
<div class="main-content">
  <div class="panel-default">
    <form class="form-horizontal" role="form"  data-target="#Facilitymodal" id="facilityform">
      <div id="resultareafacility" class="text-center " style="font-size: 15px;color: red;"></div>
      <div id="editItem" class="modal fade modal" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-contentitem" id="modal-contentitem">
          </div>
        </div>
      </div>
    </form>
    <form class="form-horizontal" role="form" method="post" action="insert_facilities">
      <ol class="breadcrumb breadcrumb-2">
        <li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
        <li><a href="#">Assets</a></li>
        <li class="active"><strong>Add Facilities</strong></li>
        <span class="c-validation c-error" style="text-align:center; color:#F00;background-color:#CCF5CC " id="msg"></span>
        <div class="pull-right">
          <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#Facilitymodal" title="Add Facility" >Add Facilities</button>
          <div id="Facilitymodal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">
                  Add Facilities<span style="background-color: #F00;width: 100px;text-align: center;">
                  <h4>
                    <p id="msgadd" style="color: #F00;" >
                  </h4>
                  <h4>
                    <p id="msgadd" style="background-color: red;width: 100px;text-align: center;"> </p>
                  </h4>
                  <div id="resultareafacility" class="text-center " style="font-size: 15px;color: red;"></div>
                </div>
                <div class="modal-body overflow">
                  <div class="form-group">
                    <p id="mssg10011" style="background-color: red;width: 100px"></p>
                    <label class="col-sm-2 control-label">*Code:</label> 
                    <div class="col-sm-4">
                      <?php
                        $i=0;
                        $codess=array();
                        $query=("select * from tbl_facilities where status='A'");
                        $getQuery = $this->db->query($query);
                        
                        foreach ($getQuery->result() as $res) 
                        {
                        	$codess[$i]=$res->fac_code;
                        	$i++;
                        }
                        
                        $myJSON = json_encode($codess);
                        $countt=json_encode($i);
                        
                        ?> 
                      <input type="text" name="fac_code" id="fac_code" class="form-control" required> 
                      <input type="hidden" name="jsonvalue" id="jsonvalue" value="<?=$myJSON?>">
                      <input type="hidden" name="jsoncount" id="jsoncount" value="<?=$countt?>">
                      <span class="c-validation c-error" style="text-align:center; color:#F00" id="codee"></span>
                      <span id="err_unit1"></span>
                      <input type="hidden" id="id" name="id" value="" />
                    </div>
                    <label class="col-sm-2 control-label">*Name:</label> 
                    <div class="col-sm-4"> 
                      <input type="text" name="fac_name" id="fac_name" class="form-control" required />
                      <span class="c-validation c-error" style="text-align:center; color:#F00" id="namee"></span>
                      <span id="err_unit1"></span>         
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" style="display: none;">*Location:</label> 
                    <div class="col-sm-4" style="display: none;">
                      <select name="fac_loc" required class="select2 form-control" id="fac_loc" style="width:100%;">
                        <option value="" >----Select----</option>
                        <?php 
                          $sqlunit=$this->db->query("select * from tbl_master_data where param_id = 21 AND status='A'");
                          foreach ($sqlunit->result() as $fetchunit){
                          ?>
                        <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                        <?php } ?>
                      </select>
                      <span class="c-validation c-error" style="text-align:center; color:#F00" id="locee"></span>
                      <span id="err_unit1"></span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="saveData()" class="btn btn-sm savebutton"  >Save</button>
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="clearfunc();">Cancel</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
          <a href="#/" class="btn btn-secondary btn-sm delete_all" title="Delete Multiple"><i class="fa fa-trash-o"></i> Delete All</a>
        </div>
      </ol>
    </form>
    <?php
      if($this->session->flashdata('flash_msg')!='')
      {
      ?>
    <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
      <strong>Well done! &nbsp;<?php echo $this->session->flashdata('flash_msg');?></strong> 
    </div>
    <?php }?>		
    <div class="row">
      <div class="col-sm-12" id="listingData">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
          <div class="html5buttons">
            <div class="dt-buttons">
              <a href="<?=base_url();?>assets/facilities/excel_manage_facilities?<?='&fac_code='.$_GET['fac_code'].'&fac_name='.$_GET['fac_name'].'&fac_loc='.$_GET['fac_loc'].'&filter='.$_GET['filter']?>" class="dt-button buttons-excel buttons-html5" title="Excel">Excel</a>
            </div>
          </div>
          <div class="dataTables_length" id="DataTables_Table_0_length">
            <label>
              Show
              <select name="Da\taTables_Table_0_length" url="<?=base_url();?>assets/facilities/manage_facilities?<?='&fac_code='.$_GET['fac_code'].'&fac_name='.$_GET['fac_name'].'&fac_loc='.$_GET['fac_loc'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
                <option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
                <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
                <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
                <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
                <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
                <option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
                <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
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
            <input type="text" id="searchTerm" name="filter"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
            </label>
          </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <input type="hidden" id="searchTerm" class="search_box" onkeyup="doSearch()" />			
            <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData" >
              <thead>
                <tr>
                  <th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
                  <th>Code</th>
                  <th>Name</th>
                  <th style="display: none;">Location</th>
                  <th style="width:110px;">Action</th>
                </tr>
              </thead>
              <tbody id="getDataTable">
                <tr>
                  <form method="get">
                    <td>&nbsp;</td>
                    <td><input name="fac_code"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                    <td><input name="fac_name"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                    <td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
                  </form>
                </tr>
                <?php  
                  /*echo "<pre>";
                  print_r($result);
                  echo "</pre>";*/
                  
                  foreach($result as $fetch_list)
                  {
                  ?>
                <tr class="gradeC record " data-row-id="<?php echo $fetch_list->id; ?>">
                  <th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->id; ?>" value="<?php echo $fetch_list->id;?>" /></th>
                  <th><?php echo $fetch_list->fac_code; ?></th>
                  <th><?php echo $fetch_list->fac_name; ?></th>
                  <th style="display: none;"><?php 
                    $facilityQuery = $this ->db->query("select * from tbl_master_data where serial_number='".$fetch_list->fac_loc."'");
                    $getfacility = $facilityQuery->row();
                    echo $getfacility->keyvalue;  ?></th>
                  <th class="bs-example">
                    <?php if($view!=''){ ?>
                    <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Facility"> <i class="fa fa-eye"></i> </button>
                    <?php } if($edit!=''){ ?>
                    <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->id;?>" href='#editItem' onclick="getEditItem('<?php echo $fetch_list->id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Facility"><i class="icon-pencil"></i></button>
                    <?php }
                      $pri_col='id';
                      $table_name='tbl_facilities';
                      ?>
                    <button class="btn btn-default delbutton" id="<?php echo $fetch_list->id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Facility"><i class="icon-trash"></i></button>		
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <input type="text" style="display:none;" id="table_name" value="tbl_facilities">  
            <input type="text" style="display:none;" id="pri_col" value="id">
          </div>
          <div class="row">
            <div class="col-md-12 text-right">
              <div class="col-md-6 text-left"> </div>
              <div class="col-md-6"> 
                <?php echo $pagination; ?>
              </div>
              <div class="popover fade right in displayclass" role="tooltip" id="popover" style=" background-color: #ffffff;border-color: #212B4F;">
                <div class="popover-content" id="showParent"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--panel-default-- close-->
</div>
<!--main-content close-->
<div style="clear:both;"></div>
<?php
  $this->load->view("footer.php");
  ?>
<script type="text/javascript">
  function saveData()
  {
  	
     var fac_code     = document.getElementById("fac_code").value;
     var id          	= document.getElementById("id").value;
     var fac_name    	= document.getElementById("fac_name").value;
     var fac_loc      = document.getElementById("fac_loc").value;
       
  
  	if(fac_code=='' )
  	{
  	  document.getElementById("codee").innerHTML = "Please Enter Code";
  	  return false;
  	}
  	if(fac_name=='' )
  	{
  	  document.getElementById("namee").innerHTML = "Please Enter Name";
  	  return false;
  	}
  
  	/*if(fac_loc=='' )
  	{
  	  document.getElementById("locee").innerHTML = "Please Enter Location";
  	  return false;
  	}
  	*/
  
  	 var xhttp = new XMLHttpRequest();
  	 xhttp.open("GET", "insert_facilities?id="+id+"&fac_code="+fac_code+"&fac_name="+fac_name+"&fac_loc="+fac_loc, false);
  	 xhttp.send();
  
  	 //$("#Facilitymodal .close").click();	   
  	 document.getElementById("loadData").innerHTML = xhttp.responseText;
  
  	 document.getElementById("fac_code").value=''
  	 document.getElementById("fac_name").value='';
  	 
  	 document.getElementById("msgadd").innerHTML="Added Successfully";
  	 setTimeout(function() {
  	 //$('#success_message').fadeOut("slow");
  	 //$("#resultarea").text(" ");
  
  	clearfunc();
  	$("#Facilitymodal .close").click();	   
  	}, 1500 );	
  
  }
  
  
  function getEditItem(v,button_type)
  {
  
  	 var pro=v;
  	 //alert(button_type);
  	 var xhttp = new XMLHttpRequest();
  	 xhttp.open("GET", "getfacility_edit?ID="+pro+"&type="+button_type, false);
  	 xhttp.send();
  
  	 document.getElementById("modal-contentitem").innerHTML = xhttp.responseText;
  
  } 	
  
  
  
  function editData()
  {
  
     var fac_code     = document.getElementById("fac_code").value;
     var id          	= document.getElementById("id").value;
     var fac_name    	= document.getElementById("fac_name").value;
     var fac_loc      = document.getElementById("fac_loc").value;
       
  
  	if(fac_code=='' )
  	{
  	  document.getElementById("codee").innerHTML = "Please Enter Code";
  	  return false;
  	}
  
  	if(fac_name=='' )
  	{
  	  document.getElementById("namee").innerHTML = "Please Enter Name";
  	  return false;
  	}
  
  	/*if(fac_loc=='' )
  	 {
  
  	  document.getElementById("locee").innerHTML = "Please Enter Location";
  	  return false;
  	}
  	*/
  
  	 var xhttp = new XMLHttpRequest();
  	 xhttp.open("GET", "insert_facilities?id="+id+"&fac_code="+fac_code+"&fac_name="+fac_name+"&fac_loc="+fac_loc, false);
  	 xhttp.send();
  	 
  	 document.getElementById("loadData").innerHTML = xhttp.responseText;
  	 document.getElementById("mssg100").innerHTML="Updated Successfully";
  
  	 setTimeout(function() {
  	 //$('#success_message').fadeOut("slow");
  	 //$("#resultarea").text(" ");
  
  	 $("#editItem .close").click();	   
  	 }, 1400 );	
  
  }
  
</script>
<script type="text/javascript">
  function exportTableToExcel(tableID, filename = '')
  {
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'Machine BreakDown<?php echo date('d-m-Y');?>.xls';
     
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
  
  $(document).ready(function(){
  
  $("#fac_code").keyup(function(){
  /*$(".savebutton").keyup(function(){*/
  
  var datas=$("#fac_code").val();
  //alert(datas);
  		$.ajax({
  			
  			url:"<?php echo base_url();?>assets/facilities/codevalidation",
  			data:{"codeval":datas},
  			success:function(data){
  						
  				if(data==1)
  				{
  					
  					$("#codee").html("Code Already Exists.");
  					$(".savebutton").prop("disabled",true);					
  					//$("#codee").val("Code already exists");
  				}
  				else
  				{
  					$("#codee").html("");
  					$(".savebutton").attr("disabled",false);
  				}
  			}
  			
  		});
  
  });
  
  });
  
  
  function editalert()
  {
  		
  $(document).ready(function(){
  $("#fac_code").keyup(function(){
  /*$(".savebutton").keyup(function(){*/
  
  var datas=$("#fac_code").val();
  //alert(datas);
  		$.ajax({
  			
  			url:"<?php echo base_url();?>assets/facilities/codevalidation",
  			data:{"codeval":datas},
  			success:function(data){
  						
  				if(data==1)
  				{
  					
  					$("#codee").html("Code Already Exists");
  					$(".savebutton").prop("disabled",true);
  					//$('#msg').html(data).fadeIn('slow');
     				  	$('#msg11').html("data insert successfully").fadeIn('slow'); 
     				  	//also show a success message 
       				$('#msg').delay(5000).fadeOut('slow');					
  					//$("#codee").val("Code already exists");
  				
  				}
  				else
  				{
  					$("#codee").html("");
  					$(".savebutton").attr("disabled",false);
  				}
  		    }
  			
  		});
  	});
  });
  
  }
  
  function clearfunc()
  {
  
  	document.getElementById("fac_code").value="";
  	document.getElementById("fac_name").value="";
  	document.getElementById("codee").innerHTML="";
  	document.getElementById("namee").innerHTML="";
  	document.getElementById("msgadd").innerHTML="";
  }
</script>