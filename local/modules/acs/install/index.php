<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

loc::loadMessages(__FILE__);

Class acs extends CModule
{
    var $MODULE_ID = "acs";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;

    public function __construct()
    {
        $arModuleVersion = [];
        include(__DIR__.'/version.php');
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage("acs_module_name");
        $this->MODULE_DESCRIPTION = GetMessage("acs_module_desc");
    }

    function getPageLocal($page)
    {
        return str_replace('index.php', $page, Loader::getLocal('modules/'.$this->MODULE_ID.'/install/index.php'));
    }

    function InstallFiles($arParams = [])
    {
        CopyDirFiles($this->getPageLocal('admin'), $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($this->getPageLocal('admin'), $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
        return true;
    }

    /**/


    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        // Install events
        // RegisterModuleDependences("iblock","OnBeforeIBlockElementUpdate",$this->MODULE_ID,"cMainRPJ","onBeforeElementUpdateHandler");
        RegisterModule($this->MODULE_ID);
        $this->InstallFiles();
        $APPLICATION->IncludeAdminFile("Установка модуля ".$this->MODULE_ID, $this->getPageLocal('step.php'));
        return true;
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        // UnRegisterModuleDependences("iblock","OnBeforeIBlockElementUpdate",$this->MODULE_ID,"cMainRPJ","onBeforeElementUpdateHandler");
        UnRegisterModule($this->MODULE_ID);
        $this->UnInstallFiles();
        $APPLICATION->IncludeAdminFile("Деинсталляция модуля ".$this->MODULE_ID, $this->getPageLocal('unstep.php'));
        return true;
    }
}