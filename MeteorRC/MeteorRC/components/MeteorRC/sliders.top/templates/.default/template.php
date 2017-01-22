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
//$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");

?>
<div id="component_<?=$APPLICATION->GetComponentId()?>">
<div id="carousel-home" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
<?
$active_o = 0;
foreach($arResult["ELEMENTS"] as $arItem){?>
        <li data-target="#carousel-home" data-slide-to="<?=$active_o?>" class="<?if(empty($active_o)){?>active<?}$active_o++;?>"></li>
<? }?>
    </ol>
    <div class="carousel-inner" role="listbox">
<?foreach($arResult["ELEMENTS"] as $arItem){?>
    <div class="item<?if(!$active){?> active<?$active = true;}?>">
<? if($arItem['LINK']){ ?><a href="<?=$arItem['LINK'];?>"><? } ?>
        <img src="/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=<?=$FILE->GetUrlFile($arItem["PICTURE"], $arParams["IBLOCK"])?>&amp;w=1300&amp;h=550&amp;zc=1&amp;q=100" alt="<?=$arItem["NAME"]?>" data-holder-rendered="true">
<? if($arItem['LINK']){ ?></a><? } ?>
      </div>
<? }?>
        <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
</div>
</div>