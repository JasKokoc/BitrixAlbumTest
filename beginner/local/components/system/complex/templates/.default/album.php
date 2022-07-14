<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @global $APPLICATION
 * @var \CBitrixComponentTemplate $this
 * @var \SystemComplexComponent $component
 */
$APPLICATION->setTitle('Просмотр альбома');

$APPLICATION->IncludeComponent('project:album.detail', '.default', [
    'CACHE_TYPE' => 'N',
    'CODE' => $arResult['VARIABLES']['CODE'],
    'ID' => $arResult['VARIABLES']['ALBUM_ID'],
    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
    "IBLOCK_CODE" => $arParams['IBLOCK_CODE'],
    "NEWS_COUNT" => $arParams['COUNT'],
    'FIELD_CODE' => [
        "ID",
        "NAME",
        "PREVIEW_TEXT",
        "PROPERTY_PHOTOS",
        "DETAIL_TEXT",
    ]
]);
