jQuery(document).ready(function(){

	jQuery("#upm-upload-image").click(function(){
		initialize_image_upload();
	});

	jQuery("#upm-upload-video").click(function(){
		initialize_video_upload();
	});

	jQuery("#upm-upload-music").click(function(){
		initialize_music_upload();
	});
});

function initialize_image_upload(){
	if (jQuery('body').find('.userpro-overlay').length==0) {
		jQuery('body').append('<div class="userpro-overlay"/><div class="userpro-overlay-inner"/>');
	}
	
	jQuery('.userpro-overlay-inner').html("<a class='userpro-close-popup' href='#'>Close</a><div class='userpro'><div class='userpro-centered' style='min-width:478px'><input type='button' name='userpro_file' class='userpro-dash-upload' value='Upload File(s)' id='upm_upload_image_button'></div></div>");


	userpro_overlay_center('.userpro-overlay-inner');
		
	init_upload( this , 'upm_upload_image_button', 'photo', jQuery('#upm_photo_div').data('upload_limit'), jQuery('#upm_photo_div').data('allowed_extensions') );
}

function initialize_video_upload(){
	if (jQuery('body').find('.userpro-overlay').length==0) {
		jQuery('body').append('<div class="userpro-overlay"/><div class="userpro-overlay-inner"/>');
	}
	
	jQuery('.userpro-overlay-inner').html("<a class='userpro-close-popup' href='#'>Close</a><div class='userpro'><div class='userpro-centered' style='width:478px'><input type='button' name='userpro_file' class='userpro-dash-upload' value='Upload File(s)' id='upm_upload_video_button'></div></div>");
	userpro_overlay_center('.userpro-overlay-inner');
	init_upload( this , 'upm_upload_video_button', 'video', jQuery('#upm_video_div').data('upload_limit'), jQuery('#upm_video_div').data('allowed_extensions') );
}

function initialize_music_upload(){
	if (jQuery('body').find('.userpro-overlay').length==0) {
		jQuery('body').append('<div class="userpro-overlay"/><div class="userpro-overlay-inner"/>');
	}
	
	jQuery('.userpro-overlay-inner').html("<a class='userpro-close-popup' href='#'>Close</a><div class='userpro'><div class='userpro-centered' style='width:478px'><input type='button' name='userpro_file' class='userpro-dash-upload' value='Upload File(s)' id='upm_upload_music_button'></div></div>");
	userpro_overlay_center('.userpro-overlay-inner');
	init_upload( this , 'upm_upload_music_button', 'music', jQuery('#upm_music_div').data('upload_limit'), jQuery('#upm_music_div').data('allowed_extensions') );
}

