<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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
if(!isset($arParams["PARAM_PARSER"])) $arParams["PARAM_PARSER"] = "https://pogoda.yandex.ru/kaliningrad";
if(!isset($arParams["CACHE_GROUPS"])) $arParams["CACHE_GROUPS"] = "N";

if(CModule::IncludeModule('iblock')) {


    //
    if (!function_exists('smallWeatherNewParcer')) {
        function smallWeatherNewParcer($PP)
        {
            $PP = ($PP?$PP:$this->$URL_PARSER_);
            $arResult = array();
            require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/acs/acs.weather.parser.details/phpQuery/phpQuery.php");
            $PARAM_PARSER = file_get_contents($PP);
            $doc = phpQuery::newDocument($PARAM_PARSER);

            //
            $arResult["HEADER"] = $doc->find('div.content__main h1.title_level_1')->text();

            // в массив для мелкого виджета и т.д.
            $current_weather__col = $doc->find('div.content__main div.content__row');
            $fact_ = pq($current_weather__col)->find('div.fact');
            $fact_header_ = pq($fact_);
            $arResult['fact_basic'] = $fact_header_->find('a.fact__basic')->html();
            $arResult['fact_condition'] = $fact_header_->find('div.fact__condition')->text();
            $arResult['feels_like']['label'] = $fact_header_->find('dl.fact__feels-like dt.term__label')->text();
            $arResult['feels_like']['value'] = $fact_header_->find('dl.fact__feels-like dd.term__value')->text();
            //
            $arResult['yesterday']['label'] = $fact_header_->find('dl.fact__yesterday dt.term__label')->text();
            $arResult['yesterday']['value'] = $fact_header_->find('dl.fact__yesterday dd.term__value')->text();
            //

            $fact__props = $fact_header_->find('div.fact__props dl.term_orient_v');
            foreach($fact__props as $el){
                $q = pq($el);
                $label_ = $q->find('dt.term__label')->text();
                $value_ = $q->find('dd.term__value')->text();
                if(strlen($label_)>0 && strlen($value_)>0) {
                    $arResult['props'][] = array('label' => $label_, 'value' => $value_);
                }
            }
            return $arResult;
        }

    }

    // функция ARRAY - XML
    if (!function_exists('array_to_xml')) {
        // сама функция преобразования
        function array_to_xml($array, &$xml_user_info) {
            foreach($array as $key => $value) {
                if(is_array($value)) {
                    if(!is_numeric($key)){
                        $subnode = $xml_user_info->addChild("$key");
                        array_to_xml($value, $subnode);
                    }else{
                        $subnode = $xml_user_info->addChild("item$key");
                        array_to_xml($value, $subnode);
                    }
                }else {
                    $xml_user_info->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }
    }

    // функция возвращает массив из xml обратная функция array_to_xml
    if (!function_exists('XML2Array')) {
        function XML2Array(SimpleXMLElement $parent)
        {
            $array = array();

            foreach ($parent as $name => $element) {
                ($node = & $array[$name])
                && (1 === count($node) ? $node = array($node) : 1)
                && $node = & $node[];

                $node = $element->count() ? XML2Array($element) : trim($element);
            }

            return $array;
        }
    }

    if ($this->StartResultCache($arParams["CACHE_TIME"], array(($arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $arParams), 'left_weather_parser')) {
        //
        require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/xml.php");

        $result = smallWeatherNewParcer($arParams["PARAM_PARSER"]);
        //p($result,'p');
        //$arResult = $result;
        if ($result && count($result['props'])>0) {
            // выводим
            $arResult = $result;

            // записываем xml
            //creating object of SimpleXMLElement
            $xml_weather= new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><weather creation-date=".'"'.date('Y-m-d H:i:s T', time()).'"'."></weather>");
            //function call to convert array to xml
            array_to_xml($result,$xml_weather);
            //saving generated xml file
            $xml_file = $xml_weather->asXML($_SERVER["DOCUMENT_ROOT"].$componentPath."/parser_weather.xml");

        } else {
            // если $result == false то данные не кешируем && берем данные из xml данных и т.д.
            // берем данные из xml
            $path = $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/acs/acs.weather.parser/parser_weather.xml"; // откуда читаем
            //
            $xmlArr   = simplexml_load_file($path); //simplexml_load_string($buffer);
            $arrayXml = XML2Array($xmlArr);
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