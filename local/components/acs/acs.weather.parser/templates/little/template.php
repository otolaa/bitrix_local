<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? // p($arParams,"p"); ?>
<? // p($arResult,"p"); ?>

<? if(count($arResult["props"])>0 && $arResult["fact_basic"]){ ?>
    <div class="current-weather-little">
        <ul>
            <li><?=strip_tags($arResult["fact_basic"],'<i>,<div>,<time>')?> <small><?=$arResult['fact_condition']?></small></li>
            <li><small><?=$arResult['feels_like']['label']?></small> <div><?=$arResult['feels_like']['value']?></div></li>
            <li><small><?=$arResult['yesterday']['label']?></small> <div><?=$arResult['yesterday']['value']?></div></li>
            <? if($arResult['props']){ ?>
                <? foreach($arResult['props'] as $props){ ?>
                <li><small><?=$props['label']?></small> <div><?=$props['value']?></div></li>
            <? } } ?>
        </ul>
        <div class="prognoz"><a href="<?=$arParams['URL_LIST']?>">ПОДРОБНЫЙ ПРОГНОЗ</a></div>
    </div>
<? } ?>