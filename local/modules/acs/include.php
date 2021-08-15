<?php
IncludeModuleLangFile(__FILE__);
static $MODULE_ID = 'acs';
//
$arClasses=array(
    'AcsApi'=>'classes/general/AcsApi.php',
);

CModule::AddAutoloadClasses("acs", $arClasses);