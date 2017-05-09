<?php
add_action('userpro_pre_profile_update','userpro_media_update');
function userpro_media_update($arg0){
	global $userpro,$userpro_media_api;
	if(isset($arg0['user_id']))
	{
		$user_id=$arg0['user_id'];
	}
	$media_list=get_option('userpro_media_gallery_temp_data');
	delete_option('userpro_media_gallery_temp_data');
	if(is_array($media_list))
	{
	foreach($media_list as $media){
		/* move user pics to his folder */
		if ( $media['media_type'] == 'photo'  || $media['media_type'] == 'video'  || $media['media_type'] == 'music' ) {
			$file_data=pathinfo($media['media_url']);
			if(isset($file_data['extension']))
			if(in_array($file_data['extension'],array('jpg','jpeg','png','gif','mp4', 'mov', 'm4v', 'm2v', 'avi', 'mpg', 'flv', 'wmv', 'mkv', 'webm', 'ogv', 'mxf', 'asf', 'vob', 'mts', 'qt', 'mpeg', 'x-msvideo','mp3', 'wma', 'ogg', 'wav', 'm4a')))
			{
				$userpro_media_api->do_uploads_dir_media( $user_id );
				$userpro_media_api->do_uploads_dir_media_thumbnail( $user_id );
				if ( file_exists( $userpro_media_api->get_uploads_dir_media() ) ) {
					rename( $userpro_media_api->get_uploads_dir_media().basename($media['media_url']), $userpro_media_api->get_uploads_dir_media($user_id).basename($media['media_url']) );
					if($media['media_type']=='photo')
					rename( $userpro_media_api->get_uploads_dir_media_thumbnail().basename($media['media_url']), $userpro_media_api->get_uploads_dir_media_thumbnail($user_id).basename($media['media_url']) );
					$options=get_option('userpro_media_gallery');
					$options_new=array();
					foreach($options as $option)
					{
						if(isset($option['media_name'])) 
						if(basename($media['media_url'])===$option['media_name'])
						{
							$option['user_id']=$user_id;
							$option['media_url']=$userpro_media_api->get_uploads_url_media($user_id).basename($media['media_url']);
							$option['media_path']=$userpro_media_api->get_uploads_dir_media($user_id).basename($media['media_url']);
							if($media['media_type']=='photo')
							$option['thumbnail_path']=$userpro_media_api->get_uploads_url_media_thumbnail($user_id).basename($media['media_url']);
						}
						array_push($options_new,$option);
					}
					update_option('userpro_media_gallery',$options_new);
				}
			}		
		}
	}
	}
}

add_action('wp_enqueue_scripts', 'userpro_enqueue_media_scripts',1);
function userpro_enqueue_media_scripts(){
	wp_enqueue_script("media_js",userpro_media_url."scripts/mediauploader.js",array('jquery'),'',true);
	wp_enqueue_script("sharebutton_js",userpro_media_url."scripts/sharebutton.js",array('jquery'),'',true);
	wp_register_style('fontowsome', userpro_media_url.'lib/font-awesome-4.2.0/css/font-awesome.min.css');
	wp_enqueue_style('fontowsome');
	wp_enqueue_style("media_display_css",userpro_media_url."css/userpro-media.min.css");
	
}

function media_get_role_by_id($uid) {
	global $wp_roles;
	$user = get_user_by('id', $uid);
	$roles = $user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? $role : false;
}

function get_media_count($user_id) {
	$medias=get_option('userpro_media_gallery');
	$count = 0;
	foreach($medias as $media)
	{
		if($media['user_id']==$user_id)
		{
			if(file_exists($media['media_path']))
			{
				$count++;
			}
		}
	}
	return $count;
}

