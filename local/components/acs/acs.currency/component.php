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

if (!isset($arParams["CACHE_TIME"])) $arParams["CACHE_TIME"] = 3600;

if(CModule::IncludeModule('iblock')) {


    $now_date = date("d/m/Y");
    //
    //AddMessage2Log("\n" . var_export($now_date, true) . " \n \r\n ", "day");
    //AddMessage2Log("\n" . var_export($gcD, true) . " \n \r\n ", "arr");

    //
    if ($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $arParams, $now_date), 'ads_currency')) {

        require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/xml.php");

        $arParams['DIGITS'] = intval($arParams['DIGITS']);

        $arResult['CBR']['DATE'] = date($arParams['DATE_FORMAT']);
        $currency_now_date = $this->getCurrencyDay($now_date);

        /**/
        if ($currency_now_date) {
            // алгоритм записи в файл и т.д. acs_curremcy.xml
            $this->getCurrencyDayAddFiles($currency_now_date, $now_date, Null);
            //
            $arResult['CBR_URL_'] = true;

        } else {
            // если $currency_now_date == false то данные не кешируем && берем данные из файла если такой файл есть
            // берем из файла и т.д.
            $currency_now_date =  $this->toReadCurrencyDayFiles();
            $arResult['CBR_URL_'] = false;

        }

        // вывод и т.д.
        if($currency_now_date){
            foreach ($arParams['CURR'] as $cur):
                $res = array();
                $res['NAME'] = $currency_now_date[$cur]['Name'];
                $res['VAL'] = number_format(round($currency_now_date[$cur]['Value'], $arParams['DIGITS']), $arParams['DIGITS'], $arParams['DELIMITER'], '');
                $res['NOMINAL'] = $currency_now_date[$cur]['Nominal'];
                /**/
                $arResult['CBR']['CUR'][$cur] = $res;
            endforeach;
        }

        //
        if($arResult['CBR_URL_']){
            $this->SetResultCacheKeys(array(
                "CBR",
            ));
        }else{
            // данные не кешируем
            $this->AbortResultCache();
        }


        /**/
        $this->IncludeComponentTemplate();
    }

} // end moduls
