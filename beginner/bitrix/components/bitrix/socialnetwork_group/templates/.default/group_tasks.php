<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$pageId = "group_tasks";
include("util_group_menu.php");
include("util_group_profile.php");
?>
<?
if (CSocNetFeatures::IsActiveFeature(SONET_ENTITY_GROUP, $arResult["VARIABLES"]["group_id"], "tasks"))
{
	?>
	<?
	if (COption::GetOptionString("intranet", "use_tasks_2_0", "N") == "Y")
	{
		$APPLICATION->IncludeComponent(
			"bitrix:tasks.list",
			".default",
			Array(
				"GROUP_ID" => $arResult["VARIABLES"]["group_id"],
				"ITEMS_COUNT" => $arParams["ITEM_DETAIL_COUNT"],
				"PAGE_VAR" => $arResult["ALIASES"]["page"],
				"GROUP_VAR" => $arResult["ALIASES"]["group_id"],
				"VIEW_VAR" => $arResult["ALIASES"]["view_id"],
				"TASK_VAR" => $arResult["ALIASES"]["task_id"],
				"ACTION_VAR" => $arResult["ALIASES"]["action"],
				"PATH_TO_USER_TASKS_TEMPLATES" => $arParams["PATH_TO_USER_TASKS_TEMPLATES"],
				"PATH_TO_GROUP_TASKS" => $arResult["PATH_TO_GROUP_TASKS"],
				"PATH_TO_GROUP_TASKS_TASK" => $arResult["PATH_TO_GROUP_TASKS_TASK"],
				"PATH_TO_GROUP_TASKS_VIEW" => $arResult["PATH_TO_GROUP_TASKS_VIEW"],
				"PATH_TO_GROUP_TASKS_REPORT" => $arResult["PATH_TO_GROUP_TASKS_REPORT"],
				"PATH_TO_USER_PROFILE" => $arParams["PATH_TO_USER"],
				"PATH_TO_GROUP" => $arResult["PATH_TO_GROUP"],
				"PATH_TO_MESSAGES_CHAT" => $arParams["PATH_TO_MESSAGES_CHAT"],
				"PATH_TO_VIDEO_CALL" => $arParams["PATH_TO_VIDEO_CALL"],
				"PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
				"TASKS_FIELDS_SHOW" => $arParams["TASKS_FIELDS_SHOW"],
				"SET_NAV_CHAIN" => $arResult["SET_NAV_CHAIN"],
				"SET_TITLE" => $arResult["SET_TITLE"],
				"FORUM_ID" => $arParams["TASK_FORUM_ID"],
				"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
				"SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
				"DATE_TIME_FORMAT" => $arResult["DATE_TIME_FORMAT"],
				"SHOW_YEAR" => $arParams["SHOW_YEAR"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"USE_THUMBNAIL_LIST" => "N",
				"INLINE" => "Y",
				'HIDE_OWNER_IN_TITLE' => $arParams['HIDE_OWNER_IN_TITLE']
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);
	}
	else
	{
		$APPLICATION->IncludeComponent("bitrix:intranet.tasks.menu", ".default", Array(
				"IBLOCK_ID" => $arParams["TASK_IBLOCK_ID"],
				"OWNER_ID" => $arResult["VARIABLES"]["group_id"],
				"TASK_TYPE" => 'group',
				"PAGE_VAR" => $arResult["ALIASES"]["page"],
				"GROUP_VAR" => $arResult["ALIASES"]["group_id"],
				"VIEW_VAR" => $arResult["ALIASES"]["view_id"],
				"TASK_VAR" => $arResult["ALIASES"]["task_id"],
				"ACTION_VAR" => $arResult["ALIASES"]["action"],
				"PATH_TO_GROUP_TASKS" => $arResult["PATH_TO_GROUP_TASKS"],
				"PATH_TO_GROUP_TASKS_TASK" => $arResult["PATH_TO_GROUP_TASKS_TASK"],
				"PATH_TO_GROUP_TASKS_VIEW" => $arResult["PATH_TO_GROUP_TASKS_VIEW"],
				"PAGE_ID" => "group_tasks",
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);
		$APPLICATION->IncludeComponent(
			"bitrix:intranet.tasks",
			".default",
			Array(
				"IBLOCK_ID" => $arParams["TASK_IBLOCK_ID"],
				"OWNER_ID" => $arResult["VARIABLES"]["group_id"],
				"TASK_TYPE" => 'group',
				"ITEMS_COUNT" => $arParams["ITEM_DETAIL_COUNT"],
				"PAGE_VAR" => $arResult["ALIASES"]["page"],
				"GROUP_VAR" => $arResult["ALIASES"]["group_id"],
				"VIEW_VAR" => $arResult["ALIASES"]["view_id"],
				"TASK_VAR" => $arResult["ALIASES"]["task_id"],
				"ACTION_VAR" => $arResult["ALIASES"]["action"],
				"PATH_TO_GROUP_TASKS" => $arResult["PATH_TO_GROUP_TASKS"],
				"PATH_TO_GROUP_TASKS_TASK" => $arResult["PATH_TO_GROUP_TASKS_TASK"],
				"PATH_TO_GROUP_TASKS_VIEW" => $arResult["PATH_TO_GROUP_TASKS_VIEW"],
				"PATH_TO_USER" => $arParams["PATH_TO_USER"],
				"PATH_TO_GROUP" => $arResult["PATH_TO_GROUP"],
				"PATH_TO_MESSAGES_CHAT" => $arParams["PATH_TO_MESSAGES_CHAT"],
				"PATH_TO_VIDEO_CALL" => $arParams["PATH_TO_VIDEO_CALL"],
				"PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
				"TASKS_FIELDS_SHOW" => $arParams["TASKS_FIELDS_SHOW"],
				"SET_NAV_CHAIN" => $arResult["SET_NAV_CHAIN"],
				"SET_TITLE" => $arResult["SET_TITLE"],
				"FORUM_ID" => $arParams["TASK_FORUM_ID"],
				"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
				"SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
				"DATE_TIME_FORMAT" => $arResult["DATE_TIME_FORMAT"],
				"SHOW_YEAR" => $arParams["SHOW_YEAR"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"USE_THUMBNAIL_LIST" => "N",
				"INLINE" => "Y",
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);
	}
}
?>