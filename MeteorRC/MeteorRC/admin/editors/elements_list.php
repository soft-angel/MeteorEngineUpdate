<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?CJSCore::Init(array('fancybox'));

$arPageCount = array(10, 25, 50, 100, 200, 500, 1000);

if($showCount = $FIREWALL->GetNumber('SHOW_COUNT')){
    $arParams["PAGE_ELEMENT_COUNT"] = $showCount;
    $_SESSION['PAGE_ELEMENT_COUNT'][$arParams["IBLOCK"]] = $showCount;
}elseif(!isset($arParams["PAGE_ELEMENT_COUNT"])){
    $arParams["PAGE_ELEMENT_COUNT"] = isset($_SESSION['PAGE_ELEMENT_COUNT'][$arParams["IBLOCK"]])?$_SESSION['PAGE_ELEMENT_COUNT'][$arParams["IBLOCK"]]:25;
}

if(isset($arElements)){
    // Получаем активный элемент из $_GET
    $arResult["PAGENAVIGATION"]["ACTIVE"] = $FIREWALL->GetNumber("PAGEN_" . $arParams["IBLOCK"]);
    if(!$arResult["PAGENAVIGATION"]["ACTIVE"])
        $arResult["PAGENAVIGATION"]["ACTIVE"] = 1;
    // Получаем количество элементов
    $arResult["PAGENAVIGATION"]["COUNT"] = count($arElements);

    // Проверяем есть ли необходимость в навигации
    if($arParams["PAGE_ELEMENT_COUNT"] < $arResult["PAGENAVIGATION"]["COUNT"]){
        $arResult["PAGENAVIGATION"]["SHOW"] = "Y";
        // Вычисляем количество страниц
        $arResult["PAGENAVIGATION"]["PAGES"] = $arResult["PAGENAVIGATION"]["COUNT"] / $arParams["PAGE_ELEMENT_COUNT"];
        $arElements = array_slice($arElements, (($arResult["PAGENAVIGATION"]["ACTIVE"] - 1) * $arParams["PAGE_ELEMENT_COUNT"]), $arParams["PAGE_ELEMENT_COUNT"], TRUE);
    }
}
?>
                            <!-- #modal-dialog -->
                            <div class="modal fade" id="modal-stata-element">
                                <div class="modal-dialog" style="padding-left: 15px;width: 100%;padding-right: 15px;">
                                    <div style="border-radius: 0;background-color: #3A4248;" class="modal-content">

                                        <div class="modal-body">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #modal-without-animation -->

<div class="row">
    <div class="col-sm-6">
        <form method="POST" action="">
            <label>Выводить по <select style="display: inline-block;width: 70px;" name="SHOW_COUNT" onchange="this.form.submit();" class="form-control input-sm">
                <? foreach ($arPageCount as $key => $value) {?>
                    <option <?if($arParams["PAGE_ELEMENT_COUNT"] == $value){?>selected="selected"<?}?> value="<?=$value?>"><?=$value?></option>
                <?} ?> 
                </select> элементов
            </label>
        </form>
    </div>
    <div class="col-sm-6">
        
    </div>
