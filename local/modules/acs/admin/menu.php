<?php
IncludeModuleLangFile(__FILE__);

if($APPLICATION->GetGroupRight("acs")>"D"){

    require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/acs/prolog.php");

    // the types menu  dev.1c-bitrix.ru/api_help/main/general/admin.section/menu.php
    $aMenu = array(
        "parent_menu" => "global_menu_settings",
        "section" => "acs",
        "sort" => 15,
        "module_id" => "acs",
        "text" => 'Вспомогательный модуль',
        "title"=> 'Вспомогательный модуль для дополнительного функционала',
        "icon" => "sys_menu_icon",   // sys_menu_icon  bizproc_menu_icon
        "page_icon" => "sys_menu_icon", // sys_menu_icon  bizproc_menu_icon
        "items_id" => "menu_acs",
        "items" => array(
            array(
                "text" => 'Настройки',
                "title" => 'Настройки модуля',
                "url" => "settings.php?mid=acs&lang=".LANGUAGE_ID,
            ),
            /* array(
                "text" => 'Name menu',
                "title" => 'Name menu',
                "items_id" => "acs_menu_ads",
                "items" => array(
                    array(
                        "text" => 'Name menu sub',
                        "title" => 'Name menu sub',
                        "url" => "name_files.php?lang=".LANGUAGE_ID,
                        # "more_url" => array('acs_stat.php'),
                    ),
                )
            ), */
        )
    );
    return $aMenu;
}
return false;