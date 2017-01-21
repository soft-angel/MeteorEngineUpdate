<?
define('DR', dirname(__FLE__));
define('DS', DIRECTORY_SEPARATOR);
function p($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
global $fileList;
// Генерация, сохранение и получение списка файлов
function GenerateFileList($folder){
		global $fileList;
		$fp = opendir($folder);
		while($cv_file = readdir($fp)) {
			if(is_file($folder . "/" . $cv_file)) {
				$fileList[] = $folder."/".$cv_file;
			}elseif($cv_file != "." && $cv_file != ".." && is_dir($folder."/".$cv_file)){
				GenerateFileList($folder . "/" . $cv_file);
			}
		}
		closedir($fp);
}

GenerateFileList(DR . '/MeteorRC');
//p($fileList);



if(!extension_loaded('zip')){
	die("В php не установлена библиотека \"zip\"");
}else{
	$zip = new ZipArchive();
	$backupName = "MeteorRC.zip";
	if($zip->open($backupName, ZIPARCHIVE::CREATE)!== TRUE){
		die("Sorry ZIP creation failed at this time");
	}

	foreach ($fileList as $id => $file) {
			$rootFileName = str_replace(DR . '/MeteorRC', "", $file);
			$zip->addFile($file, $rootFileName);
	}
	$zip->close();
}