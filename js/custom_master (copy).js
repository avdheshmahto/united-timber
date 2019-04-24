var base_url = "united-timber";

//==========================================Contact Form================================//

$("#contactForm").validate({
    rules: {
      first_name: "required",
      groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_contact";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#contactForm').serialize(), // serializes the form's elements.
                success : function (data) {
                  // console.log(data);  
                  // alert(data); // show response from the php script.
                 
                    if(data == 1 || data == 2){

                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                      $("#resultareacontact").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#Contactmodal .close").click();
                      $("#resultareacontact").text(" "); 
                      $('#contactForm')[0].reset(); 
                      $("#contactForm").val("");
                    }, 1000);
                 }else{
                    $("#resultareacontact").text(data);
                 }
                 ajex_contactListData();
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_contactListData(){
  ur = "ajex_ContactListData";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        // $("#listingDataremove").hide();
        // $("#listingData").append(data);
        // $("#listingData").fadeIn();
        $("#listingData").empty().append(data).fadeIn();
       // console.log(data);
     }
  });

}

function editContact(ths) {
  //console.log('edit ready !');
  $('.error').css('display','none');
  var rowValue = $(ths).attr('arrt');
  var button_property = $(ths).attr('property');
  console.log(button_property);
   if(rowValue !== undefined)
     var editVal = JSON.parse(rowValue);
      //alert(editVal.group_name);
    if(button_property != 'view')
      $('#contact_id').val(editVal.contact_id);
      $('#first_name').val(editVal.first_name);
      $('#addres_id').val(editVal.addres_id);
      $('#groupName').val(editVal.group_name).prop('selected', true);
      $('#contact_person').val(editVal.contact_person);      
      $('#email').val(editVal.email);
      $('#mobile').val(editVal.mobile);
      $('#phone').val(editVal.phone);
      $('#pan_no').val(editVal.IT_Pan);     
      $('#gstin').val(editVal.gst); 
      $('#address1').val(editVal.address1);      
      $('#address3').val(editVal.address3);
      $('#city').val(editVal.city);
      $('#state_id').val(editVal.state_id).prop('selected', true);
      $('#pin_code').val(editVal.pin_code);


    
      if(button_property == 'view'){
       $('.top_title').html('View ');
       $('.button').hide(); 
       //$('#button').css('display','none');
       $("#contactForm :input").prop("disabled", true);
      }else{
       $('.top_title').html('Update ');
       $('.button').show(); 
       //$('#button').css('display','block');
       // $('#buttonnn').css('display','none');
       $("#contactForm :input").prop("disabled", false);
      }
};


//************************************Spare Form**************************************************

