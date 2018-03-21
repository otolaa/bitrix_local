<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? //p($arResult,"p"); ?>
<? if(count($arResult['CBR']['CUR'])):?>
<div class="cur_block" id='cur_currency_some'>
    <table class="table table-striped"><tbody>
	 <? 
	 foreach($arResult['CBR']['CUR'] as $v):
	 ?>
            <tr>
                <td>
                    <div class="cur_val_img"><?=$v['NAME']?></div>
                </td>
                <td><?=$v['VAL']?></td>
                <?/*<td><?=$v['NOMINAL']?></td>*/?>
            </tr>
	<? endforeach?>
     </tbody></table>
    <div class="cur_on_date"><?=GetMessage('DATE')?> <?=$arResult['CBR']['DATE']?></div>
</div>
<? endif ?>