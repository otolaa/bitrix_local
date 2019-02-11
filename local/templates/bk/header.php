<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/* lang files */
IncludeTemplateLangFile(__FILE__);
global $USER, $APPLICATION;
/* MOBILES */
include $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/lib/mobile_detect/NLSResponsive.php';
/* CSS Script can then be removed */
$styles = array("styles", "template_styles");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/less.php/Less.php";
$options = array('compress'=>true);
foreach($styles as $filename){
    $parser = new Less_Parser($options);
    $parser->parseFile($_SERVER["DOCUMENT_ROOT"] . '/local/templates/bk/css/'.$filename.'.less', '/local/templates/bk/css/');
    $css = $parser->getCss();
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/local/templates/bk/css/'.$filename.'.css', $css);
} ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?$APPLICATION->ShowHead();?>
    <? /* подключаем библиотеки (( */ ?>
    <? CJSCore::Init(array('ajax', 'window')); ?>
    <? /* from meta VK && Facebook */ ?>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?=$APPLICATION->ShowTitle("title",true)?>" />
    <meta property="og:url" content="http://<?=$_SERVER['SERVER_NAME']?><?=$APPLICATION->GetCurPageParam("", Array("clear_cache","bitrix_include_areas"))?>" />
    <meta property="og:site_name" content="<?$arSite=$APPLICATION->GetSiteByDir();echo $arSite["NAME"]?>" />
    <? /* Title */ ?>
    <title><?$APPLICATION->ShowTitle()?></title>

    <? /* Bootstrap */
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/bootstrap-3/css/bootstrap.min.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/js/datepicker/css/bootstrap-datepicker.min.css');
    /* STYLE */
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/styles.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/template_styles.css');
    //
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/font-awesome-4.7.0/css/font-awesome.min.css');
    //$APPLICATION->SetAdditionalCSS('/local/templates/.common/js/fancybox-master/dist/jquery.fancybox.min.css'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <? /* jQuery (necessary for Bootstrap's JavaScript plugins) */
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-1.12.4/jquery-1.12.4.min.js');
    /* Include all compiled plugins (below), or include individual files as needed */
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/bootstrap-3/js/bootstrap.js');
    /* ALL JAVASCRIPT */
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.nicescroll.340/jquery.nicescroll.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/datepicker/js/bootstrap-datepicker.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/datepicker/locales/bootstrap-datepicker.ru.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/my.js');
    ?>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon.ico" />
</head>

<body role="document">
<? /* FROM ADMIN */ ?>
<?$APPLICATION->ShowPanel();?>
<? /* MENU */ ?>
<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include/company_name.php"), Array(), Array("MODE"=>"html"));?>
        </div>
        <div class="navbar-collapse collapse">
            <?$APPLICATION->IncludeComponent("bitrix:menu", "bootstrap_horizontal_multilevel",
                Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "Y",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => Array()
                )
            );?>
        </div><!--/.nav-collapse -->
    </div>
</div>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <? /* Main include */ ?>
    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
        Array(
            "AREA_FILE_SHOW" => "sect",
            "AREA_FILE_SUFFIX" => "top",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_MODE" => "html",
            "EDIT_TEMPLATE" => "sect_inc.php"
        )
    );?>
    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
        Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "top",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_MODE" => "html",
            "EDIT_TEMPLATE" => "page_inc.php"
        )
    );?>
</div>

<? /* three columns && + */ ?>
<div class="container theme-showcase" data-detected="<?=(NLSResponsive::$mobile_device ? "mobile_detect_mobile" : (NLSResponsive::$tablet_device ? "mobile_detect_tablet" : "mobile_detect_desktop"))?>">



    <div class="row">
        <main class="<?$APPLICATION->AddBufferContent('setMainClass')?>" role="main">

            <div id="navigation">
                <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default",
                    Array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => ""
                    )
                );?>
            </div>

            <div class="page-header">
                <h1 id="pagetitle"><?$APPLICATION->ShowTitle(false)?></h1>
            </div>
