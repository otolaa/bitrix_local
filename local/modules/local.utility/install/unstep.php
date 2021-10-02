<?if(!check_bitrix_sessid()) return;

echo CAdminMessage::ShowNote("Вспомогательный модуль успешно удален из системы"); ?>

<form action="<? echo($APPLICATION->GetCurPage()); ?>">
    <input type="hidden" name="lang" value="<? echo(LANG); ?>" />
    <input type="submit" value="Вернуться в список">
</form>
