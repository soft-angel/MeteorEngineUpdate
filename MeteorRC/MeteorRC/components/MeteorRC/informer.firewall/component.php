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
$arResult = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], false, false);
?>
