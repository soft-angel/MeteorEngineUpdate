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
$APPLICATION->AddHeadScript($templateFolder . "/script.js");

?>
					<div class="panel panel-inverse" id="meteor_timeline" data-sortable-id="index-<?=$arParams["COMPONENT"]?>-<?=$arParams["IBLOCK"]?>">
                        <div class="panel-heading">
                            <a href="/MeteorRC/admin/?component=<?=$arParams["COMPONENT"]?>&iblock=<?=$arParams["IBLOCK"]?>" class="pull-right label label-theme">Действий: <?=count($arResult)?></a>
                            <h4 class="panel-title">Последние действия</h4>
                        </div>
                        <div class="panel-body">
<?if($arResult){?>
<div id="timelineResult"></div>
<div class="slimScrollDiv" data-scrollbar="true" style="position: relative; overflow: hidden; width: auto; height: 306px;">
	<div class="list-group">
	<?foreach ($arResult as $key => $arElement) {?>
		<div class="list-group-item text-ellipsis">
		<?if($arElement['EVENT_ID'] != 'ADD' and isset($arElement['ELEMENT_BACKUP'])){?>
			<span title="Восстановить" class="badge bg-theme"><i style="cursor: pointer;" onclick="TimelineBackupRestore(this, <?=$arElement['ID']?>);" class="fa fa-undo" aria-hidden="true"></i></span>
		<?}?>
			<span>
				<a class="text-theme" href="/MeteorRC/admin/?component=<?=$arElement["COMPONENT"]?>&iblock=<?=$arElement["IBLOCK"]?>"><?=$arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]]["ICON"]?></a>
					<?=$arElement["EVENT"]?>: <?=$arElement["ELEMENT"]["NAME"]?>
			</span>
		</div>
	<?}?>
	</div>
</div>         
<?}?>
                        </div>
                    </div>