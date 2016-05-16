$('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
      $(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
      $(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
      $(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
      $(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});


$(document).ready(function(){
    
    ///////////////////DASHBOARD AJAX CALLS/////////////////////////////
    jQuery.ajax({
            type       : "GET",
            url        : "/buyer/dashboard/show",
            dataType   : "json",
            success    : function (response) {
                var data = eval(response);
                if (data.error == 'error') {
                    jQuery.each(data, function (index, value) {
                        jQuery('#' + index).text('');
                    });
                  
                } else {
                        jQuery('#buyerDashboardOpenPO').text(Math.floor(parseFloat(data.openPO)).toLocaleString("en"));
                        jQuery('#buyerDashboardOpenInv').text(Math.floor(parseFloat(data.openInv)).toLocaleString("en"));
                        jQuery('#buyerDashboardAppPI').text(Math.floor(parseFloat(data.AppPI)).toLocaleString("en"));
                        jQuery('#buyerDashboardRem').text(Math.floor(parseFloat(200000000)).toLocaleString("en")).css('font-size',30);
                }
            }
        });
    ///////////////////DASHBOARD AJAX CALLS/////////////////////////////


    $('.dropdown-toggle').dropdown();
    //-------- BODY TOGGLE JS START------
    $(".container,header").on("click",function( event ){
        $( ".pullbox:visible" ).toggleClass('active', false);
    });

    $('.pullbtn').click(function(){
        $('.pullbox').toggleClass('active');
    });
    //-------- BODY TOGGLE JS END--------

        jQuery("#chatForm").submit(function () {
        if(!jQuery("#userChat").val())
            return false;
        var formData = jQuery("#chatForm").serialize();
        jQuery.ajax({
            type: "POST",
            url: "/buyer/chat/save",
            data: formData,
            processData: false,
            dataType: "json",
            success: function (response) {
                var data = eval(response);
                if (data.error == 'error') {
                    jQuery.each(data, function (index, value) {
                        jQuery('#' + index).text('');
                    });
                    jQuery.each(data, function (index, value) {
                        jQuery('#' + index).text(value);
                    });
                } else {
                    // /jQuery("#placeChat").show();
                    var text = jQuery("#placeChat").text();
                    jQuery("#placeChatWithText").append("<li>"+text+  "  " + jQuery("#userChat").val()+"</li>");
                    jQuery("#userChat").val('');
                    //location.reload();
                }
            }
        });
    })
});

$(document).ready(function(){
  var pt = $("#paymentTerms").val();

  $("#roleForm").submit(function() {
        var formData = $("#roleForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/buyer/role/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
              var value = eval(msg);
              if(value.error == 'success'){
                window.location.href = '/buyer/role';
                return false;
              }
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            }
        });
    });
  $("#buyCheckAll").click(function(){
        $(".buyer-per").prop('checked', $(this).prop("checked"));
    });
    /*block related to PO starts here*/
	var url = '/buyer/po/show';
    
    $("#sellerName").autocomplete({
        source: url,
        minLength: 0,
        width: 320,
        max: 10,
        select: function (event, ui) {
            $("#sellerId").val(ui.item.id);
            if(isNaN(ui.item.paymentTerms) || ui.item.paymentTerms != 0)
              $("#paymentTerms").val(ui.item.paymentTerms);
            else
              $("#paymentTerms").val(pt);
        }
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {
      $message = $(e.relatedTarget).attr('data-message');
      $(this).find('.modal-body p').text($message);
      $title = $(e.relatedTarget).attr('data-title');
      $(this).find('.modal-title').text($title);

      // Pass form reference to modal for submission on yes/ok
      var form = $(e.relatedTarget).closest('form');
      $(this).find('.modal-footer #confirm').data('form', form);

  });

  /*Form confirm (yes/ok) handler, submits form*/

    $(document).on('click','.delete_po',function(index,value){
        var url = $(this).attr('data-url');
        $('#confirm').attr('href',url);
    })

  /*po view block started here*/  
    $(".poView").on('click',function(e) {
        var poId = $(this).attr('data-id');
        var poUrl = '/buyer/po/show/'+poId;
        
        $.ajax({
            method: 'get',
            url: poUrl,
            dataType: 'html',
            
            success: function(msg) {
              $('#poModalContainer').html(msg);
              $('#myModal_po').modal('show');
              $("#poAttach").filer({
                  extensions: ['jpg', 'jpeg', 'png', 'gif','doc','docx','xls','xlsx','pdf'],
                  changeInput: true,
                  showThumbs: true,
                  addMore: true,
                  captions: {
                      errors: {
                          filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                          filesType: "Only Images,Doc and PDF files are allowed to be uploaded.",
                          filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                          filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
                      }
                  }
                });
            },
            beforeSend: function(){
               // $('.loader').show();
            },
            complete: function(){
              //  $('.loader').hide();
            }
        });

    });
  /*po view block started here*/  

  /*$(".pricePer").each(function() {
    $(this).keyup(function(){
      if(!isNaN(this.value) && this.value.length!=0) {
          calculateSum(this.value);
      }
    });
  });
  function calculateSum() {
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".quantity").each(function() {
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum = price * parseFloat(this.value);
            }
            $(this).next($(".total").val(sum.toFixed(2)));
        });
        
        //.toFixed() method will roundoff the final sum to 2 decimal places
         
}*/
  
/*block related to PO ended here*/


	var keyword = $("#sellerId").val();
	$('#sellerId11').typeahead({
	  name: 'sellerId',
	  remote: "/buyer/po/show/%QUERY"
	});
	
	//Date Picker Js Start 
	$( "#datepicker1" ).datepicker({ 
		changeMonth: true,
		changeYear: true,
    dateFormat:"dd M yy",	
    });

	$( "#datepicker2" ).datepicker({      
	    changeMonth: true,
		changeYear: true,
    dateFormat:"dd M yy",
    });
  
	$( "#datepicker3" ).datepicker({      
	    changeMonth: true,
		changeYear: true,
    dateFormat:"dd M yy",
    });
	//Date Picker Js End


	/*js related code for buyerConfiguration file start here*/
	$("#add_more_btn").on("click",function( event ){
        var cloneData=$("#add_item").clone(true);
        cloneData.find('input[type="text"]').val('');
        cloneData.find('.deleteItemDes').css('display','block');
        $(".add_more_col").append(cloneData);
		//$("#add_item").clone(true).find('input[type="text"]').val('').appendTo(".add_more_col").append('<div><a href="#" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a></div>');
	});

    $(document).on("click", "a.deleteItemDes", function( event ){

        event.preventDefault(); $(this).parent('div').parent().remove();

    });

    $("#add_more_btn1").on("click",function( event ){
        var cloneData1=$("#add_item1").clone(true);
        cloneData1.find('input[type="text"]').val('');
        cloneData1.find('.deleteItemDes').css('display','block');
        $(".add_more_col1").append(cloneData1);
        //$("#add_item").clone(true).find('input[type="text"]').val('').appendTo(".add_more_col").append('<div><a href="#" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a></div>');
    });

    $(".add_more_col1").on("click", "a.deleteItemDes", function( event ){
        //alert(abc.eq(0));
        event.preventDefault(); $(this).parent('div').parent().remove();

    });
		
	/*js related code for buyerConfiguration file end here*/
$("#purOrderNumber").on('blur',function(){
  var purOrderNumber = $('#purOrderNumber').val();
  $.ajax({
    url:'/buyer/po/poPresentYN',
    type: 'GET',
    data: {purOrderNumber:purOrderNumber},
    success:function(msg){
      var value = eval(msg);
      if(value.success){
        $('#purchase_order_numberErr').text(value.success);
      }
      else if(value.error){
        $('#purchase_order_numberErr').html('');
      }
    }
  });

});

  /*js related code for buyer user started here*/
  $("#addPO").submit(function() {
        var formData = $("#addPO").serialize();
        $.ajax({
            method: 'POST',
            url: '/buyer/po/store',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
               // alert(msg);
                if(value.error == 'success'){
                    window.location.href = '/buyer/po';
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
  /*js related code for buyer user ended here*/

	/*js related code for buyer user started here*/
	$("#buyerUserForm").submit(function() {
        var formData = $("#buyerUserForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/buyer/user/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/buyer/user';
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
	/*js related code for buyer user ended here*/

    /* Show Invoice-Modal Start*/                               //by sunil 22-01-2016
 $(".invoice-modal").click(function(){
      var id=$(this).attr('id');
      var url = '/buyer/invoice/invoiceDetails/'+id;
      $.ajax({
            url:url,
            dataType:'html',
            success:function(data){

              $("#allModals").html(data);
              
              $("#myModalInvoice").modal("show");

              $("#invoiceAttach").filer({
                  extensions: ['jpg', 'jpeg', 'png', 'gif','doc','docx','xls','xlsx','pdf'],
                  changeInput: true,
                  showThumbs: true,
                  addMore: true,
                  captions: {
                      errors: {
                          filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                          filesType: "Only Images,Doc and PDF files are allowed to be uploaded.",
                          filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                          filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
                      }
                  }
                });


              var taxTotal = 0, taxPer = 0 , subTotalDis=0, finalAmount=0;
       
               var subTotal = parseFloat($("#subTotal").val());
               var tds = parseFloat($("#tds").val());

               subTotal = isNaN(subTotal) ? '0' : subTotal;
               tds = isNaN(tds) ? '0' : tds;

               subTotalDis=(subTotal*tds)/100;

               subTotal=subTotal-subTotalDis;
                $("#subTotalDis").val(subTotal.toFixed(2));

               $('.tax').each(function(){
         
                var taxVal=parseFloat($(this).val());
                
                taxVal = isNaN(taxVal) ? '0' : taxVal;
                
                //var taxPercentageAmount=(subTotal*taxPer)/100;

                //$(this).parent().find(".tax").val(taxPercentageAmount);

                taxTotal=taxTotal+taxVal;

                });

               //$("#tax").val(taxTotal.toFixed(2));

               finalAmount=subTotal+taxTotal;

               $("#finalAmount").val(finalAmount.toFixed(2));
               
            }
          });

       
     
  });

$(".pi-modal").click(function(){
      var id=$(this).attr('id');
      $.ajax({
            url:'/buyer/piListing/showPiModal/'+id,
            dataType:'html',
            success:function(data){
             $("#piModal").html(data);
             $("#pi_modal").modal("show");
            }
          });
      
    });

/* Delete attachment start*/
$(".delete-attach").click(function(){
  var id=$(this).attr('id');
   if(confirm("Are you sure you want to delete this?")){
    $.get('/buyer/po/deleteAttachment/'+id, function(data, status){});
    $(this).parent().parent().parent().parent().parent().parent().parent().remove();
    }else{
        return false;
    }

});
/* Delete attachment end*/
$('#filer_input').filer({
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'xls', 'xlsx'],
        changeInput: true,
        showThumbs: true,
        addMore: true,
        
    });

});


$(".pricePer").on('blur',function(){
    calculateSum($(this));  

});

function calculateSum(e) {
  var subTotal=0;
    if(!isNaN(e.val()) && e.length!=0) {
      //e.next().find("input[name=total]").val('class');

        var sum = 0;
        //iterate through each textboxes and add the values

        $(".quantity").each(function() {
          
            if(!isNaN(this.value) && this.value.length!=0) {
                sum = parseFloat( e.parent().parent().find('.quantity').val()) * parseFloat(e.val());

                console.log(sum);
                e.parent().parent().find('.total').val(sum.toFixed(2));
            }
      });
      
        $(".total").each(function() {
            
            if(!isNaN(this.value) && this.value.length!=0) {
                subTotal = subTotal+parseFloat(this.value);

            }
        });
        $("#amount").val(subTotal);
    }
        //.toFixed() method will roundoff the final sum to 2 decimal places
         
  }

  /*seller setting modal data*/
  $(".sellerSetting").click(function(){
     var id = $(this).attr('data-id');
      $.ajax({
            url:'/buyer/sellerSetting/edit/'+id,
            dataType:'html',
            success:function(msg){
              $('#sellerSettingContainer').html(msg);
              $('#sellerSettingModal').modal('show');
            }
          });
     
  });

$(".hide_btn").click(function(e){
  e.preventDefault();
  $(this).parent().parent().find('.show_btn').show();
  $(this).parent().parent().find('.seller_hide_border').attr("readonly",false).css('border', '0.5px solid grey').eq(0).focus();
  $(this).hide();
});

$(".show_btn").on('click',function(e){
  e.preventDefault();
  var currclass = $(this);
  var id = $(this).attr('data-id');
  var taxAmt = $(this).closest("tr").find("input[name=taxPercentage]").val();
  var paymentTerms = $(this).closest("tr").find("input[name=paymentTerms]").val();
  var _token = $(this).closest("tr").find("input[name=_token]").val();
  $.ajax({
            cache: false,
            url:'/buyer/sellerSetting/save',
            type:'POST',
            data: {id:id, taxPercentage:taxAmt, paymentTerms:paymentTerms,_token:_token},
            success:function(msg){
              $('.seller_hide_border').attr("readonly",true).css('border', 'none');
              currclass.parent().parent().find('.hide_btn').show();
              currclass.hide();            
            }

          });
});



/*function toggle() {
  $('.seller_hide_border').attr("readonly",false);
  $('.hide_btn').hide();
  $('.show_btn').show();
} 
function toggleupdate() { 
  $('.seller_hide_border').attr("readonly",true).focus();
  $('.hide_btn').show();
  $('.show_btn').hide();  
}
*/
/*$("#discount").on('blur',function(){
  if(!isNaN(this.value) && this.value.length!=0) {
    var discount=parseFloat($(this).val());  
    var subTotal=parseFloat($("#amount").val());
    var finalAmount=subTotal-discount;

    $("#final_amount").val(finalAmount);
  }
});*/

