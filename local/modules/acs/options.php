<h1>Настройка модуля</h1>

<?
$module_id = "acs";
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");
$RIGHT = $APPLICATION->GetGroupRight($module_id);
if($RIGHT >= "R") :

//
$arAllOptions = Array(
    array("SITE_POLITICS", "Политика сайта", array("textarea",5,50), 'Этот сайт защищен reCAPTCHA и применяются <a href="https://policies.google.com/privacy" rel="nofollow">Политика конфиденциальности</a> и <a href="https://policies.google.com/terms" rel="nofollow">Условия обслуживания</a> Google.'),
    array("SITE_ERROR", "Сообщение об ошибке", array("textarea",2,50), 'Вопрос не отправлен, так как система определила Вас как робота. Задайте вопрос по телефону, указанному в контактах.'),
    array("SITE_COOKIE", "Сообщение про куки", array("textarea",2,50), 'Мы используем &#127850;cookie, чтобы сделать сайт максимально удобным для вас.'),
    array("ADD_LOG", "Записывать лог", array("checkbox",10), ""),
    array('PHP_CURLOPT_PROXY', 'CURL PROXY для API', array('text',50), ''),
    array("OPENWEATHERMAP_KEY", "Открытый ключ api.openweathermap.org", array("text",50), ""),
);

$aTabs = array(
    array("DIV" => "edit1", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "perfmon_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
    array("DIV" => "edit2", "TAB" => GetMessage("MAIN_TAB_RIGHTS"), "ICON" => "perfmon_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_RIGHTS")),
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);

CModule::IncludeModule($module_id);

if($_SERVER["REQUEST_METHOD"] == "POST" && strlen($Update.$Apply.$RestoreDefaults) > 0 && $RIGHT=="W" && check_bitrix_sessid())
{
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/perfmon/prolog.php");

    if(strlen($RestoreDefaults)>0)
        COption::RemoveOption("WE_ARE_CLOSED_TEXT_TITLE");
    else
    {
        foreach($arAllOptions as $arOption)
        {
            $name=$arOption[0];
            $val=$_REQUEST[$name];
            // @todo: проверка безопасности должна быть тут!
            COption::SetOptionString($module_id, $name, $val);
        }
    }

    $Update = $Update.$Apply;
    ob_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");
    ob_end_clean();

    LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($module_id)."&lang=".urlencode(LANGUAGE_ID)."&".$tabControl->ActiveTabParam());
} ?>

<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($module_id)?>&amp;lang=<?=LANGUAGE_ID?>">
    <?
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    foreach($arAllOptions as $f=>$arOption):
        $val = COption::GetOptionString($module_id, $arOption[0], $arOption[3]);
        $type = $arOption[2]; ?>
        <tr>
            <td width="40%" nowrap <?if($type[0]=="textarea") echo 'class="adm-detail-valign-top"'?>>
                <label for="<?echo htmlspecialcharsbx($arOption[0])?>"><?echo $arOption[1]?>:</label>
            <td width="60%">
                <?if($type[0]=="checkbox"):?>
                    <input type="checkbox" name="<?echo htmlspecialcharsbx($arOption[0])?>" id="<?echo htmlspecialcharsbx($arOption[0])?>" value="Y"<?if($val=="Y")echo" checked";?>>
                <?elseif($type[0]=="text"):?>
                    <input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($arOption[0])?>" id="<?echo htmlspecialcharsbx($arOption[0])?>"><?if($arOption[0] == "slow_sql_time") echo GetMessage("PERFMON_OPTIONS_SLOW_SQL_TIME_SEC")?>
                <?elseif($type[0]=="textarea"):?>
                    <textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialcharsbx($arOption[0])?>" id="<?echo htmlspecialcharsbx($arOption[0])?>"><?echo htmlspecialcharsbx($val)?></textarea>
                <?endif?>
            </td>
        </tr>
    <?endforeach?>
    <?$tabControl->BeginNextTab();?>
    <?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
    <?$tabControl->Buttons();?>
    <input <?if ($RIGHT<"W") echo "disabled" ?> type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>" class="adm-btn-save">
    <input <?if ($RIGHT<"W") echo "disabled" ?> type="submit" name="Apply" value="<?=GetMessage("MAIN_OPT_APPLY")?>" title="<?=GetMessage("MAIN_OPT_APPLY_TITLE")?>">
    <?if(strlen($_REQUEST["back_url_settings"])>0):?>
        <input <?if ($RIGHT<"W") echo "disabled" ?> type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?echo htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
        <input type="hidden" name="back_url_settings" value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>">
    <?endif?>
    <input type="submit" name="RestoreDefaults" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
    <?=bitrix_sessid_post();?>
    <?$tabControl->End();?>
</form>
<?endif;?>

<? // информационная подсказка, про статусы и т.д.
echo BeginNote();?>
Открытый ключ <a href="https://openweathermap.org/appid">api.openweathermap.org</a> получить можно тут.<br>
Настройки ключей и reCAPTCHA производится на сайте <a href="https://www.google.com/recaptcha/admin#v3signup" target="_blank">https://www.google.com/recaptcha/admin#v3signup</a>
<?echo EndNote();?>
