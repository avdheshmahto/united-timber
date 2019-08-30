<?php
  $this->load->view("header.php");
  $entries = "";
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
<div id="modal-0" class="modal fade"  role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" > <span class="top_title" >Add </span>Tool</h4>
        <div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div>
      </div>
      <div class="modal-body overflow">
        <form class="form-horizontal"  role="form"  enctype="multipart/form-data" id="ToolForm" >
          <div class="form-group">
            <label class="col-sm-2 control-label">*Serial Number:</label> 
            <div class="col-sm-4"> 	
              <input type="hidden" class="hiddenField" name="Product_id" id="Product_id" value="" />
              <input type="text" class="form-control" name="sku_no" id="sku_no" value=""> 
            </div>
            <label class="col-sm-2 control-label">*Tool Name:</label> 
            <span id="spare_name"></span>
            <div class="col-sm-4"> 
              <input name="item_name"  type="text" id="item_name" value="" class="form-control"> 
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Type Of Tool:</label> 
            <div class="col-sm-4" id="regid">
              <select name="type_of_spare" required class="select2 form-control" id="type_of_spare" style="width:100%;">
                <option value="" >----Select Unit----</option>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where param_id=26");
                  foreach ($sqlunit->result() as $fetchunit){
                  ?>
                <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">*Priority:</label> 
            <div class="col-sm-4">
              <select name="priority" required class="select2 form-control" id="priority" style="width:100%;">
                <option value="" >----Select----</option>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where param_id=27");
                  foreach ($sqlunit->result() as $fetchunit){
                  ?>
                <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                <?php } ?>
              </select>
              <span id="err_unit1"></span>           
            </div>
          </div>
          <span class="c-validation c-error" style="text-align:center; color:#F00" id="sec"></span>
          <span id="err_unit1"></span>
          <div class="form-group">
            <label class="col-sm-2 control-label">*Usages Unit:</label> 
            <div class="col-sm-4">
              <select name="unit" required class="select2 form-control" id="unit1" style="width:100%;">
                <option value="" >----Select Unit----</option>
                <?php 
                  $sqlunit=$this->db->query("select * from tbl_master_data where param_id=16");
                  foreach ($sqlunit->result() as $fetchunit){
                  ?>
                <option value="<?php echo $fetchunit->serial_number;?>"><?php echo $fetchunit->keyvalue; ?></option>
                <?php } ?>
              </select>
              <span id="err_unit1"></span>           
            </div>
            <label class="col-sm-2 control-label">*Purchase Price:</label> 
            <div class="col-sm-4" id="regid"> 
              <input type="number" step="any" name="unitprice_purchase" id="unitprice_purchase" value="" class="form-control" required>
            </div>
          </div>
          <div class="table-responsive">
            <INPUT type="button" value="Add Row" class="btn btn-primary" onclick="addRow('dataTable')" />
            <INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />
            <table class="table table-striped table-bordered table-hover" id="dataTable" >
              <tbody>
                <tr class="gradeA">
                  <th>Check </th>
                  <th>Location</th>
                  <th>Rack</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
                <tr class="gradeA">
                  <th>
                    <input type="checkbox" name="chkbox[]" />
                  </th>
                  <th>
                    <input type="hidden"  name="id" value="<?php echo $_GET['id']; ?>" />
                    <select name="location[]" id="cat_id1"  class="select2 form-control" onChange="getCat(this.id)" style="width:100%;">
                      <option value=""selected disabled>----Select ----</option>
                      <?php 
                        $sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
                        foreach ($sqlgroup->result() as $fetchgroup){						
                        ?>					
                      <option value="<?php echo $fetchgroup->serial_number; ?>"><?php echo $fetchgroup->keyvalue; ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th>
                    <select name="rack[]" id="div_cat_id1" class="select2 form-control" style="width:100%;">
                      <option value=""selected disabled>----Select ----</option>
                      <?php
                        $queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A'");
                        foreach($queryMainLocation1->result() as $getMainLocation1){
                        ?>
                      <option value="<?php echo $getMainLocation1->id;?>"><?=$getMainLocation1->rack_name;?>
                      </option>
                      <?php }?>
                    </select>
                  </th>
                  <th>
                    <input type="number" step="any"   name="qtyy[]"   class="form-control"> 
                  </th>
                  <th>
                    <!--<img src="/united-timber/assets/images/delete.png" border="0" name="dlt" id="dlt1" style="border: hidden;">-->
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
      </div>
      <div class="modal-footer" id="button">
      <input type="submit" class="btn btn-sm"  value="Save">
      <!-- <a class="btn btn-sm" style="padding:4px;" editvalue=""  submit_value = "save" id="itemSave"> Save </a> -->
      <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Main content -->
<div class="main-content">
  <form class="form-horizontal" role="form"  enctype="multipart/form-data" id="ToolForm1" >
    <div id="edittool" class="modal fade modal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-contenttool" id="modal-contenttool">
        </div>
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body-">
          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-default-">
                <div class="row" >
                  <div class="col-lg-12" id="listingDataoftools">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <ol class="breadcrumb">
                            <li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
                            <li><a href="#">Assets</a></li>
                            <li class="active"><strong>Manage Tools</strong></li>
                          </ol>
                        </div>
                      </div>
                      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="html5buttons">
                          <div class="dt-buttons">
                            <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('getDataTable')" title="Excel">Excel</button>
                            <a class="btn btn-sm" data-toggle="modal" formid = "#ToolForm" data-target="#modal-0" id="formreset" title="Add Tools"><i class="fa fa-arrow-circle-left"></i> Add Tool</a>
                            <a class="btn btn-secondary btn-sm delete_all" title="Delete Multiple" ><span><i class="fa fa-trash-o"></i> Delete</span></a>
                          </div>
                        </div>
                        <div class="dataTables_length" id="DataTables_Table_0_length">
                          <label>
                            Show
                            <select name="DataTables_Table_0_length" url="<?=base_url();?>assets/tools/manage_tools?<?='sku_no='.$_GET['sku_no'].'&priority='.$_GET['priority'].'&productname='.$_GET['productname'].'&usages_unit='.$_GET['usages_unit'].'&unitprice_purchase='.$_GET['unitprice_purchase'].'&quantity='.$_GET['quantity'].'&type_of_spare='.$_GET['type_of_spare'].'&filter='.$_GET['filter'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
                              <option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
                              <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
                              <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
                              <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
                              <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
                              <option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
                              <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
                            </select>
                            entries
                          </label>
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
                      <!--row close-->
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example_"  id="getDataTable">
                          <thead bgcolor="#CCCCCC">
                            <tr>
                              <th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
                              <th>Serial Number </th>
                              <th>Type Of Tools</th>
                              <th>Priority</th>
                              <th>Tool Name</th>
                              <th>Usages Unit</th>
                              <th>Purchase Price</th>
                              <th>Quantity</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id = "getDataTable">
                            <tr>
                              <form method="get">
                                <td>&nbsp;</td>
                                <td><input name="sku_no"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <!--<td><input name="category"  type="text"  class="search_box form-control input-sm"  value="" /></td>-->
                                <td><input name="type_of_spare"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <td><input name="priority"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <td><input name="productname"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <td><input name="usages_unit"  type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <td><input name="unitprice_purchase" type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <td><input name="quantity" type="text"  class="search_box form-control input-sm"  value="" /></td>
                                <td><button type="submit" class="btn btn-sm" name="filter" value="filter" title="Search"><span>Search</span></button></td>
                              </form>
                            </tr>
                            <?php  
                              $i=1;
                              if($result != ""){
                              foreach($result as $fetch_list)
                              {
                              ?>
                            <tr class="gradeC record" data-row-id="<?php echo $fetch_list->Product_id; ?>">
                              <th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->Product_id; ?>" value="<?php echo $fetch_list->Product_id;?>" /></th>
                              <?php
                                $queryType=$this->db->query("select *from tbl_master_data where serial_number='$fetch_list->type'");
                                $getType=$queryType->row();
                                ?>
                              <th><?=$fetch_list->sku_no;?></th>
                              <th><?php $compQuery1 = $this -> db
                                -> select('*')
                                -> where('serial_number',$fetch_list->type_of_spare)
                                -> get('tbl_master_data');
                                $keyvalue1 = $compQuery1->row();
                                echo $keyvalue1->keyvalue;		  
                                ?></th>
                              <th><?php $compQuery1 = $this -> db
                                -> select('*')
                                -> where('serial_number',$fetch_list->priority)
                                -> get('tbl_master_data');
                                $keyvalue1 = $compQuery1->row();
                                echo $keyvalue1->keyvalue; ?></th>
                              </th>
                              <?php 
                                $size=$this->db->query("select *from tbl_master_data where serial_number='$fetch_list->size'");
                                $psize=$size->row();
                                if($psize->keyvalue !='')
                                {
                                ?>
                              <th><?php echo $fetch_list->productname .'   ( '.$psize->keyvalue .')' ; } else { ?></th>
                              <th>
                                <!-- <a class="modalMapSpare"   onclick ="viewtool(<?=$fetch_list->Product_id;?>);"  data-toggle="modal" data-target="#modal-1" data-backdrop='static' data-keyboard='false'  id="formreset" title="View Tools Location Details"> -->
                                <a href="<?=base_url();?>assets/tools/manage_tool_map?id=<?php echo $fetch_list->Product_id; ?>" title="Tools Details"><?php echo $fetch_list->productname; } ?></a>
                              </th>
                              <th>
                                <?php
                                  $compQuery1 = $this -> db
                                  		   -> select('*')
                                  		   -> where('serial_number',$fetch_list->usageunit)
                                  		   -> get('tbl_master_data');
                                  		  $keyvalue1 = $compQuery1->row();
                                  echo $keyvalue1->keyvalue;		  
                                  
                                  
                                  ?>
                              </th>
                              <th><?=$fetch_list->unitprice_purchase?></th>
                              <th><?=$fetch_list->quantity?></th>
                              <th class="bs-example">
                                <?php if($view!=''){ ?>
                                <!--<button class="btn btn-default" type="button" property="view" arrt= '<?=json_encode($fetch_list);?>' onclick ="editRow(this);" data-toggle="modal" data-target="#modal-0" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i></button>
                                  -->
                                <!-- <button class="btn btn-default modalEdittool" data-a="<?php echo $fetch_list->Product_id;?>" href='#edittool' onclick="getEdittool('<?php echo $fetch_list->Product_id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="View Tools"><i class="fa fa-eye"></i></button>
                                  -->
                                <?php } if($edit!=''){ ?>
                                <button class="btn btn-default modalEdittool" data-a="<?php echo $fetch_list->Product_id;?>" href='#edittool' onclick="getEdittool('<?php echo $fetch_list->Product_id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Tools"><i class="icon-pencil"></i></button>
                                <!--<a  arrt= '<?=json_encode($fetch_list);?>'   onclick ="editRow(this);" class="btn btn-default"  data-toggle="modal" data-target="#modal-0" >&nbsp; <i class="icon-pencil"></i>&nbsp; </a> -->
                                <?php }
                                  $pri_col='Product_id';
                                  $table_name='tbl_product_stock';
                                  ?>
                                <button class="btn btn-default delbutton" id="<?php echo $fetch_list->Product_id."^".$table_name."^".$pri_col ; ?>" type="button" title="Delete Tools"><i class="icon-trash"></i></button>		
                                <?php
                                  ?>
                                <!--
                                  <button class="btn btn-default " type="button" onclick ="viewtool(<?=$fetch_list->Product_id;?>);" type="button" data-toggle="modal" data-target="#modal-1" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye" title="View"></i> </button>-->
                              </th>
                            </tr>
                            <?php $i++; }} ?>
                          </tbody>
                          <input type="text" style="display:none;" id="table_name" value="tbl_product_stock">  
                          <input type="text" style="display:none;" id="pri_col" value="Product_id">
                        </table>
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
              <div id="modal-1" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Tools Details</h4>
                      <!-- <div id="resultarea" class="text-center " style="font-size: 15px;color: red;"></div>  -->
                    </div>
                    <div class="modal-body overflow"  id="viewData">
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <?php
    $this->load->view("footer.php");
    ?>
</div>
<!--main-content close-->
<script>
  /* $('.modalEditItem').click(function(){
       var ID=$(this).attr('data-a');
    $.ajax({url:"updateItem?ID="+ID,cache:true,success:function(result){
           $(".modal-contentitem").html(result);
       }});
   });
  */
  
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
  
  function changing(v)
  {
  
  //alert(v);
  var pro=v;
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "changesubcatg?ID="+pro, false);
  xhttp.send();
  //alert(xhttp.responseText);
  document.getElementById("subcategory").innerHTML = xhttp.responseText;
  //document.getElementById("subcategory11").innerHTML = xhttp.responseText;
  
  }
  
  
  
  
  function changingf(v)
  {
  
  //alert(v);
  var pro=v;
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "changesubcatg?ID="+pro, false);
  xhttp.send();
  //alert(xhttp.responseText);
  document.getElementById("subcategory").innerHTML = xhttp.responseText;
  //document.getElementById("subcategory11").innerHTML = xhttp.responseText;
  
  }
  
  
