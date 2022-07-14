$(document).ready(function () {
$(document).on('click','.deletePicBtn', function (e) {
    var id = $(this).attr('data-source');
    var albId = $(this).attr('data-info');

    $.ajax({
        type: 'POST',
        url: '/ajax/picDelete.php',
        dataType: 'json',
        data: {id: id, albId: albId},
        success: function (result) {
            alert("Подтвердите удаление");
            if (result.success) {
                console.log(result);
                window.location.replace('/albums/');
            }
        }
    });
    return false;
});
});
