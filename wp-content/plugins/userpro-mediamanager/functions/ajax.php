<?php
	add_action('wp_head','userpro_ajax_media_url');
	function userpro_ajax_media_url() { 
		?>
		<script type="text/javascript">
			var userpro_ajax_media_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
	<?php
	}
	add_action('wp_head','userpro_media_upload_url');
	function userpro_media_upload_url() { ?>
		<script type="text/javascript">
		var userpro_media_upload_url = '<?php echo userpro_media_url . 'lib/fileupload/fileupload.php'; ?>';
		</script>
	<?php
	}

	add_action('wp_head','userpro_photo_upload_size');
	function userpro_photo_upload_size() { 
		$options=get_option('userpro_media');
		if($options['media_photo_size_limit']<=wp_max_upload_size()/(1024*1024))
		{
			$max_file_size=$options['media_photo_size_limit'];
		}
		else
		{
			$max_file_size=wp_max_upload_size()/(1024*1024);
		}
		?>
		<script type="text/javascript">
		var userpro_photo_upload_size = '<?php echo $max_file_size."MB"; ?>';
		</script>
	<?php
	}


	

	function userpro_video_upload_size() { 
		$options=get_option('userpro_media');
		if($options['media_video_size_limit']<=wp_max_upload_size()/(1024*1024))
		{
			$max_file_size=$options['media_video_size_limit'];
		}
		else
		{
			$max_file_size=wp_max_upload_size()/(1024*1024);
		}
		?>
		<script type="text/javascript">
		var userpro_video_upload_size = '<?php echo $max_file_size."MB"; ?>';
		</script>
	<?php
	}

add_action('wp_ajax_nopriv_mediamanager_admin_ignore_media', 'mediamanager_admin_ignore_media');
add_action('wp_ajax_mediamanager_admin_ignore_media', 'mediamanager_admin_ignore_media');
function mediamanager_admin_ignore_media()
{
	$medialist = (array)get_option("reportedmedia");
		
		$key = array_search($_POST['media_id'], $medialist,true);
		
		unset($medialist[$key]);
		update_option('reportedmedia',$medialist);
}
add_action('wp_ajax_nopriv_mediamanager_admin_approve_media', 'mediamanager_admin_approve_media');
add_action('wp_ajax_mediamanager_admin_approve_media', 'mediamanager_admin_approve_media');
function mediamanager_admin_approve_media()
{
	
	$media_array = get_option("userpro_media_gallery");
	for($i=(count($media_array)-1);$i>=0;$i--)
		{		

			if(isset($media_array[$i]['media_id']) && $media_array[$i]['media_id']==$_POST['media_id'])
			{
				$media_array[$i]['admin_approve']='0';
				
			}
		}
		update_option('userpro_media_gallery',$media_array);
}

add_action('wp_ajax_nopriv_reportmedia_to_admin', 'reportmedia_to_admin');
add_action('wp_ajax_reportmedia_to_admin', 'reportmedia_to_admin');
function reportmedia_to_admin()
{

	$reported_media=get_option("reportedmedia");
	
	if(is_array($reported_media))
		{
			array_push($reported_media,array("userid"=>$_POST['userid'],"mediaid"=>$_POST['media_id']));
		}
		else
		{
		$reported_media=array(array("userid"=>$_POST['userid'],"mediaid"=>$_POST['media_id']));
		}

	
	update_option("reportedmedia",$reported_media);

 
}

add_action('wp_ajax_nopriv_media_manager_like', 'media_manager_like');
add_action('wp_ajax_media_manager_like', 'media_manager_like');
function media_manager_like()
{
	$like_media=get_option("like_".$_POST['media_id']);
	
	if(is_array($like_media))
		{
			array_push($like_media,$_POST['user_id']);
		}
		else
		{
		$like_media=array($_POST['user_id']);
		}

	
	update_option("like_".$_POST['media_id'],$like_media);

}
add_action('wp_ajax_nopriv_media_manager_dislike', 'media_manager_dislike');
add_action('wp_ajax_media_manager_dislike', 'media_manager_dislike');
function media_manager_dislike()
{
$dislike_media=get_option("dislike_".$_POST['media_id']);
	
	if(is_array($dislike_media))
		{
			array_push($dislike_media,$_POST['user_id']);
		}
		else
		{
		$dislike_media=array($_POST['user_id']);
		}

	
	update_option("dislike_".$_POST['media_id'],$dislike_media);

}


