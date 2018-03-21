<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!\Bitrix\Main\Loader::includeModule('iblock'))
return;

Loc::loadMessages(__FILE__);

class AcsCurrencyClassAdd extends \CBitrixComponent
{
    //
    public function getCurrencyDay($day)
    {
        $strQueryText = QueryGetData("www.cbr.ru", 80, "/scripts/XML_daily.asp?date_req=" . $day);

        if (strlen($strQueryText) <= 0) {
            $result = false;
        } else {
            //
            $objXML = new CDataXML();
            $objXML->LoadString($strQueryText);
            if ($arData = $objXML->GetArray()) {
                //AddMessage2Log("\n" . var_export($day, true) . " \n \r\n ", "day");
                //AddMessage2Log("\n" . var_export($arData, true) . " \n \r\n ", "arData");
                $result = array();
                foreach ($arData['ValCurs']['#']['Valute'] as $arValue) {
                    $ar = array();
                    foreach ($arValue['#'] as $sKey => $sVal) {
                        if (SITE_CHARSET != "windows-1251")
                            $sVal[0]['#'] = iconv("windows-1251", SITE_CHARSET, $sVal[0]['#']);
                        if ($sKey == 'Value')
                            $sVal[0]['#'] = str_replace(',', '.', $sVal[0]['#']);
                        $ar[$sKey] = $sVal[0]['#'];
                    }

                    $result[$ar['CharCode']] = $ar;
                }

            } else {
                $result = false;
            }  // end $arData
        }
        return $result;
    }

    // запись xml файла валюты и т.д.
    public function getCurrencyDayAddFiles($resultArr, $dateAdd = Null, $path = Null)
    {
        $path = ($path ? $path : $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/acs/acs.currency/acs_currency.xml"); // куда пишем
        $dateAdd = ($dateAdd ? $dateAdd : date("d/m/Y"));
        if (count($resultArr) > 0) {
            $resultFiles = true;
            // формируем xml
            $xml = new DomDocument('1.0', 'utf-8');
            $acs_currency = $xml->appendChild($xml->createElement('acs-currency'));
            $acs_currency->appendChild($xml->createElement('creation-date', date('Y-m-d H:i:s T', time())));
            $acs_currency->appendChild($xml->createElement('host', $_SERVER[HTTP_HOST]));
            $ValCurs = $acs_currency->appendChild($xml->createElement('ValCurs'));
            foreach ($resultArr as $k => $vc) {
                $Valute = $ValCurs->appendChild($xml->createElement('Valute'));
                $Valute->setAttribute('ID', $vc['NumCode']);
                foreach ($vc as $ky => $valID) {
                    $Valute->appendChild($xml->createElement($ky, $valID));
                }
            }
            $xml->formatOutput = true;
            $xml->save($path);

        } else {
            $resultFiles = false;
        }
        return $resultFiles;
    }

    //
    public function toReadCurrencyDayFiles($path = Null){
        $resultArr = array();
        $path = ($path ? $path : $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/acs/acs.currency/acs_currency.xml"); // откуда читаем
        $reader = simplexml_load_file($path);
        // AddMessage2Log("\n" . var_export($reader->getName(), true) . " \n \r\n ", "reader");
        // AddMessage2Log("\n" . var_export($reader, true) . " \n \r\n ", "reader");
        if ($reader && 'acs-currency' == $reader->getName()) {
            $reader = $reader->ValCurs->children();
            // AddMessage2Log("\n" . var_export($reader, true) . " \n \r\n ", "reader");
            if(count($reader)>0) {
                foreach ($reader as $rv) {
                    // AddMessage2Log("\n" . var_export($rv, true) . " \n \r\n ", "rv");
                    $resultArr[(string)$rv->CharCode] = array(
                        'NumCode' => (string)$rv->NumCode,
                        'CharCode' => (string)$rv->CharCode,
                        'Nominal' => (string)$rv->Nominal,
                        'Name' => (string)$rv->Name,
                        'Value' => (string)$rv->Value,
                    );
                }
            }

            // AddMessage2Log("\n" . var_export($resultArr, true) . " \n \r\n ", "resultArr");
        }
        return $resultArr;
    }
}