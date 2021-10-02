<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">
    <div class="col-12">
        <div class="alert alert-primary" role="alert">
            <i class="fa fa-info-circle"></i> Правый блок отключается в index_bk.php переменной <nobr>HIDE_SIDEBAR = true</nobr>
        </div>
    </div>
    <div class="col-12 mb-3">
        <?$APPLICATION->IncludeComponent("bitrix:menu", ".default",
            [
                "ROOT_MENU_TYPE" => "top",
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "N",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => []
            ]
        );?>
    </div>
    <div class="col-12">
        <div class="alert alert-secondary" role="alert">
            <i class="fa fa-info-circle"></i> Иконки используется <a href="https://fontawesome.bootstrapcheatsheets.com/" class="alert-link" target="_blank" rel="nofollow">font-awesome/4.7.0</a>
        </div>
    </div>

    <div class="col-12">
        <h2>2. acs:acs.weather</h2>
        <div class="alert alert-secondary" role="alert">
            <? $APPLICATION->IncludeComponent("acs:acs.weather", ".default",
                array(
                    "KEY" => \Bitrix\Main\Config\Option::get("local.utility", "OPENWEATHERMAP_KEY", ''), // key from is openweathermap.org
                    "CITY_ID" => "536203",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600"
                ),
                false
            ); ?>
        </div>
    </div>

    <? if (Bitrix\Main\Loader::includeModule("local.utility")) : ?>
    <div class="col-12">
        <div class="alert alert-secondary fade show" role="alert">
            <?=\Bitrix\Main\Config\Option::get("local.utility", "SITE_COOKIE", '')?>
            <button type="button" class="btn btn-secondary btn-sm btn-block mt-2" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">принять</span>
            </button>
        </div>
    </div>
    <? endif; ?>

</div>

