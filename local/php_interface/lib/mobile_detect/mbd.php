<?php

namespace Olepro\Classes\Helpers;

// require dirname(__FILE__) . "/Mobile_Detect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/lib/mobile_detect/Mobile_Detect.php';

class MobileDetect extends \Mobile_Detect {

    /** @var \Mobile_Detect */
    protected static $instance;

    /**
     * @return \Mobile_Detect
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}