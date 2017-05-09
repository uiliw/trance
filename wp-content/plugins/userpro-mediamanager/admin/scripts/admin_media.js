function mediamanager_delete_youtubeurl(media_id){
	

	
	str = 'action=delete_youtubeurl&media_id='+media_id;
	jQuery.ajax({
		url: ajaxurl,
		data: str,
		dataType: 'JSON',
		type: 'POST',
		success:function(data){
			jQuery('#'+media_id).remove();	
		},
		error:function(data){
			alert(data);
		}		
	});
}

function mediamanager_delete_files(file_name,media_id,file_id){
	

	
	str = 'action=userpro_media_delete&media_id='+media_id+'&file_name='+file_name;
	jQuery.ajax({
		url: ajaxurl,
		data: str,
		dataType: 'JSON',
		type: 'POST',
		success:function(data){
			jQuery('#'+media_id).remove();	
		},
		error:function(data){
			alert(data);
		}		
	});
}

function mediamanager_approve_media(media_id){
	

	
	str = 'action=mediamanager_admin_approve_media&media_id='+media_id;
	jQuery.ajax({
		url: ajaxurl,
		data: str,
		dataType: 'JSON',
		type: 'POST',
		success:function(data){
		jQuery('#'+media_id).remove();	
		},
		error:function(data){
			alert(data);
		}		
	});
}
function mediamanager_ignore_media(media_id){
	

	
	str = 'action=mediamanager_admin_ignore_media&media_id='+media_id;
	jQuery.ajax({
		url: ajaxurl,
		data: str,
		dataType: 'JSON',
		type: 'POST',
		success:function(data){
		jQuery('#'+media_id).remove();	
		},
		error:function(data){
			alert(data);
		}		
	});
}

