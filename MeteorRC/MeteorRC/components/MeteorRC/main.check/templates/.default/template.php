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
//p($arResult);
//$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
//p($arResult);
?>
<div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                            <h4 class="panel-title">
                                Общая работа сайта
                            </h4>
                        </div>
                        <div class="panel-body">
        <table id="data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Статус</th>
                    <th>Значение на сервере</th>
                    <th>Необходимое значение</th>
                </tr>
            </thead>
            <tbody>
<?foreach ($arResult as $id => $arElement) {?>
                <tr>
                    <td>
                        <?=$arElement["NAME"]?>
                    </td>
                    <td class="text-center">
                        <?if($arElement['STATUS'] == 'Y'){?>
                        	<i class="fa fa-check-circle-o text-success"></i>
                        <?}else{?>
                        	<i class="fa fa-exclamation-circle text-danger"></i>
                        <?}?>	
                    </td>
                    <td class="text-center <?if($arElement['STATUS'] != 'Y'){?>text-danger<?}?>">
                        <?=$arElement["REAL"]?>
                    </td>
                    <td class="text-center">
                        <?=$arElement["STANDART"]?>
                    </td>
                </tr>
<?}?>
            </tbody>
        </table>
</div>
</div>