<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
			        <div class="panel panel-inverse" data-sortable-id="index-<?=$arParams["COMPONENT"]?>-<?=$arParams["IBLOCK"]?>">
			            <div class="panel-heading">
			                <h4 class="panel-title">Новые пользователи<span class="pull-right label label-theme">Пользователей: <?=count($arResult["ELEMENTS"])?></span></h4>
			            </div>
			            <div class="panel-body" style="height: 298px;">
                        <ul class="registered-users-list clearfix">
<?
						$i = 0;
						foreach($arResult["ELEMENTS"] as $id => $arElement){
							$i++;
?>
                            <li>
                                <a href="?component=users&amp;iblock=users&amp;edit_element=<?=$id?>"><img src="<?=(isset($arElement["PERSONAL_PHOTO"]))?$FILE->IblockResizeImageGet($arElement["PERSONAL_PHOTO"], $arParams["IBLOCK"], 128, 128, 70, 'crop'):SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
                                <h4 class="username text-ellipsis text-center">
                                    <?=$arElement["NAME"]?>
                                    <small class="text-center"><?=$arElement["LOGIN"]?></small>
                                </h4>
                            </li>
<?
							if(isset($arParams["ELEMENT_COUNT"]) and $i >= $arParams["ELEMENT_COUNT"])
								break;
						}
?>
                        </ul>
                        </div>
			            <div class="panel-footer text-center">
			                <a href="?component=users&amp;iblock=users" class="text-inverse">Показать всех</a>
			            </div>
			        </div>