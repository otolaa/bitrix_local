<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? /**/ ?>
<? if(count($arResult['WEATHER']) && count($arResult['WEATHER']['FORECAST_BRIEF'][0])):?>
    <h4><?=$arResult['WEATHER']['CURRENT_WEATHER']?></h4>
    <table class="table table-striped weather-controller-modules-table">
        <tr><td colspan="3"><?=implode(" ",$arResult['WEATHER']['FORECAST_BRIEF'][0]['DAY'])?></td></tr>
    <? foreach ($arResult['WEATHER']['FORECAST_BRIEF'][0]['DATA'] as $DT): ?>
        <tr>
            <td><?=$DT['0']?></td>
            <td><?=$DT['1']?></td>
            <td><?=$DT['2']?></td>
        </tr>
    <? endforeach; ?>
    </table>
    <? if($arParams['OLL_PAGE']): ?><div class="text-center"><a href="<?=$arParams['OLL_PAGE']?>"><?=$arResult['WEATHER']['HEADER']?></a></div><? endif; ?>
<? endif; ?>