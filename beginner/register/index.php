<?php
/**
 * @global $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Регистрация'); ?>
<?php $APPLICATION->IncludeComponent(
	"project:register",
	"",
	array(
		"AUTH" => "Y",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE_NUMBER",
		),
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => array(
			0 => "PHONE_NUMBER",
		),
		"SUCCESS_PAGE" => "/albums/",
		"USER_PROPERTY" => array(
		),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"COMPONENT_TEMPLATE" => "register"
	),
	false
); ?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>