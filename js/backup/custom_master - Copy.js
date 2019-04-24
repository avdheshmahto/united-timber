          /////// tree js  ///

   
    
    var setting = { };
    var da      = "";
    var title   =  $("#content_wrap").attr('arr');
    var base_url = "thermodyne/";
    alert(base_url);

    if(title !== undefined)
      var da      = JSON.parse(title);

      var zNodes  = da;
          var curMenu = null, zTree_Menu = null;
          var setting = {
            view:{
              showLine: false,
              showIcon: false,
              selectedMulti: false,
              dblClickExpand: false,
              addDiyDom: addDiyDom
             },
            data: {
              simpleData: {
                enable: true
              }
            },
            callback: {
              beforeClick: beforeClick
            }
          };

$(document).ready(function(){
 
  if(zNodes != ""){
      var treeObj = $("#treeDemo");
      $.fn.zTree.init(treeObj, setting, zNodes);
      zTree_Menu = $.fn.zTree.getZTreeObj("treeDemo");
      curMenu = zTree_Menu.getNodes()[0].children[0].children[0];
      zTree_Menu.selectNode(curMenu);

      treeObj.hover(function () {
        if (!treeObj.hasClass("showIcon")) {
          treeObj.addClass("showIcon");
        }
      }, function() {
        treeObj.removeClass("showIcon");
      });
     }

$(document).delegate("#formreset","click",function(){
     //  alert('ssdfsdf');
    var url = base_url+'assets/images/no_image.png';
    var formid =  $('#formreset').attr('formid');
    alert(formid);
    
    $(formid)[0].reset();
    $(".hiddenField").val('');
    $(formid+" :input").prop("disabled", false);
    $("#button").css("display", "block");
    $('#image').attr('src',url);
});

  $("#entries").change(function(){
    var value=$(this).val();
    var pageurl  = $(this).attr('url');
    url = pageurl+"?entries="+value;
    window.location.href = url;
  });

 });

 function addDiyDom(treeId, treeNode) {
      var spaceWidth = 5;
      var switchObj = $("#" + treeNode.tId + "_switch"),
      icoObj = $("#" + treeNode.tId + "_ico");
      switchObj.remove();
      icoObj.before(switchObj);

      if (treeNode.level > 1) {
        var spaceStr = "<span style='display: inline-block;width:" + (spaceWidth * treeNode.level)+ "px'></span>";
        switchObj.before(spaceStr);
      }
    }

    function beforeClick(treeId, treeNode) {
      if (treeNode.level == 0 ) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandNode(treeNode);
        return false;
      }
      return true;
    }

