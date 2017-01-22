<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	ini_set('upload_max_filesize','32M');
	ini_set('post_max_size','32M');
	if (empty($_FILES['FILES'])) {
	    echo json_encode(array('error' => 'Нет файлов для загрузки')); 
	    return;
	}
	$savePath = empty($_POST['patch'])?false:$_POST['patch'];
	$arFiles = $_FILES['FILES'];
	$success = null;
	$paths= array();
	$filenames = $arFiles['name'];

	for($i=0; $i < count($filenames); $i++){
	    $target = $_SERVER["DOCUMENT_ROOT"] . $savePath . DS . $filenames[$i];
		if(!file_exists($_SERVER["DOCUMENT_ROOT"] . $savePath))
			mkdir($_SERVER["DOCUMENT_ROOT"] . $savePath, 0775, true);
	    if(move_uploaded_file($arFiles['tmp_name'][$i], $target)) {
	        $success = true;
	        $paths[] = $target;
	    } else {
	        $success = false;
	        break;
	    }
	}
	if ($success === true) {
	    
	    $output = array();
	} elseif ($success === false) {
	    $output = array('error'=>'Ошибка при загрузке изображений. Обратитесь к системному администратору');
	    // delete any uploaded files
	    foreach ($paths as $file) {
	        unlink($file);
	    }
	} else {
	    $output = array('error'=>'Ошибка обработки файлов, возможно привышен лимит в ' . ini_get("upload_max_filesize"));
	}

	echo json_encode($output);
}
?>