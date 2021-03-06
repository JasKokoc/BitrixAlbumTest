<?
namespace Bitrix\Socialnetwork\Integration\Main\UISelector;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\UserTable;

class Users extends \Bitrix\Main\UI\Selector\EntityBase
{
	public static function getNameTemplate($requestNameTemplate = '')
	{
		if (!empty($requestNameTemplate))
		{
			preg_match_all("/(#NAME#)|(#LAST_NAME#)|(#SECOND_NAME#)|(#NAME_SHORT#)|(#SECOND_NAME_SHORT#)|\\s|\\,/", urldecode($requestNameTemplate), $matches);
			$result = implode("", $matches[0]);
		}
		else
		{
			$result = \CSite::getNameFormat(false);
		}

		return $result;
	}

	public function getData($params = array())
	{
		$result = array(
			'ITEMS' => array(),
			'ITEMS_LAST' => array(),
			'ITEMS_HIDDEN' => array(),
			'ADDITIONAL_INFO' => array(
				'PREFIX' => 'U',
				'GROUPS_LIST' => array(
					'users' => array(
						'TITLE' => Loc::getMessage('MAIN_UI_SELECTOR_TITLE_USERS'),
						'TYPE_LIST' => array(Handler::ENTITY_TYPE_USERS, Handler::ENTITY_TYPE_EMAILUSERS, Handler::ENTITY_TYPE_GROUPS),
						'DESC_LESS_MODE' => 'Y',
						'SORT' => 10
					)
				),
				'SORT_SELECTED' => 200
			)
		);

		$entityType = Handler::ENTITY_TYPE_USERS;

		$options = (!empty($params['options']) ? $params['options'] : array());

		$lastItems = (!empty($params['lastItems']) ? $params['lastItems'] : array());
		$selectedItems = (!empty($params['selectedItems']) ? $params['selectedItems'] : array());

		$selectedUserList = array();
		if (!empty($selectedItems[$entityType]))
		{
			$selectedUserList = array_map(function($code) { return preg_replace('/^U(\d+)$/', '$1', $code); }, $selectedItems[$entityType]);
		}

		$selected = array();
		if (!empty($selectedUserList))
		{
			$selected = \CSocNetLogDestination::getUsers(array(
				'id' => $selectedUserList,
				'CRM_ENTITY' => ModuleManager::isModuleInstalled('crm'),
				'IGNORE_ACTIVITY' => 'Y'
			));
		}

		if (Handler::isExtranetUser())
		{
			$items[$entityType] = \CSocNetLogDestination::getExtranetUser();
			$result['ADDITIONAL_INFO']['EXTRANET_USER'] = 'Y';

			if (!empty($selectedItems[$entityType]))
			{
				foreach($selectedItems[$entityType] as $code)
				{
					if (!isset($items[$entityType][$code]))
					{
						$result['ITEMS_HIDDEN'][] = $code;
					}
				}
			}

			$result['ITEMS'] = $items[$entityType];
			if(!empty($lastItems[$entityType]))
			{
				$result["ITEMS_LAST"] = array_values($lastItems[$entityType]);
			}
			$result["ITEMS_LAST"] = array_values(array_intersect($result["ITEMS_LAST"], array_keys($result['ITEMS'])));
		}
		else
		{
			$lastUserList = array();
			if(!empty($lastItems[$entityType]))
			{
				$lastUserList = array_map(function($code) { return preg_replace('/^U(\d+)$/', '$1', $code); }, $lastItems[$entityType]);
			}

			$result['ADDITIONAL_INFO']['EXTRANET_USER'] = 'N';

			if (!empty($lastUserList))
			{
				$items[$entityType] = \CSocNetLogDestination::getUsers(array(
					'id' => $lastUserList,
					'CRM_ENTITY' => ModuleManager::isModuleInstalled('crm')
				));

				$items[$entityType] = array_merge($items[$entityType], $selected);

				if (
					isset($options['extranetContext'])
					&& in_array($options['extranetContext'], array(Entities::EXTRANET_CONTEXT_INTERNAL, Entities::EXTRANET_CONTEXT_EXTERNAL))
				)
				{
					foreach($items[$entityType] as $key => $value)
					{
						if (isset($value["isExtranet"]))
						{
							if (
								(
									$value["isExtranet"] == 'Y'
									&& $options['extranetContext'] == Entities::EXTRANET_CONTEXT_INTERNAL
								)
								|| (
									$value["isExtranet"] == 'N'
									&& $options['extranetContext'] == Entities::EXTRANET_CONTEXT_EXTERNAL
								)
							)
							{
								unset($items[$entityType][$key]);
								unset($lastItems[$entityType][$key]);
							}
						}
					}
				}

				foreach($items[$entityType] as $key => $value)
				{
					if (
						!empty($value['isEmail'])
						&& $value['isEmail'] == 'Y'
					)
					{
						unset($items[$entityType][$key]);
						unset($lastItems[$entityType][$key]);
					}
				}

				if (!empty($selectedItems[$entityType]))
				{
					foreach($selectedItems[$entityType] as $code)
					{
						if (!isset($items[$entityType][$code]))
						{
							$result['ITEMS_HIDDEN'][] = $code;
						}
					}
				}
			}

			$result["ITEMS_LAST"] = array_values($lastItems[$entityType]);

			if (
				(
					isset($options["allowAddUser"])
					&& $options["allowAddUser"] == 'Y'
				)
				|| (
					isset($options["allowSearchEmailUsers"])
					&& $options["allowSearchEmailUsers"] == 'Y'
				)
				|| (
					isset($options["allowEmailInvitation"])
					&& $options["allowEmailInvitation"] == 'Y'
				)
			)
			{
				$items['LAST'] = $result["ITEMS_LAST"];
				\CSocNetLogDestination::fillEmails($items);
				$result["ITEMS_LAST"] = $items['LAST'];
				unset($items['LAST']);
			}

			if (
				(
					empty($items[$entityType])
					|| (
						is_array($items[$entityType])
						&& count($items[$entityType]) < 3
					)
				)
				&& ModuleManager::isModuleInstalled('intranet')
				&& (
					!isset($options['extranetContext'])
					|| $options['extranetContext'] != Entities::EXTRANET_CONTEXT_EXTERNAL
				)
			)
			{
				$lastUserList = array();

				$res = UserTable::getList(array(
					'order' => array(
						'LAST_ACTIVITY_DATE' => 'DESC'
					),
					'filter' => array(
						'!=UF_DEPARTMENT' => false,
						'=ACTIVE' => 'Y',
						'CONFIRM_CODE' => false
					),
					'select' => array('ID'),
					'limit' => 10
				));
				while($userFields = $res->fetch())
				{
					$lastUserList[] = $userFields['ID'];
				}

				$items[$entityType] = array_merge((is_array($items[$entityType]) ? $items[$entityType] : array()), \CSocNetLogDestination::getUsers(array(
					'id' => $lastUserList
				)));
				foreach($items[$entityType] as $item)
				{
					$result["ITEMS_LAST"][] = 'U'.$item['entityId'];
				}
			}
		}

		if (
			isset($options["showVacations"])
			&& $options["showVacations"] == 'Y'
		)
		{
			$result['ADDITIONAL_INFO']['USERS_VACATION'] = \Bitrix\Socialnetwork\Integration\Intranet\Absence\User::getDayVacationList();
		}

		$result['ITEMS'] = $items[$entityType];

		return $result;
	}

