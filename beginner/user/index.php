<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
if (!$USER->IsAuthorized()) LocalRedirect('/auth/');
$APPLICATION->SetTitle("Пользователь");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.profile",
	"",
	Array(
		"CHECK_RIGHTS" => "N",
		"SEND_INFO" => "N",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => array(),
		"USER_PROPERTY_NAME" => ""
	)

);
?><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>