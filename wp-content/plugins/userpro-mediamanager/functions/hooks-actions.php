<?php

	if( !class_exists( 'UPMHooksActions' ) ){
	class UPMHooksActions{

		function __construct(){
			add_action( 'after_dashboard_side', array( $this, 'upm_add_media_tab' ) );
			add_action( 'after_dashboard_profile_content', array( $this, 'upm_add_media_content' ) , '', 2 );
		}
		
		function upm_add_media_tab(){
			
		?>
			<div class="uploadPic dashboard-side" data-id = "dashboard-media-uploader">
					<a href="#" class="uploadPic-box">
						<span>
							<i class="fa fa-user"></i>
						</span>
						<span class="labelName"><?php _e( 'Upload Media', 'userpro-mediamanager' );?></span>
					</a>
			</div>
		<?php	
		}

		function upm_add_media_content( $args, $edit_fields ){
			wp_enqueue_script( 'dashboard_media_uploader_js', userpro_media_url.'scripts/dashboardmediauploader.js', '','', true);
			//wp_enqueue_script( 'jquery_dashupload_js', userpro_media_url.'scripts/jquery.dashupload.js','', '', true );
			//wp_enqueue_style( 'dash_file_upload_css', userpro_media_url.'css/jquery.fileupload.css' );
			//wp_enqueue_style( 'dash_file_upload_ui_css', userpro_media_url.'css/jquery.fileupload-ui.css' );
			include_once userpro_media_path.'templates/upm-media-upload.php';
		}
		
	}
	new UPMHooksActions();
  }	
?>
