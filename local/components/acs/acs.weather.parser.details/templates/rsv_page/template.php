<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
//PR( $arResult );
//p(count($arResult['FORECAST_BRIEF']),'p');
//p($arResult['FORECAST_BRIEF'],'p');
?>
    <h1><?=$arResult['CURRENT_WEATHER']?> <small><?=$arResult['HEADER']?></small></h1>
<?

if(count($arResult['FORECAST_BRIEF'])>0) {
     foreach ($arResult['FORECAST_BRIEF'] as $d=>$day): ?>
        <? //p($day['HEADER'],'p'); ?>
        <? if(strlen(trim($day['DAY']['DAY_NUM']))<=0) continue; ?>
        <table class="weather table table-striped">
            <tr>
                <th class="daytime success">
                    <span class="day"><?=$day['DAY']['DAY_NUM'].' '.$day['DAY']['DAY_OF_WEEK'];?></span>
                </th>
                <th class="daytime success"></th>
                <th class="daytime success"></th>
                <? foreach($day['HEADER'] as $hea){ ?>
                    <th class="daytime success"><?=$hea?></th>
                <? } ?>
            </tr>
            <? foreach ($day['DATA'] as $dpart): ?>
                <tr>
                    <? foreach($dpart as $dps_){ ?>
                        <td><?=$dps_;?></td>
                    <? } ?>
                </tr>
            <? endforeach; ?>
        </table>
    <? endforeach;

} ?>