</div>
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <?if(isset($arParams["STATA_TRACKING"])){?>
                                        <th>Статистика</th>
                                        <?}?>
                                        <?foreach($arParams["FIELDS"] as $code => $field){
                                            if($field["DISPLAY"] != "Y")continue;?>
                                        <th><?=$field["NAME"]?></th>
                                        <?}?>
                                        <th>Управление</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?foreach ($arElements as $id => $product) {?>
                                        <tr id="element-<?=$id?>" ondblclick="window.location = '?component=<?=$arParams["COMPONENT"]?>&amp;iblock=<?=$arParams["IBLOCK"]?>&amp;edit_element=<?=$id?>'">
                                    <?if(isset($arParams["STATA_TRACKING"])){?>
                                            <td class="text-center">
                                            <a data-toggle="modal" data-target="#modal-stata-element" href="/MeteorRC/admin/editors/elements_stata_ajax.php?component=<?=$arParams["COMPONENT"]?>&amp;iblock=<?=$arParams["IBLOCK"]?>&amp;id=<?=$product["ID"]?>">
                                            <?//p($arStata[$product["ID"]]);?>
                                                <span class="lineChart"><?if(isset($product['STATA_TRACKING'])){
                                                    echo implode(',', $product['STATA_TRACKING']);
                                                }?></span>
                                            </a>
                                                
                                            </td>
                                    <?}?>
                                            <?foreach($arParams["FIELDS"] as $code => $field){
                                                if($field["DISPLAY"] != "Y")continue;?>
                                            <td class="text-center">
                                                <span class="hide"><?=$product[$code]?></span>
                                            <?
                                            switch($field["TYPE"])
                                                {
                                                case "SELECT":
                                                    ?>
                                                    <?if(!isset($field["MULTI"])){?>
                                                    <span data-value="<?=$product[$code]?>" data-name="<?=$code?>" id="field_<?=$code?>_<?=$id?>"><?=$field["SELECT"][$product[$code]]?></span>
                                                    <script type="text/javascript">
                                                    $(function() {
                                                        $("#field_<?=$code?>_<?=$id?>").editable({
                                                            type: 'select',
                                                            source: [<?foreach ($field["SELECT"] as $key => $value) {?>
                                                                {value: '<?=$key?>', text: '<?=$value?>'},
                                                            <?}?>],
                                                            enablefocus: true,
                                                            pk: 1,
                                                            emptytext: "Пусто",
                                                            success: function(data) {
                                                                if(typeof data == 'object' && !data.SUCCESS)
                                                                    alert(data.ERROR);
                                                                
                                                            },
                                                            url: '/MeteorRC/admin/editors/save_ajax.php?PARAMS[COMPONENT]=<?=$arParams["COMPONENT"]?>&PARAMS[IBLOCK]=<?=$arParams["IBLOCK"]?>&PARAMS[OLD_KEY]=<?=$id?>&PARAMS[DATA_MERGE]=Y',
                                                        });
                                                    });
                                                    </script>
                                                    <?}else{?>
                                                    <?=isset($product[$code][0])?$field["SELECT"][$product[$code][0]] . ', ...':false?>
                                                    <?}
                                                    break;
                                                case "SELECT_BD":
                                                    $component = (isset($field["COMPONENT_BD"]))?$field["COMPONENT_BD"]:$arParams["COMPONENT"];
                                                    $select_bd = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $field["BD"] . SFX_BD);
                                                    ?>
                                                    <?if(!isset($field["MULTI"])){?>
                                                    <a href="?component=<?=$component?>&iblock=<?=$field["BD"]?>&edit_element=<?=$product[$code]?>"><?=(isset($product[$code]))?$select_bd[$product[$code]]["NAME"] . " [" . $product[$code] . "]":false?></a>
                                                    <?}else{?>
                                                    <?=(isset($product[$code]))?$select_bd[$product[$code][0]]["NAME"]:false?>, ...
                                                    <?
                                                    }
                                                    break;
                                                case "PRICE":
                                                    ?>
                                                    <span data-value="<?=$product[$code]?>" data-name="<?=$code?>" id="field_<?=$code?>_<?=$id?>"><?=$APPLICATION->PriceFormat($product[$code]) . ' <i class="fa fa-rub"></i>';?></span>
                                                    <script type="text/javascript">
                                                    $(function() {
                                                        $("#field_<?=$code?>_<?=$id?>").editable({
                                                            type: 'text',
                                                            enablefocus: true,
                                                            pk: 1,
                                                            emptytext: "Пусто",
                                                            success: function(data) {
                                                                if(typeof data == 'object' && !data.SUCCESS)
                                                                    alert(data.ERROR);
                                                                
                                                            },
                                                            url: '/MeteorRC/admin/editors/save_ajax.php?PARAMS[COMPONENT]=<?=$arParams["COMPONENT"]?>&PARAMS[IBLOCK]=<?=$arParams["IBLOCK"]?>&PARAMS[OLD_KEY]=<?=$id?>&PARAMS[DATA_MERGE]=Y',
                                                        });
                                                    });
                                                    </script>
                                                    <?
                                                    break;
                                                case "IMAGE":
                                                    ?>
                                                    <a class="fancybox" target="_blank" href="<?=$FILE->GetUrlFile($product[$code], $arParams["IBLOCK"])?>"><img class="img-thumbnail" width="<?=$arParams["IMAGE_WIDTH"]?>" src="<?=isset($product[$code])?$FILE->IblockResizeImageGet($product[$code], $arParams["IBLOCK"], 50, 50, 70, 'crop'):SITE_TEMPLATE_PATH . "images/noimage.png"?>"></a>
                                                    <?
                                                    break;
                                                case "TIME":
                                                ?>
                                                <span><?=(isset($product[$code]))?date('d.m.Y H:i:s', $product[$code]):false?></span>
                                                <?
                                                break;
                                                case "TEXT":
                                                default:
                                                ?>
                                                    <span data-name="<?=$code?>" id="field_<?=$code?>_<?=$id?>"><?=(isset($product[$code]))?$product[$code]:false?></span>
                                                    <script type="text/javascript">
                                                    $(function() {
                                                        $("#field_<?=$code?>_<?=$id?>").editable({
                                                            type: 'text',
                                                            enablefocus: true,
                                                            emptytext: "Пусто",
                                                            pk: 1,
                                                            success: function(data) {
                                                                if(typeof data == 'object' && !data.SUCCESS)
                                                                    alert(data.ERROR);
                                                                
                                                            },
                                                            url: '/MeteorRC/admin/editors/save_ajax.php?PARAMS[COMPONENT]=<?=$arParams["COMPONENT"]?>&PARAMS[IBLOCK]=<?=$arParams["IBLOCK"]?>&PARAMS[OLD_KEY]=<?=$id?>&PARAMS[DATA_MERGE]=Y',
                                                        });
                                                    });
                                                    </script>
                                                <?
                                                }
                                            ?></td>
                                            <?}?>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="?component=<?=$arParams["COMPONENT"]?>&iblock=<?=$arParams["IBLOCK"]?>&edit_element=<?=$id?>" class="btn btn-sm btn-white"><span class="btn btn-success btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-pencil"></i></span></a>
                                                    <a href="?component=<?=$arParams["COMPONENT"]?>&iblock=<?=$arParams["IBLOCK"]?>&edit_element=<?=$id?>&clone_element" class="btn btn-sm btn-white"><span class="btn btn-xs btn-info btn-icon btn-circle btn-xs"><i class="fa fa-files-o"></i></span></a>
                                                    <a href="javascript:elementDelete(this, '<?=$arParams["COMPONENT"]?>', '<?=$arParams["IBLOCK"]?>', '<?=$id?>');" class="btn btn-sm btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?}?>
                                </tbody>
                            </table>
                <?if(isset($arResult["PAGENAVIGATION"]["SHOW"]) and $arResult["PAGENAVIGATION"]["SHOW"] == "Y"){?>
                <div class="text-center">
                <p>Показано <?=$arParams["PAGE_ELEMENT_COUNT"]?> из <?=$arResult["PAGENAVIGATION"]["COUNT"]?> элементов</p>
                <ul class="pagination m-t-0 m-b-10">
                    <?if($arResult["PAGENAVIGATION"]["ACTIVE"] > 1){?>
                    <li><a href="<?=$APPLICATION->UrlQuery('PAGEN_' . $arParams["IBLOCK"], ($arResult["PAGENAVIGATION"]["ACTIVE"] - 1))?>"><i class="fa fa-caret-left"></i></a></li>
                    <?}?>
                    <?
                    $i = 0;
                    while($arResult["PAGENAVIGATION"]["PAGES"] > $i){
                        $i++;
                    ?>
                    <li <?if($arResult["PAGENAVIGATION"]["ACTIVE"] == $i){?>class="active"<?}?>><a href="<?=$APPLICATION->UrlQuery('PAGEN_' . $arParams["IBLOCK"], $i)?>"><?=$i?></a></li>
                    <?}?>
                    <?if($arResult["PAGENAVIGATION"]["ACTIVE"] < $i){?>
                    <li><a href="<?=$APPLICATION->UrlQuery('PAGEN_' . $arParams["IBLOCK"], ($arResult["PAGENAVIGATION"]["ACTIVE"] + 1))?>"><i class="fa fa-caret-right"></i></a></li>
                    <?}?>
                </ul>
                </div>
                <?}?>

