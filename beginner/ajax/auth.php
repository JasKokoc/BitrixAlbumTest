<?php

/**
 * @global $APPLICATION
 * @global $USER
 */

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Response\Json;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (Context::getCurrent()->getRequest()->isAjaxRequest()) {
    $result = [
        'success' => false,
        'message' => 'Неизвестная ошибка',
    ];
    if (!$USER->IsAuthorized()) {
        $res = $USER->Login($_POST['USER_LOGIN'], $_POST['USER_PASSWORD'], 'Y');

        if (empty($res['MESSAGE'])) {
            $result['success'] = true;
            $result['message'] = 'Успешно авторизован';
        } else {
            $result['success'] = false;
            $result['message'] = strip_tags($res['MESSAGE']);
        }
    }

    $response = new Json($result);
    if ($result['success']) {
        $response->setStatus(200);
    } else {
        $response->setStatus(400);
    }

    $response->send();
}
