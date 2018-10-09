<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// the minimum pattern displays only the weather on the first day of 10 days
$this->setFrameMode(true); ?>

<? /**/ ?>
<? if(count($arResult['WEATHER']) && count($arResult['WEATHER']['WEEK_TABLE'][0])):?>
    <h4><?=$arResult['WEATHER']['HEADER_CURRENT']?></h4>
    <table class="table table-striped weather-controller-modules-table">
        <tr><td colspan="3"><?=$arResult['WEATHER']['WEEK_TABLE'][0]['DAY']?></td></tr>
    <? foreach ($arResult['WEATHER']['WEEK_TABLE'][0]['ITEMS'] as $DT): ?>
        <tr>
            <td><?=implode("<br>", $DT[0])?></td>
            <td><i class="<?=$DT[1]?>"></i></td>
            <td><?=$DT[2]?></td>
        </tr>
    <? endforeach; ?>
    </table>
    <? if($arParams['OLL_PAGE']): ?><div class="text-center"><a href="<?=$arParams['OLL_PAGE']?>"><?=$arResult['WEATHER']['HEADER']?></a></div><? endif; ?>
<? endif; ?>