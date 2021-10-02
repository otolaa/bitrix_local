<?php
namespace Local\Utility;

/**
 * Class Api
 * @package Local\Utility
 */
class Api
{

    static $MODULE_ID = "local.utility";

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