<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");

global $APPLICATION;
global $USER;
if($USER->IsAdmin()){
	if($component = $FIREWALL->GetString("component") and $iblock = $FIREWALL->GetString("iblock") and $id = $FIREWALL->GetNumber("id")){
		$arElment = $APPLICATION->GetElementForID($component, $iblock, $id);
		$arParams = $APPLICATION->GetComponentsParams($component, $iblock);
		if(isset($arParams["EVENTS"]["TEXT"]["DELL"])){
			$APPLICATION->TimelineAdd($arParams, $arElment, 'DELL');
		}
		if($APPLICATION->DeleteElementForID($component, $iblock, $id)){
			$arRespond["SUCCESS"] = "Элемент id:" . $id . ' удален.';
		}else{
			$arRespond["ERROR"][] = "Ошибка удаления";
		}
	}
}else{
	$arRespond["ERROR"][] = "Ошибка доступа";
}
ob_clean();
die(json_encode($arRespond));