<?php
  $this->load->view("header.php");
  
  $entries = "";
  if($this->input->get('entries')!="")
  {
    $entries = $this->input->get('entries');
  }
  
  ?>
<div class="main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h4 class="panel-title">CURRENT STOCK DETAILS</h4>
          <ul class="panel-tool-options">
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
          </ul>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Parts And Supplies Name</th>
                  <th>Type</th>
                  <th>Sub-Type</th>
                  <th>Location</th>
                  <th>Rack</th>
                  <th>Quantity</th>
                  <th>Vendor Name</th>
                  <th>Purchase Price</th>
                </tr>
              </thead>
              <tbody id="getDataTable" >
                <?php
                  $serial=$this->db->query("select * from tbl_product_serial where product_id='".$_GET['id']."'");
                  $result=$serial->result();
                  foreach($result as $fetch){
                  ?>
                <tr class="gradeC record">
                  <?php  
                    $locaquery = $this->db->query("select * from tbl_product_stock where Product_id='".$fetch->product_id."'");
                    $getlocate = $locaquery->row();
                    
                    $type=$this->db->query("select * from tbl_master_data where serial_number='$getlocate->type_of_spare'");
                    $getType=$type->row();
                    
                    $vnd=$this->db->query("select * from tbl_contact_m where contact_id = '$fetch->supp_name' ");
                    $getVnd=$vnd->row();
                    
                    $main_locQuery = $this->db->query("select * from tbl_master_data where serial_number='".$fetch->loc."'");
                    $getmain_loc = $main_locQuery->row();
                    
                    $main_rackQuery = $this->db->query("select * from tbl_location_rack where id='".$fetch->rack_id."'");
                    $getmain_rack = $main_rackQuery->row();
                    
                    ?>
                  <th><?php echo $fetch->maker_date ?> </th>
                  <th><?php echo $getlocate->productname; ?></th>
                  <th><?php echo $getType->keyvalue; ?></th>
                  <th><?php echo $fetch->module_status; ?></th>
                  <th><?php echo $getmain_loc->keyvalue; ?></th>
                  <th><?php echo $getmain_rack->rack_name; ?></th>
                  <th><?php echo $fetch->quantity; ?></th>
                  <th><?php echo $getVnd->first_name; ?></th>
                  <th><?php echo $fetch->purchase_price; ?></th>
                </tr>
                <?php  }  ?>
              </tbody>
            </table>
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
  </div>
</div>
<?php
  $this->load->view("footer.php");
  ?>
<script>
  function exportTableToExcel(tableID, filename = ''){
  
      //alert();
     var downloadLink;
     var dataType = 'application/vnd.ms-excel';
     var tableSelect = document.getElementById(tableID);
     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
     
     // Specify file name
     filename = filename?filename+'.xls':'LOCATION WISE CURRENT STOCK REPORT(<?php echo date('d-m-Y');?>).xls';
     
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
    location.href="<?=base_url('/stocks/current_stock/manage_current_stock');?>";
  }
  
  
  function getSpareDrowdown(v)
  {
    //alert(v);
    var urll="<?=base_url('stocks/current_stock/get_spare_dropdown');?>";
          $.ajax({
            type:"POST",
            url:urll,
            data : {'typ':v},
            success:function(data){            
              //alert(data);
              if(data != ''){
                //alert(data);
                //location.reload();
               $("#sp_name").empty().append(data);
              }            
            }
        });
  
  }
  $(window).load(function() {
       getSpareDrowdown('<?=$_GET['type']?>');
  });
</script>