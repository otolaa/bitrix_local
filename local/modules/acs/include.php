<?php
//CModule::IncludeModule("acs");
static $MODULE_ID = 'acs';
//
$arClasses=array(
    'AcsApi'=>'classes/general/acs.php',
);

CModule::AddAutoloadClasses("acs",$arClasses);