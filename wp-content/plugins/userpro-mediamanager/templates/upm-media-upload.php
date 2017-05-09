<?php
	$options=get_option('userpro_media');
	$current_role= media_get_role_by_id(get_current_user_id());
	$medias=get_option('userpro_media_gallery');
	$thumnail_photos = $thumnail_videos = $thumnail_musics = '';
	delete_option('userpro_media_gallery_temp_data');
	$count=$photo=$video=$music=0;
	$i = rand();
	$user_id = get_current_user_id();
	if(!empty($medias))
	{
		foreach($medias as $media)
		{
			if( isset( $media['user_id'] ) && ($media['user_id'] == $user_id ) ){
			if(isset($media['media_name']) && get_option($media['media_name'])!='')
			{
				$media['media_display_name']=get_option($media['media_name']);
			}
			if(isset($media['media_type']) && ($media['media_type']=='photo' || $media['media_type']=='video' || $media['media_type']=='music'))
			{
				if((isset($media['media_path']) && file_exists($media['media_path'])) || (isset($media['type'])&& $media['type']=="youtube"))
				{
					if($media['media_type']=='photo'){
						$file_id = $photo++ ."_photo";
						$thumnail_photos .= '<div class="upm-thumbnail" id="'.$file_id.'"> <span class="upm_remove" onclick=userpro_delete_files("'.$media['media_path'].'","'.get_current_user_id().'","'.$file_id.'")>&times;</span><div class="upp-image"><img src="'.$media['thumbnail_path'].'"></div><div class="upm_display_name">'.$media['media_display_name'].'</div></div>';
					}
					if($media['media_type']=='video'){
						$file_id = $video++ ."_video";
						$thumnail_videos .= '<div class="upm-thumbnail" id="'.$file_id.'"><span class="upm_remove" onclick=userpro_delete_files("'.$media['media_path'].'","'.get_current_user_id().'","'.$file_id.'")>&times;</span><video width="400" height="400" controls> <source src="'.$media['media_url'].'"></video></div>';
					}
					if($media['media_type']=='music'){
						$file_id = $music++ ."_music";
						$thumnail_musics .= '<div class="upm-thumbnail" id="'.$file_id.'"><span class="upm_remove" onclick=userpro_delete_files("'.$media['media_path'].'","'.get_current_user_id().'","'.$file_id.'")>&times;</span><audio controls><source src="'.$media['media_url'].'"></audio></div>';
					}
				}
			}
		}
		}
	}
	if($options['media_photo_upload_count']=="y")
	{
		if($options['media_photo_number_limit_'.$current_role]=='-1')
		{
			$image_count=99999999;
		}
		else
		{
			$image_count=$options['media_photo_number_limit_'.$current_role]-$photo;
		}
		if($options['media_photo_number_limit_'.$current_role]!='-1' && $image_count>0)
		{
			$data.="<p>".sprintf(__('You can now upload %s image/s','userpro-media'),$image_count)."</p>";
		}
	}
	else
	{
		if($options['media_photo_number_limit_'.$current_role]=='-1')
		{
			$image_count=99999999;
		}
		else
		{
			$image_count=$options['media_photo_number_limit_'.$current_role]-$photo;
		}
		$data="";
	}
	
	if($options['media_video_upload_count']=="y")
	{
		$data="<p>".sprintf(__('You have uploaded %s video/s','userpro-media'),$video)."</p>";
		if($options['media_video_number_limit_'.$current_role]=='-1')
		{
			$video_count=99999999;
		}
		else
		{
			$video_count=$options['media_video_number_limit_'.$current_role]-$video;
		}
		if($options['media_video_number_limit_'.$current_role]!='-1' && $video_count>0)
		{
			$data.="<p>".sprintf(__('You can now upload %s video/s','userpro-media'),$video_count)."</p>";
		}
	}
	else
	{
		if($options['media_video_number_limit_'.$current_role]=='-1')
		{
			$video_count=99999999;
		}
		else
		{
			$video_count=$options['media_video_number_limit_'.$current_role]-$video;
		}
			$data="";
	}
						
	if($options['media_music_upload_count']=="y")
	{
		$data="<p>".sprintf(__('You have uploaded %s audio/s','userpro-media'),$music)."</p>";
		if($options['media_music_number_limit_'.$current_role]=='-1')
		{
			$music_count=99999999;
		}
		else
		{
			$music_count=$options['media_music_number_limit_'.$current_role]-$music;
		}
		if($options['media_music_number_limit_'.$current_role]!='-1' && $music_count>0)
		{
			$data.="<p>".sprintf(__('You can now upload %s audio/s','userpro-media'),$music_count)."</p>";
		}
	}
	else
	{
		if($options['media_music_number_limit_'.$current_role]=='-1')
		{
			$music_count=99999999;
		}
		else
		{
			$music_count=$options['media_music_number_limit_'.$current_role]-$music;
		}
			$data="";
	
	}
?>
<div class="profileDashboard dashboardRight" id = "dashboard-media-uploader">
	<div id = "upm_photo_div" class="userpro-dashboard userpro-<?php echo $i; ?> userpro-id-<?php echo $user_id; ?> " data-upload_limit= "<?php echo $image_count; ?>" data-allowed_extensions = "<?php echo $options['media_photo_extension_list'];?>">
		<div class="userpro-section userpro-column userpro-collapsible-0 userpro-collapsed-0"><?php _e( 'Upload Image', 'userpro-dashboard' );?></div>
		<div class="upm-thumb-container">
			<?php echo $thumnail_photos; ?>
		</div>
		<input type="button" id="upm-upload-image" value = "Upload Images" />
	</div>

	<div id = "upm_video_div" class="userpro-dashboard userpro-<?php echo $i; ?> userpro-id-<?php echo $user_id; ?> " data-upload_limit= "<?php echo $video_count; ?>" data-allowed_extensions = "<?php echo $options['media_video_extension_list'];?>">
		<div class="userpro-section userpro-column userpro-collapsible-0 userpro-collapsed-0"><?php _e( 'Upload Video', 'userpro-dashboard' );?></div>
			<!-- <label><?php _e( 'Enter youtube iframe code:' );?></label>
			<input type = 'text' id="youtube_url" name="youtube_">
			<input class="userpro-button" type="button" onclick="mediamanager_youtube_url('youtube_url',this)" value="Submit"> -->
			<div class="upm-thumb-container">
				<?php echo $thumnail_videos; ?>
			</div>	
			<input type="button" id="upm-upload-video" value = "Upload Videos" />
			
	</div>

	<div id = "upm_music_div" class="userpro-dashboard userpro-<?php echo $i; ?> userpro-id-<?php echo $user_id; ?> " data-upload_limit= "<?php echo $music_count; ?>" data-allowed_extensions = "<?php echo $options['media_music_extension_list'];?>">
		<div class="userpro-section userpro-column userpro-collapsible-0 userpro-collapsed-0"><?php _e( 'Upload Music', 'userpro-dashboard' );?></div>
		<div class="upm-thumb-container">			
			<?php echo $thumnail_musics; ?>
		</div>
		<input type="button" id="upm-upload-music" value = "Upload Musics" />
	</div>
	<input type="hidden" id="upm_user_id" value="<?php echo get_current_user_id();?>">
</div>
