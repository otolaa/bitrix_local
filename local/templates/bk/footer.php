<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
    </main><!--/main-->
    <? /* RIGHT */ ?>
    <aside class="<?$APPLICATION->AddBufferContent('setSidebarsRight')?>" role="sidebars-right">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "sect",
            "AREA_FILE_SUFFIX" => "inc",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_MODE" => "html",
            "EDIT_TEMPLATE" => "sect_inc.php"
        )
    );?> <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "inc",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_MODE" => "html",
            "EDIT_TEMPLATE" => "page_inc.php"
        )
    );?>
    </aside><!--/right-->
</div> <!--row-->
</div> <!-- /container -->

<footer id="footer">
    <div class="container">
        <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include/copyright.php"),Array(),Array("MODE"=>"html"));?>
    </div>
</footer>

</body>
</html>