$(document).on('submit','#js-main-auth-form',function (event) {
    event.preventDefault();
    var formData = new FormData(event.target);

    $.ajax({
        type: "POST",
        url: "/ajax/auth.php",
        success: function (data) {
            window.location.href = "/";
            alert(data.message);
        },
        error: function (error) {
            alert('Неверный логин или пароль');
            },
        data: formData,
        contentType: false,
        processData: false,
    });

});
