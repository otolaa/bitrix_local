<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

class weatherAPI extends \CBitrixComponent
{
    private $API_URL = "https://api.openweathermap.org/data/2.5/weather";

    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => isset($arParams["CACHE_TYPE"])?$arParams["CACHE_TYPE"]:"A",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"])?$arParams["CACHE_TIME"]:3600*2, // 2 hour
            "CACHE_GROUPS" => isset($arParams["CACHE_GROUPS"])?$arParams["CACHE_GROUPS"]:"N",
            "CITY_ID" => isset($arParams["CITY_ID"])?$arParams["CITY_ID"]:524894,
            "KEY" => isset($arParams["KEY"])?$arParams["KEY"]:"",
        ];
        return $result;
    }

    public function sendToAPI($url_api_method = '', $params = '', $method = 'GET')
    {
        $headers = ["Accept: application/json", "Cache-Control: no-cache", "Content-Type: application/x-www-form-urlencoded"];
        $get_params = '';
        if ($method == 'GET' && strlen($params)) $get_params = '?'.$params;
        $ch = curl_init($this->API_URL.$url_api_method.$get_params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($params) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($response, true);

        if($code!=200 && $code!=204 && $code!=201) {
            return false;
        } else {
            return $response;
        }
    }

    public function getEmoji($s)
    {
        $emoji = [
                "Clear"=> "Ясно &#9728;",
                "Clouds"=> "Облачно &#9729;",
                "Rain"=> "Дождь &#9748;",
                "Drizzle"=> "Дождь &#9748;",
                "Thunderstorm"=> "Гроза &#9889;",
                "Snow"=> "Снег &#127784;",
                "Mist"=> "Туман &#127787;"
        ];

        return ($emoji[$s]?$emoji[$s]:'Посмотри в окно, не пойму что там за погода!');
    }

    public function getPrint($r)
    {
        if ($r && is_array($r)) {

            return Loc::getMessage('GET_PRINT_WEATHER', [
                '#_date_#'=>date('d.m.Y H:i'),
                '#city_w#'=>$r['name'],
                '#temp_w#'=>$r['main']['temp'],
                '#wd#'=>$this->getEmoji($r["weather"][0]["main"]),
                '#humidity_w#'=>$r["main"]["humidity"],
                '#pressure_w#'=>$r['main']['pressure'],
                '#wind_w#'=>$r['wind']['speed'],
                '#sunrise_time#'=>date('d.m.Y H:i', $r['sys']['sunrise']),
                '#sunset_time#'=>date('d.m.Y H:i', $r['sys']['sunset']),
            ]);

        } else return false;
    }

    public function executeComponent()
    {
        global $USER;
        if ($this->StartResultCache(false, [($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $this->arParams]))
        {
            // "https://api.openweathermap.org/data/2.5/weather?id={id}&appid={key}&units=metric&lang=ru"
            $params = 'id='.$this->arParams["CITY_ID"].'&appid='.$this->arParams["KEY"].'&units=metric&lang=ru';
            $weather_now_date = $this->sendToAPI('', $params);
            if ($weather_now_date) {
                $this->arResult["WEATHER"] = $weather_now_date;
                $this->arResult["WEATHER_PRINT"] = $this->getPrint($weather_now_date);
                // write everything to a file txt
                // file_put_contents(dirname(__FILE__)."/weather_parser.txt", serialize($weather_now_date));
                // $this->arResult['WEATHER_URL_CACHE'] = true;
            } else {
                // we deliver from a file
                $this->arResult["WEATHER"] = []; // unserialize(file_get_contents(dirname(__FILE__)."/weather_parser.txt"));
                $this->arResult["WEATHER_PRINT"] = '';
                $this->arResult['WEATHER_URL_CACHE'] = false;
            }

            // If parsing is successful then we cache the data
            if ($this->arResult['WEATHER_URL_CACHE']) {
                $this->SetResultCacheKeys([
                    "WEATHER",
                    "WEATHER_PRINT",
                ]);
            } else {
                // data is not cached
                $this->AbortResultCache();
            }

            $this->includeComponentTemplate();
        }
    }
}