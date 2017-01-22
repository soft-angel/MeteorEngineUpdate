<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "settings",
	"NAME" => "Карта сайта",
	"IBLOCK" => "sitemap",
	"DESCRIPTION" => "Генерация карты сайта",
	"ICON" => '<i class="fa fa-sitemap"></i>',
	"BD_FOLDER" => "/MeteorRC/bd/settings/",
	"CORPORATE" => "MeteorRC",
	"ADMIN" => "Y",
	"NEW" => "Y",
	"IBLOCKS" => array(
		array(
			"COMPONENT" => "shop",
			"IBLOCK" => "products",
		),
		array(
			"COMPONENT" => "shop",
			"IBLOCK" => "sections",
		),
		array(
			"COMPONENT" => "news",
			"IBLOCK" => "news",
		),
	)
);
?>