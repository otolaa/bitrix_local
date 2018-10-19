<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

class weatherAPI extends \CBitrixComponent
{
    //
    private $URL_PARSER_PAGE = "https://yandex.ru/pogoda/kaliningrad/details";

    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => isset($arParams["CACHE_TYPE"])?$arParams["CACHE_TYPE"]:"A",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"])?$arParams["CACHE_TIME"]:3600*6, // six hour
            "CACHE_GROUPS" => isset($arParams["CACHE_GROUPS"])?$arParams["CACHE_GROUPS"]:"N",
            "URL_PARSER_PAGE" => isset($arParams["URL_PARSER_PAGE"])?$arParams["URL_PARSER_PAGE"]:$this->URL_PARSER_PAGE,
            "OLL_PAGE" => isset($arParams["OLL_PAGE"])?$arParams["OLL_PAGE"]:false,
        ];
        return $result;
    }

    // the Parser Xpath Weather
    public function acsWeatherParserXpath(){
        //
        $PARAM_PARSER = file_get_contents($this->arParams["URL_PARSER_PAGE"]);
        if($PARAM_PARSER ===  FALSE){
            return FALSE;
        }
        $weatherResult = []; //
        $doc = new DOMDocument();
        $doc->loadHTML($PARAM_PARSER); // from html
        $xpath = new DOMXpath($doc);
        // заголовок
        $h1 = $xpath->query('//div[@class="location-title"]/h1[@class="title title_level_1"]')->item(0)->textContent;
        $h2 = $xpath->query('//div[@class="location-title"]/h2[@class="title title_level_2 location-title__place"]')->item(0)->textContent;
        //
        $weatherResult["HEADER"] = $h1;
        $weatherResult["HEADER_CURRENT"] = $h2;
        //
        $daysArr = []; // массив дней и т.д.
        $dyl = $xpath->query('//div[@class="content"]/div/dt');
        foreach ($dyl as $dy){
            //
            $dn = $xpath->query('strong[@class="forecast-details__day-number"]',$dy)->item(0)->textContent;
            $dm = $xpath->query('small/span[@class="forecast-details__day-month"]',$dy)->item(0)->textContent;
            $dnm = $xpath->query('small/span[@class="forecast-details__day-name"]',$dy)->item(0)->textContent;
            $daysArr[] = $dn." ".$dm.", ".$dnm;
        }
        //
        $thArr = [];
        $th = $xpath->query('//div[@class="content"]/div/dd/table[@class="weather-table"]/thead')->item(0);
        foreach ($xpath->query('th/div',$th) as $thd){
            $thArr[] = $thd->textContent;
        }
        $weatherResult["HEADER_TABLE"] = $thArr;
        //
        $wArr = [];
        $wl = $xpath->query('//div[@class="content"]/div/dd/table[@class="weather-table"]/tbody[@class="weather-table__body"]');
        foreach ($wl as $kw=>$w){
            $wArrDay = [];
            foreach ($xpath->query('tr',$w) as $tr){
                $wDayItem = [];
                $rd = $xpath->query('td',$tr);
                $rd0 = $xpath->query('div/div',$rd->item(0))->item(0)->textContent;
                $rd1 = $xpath->query('div/div',$rd->item(0))->item(1)->textContent;
                $wDayItem[] = [$rd0,$rd1];
                //
                $rdc = $xpath->query('i',$rd->item(1))->item(0)->getAttribute('class');
                $wDayItem[] = $rdc;
                //
                $rd2 = $rd->item(2)->textContent;
                $wDayItem[] = $rd2;
                $rd3 = $rd->item(3)->textContent;
                $wDayItem[] = $rd3;
                $rd4 = $rd->item(4)->textContent;
                $wDayItem[] = $rd4;
                //
                //
                $rd5 = [];
                $span = @$xpath->query('div/span/span',$rd->item(5))->item(0);
                if($span===Null){ /**/ }else{
                    if ($ss = $span->textContent) {
                        $rd5[] = $ss;
                    }
                }
                $abbr = @$xpath->query('div/div/abbr',$rd->item(5))->item(0);
                if($abbr===Null){ /**/ }else{
                    if ($ss = $abbr->getAttribute('title')) {
                        $rd5[] = $ss;
                    }
                }
                $wDayItem[] = count($rd5)? $rd5:$rd->item(5)->textContent;
                //
                $rd6 = $rd->item(6)->textContent;
                $wDayItem[] = $rd6;
                //
                $wArrDay[] = $wDayItem;
            }
            //
            $wArr[$kw]['DAY'] = $daysArr[$kw];
            $wArr[$kw]['ITEMS'] = $wArrDay;
        }
        $weatherResult["WEEK_TABLE"] = $wArr;
        return $weatherResult;
    }

    public function executeComponent()
    {
        global $USER;
        if ($this->StartResultCache(false, array(($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $this->arParams, date("d.m.Y")), 'weather_parser')){
            //
            $weather_now_date = $this->acsWeatherParserXpath();
            if($weather_now_date){
                $this->arResult["WEATHER"] = $weather_now_date;
                // write everything to a file txt
                file_put_contents(dirname(__FILE__)."/weather_parser.txt", serialize($weather_now_date));
                $this->arResult['WEATHER_URL_CACHE'] = true;
            }else{
                // we deliver from a file
                $this->arResult["WEATHER"] = unserialize(file_get_contents(dirname(__FILE__)."/weather_parser.txt"));
                $this->arResult['WEATHER_URL_CACHE'] = false;
            }
            // If parsing is successful then we cache the data
            if($this->arResult['WEATHER_URL_CACHE']){
                $this->SetResultCacheKeys([
                    "WEATHER",
                ]);
            }else{
                // data is not cached
                $this->AbortResultCache();
            }
            $this->includeComponentTemplate();
        }
    }
}