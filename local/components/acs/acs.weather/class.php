<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

class weatherAPI extends \CBitrixComponent
{
    //
    private $URL_PARSER_PAGE = "https://yandex.ru/pogoda/kaliningrad/details";
    private $URL_PARSER_ARR = [
            'moscow'=>'https://yandex.ru/pogoda/moscow/details',
            'petersburg'=>'https://yandex.ru/pogoda/saint-petersburg/details',
            'yekaterinburg'=>'https://yandex.ru/pogoda/yekaterinburg/details',
            'novosibirsk'=>'https://yandex.ru/pogoda/novosibirsk/details',
            'kaliningrad'=>'https://yandex.ru/pogoda/kaliningrad/details',
            'krasnoyarsk'=>'https://yandex.ru/pogoda/krasnoyarsk/details',
            'kazan'=>'https://yandex.ru/pogoda/kazan/details',
            'ufa'=>'https://yandex.ru/pogoda/ufa/details',
            'chelyabinsk'=>'https://yandex.ru/pogoda/chelyabinsk/details',
        ];

    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => isset($arParams["CACHE_TYPE"])?$arParams["CACHE_TYPE"]:"A",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"])?$arParams["CACHE_TIME"]:3600*6, // six hour
            "CACHE_GROUPS" => isset($arParams["CACHE_GROUPS"])?$arParams["CACHE_GROUPS"]:"N",
            "URL_PARSER_PAGE" => isset($arParams["URL_PARSER_PAGE"])?$arParams["URL_PARSER_PAGE"]:$this->URL_PARSER_PAGE,
            "OLL_PAGE" => isset($arParams["OLL_PAGE"])?$arParams["OLL_PAGE"]:'/weather',
        ];
        return $result;
    }

    public function acsWeatherParser()
    {
        $weatherResult = NULL;
        if (!class_exists("phpQuery")) {
            require_once(dirname(__FILE__) . '/phpQuery/phpQuery.php');
        }
        $PARAM_PARSER = file_get_contents($this->URL_PARSER_PAGE);
        if($PARAM_PARSER ===  FALSE){
            return FALSE;
        }
        $doc = \phpQuery::newDocument($PARAM_PARSER);
        $weatherResult["HEADER"] = $doc->find('h1.title_level_1')->text();
        $weatherResult["CURRENT_WEATHER"] = $doc->find('h2.title_level_2')->text();

        $weather_body = $doc->find('div.forecast-details');
        $details__day = pq($weather_body)->find('dt.forecast-details__day');
        $details__day_info = pq($weather_body)->find('dd.forecast-details__day-info');

        $weatherResult['WEEK10'] = array();
        foreach($details__day as $i=>$el){
            $q = pq($el);
            $DAY_NUM = trim($q->find('strong.forecast-details__day-number')->text());
            $DAY_OF_WEEK = $q->find('span.forecast-details__day-month')->text() . ", " . $q->find('span.forecast-details__day-name')->text();
            if(strlen($DAY_NUM)>0 && strlen($DAY_OF_WEEK)>0) {
                $weatherResult['WEEK10']['DAY'][] = array(
                    "DAY_NUM" => $DAY_NUM,
                    "DAY_OF_WEEK" => $DAY_OF_WEEK,
                );
            }
        }

        foreach($details__day_info as $a=>$el){
            $q = pq($el);
            $weather_table_head_ = $q->find('thead.weather-table__head th.weather-table__head-cell');
            $HEADER_ = array();
            foreach ($weather_table_head_ as $wea) {
                $weaHtml = trim(pq($wea)->html());
                if (strlen($weaHtml) > 0) {
                    $HEADER_[] = $weaHtml;
                }
            }
            if(count($HEADER_)) {
                $weatherResult['WEEK10']['HEADER'][] = $HEADER_;
            }

            //
            $dops = array();
            $weather_table_row_ = $q->find('tbody.weather-table__body tr.weather-table__row');
            if(count($weather_table_row_)) {
                foreach ($weather_table_row_ as $d=>$row) {
                    $rowHtml = pq($row)->find('td.weather-table__body-cell');
                    foreach($rowHtml as $ds=>$rh){
                        $dops[$d][$ds] = pq($rh)->html();
                    }
                }
            }
            if(count($dops)) {
                $weatherResult['WEEK10']['DATA'][] = $dops;
            }
        }

        // FORECAST_BRIEF
        foreach($weatherResult['WEEK10']['DATA'] as $d_=>$dt){
            $weatherResult['FORECAST_BRIEF'][$d_]['DAY'] =  $weatherResult['WEEK10']['DAY'][$d_];
            $weatherResult['FORECAST_BRIEF'][$d_]['HEADER'] =  $weatherResult['WEEK10']['HEADER'][$d_];
            $weatherResult['FORECAST_BRIEF'][$d_]['DATA'] = $dt;
        }

        unset($weatherResult['WEEK10']);
        //
        return $weatherResult;
    }

    public function executeComponent()
    {
        global $USER;
        if ($this->StartResultCache(false, array(($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $this->arParams, date("d/m/Y")), 'weather_parser')){
            //
            $weather_now_date = $this->acsWeatherParser();
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