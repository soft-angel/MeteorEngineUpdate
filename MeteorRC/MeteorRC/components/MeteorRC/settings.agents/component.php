<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
function includeAgent($file)
{
	global $APPLICATION;
	global $CONFIG;
	global $USER;
	global $CACHE;
	global $FILE;
	global $FIREWALL;
	ob_clean();
	ob_start();
	include(DR . $file);
	$result = ob_get_contents();
	ob_end_clean();
	return $result;
}
set_time_limit ( 36000 );
ignore_user_abort(true);
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");
// Получаем массив с кронами
$arCron = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], false, false);
//p($arCron);
// Если есть кроны
if(count($arCron) > 0){
	// Перебираем кроны циклом
	foreach($arCron as $key => $agent){
		// Если пора опять запускать файл,
		$last_exec = isset($agent["LAST_EXEC"])?$agent["LAST_EXEC"]:0;
		if($agent["ACTIVE"] == "Y" and $last_exec < (time() - $agent["AGENT_INTERVAL"])){
			// то обновляем тайм
			$arCron[$key]["LAST_EXEC"] = time();
			// Если файл крона существует
			if(file_exists(DR . $agent["FILE"])){
				// то инклюдим его
				$result = includeAgent($agent["FILE"]);
			}else{
				// Если же нет на сервере, то выдаем ошибку и пишем ее в лог
				$result = 'Файл крона не найден :' . $agent["FILE"];
				$APPLICATION->ShowError($result, 'Cron', true);
			}
			$arCron[$key]["RESULT"] = $result;
			// и пишем новый тайм в бд
			$APPLICATION->SaveElementForIblock($arCron, $arParams["COMPONENT"], $arParams["IBLOCK"]);
		}
	}		
}
?>