<?php
/**
 * @global $APPLICATION
 */

use WheatleyWL\BXIBlockHelpers\IBlockHelper;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Альбом центр");
?>
<?php
$iblockId = \WheatleyWL\BXIBlockHelpers\IBlockHelper::getIBlockIdByCode('albums', 'albums');

$APPLICATION->IncludeComponent('project:albums.list', 'albums.list.formainpage', [
    'CACHE_TYPE' => 'A',
    'CACHE_TIME' => '3600',
    'COUNT' => '10',
    "IBLOCK_ID" => $iblockId,
    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
    "IBLOCK_CODE" => $arParams['IBLOCK_CODE'],
]);
 ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
