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
if($arResult){
?>
	<!-- begin panel -->
	<div class="panel panel-inverse" id="meteor_timeline" data-sortable-id="index-<?=$arParams["COMPONENT"]?>-<?=$arParams["IBLOCK"]?>">
		<div class="panel-heading">
			<a href="/MeteorRC/admin/?component=settings&iblock=scaner" class="pull-right label label-theme"><i class="fa fa-search"></i> Сканировать</a>
			<h4 class="panel-title">Firewall</h4>
		</div>
		<div class="panel-body" style="height: 336px;">
			<div style="margin: 15px 0" class="text-center">
				<i class="fa fa-shield fa-5x text-theme"></i>
			</div>
			<div class="list-group">
				<div class="list-group-item text-ellipsis">
					<span class="badge bg-theme"><?=(isset($arResult['URI']))?$arResult['URI']:0?></span>
					<span>Отражено попыток взлома:</span>
				</div>
				<div class="list-group-item text-ellipsis">
					<span class="badge bg-theme"><?=(isset($arResult['BD']))?$arResult['BD']:0?></span>
					<span>Попытки вторжения в базу:</span>
				</div>
				<div class="list-group-item text-ellipsis">
					<span class="badge bg-theme"><?=(isset($arResult['XSS']))?$arResult['XSS']:0?></span>
					<span>Отражено XSS атак:</span>
				</div>
				<div class="list-group-item text-ellipsis">
					<span class="badge bg-theme"><?=(isset($arResult['UPLOAD']))?$arResult['UPLOAD']:0?></span>
					<span>Попытки подгрузки вирусов:</span>
				</div>
			</div>
		</div>
	</div>
<?}?>