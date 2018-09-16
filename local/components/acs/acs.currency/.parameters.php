<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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

$arComponentParameters = array(
	"PARAMETERS" => array(
		"CURR" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CURR"),
			"TYPE" => "LIST",
			"VALUES" => $arCurr,
			"MULTIPLE" => 'Y'
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);
