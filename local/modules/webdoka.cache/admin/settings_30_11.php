<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/prolog.php");
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/prolog_admin_after.php");
IncludeModuleLangFile(__FILE__);

/** @global CMain $APPLICATION */
global $APPLICATION;
/** @var CAdminMessage $message */

if($_POST['full_text_engine']) {
    COption::SetOptionString("devmodule", 'full_text_engine', $_POST['full_text_engine']);
}
if($_POST['full_text_engine']) {
    COption::SetOptionString("devmodule", 'clear_now', $_POST['clear_now']);
} else {
    COption::SetOptionString("devmodule", 'clear_now', 'N');
}
//echo COption::GetOptionString("devmodule","clear_now");
//echo COption::GetOptionString("devmodule","full_text_engine");
/*echo "<pre>";
print_r($_POST);*/




$bVarsFromForm = false;
$aTabs = array(
    array(
        "DIV" => "stemming",
        "TAB" => GetMessage("WD_SETTINGS"),
        "ICON" => "search_settings",
        "TITLE" => GetMessage("WD_HOW"),
        "OPTIONS" => Array(
            "full_text_engine" => Array(GetMessage("WD_PERIOD"), Array("select", array(
                "1" => GetMessage("WD_NIKOGDA"),
                "2" => GetMessage("WD_WEEK"),
                "3" => GetMessage("WD_MOUNTH"),
                "4" => GetMessage("WD_YEAR"),
                "5" => GetMessage("WD_DAY"),
            ))),
            "clear_now" => array(GetMessage("WD_NOW"), Array("checkbox", "N")),
        )
    ),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);

if($REQUEST_METHOD=="POST")
{
    if(COption::GetOptionString("devmodule","clear_now") == 'Y') {
        // ������� ��������
        //  echo "������� �������.";
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //    echo '������ �������� ��� ����������� Windows!';
            exec("rmdir /s /q ".$_SERVER['DOCUMENT_ROOT']."/bitrix/cache/");
            exec("rmdir /s /q ".$_SERVER['DOCUMENT_ROOT']."/bitrix/managed_cache/");
            exec("rmdir /s /q ".$_SERVER['DOCUMENT_ROOT']."/bitrix/stack_cache/");


        } else {
            exec("rm -rf ".$_SERVER['DOCUMENT_ROOT']."/bitrix/cache/");
            exec("rm -rf ".$_SERVER['DOCUMENT_ROOT']."/bitrix/managed_cache/");
            exec("rm -rf ".$_SERVER['DOCUMENT_ROOT']."/bitrix/stack_cache/");
        }

    }



    if(COption::GetOptionString("devmodule","full_text_engine")) {
        // ������� ��������� ������
        //  echo "����� ����������";
        $res = CAgent::GetList(Array("ID" => "DESC"), array("NAME" => "CDevmoduleStatistic::CleanUpAgent2();"));
        while($res->NavNext(true, "agent_")):
            $agent_ID;
        endwhile;
        $time = 20;
        if(COption::GetOptionString("devmodule","full_text_engine")== '1') {
            $time = '';
        }
        if(COption::GetOptionString("devmodule","full_text_engine")== '2') {
            $time = 604800;
        }
        if(COption::GetOptionString("devmodule","full_text_engine")== '3') {
            $time = 2592000;
        }
        if(COption::GetOptionString("devmodule","full_text_engine")== '4') {
            $time = 31536000;
        }
        if(COption::GetOptionString("devmodule","full_text_engine")== '5') {
            $time = 86400;
        }

        if (CAgent::Delete($agent_ID)) {
            $x = CAgent::AddAgent(
                "CDevmoduleStatistic::CleanUpAgent2();", // ��� �������
                "devmodule",                          // ������������� ������
                "N",                                  // ����� �� �������� � ���-�� ��������
                $time,                                // �������� ������� - 1 �����
                date("d.m.Y H:i:s"),                // ���� ������ �������� �� ������
                "Y",                                  // ����� �������
                date("d.m.Y H:i:s"),                // ���� ������� �������
                30);
        }
    }
}
if(is_object($message))
    echo $message->Show();

$tabControl->Begin();
?>

<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>" id="options">
    <?=bitrix_sessid_post();?>
    <?
    foreach($aTabs as $aTab):
        $tabControl->BeginNextTab();
        foreach($aTab["OPTIONS"] as $name => $arOption):
            if ($bVarsFromForm)
                $val = $_POST[$name];
            else
                $val = COption::GetOptionString("devmodule", $name);
            $type = $arOption[1];
            $disabled = array_key_exists("disabled", $arOption)? $arOption["disabled"]: "";
            ?>
            <tr <?if(isset($arOption[2])) echo 'style="display:none" class="show-for-'.htmlspecialcharsbx($arOption[2]).'"'?>>
                <td width="40%" <?if($type[0]=="textarea") echo 'class="adm-detail-valign-top"'?>>
                    <label for="<?echo htmlspecialcharsbx($name)?>"><?echo $arOption[0]?></label>
                <td width="60%">
                    <?if($type[0]=="checkbox"):?>
                        <input type="checkbox" name="<?echo htmlspecialcharsbx($name)?>" id="<?echo htmlspecialcharsbx($name)?>" value="Y" <?if($val=="Y")echo" checked";?><?if($disabled)echo' disabled="disabled"';?>><?if($disabled) echo '<br>'.$disabled;?>
                    <?elseif($type[0]=="text"):?>
                        <input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($name)?>">
                    <?elseif($type[0]=="textarea"):?>
                        <textarea rows="<?echo $type[1]?>" name="<?echo htmlspecialcharsbx($name)?>" style=
                        "width:100%"><?echo htmlspecialcharsbx($val)?></textarea>
                    <?elseif($type[0]=="select"):?>
                        <select name="<?echo htmlspecialcharsbx($name)?>" onchange="doShowAndHide()">
                            <?foreach($type[1] as $key => $value):?>
                                <option value="<?echo htmlspecialcharsbx($key)?>" <?if ($val == $key) echo 'selected="selected"'?>><?echo htmlspecialcharsEx($value)?></option>
                            <?endforeach?>
                        </select>
                    <?elseif($type[0]=="note"):?>
                        <?echo BeginNote(), $type[1], EndNote();?>
                    <?endif?>
                </td>
            </tr>
        <?endforeach;
    endforeach;?>
    <?$tabControl->Buttons();?>
    <input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>" class="adm-btn-save">
    <input type="submit" name="Apply" value="<?=GetMessage("WD_PRIM")?>" title="<?=GetMessage("WD_PRIM")?>">

    <?$tabControl->End();?>
</form>
<div class="" style="padding: 20px;">
    <img src="http://webdoka.org/bitrix/templates/rm/images/logo1.png" alt=""/> <br/>
    <a target="_blank" href="http://webdoka.ru/"><?=GetMessage("WD_AUTHOR")?></a>
</div>



