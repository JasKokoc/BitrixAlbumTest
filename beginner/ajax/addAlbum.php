<?php

/***
 * @global $APPLICATION
 * @global $USER
 */

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Response\Json;
use \WheatleyWL\BXIBlockHelpers\IBlockHelper;
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$iblockId = \WheatleyWL\BXIBlockHelpers\IBlockHelper::getIBlockIdByCode('albums', 'albums');
if (Context::getCurrent()->getRequest()->isAjaxRequest()) {
    $result = [
        'success' => false,
        'message' => 'Неизвестная ошибка',
    ];
    if (!empty($_POST['albumName']) && !empty($_POST['albumDescription']) && !empty($_FILES['previewImage'])) {
        CModule::IncludeModule('iblock');
        $el = new CIBlockElement();
        $arParams = ["replace_space" => "-", "replace_other" => "-"];
        $trans = transliterate($_POST['albumName']);
        $Fields = [
            "IBLOCK_ID" => $iblockId,
            "DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
            "CREATED_BY" => $GLOBALS['USER']->GetID(),    //Передаем ID пользователя кто добавляет
            "NAME" => strip_tags($_POST['albumName']),
            "CODE" => $trans,
            "ACTIVE" => "Y", //поумолчанию делаем активным или ставим N для отключении поумолчанию
            "PREVIEW_TEXT" => strip_tags($_POST['albumName']), //Анонс
            "PREVIEW_PICTURE" => $_FILES['previewImage'], //изображение для анонса
            "DETAIL_TEXT" => strip_tags($_POST['albumDescription']),

        ];
        if ($albumID = $el->Add($Fields)) {
            $result['message'] =  $albumID;
            $result['success'] =  true;
        } else {
            $result['message'] = $el->LAST_ERROR;
            $result['success'] = false;
        }
    }
    $response = new Json($result);
    $response->setStatus(200);
}
$response->send();
?>