/*added by Yogesh for display lable for img*/
add_action('wp_ajax_nopriv_add_capto_img', 'add_capto_img');
add_action('wp_ajax_add_capto_img', 'add_capto_img');
function add_capto_img()
	{
		 esc_attr($_POST['cap']);
		update_option($_POST['caplable'],$_POST['cap']);
	

	}

	
add_action('wp_ajax_nopriv_delete_youtubeurl', 'delete_youtubeurl');
add_action('wp_ajax_delete_youtubeurl', 'delete_youtubeurl');
	function delete_youtubeurl()
	{
		$urls = get_option("userpro_media_gallery");
		if(!current_user_can('manage_options')){
			foreach ($urls as $key => $value){
				if (($value["media_id"] == $_POST['media_id'] && $value["user_id"]==get_current_user_id()) ) 
				{
					unset($urls[$key]); 
				}
			}
		}
		else{
			foreach ($urls as $key => $value){
				if (($value["media_id"] == $_POST['media_id'] ))
				{
					unset($urls[$key]);
				}
			}
		}
		update_option('userpro_media_gallery',$urls);
	}
	
add_action('wp_ajax_nopriv_userpro_add_youtube_url', 'userpro_add_youtube_url');
add_action('wp_ajax_userpro_add_youtube_url', 'userpro_add_youtube_url');
function userpro_add_youtube_url()
{	
	$width=300;
	$height=200;	
	$newWidth = 0;
	$newHeight = 0;
	$userurl=preg_replace(
			array('/width="\d+"/i', '/height="\d+"/i'),
			array(sprintf('width="%d"', $width), sprintf('height="%d"', $height)),
			stripslashes($_POST['url'])); 
	$url = preg_replace(
			array('/width="\d+"/i', '/height="\d+"/i'),
			array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
			stripslashes($_POST['url']));
	

	$iframe = strpos($url,'<iframe');
	
        preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $url, $matches);
	if (!empty($matches['0'])) {

	$array=array();
	$array['user_id']=get_current_user_id();

	$array['media_url']=$url;
	$array['media_type']='video';
	$array['type']='youtube';
	if( userpro_media_get_option('media_approve')=='1')
	$array['admin_approve']='1';
	$youtube_urls=get_option('userpro_media_gallery');

            if(empty($youtube_urls))
		{  $youtube_urls=array();
			$array['media_id']=0;
		}
		else
		{
			$array['media_id']=sizeof($youtube_urls);
		}
		array_push($youtube_urls,$array);
		update_option('userpro_media_gallery',$youtube_urls);
		
           echo  "<div class='thumbnail_media videos'>$userurl<br></div>";
	   die();
	}
	else
	{
		echo "Invalid iFrame url";	
		die();
	}

}

/* Code added for Media Restriction : Start*/
add_action('wp_ajax_nopriv_userpro_save_media_restriction', 'userpro_save_media_restriction');
add_action('wp_ajax_userpro_save_media_restriction', 'userpro_save_media_restriction');
function userpro_save_media_restriction()
{
	$options = get_option('userpro_media_gallery');
	$media_id= $_POST['media_id'];
	
	$options[$media_id]['media_restriction'] = $_POST['radiovalue'];
	
	update_option('userpro_media_gallery',$options);
}

