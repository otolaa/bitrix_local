<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? //p($arResult,"p"); ?>

<? if(count($arResult['CBR']['CUR'])):?>
<div class="curency"><strong>USD:</strong> <?=$arResult['CBR']['CUR']['USD']['VAL']?> <? /*<!--<span class="<?=$arResult['CBR']['CUR']['USD']['CHANGE']?>"><?=$arResult['CBR']['CUR']['USD']['CHANGE']=='down'?'-':($arResult['CBR']['CUR']['USD']['CHANGE']=='up'?'+':'')?> <?=$arResult['CBR']['CUR']['USD']['CHVAL']?><i></i></span>-->*/?></div>
<div class="curency"><strong>EUR:</strong> <?=$arResult['CBR']['CUR']['EUR']['VAL']?> <? /*<!--<span class="<?=$arResult['CBR']['CUR']['EUR']['CHANGE']?>"><?=$arResult['CBR']['CUR']['EUR']['CHANGE']=='down'?'-':($arResult['CBR']['CUR']['EUR']['CHANGE']=='up'?'+':'')?> <?=$arResult['CBR']['CUR']['EUR']['CHVAL']?><i></i></span>-->*/?></div>
<div class="curency"><strong>НА:</strong> <?=$arResult['CBR']['DATE']?></div>
<? endif?>