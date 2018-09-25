<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "PRESET" => array(
            "PARENT" => "BASE",
            "NAME" => "preset",
            "TYPE" => "STRING",
            "DEFAULT" => "islands#dotIcon",
        ),
        "ICON_COLOR" => array(
            "PARENT" => "BASE",
            "NAME" => "iconColor",
            "TYPE" => "STRING",
            "DEFAULT" => "#64be23",
        ),
        "HEIGHT" => array(
            "PARENT" => "BASE",
            "NAME" => "HEIGHT",
            "TYPE" => "STRING",
            "DEFAULT" => "350",
        ),
        "CLUSTERER" => array(
            "PARENT" => "BASE",
            "NAME" => "CLUSTERER",
            "TYPE" => "STRING",
            "DEFAULT" => "islands#invertedDarkGreenClusterIcons",
        ),
    ),
);
