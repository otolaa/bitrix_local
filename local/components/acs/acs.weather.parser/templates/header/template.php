<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//

/*if(count($arResult['header'])>0){
    $k = 0;
    foreach ($arResult['header'] as $hw) {
        $k++;
        if($k!=2) continue;
    ?>
    <div class="weather w<?=$arResult['weather']['icon']?>">
        <span class="weatherName"><a href="<?=$arParams["URL_LIST"]?>" title="ПОДРОБНЫЙ ПРОГНОЗ"><?=$hw['name']?></a></span>
        <span class="weatherIco"><?=$hw['image']?></span>
        <span class="degree"><?=$hw['temperature']?></span>
        <?=$hw['type']?>
    </div>

<? } }*/ ?>

<? //p($arResult["ITEMS_RES"],"p"); ?>

<? if(count($arResult["ITEMS_RES"])>0){
    $i = 0;
    foreach ($arResult["ITEMS_RES"] as $ITEMS_RES) {
    if($i>0) continue;
    $i++;
    //p($ITEMS_RES,"p");
    $irArr = array();
    foreach($ITEMS_RES as $ir){
        $irArr[] = $ir;
    }
    //p($irArr,"p");
    ?>
    <div class="weather w">
        <? print $irArr[0]; ?>
        <span class="degree"><?=strip_tags($irArr[2])?></span>
        <a href="<?=$arParams["URL_LIST"]?>" title="ПОДРОБНЫЙ ПРОГНОЗ"><?=strip_tags($irArr[1])?></a>
    <?

    //p($arResult["ITEMS_RES"][0],"p");
    ?>
    </div>
<? } } ?>