<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
?>
<?
$arResult = array_reverse($APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], false, false));
foreach ($arResult as $id => $arElement) {
	if(isset($arElement["USER_ID"])){
		$arResult[$id]["USER"] = $APPLICATION->GetElementForID("users", "users", $arElement["USER_ID"]);
	}
	if(isset($arElement["ELEMENT_ID"])){
		$arResult[$id]["ELEMENT_BD"] = $APPLICATION->GetElementForID($arElement["COMPONENT"], $arElement["IBLOCK"], $arElement["ELEMENT_ID"]);
	}
	// Полчаем параметры компонента
	if(!isset($arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]])){
			$arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]] = $APPLICATION->GetComponentsParams($arElement["COMPONENT"], $arElement["IBLOCK"]);
	}
}
?>
