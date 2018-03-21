<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @global CDatabase $DB */
global $DB;
/** @global CUser $USER */
global $USER;
/** @global CMain $APPLICATION */
global $APPLICATION;
/** @global CIntranetToolbar $INTRANET_TOOLBAR */
global $INTRANET_TOOLBAR;

if(!isset($arParams["CACHE_TIME"])) $arParams["CACHE_TIME"] = 3600;
if(!isset($arParams["PARAM_CITY"])) $arParams["PARAM_CITY"] = 26702;
if(!isset($arParams["PARAM_PARSER"])) $arParams["PARAM_PARSER"] = "https://yandex.ru/pogoda/kaliningrad/details";
// $arParams["PARAM_PARSER"] = "https://yandex.ru/pogoda/kaliningrad/details";

if(CModule::IncludeModule('iblock')) {

    //
    $arResult = array();
    //
    if ($this->StartResultCache($arParams["CACHE_TIME"], array(($arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $arParams), 'lideon_weather_parser')) {

		//
        require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/xml.php");

        $result = $this->acsWeatherParserNew($arParams["PARAM_PARSER"]);
        if ($result && count($result['FORECAST_BRIEF'])>0) {
            // выводим
            $arResult = $result;

            // записываем xml
            //creating object of SimpleXMLElement
            $xml_weather= new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><weather creation-date=".'"'.date('Y-m-d H:i:s T', time()).'"'."></weather>");
            //function call to convert array to xml
            $this->array_to_xml($result,$xml_weather);
            //saving generated xml file
            $xml_file = $xml_weather->asXML($_SERVER["DOCUMENT_ROOT"].$componentPath."/parser_weather.xml");

        } else {
            // если $result == false то данные не кешируем && берем данные из xml данных и т.д.
            // берем данные из xml
            $path = $_SERVER["DOCUMENT_ROOT"].$componentPath."/parser_weather.xml"; // откуда читаем
            //
            $xmlArr   = simplexml_load_file($path); //simplexml_load_string($buffer);
            $arrayXml = $this->XML2Array($xmlArr);
            $arrayXml = array($xmlArr->getName() => $arrayXml);
            // p($arrayXml,"p");
            $arResult = $arrayXml['weather'];

            // не кешируем
            $this->AbortResultCache();
        }
        //

        $this->IncludeComponentTemplate();
    }

}