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
//$APPLICATION->AddHeadScript($templateFolder . "/script.js");
?>

<?if(isset($arResult)){?>
<?//p( $arParams)?>
<div id="deliveryPrice">
<?foreach ($arResult as $id => $arDelivery) {
	if(isset($arDelivery['PRICE_FREE']) and $arDelivery['PRICE_FREE'] < $arParams["TOTAL_PRICE"]){
		$arDelivery["PRICE"] = 0;
	}
	?>
	<div>
		<div class="radio">
			<label>
				<input data-price="<?=isset($arDelivery["PRICE"])?$arDelivery["PRICE"]:0?>" type="<?if($arParams["MULTY"] != "Y"){?>radio<?}else{?>checkbox<?}?>" name="ORDER[DELIVERY_SYSTEM_ID]" id="optionsRadios<?=$arDelivery["ID"]?>" value="<?=$arDelivery["ID"]?>" <?if(isset($arDelivery["DEFAULT"]) and $arDelivery["DEFAULT"] == "Y"){?>checked=""<?}?>>
				<?=$arDelivery["NAME"]?> <?if($arDelivery["PRICE"] > 0){?>(<?=$arDelivery["PRICE"]?> <small class="fa fa-rub"></small>)<?}?>
			</label>
		</div>
	</div>
<?}?>
</div>
<?}?>