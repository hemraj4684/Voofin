$('document').ready(function() {

    $("#roleForm").submit(function() {
        var formData = $("#roleForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/admin/role/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/admin/role';
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
            url: '/admin/user/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/admin/user';
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

    $(".change_status").click(function() {
        var element = $(this);
        var elementId = element.attr('id');
        var info = "id="+elementId;
        console.log(info);
        $.ajax({
            method: 'GET',
            url: '/admin/user/change/status',
            datatype: 'json',
            data: info,
            success: function(msg) {
                

            }

        });
     });

    $("#resetPassword").submit(function() {
        var formData = $("#resetPassword").serialize();
        $.ajax({
            method: 'POST',
            url: '/admin/bank/user/updatepassword',
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

    $("#permissionForm").submit(function() {
        var formData = $("#permissionForm").serialize();
        $.ajax({
            method: 'POST',
            url: '/admin/permission/save',
            dataType: 'json',
            data: formData,
            success: function(msg) {
                var value = eval(msg);
                if(value.error == 'success'){
                    window.location.href = '/admin/permission';
                    return false;
                }
                $.each(value, function(index, value) {
                    $("#" + index).html(value);
                });
            }
        });
    });

    
    $("#all_read").click(function(){
        $(":checkbox:eq(0)", this).attr("checked", "checked"); 
    });

    /*check all permission for bank, seller and buyer starts*/
    $("#adminCheckAll").click(function(){
        $(".admin-per").prop('checked', $(this).prop("checked"));
    });
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

});

