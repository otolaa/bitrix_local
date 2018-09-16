<?php
//CModule::IncludeModule("acs");
static $MODULE_ID = 'acs';
//
$arClasses=array(
    'AcsApi'=>'classes/general/acs.php',
    'HiWrapper'=>'classes/general/HiWrapper.php',
);

CModule::AddAutoloadClasses("acs",$arClasses);