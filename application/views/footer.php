<!-- Footer -->
<footer class="footer-main"> 
Copyright &copy; <?php echo date(Y);?> <a target="_blank" href="http://www.techvyas.com/"> Tech Vyas Solutions Pvt Ltd.</a> All Rights Reserved.
</footer>	
<!-- /footer -->
</div>
<!-- /main content -->
</div>
  <!-- /main container -->
</div>
<!-- /page container -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script> -->

 <script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.min.js"></script> 
 <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.min.js"></script> 
 
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>


<script type="text/javascript" src="<?=base_url();?>assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/blockui-master/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/blockui-master/js/jquery.blockUI.js"></script>

<!--Knob Charts-->
<script type="text/javascript" src="<?=base_url();?>assets/plugins/knob/js/jquery.knob.min.js"></script>

<!--Jvector Map-->
<script type="text/javascript" src="<?=base_url();?>assets/plugins/jvectormap/js/jquery-jvectormap-2.0.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js"></script>

<!--ChartJs-->
<script type="text/javascript" src="<?=base_url();?>assets/plugins/chartjs/js/Chart.min.js"></script>

<!--Morris Charts-->
<script type="text/javascript" src="<?=base_url();?>assets/plugins/morris/js/raphael-min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/morris/js/morris.min.js"></script>

<!--Float Charts-->
<script type="text/javascript" src="<?=base_url();?>assets/plugins/flot/js/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/flot/js/jquery.flot.tooltip.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/flot/js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/flot/js/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/flot/js/jquery.flot.time.min.js"></script>

<!--Dashboard Js-->
<link type="text/css" href="<?=base_url();?>assets/dropdown-customer/semantic.css" rel="stylesheet" />
<script type="text/javascript" src="<?=base_url();?>assets/js/dashboard.js"></script>

<script type="text/javascript" src="<?=base_url();?>assets/dropdown-customer/semantic.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.ztree.core.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/newjs/additional-methods.js"></script>
<!--Functions Js-->
<script type="text/javascript" src="<?=base_url();?>assets/js/functions.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/custom_master.js"></script>


<script type="text/javascript">

  $("#entries").change(function(){
      var value=$(this).val();
      var pageurl  = $(this).attr('url');
      url = pageurl+"&entries="+value;
      window.location.href = url;
  });

 

//===============================End===============================================
  
function editItem(ths) 
{

   var image_url = "<?=base_url('assets/image_data');?>"+'/';
   //console.log('edit ready !');
   $('.error').css('display','none');
   var rowValue = $(ths).attr('arrt');
   var button_property = $(ths).attr('property');
  
   //console.log(rowValue);
   if(rowValue !== undefined)
    var editVal = JSON.parse(rowValue);
    if(button_property != 'view')
      $('#Product_id').val(editVal.Product_id);

      $('#sku_no').val(editVal.sku_no);
	  
      $('#type').val(editVal.type);
      $('#industry').val(editVal.industry).prop('selected', true);
      $('#category').val(editVal.category).prop('selected', true);
      $('#subcategory').val(editVal.subcategory).prop('selected', true);

      var valArr  = editVal.color; 
      var dataarray=valArr.split(",");
      $('#color').val(dataarray);
      $('#unit').val(editVal.usageunit);
      $('#hsn_code').val(editVal.hsn_code);
      $('#gst_tax').val(editVal.gst_tax);
      $('#unitprice_sale').val(editVal.unitprice_sale);
      $('#unitprice_purchase').val(editVal.unitprice_purchase);
      $('#productname').val(editVal.productname);
      if(editVal.product_image != "")
      $('#image').attr('src',image_url+editVal.product_image);
     

      if(button_property == 'view'){
       $('#button').css('display','none');
       $("#ItemForm :input").prop("disabled", true);
      }else{
       $('#button').css('display','block');
       $("#ItemForm :input").prop("disabled", false);
      }

};


//*******************************Tool Edit**************************************


function edittool(ths) 
{

   var image_url = "<?=base_url('assets/image_data');?>"+'/';
   //console.log('edit ready !');
   $('.error').css('display','none');
   var rowValue = $(ths).attr('arrt');
   var button_property = $(ths).attr('property');
  
   //console.log(rowValue);
   if(rowValue !== undefined)
    var editVal = JSON.parse(rowValue);
    if(button_property != 'view')
      $('#Product_id').val(editVal.Product_id);

      $('#sku_no').val(editVal.sku_no);
	  
      $('#type').val(editVal.type);
      $('#industry').val(editVal.industry).prop('selected', true);
      $('#priority').val(editVal.priority).prop('selected', true);
      $('#subcategory').val(editVal.subcategory).prop('selected', true);

      var valArr  = editVal.color; 
      var dataarray=valArr.split(",");
      $('#color').val(dataarray);
      $('#unit').val(editVal.usageunit);
      $('#hsn_code').val(editVal.hsn_code);
      $('#gst_tax').val(editVal.gst_tax);
      $('#unitprice_sale').val(editVal.unitprice_sale);
      $('#unitprice_purchase').val(editVal.unitprice_purchase);
      $('#productname').val(editVal.productname);
      if(editVal.product_image != "")
      $('#image').attr('src',image_url+editVal.product_image);
     

      if(button_property == 'view'){
       $('#button').css('display','none');
       $("#ToolForm :input").prop("disabled", true);
      }else{
       $('#button').css('display','block');
       $("#ToolForm :input").prop("disabled", false);
      }

};

//**********************************************************************************

function loadFile(ths) 
{

  if (ths.files && ths.files[0]) 
  {
        var reader = new FileReader();
        reader.onload = function (e) {
             $('#image').attr('src', e.target.result);
        };
        reader.readAsDataURL(ths.files[0]);
  }

}




