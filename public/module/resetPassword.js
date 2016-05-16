$('document').ready(function() {
        
    $("#resetPassword").submit(function() {
        var formData = $("#resetPassword").serialize();
        $.ajax({
            method: 'POST',
            url: '/user/updatepassword',
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
    
})

