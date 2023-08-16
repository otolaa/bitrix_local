<?php /* minimal set of functions for a real gentleman */

/* Debug function for displaying information in the required form */
function p($text, $p = Null, $all = Null) {
    if (\Bitrix\Main\Engine\CurrentUser::get()->isAdmin() || $all == "all") {
        echo "<pre>";
        if ($p == "p")
            print_r($text);
        elseif ($p == "export")
            var_export($text);
        else
            var_dump($text);
        echo "</pre>";
    }
}

/* function to trim text */
function my_crop($text, $length, $clearTags = true)
{
    $text = trim($text);
    if ($clearTags === true)
        $text = strip_tags($text);
    if ($length <= 0 || strlen($text) <= $length)
        return $text;
    $out = mb_substr($text, 0, $length);
    $pos = mb_strrpos($out, ' ');
    if ($pos)
        $out = mb_substr($out, 0, $pos);
    return $out.'…';
}

/* a function to search an array for an entry string */
function strpos_arr($haystack, $needle) {
    if (!is_array($needle))
        $needle = array($needle);

    foreach($needle as $what) {
        $pos = strpos($haystack, $what);
        if ($pos !== false)
            return true;
    }

    return false;
}

/* Transliteration */
function getTranslit($name) {
    $arParams = ["replace_space"=>"-","replace_other"=>"-"];
    $trans = Cutil::translit($name,"ru",$arParams); // dev.1c-bitrix.ru/api_help/main/reference/cutil/translit.php
    return $trans;
}

/* variable helper class */
class PRM
{
    // for preview pictures, on the fly
    // PRM::PR($PREVIEW_PICTURE, $arSize = array("width" => 50, "height" => 50));
    public static function PR($PREVIEW_PICTURE, $arSize, $filter=Null)
    {
        $filter = ($filter ? $filter : BX_RESIZE_IMAGE_EXACT);
        $arPR = array_merge(
            ['ID'=>$PREVIEW_PICTURE],
            array_change_key_case(CFile::ResizeImageGet($PREVIEW_PICTURE, $arSize, $filter,true),CASE_UPPER)
        );
        return $arPR;
    }

    // watermark in the picture
    public static function PRW($PREVIEW_PICTURE, $arSize, $filter=Null)
    {
        $filter = ($filter ? $filter : BX_RESIZE_IMAGE_PROPORTIONAL);
        $arWaterMark = [
            [
                "name" => "watermark",
                "position" => "mc", // Center position
                "type" => "image",
                "size" => "real",
                "file" => $_SERVER["DOCUMENT_ROOT"].'/local/templates/bk/img/watermark.png', // The path to the picture
                "fill" => "exact",
            ]
        ];
        $arPR = array_merge(
            ['ID'=>$PREVIEW_PICTURE],
            array_change_key_case(CFile::ResizeImageGet($PREVIEW_PICTURE, $arSize, $filter,true, $arWaterMark),CASE_UPPER)
        );
        return $arPR;
    }

    // returns the protocol on which the site is sitting
    public static function isHttps() {
        $isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
        return ($isHttps?"https://":"http://");
    }

    public static function log($arFields, $nameModule = '')
    {
        // define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");  /* in dbconn.php */
        AddMessage2Log("\n".var_export($arFields, true). " \n \r\n ", $nameModule);
    }
}


/* the deferred function returns class for page */
function mainClass() {
    global $APPLICATION;
    return $APPLICATION->GetPageProperty('main_class', '');
}

/* page for return 404 error */
AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error()
{
    if (defined("ERROR_404") && ERROR_404=="Y")
    {
        global $APPLICATION;
        $GetCurPage_ = $APPLICATION->GetCurPage();
        $LocalRedirect_ = "/404.php";
        if($GetCurPage_ != $LocalRedirect_) LocalRedirect($LocalRedirect_);
    }
}