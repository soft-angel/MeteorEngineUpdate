<?
if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
$FILE = new FILE;
$arParams = $APPLICATION->GetFileArray(__DIR__ . '/.parametrs.php');
?>
<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li><a href="javascript:;">Панель управления</a></li>
                <li class="active"><?=$arParams["NAME"]?></li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header"><?=$arParams["NAME"]?> <small>Последние <?=isset($CONFIG["TIMELINE_CNT"])?$CONFIG["TIMELINE_CNT"]:30?> действий</small></h1>
            <!-- end page-header -->
            
            <!-- begin timeline -->
<?$APPLICATION->IncludeComponent("MeteorRC:statistics.timeline", "", Array(
        "COMPONENT" => "statistics",
        "IBLOCK" => "timeline",  // Инфоблок
        "CACHE_TYPE" => "N",    // Тип кеширования
        "CACHE_TIME" => "36000000", // Время кеширования (сек.)
        "CACHE_FILTER" => "Y",  // Кешировать при установленном фильтре
        "CACHE_GROUPS" => "Y",  // Учитывать права доступа
    ),
    false
);?>
            <!-- end timeline -->
        </div>
        <!-- end #content -->