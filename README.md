# I ❤ Bootstrap 4.6
### Theme Template ❤ Bootstrap for Bitrix
```php
/index_bk.php
/index_bk_right.php
/index_bk_top.php
/index_bk_kino.php
/local/templates/bk/*
```
![index_bk](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/bk.png "index_bk.php")
# /local/components/acs/
## 1. acs.currency
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
## 2. acs.weather
this is the api.openweathermap.org
```php 
$APPLICATION->IncludeComponent("acs:acs.weather", ".default",
    array(
        "KEY" => "", // key from is openweathermap.org
        "CITY_ID" => "536203",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600"
    ),
    false
);
```
![acs.weather](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/weather.png "this is the api.openweathermap.org")
## 3. acs.map
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

## 4. acs.kino
this is the acs.kino parsing kinopoisk.ru/afisha/city/490/ the /index_bk_kino.php
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

## 5. /local/modules/acs/
this is small module for message in user
```php
\Bitrix\Main\Config\Option::get("acs", "SITE_COOKIE", '');
\Bitrix\Main\Config\Option::get("acs", "OPENWEATHERMAP_KEY", ''), // key from is openweathermap.org
```
![message in user](https://github.com/otolaa/bitrix_local/blob/master/local/templates/bk/img/hm.png "message in user")