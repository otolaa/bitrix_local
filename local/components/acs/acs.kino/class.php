<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

class kinopoiskAPI extends \CBitrixComponent
{
    //
    private $URL_PARSER_PAGE = "https://www.kinopoisk.ru/afisha/city/490/";

    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => isset($arParams["CACHE_TYPE"])?$arParams["CACHE_TYPE"]:"A",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"])?$arParams["CACHE_TIME"]:3600*3, // three hour
            "CACHE_GROUPS" => isset($arParams["CACHE_GROUPS"])?$arParams["CACHE_GROUPS"]:"N",
            "URL_CITY_PAGE" => isset($arParams["URL_CITY_PAGE"])?$arParams["URL_CITY_PAGE"]:$this->URL_PARSER_PAGE,
            "OLL_PAGE" => isset($arParams["OLL_PAGE"])?$arParams["OLL_PAGE"]:false,
        ];
        return $result;
    }

    public function acsKinoPageParser()
    {
        $res = NULL;
        $PARAM_PARSER = file_get_contents($this->arParams["URL_CITY_PAGE"]);
        if($PARAM_PARSER ===  FALSE){
            return FALSE;
        }
        //
        $doc = new DOMDocument();
        $doc->loadHTML($PARAM_PARSER); // from html
        $xpath = new DOMXpath($doc);
        //
        $body = $xpath->query('//td[@id="block_left"]/div[@class="block_left"]/table/tr/td');
        $headers = $xpath->query('table/tr/td[@colspan="3"]/table/tr/td[@colspan="3"]/a',$body->item(0))->item(0)->nodeValue;
        //
        $filmArr = [];
        $dtFilm = $xpath->query('div[@class="showing"]',$body->item(0));
        foreach ($dtFilm as $fl) {
            //
            $showDate = $xpath->query('div[@class="showDate"]|div[@class="showDate gray"]',$fl)->item(0)->nodeValue;
            $fmArr = [];
            $fm = $xpath->query('div[@class="films_metro "]|div[@class="films_metro"]',$fl);
            foreach ($fm as $f){
                $fmn = $xpath->query('div[@class="title _FILM_"]/div/p/a',$f)->item(0)->nodeValue;
                $age = false;
                if($age = $xpath->query('div[@class="title _FILM_"]/div/p/span',$f)->item(0)):
                    $age = explode(" ",$age->getAttribute('class'));
                    $age = str_replace("age", "", $age[count($age)-1]);
                endif;
                // descriptions for films
                $fmInfoArr = [];
                $fmInfo = $xpath->query('div[@class="title _FILM_"]/ul/li',$f);
                foreach ($fmInfo as $fi){
                    $fmInfoArr[] = $fi->textContent;
                }
                // the cinema и т.д.
                $cinemaArr = [];
                $cnm = $xpath->query('div[@class="showing_section"]/dl',$f);
                foreach ($cnm as $cinema) {
                    $cnn = $xpath->query('dt[@class="name"]',$cinema)->item(0)->textContent; // название кинотеатра и т.д.
                    // the time
                    $shArr = [];
                    foreach ($xpath->query('dd[@class="time"]',$cinema) as $time){
                        $ibu = [];
                        foreach ($xpath->query('i|u|b',$time) as $tt){
                            $ibu[] = "<".$tt->tagName.">".trim($tt->textContent)."</".$tt->tagName.">";
                        }
                        $shArr[] = implode(" ",$ibu);
                    }
                    // hall
                    $hallArr = [];
                    foreach ($xpath->query('dd[@class="hall"]',$cinema) as $hall){
                        // return html
                        $hall = $body->item(0)->ownerDocument->saveHTML($hall);
                        $hall = strip_tags($hall,'<u>');
                        if(strlen($hall)>1):
                        if(strpos((string)$hall, "imax") === false){ /**/ }else{ $hall = "IMAX"; }
                        if(strpos((string)$hall, "3D") === false){ /**/ }else{ $hall = "3D"; }
                        endif;
                        // return html CSS и т.д.
                        $hallArr[] = $hall;
                    }
                    $cinemaArr[] = ['TITLE'=>$cnn,'TIME'=>$shArr,'HALL'=>$hallArr];
                }
                //
                $fmArr[] = ['TITLE'=>$fmn, 'AGE'=>$age, 'DESCRIPTION'=>$fmInfoArr, 'CINEMA'=>$cinemaArr,];
            }
            //
            $filmArr[] = ['DATE'=>$showDate,'FILM'=>$fmArr];
        } // end FILMS
        $res = ['CITY'=>$headers,'SCHEDULE'=>$filmArr];
        //
        return $res;
    }

    public function executeComponent()
    {
        global $USER;
        if ($this->StartResultCache(false, array(($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()), $this->arParams, date("d/m/Y")), 'kino_page_parser')){
            //
            $kino_now_date = $this->acsKinoPageParser();
            if($kino_now_date){
                $this->arResult["KINO"] = $kino_now_date;
                // write everything to a file txt
                file_put_contents(dirname(__FILE__)."/kino_parser.txt", serialize($kino_now_date));
                $this->arResult['KINO_URL_CACHE'] = true;
            }else{
                // we deliver from a file
                $this->arResult["KINO"] = unserialize(file_get_contents(dirname(__FILE__)."/kino_parser.txt"));
                $this->arResult['KINO_URL_CACHE'] = false;
            }
            // If parsing is successful then we cache the data
            if($this->arResult['KINO_URL_CACHE']){
                $this->SetResultCacheKeys([
                    "KINO",
                ]);
            }else{
                // data is not cached
                $this->AbortResultCache();
            }
            $this->includeComponentTemplate();
        }
    }
}