</script>
<div style="clear:both;"></div>
<script>
  function exportTableToExcel(tableID, filename = ''){
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'Tools<?php echo date('d-m-Y');?>.xls';
     
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
<SCRIPT language="javascript">
  function addRow(tableID) {
  
  	
  	var table = document.getElementById(tableID);
  
  	var rowCount = table.rows.length;
  	var row = table.insertRow(rowCount);
  
  var cell1 = row.insertCell(0);
  	var element1 = document.createElement("input");
  	element1.type = "checkbox";
  	element1.name="chkbox[]";
  	cell1.appendChild(element1);
  	
  var cell2 = row.insertCell(1);
  	var element2 = document.createElement("select");
  	element2.name = "location[]";
  	element2.id = "cat_id"+rowCount;
  	element2.onchange=function() { getCat(this.id); };
  	element2.className="form-control";
  	var option1 = document.createElement("option");
  	option1.innerHTML = "--Select--";
    		option1.value = "";
    		element2.appendChild(option1, null);
  <?php 
    $sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
    foreach ($sqlgroup->result() as $fetchgroup){						
    ?>					
  
  
    var option2 = document.createElement("option");
    option2.innerHTML = "<?=$fetchgroup->keyvalue;?>";
    option2.value = "<?=$fetchgroup->serial_number;?>";
    element2.appendChild(option2, null);
    
  <?php }?>
  	cell2.appendChild(element2);
  	
  var cell3 = row.insertCell(2);
  	var element9 = document.createElement("select");
  	element9.name = "rack[]";
  	element9.id = "div_cat_id"+rowCount;
  	element9.className="form-control";
  	var option9 = document.createElement("option");
  	option9.innerHTML = "--Select--";
    option9.value = "";
    element9.appendChild(option9, null);
  	<?php
    $queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A'");
    foreach($queryMainLocation1->result() as $getMainLocation1){
    ?>
  
  
    var option10 = document.createElement("option");
    option10.innerHTML = "<?=$getMainLocation1->rack_name;?>";
    option10.value = "<?=$getMainLocation1->id;?>";
    element9.appendChild(option10, null);
    
  <?php }?>
  	cell3.appendChild(element9);
  
  	
  	
  
  var cell4 = row.insertCell(3);
  	var element3 = document.createElement("input");
  	element3.type = "number";
  	element3.className="form-control"
  	element3.name = "qtyy[]";
  	cell4.appendChild(element3);
  	
  	
  	
  
  var cell5 = row.insertCell(4);
  cell5.style.width="3%";
  		cell5.align="center";
  		var delt =document.createElement("img");
  				delt.src ="<?=base_url();?>assets/images/delete.png";
  				delt.class ="icon";
  				delt.border ="0";
  				//delt.style.width="30%";
  				//delt.style.height="20%";
  				delt.name ='dlt';
  				delt.id='dlt'+rowCount;
  				delt.style.border="hidden"; 
  				delt.onclick=function() { deleteselectrow(delt.id,delt); };
  				//delt.onclick= function() { deleteselectrow(delt.id,delt); };
  			    cell5.appendChild(delt);
  				
  				
  	
  
  }
  
  
  
  function deleteRow(tableID) {
  	try {
  	var table = document.getElementById(tableID);
  	var rowCount = table.rows.length;
  
  	for(var i=0; i<rowCount; i++) {
  		var row = table.rows[i];
  		var chkbox = row.cells[0].childNodes[0];
  		if(null != chkbox && true == chkbox.checked) {
  			table.deleteRow(i);
  			rowCount--;
  			i--;
  		}
  
  
  	}
  	}catch(e) {
  		alert(e);
  	}
  }
  
  
  function addRow_edit(tableID) {
  
  	
  	var table = document.getElementById(tableID);
  
  	var rowCount = table.rows.length;
  	var row = table.insertRow(rowCount);
  
  var cell1 = row.insertCell(0);
  	var element1 = document.createElement("input");
  	element1.type = "checkbox";
  	element1.name="chkbox[]";
  	element1.id = "chk1"+rowCount;
  	cell1.appendChild(element1);
  	
  var cell2 = row.insertCell(1);
  	var element2 = document.createElement("select");
  	element2.name = "location[]";
  	element2.id = "cat_idd"+rowCount;
  	element2.onchange=function() { getCatt(this.id); };
  	element2.className="form-control";
  	var option1 = document.createElement("option");
  	option1.innerHTML = "--Select--";
    option1.value = "";
    element2.appendChild(option1, null);
  <?php 
    $sqlgroup=$this->db->query("select * from tbl_master_data where param_id='21'");
    foreach ($sqlgroup->result() as $fetchgroup){						
    ?>					
  
  
    var option2 = document.createElement("option");
    option2.innerHTML = "<?=$fetchgroup->keyvalue;?>";
    option2.value = "<?=$fetchgroup->serial_number;?>";
    element2.appendChild(option2, null);
    
  <?php }?>
  	cell2.appendChild(element2);
  	
  var cell3 = row.insertCell(2);
  	var element9 = document.createElement("select");
  	element9.name = "rack[]";
  	element9.id = "div_cat_idd"+rowCount;
  	element9.className="form-control";
  	var option9 = document.createElement("option");
  	option9.innerHTML = "--Select--";
    option9.value = "";
    element9.appendChild(option9, null);
  	<?php
    $queryMainLocation1=$this->db->query("select *from tbl_location_rack where status='A'");
    foreach($queryMainLocation1->result() as $getMainLocation1){
    ?>
  
  
  
  
  
    var option10 = document.createElement("option");
    option10.innerHTML = "<?=$getMainLocation1->rack_name;?>";
    option10.value = "<?=$getMainLocation1->id;?>";
    element9.appendChild(option10, null);
    
  <?php }?>
  	cell3.appendChild(element9);
  
  	
  	
  
  var cell4 = row.insertCell(3);
  	var element3 = document.createElement("input");
  	element3.type = "number";
  	element3.className="form-control"
  	element3.name = "qtyy[]";
  	cell4.appendChild(element3);
  	
  	
  	
  
  var cell5 = row.insertCell(4);
  cell5.style.width="3%";
  		cell5.align="center";
  		var delt =document.createElement("img");
  				delt.src ="<?=base_url();?>assets/images/delete.png";
  				delt.class ="icon";
  				delt.border ="0";
  				//delt.style.width="30%";
  				//delt.style.height="20%";
  				delt.name ='dlt';
  				delt.id='dlt'+rowCount;
  				delt.style.border="hidden"; 
  				delt.onclick=function() { deleteselectrow(delt.id,delt); };
  				//delt.onclick= function() { deleteselectrow(delt.id,delt); };
  			    cell5.appendChild(delt);
  				
  				
  	
  
  }
  
  
  
  function deleteRow_edit(tableID) {
  //alert("edbcvb");
  	try {
  	var table = document.getElementById(tableID);
  	var rowCount = table.rows.length;
  
  	for(var i=0; i<rowCount; i++) {
  		var row = table.rows[i];
  		var chkbox = row.cells[0].childNodes[0];
  		if(null != chkbox && true == chkbox.checked) {
  			table.deleteRow(i);
  			rowCount--;
  			i--;
  		}
  
  
  	}
  	}catch(e) {
  		alert(e);
  	}
  }
  
  
  
  
  
  function deleteselectrow(d,r) //delete dyanamicly created rows or product detail
  {
  
  var regex = /(\d+)/g;
  
  nn= d.match(regex)
  id=nn;
  $(r).parent().parent().remove();
  
  }
  
  
  
  function getCat(q)
  {
  
  var zz=document.getElementById(q).id;
  //alert(zz);
    var myarra = zz.split("cat_id");
  
    var asx= myarra[1];
  
    
  
    var cat_id=document.getElementById("cat_id"+asx).value;
  
  
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "get_rack?con="+cat_id, false);
  xhttp.send();
  document.getElementById("div_cat_id"+asx).innerHTML = xhttp.responseText;
  
  
  }
  
  
  
  function getCatt(q)
  {
  var zzx=document.getElementById(q).id;
    //alert(zz);
    var myarraa = zzx.split("cat_idd");
    var asxx    = myarraa[1];
    var cat_idd = document.getElementById("cat_idd"+asxx).value;
  var xhttp   = new XMLHttpRequest();
    xhttp.open("GET", "get_rack?con="+cat_idd, false);
    xhttp.send();
    document.getElementById("div_cat_idd"+asxx).innerHTML = xhttp.responseText;
  }
  
  