$("#priceMapSpare").validate({

    rules: {},

      submitHandler: function(form) {
      	alert();
        ur = "<?=base_url('master/Account/ajax_sparePriceMapping');?>";
        var formData = new FormData(form);
        console.log($('#priceMapSpare').serialize());
            $.ajax({
                type : "POST",
                url  :  ur, 
              //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 1 || data == 2){
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                     $("#resultarea").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#modal-1 .close").click();
                       $("#invoice").empty();
                       $("#resultarea").text(" "); 
                       $('#priceMapSpare')[0].reset(); 

                       

                    }, 1000);
                  }else{
                    $("#resultarea").text(data);
                 }
                //ajex_ItemListData();
               },
                error: function(data){
                    console.log(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });



$("#target").click(function(event){
    event.preventDefault();
    $("#error").text(" ");
    $('#button').css('display','block');
   
    $("#category").prop("disabled", false);
    $("#selectCategory").prop("disabled", false);

    var ur   = "<?php echo base_url('assets/Section/ajex_formsubmit');?>";
    var name = $("#category").val();
    var ctg   = $("#selectCategory").val();
    var submit_type = $('#target').attr("submit_value");
    var editId = $('#editvalue').val();
    
    $("#saveload").css("display","inline-block");
    $("#target").attr("type","button");
    $("#target").css("display","none");

    if(name != "" && ctg != ""){
        $.ajax({
        type: "POST",
        url: ur,
        data: {'category':name,'selectCategory':ctg,'type':submit_type,'edit':editId },
        cache: false,
        success: function(data){
          $("#resultarea").text(data);
          ajex_loadListData(); //// load add table listing // 
          setTimeout(function() {   //calls click event after a certain time
          $("#modal-1 .close").click();
          $("#resultarea").text(" "); 
          }, 1000);
          //$('#formId')[0].reset(); 
          $("#saveload").css("display","none");
          $("#target").css("display","inline-block");
          $("#target").attr("type","submit");
        } 
        });
    }else if(name == ""){
     $("#error").text('Please Enter Category !');
    }else if(ctg == ""){
     $("#error").text('Please Select Category !');
    }
});

function deleterow(ths)
{

 var element = $(ths);
 var del_id = element.attr("id");
 var info = 'id=' + del_id;

   if(confirm("Are you sure you want to delete ?"))
    {
      $.ajax({
       type: "GET",
       url: "delete_data",
       data: info,
       success: function(data){}
      });
      $(ths).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast").animate({ opacity: "hide" }, "slow");
   }
return false;

}


function inputdisable(){
   $('#formId')[0].reset(); 
}

function editRow(ths)
{

   $('.error').css('display','none');
   var rowValue = $(ths).attr('arrt');
   console.log(rowValue);
   var button_property = $(ths).attr('property');
   //alert(button_property);
   if(rowValue !== undefined)
      var editVal = JSON.parse(rowValue);

   if(button_property != 'view')
      $('#Product_id').val(editVal.Product_id);

      $('#sku_no').val(editVal.sku_no);
      $('#type').val(editVal.type);
      $('#item_name').val(editVal.productname);
      $('#min_re_order_level').val(editVal.min_re_order_level);
	    $('#min_order').val(editVal.min_order);
      $('#unitprice_purchase').val(editVal.unitprice_purchase);
      $('#item_name').val(editVal.productname);
      $('#supp_name').val(editVal.supp_name);
      $('#unit1').val(editVal.usageunit).prop('selected', true);
      $('#category').val(editVal.category).prop('selected', true);
	    $('#type_of_spare').val(editVal.type_of_spare).prop('selected', true);

      if(button_property == 'view'){
	    $('.top_title').html('View ');
	    $('.button').hide(); 
       $('#button').css('display','none');
	   //$('#buttonnn').css('display','block');
       $("#ItemForm :input").prop("disabled", true);
      }else{
	    $('.top_title').html('Update ');
	    $('.button').show();
      
       $("#ItemForm :input").prop("disabled", false);
      }
     
}

function showRowtree(val)
{

  var ur   = "<?php echo base_url('assets/Section/ajaxShowParent'); ?>";
  //alert(ur);
  $(".displayclass").css("display", "none");
  $("th").css("color", "black");
  $.ajax({
      type: "POST",
      url: ur,
      data: {'id':val },
      success: function(data){
      
      $("#showParent").html(data);
      $("#row"+val).css("color", "red");
      $("#popover").css("display", "block");
     }
    });
}

function ajex_loadListData()
{

  ur = "<?=base_url('assets/Section/ajex_loadListData');?>";
  $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        // console.log(data);
        $("#loadProductData").html(data);

       
     }
  });

}


$(document).ready(function(){
 
// $(document).delegate("#formreset","click",function(){
//     //   alert('ssdfsdf');
//     var url = "<?=base_url()?>"+'assets/images/no_image.png';
//     var formid =  $('#formreset').attr('formid');
//   // alert(formid);
//     $(".top_title").html('Add ');
// 	  $(' #save').show();
//     $(formid)[0].reset();
//     // $(".tablejs")[0].reset();
//     $(".addrowdelete").remove();
//     $(".hiddenField").val('');
//     $(formid+" :input").prop("disabled", false);
//     $("#button").css("display", "block");
//     $('#image').attr('src',url);
    
//     $('#target').attr('submit_value','save');

//     });

/* $("#entries").change(function()
    {
      var value=$(this).val();
      var pageurl  = $(this).attr('url');
      url = pageurl+"&entries="+value;
      window.location.href = url;
    });*/



});

function selectList(ths)
{
 var data =  $(ths).attr('jsvalue');
   if(data !== undefined)
     var data = JSON.parse(data);
  $('#productList').css('display','none');
  $('#prd').val(data.productname);
  $('#pri_id').val(data.Product_id);
}

//#######################################################################//

function getdataSP(val){
    //alert(val);
    $('#productList').css('display','block');
    ur = "<?=base_url('assets/machine/ajax_productlist');?>"
    $.ajax({
      type: "POST",
      url: ur,
      data: {'value':val},
      success: function(data){
          console.log(data);
          $('#productList').html(data);
      }
    });
  }

//============start function spare price mapping=====================//

function selectSpareList(ths)
{
 var data =  $(ths).attr('jsvalue');
   if(data !== undefined)
     var data = JSON.parse(data);
  $('#sparelist').css('display','none');
  $('#prd').val(data.productname);
  $('#pri_id').val(data.Product_id);
}

function getdatasparepricemapping(val)
{
    //alert(val);
    $('#sparelist').css('display','block');
    ur = "<?=base_url('master/Account/get_sparelist');?>"
    $.ajax({
      type: "POST",
      url: ur,
      data: {'value':val},
      success: function(data){
          console.log(data);
          $('#sparelist').html(data);
      }
    });
}

$("#sparePriceMapForm").validate({
    rules: {},
      submitHandler: function(form) {
        ur = "<?=base_url('master/Account/ajax_sparePriceMapping');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 1 || data == 2){
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                     $("#resultarea").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#mapSpare .close").click();
                       $("#resultarea").text(" "); 
                       $('#sparePriceMapForm')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultarea").text(data);
                 }
              
                 ajex_manageSpareListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
});

function ajex_manageSpareListData(vendorid)
{
    ur = "<?=base_url('master/Account/get_manage_spare_price_mapping');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadsparepricemapping").empty().append(data).fadeIn();               
     }
    });
}

/*============close all function spare price mapping=====================*/  

/*============start function work order labor tasks =====================*/

$("#formlabortaskid").validate({
    rules: {
      task_type: "required", 
      cost_estimate: "required",
      cost_spent: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/machine_breakdown/insert_breakdown_labor_tasks');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 1 || data == 2){
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                     $("#resultarea").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#labortasksid .close").click();
                       $("#resultarea").text(" "); 
                       $('#formlabortaskid')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultarea").text(data);
                 }
              
                 ajex_manageLaborListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageLaborListData(vendorid)
{
    ur = "<?=base_url('maintenance/machine_breakdown/get_breakdown_labor_tasks');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadlabortasks").empty().append(data).fadeIn();
               
     }
  });
}

/*============close all function work order labor tasks =====================*/ 


/*============start function breakdown Parts =====================*/

$("#formspareid").validate({
    
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/machine_breakdown/insert_breakdown_parts');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                // alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareaspare").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#spareid .close").click();
                       $("#resultareaspare").text(" "); 
                       $('#formspareid')[0].reset(); 
                       //$("#dataTable").[0].reset(); ;
                    }, 1000);
                  }else{
                    $("#resultareaspare").text(data);
                 }
              
                 ajex_manageSparePartsListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
});

function ajex_manageSparePartsListData(vendorid)
{
    ur = "<?=base_url('maintenance/machine_breakdown/get_breakdown_parts');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadspareparts").empty().append(data).fadeIn();
               
     }
    });
}

