<?
class CWebdokaCacheAgent
{
    var $phrase_id = 0;
    var $_phrase = false;
    var $_tags = false;
    var $_session_id = "";
    var $_stat_sess_id = false;


    function __construct($phrase = "", $tags = "")
    {
        return $this->webdoka_cache($phrase, $tags);
    }
    function agentExecute()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec("rmdir /s /q ".$_SERVER['DOCUMENT_ROOT']."/bitrix/cache/");
            exec("rmdir /s /q ".$_SERVER['DOCUMENT_ROOT']."/bitrix/managed_cache/");
            exec("rmdir /s /q ".$_SERVER['DOCUMENT_ROOT']."/bitrix/stack_cache/");
        } else {
            exec("rm -rf ".$_SERVER['DOCUMENT_ROOT']."/bitrix/cache/");
            exec("rm -rf ".$_SERVER['DOCUMENT_ROOT']."/bitrix/managed_cache/");
            exec("rm -rf ".$_SERVER['DOCUMENT_ROOT']."/bitrix/stack_cache/");
        }
        AddMessage2Log("Add agent", "agentExecute");
        return "CWebdokaCacheAgent::agentExecute();";
    }
}


?>