$(document).ready(function () {

    $(document).on('click','.deleteAlbumBtn', function (e) {
        var id = $(this).attr('data-source');
        $.ajax({
            type: 'POST',
            url: '/ajax/elDelete.php',
            dataType: 'json',
            data: {id: id},
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