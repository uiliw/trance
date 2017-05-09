<?php

class userpro_media_api{
	function __construct() {

		$this->temp_id = null;

		$this->upload_dir = wp_upload_dir();
		
		$this->upload_base_dir = $this->upload_dir['basedir'];
		$this->upload_base_dir=str_replace("\\","/",$this->upload_base_dir);

		if ( strstr( $this->upload_base_dir, 'wp-content/uploads/sites' ) ) { 
			$this->upload_base_dir = $this->str_before( $this->upload_base_dir, '/wp-content/uploads/sites' );
			$this->upload_base_dir = $this->upload_base_dir . '/wp-content/uploads/userpro/';
		} else {
			$this->upload_base_dir = $this->upload_base_dir . '/userpro/';
		}
		
		$this->upload_base_url = $this->upload_dir['baseurl'];
		if ( strstr( $this->upload_base_url, 'wp-content/uploads/sites' ) ) { 
			$this->upload_base_url = $this->str_before( $this->upload_base_url, '/wp-content/uploads/sites' );
			$this->upload_base_url = $this->upload_base_url . '/wp-content/uploads/userpro/';
		} else {
			$this->upload_base_url = $this->upload_base_url . '/userpro/';
		}
		
		$this->upload_path_wp = trailingslashit($this->upload_dir['path']);
		$this->upload_path = $this->upload_dir['basedir'] . '/userpro/';
	}

	/******************************************
	Delete a File Permanently
	******************************************/
	function delete_file($user_id, $key){
		if ( userpro_profile_data( $key, $user_id ) ) {
			$file = $this->get_uploads_dir($user_id) . basename( userpro_profile_data( $key, $user_id ) );
			if (file_exists($file)) {
				unlink($file);
			}
		}
	}


	/******************************************
	Get need before in string
	******************************************/
	function str_before($subject, $needle)
	{
		$p = strpos($subject, $needle);
		return substr($subject, 0, $p);
	}


	/******************************************
	Create uploads dir for media if does not exist
	******************************************/
	function do_uploads_dir_media($user_id=0) {
	
		if (!file_exists( $this->upload_base_dir . '.htaccess') ) {

$data = <<<EOF
<Files ~ "\.txt$">
Order allow,deny
Deny from all
</Files>
EOF;

			file_put_contents( $this->upload_base_dir . '.htaccess' , $data);
		}
	
		if (!file_exists( $this->upload_base_dir )) {
			@mkdir( $this->upload_base_dir, 0777, true);
		}
		
		if ($user_id > 0) { // upload dir for a user
			if (!file_exists( $this->upload_base_dir . $user_id . '/media/' )) {
				@mkdir( $this->upload_base_dir . $user_id . '/media/', 0777, true);
			}
		}
	}
	
	/******************************************
	Create uploads dir for thumbnails media if does not exist
	*******************************************/
	function do_uploads_dir_media_thumbnail($user_id=0) {
	
		if (!file_exists( $this->upload_base_dir . '.htaccess') ) {

$data = <<<EOF
<Files ~ "\.txt$">
Order allow,deny
Deny from all
</Files>
EOF;

			file_put_contents( $this->upload_base_dir . '.htaccess' , $data);
		}
	
		if (!file_exists( $this->upload_base_dir."thumbnail/" )) {
			@mkdir( $this->upload_base_dir."thumbnail/", 0777, true);
		}
		
		if ($user_id > 0) { // upload dir for a user
			if (!file_exists( $this->upload_base_dir . $user_id . '/media/thumbnail/' )) {
				@mkdir( $this->upload_base_dir . $user_id . '/media/thumbnail/', 0777, true);
			}
		}
	}


	/******************************************
	Get the proper uploads dir for media
	******************************************/
	function get_uploads_dir_media($user_id=0){
		if ($user_id > 0) {
			return $this->upload_base_dir . $user_id . '/media/';
		}
		return $this->upload_base_dir;
	}
	
	/******************************************
	Return the uploads URL for media
	******************************************/
	function get_uploads_url_media($user_id=0){
		if ($user_id > 0) {
			return $this->upload_base_url . $user_id . '/media/';
		}
		return $this->upload_base_url;
	}


	function get_uploads_dir_media_thumbnail($user_id=0){
		if ($user_id > 0) {
			return $this->upload_base_dir . $user_id . '/media/thumbnail/';
		}
		return $this->upload_base_dir."thumbnail/";
	}
	
	/******************************************
	Return the uploads URL for media
	******************************************/
	function get_uploads_url_media_thumbnail($user_id=0){
		if ($user_id > 0) {
			return $this->upload_base_url . $user_id . '/media/thumbnail/';
		}
		return $this->upload_base_url."thumbnail/";
	}

}
$userpro_media_api=new userpro_media_api();
