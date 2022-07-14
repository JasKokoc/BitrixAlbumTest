<?php

use Bitrix\Main\UserTable;

class UserProfileManagement
{
    protected static function checkEmail($email)
    {
        $user = UserTable::getList([
            'filter' => [
                'EMAIL' => $email
            ],
            'select' => [
                '*'
            ]
        ])->fetch();
    }

}

AddEventHandler("main", "OnBeforeUserRegister", array("UserProfileManagement", "OnBeforeUserRegisterHandler"));




