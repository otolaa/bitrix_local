<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!\Bitrix\Main\Loader::includeModule('iblock'))
return;

Loc::loadMessages(__FILE__);

class WeatherParserClassThemes extends \CBitrixComponent
{
    // откуда парсим
    private $URL_PARSER_ = "https://yandex.ru/pogoda/kaliningrad/details";
    // private $XML_PATH_ = $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/lioden/weather.parser/parser_weather.xml";

    public function acsWeatherParserNew($PP = Null){
        $PP = ($PP?$PP:$this->$URL_PARSER_);
        $arResult = array();
        require_once(dirname(__FILE__) . '/phpQuery/phpQuery.php');
        $PARAM_PARSER = file_get_contents($PP);
        $doc = phpQuery::newDocument($PARAM_PARSER);

        $arResult["HEADER"] = $doc->find('h1.title_level_1')->text();
        $arResult["CURRENT_WEATHER"] = $doc->find('h2.title_level_2')->text();

        $weather_body = $doc->find('div.forecast-details');
        $details__day = pq($weather_body)->find('dt.forecast-details__day');
        $details__day_info = pq($weather_body)->find('dd.forecast-details__day-info');

        $arResult['WEEK10'] = array();
        foreach($details__day as $i=>$el){
            $q = pq($el);
            $DAY_NUM = trim($q->find('strong.forecast-details__day-number')->text());
            $DAY_OF_WEEK = $q->find('span.forecast-details__day-month')->text() . ", " . $q->find('span.forecast-details__day-name')->text();
            if(strlen($DAY_NUM)>0 && strlen($DAY_OF_WEEK)>0) {
                $arResult['WEEK10']['DAY'][] = array(
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
                $arResult['WEEK10']['HEADER'][] = $HEADER_;
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
                $arResult['WEEK10']['DATA'][] = $dops;
            }
        }

        // FORECAST_BRIEF
        foreach($arResult['WEEK10']['DATA'] as $d_=>$dt){
            $arResult['FORECAST_BRIEF'][$d_]['DAY'] =  $arResult['WEEK10']['DAY'][$d_];
            $arResult['FORECAST_BRIEF'][$d_]['HEADER'] =  $arResult['WEEK10']['HEADER'][$d_];
            $arResult['FORECAST_BRIEF'][$d_]['DATA'] = $dt;
        }

        unset($arResult['WEEK10']);

        return $arResult;
    }

    //
    public function acsWeatherParser($PP = Null){
        //
        $PP = ($PP?$PP:$this->$URL_PARSER_);
        $arResult = array();
        require_once(dirname(__FILE__) . '/phpQuery/phpQuery.php');
        $PARAM_PARSER = file_get_contents($PP);
        $doc = phpQuery::newDocument($PARAM_PARSER);

        $hentry = $doc->find('h1.title_level_1')->text();
        $current_weather = $doc->find('div.current-weather')->html();
        //$forecast_brief = $doc->find('ul.forecast-brief')->parent("div.tabs-panes__pane")->html();
        $forecast_brief = $doc->find('dl.forecast-detailed')->parent("div.tabs-panes__pane")->html();  //  i-bem forecast-detailed_js_inited

        $arResult["HEADER"] = $hentry;
        $arResult["CURRENT_WEATHER"] = $current_weather;
        //$arResult["FORECAST_BRIEF"] = $forecast_brief;


        //несколько дней погоды
        $week10d = $doc->find('dl.forecast-detailed dt');
        $week10v = $doc->find('dl.forecast-detailed dd');
        //PR($week10);

        $arResult['WEEK10'] = array();
        foreach ($week10d as $i=>$el) {
            $q = pq($el);
            $arResult['WEEK10'][$i] = array(
                'DAY_OF_WEEK' => $q->find('.forecast-detailed__weekday')->text(),
                'DAY_NUM' => IntVal($q->find('.forecast-detailed__day-number')->text()), //$q->attr('data-anchor'),
                'DAY_MONTH'=> $q->find('.forecast-detailed__day-month')->text(),

            );
            $arResult['WEEK10'][$i]['IS_TODAY'] =  ( date('j') == $arResult['WEEK10'][$i]['DAY_NUM'] );
        }

        foreach ($week10v as $i=>$el) {
            $rows = pq($el)->find('.weather-table__body tr');
            $dops = array();
            foreach ($rows as $r) {
                $q = pq($r);
                // p($q->find('.weather-table__body-cell_type_feels-like > div.weather-table__temp')->text(),'p');
                $dops[] = array(
                    'PART' =>  $q->find('.weather-table__daypart')->text(),
                    'TEMP' =>  $q->find('.weather-table__body-cell_type_daypart > div.weather-table__temp')->text(),
                    'ICON' => $q->find('.weather-table__body-cell_type_icon')->html(), // .weather-table__value i')->class()
                    'COND' =>  $q->find('.weather-table__body-cell_type_condition')->text(),
                    'AIR_PRES' =>  $q->find('.weather-table__body-cell_type_air-pressure')->text(),
                    'AIR_VODA' =>  $q->find('.weather-table__body-cell_type_humidity')->text(),
                    'WIND_SPD' =>  $q->find('.weather-table__body-cell_type_wind span.wind-speed')->text(),
                    'WIND_DIR' =>  $q->find('.weather-table__body-cell_type_wind .icon-abbr')->text(),
                    'TEMP_LIKE' => $q->find('.weather-table__body-cell_type_feels-like > div.weather-table__temp')->text(),
                );
            }
            $arResult['WEEK10'][$i]['DATA'] = $dops;
        }

        //
        $arResult["FORECAST_BRIEF"] = $arResult['WEEK10'];


        // в массив для мелкого виджета и т.д.
        $res_ = array();
        $current_weather__col = $doc->find('div.current-weather span.current-weather__col');
        foreach ($current_weather__col as $k => $col) {
            $pq = pq($col); // Это аналог $ в jQuery
            $res[] = $pq->html();

            $tags = $pq->find('i, span, div');
            foreach ($tags as $t => $tg) {
                $pq_tg = pq($tg);
                $pq_tg->after(" | ");
                //
            }
            //
            $ContactArrayList = explode(" | ", $pq->html());
            $ContactArrayList = array_filter($ContactArrayList, 'strlen');
            $ctArr = array();
            foreach ($ContactArrayList as $kp=>$ct) {
                $item = "ITEMS_".$kp;
                $ctArr[$item] = $ct;
            }

            $itemW = "WEATER_".$k;
            $res_[$itemW] = $ctArr; //$pq->html();
        }

        if (count($res_) > 0) {
            $arResult["ITEMS_RES"] = $res_;
        }
        return $arResult;
    }

    // рекурсивная функция формирования и записи parser_weather.xml
    public function array_to_xml($array, &$xml_user_info) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_user_info->addChild("$key");
                    $this->array_to_xml($value, $subnode);
                }else{
                    $subnode = $xml_user_info->addChild("item$key");
                    $this->array_to_xml($value, $subnode);
                }
            }else {
                $xml_user_info->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }

    //
    public function XML2Array(SimpleXMLElement $parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];

            $node = $element->count() ? $this->XML2Array($element) : trim($element);
        }

        return $array;
    }

    //
}