/*============close all function breakdown Parts =====================*/ 

/*=====================start function breakdown Tools ===================================*/

$("#formtoolsid").validate({
    /*rules: {
      spare_name: "required", 
      suggested_qty: "required"
      },*/
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/machine_breakdown/insert_breakdown_tools');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                // alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareatools").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#toolsid .close").click();
                       $("#resultareatools").text(" "); 
                       //                                                                                       $('#formtoolsid')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultareatools").text(data);
                 }
              
                 ajex_manageToolsListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
});

function ajex_manageToolsListData(vendorid)
{
    ur = "<?=base_url('maintenance/machine_breakdown/get_breakdown_tools');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadtools").empty().append(data).fadeIn();
               
     }
    });
}

/*========================close all function breakdown Tools ==================================*/ 

/*=====================start function work order meter reading =================================*/

$("#formMeterReadingid").validate({
    rules: {
      meter_reading: "required", 
      meter_unite: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/machine_breakdown/insert_work_order_meter_reading');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                // alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareameterreading").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#meterreadingid .close").click();
                       $("#resultareameterreading").text(" "); 
                       $('#formMeterReadingid')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultareameterreading").text(data);
                 }
              
                 ajex_manageMeterReadingListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageMeterReadingListData(vendorid)
{
    ur = "<?=base_url('maintenance/machine_breakdown/get_work_order_meter_reading');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadmeterreading").empty().append(data).fadeIn();
               
     }
    });
}

/*========================close all function work order meter reading ===========================*/ 
/*=====================start function work order misc costs =================================*/

$("#formMiscCostid").validate({
    rules: {
      type_name: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/machine_breakdown/insert_work_order_misc_costs');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                // alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareamisc").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#misccostid .close").click();
                       $("#resultareamisc").text(" "); 
                       $('#formMiscCostid')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultareamisc").text(data);
                 }
              
                 ajex_manageMiscCostsListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageMiscCostsListData(vendorid){
  ur = "<?=base_url('maintenance/machine_breakdown/get_work_order_misc_costs');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadmisc").empty().append(data).fadeIn();
               
     }
    });
}

/*========================close all function work order misc costs ===========================*/

/*=====================start function work order files uploads =================================*/

function submitworkorderfilesupload() 
{
        
  var form_data = new FormData(document.getElementById("formfileuploads"));
  form_data.append("label", "WEBUPLOAD");

  $.ajax({
      url: "insert_work_order_files",
      type: "POST",
      data: form_data,
      processData: false,  // tell jQuery not to process the data
      contentType: false   // tell jQuery not to set contentType
  }).done(function( data ) {
  
  $("#addfiles .close").click();
   $('#formfileuploads')[0].reset();  
  ajex_manageFileUploadListData(<?=$_GET['id'];?>);
   
    console.log(data);
    //Perform ANy action after successfuly post data
       
  });
  return false;     
}
// ends


function ajex_manageFileUploadListData(production_id)
{
  //alert(production_id);
  ur = "get_work_order_file_upload";
   $.ajax({
     url: ur,
     data: { 'id' : production_id },
     type: "POST",
     success: function(data){
       $("#loadfileupload").empty().append(data).fadeIn();

    }
   });
}


/*========================close all function work order files uploads ==========================*/ 

 function getdataSPd(val)
 {
    //alert(val);
    $('#productLists').css('display','block');
    ur = "<?=base_url('assets/machine/ajax_productlist');?>"
    $.ajax({
      type: "POST",
      url: ur,
      data: {'value':val},
      success: function(data){
          console.log(data);
          $('#productLists').html(data);
      }
    });
}

//###########################################################//

$("#mapSpareForm").validate({
    rules: {},
      submitHandler: function(form) {
        ur = "<?=base_url('assets/machine/insert_spare');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 alert(data); // show response from the php script.
                    if(data == 1 || data == 2){
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                     $("#resultarea").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#mapSpare .close").click();
                       $("#resultarea").text(" "); 
                       $('#ItemForm')[0].reset(); 
                       $("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultarea").text(data);
                 }
                 //ajex_ItemListData();
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });


$('.email.dropdown').dropdown();

$('.emails.form').form({
    fields: {
        email: {
            identifier: 'country',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please select or add at least one to email address'
                }
            ]
        }
    }
});


</script>

<!-- =====================Start Scheduling modules all functions ================================= -->

<script type="text/javascript">



/*============start function schedule Parts =====================*/

$("#formscheduleparts").validate({
    
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_schedule_parts');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                // alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareaschedule").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#schedulespareid .close").click();
                       $("#resultareaschedule").text(" "); 
                       //$('#formscheduleparts')[0].reset(); 
                       //$("#dataTable").[0].reset(); ;
                    }, 1000);
                  }else{
                    $("#resultareaschedule").text(data);
                 }
              
                 ajex_SchedulePartsListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
});

function ajex_SchedulePartsListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_schedule_parts');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadspareparts").empty().append(data).fadeIn();
               
     }
    });
}

/*============close all function schedule Parts =====================*/ 

/*=====================start function schedule Tools ===================================*/

$("#formtoolschedule").validate({
    /*rules: {
      spare_name: "required", 
      suggested_qty: "required"
      },*/
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_schedule_tools');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                // alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareatoolss").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#scheduletoolsid .close").click();
                       $("#resultareatoolss").text(" "); 
                       //$('#resultareatoolss')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultareatoolss").text(data);
                 }
              
                 ajex_ScheduleToolsListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
});

function ajex_ScheduleToolsListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_schedule_tools');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadtools").empty().append(data).fadeIn();
               
     }
    });
}

/*========================close all function breakdown Tools ==================================*/ 



/*=====================start function add Scheduling =================================*/

$("#formschedulingid").validate({
 // alert("dd");
    rules: {
      trigger_code: "required",
      every_name: "required",
      unit_meter: "required",
      start_at: "required",
      end_by: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_scheduling');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareaschedule").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#addscheduling .close").click();
                       $("#resultareaschedule").text(" "); 
                       $('#formschedulingid')[0].reset(); 
                    }, 1000);
                  }else{
                    $("#resultareaschedule").text(data);
                 }
              
                 ajex_manageSchedulingListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
});

function ajex_manageSchedulingListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_schedule_trigger');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        $("#loadscheduling").empty().append(data).fadeIn();
               
     }
  });
}

/*========================close all function add Scheduling ===========================*/

/*=====================start function edit Scheduling =================================*/

$("#formeditschedulingid").validate({
 // alert("dd");
    rules: {
      trigger_code: "required",
      every_name: "required",
      unit_meter: "required",
      start_at: "required",
      end_by: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_edit_scheduling');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 2){
                        var msg = "Data Successfully Updated !";
                     $("#resultareaeditschedule").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#editscheduling .close").click();
                       $("#resultareaeditschedule").text(" "); 
                       $('#formeditschedulingid')[0].reset(); 
                    }, 1000);
                  }else{
                    $("#resultareaeditschedule").text(data);
                 }
              
                 ajex_manageEditSchedulingListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageEditSchedulingListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_schedule_trigger');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        $("#loadscheduling").empty().append(data).fadeIn();
               
     }
    });
}

/*========================close all function edit Scheduling ===========================*/

