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
//echo $APPLICATION->TimelineBackupRestore(1);
//p($arResult);
?>
<div id="timelineResult"></div>
            <ul class="timeline">
<?foreach($arResult as $id => $arElement){?>
                <li id="timelineElement_<?=$arElement['ID']?>">
                    <!-- begin timeline-time -->
                    <div class="timeline-time">
                        <span class="date"><?=rus_date("d F Y", $arElement["TIME"])?></span>
                        <span class="time"><?=date("H:i", $arElement["TIME"])?></span>
                    </div>
                    <!-- end timeline-time -->
                    <!-- begin timeline-icon -->
                    <div class="timeline-icon">
                        <a href="/MeteorRC/admin/?component=<?=$arElement["COMPONENT"]?>&iblock=<?=$arElement["IBLOCK"]?>"><?=$arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]]["ICON"]?></a>
                    </div>
                    <!-- end timeline-icon -->
                    <!-- begin timeline-body -->
                    <div class="timeline-body">
                        <div class="timeline-header">
                            <span class="userimage">
                                <img src="<?=$FILE->IblockResizeImageGet($arElement["USER"]['PERSONAL_PHOTO'], "users", 34, 34, 70, 'crop')?>" />
                            </span>
                            <a href="/MeteorRC/admin/?component=users&iblock=users&edit_element=<?=$arElement["USER_ID"]?>" class="username"><?=(isset($arElement["USER"]["NAME"]))?$arElement["USER"]["NAME"]:"SYSTEM"?></a>
                            <!--<span class="pull-right text-muted">1,021,282 Views</span>-->
                        </div>
                        <div class="timeline-content">
                            <h4 class="template-title">
                                <?=$arElement["EVENT"]?>: 
                                <?if(isset($arElement["ELEMENT_ID"])){?>
                                <a href="/MeteorRC/admin/?component=<?=$arElement["COMPONENT"]?>&iblock=<?=$arElement["IBLOCK"]?>&edit_element=<?=$arElement["USER_ID"]?>"><?=$arElement["ELEMENT"]["NAME"]?></a>
                                <?}else{?>
                                <?=$arElement["ELEMENT"]["NAME"]?>
                                <?}?>
                            </h4>
                            <?if(isset($arElement["ELEMENT"]["PREVIEW_PICTURE"])){?>
                            <p><?=htmlspecialchars_decode($arElement["ELEMENT"]["PREVIEW_TEXT"])?></p>
                            <?}?>
                            <?if(isset($arElement["ELEMENT"]["PREVIEW_PICTURE"])){
                                $iblock = ($arElement['EVENT_ID'] == 'DELL')?'timeline':$arElement['IBLOCK'];?>
                            <p class="m-t-20">
                                <img src="<?=$FILE->IblockResizeImageGet($arElement["ELEMENT"]['PREVIEW_PICTURE'], $iblock, 200, 200, 75, 'crop')?>" />
                            </p>
                            <?}?>
                        </div>
                        <?if($arElement['EVENT_ID'] != 'ADD' and isset($arElement['ELEMENT_BACKUP'])){?>
                        <div class="timeline-footer">
                            <button onclick="TimelineBackupRestore(this, <?=$arElement['ID']?>);" class="btn btn-theme btn-xs"><i class="fa fa-undo" aria-hidden="true"></i> Восстановить</button>
                        </div>
                        <?}?>
                    </div>
                    <!-- end timeline-body -->
                </li>
<?}?>
                <!--<li>
                    <div class="timeline-icon">
                        <a href="javascript:;"><i class="fa fa-spinner"></i></a>
                    </div>
                    <div class="timeline-body">
                        Загрузка...
                    </div>
                </li>-->

            </ul>