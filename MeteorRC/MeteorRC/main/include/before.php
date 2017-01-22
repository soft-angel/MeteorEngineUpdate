<?
session_start();
date_default_timezone_set ( 'Europe/Moscow' );
define('OB_START', microtime(true));
define('OB_MEMERY_USAGE', memory_get_usage());

define('DR', $_SERVER["DOCUMENT_ROOT"]);
define('DS', DIRECTORY_SEPARATOR);
define('PROLOG_INCLUDED', true);
// Пишем лог ошибок php
ini_set('log_errors', 'On'); 
ini_set('log_errors_max_len', 1024);
ini_set('error_log', DR . "/MeteorRC/logs/" . date("m_d_y") . "_php.log");


define('CACHE_RESIZE', "/MeteorRC/cache/resizecache/");
define('CACHE_PATCH', DR . "/MeteorRC/cache/arraycache/");
define('FOLDER_CSS_MIN', "/MeteorRC/cache/css");
define('FOLDER_JS_MIN', "/MeteorRC/cache/js");

define("STATA_PATCH", DR . "/MeteorRC/bd/statistics/stata");


require_once(DR . "/MeteorRC/main/helper.php");
require_once(DR . "/MeteorRC/main/application.php");
// DIR
defined("NAME_TEMPLATE") || define("NAME_TEMPLATE", '.default');
defined("SHOW_DEBUG") || define("SHOW_DEBUG", 'Y');
define('SFX_BD', ".php");

define('CRON_FILE', DR . "/MeteorRC/bd/phpcron/cron" . SFX_BD);
define('FIREWALL_FILE', DR . "/MeteorRC/bd/firewall/firewall" . SFX_BD);
define('LOG_DIR', DR . "/MeteorRC/logs/");
define('LOG_FILE', LOG_DIR . date("m_d_y") . "_log.log");
define('LICENSE_KEY_FILE', DR . "/MeteorRC/key.php");

define('FOLDER_BD', DR . "/MeteorRC/bd/");
define('FOLDER_BACKUPS', "/MeteorRC/backups");
define('PATCH_BACKUPS', DR . FOLDER_BACKUPS);
define('FOLDER_STATA_BD', DR . "/MeteorRC/bd/stata/");
define('FOLDER_FILE_BD', DR . "/MeteorRC/bd/file/");
define('SEND_LOG_FILE', DR . "/MeteorRC/bd/log/send" . SFX_BD);
define('FILELIST_BD', FOLDER_BD . "filelist/filelist" . SFX_BD);


define('CONFIG_FILE', DR . "/MeteorRC/config.php");
define('SITE_COMPONENTS_PATH', "/MeteorRC/components/");
define('SITE_TEMPLATE_PATH', "/MeteorRC/template/" . NAME_TEMPLATE . DS);
define('TEMPLATE_PATH', DR . "/MeteorRC/template/" . NAME_TEMPLATE . DS);

$CACHE = new CACHE;
$APPLICATION = new APPLICATION;

$CONFIG = $APPLICATION->CONFIG;

// маска для создания файлов
define('FILE_PERMISSIONS', (isset($CONFIG['FILE_PERMISSIONS']))?octdec((int)$CONFIG['FILE_PERMISSIONS']):0775);
define('DIR_PERMISSIONS', (isset($CONFIG['DIR_PERMISSIONS']))?octdec((int)$CONFIG['DIR_PERMISSIONS']):0764);

// Режим отладки, если необходимо
if(isset($CONFIG['DEBUG']) and $CONFIG['DEBUG'] == 'Y'){
	// Включаем отображение ошибок
	ini_set('error_reporting', E_ALL);
	//ini_set('error_reporting', E_ALL & ~E_NOTICE);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}else{
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}

// Проверяем и пишем домен в конфиг
if(!isset($_SERVER['HTTP_HOST']) or $_SERVER['HTTP_HOST'] != $CONFIG['HTTP_HOST']){
	$CONFIG['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$APPLICATION->ArrayWriter($CONFIG, CONFIG_FILE);
}


if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { 
	$protocol = 'https';
}else{
	$protocol = 'http';
}
if(!isset($CONFIG['HTTP_HOST']) or $protocol != $CONFIG['HTTPS']){ 
	$CONFIG['HTTPS'] = $protocol;
	$APPLICATION->ArrayWriter($CONFIG, CONFIG_FILE);
}


$FIREWALL = new FIREWALL;
// Старт класса и запуск функции URI защиты
$FIREWALL->ProtectedUrl();

$USER = new USER;
$FILE = new FILE;

global $FILE;
global $APPLICATION;
global $FIREWALL;
global $CONFIG;
global $USER;
global $CACHE;


$APPLICATION->AddHeadScript("/MeteorRC/js/core.js", false);
?>