$("#ItemForm").validate({    
    rules: {
      sku_no: "required",
      item_name:"required"
    },
      submitHandler: function(form) {
        ur = "insert_item";
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
                       // $("#dataTable").load("#dataTable");
                      else
                        var msg = "Data Successfully Updated !";

            
                     $("#resultareaspares").text(msg);
                     /*$(".tablejs").animate({ backgroundColor: "#fbc7c7" }, "fast").animate({ opacity: "hide" }, "slow");*/
                     $(".headingclass.addRowdel").siblings().remove(); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#modal-0 .close").click();
                       $("#resultareaspares").text(" "); 
                       $('#ItemForm')[0].reset(); 
                       // $('#dataTable')[0].reset();
                       // $('.tablejs').trigger("reset");
                       
                       $("#Product_id").val("");
                    }, 1000);
                  }else{
                    $("#resultareaspares").text(data);
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


$("#ItemForm1").validate({  
    rules: {
      sku_no: "required",
      item_name:"required"
    },
      submitHandler: function(form) {
        ur = "insert_item";
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

                     $("#resultarea1").text(msg);
                     var load="<img src='img/loading.gif'>"; 
                /*    document.getElementsByName("location[]").clear();
                      document.getElementsByName("rack[]").clear();
                      document.getElementsByName("qtyy[]").clear();*/
                      $("#addRowbody").remove();      
                      $(".savebutton").remove();
                     //$(".buttonsall").append(load);
                     //$(".savebutton").href("../assets/images/loading-photo.gif");
                     setTimeout(function() {   //calls click event after a certain time
                       $("#editItem .close").click();
                       $("#resultarea1").text(" "); 
                       $('#ItemForm1')[0].reset(); 
                       
                    }, 1000);
                  }else{
                    $("#resultarea1").text(data);
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


function ajex_ItemListData()
{

  ur = "ajex_ItemListData";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#listingData").empty().append(data).fadeIn();
        
       
     }
    });
}

//--------------------------- Main Location Starts-----------------------------------

$("#Location_form").validate({
  
  rules:
  {    
    loc_name:"required",
  },
  submitHandler:function(form){
    var formData=new FormData(form);
    
    ur="Insert_Location";
      
    if(document.getElementById("Location_Validation").innerHTML=="")
    {
      
    $.ajax({
          type:"POST",
          url:ur,
          data:formData,
          success:function(data){

              if(data==0)
                  {
                    $("#success-message").text("Add Location Successfully!");
                  }
              else if(data==1)
                  {
                    $("#success-message").text("Update Location Successfully!");
                  }            
              document.getElementById("Location_Validation").innerHTML="";
              setTimeout(function(){
              $("#editlocation .close").click();
              $("#success-message").text("");
                   
              $("#Location_Form")[0].reset();

              },1000);
                      
            LocationTable();

          },
            error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
           
            });
      }
       return false;
    }
});  


function LocationTable()
{
    ur="LocationTable";
    $.ajax({
          type:"POST",
          url:ur,
          success:function(data)
          {            
            $("#loadData").empty().append(data);
          }


    });
}


function editlocation(th)
{

    var rowVal=$(th).attr("attr");
    var button_det=$(th).attr("property");
    
    var editLOC=JSON.parse(rowVal);
    
    $("#loc_det").val(editLOC.keyvalue);
    $("#id").val(editLOC.serial_number);
     //$("#summernote").code(editVal.description);
         //$("#optionsRadios").code(editVal.visibility);
    if(button_det=='view')
        {
          $("#title").html("View Location");
            
          $('#Location_form :input[type="text"]').attr('disabled',true);

          $('#Location_form :input[type="submit"]').attr('disabled',true);


          $("#closes").prop('disabled',false);

          $(".save").hide();

        }
    else

    {

      $("#title").html("Update Location");
      
      $('#Location_form :input[type="text"]').attr('disabled',false);

      $('#Location_form :input[type="submit"]').attr('disabled',false);

      $("#closes").attr('disabled',false);

      $(".save").show();
    }
  }


$(".addlocation").click(function()
{
    
    $("#loc_det").val("");
    $("#id").val("");
    $('#Location_form :input[type="submit"]').attr('disabled',false);
    $(".save").show();
    document.getElementById("Location_Validation").innerHTML="";
});


//------------------------------------Location Rack starts------------------------------------


$("#LocationRackForm").validate({
  
  rules:
  {
    
    location_rack_id:"required",
    rack_name:"required"

  },
  submitHandler:function(form){
    var formData=new FormData(form);
    
    ur="insert_location_rack";
   
    if(document.getElementById("Location_Validation").innerHTML=="")
            {
    $.ajax({
          type:"POST",
          url:ur,
          data:formData,
          success:function(data){

            if(data == 1 || data == 2)
            {

              if(data==1)
                {
                    var msg="Data Added Successfully";           
                }
              else
                {
                  var msg="Data Edited Successfully";           
                }
              $("#operationarea").text(msg);
              document.getElementById("Location_Validation").innerHTML="";
              setTimeout(function(){
              $("#modal-0 .close").click();
              $("#operationarea").text("");
        
              document.getElementById("location_rack_id").options.length = 0;

            $("#LocationRackForm")[0].reset();

                },500);
            }
            else
            {
              $("#operationarea").text(data);
        
            }
            LocationRackTable();
          },
            error: function(data){
                    alert("error");
                },
                cache: false,
                contentType: false,
                processData: false
           
            });
         }
          return false;
        }
});      

function LocationRackTable()
{
        
        ur="LocationRackData";

        $.ajax({
          url:ur,
          type:"POST",
          success:function(data){
           
            
           $("#loadData").empty().append(data).fadeIn();
            
          }  
        });

}

$(".addlocationRack").click(function()
{
    
    $("#location_rack_id").val("");
    $("#rack_name").val("");
    $(".ui fluid email search dropdown").val("");
    //$("#id").val("");
    $('#LocationRackForm :input[type="submit"]').attr('disabled',false);
    $('#LocationRackFormEdit :input[type="submit"]').attr('disabled',false);
   // $(".save").show();
    document.getElementById("Location_Validation").innerHTML="";

});


//******************************************Tool Insert*********************************************
  
  $("#ToolForm").validate({
  
    rules: {
      sku_no: "required",
      item_name:"required"
    },
      submitHandler: function(form) {
        ur = "insert_tools";
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

                     $("#resultarea").text(msg); 
                     setTimeout(function() {   //calls click event after a certain time
                       $("#modal-0 .close").click();
                       $("#resultarea").text(" "); 
                       $('#ToolForm')[0].reset(); 
                     //  $("#contact_id").val("");
                    }, 1000);
                  }else{
                    $("#resultarea").text(data);
                 }
                 ajex_toolListData();
                // alert("hello");
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
  
  
 $("#ToolForm1").validate({

    rules: {
      sku_no: "required",
      item_name:"required"
    },
      submitHandler: function(form) {
        ur = "insert_tools";
        var formData = new FormData(form);
            $.ajax({
                type : "POST",
                url  :  ur, 
                //dataType : 'json', // Notice json here
                data : formData, // serializes the form's elements.
                success : function (data) {
                 // alert(data); // show response from the php script.
                       if(data == 1 || data == 2){
                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";
                      
                     $("#resultarea1").text(msg); 

                     setTimeout(function() {   //calls click event after a certain time
                       $("#edittool .close").click();
                       $("#resultarea1").text(" "); 
                       $('#ToolForm1')[0].reset(); 
                      
                    }, 1000);
                    }else{
                    $("#resultarea1").text(data);
                 }
                 
                 ajex_toolListData();
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
  

function ajex_toolListData()
{

  //alert("anoj");
  ur = "ajex_toolsecondpageListData";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data)
      {
         //alert(data);
         //$("#listingData").hide();
         $("#listingDataoftools").empty().append(data).fadeIn();
      }
    });

}

//=======================================Tools Issue-=============================================

$("#PartsIssueForm").validate({
    rules: {
      facility: "required",
      //groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_tools_issue";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#PartsIssueForm').serialize(), // serializes the form's elements.
                success : function (data) {
                  // console.log(data);  
                  // alert(data); // show response from the php script.
                 
                    if(data == 1 || data == 2){

                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                      $("#resultareaissue").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#PartsIssuemodal .close").click();
                      $("#resultareaissue").text(" "); 
                      // $('#PartsIssueForm')[0].reset(); 
                      // $("#PartsIssueForm").val("");
                    }, 1000);
                 }else{
                    $("#resultareaissue").text(data);
                 }
                 ajex_issuetListData();
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_issuetListData(){
  ur = "ajex_IssueListData";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        // $("#listingDataremove").hide();
        // $("#listingData").append(data);
        // $("#listingData").fadeIn();
        $("#listingData").empty().append(data).fadeIn();
       // console.log(data);
     }
  });

}


//============================Consumable Issue=========================


$("#ConsumIssueForm").validate({
    rules: {
      facility: "required",
      //groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_consumable_issue";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#ConsumIssueForm').serialize(), // serializes the form's elements.
                success : function (data) {
                  // console.log(data);  
                  // alert(data); // show response from the php script.
                 
                    if(data == 1 || data == 2){

                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                      $("#resultareaconsumable").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#ConsumIssuemodal .close").click();
                      $("#resultareaconsumable").text(" "); 
                      // $('#PartsIssueForm')[0].reset(); 
                      // $("#PartsIssueForm").val("");
                    }, 1000);
                 }else{
                    $("#resultareaconsumable").text(data);
                 }
                 ajex_issueConsumData();
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_issueConsumData(){
  ur = "ajex_IssueDataConsumable";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        $("#listingData").empty().append(data).fadeIn();
       // console.log(data);
     }
  });

}

//==========================Spare Issue===========================

$("#formedSpareIssue").validate({
    rules: {
      facility: "required",
      //groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_spare_issue_data";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#formedSpareIssue').serialize(), // serializes the form's elements.
                success : function (data) {
                   console.log(data);  
                  // alert(data); // show response from the php script.
                 
                    if(data != ''){

                      // if(data == 1)
                         var msg = "Parts & Supplies Issue Successfully !";
                      // else
                      //   var msg = "Data Successfully Updated !";

                      $("#resultspare").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#spareIssue .close").click();
                      $("#resultspare").text(" "); 
                      // $('#PartsIssueForm')[0].reset(); 
                      // $("#PartsIssueForm").val("");
                    }, 1000);
                 }else{
                    $("#resultspare").text(data);
                 }
                 ajex_issuetSpareData(data);
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_issuetSpareData(thsid){
  ur = "ajex_IssueListData";
  //alert(thsid);
  var words = thsid.split('^');
  
  console.log(words[0]);
  console.log(words[1]);
  
  var x=words[0];
  var y=words[1]
  
    $.ajax({
      url  : ur,
      type : "POST",
      data : {'wospid' : x, 'woid' : y}, 
      success: function(data){ 
        $("#ajaxContent").empty().append(data).fadeIn();
       // console.log(data);
     }
  });

}

//==========================================Tools Return=========================================

$("#formedPartsReturn").validate({
    rules: {
      //facility: "required",
      //groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_tools_return";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#formedPartsReturn').serialize(), // serializes the form's elements.
                success : function (data) {
                  console.log(data);  
                   //alert(data); // show response from the php script.
                 
                    if(data != ''){

                      // if(data == 1)
                         var msg = "Tools Return Successfully !";
                      // else
                      //   var msg = "Data Successfully Updated !";

                      $("#resultreturn").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#partsReturn .close").click();
                      $("#resultreturn").text(" "); 
                      // $('#PartsIssueForm')[0].reset(); 
                      // $("#PartsIssueForm").val("");
                    }, 1000);
                 }else{
                    $("#resultreturn").text(data);
                 }
                 ajex_returnPartsData(data);
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_returnPartsData(thsid){
  ur = "ajex_returnToolsListData";
  //alert(thsid);
    $.ajax({
      url  : ur,
      type : "POST",
      data : {'idval' : thsid},
      success: function(data){        
        $("#AjaxData").empty().append(data).fadeIn();
        console.log(data);
     }
  });

}

//================================Stock Transfer=====================================

$("#fromStockTransfer").validate({
    rules: {
      location_rack_id: "required",
      rack_id:"required",
      purchase_price: "required",
      qtyid:"required"

    },
      submitHandler: function(e) {
        ur = "stock_transfer_qty";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#fromStockTransfer').serialize(), // serializes the form's elements.
                success : function (data) {
                  // console.log(data);  
                  // alert(data); // show response from the php script.
                 
                    if(data != '' ){

                      //if(data == 1)
                        var msg = "Stock Successfully Transfer !";
                      // else
                      //   var msg = "Data Successfully Updated !";

                      $("#resultareatransfer").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#StockTransfer .close").click();
                      $("#resultareatransfer").text(" "); 
                      // $('#PartsIssueForm')[0].reset(); 
                      // $("#PartsIssueForm").val("");
                    }, 1000);
                 }else{
                    $("#resultareatransfer").text(data);
                 }
                 ajex_stockTransfer(data);
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_stockTransfer(thsid){
  ur = "/"+base_url+"/stocks/stockTransfer/ajax_TransferStock";
  //alert(ur);
    $.ajax({
      url: ur,
      type: "POST",
      data : {'ids' : thsid},
      success: function(data){
        //alert(data);
        $("#loadAjax").empty().append(data).fadeIn();
        console.log(data);
     }
  });

}


//================================Breakdown Hours===========================

$("#formBreakDown").validate({
    rules: {
      breakdown_start_time: "required",
      breakdown_end_time:"required"

    },
      submitHandler: function(e) {
        ur = "insert_breakdown_hours";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#formBreakDown').serialize(), // serializes the form's elements.
                success : function (data) {
                   console.log(data);  
                   //alert(data); // show response from the php script.
                 
                    if(data != '' ){

                      //if(data == 1)
                        var msg = "Breakdown Hours Added Successfully !";
                      // else
                      //   var msg = "Data Successfully Updated !";

                      $("#resultareahours").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#breakDownId .close").click();
                      $("#resultareahours").text(" "); 
                      // $('#PartsIssueForm')[0].reset(); 
                      // $("#PartsIssueForm").val("");
                    }, 1000);
                 }else{
                    $("#resultareahours").text(data);
                 }
                 ajex_breadkDownHours(data);
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_breadkDownHours(thsid){
  ur = "ajax_getBreakdownHours";
  //alert(ur);
    $.ajax({
      url: ur,
      type: "POST",
      data : {'idval' : thsid},
      success: function(data){
        //alert(data);
        $("#loadHours").empty().append(data).fadeIn();
        console.log(data);
     }
  });

}





//=====================================Delete Fnction==============================


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


$(function() {

//$(".delbutton").click(function(){
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


$(function() {

$(".delbuttonProduction").click(function(){

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
   url: "delete_production_data",
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



$(function() {

$(".delbuttonpacking").click(function(){

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
   url: "delete_packing_data",
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



$(function() {

$(".delbuttonQc").click(function(){

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
   url: "delete_Qc_data",
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


$(function() {

$(".delbuttondispatch").click(function(){

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
   url: "delete_dispatch_data",
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


$(function() {

$(".delbuttonstockrefill").click(function(){

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
   url: "delete_stock_refill",
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


$(function() {

$(".delbuttonPurchase").click(function(){

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
   url: "delete_purchase_order_data",
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

//==========================Entries Function=====================

$("#entries").change(function(){
      var value=$(this).val();
      var pageurl  = $(this).attr('url');
      url = pageurl+"&entries="+value;
      window.location.href = url;
  });


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


function inputdisable()
{
   $('#formId')[0].reset(); 
}

$(document).ready(function(){
 
// $(document).delegate("#formreset","click",function(){
//     //   alert('ssdfsdf');
//     var url = "<?=base_url()?>"+'assets/images/no_image.png';
//     var formid =  $('#formreset').attr('formid');
//   // alert(formid);
//     $(".top_title").html('Add ');
//    $(' #save').show();
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

function selectSpareList(ths)
{
 var data =  $(ths).attr('jsvalue');
   if(data !== undefined)
     var data = JSON.parse(data);
  $('#sparelist').css('display','none');
  $('#prd').val(data.productname);
  $('#pri_id').val(data.Product_id);
}


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

