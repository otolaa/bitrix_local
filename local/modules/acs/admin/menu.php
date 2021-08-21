<?php
IncludeModuleLangFile(__FILE__);

if ($APPLICATION->GetGroupRight("acs") > "D") {

    require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/acs/prolog.php");

    // the types menu  dev.1c-bitrix.ru/api_help/main/general/admin.section/menu.php
    $aMenu = [
        "parent_menu" => "global_menu_content", // global_menu_content - раздел "Контент" global_menu_settings - раздел "Настройки"
        "section" => "acs",
        "sort" => 880,
        "module_id" => "acs",
        "text" => 'Вспомогательный модуль',
        "title"=> 'Вспомогательный модуль для дополнительного функционала',
        "icon" => "util_menu_icon", // sys_menu_icon bizproc_menu_icon util_menu_icon
        "page_icon" => "util_menu_icon", // sys_menu_icon bizproc_menu_icon util_menu_icon
        "items_id" => "menu_acs",
        "items" => [
            [
                "text" => 'Настройки сообщений',
                "title" => 'Настройки сообщений',
                "url" => "settings.php?mid=acs&lang=".LANGUAGE_ID,
            ],
            /* [
                "text" => 'Name menu',
                "title" => 'Name menu',
                "items_id" => "acs_menu_ads",
                "items" => [
                    [
                        "text" => 'Name menu sub',
                        "title" => 'Name menu sub',
                        "url" => "name_files.php?lang=".LANGUAGE_ID,
                        # "more_url" => array('acs_stat.php'),
                    ],
                ]
            ], */
        ]
    ];

    return $aMenu;
}

return false;