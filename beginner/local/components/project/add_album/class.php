<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


CBitrixComponent::includeComponentClass('system:standard.elements.list');


class Add_albumComponent extends SystemStandardElementsListComponent
{
    public function getResult()
    {
        if (!empty($_REQUEST['albumName']) && !empty($_REQUEST['albumDescription'])) {
            CModule::IncludeModule('iblock');
            $id = false;
            $id[] = $_POST['id'];

            $this->arResult['addAlbum'] = [
                "DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
                "CREATED_BY" => $GLOBALS['USER']->GetID(),    //Передаем ID пользователя кто добавляет
                "NAME" => strip_tags($_REQUEST['albumName']),
                "ACTIVE" => "Y", //поумолчанию делаем активным или ставим N для отключении поумолчанию
                "PREVIEW_TEXT" => strip_tags($_REQUEST['albumName']), //Анонс
                "PREVIEW_PICTURE" => $_FILES['uploadImage'], //изображение для анонса
                "DETAIL_TEXT" => strip_tags($_REQUEST['albumDescription']),
            ];
        }
    }
}
