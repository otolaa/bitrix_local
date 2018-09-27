<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

//
$URL_PARSER_ARR = [
    'Москва'=>'https://www.kinopoisk.ru/afisha/city/1/',
    'Санкт-Петербург'=>'https://www.kinopoisk.ru/afisha/city/2/',
    'Абакан'=>'https://www.kinopoisk.ru/afisha/city/5061/',
    'Калининград'=>'https://www.kinopoisk.ru/afisha/city/490/',
];

$arComponentParameters = array(
    "PARAMETERS" => array(
        "URL_CITY_PAGE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("URL_CITY_PAGE"),
            "TYPE" => "LIST",
            "VALUES" => array_flip($URL_PARSER_ARR),
            "MULTIPLE" => 'N'
        ),
        "OLL_PAGE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("OLL_PAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => "/kino/",
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>3600),
    ),
);
