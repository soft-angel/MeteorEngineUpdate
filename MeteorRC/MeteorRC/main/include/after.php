<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
if($USER->IsAdmin() and SHOW_DEBUG != "N"){
?>
<style type="text/css">
/* Debugging */
#meteor_debugging {
    position: fixed;
    bottom: 0;
    padding: 5px 15px;
    color: #fff;
    background-color: rgba(0,0,0,0.7);
    border-radius: 5px 5px 0px 0px;
    z-index: 10001;
}
#meteor_debugging p {
    margin: 1px 0;
    font-size: 10px;
    line-height: normal;
}
#meteor_debug_all {
    display: none;
}
#meteor_debugging_show {
    cursor: pointer;
}
</style>
<div id="meteor_debugging">
<p id="meteor_debugging_show">Время генерации страницы: <?=round((microtime(true) - OB_START), 5) . " сек.";?> <i class="fa fa-angle-double-up"></i></p>
	<div id="meteor_debug_all">
	<p>Запросов на запись в бд: <?=$APPLICATION->bdWriter?></p>
	<p>Запросов на чтение в бд: <?=$APPLICATION->bdCount?> (<?=ConvertFileSize($APPLICATION->bdSize)?>)</p>
	<p>Компонентов подключено: <?=$APPLICATION->ComponentCount?> (<?=$APPLICATION->ComponentCacheCount?>)</p>
	<p>Файлов подключено: <?=$APPLICATION->CountIncludeFile()?></p>
	<p>Система кеширования: <?=$CACHE->cacheType?></p>
	<p>RAM использовано: <?=ConvertFileSize(memory_get_usage() - OB_MEMERY_USAGE);?></p>
	<p>Ошибок: <?=$APPLICATION->ErrorCount?></p>
	<?//p(get_included_files())?>
	</div>
</div>
<script type="text/javascript">
	$("#meteor_debugging_show").click(function() {
	  $("#meteor_debug_all").toggle();
	});
</script>
<?}
$APPLICATION->IncludeComponent("MeteorRC:statistics.stata", "", Array(
        "COMPONENT" => "statistics",
        "IBLOCK" => "stata",  // Инфоблок
    ),
    false
);
?>