/* Code added for Media Restriction : End*/

	/* User media upload */
	add_action('wp_ajax_nopriv_userpro_media_upload', 'userpro_media_upload');
	add_action('wp_ajax_userpro_media_upload', 'userpro_media_upload');
	function userpro_media_upload(){
		if (!isset($_POST['src'])) die();
		$default_args = array (
    'action' => 'userpro_media_upload',
    'filetype' => '',
    'src' => '',
    'media_type' => '',
    'srcname' => '',
    'media_name' => '',
    'thumbnail_path' => ''
);
		foreach ($default_args as $key => $val){
			if(isset($_POST[$key])) {
				$$key = $_POST[$key];			
			}else {
				$$key = '';
			}
		}
		$media_name_list=explode("------",$media_name);
		$srcname_list=explode("------",$srcname);
		$src_list=explode("------",$src);
		$thumbnail_path_list=explode("------",$thumbnail_path);
		$output['response']="";
		for($count=0;$count<(count($media_name_list)-1);$count++)
		{
			$option=array('media_id'=>'','user_id'=>'','media_name'=>$media_name_list[$count],'media_type'=>$filetype,'media_display_name'=>$srcname_list[$count],'media_url'=>$src_list[$count],'media_path'=>'','thumbnail_path'=>$thumbnail_path_list[$count],'media_restriction'=>'');
		$options=get_option('userpro_media_gallery');
		if(empty($options))
			{
				userpro_media_add_new_media(array(),$option);
			}
		else{
			userpro_media_add_new_media($options,$option);
		}
		
		if ($filetype == 'media' || $filetype == 'photo' || $filetype == 'video' || $filetype == 'music') {
		$newsrc=$src;
			if ( strstr($src, 'wp-content')) {
				$src = explode('wp-content', $src);
				$src = $src[1];
				
				if ( userpro_get_option('ppfix') == 'b' ) {
					$src = '' . $src;
				} else {
					$src = '/wp-content' . $src;
				}
			}	
		}
			$media=$option;
			if ($filetype == 'media' || $filetype == 'video' || $filetype == 'music'){
				$medias=get_option('userpro_media_gallery_temp_data');
				if(empty($medias)){
					userpro_media_temp_add_new_media(array(),$media);
				}
				else{
					userpro_media_temp_add_new_media($medias,$media);
				}
				$media_list=get_option('userpro_media_gallery_temp_data');
				
				$media_id = sizeof($options);
				$uploaded_media_count = count($media_name_list) - 1 ;
					
				if( userpro_media_get_option('media_restrict') == 'y' ){					
					$output['response'] .= '<div id="'.basename($src_list[$count]).'" class="userpro-file-input"><a href="'.$src_list[$count].'">'.$srcname_list[$count].'</a><br/><br>Media Restriction<br> <input type="radio" class="userpro_mm_radio" name="public-'.$media_id.'" value="private" onclick="userpro_save_media_restriction('.$media_id.');"/>Private <br> <input type="radio" name="public-'.$media_id.'" value="public" class="userpro_mm_radio" checked=checked onclick="userpro_save_media_restriction('.$media_id.');"/>Public <br> <br><input type="button" value="Remove" class="userpro-button" onclick="delete_temp_media(\''.basename($src_list[$count]).'\')" /></div><br/>';
				}else{
					$output['response'] .= '<div id="'.basename($src_list[$count]).'" class="userpro-file-input"><a href="'.$src_list[$count].'">'.$srcname_list[$count].'</a><br/><br><input type="button" value="Remove" class="userpro-button" onclick="delete_temp_media(\''.basename($src_list[$count]).'\')" /></div><br/>';
				}
			
			} else if($filetype == 'photo'){
				
				$medias=get_option('userpro_media_gallery_temp_data');
				if(empty($medias)){
					userpro_media_temp_add_new_media(array(),$media);
				}
				else{
					userpro_media_temp_add_new_media($medias,$media);
				}
				$media_list=get_option('userpro_media_gallery_temp_data');
				
				$media_id = sizeof($options);
				$uploaded_media_count = count($media_name_list) - 1 ;
				
				if( userpro_media_get_option('media_restrict') == 'y' ){
					$output['response'] .= '<div id="'.basename($src_list[$count]).'" class="userpro-file-input"><a href="'.$src_list[$count].'">'.$srcname_list[$count].'</a><br/>Media Caption<input id="img_caption-'.$media_id.'" type="text" onblur="save_img_caption(\'img_caption-'.$media_id.'\',\''.basename($src_list[$count]).'\')"><br><br>Media Restriction<br> <input type="radio" class="userpro_mm_radio" name="public-'.$media_id.'" value="private" onclick="userpro_save_media_restriction('.$media_id.');"/>Private <br> <input type="radio" name="public-'.$media_id.'" value="public" class="userpro_mm_radio" checked=checked onclick="userpro_save_media_restriction('.$media_id.');"/>Public <br> <br><input type="button" value="Remove" class="userpro-button" onclick="delete_temp_media(\''.basename($src_list[$count]).'\')" /></div><br/>';
				}else{
					$output['response'] .= '<div id="'.basename($src_list[$count]).'" class="userpro-file-input"><a href="'.$src_list[$count].'">'.$srcname_list[$count].'</a><br/>Media Caption<input id="img_caption-'.$media_id.'" type="text" onblur="save_img_caption(\'img_caption-'.$media_id.'\',\''.basename($src_list[$count]).'\')"><br> <br><input type="button" value="Remove" class="userpro-button" onclick="delete_temp_media(\''.basename($src_list[$count]).'\')" /></div><br/>';
				}
			}
		}
		$output=json_encode($output);		
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}


	add_action('wp_ajax_nopriv_upm_upload_media', ' upm_upload_media');
	add_action('wp_ajax_upm_upload_media', 'upm_upload_media');

	function upm_upload_media(){
		$form = array();
		$i = 0;
		$form['template'] = 'edit';
		$form['group'] = 'default';
		$form[$_POST['filetype']] = $_POST['media'];
		$form['user_id'] = get_current_user_id();
		$src = explode('------',$_POST['media']);
		if( isset( $_POST['media_restriction'] ) && !empty( $_POST['media_restriction']) && $_POST['media_restriction'] != 'undefined' ){
			$media_restriction = explode( ',' , $_POST['media_restriction']); 
			array_pop($media_restriction);
		}
		userpro_update_user_profile( get_current_user_id(), $form, $action='ajax_save' );	
		if( $_POST['filetype'] == 'photo'){
			$media_caption_arr = explode(',', $_POST['media_caption']);
			foreach( $media_caption_arr as $media_caption ){
				update_option(basename($src[$i]),$media_caption);
				
				$i++;
			}
		}
		if( isset( $media_restriction ) ){
			$options = get_option('userpro_media_gallery');
	
			for($j=0;$j<count($media_restriction);$j++){
				$media_info = explode('_',$media_restriction[$j]);
				$options[$media_info[0]]['media_restriction'] = $media_info[1];
			}
			update_option('userpro_media_gallery',$options);
		}
	
	}
	
	add_action('wp_ajax_nopriv_userpro_media_delete', 'userpro_media_delete');
	add_action('wp_ajax_userpro_media_delete', 'userpro_media_delete');
	function userpro_media_delete(){
		global $userpro_media_manager,$userpro_media_api;
		if (!isset($_POST['file_name'])) die();
		$file_name = $userpro_media_api->get_uploads_dir_media($_POST['user_id']).basename($_POST['file_name']);
		if(!unlink($file_name))
		{
			echo "Error In deleting file";
		}
		
		if(isset($_POST['media_id']))
		{
						
		$medialist = (array)get_option("reportedmedia");
		
		$key = array_search($_POST['media_id'], $medialist);
		unset($medialist[$key]);
		update_option('reportedmedia',$medialist);
		}
		
	}

	
	add_action('wp_ajax_nopriv_userpro_temp_media_delete', 'userpro_temp_media_delete');
	add_action('wp_ajax_userpro_temp_media_delete', 'userpro_temp_media_delete');
	function userpro_temp_media_delete(){
		global $userpro_media_manager,$userpro_media_api;
		if (!isset($_POST['file_name'])) die();
		
		$file_name = $_POST['file_name'];
		
		$medias=get_option('userpro_media_gallery_temp_data');
		$options=array();
		foreach($medias as $media)
		{
			if($media['media_name']!==$file_name)
			{
				array_push($options,$media);
			}
		}
		update_option('userpro_media_gallery_temp_data',$options);
		if(!unlink($userpro_media_api->get_uploads_dir_media().$file_name))
		{
			echo "Error In deleting file";
		}
		else
		{
			if(file_exists($userpro_media_api->get_uploads_dir_media_thumbnail().$file_name))
			{
				if(!unlink($userpro_media_api->get_uploads_dir_media_thumbnail().$file_name))
				{
					echo "Error In deleting file";
				}
			}
		}
	}

	add_action('wp_ajax_nopriv_save_instagram_code', 'save_instagram_code');
	add_action('wp_ajax_save_instagram_code', 'save_instagram_code');
	function save_instagram_code(){
		
		$token = $_POST['access_token'];
	
		$output['redirect_uri'] = admin_url('admin.php?page=userpro-media&tab=instagram');
		update_option('UMM_instagram_access_token',$token);
		
		$output=json_encode($output);
		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
		
	}
