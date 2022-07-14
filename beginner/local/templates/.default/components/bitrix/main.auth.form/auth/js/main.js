$(document).ready(function(){

    $('.auth-link').click(function(e){
        $('.auth-box').modal();
        e.preventDefault();
        return false;
    });

    $('#auth-form input[name=submit]').click(function(e){
        $.ajax({
            type: 'POST',
            url: '/ajax/auth.php',
            data: {
                mode: 'login',
                login: $('#auth-form input[name=login]').val(),
                password: $('#auth-form input[name=password]').val()
            },
            dataType: 'json',
            success: function(result){
                if(result.status)
                    location.reload();
                else{
                    $('.message.error').html(result.message);
                    $('.message.error').show();
                }
            }
        });
        e.preventDefault();
        return false;
    });

});