<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? if(count($arResult['WEATHER']) && count($arResult['WEATHER']['FORECAST_BRIEF'])):?>
    <h4><?=$arResult['WEATHER']['CURRENT_WEATHER']?></h4>
    <? foreach ($arResult['WEATHER']['FORECAST_BRIEF'] as $FB): ?>
        <table class="table table-striped weather-controller-modules-table">
            <tr class="weather-controller-modules-table-header">
                <td colspan="3"><?=implode(" ",$FB['DAY'])?></td>
                <? foreach ($FB['HEADER'] as $header){ ?>
                    <td><?=$header?></td>
                <? } ?>
            </tr>
            <? foreach ($FB['DATA'] as $DT): ?>
                <tr>
                    <? foreach ($DT as $item){ ?>
                        <td><?=$item?></td>
                    <? } ?>
                </tr>
            <? endforeach; ?>
        </table>
    <? endforeach; ?>
<? endif; ?>