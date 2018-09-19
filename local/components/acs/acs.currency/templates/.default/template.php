<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? if(count($arResult['CBR'])):
    //
    $CBR = $arResult['CBR'];
    $fruit = array_shift($CBR);
    $second = array_shift($CBR);
    //
    $curArr = [];
    if(count($fruit['ITEMS'])):
    foreach ($fruit['ITEMS'] as $k=>&$cur){
        if(!in_array($cur[1],$arParams['CURR']))continue;
        //
        $cur[4] = (float)str_replace(",", ".", $cur[4]);
        $cur[] = round($cur[4] - (float)str_replace(",", ".", $second['ITEMS'][$k][4]),4);
        $curArr[] = $cur;
    }
    endif;
    //
    if(count($curArr)): ?>
    <div class="cur_block" id='cur_currency_some'>
        <table class="table table-striped"><tbody>
            <? foreach($curArr as $v): ?>
                <tr>
                    <td><div class="cur_val_img"><?=$v['1']." / ".$v['3']?></div></td>
                    <td><?=$v['4']?> <?=$v['5']>0?"&#8593;":"&#8595;"?></td>
                    <td><?=$v['5']>0?"+":""?><?=$v['5']?></td>
                </tr>
            <? endforeach?>
            </tbody></table>
        <div class="cur_on_date"><?=GetMessage('DATE')?> <?=$fruit['DATE']?></div>
    </div>
    <? endif; ?>
<? endif; ?>