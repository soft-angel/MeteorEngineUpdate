<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$arResult = '';
$LogList = glob(LOG_DIR . "*.log");
if(count($LogList) > 0){
	foreach($LogList as $file){
		$arResult .= file_get_contents($file);
	}
}