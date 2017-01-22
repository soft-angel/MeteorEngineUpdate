<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");

global $APPLICATION;
global $USER;
$arRespond = array();
if($USER->IsAdmin()){
	if($id = $FIREWALL->GetNumber("id")){
		if($url = $APPLICATION->TimelineBackupRestore($id)){
			$arRespond["SUCCESS"] = 'Элемент id:<a href="' . $url . '">' . $id . '</a> восстановлен.';
		}else{
			$arRespond["ERROR"][] = 'Ошибка восстановления';
		}
	}
}else{
	$arRespond["ERROR"][] = "Ошибка доступа";
}
ob_clean();
die(json_encode($arRespond));