<script src="/MeteorRC/js/plugins/dataTables/js/jquery.dataTables.min.js"></script>
<script src="/MeteorRC/js/plugins/dataTables/js/dataTables.bootstrap.min.js"></script>
<script src="/MeteorRC/js/plugins/dataTables/js/dataTables.fixedHeader.min.js"></script>
<script src="/MeteorRC/js/plugins/dataTables/js/dataTables.responsive.min.js"></script>


    <script src="/MeteorRC/js/plugins/editable/bootstrap-editable.min.js"></script>
    <script src="/MeteorRC/js/plugins/editable/inputs-ext/address/address.js"></script>
    <script src="/MeteorRC/js/plugins/editable/inputs-ext/typeahead/typeahead.js"></script>
    <script src="/MeteorRC/js/plugins/editable/inputs-ext/typeahead/typeaheadjs.js"></script>
    <script src="/MeteorRC/js/plugins/editable/inputs-ext/wysihtml5/wysihtml5.js"></script>

    <link href="/MeteorRC/js/plugins/editable/bootstrap-editable.css" rel="stylesheet" />
    <link href="/MeteorRC/js/plugins/editable/inputs-ext/address/address.css" rel="stylesheet" />
    <link href="/MeteorRC/js/plugins/editable/inputs-ext/typeahead/typeahead.css" rel="stylesheet" />