</SCRIPT>
<script>
  function getEdittool(v,button_type)
  {
  
   var pro=v;
   //alert(button_type);
   var xhttp = new XMLHttpRequest();
   xhttp.open("GET", "edit_map_tool?ID="+pro+"&type="+button_type, false);
   xhttp.send();
  
   document.getElementById("modal-contenttool").innerHTML = xhttp.responseText;
  
  } 	
  
  
  
  function editData()
  {
  	
     var sku_no = document.getElementById("sku_no").value;
     var item_name     = document.getElementById("item_name").value;
     var Product_id          	 = document.getElementById("Product_id").value;
     //alert(id);
     var priority    		 = document.getElementById("priority").value;
     var unit1    		 = document.getElementById("unit1").value;
     var unitprice_purchase    = document.getElementById("unitprice_purchase").value;
   
     var type_of_spare   = document.getElementById("type_of_spare").value;
     var location   = document.getElementById("location").value;
     var rack   = document.getElementById("rack").value;
     var qtyy   = document.getElementById("qtyy").value;
     
  
  if(item_name=='' )
   {
  
    document.getElementById("name").innerHTML = "Please Enter Tool";
    return false;
  }
  if(type_of_spare=='' )
   {
  
    document.getElementById("spare").innerHTML = "Please Enter Type Of Tool";
    return false;
  }
  
  
  
  
   var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "insert_item?Product_id="+Product_id+"&sku_no="+sku_no+"&item_name="+item_name+"&priority="+priority+"&unit1="+unit1+"&unitprice_purchase="+unitprice_purchase+"&type_of_spare="+type_of_spare+"&location="+location+"&rack="+rack+"&qtyy="+qtyy, false);
   xhttp.send();
  
  
   $("#edittool .close").click();	   
   document.getElementById("loadData").innerHTML = xhttp.responseText;
  
   document.getElementById("spare").value='';
   document.getElementById("Product_id").value='';
  	
  	
  }
  
  
</script>
<script>
  function viewtool(viewId)
  {
  
  	$.ajax({   
      type: "POST",  
  	url: "ajax_viewtoolData",  
  	cache:false,  
  	data: {'id':viewId},  
  	success: function(data)  
  	{  
  	//alert(data); 
  	//console.log(data);
  	// $("#loading").hide();  
  	 $("#viewData").empty().append(data).fadeIn();
  	//referesh table
  	}   
  });
  
  }
  
</script>