<?php
/**
 * @global $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var \CBitrixComponentTemplate $this
 * @var \SystemComplexComponent $component
 */

?>
<?php

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Response\Json;
use \WheatleyWL\BXIBlockHelpers\IBlockHelper;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (Context::getCurrent()->getRequest()->isAjaxRequest()) {
    $result = [
        'success' => false,
        'message' => 'error',
    ];
    CModule::IncludeModule('iblock');
    $iblockId = \WheatleyWL\BXIBlockHelpers\IBlockHelper::getIBlockIdByCode('albums', 'albums');

    $arList = CIBlockElement::GetList([],
        ['IBLOCK_ID' => $iblockId, 'CODE' => $_POST['albumid']],
        false, false,
        ['ID']
    );
    $arDb = $arList->Fetch();
    $albumID = $arDb;

    function reArrayFiles($file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    if (!empty($_FILES['uploadImages']['name'][0])) {
        $arFiles = reArrayFiles($_FILES['uploadImages']);
        CIBlockElement::SetPropertyValueCode($albumID['ID'], "PHOTOS", $arFiles);
        $result['messge'] = 'Изображения добавлены!';
        $result['success'] = true;
    }
    else {
        $result['message'] = 'Выберите изображения!';
        $result['success'] = false;
    }
    $response = new Json($result);
    $response->setStatus(200);
}
    $response->send();
?>