<?//$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/dataTables/jquery.dataTables.js");?>
<?//$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/dataTables/dataTables.bootstrap.min.js");?>
<?//$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/dataTables/dataTables.fixedHeader.min.js");?>
<?//$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/dataTables/dataTables.responsive.min.js");?>

<?$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/dataTables/css/dataTables.bootstrap.min.css");?>
<?$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/dataTables/css/fixedHeader.bootstrap.min.css");?>

<script>

function GetContentToModal(url, modalId){
    var modal = $('#' + modalId + ' .modal-content');
    $.post(url, function(data){
        modal.html(data);
    });
    
}
$('#modal-stata-element').on('hidden.bs.modal', function() {
    $(this).removeData('bs.modal');
});


var handleDataTableFixedHeader = function() {
        "use strict";
        0 !== $("#data-table").length && $("#data-table").DataTable({
            searching: false,
            paging: false,
            info: false,
            //stateSave: true,
            //iDisplayLength: $.cookie('displayLength') == null ? -1 : $.cookie('displayLength'),
            //lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
            fixedHeader: {
                header: !0,
                headerOffset: $("#header").height()
            },
            responsive: !0
        });
        //$("#data-table").on( 'length.dt', function ( e, settings, len ) {
            //$.cookie('displayLength', len, { expires: 90 });
        //});
    },
    TableManageFixedHeader = function() {
        "use strict";
        return {
            init: function() {
                handleDataTableFixedHeader()
            }
        }
    }();
$(document).ready(function() {
    TableManageFixedHeader.init();
});

<?
if(isset($arParams["STATA_TRACKING"])){
    CJSCore::Init(array('peity'));
?>
$(".lineChart").peity("line", {fill: ["rgba(0,172,172,0.5)"],stroke: "#008a8a"})
<?
}
?>
</script>

