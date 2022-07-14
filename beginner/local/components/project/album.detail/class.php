<?php

use WheatleyWL\BXIBlockHelpers\IBlockHelper;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
CBitrixComponent::includeComponentClass('system:standard.elements.list');

/**
 * Class ProjectAlbumDetailComponent
 */
class ProjectAlbumDetailComponent extends SystemStandardElementsListComponent
{

    public function onPrepareComponentParams($arParams)
    {
        $result = parent::onPrepareComponentParams($arParams);
        $result['ID'] = $arParams['ID'];
        return $result;
    }


    protected function getResult()
    {
        $filter = [
            'CODE' => $this->arParams['ID'],
            'IBLOCK_ID' => $this->arResult['IBLOCK_ID'],
            'CREATED_BY' => $this->arParams['CREATED_BY'],
        ];
        $select = [
            'PREVIEW_TEXT',
            'CODE',
            'IBLOCK_ID',
            'ID',
            'PROPERTY_PHOTOS',
            'CREATED_BY'

        ];

        $dbList = CIBlockElement::GetList(['timestamp_x' => ['DESC']], $filter, false, $this->navParams, $select);
        $this->arResult['ALBUMS_DETAIL'] = [];

        while ($arList = $dbList->Fetch()) {

            $iblockId = IBlockHelper::getIBlockIdByCode('albums', 'albums');
            if (CModule::IncludeModule("iblock")) {
                $props = CIBlockElement::GetProperty($iblockId, $arList['ID'],);

                while ($ar_props = $props->Fetch()) {

                    $arList['PICTURES_SRC'] = CFile::GetPath($ar_props['VALUE']);
                    $arList['TEXT'] = $ar_props['DESCRIPTION'];

                    $this->arResult['ALBUMS_DETAIL'][] = [
                        'AlbID' => $arList['ID'],
                        'PREVIEW_TEXT' => $arList['PREVIEW_TEXT'],
                        'PROPERTY_VALUE' => $ar_props['VALUE'],
                        'PROPERTY_FOR_DELETE' => [$ar_props['PROPERTY_VALUE_ID'] => $ar_props['VALUE']],
                        'PROPERTY_ID' => $ar_props['PROPERTY_VALUE_ID'],
                        'CREATED_BY' => $arList['CREATED_BY'],
                        'TIMESTAMP' => $arList['TIMESTAMP_X'],
                        'PICTURES_SRC' => $arList['PICTURES_SRC'],
                        'TEXT' => $arList['TEXT'],
                    ];

                }
            }
        }
    }
}