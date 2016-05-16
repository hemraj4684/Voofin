$(document).ready(function(){
    $('.dropdown-toggle').dropdown();
    //-------- BODY TOGGLE JS START------
    $(".container,header").on("click",function( event ){
        $( ".pullbox:visible" ).toggleClass('active', false);
    });

    $('.pullbtn').click(function(){
        $('.pullbox').toggleClass('active');
    });
    //-------- BODY TOGGLE JS END--------
});
/*js related code for buyerConfiguration file start here*/
    $("#add_more_btn").on("click",function( event ){
        var cloneData=$("#add_item").clone(true);
        cloneData.find('input[type="text"]').val('');
        cloneData.find('.deleteItemDes').css('display','block');
        $(".add_more_col").append(cloneData);
        //$("#add_item").clone(true).find('input[type="text"]').val('').appendTo(".add_more_col").append('<div><a href="#" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a></div>');
    });

    $(".add_more_col").on("click", "a.deleteItemDes", function( event ){
        //alert(abc.eq(0));
        event.preventDefault(); $(this).parent('div').parent().remove();

    });

    $("#add_more_btn1").on("click",function( event ){
        var cloneData1=$("#add_item1").clone(true);
        cloneData1.find('input[type="text"],textarea').val('');
             // cloneData1.find('textarea"]').val('');
        cloneData1.find('.deleteItemDes').css('display','block');

        $(".add_more_col1").append(cloneData1);
        //$("#add_item").clone(true).find('input[type="text"]').val('').appendTo(".add_more_col").append('<div><a href="#" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a></div>');
    });

    $(document).on("click", "a.deleteItemDes", function(event){
        event.preventDefault(); 
        $(this).parent('div').parent().remove();
    });
        
    /*js related code for buyerConfiguration file end here*/

$(document).ready(function() {
    $("#roleForm").submit(function() {
        var formData = $("#roleForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/bank/role/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
            	var value = eval(msg);
            	if(value.error == 'success'){
            		window.location.href = '/bank/role';
            		return false;
            	}
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            }
        });
    });
	
	var url = '/buyer/invoice/showSeller';
    $("#sellerName").autocomplete({
        source: url,
        minLength:0,
        width: 320,
        max: 10,
        select: function (event, ui) {
           //alert('id='+ui.item.id);
            $("#sellerId").val(ui.item.id);
        }
    });

    var url = '/seller/invoice/showBuyer';
    $("#buyerName").autocomplete({
        source: url,
        minLength:0,
        width: 320,
        max: 10,
        select: function (event, ui) {
           //console.log(ui.item.id);
            $("#buyerId").val(ui.item.id);
        }
    });
    $( "#buyerName" ).autocomplete( "option", "appendTo", "#bandMapForm" );
    $( "#sellerName" ).autocomplete( "option", "appendTo", "#bandMapForm" );

    $("#navigationForm").submit(function() {
        var formData = $("#navigationForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/bank/navigation/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/bank/navigation';
                    return false;
                }
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            }
        });
    });

    $("#userForm").submit(function() {
        var formData = $("#userForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/bank/user/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/bank/user';
                    return false;
                }
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            },
            beforeSend: function(){
                $('.loader').show();
            },
            complete: function(){
                $('.loader').hide();
            }
        });
    });

    $("#resetPassword").submit(function() {
        var formData = $("#resetPassword").serialize();
        $.ajax({
            method: 'POST',
            url: '/bank/user/updatepassword',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    alert('Password updated successFully');
                    window.location.href = '/auth/login';
                    return false;
                }
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            },
            beforeSend: function(){
                $('.loader').show();
            },
            complete: function(){
                $('.loader').hide();
            }
        });
    });
    
    
    
    $("#companyForm").submit(function() {
        var formData = $("#companyForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/bank/company/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/bank/company';
                    return false;
                }
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            },
            beforeSend: function(){
                $('.loader').show();
            },
            complete: function(){
                $('.loader').hide();
            }
        });
    });    


    $("#permissionForm").submit(function() {
        var formData = $("#permissionForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/bank/permission/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
            	var value = eval(msg);
            	if(value.error == 'success'){
            		window.location.href = '/bank/permission';
            		return false;
            	}
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            }
        });
    });

    

    $(".change_status").click(function() {
        var element = $(this);
        var elementId = element.attr('id');
        var info = "id="+elementId;
                
        $.ajax({
            method: 'GET',
            url: '/bank/company/change/status',
            datatype: 'json',
            data: info,
            success: function(msg) {
                

            }

        });
     });

    $("#all_read").click(function(){
        $(":checkbox:eq(0)", this).attr("checked", "checked"); 
    });

    $(':radio').change(function (event) {
        var id = $(this).data('id');
        $('#' + id).addClass('none').siblings().removeClass('none');
    });
    
   /*check all permission for bank, seller and buyer starts*/

    $("#bankCheckAll").click(function(){
        $(".bank-per").prop('checked', $(this).prop("checked"));
    });
    $("#sellCheckAll").click(function(){
        $(".seller-per").prop('checked', $(this).prop("checked"));
    });
    $("#buyCheckAll").click(function(){
        $(".buyer-per").prop('checked', $(this).prop("checked"));
    });
    /*check all permission for bank,seller and buyer ends*/

})

