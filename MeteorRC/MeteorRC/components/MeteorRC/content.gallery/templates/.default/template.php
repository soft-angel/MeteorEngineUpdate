<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
if(isset($arResult["ELEMENTS"])){
?>
<?CJSCore::Init(array('fancybox'));?>
<div class="gallery" id="component_<?=$APPLICATION->GetComponentId()?>">
	<div class="row">
<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
    
    <div class="col-md-2 col-sm-3 col-xs-4">
    	<a class="fancybox" rel="group" href="<?=$FILE->GetUrlFile($arElement["PICTURE"], $arParams["IBLOCK"])?>" title="<?=$arElement["NAME"]?>" data-gallery>
    		<img class="img-responsive" src="<?=$FILE->IblockResizeImageGet($arElement["PICTURE"], $arParams["IBLOCK"], 200, 200, 75, 'crop')?>" />
		</a>
    </div>
<?}?>
	</div>
</div>
<?}?>