<?php

/**
 * @global $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var \CBitrixComponentTemplate $this
 * @var \SystemComplexComponent $component
 */
$APPLICATION->setTitle('Создание нового альбома');
if (!$USER->IsAuthorized()) {
    LocalRedirect('/auth/');
}
?>
<div class="container">
    <main>
        <form id="add-album-form" method="post" action="">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4"
                     src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72"
                     height="57">
                <h2>Создание альбома</h2>
            </div>
            <div class="row g-5" id="addAlbum">
                <div class="col-md-7 col-lg-8">
                    <h4>Выберите обложку альбома</h4>
                    <div class="input-group">
                        <input type="file" name="previewImage" id="uploadImage" class="form-control" accept="image/*"/>

                    </div>
                    <br>
                    <img height="300px" width="300px" id="result">
                </div>
                <div class="col-md-7 col-lg-8">

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="albumName" class="">Название альбома</label>
                            <input type="text" name="albumName" class="form-control" placeholder="" value="" required>
                            <label for="albumDescription" class="">Описание альбома</label>
                            <input type="text" class="form-control" name="albumDescription" placeholder="" value=""
                                   required>
                        </div>
                        <hr class="my-4">
                        <button id="album-form-submit-btn" class="w-100 btn btn-primary btn-lg" type="submit">Создать
                        </button>

        </form>
</div>
<script>
    FReader = new FileReader();

    // событие, когда файл загрузится
    FReader.onload = function (e) {
        document.querySelector("#result").src = e.target.result;
    };

    // выполнение функции при выборки файла
    document.querySelector("input").addEventListener("change", loadImageFile);

    // функция выборки файла
    function loadImageFile() {
        var file = document.querySelector("input").files[0];
        FReader.readAsDataURL(file);
    }
</script>