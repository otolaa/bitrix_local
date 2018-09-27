<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// расписание фильмов
$this->setFrameMode(true); ?>

<? if(!empty($arResult['KINO']) && !empty($arResult['KINO']['SCHEDULE'])): ?>
    <table class="table table-striped kino-component-table">
        <tbody>
            <? foreach ($arResult['KINO']['SCHEDULE'] as $FILM): ?>
            <tr><td colspan="3"><?=$FILM['DATE']?></td></tr>
            <? foreach ($FILM['FILM'] as $item): ?>
                <tr>
                    <td><span class="film"><?=$item['TITLE']?></span></td>
                    <td><span class="age"><?=$item['AGE']?$item['AGE']."+":""?></span></td>
                    <td><small><?=implode("<br>",$item['DESCRIPTION'])?></small></td>
                </tr>
                <? if(!empty($item['CINEMA'])): foreach ($item['CINEMA'] as $CINEMA): ?>
                    <? foreach ($CINEMA['TIME'] as $k=>$time): ?>
                    <tr>
                        <td><?=($k==0?'<span class="cinema">'.$CINEMA['TITLE'].'</span>':"")?></td>
                        <td><?=($CINEMA['HALL'][$k]?'<span class="hall">'.$CINEMA['HALL'][$k].'</span>':"")?></td>
                        <td><?=$time?></td>
                    </tr>
                    <? endforeach; ?>
                <? endforeach; endif; ?>
            <? endforeach; ?>
            <? endforeach; ?>
        </tbody>
    </table>
<? endif; ?>