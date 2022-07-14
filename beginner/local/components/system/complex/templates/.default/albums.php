<?php

/**
 * @var array $arParams
 * @global $APPLICATION
 * @var array $arResult
 * @var \CBitrixComponentTemplate $this
 * @var \SystemComplexComponent $component
 */
$APPLICATION->setTitle('Мои альбомы');
if (!$USER->IsAuthorized()) {
    LocalRedirect('/auth/');
}
$APPLICATION->IncludeComponent('project:albums.list', '.default', [
    'CACHE_TYPE' => 'A',
    'CACHE_TIME' => '3600',
    'IBLOCK_ID' => 6,
    'COUNT' => '10',
    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
    "IBLOCK_CODE" => $arParams['IBLOCK_CODE'],
]);