///////////////////////////////////////////////////   form save  js   //////////////////////////////////////////////

  $("#target").click(function(event){              /////  category form save js  /////
    event.preventDefault();
    $("#error").text(" ");
    $('#button').css('display','block');
    $("#category").prop("disabled", false);
    $("#selectCategory").prop("disabled", false);

    var ur   = 'ajex_formsubmit';
    var name = $("#category").val();
    var id   = $("#selectCategory").val();
    var submit_type = $('#target').attr("submit_value");
    var editId = $('#editvalue').val();
    
    if(name != "" && id != ""){
        $.ajax({
        type: "POST",
        url: ur,
        data: {'category':name,'selectCategory':id,'type':submit_type,'edit':editId },
        cache: false,
        success: function(data){
          $("#resultarea").text(data); // msg show //
          ajex_loadListData(); //// load add table listing // 
          setTimeout(function() {   //calls click event after a certain time
          $("#modal-1 .close").click();
          $("#resultarea").text(" "); 
          }, 1000);
          $('#formId')[0].reset(); 
        } 
        });
    }else if(name == ""){
     $("#error").text('Please Enter Category !');
    }else if(id == ""){
     $("#error").text('Please Select Category !');
    }
  });        

  $("#contactForm").validate({           //////  contact page save data ////////
    rules: {
      first_name: "required",
      maingroupname:"required"
    },
      submitHandler: function(e) {
        ur = base_url+'master/Account/insert_contact';
            $.ajax({
                type : "POST",
                url  :  ur,
                //dataType : 'json', // Notice json here
                data : $('#contactForm').serialize(), // serializes the form's elements.
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
                      $('#contactForm')[0].reset(); 
                      $("#Product_id").val("");
                    }, 1000);
                 }else{
                    $("#resultarea").text(data);
                 }
                 ajex_contactListData();
               }
            });
          return false;
        //e.preventDefault();
      }
  });

 


  $("#ItemForm").validate({          //////     Item (prodect) page js /////
    rules: {
      sku_no: "required",
      industry:"required"
    },
      submitHandler: function(form) {
        ur = base_url+'master/Item/insert_item';
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
                       $('#ItemForm')[0].reset(); 
                       $("#contact_id").val("");
                    }, 1000);
                  }else{
                    $("#resultarea").text(data);
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

///////////////////////////////////////////////////  end  form save  js   //////////////////////////////////////////////


///////////////////////////////////////////////////  end  form edit  js   //////////////////////////////////////////////

function editRow(ths){                                 /// category ///
   var value  =  $('#'+ths).attr("arrt");
   var cat_id =  $('#'+ths).attr("cat_id");
     $('#selectCategory').val(cat_id).prop('selected', true);
     $('#category').val(value);
     $('#target').attr("submit_value","edit");
     $('#editvalue').val(ths);
}

function editContact(ths) {                             /// contact ///
  //console.log('edit ready !');
  $('.error').css('display','none');
  var rowValue = $(ths).attr('arrt');
  var button_property = $(ths).attr('property');
  //console.log(rowValue);
   if(rowValue !== undefined)
     var editVal = JSON.parse(rowValue);
      //alert(editVal.contact_id);
    if(button_property != 'view')
        $('#contact_id').val(editVal.contact_id);

        $('#addres_id').val(editVal.addres_id);
        $('#first_name').val(editVal.first_name);
        $('#printname').val(editVal.printname);
        $('#mobile').val(editVal.mobile);
        $('#phone').val(editVal.phone);
        $('#city').val(editVal.city);
        $('#email').val(editVal.email);
        $('#contact_person').val(editVal.contact_person);
        $('#address3').val(editVal.address3);
        $('#address1').val(editVal.address1);
        $('#printname').val(editVal.printname);
        $('#state_id').val(editVal.state_id).prop('selected', true);
        $('#groupName').val(editVal.group_name).prop('selected', true);
        $('#pincode').val(editVal.pincode);
        $('#gstin').val(editVal.gst);
        $('#IT_Pan').val(editVal.IT_Pan);

      if(button_property == 'view'){
        $('#button').css('display','none');
        $("#contactForm :input").prop("disabled", true);
      }else{
        $('#button').css('display','block');
        $("#contactForm :input").prop("disabled", false);
      }
};

function editItem(ths) {                                     /// Item ///
  var image_url = base_url+'assets/image_data'+'/';
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

function loadFile(ths) {
  if (ths.files && ths.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#image').attr('src', e.target.result);
            };
          reader.readAsDataURL(ths.files[0]);
        }
}

/////////////////////////////////// table listing js /////////////////////////////////////////


function ajex_contactListData(){
  ur = base_url+'master/Account/ajex_ContactListData';
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        $("#listingDataremove").hide();
        $("#listingData").append(data);
        $("#listingData").fadeIn();

       // console.log(data);
     }
  });
}

function ajex_ItemListData(){
  ur = base_url+'master/Item/ajex_ItemListData';
    $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        //$("#listingData").hide();
        $("#listingData").empty().append(data).fadeIn();
      }
    });
}


function showRowtree(val){
  var ur   = base_url+'master/ProductCategory/ajaxShowParent';
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

function inputdisable(){
   $('#formId')[0].reset(); 
}


function ajex_loadListData(){
  ur = base_url+'master/ProductCategory/ajex_loadListData';
  $.ajax({
      url: ur,
      type: "POST",
      success: function(data){
        $("#loadProductData").html(data);

       // console.log(data);
     }
  });
}


//////////////////////////////////// end /////////////////////////////////