function init_upload( elem, media_type , file_type, upload_limit, allowed_ext ){
	jQuery('#'+media_type).uploadFile({
		url: userpro_media_upload_url+"?dash=1&filetype="+file_type+'&upload_limit='+upload_limit,
		allowedTypes: allowed_ext,
		multiple:true,
		onSubmit:function(files){
		},
		onSuccess:function(files,data,xhr){
			var obj = jQuery.parseJSON(data);
			jQuery('.ajax-file-upload-statusbar').after("<table class='upm_dash_table'>"+obj.html+"</table>");
			jQuery('.upm_dash_table').after('<input type="button" class="upm-upload-all" onclick=dash_save_upload(this,"multiple") value="Save All">');
			userpro_overlay_center('.userpro-overlay-inner');
			jQuery('#'+media_type).attr('disabled','disabled');
		},
		
	});
}
function dash_save_upload( elem, method ){
	var src = '';
	var srcname = '';
	var medianame = '';
	var thumbnail_path = '';
	var media_caption = '';
	var filetype = media_type = media_restriction = '';
	var thumnail_content = '';
	var user_id = jQuery('#upm_user_id').val();
	if( method == 'multiple' ){	
		jQuery('.upm-upload-all').attr('disabled','disabled');
		jQuery('.save-single-upload').each(function(){
			var par = jQuery(this).parent().parent();
			src += par.find('.upm-uploaded-media-src').data('src')+'------';
			srcname += par.find('.upm-src-name').html()+'------';
			medianame += par.find('.upm-media-name').val()+'------';
			thumbnail_path += par.find('.upm-thumnail-path').val()+'------';
			media_caption+=par.find('.media_caption').val()+',';
			filetype = par.find('.upm-media-filetype').val();
			media_type = par.find('.upm-media-filetype').val();
			par.find('.save-single-upload').attr('disabled','disabled');
			var thumb_id = jQuery('#upm_'+filetype+'_div').find('.upm-thumbnail').length+'_'+filetype;
			var delete_function = "userpro_delete_files('"+par.find('.upm-thumnail-path').val() +"','"+user_id+"','"+thumb_id+"')";
			media_restriction = par.find('.upm-media-id').val()+"_"+par.find('.upm_media_restriction').val()+',';
			thumnail_content+='<div class="upm-thumbnail" id='+thumb_id+'> <span class="upm_remove" onclick="'+delete_function+'">&times;</span>';
			if( filetype == 'photo' ){
				thumnail_content+='<div class="upm-image"><img src="'+ par.find('.upm-uploaded-media-src').data('src')+'"></div><div class="upm_display_name">'+par.find('.upm-media-name').val()+'</div></div>';
			}
			else if( filetype == 'video' ){
				thumnail_content+='<video width = 400 height= 400 controls><source src="'+ par.find('.upm-uploaded-media-src').data('src')+'"></source></video><div class="upm_display_name">'+par.find('.upm-media-name').val()+'</div></div>';
			}
			else if( filetype == 'music' ){
				thumnail_content+='<audio controls><source src="'+ par.find('.upm-uploaded-media-src').data('src')+'"></source></audio><div class="upm_display_name">'+par.find('.upm-media-name').val()+'</div></div>';
			}
		});
	}
	else{
		var par = jQuery(elem).parent().parent();
		src = par.find('.upm-uploaded-media-src').data('src')+'------';
		srcname = par.find('.upm-src-name').html()+'------';
		medianame = par.find('.upm-media-name').val()+'------';
		thumbnail_path = par.find('.upm-thumnail-path').val()+'------';
		media_caption = par.find('.media_caption').val()+',';
		filetype = par.find('.upm-media-filetype').val();
		media_type = par.find('.upm-media-filetype').val();
		par.find('.save-single-upload').attr('disabled','disabled');
		par.find('img.userpro-loading').show().addClass('inline');
		var thumb_id = jQuery('#upm_'+filetype+'_div').find('.upm-thumbnail').length+'_'+filetype;
		var delete_function = "userpro_delete_files('"+par.find('.upm-thumnail-path').val() +"','"+user_id+"','"+thumb_id+"')";
		media_restriction = par.find('.upm-media-id').val()+"_"+par.find('.upm_media_restriction').val()+',';
		thumnail_content+='<div class="upm-thumbnail" id='+thumb_id+'> <span class="upm_remove" onclick="'+delete_function+'">&times;</span>';
			if( filetype == 'photo' ){
				thumnail_content+='<div class="upm-image"><img src="'+ par.find('.upm-uploaded-media-src').data('src')+'"></div><div class="upm_display_name">'+par.find('.upm-media-name').val()+'</div></div>';
			}
			else if( filetype == 'video' ){
				thumnail_content+='<video width = 400 height= 400 controls><source src="'+ par.find('.upm-uploaded-media-src').data('src')+'"></source></video></div>';
			}
			else if( filetype == 'music' ){
				thumnail_content+='<audio controls><source src="'+ par.find('.upm-uploaded-media-src').data('src')+'"></audio></div>';
			}
	}	
	
	var str = 'action=userpro_media_upload&filetype='+filetype+'&src='+src+'&media_type='+media_type+'&srcname='+srcname+'&media_name='+medianame+'&thumbnail_path='+thumbnail_path;
	
	jQuery.ajax({
				url: userpro_ajax_media_url,
				data: str,
				dataType: 'JSON',
				type: 'POST',
				success:function(data){
					jQuery.ajax({
						url: userpro_ajax_url,
						data: 'action=upm_upload_media&media='+src+'&media_caption='+media_caption+'&filetype='+filetype+'&media_restriction='+media_restriction,
						dataType: 'JSON',
						type: 'POST',
						success:function(data){
							if( method == 'multiple' ){	
								jQuery('.save-single-upload').val('Saved');
								jQuery('img.userpro-loading').hide().removeClass('inline');
								jQuery('.userpro-overlay').fadeOut(function(){jQuery('.userpro-overlay').remove()});
								jQuery('.userpro-overlay-inner').fadeOut(function(){jQuery('.userpro-overlay-inner').remove()});
							}
							else{
								par.find('.save-single-upload').val('Saved');
								par.find('img.userpro-loading').hide().removeClass('inline');
							}
							//console.log(thumnail_content);
							
							jQuery('#upm_'+filetype+'_div').find('.upm-thumb-container').append(thumnail_content);					
						}
					});
				}
			});
}
