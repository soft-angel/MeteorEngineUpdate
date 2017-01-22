<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
$arExclude = array(
	'/MeteorRC/components/MeteorRC/settings.scaner/signature_reg.php',
	'/MeteorRC/components/MeteorRC/map.yandex.view/templates/.default/template.php',
	'/MeteorRC/components/MeteorRC/settings.scaner/signature.php',
	'/MeteorRC/bd/settings/scaner.php',
	'/MeteorRC/bd/settings/fasset/scaner/matches.php',
);

$arParams = $APPLICATION->GetComponentsParams('settings', 'scaner');
$arElements = $APPLICATION->GetElements($arParams['COMPONENT'], $arParams['IBLOCK']);


$FILE = new $FILE;
$arSignature = include(__DIR__ . "/signature_reg.php");

$aMask = array("*.js");
include("signature.php");
$signatures = getSignatures();

$fileList = $FILE->GetFileList();

$countFile = count($fileList);


function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
function checkSpacesCnt($str){
  if(!is_string($str)) return false;
  foreach (multiexplode(array(PHP_EOL,'\n','\r\n', ' '), $str) as $key => $value) {
      if(500 < strlen($value))
        return $value;
  }

  return false;
}


$i = 0;
$arResult = array();
foreach ($fileList as $id => $file) {
		
		if(!file_exists($file["patch"]) or $file["size"] > 500 * 1024)
			continue;
		$i++;
		$content = file_get_contents($file["patch"]);

		foreach ($arSignature as $signature) {
			if($signature["f"] == "filename")continue;
				if ($pos = preg_match($signature["s"], $content, $matches)) {
						$arResult[$id]["desc"] = $signature["d"];
						$arResult[$id]["patch"] = str_replace(DR, '', $file['patch']);
						$arResult[$id]["id"] = $id;
						if(isset($signature["l"]))
							$arResult[$id]["color"] = $signature["l"];
						if(isset($matches[0]))
							$arResult[$id]["matches"][] = $matches[0];

						if(in_array($arResult[$id]["patch"], $arExclude)){
							$arResult[$id]["SEND"] = "N";
						}
				}

		}
		unset($content, $pos);
}
$bodyMesage = array();
$arColors = array(
	'warning' => 'orange',
	'danger' => 'red',
);
$count = 0;
foreach ($arResult as $id => &$arElement) {
	if(!isset($arElements[$id])){
		$arElement['NEW'] = 'Y';
		if(isset($arElement['SEND']) and $arElement['SEND'] == "N"){
			continue;
		}
		$count++;
		$color = strtr($arElement['color'], $arColors);
		
		$arMesage['VIRUS_LIST'] .= "<div style=\"border: {$color} 2px dashed;padding: 5px 15px;margin-bottom: 15px;\">";
		$arMesage['VIRUS_LIST'] .= "<h4>{$arElement['patch']}</h4>";
		$arMesage['VIRUS_LIST'] .= "<p>{$arElement['desc']}</p>";
		if(is_array($arElement['matches']) and count($arElement['matches']) > 0){
			$arMesage['VIRUS_LIST'] .= '<ul>';
			foreach ($arElement['matches'] as $vir) {
				$vir = htmlspecialchars($vir);
				$arMesage['VIRUS_LIST'] .= "<li>{$vir}</li>";
			}
			$arMesage['VIRUS_LIST'] .= '</ul>';
		}
		
		$arMesage['VIRUS_LIST'] .= '</div>';
	}
}
if(isset($arMesage['VIRUS_LIST'])){
	$arMesage["COUNT"] = $count;
	$CEvent = new CEvent;
	$CEvent->Send("NEW_VIRUS", $arMesage);
}
echo 'Найдено ' . $count . ' новых зараженных файлов';
$APPLICATION->SaveElementsArray($arResult, $arParams['COMPONENT'], $arParams['IBLOCK'], false);
?>