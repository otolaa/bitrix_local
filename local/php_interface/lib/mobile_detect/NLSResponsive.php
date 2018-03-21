<?
class NLSResponsive
{
	public static $mobile_device = NULL;
	public static $tablet_device = NULL;
	public static $isMobile = NULL;

	static function init() {
        require_once dirname(__FILE__) . "/Mobile_Detect.php";
		$detect = new Mobile_Detect;
		self::$mobile_device = $detect->isMobile() && !$detect->isTablet(); // мобильный телефон
		self::$tablet_device = $detect->isTablet(); // планшет
		self::$isMobile = $detect->isMobile(); // мобильный телефон или планшет
	}

	static function getImg($params) {
		if (!@$params["DESKTOP"] && $params["TABLET"]) {
			$params["DESKTOP"] = $params["TABLET"];
		}
		if (!@$params["TABLET"] && $params["MOBILE"]) {
			$params["TABLET"] = $params["MOBILE"];
		}

		if (!empty($params["RETINA"])) {
			if (!@$params["RETINA"]["DESKTOP"] && $params["RETINA"]["TABLET"]) {
				$params["RETINA"]["DESKTOP"] = $params["RETINA"]["TABLET"];
			}
			if (!@$params["RETINA"]["TABLET"] && $params["RETINA"]["MOBILE"]) {
				$params["RETINA"]["TABLET"] = $params["RETINA"]["MOBILE"];
			}
		}

		if (self::$mobile_device) {
			$path = @$params["MOBILE"];
		} elseif (self::$tablet_device) {
			$path = @$params["TABLET"];
		} else {
			$path = @$params["DESKTOP"];
		}

		if (!@$params["CLASS"]) {
			$params["CLASS"] = "";
		}
		$params["CLASS"] .= " responsive_image";
		$attrs = self::__GenerateAttrs($params);

		$return = '<img src="' . $path . '" ' . $attrs . ' />';
		return $return;
	}

	static private function __GenerateAttrs($params) {
		$str = "";
		$tags = array("ALT", "CLASS", "STYLE");
		$not_generate = array();
		foreach ($params as $name => $val) {
			if (is_array($val)) {
				foreach ($params[$name] as $n => $v) {
					$params[$name . $n] = $v;
				}
			}
		}
		foreach ($params as $name => $val) {
			if (is_string($val)) {
				if (!in_array($name, $tags)) {
					$name = "data-" . $name;
				}
				$str .= strtolower($name) . '="' . $val . '"';
			}
		}
		return $str;
	}
}

NLSResponsive::init();