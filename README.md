# /local/components/acs/
# 1. acs.currency
this is the currency module which parses xml link CBR.RU
```php 
$APPLICATION->IncludeComponent("acs:acs.currency", ".default",
	[
		"CURR" => [
			0 => "USD",
			1 => "EUR",
			2 => "PLN",
		],
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
	],
	false
); 
```
![acs.currency](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/currency.png "this is the currency module which parses xml link CBR.RU")
# 2. acs.weather
this is the parsing yandex.ru/pogoda
```php 
$APPLICATION->IncludeComponent("acs:acs.weather", ".default",
	array(
		"OLL_PAGE" => "/weather/",
		"URL_PARSER_PAGE" => "https://yandex.ru/pogoda/kaliningrad/details",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
	false
);
```
![acs.weather](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/weather.png "this is the parsing yandex.ru/pogoda")
Forecast for 10 days  /weather/
```php 
$APPLICATION->IncludeComponent("acs:acs.weather", "weather",
	array(
		"OLL_PAGE" => "/weather/",
		"URL_PARSER_PAGE" => "https://yandex.ru/pogoda/kaliningrad/details",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
	false
);
```
![acs.weather](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/weather10day.png "Forecast for 10 days  /weather/")
# 3. acs.map
this is the Yandex Map include component region
```php
$APPLICATION->IncludeComponent("acs:acs.map", ".default",
    [
        "ITEMS" => [
            [ 'COORDINATES'=>'55.762996,37.432978',
                'title'=>'КОНТАКТЫ В МОСКВЕ',
                'description'=>'г. Москва, Крылатская, 10. <br> По будням: с 07:30 до 21:00 <br> По выходным и праздникам: с 09:00 до 18:00'
            ],
            [ 'COORDINATES'=>'54.724271,20.467754',
                'title'=>'КОНТАКТЫ В КАЛИНИНГРАДЕ',
                'description'=>'г. Калининград, ул. Каменная 17-2<br> По будням: с 07:30 до 21:00 <br> По выходным и праздникам: с 09:00 до 18:00']
        ],
        "CACHE_TYPE"=>"A",
        "CACHE_TIME"=>3600,
        "DIV"=>"mapCamp",
        "PRESET"=>"islands#dotIcon", // style for icon in maps
        "ICON_COLOR"=>"#64be23", // color icon
        "HEIGHT"=>350, //px
        "CLUSTERER"=>'islands#invertedDarkGreenClusterIcons', //
    ],
    false
);
```
![acs.map](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/acs_map.jpg "acs.map")

# 4. acs.kino
this is the acs.kino parsing kinopoisk.ru/afisha/city/490/
```php
$APPLICATION->IncludeComponent("acs:acs.kino", ".default",
	array(
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => 3600*3, // three hour
		"URL_CITY_PAGE" => "https://www.kinopoisk.ru/afisha/city/490/",
		"OLL_PAGE" => "/kino/",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
```
![acs.kino](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/kino.jpg "acs.kino")