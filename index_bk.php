<?
define("SITE_TEMPLATE_PATH", "/local/templates/bk"); // подключаем тему
define("SITE_TEMPLATE_ID", "bk"); // подключаем тему
define("HIDE_SIDEBAR", false); // true - отключаем правый столбец темы
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("I ❤ Bootstrap");
$APPLICATION->AddChainItem('Bootstrap 4.6');
$APPLICATION->SetPageProperty('main_class','mb-5'); // отложенная функция, добавляет class
?>

    <div class="alert alert-primary" role="alert">
        Данная тема шаблона <nobr>I ❤ Bootstrap 4.6</nobr> для Bitrix подключается двумя переменными SITE_TEMPLATE_PATH и SITE_TEMPLATE_ID в файле index_bk.php (т.е. программным способом)<br>
        Все стили Bootstrap 4.6 для данной темы подключаются через CDN, дополнительные стили переопределяются снизу
    </div>

    <div class="alert alert-primary" role="alert">
        <ul style="margin-bottom: 0px; padding-left: 15px;">
            <li>Текст сверху редактируется в index_bk_top.php</li>
            <li>Текст справа редактируется в index_bk_right.php</li>
            <li>Текст по середине редактируется в index_bk.php</li>
        </ul>
    </div>

    <h2>1. acs.currency</h2>
    <? $APPLICATION->IncludeComponent("acs:acs.currency", ".default",
    [
        "CURR" => [
            0 => "USD",
            1 => "EUR",
            2 => "PLN",
        ],
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
    ],
    false
    ); ?>

    <h2>3. acs:acs.map</h2>
    <? $APPLICATION->IncludeComponent("acs:acs.map", ".default",
        [
            "ITEMS" => [
                [ 'COORDINATES'=>'55.762996,37.432978',
                    'title'=>'КОНТАКТЫ В МОСКВЕ',
                    'description'=>'г. Москва, Крылатская, 10. <br> По будням: с 07:30 до 21:00 <br> По выходным и праздникам: с 09:00 до 18:00'
                ],
                [ 'COORDINATES'=>'54.724271,20.467754',
                    'title'=>'КОНТАКТЫ В КАЛИНИНГРАДЕ',
                    'description'=>'г. Калининград, ул. Каменная 17-2<br> По будням: с 07:30 до 21:00 <br> По выходным и праздникам: с 09:00 до 18:00']
            ],
            "CACHE_TYPE"=>"A",
            "CACHE_TIME"=>3600,
            "DIV"=>"mapCamp",
            "PRESET"=>"islands#blackDotIcon", // style for icon in maps
            "ICON_COLOR"=>"#777777", // color icon
            "HEIGHT"=>350, //px
            "CLUSTERER"=>'islands#invertedBlackClusterIcons', //
        ],
        false
    ); ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>