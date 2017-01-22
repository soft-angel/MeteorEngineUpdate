<?
require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
$UPDATE = new UPDATE;

$oldVersion = $UPDATE->getVersion();

if($UPDATE->Go()){

	$CEvent = new CEvent;
	$arSend = array(
		'VERSION' => $UPDATE->GetUpdateVersion(),
		'OLD_VERSION' => $oldVersion,
		'DATE' => date('d.m.Y H:i:s'),
		'INFO' => $UPDATE->GetUpdateInfo(),
	);
	$CEvent->Send("UPDATE", $arSend);
}