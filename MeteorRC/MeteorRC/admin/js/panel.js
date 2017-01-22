function EyeEditor(checkbox){
  if (checkbox.checked){
    var isChecked = "Y";
  }else{
    var isChecked = "N";
  }
  SaveConfigParam('EYE_EDITOR', isChecked, 1000);
}
function SaveConfigParam(name, value, reloadTimeot = false){
  $.post( "/MeteorRC/admin/editors/settings_ajax.php?SAVE_SETTINGS[ARRAY][" + name + "]=" + value).done(function( data ) {
    if(reloadTimeot)
      setTimeout('location.reload();', reloadTimeot)
    return true;
  });
}
function ComponentBorderShow(component){
  $(component).mouseover(function() {
    $(component).css("box-shadow", "#464646 0 0 0px 2px").css("position", "relative").css("display", "inline-block").addClass("activ");    
  });

  $(component).mouseout(function() {
    $(component).css("box-shadow", "#464646 0 0 0 0");
    $(component).removeClass("activ");
  });
}

$(function() {
  if(typeof arComponents != 'undefined'){
    $.each(arComponents, function(index, value){
        component = $('#component_' + index);
        var componentPanel = '<div class=\"btnEyeRow\">';
        if(typeof value.btn != 'undefined'){
          componentPanel += value.btn;
        }
        if(typeof value.time != 'undefined'){
          componentPanel += '<span title="Время исполнения компонента"><i class="fa fa-clock-o"></i> ' + value.time +  ' сек.</span>';
        }
        if(typeof value.memory != 'undefined'){
          componentPanel += '<span title="Использовано оперативной памяти"><i class="fa fa-pie-chart"></i> ' + value.memory +  '</span>';
        }
        componentPanel += '</div>';
        $(component).append(componentPanel);
        ComponentBorderShow(component);
    });
  }
});

$(function() {
  $('#modal-meteor').on('hidden.bs.modal', function(e){ 
    $(this).removeData();
  });
  var changeCheckbox = document.querySelector( '#eyeToggle' );
  var init = new Switchery(changeCheckbox, { size: "small" });

  changeCheckbox.onchange = function() {
    EyeEditor(this);
  };


  PanelSetHeightLining();
});
$( window ).resize(function() {
  PanelSetHeightLining();
});



function PanelSetHeightLining() {
  var panelHeight = $('#meteor_panel').height();
  $('#meteorPanelLining').height(panelHeight);
}

function PanelToggle(btn){
  $('#meteor_panel').toggleClass("panel-fixed");
  $('#panelPin').toggleClass("active");
  if($('#meteor_panel').is( ".panel-fixed" )){
    var isFixed = "Y";
    $('#meteorPanelLining').show();
  }else{
    var isFixed = "N";
    $('#meteorPanelLining').hide();
  }
  SaveConfigParam('PANEL_FIXED', isFixed);
}