<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
//
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

class AcsYandexMapClass extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => isset($arParams["CACHE_TYPE"])?$arParams["CACHE_TYPE"]:"N",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"])?$arParams["CACHE_TIME"]:0, // one hour
            "CACHE_GROUPS" => isset($arParams["CACHE_GROUPS"])?$arParams["CACHE_GROUPS"]:"N",
            "DIV" => isset($arParams["DIV"])?$arParams["DIV"]:"mapCamp",
            "PRESET" => isset($arParams["PRESET"])?$arParams["PRESET"]:"islands#dotIcon", // style icon for maps
            "ICON_COLOR" => isset($arParams["ICON_COLOR"])?$arParams["ICON_COLOR"]:"#64be23", // color for maps
            "HEIGHT" => isset($arParams["HEIGHT"])?$arParams["HEIGHT"]:"350",
            "CLUSTERER" => isset($arParams["CLUSTERER"])?$arParams["CLUSTERER"]:"islands#invertedDarkGreenClusterIcons",
            "ITEMS" => isset($arParams["ITEMS"]) && is_array($arParams['ITEMS'])?$arParams['ITEMS']:[['COORDINATES'=>'55.765625,37.710359','title'=>'Наши контакты','description'=>'г. Москва, ул.Сторожевая д.4, стр.5']],
        ];
        return $result;
    }

    public function executeComponent()
    {
        global $USER;
        if ($this->StartResultCache(false, array(($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $this->arParams), 'ads_maps'))
        {
            $this->arResult["DIV"] = $this->arParams["DIV"];
            $this->arResult["HEIGHT"] = $this->arParams["HEIGHT"];
            if(count($this->arParams["ITEMS"])):
                $this->arResult["ITEMS"] = $this->arParams["ITEMS"];
            endif;
            //
            $this->SetResultCacheKeys([
                "ITEMS",
                "HEIGHT",
                "DIV"
            ]);
            $this->includeComponentTemplate();
        }
        return $this->arResult["DIV"];
    }
}