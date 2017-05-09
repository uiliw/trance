<?php

require_once("../../../../../wp-load.php");

global $userpro;
$userpro_media_api_temp=new userpro_media_api();
$userpro_media_api_temp->do_uploads_dir_media_thumbnail();
function resize($width, $height,$file_name,$file_temp,$file_type){
	global $userpro;
	$html = '';
	list($w, $h) = getimagesize($file_temp);

	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	$path = $userpro->get_uploads_dir().'thumbnail/'.$file_name;
	$url=$userpro->get_uploads_url().'thumbnail/'.$file_name;
	$imgString = file_get_contents($file_temp);
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);
	switch ($file_type) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $url;
	
	imagedestroy($image);
	imagedestroy($tmp);
}
// Secure file uploads
if( isset($_FILES["userpro_file"]) ) {
	$html = '';
	$options=get_option('userpro_media');
	if (!is_array($_FILES["userpro_file"]["name"])){
		die();
	}
	else if($_GET['upload_limit']<count($_FILES["userpro_file"]["name"])){
		$ret['limit_exceed']=1;
		echo json_encode($ret);
		die();
	} else {
		$size=0;
		$userpro_media_gallery_options = get_option('userpro_media_gallery');
		if( !empty( $options ) )
			$media_id = count( $userpro_media_gallery_options );
		else
			$media_id = 0;
		for($i=0;$i<count($_FILES["userpro_file"]["size"]);$i++)
		{
			$size+=$_FILES["userpro_file"]["size"][$i];
		}
		for($i=0;$i<count($_FILES["userpro_file"]["name"]);$i++)
		{
			if ($_FILES["userpro_file"]["error"][$i] > 0){
				continue;
		} else {
				if(!is_uploaded_file($_FILES["userpro_file"]["tmp_name"][$i])){
					continue;
				} elseif( $_FILES["userpro_file"]["size"][$i] > wp_max_upload_size() ){
					continue;
			} else {
					$array=str_split($_FILES["userpro_file"]["type"][$i],5);
					if($_FILES["userpro_file"]["size"][$i] > ($options["media_photo_size_limit"]*1024*1024) && $array[0]=='image')
				{
						continue;
				}
					elseif($_FILES["userpro_file"]["size"][$i] > ($options["media_video_size_limit"]*1024*1024) && $array[0]=='video')
				{
						continue;
				}
					elseif($_FILES["userpro_file"]["size"][$i] > ($options["media_music_size_limit"]*1024*1024) && $array[0]=='audio')
				{
						continue;
				}
					elseif($size > wp_max_upload_size())
					{
						die();
					}
				else
				{
						if(get_option('userpro_media_gallery_temp_data'))
						{
							$temp_files=get_option('userpro_media_gallery_temp_data');
							$photo_count = 0;
							$video_count = 0;
							$music_count = 0;
							foreach ($temp_files as $temp_file) {
								if($temp_file['media_type'] == 'photo'){
									$photo_count++;
								}elseif($temp_file['media_type'] == 'video') {
									$video_count++;
								}else {
									$music_count++;
								}
							}
							switch ($_GET['filetype']) {
								case 'photo':
									$count = $photo_count;
								break;
								case 'video':
									$count = $video_count;
								break;
								case 'music':
									$count = $music_count;
								break;
							}
							$limit_count_media=$count+count($_FILES["userpro_file"]["name"]);
							if($_GET['upload_limit']<$limit_count_media)
							{
								$ret['limit_exceed']=1;
								echo json_encode($ret);
								die();
							}
						}
						$file_extension = strtolower(strrchr($_FILES["userpro_file"]["name"][$i], "."));
						if(!is_array($_FILES["userpro_file"]["name"][$i])) {
						$unique_id = uniqid();
							if(isset($ret) && !is_array($ret))
						$ret = array();
						$target_file = $userpro->get_uploads_dir() . $unique_id . $file_extension;
						if(in_array($file_extension,array('.gif','.jpg','.jpeg','.png')))
								$ret[$i]['thumbnail_path']=resize(150,150,$unique_id . $file_extension,$_FILES["userpro_file"]["tmp_name"][$i],$_FILES["userpro_file"]["type"][$i]);
							
							move_uploaded_file( $_FILES["userpro_file"]["tmp_name"][$i], $target_file );
							$ret[$i]['target_file'] = $target_file;
							$ret[$i]['target_file_uri'] = $userpro->get_uploads_url() . basename($target_file);
							$ret[$i]['target_file_name'] = $_FILES["userpro_file"]["name"][$i];
							$ret[$i]['media_name']=$unique_id . $file_extension;

							if( $_GET['dash'] ){
								ob_start();
								include userpro_media_path.'templates/upm-single-media.php';
								$html .= ob_get_contents();
								ob_end_clean();
							}
							
						}
					}
				}
			}
		}
		echo json_encode(array('ret'=>$ret,'html'=>$html));
	}
}
else{
	die();
}
