<?

$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/news/#",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/services/#",
		"PATH" => "/services/index.php",
	),
	array(
		"CONDITION" => "#^/articles/#",
		"PATH" => "/articles/index.php",
	),
	array(
		"CONDITION" => "#^/personal/orders/#",
		"PATH" => "/personal/orders/index.php",
	),
	array(
		"CONDITION" => "#^/products/#",
		"PATH" => "/products/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/work/#",
		"PATH" => "/work/index.php",
	),
	array(
		"CONDITION" => "#^/work/#",
		"PATH" => "/work/index.php",
	),
	array(
		"CONDITION" => "#^/otzyvy.html#",
		"PATH" => "/rewievs/index.php",
	),
	array(
		"CONDITION" => "#^/portfolio/#",
		"PATH" => "/portfolio/index.php",
	),
	array(
		"CONDITION" => "#^/izgotovlenie_reklamy/#",
		"PATH" => "/izgotovlenie_reklamy/index.php",
	),
);
	foreach($arUrlRewrite as $val)
	{
		if(preg_match($val["CONDITION"], $_SERVER['REQUEST_URI']))
		{
				$_SERVER["REAL_FILE_PATH"] = $val["PATH"];
				$APPLICATION->RestartBuffer(); 
				require($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/header.php");
				include($_SERVER['DOCUMENT_ROOT'] . $val["PATH"]);
				include($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/footer.php");
				die;
		}
	}