<?php
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Response\Json;
use \WheatleyWL\BXIBlockHelpers\IBlockHelper;
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
CBitrixComponent::includeComponentClass('system:standard.elements.list');

/**
 * Class ProjectAlbumsListComponent
 */


class ProjectAlbumsListComponent extends SystemStandardElementsListComponent
{

    protected function getResult()
    {
        $iblockId = \WheatleyWL\BXIBlockHelpers\IBlockHelper::getIBlockIdByCode('albums', 'albums');
        $filter = [
            'IBLOCK_ID' => $this->arResult['IBLOCK_ID'],
            'CREATED_BY' => $this->arParams['CREATED_BY'],
        ];
        $select = [
            'CODE',
            'IBLOCK_ID',
            'ID',
            'PREVIEW_TEXT',
            'PREVIEW_PICTURE',
            'CREATED_BY'

        ];



        $dbList = CIBlockElement::GetList(['timestamp_x' => ['DESC']], $filter, false, $this->navParams, $select);

        while ($item = $dbList->Fetch()) {

            $item['PREVIEW_PICTURE_SRC'] = CFile::GetPath($item['PREVIEW_PICTURE']);
            $this->arResult['ALBUMS'][] = [
                'IDFORDELETE' => $item['ID'],
                'TEXT' => $item['PREVIEW_TEXT'],
                'ID' => $item['CODE'],
                'PREVIEW_PICTURE_SRC' => $item['PREVIEW_PICTURE_SRC'],
                'CREATED_BY' => $item['CREATED_BY'],
                'TIMESTAMP' => $item['TIMESTAMP_X']
            ];
        }
        if ($this->arParams['SHOW_NAV'] == 'Y' && $this->arParams['COUNT'] > 0) {
            $this->arResult['NAV_STRING'] = $dbList->GetPageNavString('');
        }

    }

}

