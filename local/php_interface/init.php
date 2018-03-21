<?

/*
 * Отладочная функция для вывода информации в необходимом виде
 *
 */
function p($text, $p, $all) {
    global $USER;
    if ($USER->IsAdmin() || $_SERVER["REMOTE_ADDR"] == "85.31.176.156" || $_SERVER["REMOTE_ADDR"] == "128.72.9.44" || $_SERVER["REMOTE_ADDR"] == "95.25.11.115" || $_SERVER["REMOTE_ADDR"] == "37.232.249.89" || $all == "all") {
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

/*
* функция для обрезки текста
*/
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


/* функция для поиска в массиве строки вхождения  strpos */
function strpos_arr($haystack, $needle) {
    if(!is_array($needle)){$needle = array($needle);}
    foreach($needle as $what) {
        $pos = strpos($haystack, $what);
        if($pos !== false){return true;}
    }
    return false;
}

/*
* Транслитерация файлов
$name = "Текст*89";
$arParams = array("replace_space"=>"-","replace_other"=>"-");
$trans = Cutil::translit($name,"ru",$arParams);
*/
function translit($text){
    $trans = array(
        "а" => "a",        "б" => "b",        "в" => "v",        "г" => "g",
        "д" => "d",        "е" => "e",        "ё" => "e",        "ж" => "zh",
        "з" => "z",        "и" => "i",        "й" => "y",        "к" => "k",
        "л" => "l",        "м" => "m",        "н" => "n",        "о" => "o",
        "п" => "p",        "р" => "r",        "с" => "s",        "т" => "t",
        "у" => "u",        "ф" => "f",        "х" => "kh",        "ц" => "ts",
        "ч" => "ch",        "ш" => "sh",        "щ" => "shch",        "ы" => "y",
        "э" => "e",        "ю" => "yu",        "я" => "ya",        "А" => "A",
        "Б" => "B",        "В" => "V",        "Г" => "G",        "Д" => "D",
        "Е" => "E",        "Ё" => "E",        "Ж" => "Zh",        "З" => "Z",
        "И" => "I",        "Й" => "Y",        "К" => "K",        "Л" => "L",
        "М" => "M",        "Н" => "N",        "О" => "O",        "П" => "P",
        "Р" => "R",        "С" => "S",        "Т" => "T",        "У" => "U",
        "Ф" => "F",        "Х" => "Kh",        "Ц" => "Ts",        "Ч" => "Ch",
        "Ш" => "Sh",        "Щ" => "Shch",        "Ы" => "Y",        "Э" => "E",
        "Ю" => "Yu",        "Я" => "Ya",        "ь" => "",        "Ь" => "",
        "ъ" => "",        "Ъ" => "",        "—" => "-",
    );
    if(preg_match("/[а-яА-Яa-zA-Z\.]/", $text)) {
        return strtr($text, $trans);
    }
    else {
        return $text;
    }
}


/* класс вспомогательный для переменных и т.д. */
class PRM {
    // PRM::PR($PREVIEW_PICTURE, $arSize = array("width" => 50, "height" => 50)); класс для привью картинки, налету
    public function PR($PREVIEW_PICTURE, $arSize, $filter=Null){
        if(CModule::IncludeModule("iblock") && CModule::IncludeModule("main")){
            $arPR = array();
            $arPR = array_merge(array('ID' => $PREVIEW_PICTURE), array_change_key_case(CFile::ResizeImageGet(
                $PREVIEW_PICTURE,
                $arSize,
                ($filter ? $filter : BX_RESIZE_IMAGE_EXACT),
                true
            ),CASE_UPPER));
            return $arPR;
        }
    }
}


/* отложенная функция возвращает необходимые классы */
/* sidebar-left sidebar-right two-sidebars */
function setMainClass(){
    global $APPLICATION;
    //
    if(!$APPLICATION->GetPageProperty('main_class', '')){
        return "col-sm-8 col-md-9 col-lg-9";
    }else{
        //
        switch ($APPLICATION->GetPageProperty("main_class")) {
            case "sidebar-left":
                return "col-sm-12 col-md-8 col-lg-9";
                break;
            case "two-sidebars":
                return "col-sm-8 col-md-6 col-lg-6";
                break;
            case "no-sidebars":
                return "col-sm-12 col-md-12 col-lg-12";
                break;
            case "sidebar-right":
                return "col-sm-8 col-md-9 col-lg-9";
                break;
            default:
                return "col-sm-8 col-md-9 col-lg-9";
        }
    }
}

/* sidebars-left */
function setSidebarsLeft(){
    global $APPLICATION;
    //
    if(!$APPLICATION->GetPageProperty('main_class', '')){
        return "visible-lg hidden-lg";
    }else{
        switch ($APPLICATION->GetPageProperty("main_class")) {
            case "sidebar-left":
                return "col-sm-12 col-md-4 col-lg-3";
                break;
            case "two-sidebars":
                return "col-sm-12 col-md-3 col-lg-3";
                break;
            case "no-sidebars":
                return "visible-lg hidden-lg";
                break;
            case "sidebar-right":
                return "visible-lg hidden-lg";
                break;
            default:
                return "visible-lg hidden-lg";
        }
    }
}

/* sidebars-right */
function setSidebarsRight(){
    global $APPLICATION;
    //
    if(!$APPLICATION->GetPageProperty('main_class', '')){
        return "col-sm-4 col-md-3 col-lg-3";
    }else{
        switch ($APPLICATION->GetPageProperty("main_class")) {
            case "sidebar-left":
                return "visible-lg hidden-lg";
                break;
            case "two-sidebars":
                return "col-sm-4 col-md-3 col-lg-3";
                break;
            case "no-sidebars":
                return "visible-lg hidden-lg";
                break;
            case "sidebar-right":
                return "col-sm-4 col-md-3 col-lg-3";
                break;
            default:
                return "col-sm-4 col-md-3 col-lg-3";
        }
    }
}

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


//
AddEventHandler('form', 'onAfterResultAdd', 'my_onAfterResultAddUpdate');
AddEventHandler('form', 'onAfterResultUpdate', 'my_onAfterResultAddUpdate');
function my_onAfterResultAddUpdate($WEB_FORM_ID, $RESULT_ID)
{
    // действие обработчика распространяется только на форму с ID=3
    if ($WEB_FORM_ID == 3)
    {
        // запишем в дополнительное поле 'USER_IP' IP-адрес пользователя
        CFormResult::SetField($RESULT_ID, 'USER_IP', $_SERVER["REMOTE_ADDR"]);
        //
        $rsResultForm = CFormResult::GetByID($RESULT_ID)->Fetch();
        // запись в лог $_SERVER["DOCUMENT_ROOT"]."/log.txt"
        AddMessage2Log("\n".var_export($rsResultForm, true). " \n \r\n ", "_rsResultForm");
    }
}

/*
You can place here your functions and event handlers

AddEventHandler("module", "EventName", "FunctionName");
function FunctionName(params)
{
	//code
}
*/