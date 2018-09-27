<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//
global $APPLICATION;
if($arResult['KINO']['CITY']):
    $APPLICATION->SetTitle($arResult['KINO']['CITY']);
endif;