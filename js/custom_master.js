var base_url = "united-timber";

//==========================================Contact Form================================//

$("#contactForm").validate({
    rules: {
      first_name: "required",
      groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_contact";
        
          $("#saveload").css("display","inline-block");
          $("#contactForm1").attr("type","button");
          $("#contactForm1").css("display","none");
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
                      
                      $("#saveload").css("display","none");
                      $("#contactForm1").css("display","inline-block");
                      $("#contactForm1").attr("type","submit");
                      
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

          $("#saveload").css("display","inline-block");
          $("#saveItem").attr("type","button");
          $("#saveItem").css("display","none");

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
                       //$('#ItemForm')[0].reset(); 
                       // $('#dataTable')[0].reset();
                       // $('.tablejs').trigger("reset");                       
                       $("#Product_id").val("");

                      $("#saveload").css("display","none");
                      $("#saveItem").css("display","inline-block");
                      $("#saveItem").attr("type","submit");

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

          $("#saveload").css("display","inline-block");
          $("#saveItem1").attr("type","button");
          $("#saveItem1").css("display","none");

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
                       //$('#ItemForm1')[0].reset();
                      $("#saveload").css("display","none");
                      $("#saveItem1").css("display","inline-block");
                      $("#saveItem1").attr("type","submit");
                       
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
    
    $("#saveload").css("display","inline-block");
    $("#locationSave").attr("type","button");
    $("#locationSave").css("display","none");

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
                $("#success-message").text("Location Updated Successfully!");
              }            
              document.getElementById("Location_Validation").innerHTML="";
              setTimeout(function(){
              $("#editlocation .close").click();
              $("#success-message").text("");                   
              //$("#Location_Form")[0].reset();

              $("#saveload").css("display","none");
              $("#locationSave").css("display","inline-block");
              $("#locationSave").attr("type","submit");

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

/*
$(".addlocation").click(function()
{
    
    $("#loc_det").val("");
    $("#id").val("");
    $('#Location_form :input[type="submit"]').attr('disabled',false);
    $(".save").show();
    document.getElementById("Location_Validation").innerHTML="";
});
*/

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
    
    $("#saveload").css("display","inline-block");
    $("#racksave").attr("type","button");
    $("#racksave").css("display","none");
   
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
                  var msg="Location Rack Added Successfully";           
              }
              else
              {
                var msg="Location Rack Updated Successfully";           
              }
              $("#operationarea").text(msg);
              document.getElementById("Location_Validation").innerHTML="";
              setTimeout(function(){
              $("#modal-0 .close").click();
              $("#operationarea").text("");        
              document.getElementById("location_rack_id").options.length = 0;
              //$("#LocationRackForm")[0].reset();

              $("#saveload").css("display","none");
              $("#racksave").css("display","inline-block");
              $("#racksave").attr("type","submit");

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


//----------------------------Location Rack Edit Form Popup Open----------------------------------

$("#LocationRackFormEdit").validate({

  rules:
  {
    
    location_rack_id:"required",
    rack_name:"required"

  },

    submitHandler:function(form){
    var formData=new FormData(form);
    
    ur="insert_location_rack";
    
    $("#saveload").css("display","inline-block");
    $("#editracksave").attr("type","button");
    $("#editracksave").css("display","none");

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
              $("#editItem .close").click();
              $("#operationarea").text("");
              //$("#LocationRackForm")[0].reset();

              $("#saveload").css("display","none");
              $("#editracksave").css("display","inline-block");
              $("#editracksave").attr("type","submit");

              },500);
            }
            else
            {
              $("#operationarea").text(data);        
            }

            LocationRackTableEdit();
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


function LocationRackTableEdit()
{
  
  ur="LocationRackDataEdit";

  $.ajax({

    url:ur,
    type:"POST",
    success:function(data)
    {     
      $("#loadData").empty().append(data).fadeIn();      
    }  

  });

}


//-------------------------------Location Rack Add Form Popup close--------------------------------

// $(".addlocationRack").click(function()
// {    
//     $("#location_rack_id").val("");
//     $("#rack_name").val("");
//     $(".ui fluid email search dropdown").val("");
//     $('#LocationRackForm :input[type="submit"]').attr('disabled',false);
//     $('#LocationRackFormEdit :input[type="submit"]').attr('disabled',false);
//     document.getElementById("Location_Validation").innerHTML="";

// });


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

///========================Section Labour Task====================================

$("#SectionLabourTask").validate({
    rules: {
      facility: "required",
      //groupName:"required"
    },
      submitHandler: function(e) {
        ur = "insert_labour_task";
        
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#SectionLabourTask').serialize(), // serializes the form's elements.
                success : function (data) {
                  // console.log(data);  
                  // alert(data); // show response from the php script.
                 
                    if(data == 1 || data == 2){

                      if(data == 1)
                        var msg = "Data Successfully Add !";
                      else
                        var msg = "Data Successfully Updated !";

                      $("#resultarealabour").text(msg); 
                      setTimeout(function() {   //calls click event after a certain time
                      $("#LabouTaskModal .close").click();
                      $("#resultarealabour").text(" "); 
                      // $('#SectionLabourTask')[0].reset(); 
                      // $("#SectionLabourTask").val("");
                    }, 1000);
                 }else{
                    $("#resultarealabour").text(data);
                 }
                 ajex_getLabourTask();
               }
            });
          return false;
        //e.preventDefault();
      }
  });

function ajex_getLabourTask(){
  ur = "ajex_LabourTaskData";
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        $("#listingData").empty().append(data).fadeIn();
        console.log(data);
     }
  });

}
