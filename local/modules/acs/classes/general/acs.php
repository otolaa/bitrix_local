<?php
class AcsApi{
    static $MODULE_ID = "acs";

    /* Отладочная функция для вывода информации в необходимом виде   AcsApi::p($text_array, "p"); */
    static function p($text, $p, $all) {
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

    // удаление файла из формы добавления-редактирования объявления -- AcsApi::DellFiles($_REQUEST);
    public function DellFiles($get){
        global $USER, $DB;
        $arJson = array();
        if(is_array($get) && count($get)>0 && intval($get['dell'])>0){
            //
            CFile::Delete(intval($get['dell']));
            $arJson['DL'] = intval($get['dell']);
            if(intval($get['id'])>0){
                // удяляем привязку файла к элементу если есть id
                $PHOTO_PROPERTY_ID = 58;
                $SQL = "DELETE FROM `b_iblock_element_prop_m5` WHERE `b_iblock_element_prop_m5`.`VALUE` = '".$arJson['DL']."' AND `b_iblock_element_prop_m5`.`IBLOCK_ELEMENT_ID` = '".intval($get['id'])."' AND `b_iblock_element_prop_m5`.`IBLOCK_PROPERTY_ID` = '".$PHOTO_PROPERTY_ID."'";
                $dbResult = $DB->Query($SQL);
            }
        }
        return json_encode($arJson);
    }

    // AcsApi::delTree(); с этой функцией нужно быть очень оккуратной и т.д. (нужна только для удаления превью файлов)
    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? AcsApi::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    // AcsApi::RotaTe($get)
    public function RotaTe($get){
        global $USER, $DB;
        $arJson = array();
        if(intval($get['img'])>0 && CModule::IncludeModule('iblock')) {
            $arFile = CFile::GetFileArray($get['img']);
            if($arFile) {
                ob_start();
                // понеслась
                $SRC = $_SERVER["DOCUMENT_ROOT"] . $arFile['SRC'];
                $SRC_SAVE = $SRC; // $_SERVER["DOCUMENT_ROOT"]."/".$uploadDirName."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"]; // куда сохраняем файл и т.д.
                //
                // AddMessage2Log("\n" . var_export($SRC_SAVE, true) . " \n \r\n ", "SRC_SAVE");
                // AddMessage2Log("\n" . var_export($SRC, true) . " \n \r\n ", "SRC");
                // AddMessage2Log("\n" . var_export($get, true) . " \n \r\n ", "get");
                // AddMessage2Log("\n" . var_export($arFile, true) . " \n \r\n ", "arFile");
                // AddMessage2Log("\n" . var_export($SRC, true) . " \n \r\n ", "SRC");
                // AddMessage2Log("\n" . var_export($arFile['CONTENT_TYPE'], true) . " \n \r\n ", "CONTENT_TYPE");

                switch($arFile['CONTENT_TYPE']){
                    case "image/jpg":
                    case "image/jpeg":
                        header ('Content-Type: image/jpeg');
                        $image = imagecreatefromjpeg($SRC);
                        $rotate = imagerotate($image, -90, 0);
                        imagejpeg($rotate, $SRC_SAVE);
                        break;
                    case "image/png":
                        header ('Content-Type: image/png');
                        $image = imagecreatefrompng($SRC);
                        $rotate = imagerotate($image, -90, 0);
                        imagepng($rotate, $SRC_SAVE);
                        break;
                    case "image/bmp": // обработка bmp не работает поэтому этот устаревший формат был убран из загрузки и т.д.
                        header ('Content-Type: image/x-ms-bmp');
                        $image = imagecreatefromwbmp($SRC);
                        $rotate = imagerotate($image, -90, 0);
                        imagewbmp($rotate, $SRC_SAVE);
                        break;
                    case "image/gif":
                        header ('Content-Type: image/gif');
                        $image = imagecreatefromgif($SRC);
                        $rotate = imagerotate($image, -90, 0);
                        imagegif($rotate, $SRC_SAVE);
                        break;
                }

                // освобождение памяти и т.д.
                imagedestroy($rotate);
                imagedestroy($image);

                // параметры файла и т.д.
                //$sfa = CFile::MakeFileArray($SRC_SAVE);
                list($width, $height, $type, $attr) = getimagesize($SRC_SAVE);
                $razmer = filesize($SRC_SAVE);

                // обновляем данные в таблици
                $SQL = "UPDATE b_file SET b_file.HEIGHT = '".$height."', b_file.WIDTH = '".$width."', b_file.FILE_SIZE = '".$razmer."' WHERE b_file.ID = " .$arFile['ID'];
                $dbResult = $DB->Query($SQL);


                /*
                // удаляем все привью которыем были сформированны и т.д.
                $uploadDirName = COption::GetOptionString("main", "upload_dir", "upload");
                $cacheImageFile = $_SERVER["DOCUMENT_ROOT"]."/".$uploadDirName."/resize_cache/".$arFile["SUBDIR"]."/";
                AcsApi::delTree($cacheImageFile);*/
                $ID = CFile::CopyFile($arFile['ID']);
                $arFileID = CFile::GetFileArray($ID);
                CFile::Delete($arFile['ID']);
                // перезаписать элемент проперти поля в элементе инфоблока и т.д.
                $PHOTO_PROPERTY_ID = 58;
                $SQL = "UPDATE `b_iblock_element_prop_m5` as `biel` SET  `biel`.`VALUE` =  '".$ID."', `biel`.`VALUE_NUM` =  '".$ID.".0000' WHERE  `biel`.`VALUE` ='".$arFile['ID']."' AND `biel`.`IBLOCK_ELEMENT_ID` = '".$get['id']."' AND `biel`.`IBLOCK_PROPERTY_ID` = '".$PHOTO_PROPERTY_ID."'";
                $dbResult = $DB->Query($SQL);
                //
                $arJson['id'] = $ID;
                $arJson['href'] = $arFileID['SRC'];

                /// Формируем новое превью
                $arFileTmp = CFile::ResizeImageGet(
                    $ID,
                    array("width" => 110, "height" => 105),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true, ''
                );

                //
                // AddMessage2Log("\n" . var_export($arFileTmp, true) . " \n \r\n ", "arFileTmp");
                // AddMessage2Log("\n" . var_export($ID, true) . " \n \r\n ", "ID");
                // AddMessage2Log("\n" . var_export($arFileS, true) . " \n \r\n ", "arFileS");
                //
                $arJson['width'] = $arFileTmp['width'];
                $arJson['height'] = $arFileTmp['height'];
                print $arFileTmp['src'];
                $html = ob_get_contents();
                ob_end_clean();
            }
        }

        $arJson['html'] = $html;
        $arJson['width'] = ($arJson['width']?$arJson['width']:110);
        $arJson['height'] = ($arJson['height']?$arJson['height']:105);
        return json_encode($arJson);
    }
}