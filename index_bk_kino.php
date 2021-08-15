<?
define("SITE_TEMPLATE_PATH", "/local/templates/bk"); // подключаем тему
define("SITE_TEMPLATE_ID", "bk"); // подключаем тему
define("HIDE_SIDEBAR", true); // true - отключаем правый столбец темы
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("I ❤ Bootstrap");
$APPLICATION->AddChainItem('kinopoisk is afisha');
$APPLICATION->SetPageProperty('main_class','mb-5'); // отложенная функция, добавляет class
?>


    <h2>4. acs.kino</h2>
    <? $APPLICATION->IncludeComponent("acs:acs.kino", ".default",
    array(
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => 3600*3, // three hour
        "URL_CITY_PAGE" => "https://www.kinopoisk.ru/afisha/city/490/",
        "OLL_PAGE" => "/kino/",
        "COMPONENT_TEMPLATE" => ".default"
    ),
    false
    ); ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>