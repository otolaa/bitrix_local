<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arCurr['AUD'] = GetMessage('AUD');
$arCurr['AZN'] = GetMessage('AZN');
$arCurr['AMD'] = GetMessage('AMD');
$arCurr['BYR'] = GetMessage('BYR');
$arCurr['BGN'] = GetMessage('BGN');
$arCurr['BRL'] = GetMessage('BRL');
$arCurr['HUF'] = GetMessage('HUF');
$arCurr['KRW'] = GetMessage('KRW');
$arCurr['DKK'] = GetMessage('DKK');
$arCurr['USD'] = GetMessage('USD');
$arCurr['EUR'] = GetMessage('EUR');
$arCurr['INR'] = GetMessage('INR');
$arCurr['KZT'] = GetMessage('KZT');
$arCurr['CAD'] = GetMessage('CAD');
$arCurr['KGS'] = GetMessage('KGS');
$arCurr['CNY'] = GetMessage('CNY');
$arCurr['LVL'] = GetMessage('LVL');
$arCurr['LTL'] = GetMessage('LTL');
$arCurr['MDL'] = GetMessage('MDL');
$arCurr['RON'] = GetMessage('RON');
$arCurr['TMT'] = GetMessage('TMT');
$arCurr['NOK'] = GetMessage('NOK');
$arCurr['PLN'] = GetMessage('PLN');
$arCurr['XDR'] = GetMessage('XDR');
$arCurr['SGD'] = GetMessage('SGD');
$arCurr['TJS'] = GetMessage('TJS');
$arCurr['TRY'] = GetMessage('TRY');
$arCurr['UZS'] = GetMessage('UZS');
$arCurr['UAH'] = GetMessage('UAH');
$arCurr['GBP'] = GetMessage('GBP');
$arCurr['CZK'] = GetMessage('CZK');
$arCurr['SEK'] = GetMessage('SEK');
$arCurr['CHF'] = GetMessage('CHF');
$arCurr['ZAR'] = GetMessage('ZAR');
$arCurr['JPY'] = GetMessage('JPY');

$arStyle['ic'] = 'ic';
$arStyle['cbr'] = 'cbr';


$arComponentParameters = array(
	"GROUPS" => array(
		"KR_CUR" => array(
			"NAME" => GetMessage("KR_CUR"),
		),
	),
	"PARAMETERS" => array(
		"CURR" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CURR"),
			"TYPE" => "LIST",
			"VALUES" => $arCurr,
			"MULTIPLE" => 'Y'
		),
		"STYLE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("STYLE"),
			"TYPE" => "LIST",
			"VALUES" => $arStyle,
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		"DIGITS" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("DIGITS"),
			"TYPE" => "STRING",
			"DEFAULT" => 4,
		),
		"DELIMITER" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("DELIMITER"),
			"TYPE" => "STRING",
			"DEFAULT" => '.',
		),
		"DATE_FORMAT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("DATE_FORMAT"),
			"TYPE" => "STRING",
			"DEFAULT" => 'd.m.Y',
		),
		"COUNT_KR" => Array(
			"PARENT" => "KR_CUR",
			"NAME" => GetMessage("COUNT_KR"),
			"TYPE" => "STRING",
			"DEFAULT" => "1",
			"REFRESH" => 'Y',
		),
	),
);

if(count(intval($arCurrentValues["COUNT_KR"]))>0):
	for($i = 0; $i < (intval($arCurrentValues["COUNT_KR"])); $i++):
	$arComponentParameters["GROUPS"]["KR_CUR_".$i]["NAME"] = (GetMessage("KR_CUR")." ".($i+1));
		$arComponentParameters["PARAMETERS"]["VAL_".$i."_1"] = array(
			"PARENT" => "KR_CUR_".$i,
			"NAME" => GetMessage("VAL_1"),
			"TYPE" => "LIST",
			"VALUES" => $arCurr,
			"DEFAULT" => 'EUR'
		);
		$arComponentParameters["PARAMETERS"]["VAL_".$i."_2"] = array(
			"PARENT" => "KR_CUR_".$i,
			"NAME" => GetMessage("VAL_2"),
			"TYPE" => "LIST",
			"VALUES" => $arCurr,
			"DEFAULT" => 'USD'
		);
	endfor;
endif;

?>
