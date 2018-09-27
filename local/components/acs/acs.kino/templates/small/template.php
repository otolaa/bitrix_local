<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// минимальный шаблон который выводит просто список фильмов на текущию дату в данном городе, без полного расписания
$this->setFrameMode(true); ?>

<? if(!empty($arResult['KINO']) && !empty($arResult['KINO']['SCHEDULE'])): ?>
    <h3><?=$arResult['KINO']['CITY']?></h3>
    <? if(!empty($FILM = $arResult['KINO']['SCHEDULE'][0])): ?>
        <? //p($FILM,'p'); ?>
        <table class="table table-striped kino-component-table">
            <tbody>
                <tr><td colspan="4"><?=$FILM['DATE']?></td></tr>
                <? foreach ($FILM['FILM'] as $item): ?>
                <tr>
                    <td><?=$item['TITLE']?></td>
                    <td><?=$item['AGE']?$item['AGE']."+":""?></td>
                    <td><?=substr($item['DESCRIPTION'][0],0,-1)?></td>
                    <td><?=$item['DESCRIPTION'][count($item['DESCRIPTION'])-1]?></td>
                </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <div class="text-center"><a href="<?=$arParams['OLL_PAGE']?>">Все расписание</a></div>
    <? endif; ?>
<? endif; ?>