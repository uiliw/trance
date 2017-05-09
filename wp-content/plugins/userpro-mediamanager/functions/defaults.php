<?php

	/* get a global option */
	function userpro_media_get_option( $option ) {
		$userpro_default_options = userpro_media_default_options();
		$settings = get_option('userpro_media');
		switch($option){
		
			default:
				if (isset($settings[$option])){
					return $settings[$option];
				} else {
					return $userpro_default_options[$option];
				}
				break;
	
		}
	}
	
	/* set a global option */
	function userpro_media_set_option($option, $newvalue){
		$settings = get_option('userpro_media');
		$settings[$option] = $newvalue;
		update_option('userpro_media', $settings);
	}
	
	/* default options */
	function userpro_media_default_options(){
		$array = array();
		$array['media_comments'] = 'n';
		$array['media_approve'] = '0';
		$array['media_view'] = 'n';
		$array['media_socialshare'] = '1';
		$array['media_hidefile'] = 'n';
		$array['media_restrict'] = 'n';
		$array['media_display'] = 'n';
		$array['media_per_page'] = 10;
		$array['media_photo_type'] = 'y';
		$array['media_video_type'] = 'y';
		$array['media_music_type'] = 'y';
		$array['show_photos_to_followers'] = 0;
		$array['show_videos_to_followers'] = 0;
		$array['show_music_to_followers'] = 0;
		$array['media_photo_extension_list']='jpg,jpeg,png,gif';
		$array['media_video_extension_list']='mp4,avi,mpg,flv';
		$array['media_music_extension_list']='mp3,wav';
		$array['media_photo_size_limit']=round(wp_max_upload_size()/(1024*1024),2,PHP_ROUND_HALF_DOWN);
		$array['media_video_size_limit']=round(wp_max_upload_size()/(1024*1024),2,PHP_ROUND_HALF_DOWN);
		$array['media_music_size_limit']=round(wp_max_upload_size()/(1024*1024),2,PHP_ROUND_HALF_DOWN);
		$array['instagram_img_count'] = 5;
		$array['instagram_app_key'] = '';
		if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
		$roles = $wp_roles->get_names();
		foreach($roles as $k=>$v) {
			$array['media_photo_number_limit_'.$k]='-1';
			$array['media_video_number_limit_'.$k]='-1';
			$array['media_music_number_limit_'.$k]='-1';
			
		}
		$array['media_photo_upload_count']='n';
		$array['media_video_upload_count']='n';
		$array['media_music_upload_count']='n';
		$array['media_roles_cant_upload_media'] = '';
		if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
		$roles = $wp_roles->get_names();
		foreach($roles as $k=>$v) {
			$array['media_'.$k.'_limitation'] = 0;
		}
		return apply_filters('userpro_media_default_options_array', $array);
	}

	function userpro_media_add_new_media($option,$newvalue){
		$array=array();
		$array['user_id']=$newvalue['user_id'];
		$array['media_name']=$newvalue['media_name'];
		$array['media_display_name']=$newvalue['media_display_name'];
		$array['media_type']=$newvalue['media_type'];
		$array['media_url']=$newvalue['media_url'];
		$array['media_path']=$newvalue['media_path'];
		$array['media_restriction']='public';
		$array['thumbnail_path']=$newvalue['thumbnail_path'];
		if( userpro_media_get_option('media_approve')=='1')
			$array['admin_approve']='1';
		
		if(empty($option))
		{
			$array['media_id']=0;
		}
		else
		{
			$array['media_id']=sizeof($option);
		}
		array_push($option,$array);
		update_option('userpro_media_gallery',$option);
	}
	
	function userpro_media_temp_add_new_media($option,$newvalue){
		$array=array();
		$array['user_id']=$newvalue['user_id'];
		$array['media_name']=$newvalue['media_name'];
		$array['media_display_name']=$newvalue['media_display_name'];
		$array['media_type']=$newvalue['media_type'];
		$array['media_url']=$newvalue['media_url'];
		$array['media_path']=$newvalue['media_path'];
		$array['thumbnail_path']=$newvalue['thumbnail_path'];
		if(empty($option))
		{
			$array['media_id']=0;
		}
		else
		{
			$array['media_id']=sizeof($option);
		}
		array_push($option,$array);
		
		update_option('userpro_media_gallery_temp_data',$option);
	}
