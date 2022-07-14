$(document).ready(function () {
$("#album-form-submit-btn").on("click", function () {
    let data = new FormData($('#add-album-form')[0]);
    $.ajax({
        type: 'POST',
        url: '/ajax/addAlbum.php',
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                console.log(result);
                alert("Альбом успешно добавлен!");
                window.location.replace('/albums/');
            } else {
                console.log(result);
                alert("Поля должны быть заполнены!");
                $('.message.error').html(result.message);
                $('.message.error').show();
            }
        }

    });
    return false;
});

$("#album-images-submit-btn").on("click", function () {
    let data = new FormData($('#add-images-form')[0]);
    $.ajax({
        type: 'POST',
        url: '/ajax/uploadImages.php',
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                alert("Изображения добавлены!");
                window.location.replace('/albums/');
            } else {
                alert("Выберите изображения!");
            }
        }

    });
    return false;
});




});