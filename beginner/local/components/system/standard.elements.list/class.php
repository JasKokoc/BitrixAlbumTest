<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Engine\Response\Json;
use Bitrix\Main\Localization\Loc as Loc;

/**
 * Class SystemStandardElementsListComponent
 */
class SystemStandardElementsListComponent extends CBitrixComponent
{
    /**
     * кешируемые ключи arResult
     *
     * @var array()
     */
    protected $cacheKeys = [];

    /**
     * дополнительные параметры, от которых должен зависеть кеш
     *
     * @var array
     */
    protected $cacheAddon = [];

    /**
     * парамтеры постраничной навигации
     *
     * @var array
     */
    protected $navParams = [];

    /**
     * вохвращаемые значения
     *
     * @var mixed
     */
    protected $returned;

    /**
     * тегированный кеш
     *
     * @var mixed
     */
    protected $tagCache;

    protected $page = '';

    /**
     * подключает языковые файлы
     */
    public function onIncludeComponentLang()
    {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    /**
     * @param $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams)
    {
        $arParams['AJAX_KEY'] = $arParams['AJAX_KEY'] ? $arParams['AJAX_KEY'] : 'AJAX';
        $arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
        $arParams['IBLOCK_ID'] = (int)($arParams['IBLOCK_ID']);
        $arParams['IBLOCK_CODE'] = trim($arParams['IBLOCK_CODE']);
        $arParams['SHOW_NAV'] = ($arParams['SHOW_NAV'] == 'Y' ? 'Y' : 'N');
        $arParams['COUNT'] = (int)($arParams['COUNT']);
        $arParams['SORT_FIELD1'] = strlen($arParams['SORT_FIELD1']) ? $arParams['SORT_FIELD1'] : 'ID';
        $arParams['SORT_DIRECTION1'] = $arParams['SORT_DIRECTION1'] == 'ASC' ? 'ASC' : 'DESC';
        $arParams['SORT_FIELD2'] = strlen($arParams['SORT_FIELD2']) ? $arParams['SORT_FIELD2'] : 'ID';
        $arParams['SORT_DIRECTION2'] = $arParams['SORT_DIRECTION2'] == 'ASC' ? 'ASC' : 'DESC';
        $arParams['CACHE_TIME'] = (int)($arParams['CACHE_TIME']) > 0 ? (int)($arParams['CACHE_TIME']) : 3600;
        $arParams['AJAX'] = $arParams[$arParams['AJAX_KEY']] == 'N' ? 'N' : $_REQUEST[$arParams['AJAX_KEY']] == 'Y' ? 'Y' : 'N';
        $arParams['FILTER'] = is_array($arParams['FILTER']) && sizeof($arParams['FILTER']) ? $arParams['FILTER'] : [];
        $arParams['CACHE_TAG_OFF'] = $arParams['CACHE_TAG_OFF'] == 'Y';

        return $arParams;
    }

    /**
     * определяет читать данные из кеша или нет
     *
     * @return bool
     */
    protected function readDataFromCache()
    {
        global $USER;
        if ($this->arParams['CACHE_TYPE'] == 'N') {
            return false;
        }

        if (is_array($this->cacheAddon)) {
            $this->cacheAddon[] = $USER->GetUserGroupArray();
        } else {
            $this->cacheAddon = [$USER->GetUserGroupArray()];
        }

        return !($this->startResultCache(false, $this->cacheAddon, md5(serialize($this->arParams))));
    }

    /**
     * кеширует ключи массива arResult
     */
    protected function putDataToCache()
    {
        if (is_array($this->cacheKeys) && sizeof($this->cacheKeys) > 0) {
            $this->SetResultCacheKeys($this->cacheKeys);
        }
        $this->endCache();
    }

    /**
     * прерывает кеширование
     */
    protected function abortDataCache()
    {
        $this->AbortResultCache();
    }

    /**
     * завершает кеширование
     *
     * @return bool
     */
    protected function endCache()
    {
        if ($this->arParams['CACHE_TYPE'] == 'N') {
            return false;
        }

        $this->endResultCache();
    }

    /**
     * проверяет подключение необходиимых модулей
     *
     * @throws \Bitrix\Main\LoaderException
     */
    protected function checkModules()
    {
        if (!Main\Loader::includeModule('iblock')) {
            throw new Main\LoaderException(Loc::getMessage('STANDARD_ELEMENTS_LIST_CLASS_IBLOCK_MODULE_NOT_INSTALLED'));
        }
    }

    /**
     * проверяет заполнение обязательных параметров
     *
     * @throws \Bitrix\Main\SystemException
     */
    protected function checkParams()
    {
        if ($this->arParams['IBLOCK_ID'] <= 0 && strlen($this->arParams['IBLOCK_CODE']) <= 0) {
            throw new Main\ArgumentNullException('IBLOCK_ID');
        }
    }

    /**
     * выполяет действия перед кешированием
     */
    protected function executeProlog()
    {
        if ($this->arParams['COUNT'] > 0) {
            if ($this->arParams['SHOW_NAV'] == 'Y') {
                \CPageOption::SetOptionString('main', 'nav_page_in_session', 'N');
                $this->navParams = [
                    'nPageSize' => $this->arParams['COUNT'],
                ];
                $arNavigation = \CDBResult::GetNavParams($this->navParams);
                $this->cacheAddon = [$arNavigation];
            } else {
                $this->navParams = [
                    'nTopCount' => $this->arParams['COUNT'],
                ];
            }
        } else {
            $this->navParams = false;
        }
    }

    /**
     * Определяет ID инфоблока по коду, если не был задан
     */
    protected function getIblockId()
    {
        if ($this->arParams['IBLOCK_ID'] <= 0) {
            $filter = [
                'TYPE' => $this->arParams['IBLOCK_TYPE'],
                'CODE' => $this->arParams['IBLOCK_CODE'],
            ];
            $iterator = \CIBlock::GetList([], $filter);
            if ($iblock = $iterator->GetNext()) {
                $this->arParams['IBLOCK_ID'] = $iblock['ID'];
            } else {
                $this->abortDataCache();
                throw new Main\ArgumentNullException('IBLOCK_ID');
            }
        }
        $this->arResult['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
        $this->cacheKeys[] = 'IBLOCK_ID';
    }

    /**
     * получение результатов
     */
    protected function getResult()
    {
        $filter = [
            'IBLOCK_TYPE' => $this->arParams['IBLOCK_TYPE'],
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y',
        ];
        $sort = [
            $this->arParams['SORT_FIELD1'] => $this->arParams['SORT_DIRECTION1'],
            $this->arParams['SORT_FIELD2'] => $this->arParams['SORT_DIRECTION2'],
        ];
        $select = [
            'ID',
            'NAME',
            'DATE_ACTIVE_FROM',
            'DETAIL_PAGE_URL',
            'PREVIEW_TEXT',
            'PREVIEW_TEXT_TYPE',
        ];
        $iterator = \CIBlockElement::GetList($sort, $filter, false, $this->navParams, $select);
        while ($element = $iterator->GetNext()) {
            $this->arResult['ITEMS'][] = [
                'ID' => $element['ID'],
                'NAME' => $element['NAME'],
                'DATE' => $element['DATE_ACTIVE_FROM'],
                'URL' => $element['DETAIL_PAGE_URL'],
                'TEXT' => $element['PREVIEW_TEXT'],
            ];
        }
        if ($this->arParams['SHOW_NAV'] == 'Y' && $this->arParams['COUNT'] > 0) {
            $this->arResult['NAV_STRING'] = $iterator->GetPageNavString('');
        }
    }

    /**
     * выполняет действия после выполения компонента, например установка заголовков из кеша
     */
    protected function executeEpilog()
    {
        if ($this->arResult['IBLOCK_ID'] && $this->arParams['CACHE_TAG_OFF']) {
            \CIBlock::enableTagCache($this->arResult['IBLOCK_ID']);
        }
    }

    /**
     * выполняет логику работы компонента
     */
    public function executeComponent()
    {
        global $APPLICATION;
        try {
            $this->checkModules();
            $this->checkParams();

            if ($this->arParams['AJAX'] == 'Y') {
                $APPLICATION->RestartBuffer();
            }
            $this->executeProlog();
            if (!$this->readDataFromCache()) {
                $this->getIblockId();
                $this->getResult();
                $this->includeComponentTemplate($this->page);
                $this->putDataToCache();
            }
            $this->executeEpilog();
            if ($this->arParams['AJAX'] == 'Y') {
                exit(0);
            }
            return $this->returned;
        } catch (Exception $e) {
            $this->abortDataCache();
            ShowError($e->getMessage());
        }
    }
}
