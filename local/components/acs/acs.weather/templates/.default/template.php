<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$this->setFrameMode(true); ?>

<? if ($arResult['WEATHER_PRINT'] && count($arResult['WEATHER'])) : ?>
    <? echo $arResult['WEATHER_PRINT']; ?>
<? endif; ?>