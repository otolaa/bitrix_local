<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/* initial parameters that specify the parameters of the current city  */
$CITY_ID = [
    'Moscow'=>'524894',
    'Saint Petersburg'=>'536203',
    'Yekaterinburg'=>'1486209',
    'Novosibirsk'=>'1496747',
    'Kaliningrad'=>'554234',
];

$arComponentParameters = array(
    "PARAMETERS" => array(
        "CITY_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("CITY_ID"),
            "TYPE" => "LIST",
            "VALUES" => array_flip($CITY_ID),
            "MULTIPLE" => 'N'
        ),
        "KEY" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("KEY"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>3600),
    ),
);
