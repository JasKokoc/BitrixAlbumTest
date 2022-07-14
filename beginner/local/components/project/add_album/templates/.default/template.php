<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * variables
 * @var array $arResult
 * @var array $arParams
 */

use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);
?>
<div class="container">
    <main>
        <form id="add-album-form" method="post" action="<?= POST_FORM_ACTION_URI; ?>">
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
                        <input type="file" id="uploadImage" class="form-control" accept="image/*"/>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="albumName" class="">Название альбома</label>
                            <input type="text" class="form-control" id="albumName" placeholder="" value="" required>
                            <label for="albumDescription" class="">Описание альбома</label>
                            <input type="text" class="form-control" id="albumDescription" placeholder="" value=""
                                   required>
                        </div>
                        <hr class="my-4">
                        <button data-toggle="modal" data-target="#add-album-modal" class="w-100 btn btn-primary btn-lg"
                                type="submit">Создать
                        </button>

        </form>
</div>