/*=====================start function Add Spare Scheduling =================================*/

$("#formaddspareschedulingid").validate({
    
     rules: {
      triggercode: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_add_spare_scheduling');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";
                     $("#resultareaaddspareschedule").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#myModal .close").click();
                       $("#resultareaaddspareschedule").text(" "); 
                       $('#formaddspareschedulingid')[0].reset(); 
                    }, 1000);
                  }else{
                    $("#resultareaaddspareschedule").text(data);
                 }
              
                 ajex_manageAddSpareSchedulingListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageAddSpareSchedulingListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_spare_schedule');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        $("#loadsparescheduling").empty().append(data).fadeIn();
               
     }
  });
}

/*========================close all function Add Spare Scheduling ===========================*/

/*=====================Start function Edit Spare Scheduling =================================*/

$("#formeditspareschedulingid").validate({
 // alert("dd");
    rules: {
      trigger_code: "required",
      spare_name: "required",
      suggested_qty: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_edit_spare_scheduling');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 2){
                        var msg = "Data Successfully Updated !";
                     $("#resultareaeditspareschedule").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#editspareschedulingid .close").click();
                       $("#resultareaeditspareschedule").text(" "); 
                       $('#formeditspareschedulingid')[0].reset(); 
                    }, 1000);
                  }else{
                    $("#resultareaeditspareschedule").text(data);
                 }
              
                 ajex_manageEditSpareSchedulingListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageEditSpareSchedulingListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_spare_schedule');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        $("#loadsparescheduling").empty().append(data).fadeIn();
               
     }
  });
}

/*========================close all function Edit Spare Scheduling ===========================*/
/*==================start function Add labor tasks Scheduling=================================*/

$("#formaddlabortaskschedulingid").validate({
    rules: {
      task_type: "required", 
      cost_estimate: "required",
      cost_spent: "required"
      },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_scheduling_labor_tasks');?>";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 //alert(data); // show response from the php script.
                    if(data == 1){
                        var msg = "Data Successfully Add !";

                     $("#resultaddlabortaskssm").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#addlabortaskschedulingid .close").click();
                       $("#resultaddlabortaskssm").text(" "); 
                       //$('#formaddlabortaskschedulingid')[0].reset(); 
                       //$("#pri_id").val("");
                    }, 1000);
                  }else{
                    $("#resultaddlabortaskssm").text(data);
                 }
              
                 ajex_manageLabortasksListData(<?=$_GET['id'];?>);
              
               },
                error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
            });
          return false;
        //form.preventDefault();
      }
  });

function ajex_manageLabortasksListData(vendorid)
{
    ur = "<?=base_url('maintenance/schedule/get_labor_tasks_scheduling');?>";
    $.ajax({
      url: ur,
      data: { 'id' : vendorid },
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#loadlabortaskschedule").empty().append(data).fadeIn();
               
     }
  });
}

/*============close all function Add labor tasks Scheduling =====================*/ 

</script>
<!-- =====================Close Scheduling modules all functions ================================= -->

</body>

</html>
<!-- starts here this javascript code is for multiple delete -->


<script type="text/javascript">
$(document).ready(function(){
	
	jQuery('#master').on('click', function(e) {
		if($(this).is(':checked',true))  
		{
			$(".sub_chk").prop('checked', true);  
		}  
		else  
		{  
			$(".sub_chk").prop('checked',false);  
		}  
	});
	
	
	//jQuery('.delete_all').on('click', function(e) { 
  $(document).delegate(".delete_all","click",function(e){
		var allVals = [];  
		$(".sub_chk:checked").each(function() {  
			allVals.push($(this).attr('data-id'));
		});  
		//alert(allVals.length); return false;  
		if(allVals.length <=0)  
		{  
			alert("Please select row.");  
		}  
		else {  
			//$("#loading").show(); 
			WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";  
			var check = confirm(WRN_PROFILE_DELETE);  
			if(check == true){  
				//for server side
				
				var table_name=document.getElementById("table_name").value;
				var pri_col=document.getElementById("pri_col").value;
				var join_selected_values = allVals.join(","); 
			//alert(join_selected_values);
				$.ajax({   
				  
					type: "POST",  
					url: "multiple_delete_two_table",  
					cache:false,  
					data: "ids="+join_selected_values+"&table_name="+table_name+"&pri_col="+pri_col,  
					success: function(response)  
					{   
						$("#loading").hide();  
						$("#msgdiv").html(response);
						//referesh table
					}   
				});
              //for client side
			  $.each(allVals, function( index, value ) {
				  $('table tr').filter("[data-row-id='" + value + "']").remove();
			  });
				

			}  
		}  
	});
	jQuery('.remove-row').on('click', function(e) {
		WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";  
			var check = confirm(WRN_PROFILE_DELETE);  
			if(check == true){
				$('table tr').filter("[data-row-id='" + $(this).attr('data-id') + "']").remove();
			}
	});
});
</script> 

<!-- ends here this javascript code is for multiple delete -->


