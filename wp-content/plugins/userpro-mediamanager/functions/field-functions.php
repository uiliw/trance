<?php
function report_to_admin($media_id)
{
	$reported_media=get_option("reportedmedia");
	$user_ID=get_current_user_id();
	if(!is_array($reported_media))$reported_media = array();
	$html='';
	$flag=0;
	
	foreach($reported_media as $media)
	{
		if($media['mediaid']==$media_id)
		$flag=1;
	}
	if ($flag=='0')
	{
		$html.='<i id='.$media_id .' onclick="media_report_admin('.$media_id .','.$user_ID.',this);" class="reportmedia fa fa-exclamation-circle"></i>';
	}
	else
	{
		$html.='<i class="fa fa-exclamation-circle"></i>';
	}
	return $html;

}


function likeanddislike($media_id)
{
	$userid=get_current_user_id();
	$like_media=get_option("like_".$media_id);
	$dislike_media=get_option("dislike_".$media_id);
	if(!is_array($like_media))$like_media = array();
	if(!is_array($dislike_media)) $dislike_media= array();
   	if (!in_array($userid, $like_media) &&  !in_array($userid, $dislike_media))
	{	
		$dislikecnt=empty($dislike_media)? 0 : count($dislike_media);
		$likecnt= empty($like_media)? 0 : count($like_media);
		$html="<div class='userpro_likedislike_$media_id'>";	
		$html.="<i onclick='media_manager_like($media_id,$userid,$likecnt,$dislikecnt)' id='userpro_media_like_$media_id' class='userpro_media fa fa-thumbs-up '></i>&nbsp;";
		$html.= empty($like_media)? 0 : count($like_media);
		$html.="&nbsp;&nbsp;&nbsp;";	
		$html.="<i onclick='media_manager_dislike($media_id,$userid,$dislikecnt,$likecnt)' id='userpro_media_dislike_$media_id' class='userpro_media fa fa-thumbs-down '></i>&nbsp;"; 
		$html.= empty($dislike_media)? 0 : count($dislike_media);
		$html.="</div>";
	}
	else
	{
		if(count($like_media)>0)
			$html='<i class="userpro_media_like fa fa-thumbs-up" style="color:green;"></i> &nbsp;';
		else 
			$html='<i class="userpro_media_like fa fa-thumbs-up"></i> &nbsp;';
		$html.= empty($like_media)? 0 : count($like_media);
		if(count($dislike_media)>0)
	    	$html.='&nbsp;<i class="userpro_media_like fa fa-thumbs-down" style="color:red;"></i> &nbsp;';
		else
			$html.='&nbsp;<i class="userpro_media_like fa fa-thumbs-down"></i> &nbsp;';
		$html.= empty($dislike_media)? 0 : count($dislike_media);
	}
	
return $html;
}
/*Start by Yogesh B for display sharebuttons*/
function userpro_media_sharebutton($url)
	{
	
		if(userpro_media_get_option('media_socialshare')=='1')
		{				
		$html='';
 		$html.='<div class="a2a_kit a2a_default_style" data-a2a-url="'.$url.'">';
		  $html.='<a class="a2a_button_facebook"></a>';
		  $html.='<a class="a2a_button_twitter"></a>';
		   $html.='<a class="a2a_button_google_plus"></a>';
		$html.='<a class="a2a_button_linkedin"></a>';
	
		$html.="</div>";
		return $html;      
		}
}
/*End by Yogesh B for display sharebuttons*/
add_action('userpro_after_fields','userpro_media_manager');
function userpro_media_manager($arg0){
		$show_photos_to_followers = userpro_media_get_option('show_photos_to_followers');
		$show_videos_to_followers  = userpro_media_get_option('show_videos_to_followers');
		$show_music_to_followers  = userpro_media_get_option('show_music_to_followers');
		$followers_arr = get_user_meta( $arg0['user_id'], '_userpro_followers_ids', true );
		$followers = 0;
		$display_tab = 1;
		if( $show_photos_to_followers || $show_videos_to_followers || $show_music_to_followers){
		if( isset($followers_arr) && is_array($followers_arr) ){
			
		$followers_arr = array_keys( $followers_arr );
		if( in_array( get_current_user_id(), $followers_arr )){
			$followers = 1;
			}
		  }
		}
		if( $arg0['user_id']==get_current_user_id()){
			$followers = 1;
		}
		if( $show_photos_to_followers && $show_videos_to_followers && $show_music_to_followers && !$followers ){
			$display_tab = 0;
		}
	
	global $userpro_media_manager;
	if(!isset($arg0['media']))
	{
		$arg0['media'] = '';
	}
	if ((is_user_logged_in() && $arg0['template']==='view' || userpro_media_get_option('media_display')=='n' && $arg0['template']==='view' ))
	{
	$user_ids= explode(',',$arg0['user_id']);
	foreach($user_ids as $user_id)
	{
		$user_info = get_userdata($user_id);
      		$user_name = $user_info->user_login;	
		$user_name = ucfirst($user_name);
		if( $display_tab ){			
		?><div class='userpro-section userpro-column userpro-collapsible-1 userpro-collapsed-0'><?php _e('Media Gallery for  '. $user_name,'userpro-media');?></div>
		<?php
		}
		$count=0;$photo=0;$video=0;$music=0;
		$medias=get_option('userpro_media_gallery');
		if(!empty($medias)){		
		foreach($medias as $media)
		{
			if(isset($media['media_type']) && ($media['media_type']=='photo' || $media['media_type']=='video' || $media['media_type']=='music') && $media['user_id']==$user_id)
			{
				if((isset($media['media_path']) && file_exists($media['media_path'])) ||  (isset($media['type'])&& $media['type']=="youtube"))
				{
					if($media['media_type']=='photo')
						$photo++;
					if($media['media_type']=='video')
						$video++;
					if($media['media_type']=='music')
						$music++;
					$count++;
				}
			}
			if(isset($media['user_id']) && $media['user_id']!=$user_id && count($photo) == 0 && count($video) == 0 && count($music) == 0) 
			{
				$media_flag = true;	
			}
			else
			{
				$media_flag = false;	
			}
		
			
		}
	        if($media_flag == true && $arg0['media'] == 'view')
		{
			
			_e("No Photos, Videos or Music in the gallery uploaded yet",'userpro-media');
			

		}

		}
		$inst_username = userpro_profile_data( 'insta_username', $user_id );
		
		if($count>0 || $inst_username != '')
		{
			?>
		<div class='userpro-field userpro-field-all-media userpro-field-view'>
		
		<div id="navmediacontainer">
			<ul>
				<?php if( ((isset($arg0['disable_photos_tab']) && !$arg0['disable_photos_tab']) || !isset($arg0['disable_photos_tab'])) && (!$show_photos_to_followers || ($show_photos_to_followers && $followers))){ ?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>1',<?php echo $arg0['user_id'];?>);" id="photo_tab<?php echo $arg0['user_id'];?>" style="background-color:#fff;color:#000"><?php _e('Photos','userpro-media');?></a></li>
				<?php
					} 
					if( ((isset($arg0['disable_videos_tab']) && !$arg0['disable_videos_tab']) || !isset($arg0['disable_videos_tab'])) && (!$show_videos_to_followers || ($show_videos_to_followers && $followers)) ){ 
				?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>2',<?php echo $arg0['user_id'];?>);" id="video_tab<?php echo $arg0['user_id'];?>"><?php _e('Videos','userpro-media');?></a></li>
				<?php }
					if( ((isset($arg0['disable_music_tab']) && !$arg0['disable_music_tab']) || !isset($arg0['disable_music_tab'])) && (!$show_music_to_followers || ($show_music_to_followers && $followers)) ) {
				?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>3',<?php echo $arg0['user_id'];?>);" id="music_tab<?php echo $arg0['user_id'];?>"><?php _e('Music','userpro-media');?></a></li>
					<?php }
				if( ((isset($arg0['disable_instagram_tab']) && !$arg0['disable_instagram_tab']) || !isset($arg0['disable_instagram_tab'])) && (!$show_photos_to_followers || ($show_photos_to_followers && $followers))){ ?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>4',<?php echo $arg0['user_id'];?>);" id="instagram_tab<?php echo $arg0['user_id'];?>"><?php _e('Instagram','userpro-media');?></a></li>
				<?php
					}  ?>	
			</ul>
			<div class="media_container">
			<?php if( ((isset($arg0['disable_photos_tab']) && !$arg0['disable_photos_tab']) || !isset($arg0['disable_photos_tab'])) && (!$show_photos_to_followers || ($show_photos_to_followers && $followers))){ ?>
				<div id="photo_tab_data<?php echo $user_id;?>" class="media_tab_data"><br/><div class="media_clear"></div>
				  	<?php 
					if($photo>0)
					{
						$userpro_media_manager->get_media_list_view('photos',$user_id);
					}
					else
					{
						_e("No Photos in the gallery",'userpro-media');
					}
					?>
					<div class="userpro-clear"></div>
			  </div>
			  <?php }
			  if( ((isset($arg0['disable_videos_tab']) && !$arg0['disable_videos_tab']) || !isset($arg0['disable_videos_tab'])) && (!$show_videos_to_followers || ($show_videos_to_followers && $followers)) ){
			  ?>
				<div id="video_tab_data<?php echo $user_id;?>" style="display:block" class="media_tab_data"><br/><div class="media_clear"></div>
				  	<?php
					if($video>0)
					{
						$userpro_media_manager->get_media_list_view('videos',$user_id);
					}
					else
					{
						_e("No Videos in the gallery",'userpro-media');
					}
					?>
					<div class="userpro-clear"></div>
			  </div>
			  <?php }
			  if( ((isset($arg0['disable_music_tab']) && !$arg0['disable_music_tab']) || !isset($arg0['disable_music_tab'])) && (!$show_music_to_followers || ($show_music_to_followers && $followers)) ) {
			  ?>
				<div id="music_tab_data<?php echo $user_id;?>" style="display:block" class="media_tab_data"><br/><div class="media_clear"></div>
				  	<?php
					if($music>0) 
					{
						$userpro_media_manager->get_media_list_view('music',$user_id);
					}
					else
					{
						_e("No Music files in the gallery",'userpro-media');
					}
					?>
					<div class="userpro-clear"></div>
			  </div>
			  <?php }
			  if( ((isset($arg0['disable_instagram_tab']) && !$arg0['disable_instagram_tab']) || !isset($arg0['disable_instagram_tab'])) && (!$show_music_to_followers || ($show_music_to_followers && $followers)) ) {
			  	?>
			  				<div id="instagram_tab_data<?php echo $user_id;?>" style="display:block" class="media_tab_data"><br/><div class="media_clear"></div>
			  				  	<?php
			  					$insmedia = $userpro_media_manager->get_instagram_view($inst_username);
			  					if(!empty($insmedia)){?> 
			  					<div><input type="button" value="Follow me on Instagram" onClick="window.open('http://instagram.com/<?php echo $inst_username; ?>')" /></div>
			  					<?php
			  					if(!empty($insmedia['data'])){
			  					$i = 0;
			  					$options=get_option('userpro_media');
			  					$count = $options['instagram_img_count'];
								foreach ($insmedia['data'] as $insta):
									if($count == $i){ break;}
									$i++;
									$img = $insta['images']['low_resolution']['url'];
									$link = $insta["link"];
								?>
								<div class="thumbnail_media">
								    <a class="userpro-tip-fade lightview" data-lightview-group="instagram" href="<?php echo $img;?>">
						            	 <img src="<?php echo $img; ?>" width="175" style="float:left !important;" />
						            </a>
						        </div>   
						        <?php endforeach ;
			  					}else{
			  						_e("No Image in your Instagram Account",'userpro-media');
			  					}
			  				
			  					}else{
			  						_e("You have entered invalid username",'userpro-media');
			  					}
			  					?>
			  					
			  					<div class="userpro-clear"></div>
			  			  </div>
			  			  <?php }?>
			  
			</div>
		</div>
		</div>
		<?php
		}

}//user_id foreach
		?>
	<?php
	}
	else if(  is_user_logged_in() && $arg0['template']==='edit' &&  is_media_upload_allowed() ){$i=$arg0['unique_id'];$data='';$options=get_option('userpro_media');
		$count=0;$photo=0;$video=0;$music=0;
		$medias=get_option('userpro_media_gallery');
		delete_option('userpro_media_gallery_temp_data');
		if(!empty($medias))
		{
		foreach($medias as $media)
		{
			if(isset($media['media_type']) && ($media['media_type']=='photo' || $media['media_type']=='video' || $media['media_type']=='music') && $media['user_id']==$arg0['user_id'])
			{
				if((isset($media['media_path']) && file_exists($media['media_path'])) || (isset($media['type'])&& $media['type']=="youtube"))
				{
					if($media['media_type']=='photo')
						$photo++;
					if($media['media_type']=='video')
						$video++;
					if($media['media_type']=='music')
						$music++;
				}
			}
		}
		}
		?><div class='userpro-section userpro-column userpro-collapsible-1 userpro-collapsed-0' ><?php _e('Media Gallery','userpro-media');?></div>
		<div class='userpro-field userpro-field-all-media userpro-field-view'>
		<div id="navmediacontainer">
			<ul>
				<?php if( (isset($arg0['disable_photos_tab']) && !$arg0['disable_photos_tab']) || !isset($arg0['disable_photos_tab']) ){ ?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>1',<?php echo $arg0['user_id'];?>);" id="photo_tab<?php echo $arg0['user_id'];?>" style="background-color:#fff;color:#000"><?php _e('Photos','userpro-media');?></a></li>
				<?php
					} 
					if( (isset($arg0['disable_videos_tab']) && !$arg0['disable_videos_tab']) || !isset($arg0['disable_videos_tab']) ){ 
				?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>2',<?php echo $arg0['user_id'];?>);" id="video_tab<?php echo $arg0['user_id'];?>"><?php _e('Videos','userpro-media');?></a></li>
				<?php }
					if( (isset($arg0['disable_music_tab']) && !$arg0['disable_music_tab']) || !isset($arg0['disable_music_tab']) ) {
				?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>3',<?php echo $arg0['user_id'];?>);" id="music_tab<?php echo $arg0['user_id'];?>"><?php _e('Music','userpro-media');?></a></li>
				<?php }
				if( (isset($arg0['disable_instagram_tab']) && !$arg0['disable_instagram_tab']) || !isset($arg0['disable_instagram_tab']) ){ ?>
				<li><a href="#" onclick="change_media_tab('<?php echo $arg0['user_id'];?>4',<?php echo $arg0['user_id'];?>);" id="instagram_tab<?php echo $arg0['user_id'];?>" style="background-color:#fff;color:#000"><?php _e('Instagram','userpro-media');?></a></li>
				<?php
				    }  ?>
			</ul>
			<div class="media_container">
			  <?php if( (isset($arg0['disable_photos_tab']) && !$arg0['disable_photos_tab']) || !isset($arg0['disable_photos_tab']) ){ ?>
				<div id="photo_tab_data<?php echo $arg0['user_id'];?>" class="media_tab_data"><br/><div class="media_clear"></div>
					<?php	
					$current_role= media_get_role_by_id(get_current_user_id());
						if($options['media_photo_upload_count']=="y")
						{
							$data="<p>".sprintf(__('You have uploaded %s image/s','userpro-media'),$photo)."</p>";
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
						if($image_count>0 || $options['media_photo_number_limit_'.$current_role]=='-1')
						{
					 		$data.="<div id='media_photo_uploader' class = 'userpro-input' style='float:left'>";
						
						$data.="<div class = 'userpro-pic userpro-photo-file' data-remove_text='".__('Remove','userpro')."'></div>";
							$data.="<div class = 'userpro-media-upload' data-filetype = 'photo' data-limitiation='' data-upload_limit='".$image_count."' data-allowed_extensions = '".$options['media_photo_extension_list']."'>".__('Upload New Photo','userpro-media')."</div>";
						$data.="<input data-required='0' type='hidden' name='photo-$i' id='photo-$i' value='' />";
						if($options['media_photo_size_limit']<=wp_max_upload_size()/(1024*1024))
						{
							$data.= sprintf(__('Max Upload limit is %s MB','userpro-media'),$options['media_photo_size_limit']);
						}
						else
						{
						$data.= sprintf(__('Max Upload limit is %s MB','userpro-media'),wp_max_upload_size()/(1024*1024));
						}
					$data.="</div><br/><br/>";
						}
						if($options['media_photo_type']=='y')
							echo $data;
				?><div class="media_clear"></div>
					<?php
					if($photo>0){
						echo $userpro_media_manager->get_media_list_edit('photos',$arg0['user_id']);
					}
					else
					{
						_e("No Photos in the gallery",'userpro-media');
					}?>
					<div class="userpro-clear"></div>
			  </div>
			  <?php }
			  if( (isset($arg0['disable_videos_tab']) && !$arg0['disable_videos_tab']) || !isset($arg0['disable_videos_tab']) ) {
			  ?>
				<div id="video_tab_data<?php echo $arg0['user_id'];?>" style="display:block" class="media_tab_data"><br/><div class="media_clear"></div>
					<?php
					$current_role= media_get_role_by_id(get_current_user_id());
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
						if($video_count>0 || $options['media_video_number_limit_'.$current_role]=='-1')
						{
					 		$data.="<div class = 'userpro-input' id='userinput' style='float:left'>";
						$data.="".__('Enter YouTube iFrame code','userpro-media')."<input type=text name='youtube_' id='youtube_url'></br></br>";
						$data.=" <input type='button' value='Submit' class='userpro-button' onclick=mediamanager_youtube_url('youtube_url',this)>";
						$data.="<div class = 'userpro-pic userpro-video-file' data-remove_text='".__('Remove','userpro')."'></div>";
							$data.="<div class = 'userpro-media-upload' data-limitiation='' data-filetype = 'video' data-upload_limit='".$video_count."' data-allowed_extensions = '".$options['media_video_extension_list']."'>".__('Upload New Video','userpro-media')."</div>";
						$data.="<input data-required='0' type='hidden' name='video-$i' id='video-$i' value='' />";
						if($options['media_video_size_limit']<=wp_max_upload_size()/(1024*1024))
						{
							$data.= sprintf(__('Max Upload limit is %s MB','userpro-media'),$options['media_video_size_limit']);
						}
						else
						{
						$data.= sprintf(__('Max Upload limit is %s MB','userpro-media'),wp_max_upload_size()/(1024*1024));
						}
						$data.="</div><br/><br/>";
						}
						if($options['media_video_type']=='y')
							echo $data;
					?><div class="media_clear"></div>
					<?php 
					
						echo $userpro_media_manager->get_media_list_edit('videos',$arg0['user_id']);
					
					?>
					<div class="userpro-clear"></div>
			  </div>
			  <?php }
			  if( (isset($arg0['disable_music_tab']) && !$arg0['disable_music_tab']) || !isset($arg0['disable_music_tab']) ) {
			  ?>
				<div id="music_tab_data<?php echo $arg0['user_id'];?>" style="display:block" class="media_tab_data"><br/><div class="media_clear"></div>
					<?php
						$current_role= media_get_role_by_id(get_current_user_id());
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
						if($music_count>0 || $options['media_music_number_limit_'.$current_role]=='-1')
						{
					 		$data.="<div class = 'userpro-input' style='float:left'>";
							$data.="<div class = 'userpro-pic userpro-music-file' data-remove_text='".__('Remove','userpro')."'></div>";
							$data.="<div class = 'userpro-media-upload' data-limitiation='' data-filetype = 'music' data-upload_limit='".$music_count."' data-allowed_extensions = '".$options['media_music_extension_list']."'>".__('Upload New Music','userpro-media')."</div>";
						$data.="<input data-required='0' type='hidden' name='music-$i' id='music-$i' value='' />";
						if($options['media_music_size_limit']<=wp_max_upload_size()/(1024*1024))
						{
							$data.=sprintf(__('Max Upload limit is %s MB','userpro-media'),$options['media_music_size_limit']);
						}
						else
						{
						$data.= sprintf(__('Max Upload limit is %s MB','userpro-media'),wp_max_upload_size()/(1024*1024));
						}
						$data.="</div><br/><br/>";
						}
						if($options['media_music_type']=='y')
							echo $data;
					?><div class="media_clear"></div>
					<?php 
					if($music>0)
					{
						echo $userpro_media_manager->get_media_list_edit('music',$arg0['user_id']);
					}
					else{
						_e("No Music files in the gallery",'userpro-media');
					}
					?>
					<div class="userpro-clear"></div>
			  </div>
			  <?php }
			  if( (isset($arg0['disable_instagram_tab']) && !$arg0['disable_instagram_tab']) || !isset($arg0['disable_instagram_tab']) ) {
			  	?>
			  		<div id="instagram_tab_data<?php echo $arg0['user_id'];?>" style="display:block" class="media_tab_data"><br/><div class="media_clear"></div>
			  		  <?php
	  						$user_id = $arg0['user_id'];
	  						$value = userpro_profile_data( 'insta_username', $user_id );
	  						$data = '';
  					 		$data.="<div class = 'userpro-input' style='float:left'>";
  							$data.="<div >".__('Instagram Username','userpro-media')."<input type='text' id='insta_username-$i' name='insta_username-$i' value='".$value."'></div>";
  						
  						$data.="</div><br/>";
  					echo $data;
  					?><div class="media_clear"></div>
  					
  					<div class="userpro-clear"></div>
  			  </div>
  			  <?php }?>
			</div>
		</div>
		</div>
<?php

	}
}
function is_media_upload_allowed() {
	$urole = media_get_current_user_role();
	$restricted_roles = userpro_media_get_option('media_roles_cant_upload_media');
	if($restricted_roles=='')
		$restricted_roles = array();
	if(in_array($urole, $restricted_roles))
		return false;
	else
		return true;
}

function media_get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? $role : false;
}

