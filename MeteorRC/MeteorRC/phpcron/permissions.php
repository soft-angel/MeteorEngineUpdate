<?
require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");

$arFolder = array(
	'/MeteorRC/backups' => array('DIR' => '0775', 'FILE' => '0664'),
	'/MeteorRC/bd' => array('DIR' => '0770', 'FILE' => '0660'),
	'/MeteorRC/cache' => array('DIR' => '0775', 'FILE' => '0664'),
	'/MeteorRC/images' => array('DIR' => '0775', 'FILE' => '0664'),
	'/MeteorRC/include' => array('DIR' => '0770', 'FILE' => '0660'),
	'/MeteorRC/logs' => array('DIR' => '0770', 'FILE' => '0660'),
	'/MeteorRC/upload' => array('DIR' => '0775', 'FILE' => '0664')
);
foreach ($arFolder as $dir => $arPerm) {
	exec('find ' . DR . $dir . ' -type d -exec chmod ' . $arPerm['DIR'] . ' {} +');
	exec('find ' . DR . $dir . ' -type f -exec chmod ' . $arPerm['FILE'] . ' {} +');
}


//exec ("find /path/to/folder -type f -exec chmod 0644 {} +");