<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
</div><!--/col-12-->
<? if(!$needSidebar): ?>
    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
            [
                "AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "right",
                "AREA_FILE_RECURSIVE" => "Y", "EDIT_MODE" => "html", "EDIT_TEMPLATE" => "sect_inc.php"
            ]
        );
        $APPLICATION->IncludeComponent("bitrix:main.include", "",
            [
                "AREA_FILE_SHOW" => "page", "AREA_FILE_SUFFIX" => "right",
                "AREA_FILE_RECURSIVE" => "Y", "EDIT_MODE" => "html", "EDIT_TEMPLATE" => "page_inc.php"
            ]
        );?>
    </div><!--/right-->
<? endif; ?>
</div><!--/row-->
</div><!--/container-->
</main><!--/main-->

<footer>
    <div class="container">
        <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include/copyright.php"), [], ["MODE"=>"html"]);?>
    </div>
</footer>

</body>
</html>