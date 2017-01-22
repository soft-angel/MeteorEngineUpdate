function TimelineBackupRestore(btn, id) {
	$(btn).attr({disabled: 'disabled'});
    $.post('/MeteorRC/admin/editors/timeline_backup_ajax.php', {id: id}, function(respond){
    	var isJson = true;
        try {
			var arRespond = window.JSON.parse(respond);
		}catch (e) {
			isJson = false 
		}
		if(isJson){
			if(arRespond.ERROR) {
				msgHTML = '<br><div class="alert alert-danger">' + arRespond.ERROR + '<span class="close" data-dismiss="alert">×</span></div>';
			}else{
				msgHTML = '<br><div class="alert alert-success">' + arRespond.SUCCESS + '<span class="close" data-dismiss="alert">×</span></div>';
				$('#timelineElement_' + id).hide();
			}
			$('#timelineResult').html(msgHTML);
		}else{
			alert(respond);
		}
    });
}