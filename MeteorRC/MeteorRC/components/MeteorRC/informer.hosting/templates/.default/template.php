<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
?>
					<div class="panel panel-<?if($arResult){?>inverse<?}else{?>danger<?}?>" id="meteor_hosting" data-sortable-id="hosting">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Хостинг</h4>
                        </div>
                        <div class="panel-body" style="height: 336pxZ;">
<?
if($arResult){
$APPLICATION->AddHeadScript($templateFolder . "/script.js");
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
?>
						<div style="margin: 15px 0" class="text-center">
							<i class="fa fa-hdd-o fa-5x text-theme"></i>
						</div>
						<div class="list-group">
							<div class="list-group-item text-ellipsis">
								<i class="fa fa-shopping-basket text-theme"></i> Баланс: <b class="text-theme" <?if($arResult["PRICE_DAY"] < 14){?>style="color:red"<?}?>><?=$arResult["BALANS"]?round($arResult["BALANS"], 2):'?'?> <i class="fa fa-rub"></i></b>
								<span class="btn btn-xs btn-theme" onclick="GoBalans(this)">Пополнить</span>
							</div>
							<div class="list-group-item text-ellipsis" style="display: none;" id="pay">
							<form action="//hosting.soft-angel.ru/pay/" method="POST">
								Пополнить на сумму: <div>
								<div class="input-group">
									<input name="MONEY" class="pay_input form-control input-sm" type="text" value="<?=round($arResult["PRICE_YEAR"])?>">
									<span class="input-group-btn">
									<button type="submit" class="btn btn-theme btn-sm">Оплатить <i class="fa fa-arrow-right"></i></button>
									</span>
								</div>
								<input name="DOMAIN" type="hidden" value="<?=$_SERVER['HTTP_HOST']?>">
								</div>
							</form>
							</div>
							<div class="list-group-item text-ellipsis">
								<i class="fa fa-clock-o text-theme"></i> Осталось оплаченных дней: <b class="text-theme" <?if($arResult["PRICE_DAY"] < 14){?>style="color:red"<?}?>><?=round(($arResult["PRICE_DAY"] <= 0)?0:$arResult["PRICE_DAY"])?></b>
							</div>
							<div class="list-group-item text-ellipsis">
								<i class="fa fa-calendar text-theme"></i> Цена в месяц (31 день): <b class="text-theme"><?=$arResult["MONEY"]?> <i class="fa fa-rub"></i></b>
							</div>
							<div class="list-group-item text-ellipsis">
								<i class="fa fa-calendar-check-o text-theme"></i> Цена в год (<?=decl(round(date('L')?366:365), array('день', 'дня', 'дней'))?>): <b class="text-theme"><?=round($arResult["PRICE_YEAR"], 2)?> <i class="fa fa-rub"></i></b>
							</div>
							<div class="list-group-item text-ellipsis">
								<i class="fa fa-hdd-o text-theme"></i> Использовано/квота: <b class="text-theme"><?=$arResult["DRIVE"]?ConvertFileSize(($arResult["DRIVE"] + $arResult["MYSQL"]["SIZE"]), 2):"?"?>/<?=ConvertFileSize($arResult["DRIVE_LIMIT"], 0)?></b>
							</div>
							<?if($arResult["DOMAIN"] == 'Y'){?>
							<div class="list-group-item text-ellipsis">
								Домен: <?=$_SERVER['SERVER_NAME']?> Тиц: <?=$arResult["TIC"]?>
							</div>
							<div class="list-group-item text-ellipsis">
								Продлен до: <?=$arResult["WHIOS"]["PAID_TILL"]?>
							</div>
                        	<?}?>
						</div>

<?}else{?>
	                        <div style="margin: 15px 0" class="text-center">
	                        	<img width="55px" src="<?=$templateFolder?>/images/logo.svg">
	                        </div>
	                        <div class="note note-danger">Обращаем внимание, что система работает на стороннем хостинге. Мы настоятельно рекомендуем переехать на специализированный для CSM MeteorEngine хостинг. <br>Обратитесь: <a href="mailto:hello@soft-angel.ru">hello@soft-angel.ru</a>
	                        <br>
	                        <b>Стоимость 80р за 31 день.</b><br>
	                        После чего Вам будет доступна мини панель управления хостингом и пополнение баланса прямо тут!
	                        </div>
	                        
<?}?>
                        </div>
                    </div>