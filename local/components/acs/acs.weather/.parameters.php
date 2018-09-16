<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/* тут необходимо первоначальные параметры, задающие параметры текущего города */
$URL_PARSER_ARR = [
    'moscow'=>'https://yandex.ru/pogoda/moscow/details',
    'petersburg'=>'https://yandex.ru/pogoda/saint-petersburg/details',
    'yekaterinburg'=>'https://yandex.ru/pogoda/yekaterinburg/details',
    'novosibirsk'=>'https://yandex.ru/pogoda/novosibirsk/details',
    'kaliningrad'=>'https://yandex.ru/pogoda/kaliningrad/details',
    'krasnoyarsk'=>'https://yandex.ru/pogoda/krasnoyarsk/details',
    'kazan'=>'https://yandex.ru/pogoda/kazan/details',
    'ufa'=>'https://yandex.ru/pogoda/ufa/details',
    'chelyabinsk'=>'https://yandex.ru/pogoda/chelyabinsk/details',
    'samara'=>'https://yandex.ru/pogoda/samara/details',
    'omsk'=>'https://yandex.ru/pogoda/omsk/details',
    'rostov-na-donu'=>'https://yandex.ru/pogoda/rostov-na-donu/details',
];

$arComponentParameters = array(
    "PARAMETERS" => array(
        "URL_PARSER_PAGE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("URL_PARSER_PAGE"),
            "TYPE" => "LIST",
            "VALUES" => array_flip($URL_PARSER_ARR),
            "MULTIPLE" => 'N'
        ),
        "OLL_PAGE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("OLL_PAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => "/weather/",
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>3600),
    ),
);
