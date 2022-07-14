<?php
/**
 * @global $APPLICATION
 */

use \WheatleyWL\BXIBlockHelpers\IBlockHelper;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Main Page"); ?>
<?php
$iblockId = \WheatleyWL\BXIBlockHelpers\IBlockHelper::getIBlockIdByCode('albums', 'albums'); ?>
<?
$APPLICATION->IncludeComponent(
    "system:complex",
    "",
    array(
        "CACHE_TIME" => "0",
        "CACHE_TYPE" => "A",
        "COUNT" => "6",
        "IBLOCK_CODE" => "albums",
        "IBLOCK_ID" => $iblockId,
        "IBLOCK_TYPE" => "albums",
        "SEF_FOLDER" => "/albums/",
        "SEF_MODE" => "Y",
        "SEF_URL_TEMPLATES" => [
            "albums" => "index.php",
            "add_album" => "add_album/",
            "album" => "#ALBUM_ID#/",
            "album_uploads" => "#ALBUM_ID#/uploads/",
        ],
        "SHOW_NAV" => "N",
        "SORT_DIRECTION1" => "ASC",
        "SORT_DIRECTION2" => "ASC",
        "SORT_FIELD1" => "ID",
        "SORT_FIELD2" => "ID"
    )
); ?><?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>