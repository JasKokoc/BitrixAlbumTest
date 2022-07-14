<?php

/**
 * @global $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var \CBitrixComponentTemplate $this
 * @var \SystemComplexComponent $component
 */
$APPLICATION->setTitle('Добавление изображений');
if (!$USER->IsAuthorized()) {
    LocalRedirect('/auth/');
}

?>

<div class="container">
    <main>
        <form id="add-images-form" method="post" action="">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4"
                     src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72"
                     height="57">
                <h2>Добавление изображений</h2>
            </div>
            <div class="row g-5" id="addImage">
                <div class="col-md-7 col-lg-8">
                    <h4>Выберите изображения</h4>
                    <div class="input-group">
                        <input type="file" name="uploadImages[]" class="form-control" accept="image/*"
                               multiple/>
                    </div>
                    <div>
                        <input type="hidden" value="<?= $arResult['VARIABLES']['ALBUM_ID'] ?>" name="albumid">
                    </div>

                </div>
            </div>
            <br>
            <div class="col-md-7 col-lg-8">

                <button id="album-images-submit-btn" class="w-100 btn btn-primary btn-lg" type="submit">Добавить
                </button>

                <div>
        </form>
