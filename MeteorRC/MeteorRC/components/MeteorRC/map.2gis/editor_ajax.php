<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?

if($USER->IsAdmin()){
	if(!$FIREWALL->GetString("GIS_MAP_ID")){
		$bd_map = FOLDER_BD . 'map/2gis/' . $FIREWALL->GetString("MAP_ID") . SFX_BD;
		$arResult = $APPLICATION->GetFileArray($bd_map);
		//p($arResult);
?>
<div id="map2gisConstructContainer">
<div id="map2gisSearch" class="col-lg-6 col-lg-offset-2">
    <div class="input-group">
      <input onchange="Search2gisMap(this)" type="text" class="form-control" placeholder="Поиск по адресу...">
      <span class="input-group-btn">
        <button  onclick="Search2gisMap(this)" class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i> Найти</button>
      </span>
    </div>
</div>
<div id="map2gisConstruct"></div>
<form id="menu2gisConstruct" class="col-md-4 col-sm-6 col-xs-8">
<h3 style="color:#fff"><i class="fa fa-map-marker" aria-hidden="true"></i> Редактирование метки</h3>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-align-left"></i></span>
					<textarea style="height:200px" name="balloonContent" class="form-control input-sm" placeholder="Содеримое метки"></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12 text-center">
	<div class="btn-group" role="group">
	<button type="button" id="save_placemark" class="btn btn-sm btn-success"><span class="fa fa-floppy-o"></span> Сохранить метку</button>
	<button type="button" id="delete_placemark" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span> Удалить метку</button>
	</div>
	</div>
</form>
</div>



<div style="clear:both"></div>
<button onclick="SaveMap()" class="btn_admin button_save">Cохранить <i class="fa fa-floppy-o"></i></button>

<script type="text/javascript">
		$.getScript( "//maps.api.2gis.ru/2.0/loader.js" ).done(function( script, textStatus ) {
			// Как только будет загружен API и готов DOM, выполняем инициализацию
			DG.then(function () {
				init2Gis();
			});
		});
        var myMarker2gis = [];
        var myMap2Gis;
        var coords_edit;
        var arPlaceMarks = [];
        function init2Gis () {
            // Создание экземпляра карты и его привязка к контейнеру с

            myMap2Gis =  DG.map('map2gisConstruct', {
            	<?if(isset($arResult['SETTINGS']['MAP_CENTER'][0]) and isset($arResult['SETTINGS']['MAP_CENTER'][1])){?>
                    center: [<?=$arResult['SETTINGS']['MAP_CENTER'][0]?>, <?=$arResult['SETTINGS']['MAP_CENTER'][1]?>],
                <?}else{?>
					center: [55.76, 37.64],
                <?}?>
                    zoom: <?=isset($arResult['SETTINGS']['MAP_ZOOM'])?$arResult['SETTINGS']['MAP_ZOOM']:10?>,
                });
            	<?
				if(!isset($arResult['SETTINGS']['MAP_CENTER'][0]) or !isset($arResult['SETTINGS']['MAP_CENTER'][1])){?>
				//
				<?
				}
				if(isset($arResult['PLACEMARK']))
					foreach ($arResult['PLACEMARK'] as $id => $value) {
				?>
				var coords = [<?=isset($value['coords'][0])?$value['coords'][0]:$value['coords']['lat']?>, <?=isset($value['coords'][1])?$value['coords'][1]:$value['coords']['lon']?>];
				myMarker2gis[coords] = createPlacemark(coords, '<?=str_replace(PHP_EOL, '<br>', $value['balloonContent'])?>');
				createEditEvent(coords);
				<?}?>

			    // Слушаем клик на карте.
			    myMap2Gis.on('click', function(e) {
			        var coords = [e.latlng.lat, e.latlng.lng];
			        coords_edit = coords;
			        // Если метка уже создана – просто передвигаем ее.
			        if (!myMarker2gis[coords]) {
        	
			            myMarker2gis[coords] = createPlacemark(coords);
			            getAddress(coords);
			            createEditEvent(coords);
			        }
			        
			    	ShowEdit(coords);
			    });
			    $('#map2gisSearch').show();
    		}
		    // Определяем адрес по координатам (обратное геокодирование).
		    function getAddress(coords) {
				$.getJSON( "https://geocode-maps.yandex.ru/1.x/", { rspn: 1, format: "json", geocode: coords[1] + "," + coords[0]}, function( json ) {
		    		var searchElem = json.response.GeoObjectCollection.featureMember[0];
		    		console.log(searchElem);
		    		if(typeof searchElem != "undefined"){
			    		var searchName = searchElem.GeoObject.metaDataProperty.GeocoderMetaData.text;
			    		myMarker2gis[coords].bindPopup(searchName);
						arPlaceMarks[coords].balloonContent = searchName;
			    		$('#menu2gisConstruct textarea[name="balloonContent"]').val(searchName);
			    		return searchName;
		    		}
					
				});
		    }
		    function Search2gisMap(btn){
		    	var search = $('#map2gisSearch input').val();
				$.getJSON( "https://geocode-maps.yandex.ru/1.x/", {format: "json", geocode: search}, function( json ) {
		    		var searchElem = json.response.GeoObjectCollection.featureMember[0];
		    		console.log(searchElem);

		    		if(typeof searchElem != "undefined"){
		    			console.log(searchElem);
		    			var arPoint = searchElem.GeoObject.Point.pos.split(' ');
		    			var point = {lon: arPoint[0], lat: arPoint[1]};
		    			var kind = searchElem.GeoObject.metaDataProperty.GeocoderMetaData.kind;
		    			if(kind == 'house' && !myMarker2gis[point]){
		    				var searchName = searchElem.GeoObject.metaDataProperty.GeocoderMetaData.text;
				            myMarker2gis[point] = createPlacemark(point, searchName);
				            createEditEvent(point);
				            coords_edit = point;
				            ShowEdit(point);
		    			}

		    			myMap2Gis.setView(point);
		    		}else{
		    			alert('По запросу "' + search + '" ничего не найдено!')
		    		}
					
				});
		    }
		    // Создание метки.
		    function createPlacemark(coords, balloonContent = 'Мы тут') {
		    	arPlaceMarks[coords] = {
		    		'coords' : coords,
		    		'balloonContent' : balloonContent
		    	}
		        return DG.marker(coords).addTo(myMap2Gis).bindPopup(balloonContent);
		    }
    		function ShowEdit(coords) {
    				myMap2Gis.setView(coords_edit);
    				myMarker2gis[coords_edit].openPopup();
			    	$('#menu2gisConstruct').css('right', 0);
			    	var balloonContentOroginal = arPlaceMarks[coords_edit]['balloonContent'];
			    	$('#menu2gisConstruct textarea[name="balloonContent"]').val(balloonContentOroginal);

			        // При нажатии на кнопку "Сохранить" изменяем свойства метки
			        // значениями, введенными в форме контекстного меню.
			        $('#save_placemark').click(function () {
			        	var TextballoonContent = $('textarea[name="balloonContent"]').val();
				        myMarker2gis[coords_edit].bindPopup(TextballoonContent).openPopup();
				        //Удаляем контекстное меню.
				        $('#menu2gisConstruct').css('right', '-200%');
				        arPlaceMarks[coords_edit]['balloonContent'] = TextballoonContent;
			        });


			        $('#delete_placemark').click(function () {
						myMarker2gis[coords_edit].remove();
						$('#menu2gisConstruct').css('right', '-200%');
						arPlaceMarks[coords_edit] = null;
			        });
        	}
    		function createEditEvent(coords) {
			    // Контекстное меню, позволяющее изменить параметры метки.
			    // Вызывается при нажатии правой кнопкой мыши на метке.
			    myMarker2gis[coords].on('click', function(e) {
			    	coords_edit = coords;
			    	ShowEdit(coords);
			    });
        	}
        	function SaveMap() {
				var mapCenter = myMap2Gis.getCenter();
				var arSettings = {
					'MAP_CENTER': {
						0: mapCenter['lat'],
						1: mapCenter['lng']
					},
					'MAP_ZOOM': myMap2Gis.getZoom(),
				}
				
				var i = 0;
				var arPlaceMarksSave = new Array;
				for (var key in arPlaceMarks) {
					arPlaceMarksSave[i] = arPlaceMarks[key];
					i++;
				}
				console.log(arPlaceMarksSave);
				$.post( '<?=$_SERVER["PHP_SELF"]?>',  {GIS_MAP_ID: '<?=$FIREWALL->GetString("MAP_ID")?>', PLACEMARK: arPlaceMarksSave, SETTINGS: arSettings}, function( data ) {
					if(data == 'OK'){
						$('#modal-meteor').modal('hide');
						location.reload();
					}else{
						alert(data);
					}
				});
        	}
    </script>
    <style type="text/css">
#menu2gisConstruct {
    z-index: 2;
    position: absolute;
    transition: all .7s;
    top: 0px;
    right: -200%;
    height: 199%;
    padding: 15px;
    background-color: rgba(0, 0, 0, 0.7);
}
#map2gisConstruct {
    width:100%;
    height:400px
}
#map2gisConstructContainer {
    background: url(/MeteorRC/components/MeteorRC/map.2gis/templates/.default/images/2gis.png) #fafafa center no-repeat;
    background-size: 25%;
    overflow: hidden;
    position:relative;
    width:100%;
    height:400px
}
#menu2gisConstruct h3 {
    font-size: 20px;
    font-weight: normal;
    margin-bottom: 30px;
}
div#map2gisSearch {
    position: absolute;
    top: 10px;
    display: none;
}
div#map2gisSearch .input-group-btn {
    border-color: #3d3d3d;
}
div#map2gisSearch button {
    background-color: #3d3d3d;
    color: #fff;
}
    </style>
<?
	}else{
		if($mapID = $FIREWALL->GetString("GIS_MAP_ID")){
			$arMap = array(
				'ID' => $mapID,
				'PLACEMARK' => $FIREWALL->GetArrayString("PLACEMARK"),
				'SETTINGS' => $FIREWALL->GetArrayString("SETTINGS"),
			);
  			$APPLICATION->ArrayWriter($arMap, FOLDER_BD . 'map/2gis/' . $mapID . SFX_BD);
  			echo 'OK';
		}
	}
}

?>