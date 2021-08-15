<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// D7
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

/* lang files */
Loc::loadMessages(__FILE__);

global $USER, $APPLICATION;
$curPage = $APPLICATION->GetCurPage(true); /* path the pages from templates styles */
$needSidebar = (defined("HIDE_SIDEBAR") && HIDE_SIDEBAR == true || preg_match("~^".SITE_DIR."(courses|catalog)/~", $curPage) ? true : false); ?>

<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?$APPLICATION->ShowHead();?>
    <? /* from meta VK && Facebook && yandex - called through deferred functions
    Asset::getInstance()->addString('<meta name="yandex-verification" content="" />', true);
    Asset::getInstance()->addString('<meta property="og:type" content="website" />', true);
    Asset::getInstance()->addString('<meta property="og:title" content="" />', true);
    Asset::getInstance()->addString('<meta property="og:url" content="" />', true);
    Asset::getInstance()->addString('<meta property="og:site_name" content="" />', true);
     */ ?>
    <title><?$APPLICATION->ShowTitle()?></title>

    <? /* Bootstrap && font-awesome && fonts.googleapis */
    Asset::getInstance()->addCss('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css');
    Asset::getInstance()->addCss('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    Asset::getInstance()->addCss('https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

    /* STYLE */
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/style.css');

    /* <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// --> */
    Asset::getInstance()->addString('<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->');

    /* jQuery && bootstrap && script.min */
    Asset::getInstance()->addJs('https://code.jquery.com/jquery-3.5.1.min.js');
    Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js');
    Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js');
    /* ALL JAVASCRIPT */
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/script.min.js'); ?>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon.ico" />
</head>

<body>
<? /* FROM ADMIN */ ?>
<?$APPLICATION->ShowPanel();?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include/company_name.php"), [], ["MODE"=>"html"]);?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <?$APPLICATION->IncludeComponent("bitrix:menu", "bootstrap_horizontal_multilevel",
            [
                "ROOT_MENU_TYPE" => "top",
                "MAX_LEVEL" => "2",
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "Y",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => []
            ]
        );?>
        <form class="form-inline my-2 my-lg-0" action="/search/" method="get">
            <div class="input-group">
                <input class="form-control" name="q" type="text" placeholder="Поиск" aria-label="Search">
                <div class="input-group-append"><button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></div>
            </div>
        </form>
    </div>
</nav>

<main role="main">
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
            [
                "AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "top",
                "AREA_FILE_RECURSIVE" => "Y", "EDIT_MODE" => "php", "EDIT_TEMPLATE" => "sect_inc.php"
            ]
        );
        $APPLICATION->IncludeComponent("bitrix:main.include", "",
            [
                "AREA_FILE_SHOW" => "page", "AREA_FILE_SUFFIX" => "top",
                "AREA_FILE_RECURSIVE" => "Y", "EDIT_MODE" => "php", "EDIT_TEMPLATE" => "page_inc.php"
            ]
        );?>
    </div>

    <div class="container <?$APPLICATION->AddBufferContent('mainClass')?>">
        <div class="row">
            <div class="col-12 col-sm-12 <?=(!$needSidebar?'col-md-12 col-lg-8 col-xl-8':'')?>">
                <div id="navigation">
                    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default",
                        [
                            "START_FROM" => "0",
                            "PATH" => "",
                            "SITE_ID" => ""
                        ]
                    );?>
                </div>
                <div class="page-header">
                    <h1 id="pagetitle"><?$APPLICATION->ShowTitle(false)?></h1>
                </div>