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
    if(CIBlock::GetPermission($iblockId)>='W')
    {
        $DB->StartTransaction();
        if(!CIBlockElement::Delete($_POST['id']))
        {
            $result['message'] = 'Ошибка!';
            $result['success'] = false;
            $DB->Rollback();
        }
        else
            $DB->Commit();
        $result['message'] =  'Удалено!';
        $result['success'] =  true;
    }
    $response = new Json($result);
    $response->setStatus(200);
}
$response->send();
?>