<!-- starts here this javascript code is for single delete -->
<script type="text/javascript">
$(function() 
{
 
  $(document).delegate(".delbutton","click",function(){ 
  //Save the link in a variable called element
  var element = $(this);

  //Find the id of the link that was clicked
  var del_id = element.attr("id");

  //Built a url to send
  var info = 'id=' + del_id;
  //alert(info);
   if(confirm("Are you sure you want to delete ?"))
        {

   $.ajax({
     type: "GET",
     url: "delete_data",
     data: info,
     success: function(){
    
     }
   });

    $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
    .animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for single delete -->


<!-- starts here this javascript code is for single delete -->
<script type="text/javascript">
$(function() 
{
 
  $(document).delegate(".delbutton_spare_issue","click",function(){ 
  //Save the link in a variable called element
  var element = $(this);

  //Find the id of the link that was clicked
  var del_id = element.attr("id");

  //Built a url to send
  var info = 'id=' + del_id;
  //alert(info);
   if(confirm("Are you sure you want to delete ?"))
        {

   $.ajax({
     type: "GET",
     url: "delete_data_spare_issue",
     data: info,
     success: function(data){

      //alert(data);
    
     }
   });

    $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
    .animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for single delete -->

<!-- starts here this javascript code is for single delete -->
<script type="text/javascript">
$(function() 
{
 
  $(document).delegate(".delbutton_spare_order","click",function(){ 
  //Save the link in a variable called element
  var element = $(this);

  //Find the id of the link that was clicked
  var del_id = element.attr("id");

  //Built a url to send
  var info = 'id=' + del_id;
  //alert(info);
   if(confirm("Are you sure you want to delete ?"))
        {

   $.ajax({
     type: "GET",
     url: "delete_data_spare_order",
     data: info,
     success: function(){
    
     }
   });

    $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
    .animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for single delete -->

<!-- starts here this javascript code is for single delete -->
<script type="text/javascript">
$(function() 
{
 
  $(document).delegate(".delbutton_item","click",function(){ 
  //Save the link in a variable called element
  var element = $(this);

  //Find the id of the link that was clicked
  var del_id = element.attr("id");

  //Built a url to send
  var info = 'id=' + del_id;
  //alert(info);
   if(confirm("Are you sure you want to delete ?"))
  		  {

   $.ajax({
     type: "GET",
     url: "delete_data_item",
     data: info,
     success: function(){
    
     }
   });

    $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for single delete -->

<!-- starts here this javascript code is for  sales delete -->
<script type="text/javascript">
$(function() {


$(".delbutton_contact").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_contact_data",
   data: info,
   success: function(){
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for purchase delete -->

<!-- starts here this javascript code is for  sales delete -->
<script type="text/javascript">
$(function() {


$(".delbutton_location").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_location_data",
   data: info,
   success: function(){
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for purchase delete -->

<!-- starts here this javascript code is for  invoice delete -->
<script type="text/javascript">
$(function() {


$(".delbutton_rack").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;
//alert(info);
 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_rack_data",
   data: info,
   success: function(){
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for invoice delete -->

<!-- starts here this javascript code is for  invoice delete -->
<script type="text/javascript">
$(function() {


$(".delbutton_section").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;
//alert(info);
 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_section_data",
   data: info,
   success: function(){
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<script type="text/javascript">
$(function() {


$(".delbutton_machine").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;
//alert(info);
 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_machine_data",
   data: info,
   success: function(){
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for invoice delete -->


<!-- starts here this javascript code is for  sales delete -->
<script type="text/javascript">
$(function() {


$(".delbutton_bincard").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_bincard_data",
   data: info,
   success: function(data){

     // alert(data);
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for purchase delete -->

<script type="text/javascript">
$(function() {


$(".delbutton_return").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
      {

 $.ajax({
   type: "GET",
   url: "delete_return_data",
   data: info,
   success: function(data){

      //alert(data);
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
    .animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for purchase delete -->


<script type="text/javascript">
$(function() {


$(".delbutton_toolsissue").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
      {

 $.ajax({
   type: "GET",
   url: "delete_toolsissue_data",
   data: info,
   success: function(data){

      //alert(data);
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
    .animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for purchase delete -->


<script type="text/javascript">
$(function() {


$(".delbutton_consumable").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
      {

 $.ajax({
   type: "GET",
   url: "delete_consumable_data",
   data: info,
   success: function(data){

      //alert(data);
  
   }
 });

    $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
    .animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for purchase delete -->



<script>
function getXMLHTTP() { //fuction to return the xml http object

var xmlhttp=false;

try{

xmlhttp=new XMLHttpRequest();

}

catch(e) {

try{

xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

}

catch(e){

try{

xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

}

catch(e1){

xmlhttp=false;

}

}

}

return xmlhttp;

}
</script>

<!--Loader Js-->
<script src="<?=base_url();?>assets/js/loader.js"></script>

<script src="<?=base_url();?>assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/js/jszip.min.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/js/pdfmake.min.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/js/vfs_fonts.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
<script src="<?=base_url();?>assets/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
<!-- <script src="<?=base_url();?>assets/plugins/datatables/js/dataTables-script.js"></script> -->

<link href="<?=base_url();?>assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">

<!-----------------ends timmer code starts here------------->


<!-- starts here this javascript code is for  template delete -->
<script type="text/javascript">
$(function() {


$(".delbuttonTemplate").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;

 if(confirm("Are you sure you want to delete ?"))
		  {

 $.ajax({
   type: "GET",
   url: "delete_template",
   data: info,
   success: function(){
  
   }
 });

         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<!-- ends here this javascript code is for template delete -->


<script>

	function searchData1(){
		 currentCell = 0;
		 
		 var search_id=document.getElementById("search_id").value;	  
		 var priId=document.getElementById("priId").value;
		 var tableName=document.getElementById("tableName").value;
		 var fieldName=document.getElementById("fieldName").value;	 
		
		
		 	
		    if(xobj)
			 {
				
			 var obj=document.getElementById("prdsrch");
			 
			 xobj.open("GET","getSerachData?search_id="+search_id+"&tableName="+tableName+"&fieldName="+fieldName+"&priId="+priId,true);
			 xobj.onreadystatechange=function()
			  {
				  
			  if(xobj.readyState==4 && xobj.status==200)
			   {
				   
			    obj.innerHTML=xobj.responseText;
			   }
			  }
			 }
			 xobj.send(null);
}


function clear_data()
{
	document.getElementById("prdsrch").innerHTML='';
}







function editRowCategory(ths,thisvalue){  
   var value  =  $('#'+ths).attr("arrt");
   var cat_id =  $('#'+ths).attr("cat_id");
  
    $('#selectCategory').val(cat_id).prop('selected', true);
    $('#category').val(value);
   
    $('#target').attr("submit_value","edit");
    $('#editvalue').val(ths);
    var property  =  $(thisvalue).attr("property");
     if(property == "view"){
	 	 $('.top_title').html('View ');
         $('#button').css("display",'none'); 
         $('#category').attr('readonly', 'true'); 
         $('#selectCategory').attr('disabled', 'true'); 
		 $(' #target').hide(); 
     }else{
	 	 $('.top_title').html('Update ');
         $('#button').css("display",'block');
         $('#category').attr("readonly",false); 
         $('#selectCategory').attr("disabled",false); 
		 $(' #target').show();
     }
    

}



jQuery('.delete_other').on('click', function(e) { 
	alert();
		var allVals = [];  
		$(".sub_chk:checked").each(function() {  
			allVals.push($(this).attr('data-id'));
		});  
		//alert(allVals.length); return false;  
		if(allVals.length <=0)  
		{  
			//alert("Please select row.");  
		}  
		else {  
			//$("#loading").show(); 
			WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";  
			var check = confirm(WRN_PROFILE_DELETE);  
			if(check == true){  
				//for server side
				
				var table_name=document.getElementById("table_name").value;
				var pri_col=document.getElementById("pri_col").value;
				var join_selected_values = allVals.join(","); 
			//alert(join_selected_values);
				$.ajax({   
				  
					type: "POST",  
					url: "multiple_delete_two_table",  
					cache:false,  
					data: "ids="+join_selected_values+"&table_name="+table_name+"&pri_col="+pri_col,  
					success: function(response)  
					{   
						$("#loading").hide();  
						$("#msgdiv").html(response);
						//referesh table
					}   
				});
              //for client side
			  $.each(allVals, function( index, value ) {
				  $('table tr').filter("[data-row-id='" + value + "']").remove();
			  });
				

			}  
		}  
	});
	jQuery('.remove-row').on('click', function(e) {
		WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";  
			var check = confirm(WRN_PROFILE_DELETE);  
			if(check == true){
				$('table tr').filter("[data-row-id='" + $(this).attr('data-id') + "']").remove();
			}
	});



</script>



<script type="text/javascript">

//-----------------------------starts Search Code Table-------------------------------------  

function doSearch() 
{

   //alert('afsdfasdf');
   var abc = document.getElementById('searchTerm').value;
   var searchText=abc.toLowerCase();
   
   var targetTable = document.getElementById('getDataTable');
   var targetTableColCount;
          // alert('aadf');
   //Loop through table rows
   for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++) {
       var rowData = '';

       //Get column count from header row
       if (rowIndex == 0) {
          targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
          continue; //do not execute further code for header row.
       }
               
       //Process data rows. (rowIndex >= 1)
       for (var colIndex = 0; colIndex < targetTableColCount; colIndex++) {
           rowData += targetTable.rows.item(rowIndex).cells.item(colIndex).textContent.toLowerCase();
       }

       //If search term is not found in row data
       //then hide the row, else show
       if (rowData.indexOf(searchText) == -1)
           targetTable.rows.item(rowIndex).style.display = 'none';
       else
           targetTable.rows.item(rowIndex).style.display = 'table-row';
   }
}

//---------------------------------------ends Search Code Table-------------------------------------  


//*************************************Scheduling Metering ******************************************



function view_spare_mapp_trig(ths) {
  //console.log('edit ready !');
  $('.error').css('display','none');
  var rowValue = $(ths).attr('arrt');
  var rowValuea = $(ths).attr('attr');
  
  var button_property = $(ths).attr('property');
  console.log(rowValue);
  editVala="";
   if(rowValue !== undefined)
     var editVal = JSON.parse(rowValue);
     var editVala=JSON.parse(rowValuea);
	console.log(editVala);

  $('#id_spare').val(editVal.id);
  $('#every_reading_spare').val(editVal.every_reading);
  $('#trigger_code_spare_html').html(editVal.trigger_code);
  $('#trigger_code_spare').val(editVal.id);
  $('#unit_spare').val(editVal.unit).trigger('chosen:updated');
  $('#start_reading_spare').val(editVal.starting_reading);
  $('#next_trigger_reading_spareHtml').html(editVal.next_trigger_reading);
  $('#readtype_spare').val(editVal.type).trigger('chosen:updated');
   
  
 var endby =  $('#end_by_reading_spare').val(editVal.endby_reading);
 
  if(editVal.type == 'End By'){
  $(endby).show();
  

  }else{
  $(endby).hide();
  }
  
  $('#next_trigger_reading_spare').val(editVal.next_trigger_reading);
  

  var cnt;
var el="";
$('.sparetable').empty();
  for(i=0;i<=editVala.length;i++)
  {

    cnt=i;
    el='<tr><th><input type="text" name="qt[]" value="'+editVala[i].productname+'" class="form-control" readonly></th><th><input type="text" name="qname[]" value="'+editVala[i].quantity+'" class="form-control" readonly></th></tr>';
    //el='<tr><th><input type="text" name="qt[]" value="'+editVala[i].productname+'"></th><th><input type="text" name="qname[]" value="'+editVala[i].quantity+'"></th></tr>';
    $(".sparetable").append(el);

  }

   
};



//*************************************************************************************************

function addMultiReturn()
{


   var spareid  =  $('#spareName').val();

    if(spareid=="")
    {
      alert("please Select Spare .");
    }
    else
    {
  
    //alert();
    var e = document.getElementById("spareName");
    var sparename = e.options[e.selectedIndex].text;
    
    $('#spareName option:selected').remove();

    var count=$('#cntVal').val();
    var i;
    for( i=0; i<count; i++)
    {
     
     //alert(i);

      var via_type =  $('#product_type'+i).val();
      var price    =  $('#purchase_price'+i).val();
      var rt_qnty  =  $('#rtrn_qty'+i).val();

      var loc    = $('#location_id'+i).val();
      var locVal = $('#location'+i).val();

      var rack    = $('#rack_id'+i).val();
      var rackVal = $('#rack'+i).val();

      //var vendor    = $('#vendor_id'+i).val();
      //var vendorName = $('#vendor'+i).val();

     if(rt_qnty != '')
     {
      $('#getDataTable').append('<tr><td style="display:none"><p >'+spareid+'</p><input type ="hidden" name="spareids[]" value="'+spareid+'"><input type ="hidden" name="via_types[]" value="'+via_type+'"></td><td><p id="spareName">'+sparename+'</p></td><td><input type ="hidden" name="locs[]" value="'+loc+'">'+locVal+'</td><td><input type ="hidden" name="racks[]" value="'+rack+'">'+rackVal+'</td><td><input type ="hidden" name="prices[]" value="'+price+'">'+price+'</td><td><input type ="hidden" name="qtyname[]" id="qntyy" value="'+rt_qnty+'">'+rt_qnty+'</td><td><i spareId="'+spareid+'" spareName="'+sparename+'" class="fa fa-trash  fa-2x" id="returndel" aria-hidden="true"></i></td></tr>');
      }
    }

   $('#getDataTablePage').empty();
   $('#vendor_id').attr('disabled',true);

   var z=1;
   var c=$("#countRow").val();
   $("#countRow").val(Number(c)+ Number(z));
   
  }

}


function addMultiIssue(){


   var section  =  $('#section').val();
   var spareid  =  $('#spare_nameid').val();
   //var issuQty  =  $("input[name='issue_qty']").val();

    if(section == '')
    {
      alert("Please Select Section.");
    }
    else if(spareid=="")
    {
      alert("Please Select Tools .");
    }
    // else if(issuQty == "")
    // {
    //   alert("Please Enter Issue Qty")
    // }
    else
    {
  
    //alert();
    var e = document.getElementById("spare_nameid");
    var sparename = e.options[e.selectedIndex].text;
    
    $('#spare_nameid option:selected').remove();

    var count=$('#cntVal').val();
    var i;
    for( i=0; i<count; i++)
    {
     
     //alert(i);

      var via_type =  $('#product_type'+i).val();
      var price    =  $('#purchase_price'+i).val();
      var is_qnty  =  $('#issue_qty'+i).val();

      var loc    = $('#location_id'+i).val();
      var locVal = $('#location'+i).val();

      var rack    = $('#rack_id'+i).val();
      var rackVal = $('#rack'+i).val();

      var vendor    = $('#vendor_id'+i).val();
      var vendorName = $('#vendor'+i).val();

     if(is_qnty != '')
     {
      
      $('#dataTable').append('<tr><td style="display:none"><p >'+spareid+'</p><input type ="hidden" name="section" value="'+section+'"><input type ="hidden" name="spareids[]" value="'+spareid+'"><input type ="hidden" name="via_types[]" value="'+via_type+'"></td><td><p id="spareName">'+sparename+'</p></td><td><input type ="hidden" name="locs[]" value="'+loc+'">'+locVal+'</td><td><input type ="hidden" name="racks[]" value="'+rack+'">'+rackVal+'</td><td><input type ="hidden" name="vendors[]" value="'+vendor+'">'+vendorName+'</td><td><input type ="hidden" name="prices[]" value="'+price+'">'+price+'</td><td><input type ="hidden" name="qtyname[]" id="qntyy" value="'+is_qnty+'">'+is_qnty+'</td><td><i spareId="'+spareid+'" spareName="'+sparename+'" class="fa fa-trash  fa-2x" id="quotationdel" aria-hidden="true"></i></td></tr>');

        var z=1;
        var c=$("#countRow").val();
        $("#countRow").val(Number(c)+ Number(z));

      }

    }

   $('#dataTablePage').empty();   
   
  }
}


function addrowsIssue(){


   var section =  $('#section').val();
   var spareid  =  $('#spare_nameid').val();
   var loc      =  $('#location_rack_id').val();
   var rack     =  $('#rack_id').val();
   var vendor   =  $('#vendor_id').val();
   var price    =  $('#purchase_price').val();
   var qnty_sp  =  $('#qtyid').val();
   var via_type =  $('#product_types').val();

    if(section==""){
      alert("please Select Section.");
    }else if(spareid==""){
      alert("please Select Parts & Supplies .");
    }else if(qnty_sp==""){  
       alert("please Enter Quantity.");
    }else{
  
  //alert();
  var e = document.getElementById("spare_nameid");
  var sparename = e.options[e.selectedIndex].text;

  var l = document.getElementById("location_rack_id");
  var locVal = l.options[l.selectedIndex].text;

  var r = document.getElementById("rack_id");
  var rackVal = r.options[r.selectedIndex].text;


  var v = document.getElementById("vendor_id");
  var vendorName = v.options[v.selectedIndex].text;  


//document.getElementById("locationVal").value=strMake;
   $('#spare_nameid option:selected').remove();
     $('#dataTable').append('<tr>                                                                              <td style="display:none"><p >'+spareid+'</p><input type ="hidden" name="section" value="'+section+'"><input type ="hidden" name="spareids[]" value="'+spareid+'"><input type ="hidden" name="via_types[]" value="'+via_type+'"></td><td><p id="spareName">'+sparename+'</p></td><td><input type ="hidden" name="locs[]" value="'+loc+'">'+locVal+'</td><td><input type ="hidden" name="racks[]" value="'+rack+'">'+rackVal+'</td><td><input type ="hidden" name="vendors[]" value="'+vendor+'">'+vendorName+'</td><td><input type ="hidden" name="prices[]" value="'+price+'">'+price+'</td><td><input type ="hidden" name="qtyname[]" id="qntyy" value="'+qnty_sp+'">'+qnty_sp+'</td><td><i spareId="'+spareid+'" spareName="'+sparename+'" class="fa fa-trash  fa-2x" id="quotationdel" aria-hidden="true"></i></td><td colspan="2"></td></tr>');


       $('#spare_nameid').val("");
       $('#location_rack_id').val("");
       $('#rack_id').val("");
       $('#vendor_id').val("");
       $('#qtyid').val("");
       $('#purchase_price').val("");
       $('#qty_pallet').val("");
       $('#getQn').val("");

       var i=1;
       var c=$("#countRow").val();
       $("#countRow").val(Number(c)+ Number(i));
    }
  }
//===========

function addrowsSpare(){

   var triggercodeid =  $('#triggercodeid').val();
   var spareid   =  $('#spare_nameid').val();
   var qnty_sp =  $('#qtyid').val();
   
    if(triggercodeid==""){
      alert("please Select Trigger Code.");
    }else if(spareid==""){
      alert("please Select Spare.");
    }else if(qnty_sp==""){  
       alert("please Enter Quantity.");
    }else{
  
  var e = document.getElementById("spare_nameid");
var sparename = e.options[e.selectedIndex].text;


//document.getElementById("locationVal").value=strMake;
   $('#spare_nameid option:selected').remove();
     $('#dataTable').append('<tr><td style="display:none"><p >'+spareid+'</p><input type ="hidden" name="triggercodename[]" value="'+triggercodeid+'"><input type ="hidden" name="spareids[]" value="'+spareid+'"></td><td colspan="2"><p id="spareName">'+sparename+'</p></td><td><input type ="hidden" name="qtyname[]" id="qntyy" value="'+qnty_sp+'">'+qnty_sp+'</td><td><i spareId="'+spareid+'" spareName="'+sparename+'" class="fa fa-trash  fa-2x" id="quotationdel" aria-hidden="true"></i></td><td colspan="3"></td></tr>');


       $('#spare_nameid').val("");
       $('#qtyid').val("");
    }
  }

 function addrows(){

   var triggercodeid =  $('#triggercodeid').val();
   var spareid   =  $('#spare_nameid').val();
   var qnty_sp =  $('#qtyid').val();
   var via_type = $('#product_type').val();

    if(triggercodeid==""){
      alert("please Select Trigger Code.");
    }else if(spareid==""){
      alert("please Select Spare.");
    }else if(qnty_sp==""){  
       alert("please Enter Quantity.");
    }else{
	
	var e = document.getElementById("spare_nameid");
  var sparename = e.options[e.selectedIndex].text;


//document.getElementById("locationVal").value=strMake;
	 $('#spare_nameid option:selected').remove();
     $('#dataTable').append('<tr><td style="display:none"><p >'+spareid+'</p><input type ="hidden" name="triggercodename[]" value="'+triggercodeid+'"><input type ="hidden" id="sp" name="spareids[]" value="'+spareid+'"><input type ="hidden" name="via_types[]" value="'+via_type+'"></td><td><p id="spareName">'+sparename+'</p></td><td><input type ="hidden" name="qtyname[]" id="qntyy" value="'+qnty_sp+'">'+qnty_sp+'</td><td><i spareId="'+spareid+'" spareName="'+sparename+'" class="fa fa-trash  fa-2x" id="quotationdel" aria-hidden="true"></i></td><td colspan="2"></td></tr>');


       $('#spare_nameid').val("");
       $('#qtyid').val("");
       
       var i=1;
       var c=$("#countRow").val();
       $("#countRow").val(Number(c)+ Number(i));

    }
  }


$(document).delegate("#quotationdel","click",function(){

  var spareName = $(this).attr('spareName');
  var spareId = $(this).attr('spareId');

  $(this).parent().parent().remove();
  $("#spare_nameid").append('<option value="'+spareId+'">'+spareName+'</option>');

});


$(document).delegate("#returndel","click",function(){

  var spareName = $(this).attr('spareName');
  var spareId = $(this).attr('spareId');
  $('#vendor_id').attr('disabled',false);

  $(this).parent().parent().remove();
  $("#spareName").append('<option value="'+spareId+'">'+spareName+'</option>');

});

//************************************************************************************************

 function addtoolrows(){

   //var triggercodeid =  $('#triggercodeid').val();
   var toolid   =  $('#tool_nameid').val();
   var qnty_tool =  $('#tool_qtyid').val();
   var via_type = $('#product_type_tools').val();
   //alert(spareid);
    if(toolid==""){
      alert("please Select Tool.");
    }else if(qnty_tool==""){  
       alert("please Enter Quantity.");
    }else{
  
  var e = document.getElementById("tool_nameid");
var toolname = e.options[e.selectedIndex].text;


//document.getElementById("locationVal").value=strMake;
   $('#tool_nameid option:selected').remove();
     $('#tooldataTable').append('<tr><td style="display:none"><p >'+toolid+'</p><input type ="hidden" name="toolids[]" value="'+toolid+'"><input type ="hidden" name="via_types[]" value="'+via_type+'"></td><td><p id="toolname">'+toolname+'</p></td><td><input type ="hidden" name="qtyname[]" id="qntyy" value="'+qnty_tool+'">'+qnty_tool+'</td><td><i toolId="'+toolid+'" toolName="'+toolname+'" class="fa fa-trash  fa-2x" id="tooldel" aria-hidden="true"></i></td><td colspan="2"></td></tr>');


       $('#tool_nameid').val("");
       $('#tool_qtyid').val("");
    }
  }


  $(document).delegate("#tooldel","click",function(){

    var toolName = $(this).attr('toolName');
    var toolId = $(this).attr('toolId');
    
      $(this).parent().parent().remove();
    $("#tool_nameid").append('<option value="'+toolId+'">'+toolName+'</option>');
    });

//********************************************************************************************

$("#SpareEditMapForm").validate({
     rules: {
      trigger_code_shed: "required",
     },
      submitHandler: function(form) {
        ur = "<?=base_url('maintenance/schedule/insert_schedule_triggering_spare1');?>";
        var formData = new FormData(form);
		
        // console.log(formData);
         // console.log( $("#QuotationMapForm").serialize() );
        $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
			        	//data : $('#contactForm').serialize(), // serializes the form's elements.
                success : function (data) {
                  //alert(data); // show response from the php script.
                    if(data == 1 || data == 2){
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                     $("#resultarea5").text(msg); 
                       setTimeout(function() {   //calls click event after a certain time
                       $("#myModal .close").click();
                       $("#resultarea5").text(" "); 
                       $('#SpareEditMapForm')[0].reset(); 
                       
                    }, 1000);
                  }else{
                    $("#resultarea5").text(data);
                 }
                 ajex_ItemListData();
               },
                error: function(data){
                    alert("error");
              },
              cache: false,
              contentType: false,
              processData: false
            });
          return false;

        //form.preventDefault();
      }
  });
  



function editSparetrigger(ths) {
  //console.log('edit ready !');
  $('.error').css('display','none');
  var rowValue = $(ths).attr('arrt');
  
  var button_property = $(ths).attr('property');
  console.log(rowValue);
   if(rowValue !== undefined)
     var editVal = JSON.parse(rowValue);
	//alert(editVal.trigger_code);
  $('#pri_id_spare_sched_edit').val(editVal.id);
  $('#pri_id_schedule_id_edit').val(editVal.schedule_id);
  $('#trigger_code_shed_edit').val(editVal.trigger_code).trigger('chosen:updated');
  $('#unit_meter').val(editVal.unit).trigger('chosen:updated');
  $('#start_reading_meter').val(editVal.starting_reading);
  $('#next_trigger_reading_meterHtml').html(editVal.next_trigger_reading);
 
  $('#readtype_meter').val(editVal.type).trigger('chosen:updated');
  
 var endby =  $('#end_by_reading_meter').val(editVal.endby_reading);
 
  if(editVal.type == 'End By'){
  $(endby).show();
  

  }else{
  $(endby).hide();
  }
  
  $('#next_trigger_reading_meter').val(editVal.next_trigger_reading);
  
     
};


//*******************************************************************************************************



$("#ItemFormMapp").validate({
	
    rules: {
      spare_name_sched: "required",
      trigger_code_shed:"required"
    },
      submitHandler: function(form) {
        
		//ur = "<?=base_url('master/Item/insert_item');?>";
		
        var formData = new FormData(form);
		
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
					
                //  alert(data); // show response from the php script.
                    if(data == 1 || data == 2){
						
						
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                     //$("#resultarea").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       //$("#modal-0 .close").click();
                       //$("#resultarea").text(" "); 
                       //$('#ItemForm')[0].reset(); 
                       //$("#contact_id").val("");
                    }, 1000);
                  }else{
                    //$("#resultarea").text(data);
                 }
                // ajex_ItemListData();
               },
                error: function(data){
                    alert("error");
              },
              cache: false,
              contentType: false,
              processData: false
            });
          return false;
        //form.preventDefault();
      }
  });


</script>



<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>

<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.datetimepicker.css"/>

<script src="<?=base_url();?>assets/js/jquery.js"></script>
<script src="<?=base_url();?>assets/js/jquery.datetimepicker.js"></script>
<script>

function datetimeplugin()
{
 
$('.datetimepicker_maskedit').datetimepicker({

  mask:'9999/19/39 29:59',
});

$('#datetimepicker').datetimepicker();
$('#datetimepicker').datetimepicker({value:'2015/04/15 05:06'});
$('#datetimepicker1').datetimepicker({
  datepicker:false,
  format:'H:i',
  step:5
});

}


$('#datetimepicker_mask1').datetimepicker({

  mask:'9999/19/39 29:59',
});

$('#datetimepicker').datetimepicker();
$('#datetimepicker').datetimepicker({value:'2015/04/15 05:06'});
$('#datetimepicker1').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});


$('#datetimepicker_mask3').datetimepicker({

  mask:'9999/19/39 29:59',
});

$('#datetimepicker').datetimepicker();
$('#datetimepicker').datetimepicker({value:'2015/04/15 05:06'});
$('#datetimepicker1').datetimepicker({
  datepicker:false,
  format:'H:i',
  step:5
});




//************************** New Submit Form for multiple **************************************

function submitForm() 
{
      
  var form_data = new FormData(document.getElementById("myform"));
  form_data.append("label", "WEBUPLOAD");
  
  
  //var spare_name_schedd=document.getElementById("spare_name_schedd").value;
  //alert(spare_name_schedd);
  
  
  $.ajax({
      url: "<?=base_url();?>maintenance/schedule/insert_schedule_triggering_spare1",
      type: "POST",
      data: form_data,
      processData: false,  // tell jQuery not to process the data
      contentType: false   // tell jQuery not to set contentType
  }).done(function( data ) {
	// alert(data);
    //console.log(data);
	
	 if(data == 1 || data == 2){
	  if(data == 1)
		var msg = "Data Successfully Add !";
	  else
		var msg = "Data Successfully Updated !";
	
	 $("#resultarea56").text(msg); 
	 setTimeout(function() {   //calls click event after a certain time
	   $("#myModal .close").click();
	   $("#resultarea56").text(" "); 
	   $('#myform')[0].reset(); 
	   $("#pri_id_spare_sched").val("");
	}, 1000);
	}else{
	$("#resultarea56").text(data);
	}
    //Perform ANy action after successfuly post data
      
  });
  ajex_spare_Data(); 
  return false;     
}

//*******************************************************************************************

function submitForm_edit() {
      
  var form_data = new FormData(document.getElementById("myform_edit"));
  form_data.append("label", "WEBUPLOAD");
  
  
  //var spare_name_schedd=document.getElementById("spare_name_schedd").value;
  //alert(spare_name_schedd);
  
  
  $.ajax({
      url: "<?=base_url();?>maintenance/schedule/insert_schedule_triggering_spare12",
      type: "POST",
      data: form_data,
      processData: false,  // tell jQuery not to process the data
      contentType: false   // tell jQuery not to set contentType
  }).done(function( data ) {
	// alert(data);
    //console.log(data);
	
	 if(data == 1 || data == 2){
	  if(data == 1)
		var msg = "Data Successfully Add !";
	  else
		var msg = "Data Successfully Updated !";
	//alert(form_data);
	 $("#resultarea567").text(msg); 
	 setTimeout(function() {   //calls click event after a certain time
	   $("#myModal_edit .close").click();
	   $("#resultarea567").text(" "); 
	   $('#myform_edit')[0].reset(); 
	   $("#pri_id_spare_sched_edit").val("");
	}, 1000);
	}else{
	$("#resultarea567").text(data);
	}
    //Perform ANy action after successfuly post data
      
  });
  ajex_spare_Data(); 
  return false;     
}


//*************************************************************************************************

function ajex_spare_Data()
{

  //alert();
  ur = "<?=base_url('maintenance/schedule/ajex_spare_Data');?>";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#listingData").empty().append(data).fadeIn();
        
       
     }
    });
}

</script>

<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">

<link href="<?=base_url();?>assets/chosen/chosen.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>