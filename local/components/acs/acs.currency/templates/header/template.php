<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? if(count($arResult['CBR'])):
    //
    $CBR = $arResult['CBR'];
    $fruit = array_shift($CBR);
    $second = array_shift($CBR);
    //
    $curArr = [];
    if(count($fruit['ITEMS'])):
        foreach ($fruit['ITEMS'] as $k=>$cur){
            if(!in_array($cur[1],['USD','EUR']))continue;
            // the difference of course in days, etc.
            $cur[] = $cur[4] - $second['ITEMS'][$k][4];
            $curArr[] = $cur;
        }
    endif;
    //
    if(count($curArr)): ?>
        <? foreach($curArr as $v): ?>
            <div class="curency"><strong><?=$v['1'].":"?></strong> <?=$v['4']?> <?=$v['5']>0?"&#8593;":"&#8595;"?></div>
        <? endforeach?>
        <div class="curency"><strong>НА:</strong> <?=$fruit['DATE']?></div>
    <? endif; ?>
<? endif; ?>
