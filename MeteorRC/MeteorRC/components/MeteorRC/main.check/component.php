<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$arResult = array();
function convertPHPSizeToBytes($sSize)  
{  
    if ( is_numeric( $sSize) ) {
       return $sSize;
    }
    $sSuffix = substr($sSize, -1);  
    $iValue = substr($sSize, 0, -1);  
    switch(strtoupper($sSuffix)){  
    case 'P':  
        $iValue *= 1024;  
    case 'T':  
        $iValue *= 1024;  
    case 'G':  
        $iValue *= 1024;  
    case 'M':  
        $iValue *= 1024;  
    case 'K':  
        $iValue *= 1024;  
        break;  
    }  
    return $iValue;  
}  

function getMaximumFileUploadSize(&$arResult)  
{
	$arResult['MAX_FILE_UPLOAD_SIZE']['NAME'] = 'Лимит на размер загружаемых файлов';
	$uploadMaxFilesize = min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));
	$arResult['MAX_FILE_UPLOAD_SIZE']['STATUS'] = ($uploadMaxFilesize > 16777216)?"Y":"N";
	$arResult['MAX_FILE_UPLOAD_SIZE']['STANDART'] = 'не менее 16 Мб';
	$arResult['MAX_FILE_UPLOAD_SIZE']['REAL'] = ConvertFileSize($uploadMaxFilesize, 0);
}
function getMemoryLimit()  
{
	return convertPHPSizeToBytes(ini_get('memory_limit'));  
}
function TestSession()  
{	
	session_start('test');
	$_SESSION['TEST'] = 0;
	$_SESSION['TEST']++;
	return ($_SESSION['TEST'] > 0)?"Y":"N";  
}
function TestMail()  
{	
	if(mail('test@soft-angel.ru','Тестирование mail()','Проверка функции mail() на сервере')){
		return "Y";
	}else{
		return "N";
	}
}
function TestUpdateServer(&$arResult)  
{	
	global $APPLICATION;
	$arResult['UPDATE_SERVER']['NAME'] = 'Доступ к серверу обновлений';
	$UPDATE = new UPDATE;
	$updateVersion = $UPDATE->GetUpdateVersion();
	if($updateVersion > 0){
		$arResult['UPDATE_SERVER']['STATUS'] = "Y";
	}else{
		$arResult['UPDATE_SERVER']['STATUS'] = "N";
	}
	$arResult['UPDATE_SERVER']['STANDART'] = $updateVersion;
	$arResult['UPDATE_SERVER']['REAL'] = $APPLICATION->version;
}
function GetExtensionPHP($extension)  
{	
	return extension_loaded($extension)?"Y":"N";
}

getMaximumFileUploadSize($arResult);

$arResult['MEMORY_LIMIT'] = array(
	'STATUS' => 'Y', 
	'REAL' => ConvertFileSize(getMemoryLimit(), 0),
	'STANDART' => 'не менее 64 Мб',
	'NAME' => 'Фактическое ограничение памяти',
);
$arResult['SESSIONS'] = array(
	'STATUS' => TestSession(),
	'NAME' => 'Запись сессии',
);
$arResult['MBSTRING_ENCODING'] = array(
	'STATUS' => 'Y', 
	'REAL' => ini_get('mbstring.internal_encoding'),
	'STANDART' => 'UTF-8',
	'NAME' => 'Кодировка сервера',
);
$arResult['MBSTRING_FUNC_OVERLOAD'] = array(
	'STATUS' => 'Y', 
	'REAL' => ini_get('mbstring.func_overload'),
	'STANDART' => '2',
	'NAME' => '',
);
$arResult['MAIL'] = array(
	'STATUS' => TestMail(),
	'NAME' => 'Отправка почты',
);

TestUpdateServer($arResult);

$arResult['PHP_ZIP'] = array(
	'STATUS' => GetExtensionPHP('zip'),
	'NAME' => 'Наличие PHP библиотеки "zip"',
);
$arResult['PHP_APCU'] = array(
	'STATUS' => GetExtensionPHP('apcu'), 
	'NAME' => 'Наличие PHP библиотеки "apcu"',
);
$arResult['PHP_IMAGICK'] = array(
	'STATUS' => GetExtensionPHP('imagick'),
	'NAME' => 'Наличие PHP библиотеки "imagick"',
);
$arResult['PHP_GD'] = array(
	'STATUS' => GetExtensionPHP('gd'), 
	'NAME' => 'Наличие PHP библиотеки "gd"',
);
$arResult['PHP_JSON'] = array(
	'STATUS' => GetExtensionPHP('json'), 
	'NAME' => 'Наличие PHP библиотеки "json"',
);
$arResult['PHP_MCRYPT'] = array(
	'STATUS' => GetExtensionPHP('mcrypt'),
	'NAME' => 'Наличие PHP библиотеки "mcrypt"',
);


