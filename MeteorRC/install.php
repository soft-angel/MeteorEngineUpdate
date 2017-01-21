<?
require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
global $APPLICATION;
// Добавление агента автообновлений
$fileAgent = '/MeteorRC/phpcron/update.php';
$arElement = array (
	'ACTIVE' => 'Y',
	'FILE' => $fileAgent,
	'AGENT_INTERVAL' => '86400',
	'DESCRIPTION' => 'Автоматическоее обновление',
	'ACTIVE_TIME' => time(),
);
$APPLICATION->SaveElementForField('settings', 'agents', $arElement, array('FILE' => $fileAgent), true);
// 

// Добавление агента доступов
$fileAgent = '/MeteorRC/phpcron/permissions.php';
$arElement = array (
	'ACTIVE' => 'Y',
	'FILE' => $fileAgent,
	'AGENT_INTERVAL' => '172800',
	'DESCRIPTION' => 'Проверка и исправление доступов файлов',
	'ACTIVE_TIME' => time(),
);
$APPLICATION->SaveElementForField('settings', 'agents', $arElement, array('FILE' => $fileAgent), true);
// 

// Добавление почтового события обновлений
$fileUnic = 'UPDATE';
$arElement = array (
	'ACTIVE' => 'Y',
	'EVENT_NAME' => $fileUnic,
	'NAME' => 'Уведомление автоматического обновления',
	'ACTIVE_TIME' => time(),
);
$eventID = $APPLICATION->SaveElementForField('settings', 'event', $arElement, array('EVENT_NAME' => $fileUnic), true);
// 
// Добавление почтового шаблона обновлений
$arElement = array (
    'ACTIVE' => 'Y',
    'SUBJECT' => 'CMS MeteorEngine - Установлено обновление v#VERSION#',
    'EVENT_ID' => $eventID,
    'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
    'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
    'BODY_TYPE' => 'text/html',
    'MESSAGE' => 'Обновление системы прошло успешно, новая версия #VERSION#<br><br>
Нововведения в этом выпуске: #INFO#
',
  );
$APPLICATION->SaveElementForField('settings', 'message', $arElement, array('SUBJECT' => 'CMS MeteorEngine - Установлено обновление v#VERSION#'), true);
// 



// Добавление почтового события уведомления о вирусах
$fileUnic = 'NEW_VIRUS';
$arElement = array (
	'ACTIVE' => 'Y',
	'EVENT_NAME' => $fileUnic,
	'NAME' => 'Найдены новые вирусы на сайте',
	'ACTIVE_TIME' => time(),
);
$eventID = $APPLICATION->SaveElementForField('settings', 'event', $arElement, array('EVENT_NAME' => $fileUnic), true);
// 
// Добавление почтового шаблона уведомления о вирусах
$arElement = array (
    'ACTIVE' => 'Y',
    'SUBJECT' => 'CMS MeteorEngine - Найдены новые вирусы на сайте - #SITE_NAME#',
    'EVENT_ID' => $eventID,
    'EMAIL_FROM' => 'scaner@meteorengine.ru',
    'EMAIL_TO' => 'scaner@meteorengine.ru',
    'BODY_TYPE' => 'text/html',
    'MESSAGE' => '<p>На сайте обнаружено #COUNT# новых зараженных файлов, пожалуйста проверьте содержимое файлов или обратитесь за помощью к разработчику.</p>
    <h3>Список зараженных файлов:</h3>
    <br>
    #VIRUS_LIST#',
);
$APPLICATION->SaveElementForField('settings', 'message', $arElement, array('SUBJECT' => 'CMS MeteorEngine - Найдены новые вирусы на сайте - #SITE_NAME#'), true);
// 

// Добавление агента сканера
$fileAgent = '/MeteorRC/components/MeteorRC/settings.scaner/go_scaner_agent.php';
$arElement = array (
	'ACTIVE' => 'Y',
	'FILE' => $fileAgent,
	'AGENT_INTERVAL' => '259200',
	'DESCRIPTION' => 'Запуск сканирования антивирусом',
	'ACTIVE_TIME' => time(),
);
$APPLICATION->SaveElementForField('settings', 'agents', $arElement, array('FILE' => $fileAgent), true);
// 


unlink(__FILE__);