$(".bandChange").on('change',function(e){
  e.preventDefault();
  var currclass = $(this);
  var buyerId = $(this).closest("tr").find(".buyerID").val();
  //alert(buyerId);
  var sellerId = $(this).closest("tr").find(".sellerID").val();
  var bandId = $(this).closest("tr").find("select[name=bandId]").val();
  var _token = $(this).closest("table").find("input[name=_token]").val();
  
  $.ajax({
            cache: false,
            url:'/bank/band/bandMappingSave',
            type:'POST',
            data: {bandId:bandId, buyerId:buyerId, sellerId:sellerId, _token:_token},
            success:function(msg){
               window.location.href = '/bank/band/bandMapping';            
            }

          });

   });

 $(".changebands").on('change',function(e){
    var bands = $(this).val();
   $("#band_Id").val(bands);
    
    $("#bandSubmitForm").submit();
    /*$('.bandmaplist').each(function() { //loop through each checkbox
        if(this.checked){
          var buyerId = $(this).closest("tr").find("input[name=buyerId]").val();
          var sellerId = $(this).closest("tr").find("input[name=sellerId]").val();
          var bandId = bands.val();
          //console.log(bandId);
          var _token = $(this).closest("table").find("input[name=_token]").val();

             $.ajax({
                type: "POST",
                async: false,
                url: '/bank/band/bandMappingSave',
                data: {bandId:bandId, buyerId:buyerId, sellerId:sellerId, _token:_token},
                success: function(msg){
                     window.location.href ='/bank/band/bandMapping';
                }
              });
         }         
                
      });*/
   });

 $("#allchk").on('change',function(e){
      $(".bandmaplist").prop('checked', $(this).prop("checked"));
 });

$(".hide_btn").click(function(e){
  e.preventDefault();
  $(this).parent().parent().find('.show_btn').show();
  $(this).parent().parent().find('input[name=sharepercent]').attr("readonly",false).css('border', '0.5px solid grey').eq(0).focus();
  $(this).hide();
});

//js for revenue share

$(".revenueshare").each(function(){
  if(!$(this).is(':checked')){
     $(this).parent().parent().find('.hide_btn').attr('disabled','true');
   }else{
    $(this).parent().parent().find('.hide_btn').hide();
        $(this).parent().parent().find('.show_btn').show();
        $(this).parent().parent().find('input[name=sharepercent]').attr("readonly",false).css('border', '0.5px solid grey').eq(0).focus();
   } 
});