	public function search($params = array())
	{
		$result = array(
			'ITEMS' => array(),
			'ADDITIONAL_INFO' => array()
		);

		$entityOptions = (!empty($params['options']) ? $params['options'] : array());
		$requestFields = (!empty($params['requestFields']) ? $params['requestFields'] : array());
		$commonOptions = (!empty($requestFields['options']) ? $requestFields['options'] : array());

		$search = $requestFields['searchString'];
		$searchConverted = (!empty($requestFields['searchStringConverted']) ? $requestFields['searchStringConverted'] : false);
		$nameTemplate = self::getNameTemplate($commonOptions['userNameTemplate']);

		if (
			!empty($searchOptions['additional'])
			&& $searchOptions['additional'] == 'Y'
		)
		{
			$result["ITEMS"] = array();
			if (
				!empty($entityOptions['allowSearchNetwork'])
				&& $entityOptions['allowSearchNetwork'] == 'Y'
				&& Loader::includeModule('socialservices')
			)
			{
				$result["ITEMS"] = \Bitrix\Socialnetwork\Integration\Main\UISelector\Search::searchNetworkUsers(array(
					'search' => $search,
					'nameTemplate' => $nameTemplate
				));
			}

			return $result;
		}

		if (
			empty($entityOptions['allowSearch'])
			|| $entityOptions['allowSearch'] != 'N'
		)
		{
			$searchModified = false;
			$result["ITEMS"] = \CSocNetLogDestination::searchUsers(
				array(
					"SEARCH" => $search,
					"NAME_TEMPLATE" => $nameTemplate,
					"SELF" => (!empty($entityOptions['allowSearchSelf']) && $entityOptions['allowSearchSelf'] == 'Y'),
					"EMPLOYEES_ONLY" => (!empty($entityOptions['scope']) && $entityOptions['scope'] == "I"),
					"EXTRANET_ONLY" => (!empty($entityOptions['scope']) && $entityOptions['scope'] == "E"),
					"DEPARTAMENT_ID" => (
						!empty($commonOptions['siteDepartmentId']) && intval($commonOptions['siteDepartmentId']) > 0
							? intval($commonOptions['siteDepartmentId'])
							: false
					),
					"EMAIL_USERS" => (!empty($entityOptions['allowSearchByEmail']) && $entityOptions['allowSearchByEmail'] == 'Y'),
					"CRMEMAIL_USERS" => (!empty($entityOptions['allowSearchCrmEmailUsers']) && $entityOptions['allowSearchCrmEmailUsers'] == 'Y'),
					"NETWORK_SEARCH" => false,
				),
				$searchModified
			);

			if (!empty($searchModified))
			{
				$result['SEARCH'] = $searchModified;
			}

			if (
				empty($result["ITEMS"])
				&& $searchConverted
				&& $search != $searchConverted
			)
			{
				$result["ITEMS"] = \CSocNetLogDestination::searchUsers(
					array(
						"SEARCH" => $searchConverted,
						"NAME_TEMPLATE" => $nameTemplate,
						"SELF" => (!empty($entityOptions['allowSearchSelf']) && $entityOptions['allowSearchSelf'] == 'Y'),
						"EMPLOYEES_ONLY" => (!empty($entityOptions['scope']) && $entityOptions['scope'] == "I"),
						"EXTRANET_ONLY" => (!empty($entityOptions['scope']) && $entityOptions['scope'] == "E"),
						"DEPARTAMENT_ID" => (
							!empty($commonOptions['siteDepartmentId']) && intval($commonOptions['siteDepartmentId']) > 0
								? intval($commonOptions['siteDepartmentId'])
								: false
						),
						"EMAIL_USERS" => (!empty($entityOptions['allowSearchByEmail']) && $entityOptions['allowSearchByEmail'] == 'Y'),
						"CRMEMAIL_USERS" => (!empty($entityOptions['allowSearchCrmEmailUsers']) && $entityOptions['allowSearchCrmEmailUsers'] == 'Y'),
						"NETWORK_SEARCH" => false,
					),
					$searchModified
				);

				$result['SEARCH'] = $searchConverted;
			}
		}

		return $result;
	}

	public function loadAll()
	{
		return \CSocNetLogDestination::getUsers(array(
			'all' => 'Y'
		));
	}

	public function getItemName($itemCode = '')
	{
		return \Bitrix\Socialnetwork\Integration\Main\UISelector\Users::getUserName($itemCode);
	}

	public static function getUserName($itemCode = '')
	{
		global $USER;

		$result = '';

		$entityId = (
			preg_match('/^U(\d+)$/i', $itemCode, $matches)
			&& intval($matches[1]) > 0
				? intval($matches[1])
				: 0
		);

		if (
			$entityId  > 0
			&& \CSocNetUser::canProfileView($USER->getId(), $entityId)
		)
		{
			$res = UserTable::getList(array(
				'filter' => array(
					'=ID' => $entityId
				),
				'select' => array('NAME', 'SECOND_NAME', 'LAST_NAME', 'LOGIN')
			));

			if ($userFields = $res->fetch())
			{
				$result = \CUser::formatName(self::getNameTemplate(), $userFields, false);
			}
		}

		return $result;
	}
}