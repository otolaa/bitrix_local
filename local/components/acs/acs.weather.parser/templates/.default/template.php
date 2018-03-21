<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? //p($arParams,"p"); ?>
<? //p($arResult,"p"); ?>

<? if(count($arResult)>0):?>
   <h2><? print $arResult['HEADER']; ?></h2>

   <div class="current-weather"><? print $arResult['CURRENT_WEATHER']; ?></div>

   <ul class="forecast-brief forecast-brief_cols_10 cool_class"><? print $arResult['FORECAST_BRIEF']; ?></ul>
<? endif ?>