$(".revenueshare").on('click',function(e){
 var formData = $(this).parent().parent().find('.frmrevenueshare').serialize();
 // alert(formData);
    if($(this).is(':checked')){
        $(this).parent().parent().find('.hide_btn').hide();
        $(this).parent().parent().find('.show_btn').show();
        $(this).parent().parent().find('input[name=sharepercent]').attr("readonly",false).css('border', '0.5px solid grey').eq(0).focus();
    }
    else{
      $(this).parent().parent().find('.hide_btn').show();
      $(this).parent().parent().find('.hide_btn').attr('disabled','true');
      $(this).parent().parent().find('.show_btn').hide();
      $(this).parent().parent().find('input[name=sharepercent]').attr("readonly",true).css('border', '0px grey').eq(0).focus();
      
      $.ajax({
        type:"POST",
        url:"/bank/revenuesharing/save",

        data:formData,
        success:function(msg){
         alert("data saved successFully");
         location.reload();

        },


      });
    }
 });   

// js for funding limits

$(".edit").click(function(e){
  e.preventDefault();
  $(this).parent().parent().find('.save').show();
  $(this).parent().parent().find('.approved_limit').attr("readonly",false).css('border', '0.5px solid grey').eq(0).focus();
  $(this).hide();
});

//js to save fundinglimits
$(".save").click(function(e){
e.preventDefault();
$(this).parent().parent().find(".frmfundinglimits").submit();
});




$(".show_btn,input[type=checkbox]").click(function(e){
     var abc = $(this).attr('data-id');
     $('#'+abc).submit();
});




//for discounting request page check all functionality
$("#disReqcheckAll").on('change',function () {
  $(".discountingChk").not("[disabled]").prop('checked', $(this).prop("checked"));
});

$(document).on('change','.changeDiscountingStatus',function(){
    var disStatus = $('.changeDiscountingStatus').val();
    if(disStatus == "Approved")
       $('#confirmApproveMoadal').modal("show");
    if(disStatus == "Rejected")
       $('#confirmRejectMoadal').modal("show");
});

$(document).on('click','#confirmAccept,#confirmReject',function(){
    
    var disStatus = $('.changeDiscountingStatus').val();
    var user      = $('.changeDiscountingStatus').attr('data-user');    
    var remarks   = "";

    if(disStatus == 'Rejected')
       remarks = $('#remarks').val();

    if($('.discountingChk:checked').length > 0){
       var disUuid = [];
       $('.discountingChk:checked').each(function(index){
            disUuid[index] = $(this).closest("tr").find(".discounting").attr('data-disId');
       });    
    } else{
       var disUuid = "";
       disUuid   = $('.discountingId').val();
       disStatus = $('.statusId').val();        
    }
    

      var url ='';
      if(user = 'maker'){
        url = "/bank/iDiscounting/makerApprove";
      } else if(user = 'cheker'){
        url = "/bank/iDiscounting/checkerApprove";
      }

      $.ajax({
             url:url,
             type: 'POST',
             data:{discountingId:disUuid, statusId:disStatus, remarks:remarks},
             dataType:'json',
             success:function(data){
               window.location.href = '/bank/discountingRequest';
               return false;
             }
      });
});




$(document).on('click','.discounting',function(){
      var id = $(this).attr('data-disId');
      var statusId = $(this).attr('data-status');
      var buttonTitle = $(this).attr('data-original-title');
      if(buttonTitle == "Reject Request")
        $('#confirmRejectMoadal').modal("show");

      if(buttonTitle == "Submit Request")
        $('#confirmApproveMoadal').modal("show");

      $('.discountingId').val(id);
      $('.statusId').val(statusId);
});


$(".iDisModal").click(function(e){
      var id = $(this).attr('data-id');
      $.ajax({
            url:'/seller/iDiscounting/iDisModal/'+id,
            dataType:'html',
            success:function(data){
             $("#iDisModalContainer").html(data);
             $("#iDisModal").modal("show");
            }
      });
});