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
