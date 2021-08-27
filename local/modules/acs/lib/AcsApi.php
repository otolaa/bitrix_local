<?php
namespace Bitrix\acs;

/**
 * Class AcsApi
 * @package Bitrix\acs
 */
class AcsApi
{

    static $MODULE_ID = "acs";

    /* Debug function for displaying information in the required form */
    public static function p($text, $p = Null, $all = Null) {
        global $USER;
        if ($USER->IsAdmin() || $all == "all")
        {
            echo "<pre>";
            if($p == "p") {
                print_r($text);
            } elseif($p == "export") {
                var_export($text);
            } else {
                var_dump($text);
            }
            echo "</pre>";
        }
    }

}