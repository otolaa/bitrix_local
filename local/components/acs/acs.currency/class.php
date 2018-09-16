<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
//
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

class AcsCurrencyClassAdd extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => isset($arParams["CACHE_TYPE"])?$arParams["CACHE_TYPE"]:"A",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"])?$arParams["CACHE_TIME"]:3600, // one hour
            "CACHE_GROUPS" => isset($arParams["CACHE_GROUPS"])?$arParams["CACHE_GROUPS"]:"N",
            "CURR" => isset($arParams["CURR"]) && is_array($arParams["CURR"])?$arParams["CURR"]:["USD","EUR","PLN"],
            "DAY" => isset($arParams["DAY"]) && intval($arParams["DAY"])>1?intval($arParams["DAY"]):10, // parsim 10 days
        ];
        return $result;
    }

    //
    public function getCurrencyDay()
    {
        $cbr_xml_ = NULL;
        $date_ = date("d/m/Y", time());
        $url = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=".$date_."";
        $xml = simplexml_load_file($url);
        if($xml ===  FALSE){
            // deal with error
            return FALSE;
        }
        //
        $dt_ = (string)$xml->attributes()->Date;
        $cbr = [];
        $i=0;
        foreach ($xml->Valute AS $currency_){
            foreach ($currency_ AS $val_){
                $cbr[$i][] = (string)$val_;
            }
            $i++;
        }
        return ["DATE"=>$dt_, "ITEMS"=>$cbr];
    }

    public function executeComponent()
    {
        global $USER;
        if ($this->StartResultCache(false, array(($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $this->arParams, date("d/m/Y")), 'ads_currency'))
        {
            $this->arResult["DATE"] = date("d.m.Y");
            $currency_now_date = $this->getCurrencyDay();
            if($currency_now_date){
                //
                $reportArr = unserialize(file_get_contents(dirname(__FILE__)."/cbr_parser.txt"));
                $reportArr = $reportArr?$reportArr:[];
                $reportArr = count($reportArr)?array_merge([$currency_now_date['DATE']=>$currency_now_date],$reportArr):[$currency_now_date['DATE']=>$currency_now_date];
                $reportArr = array_slice($reportArr, 0, $this->arParams["DAY"]);   // returns a slice of an array of 10 elements
                $this->arResult["CBR"] = $reportArr;
                // write everything to a file txt
                file_put_contents(dirname(__FILE__)."/cbr_parser.txt", serialize($reportArr));
                $this->arResult['CBR_URL_CACHE'] = true;
            }else{
                // we deliver from a file
                $this->arResult["CBR"] = unserialize(file_get_contents(dirname(__FILE__)."/cbr_parser.txt"));
                $this->arResult['CBR_URL_CACHE'] = false;
            }
            // If parsing is successful then we cache the data
            if($this->arResult['CBR_URL_CACHE']){
                $this->SetResultCacheKeys([
                    "CBR",
                    "DATE",
                ]);
            }else{
                // data is not cached
                $this->AbortResultCache();
            }
            $this->includeComponentTemplate();
        }
        return $this->arResult["DATE"];
    }
}