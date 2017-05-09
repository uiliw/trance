<form method="post" action="">

<h3><?php _e('Display Settings','userpro-media'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="media_view"><?php _e('Use lightbox to display media','userpro-media'); ?></label></th>
		<td>
			<select name="media_view" id="media_view" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_view')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_view')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="media_approve"><?php _e('Require admin approval for display media to all','userpro-media'); ?></label></th>
		<td>
			<select name="media_approve" id="media_approve" class="chosen-select" style="width:300px">
				<option value="1" <?php selected('1', userpro_media_get_option('media_approve')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="0" <?php selected('0', userpro_media_get_option('media_approve')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="media_socialshare"><?php _e('Display social share button on media','userpro-media'); ?></label></th>
		<td>
			<select name="media_socialshare" id="media_socialshare" class="chosen-select" style="width:300px">
				<option value="1" <?php selected('1', userpro_media_get_option('media_socialshare')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="0" <?php selected('0', userpro_media_get_option('media_socialshare')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="media_per_page"><?php _e('Number of media per page','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_per_page" id="media_per_page" value="<?php echo userpro_media_get_option('media_per_page'); ?>" class="regular-text" />
		</td>
	</tr>
<tr valign="top">
		<th scope="row"><label for="media_display"><?php _e('Display Media to Logged In users only','userpro-media'); ?></label></th>
		<td>
			<select name="media_display" id="media_display" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_display')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_display')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
<tr valign="top">
		<th scope="row"><label for="media_hidefile"><?php _e('Hide File Names From Media View','userpro-media'); ?></label></th>
		<td>
			<select name="media_hidefile" id="media_hidefile" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_hidefile')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_hidefile')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	
<tr valign="top">
		<th scope="row"><label for="media_restrict"><?php _e('Enable restriction for media upload','userpro-media'); ?></label></th>
		<td>
			<select name="media_restrict" id="media_restrict" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_restrict')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_restrict')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>

</table>

<h3><?php _e('Allow Media Upload Types','userpro-media'); ?></h3>
<table class="form-table">
	<tr valign="top">
		<td><label><Important><?php _e('Note','userpro-media')?></Important></label></td>
		<td><label><?php _e('If the maximum file upload size mentioned here is larger than the upload limit set by your server (PHP.ini) , then the server upload limit will be enforced. The Maximum upload limit for your server is ','userpro-media'); echo wp_max_upload_size()/(1024*1024)." MB";?></label></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="media_photo_type"><?php _e('Photos','userpro-media'); ?></label></th>
		<td>
			<select name="media_photo_type" id="media_photo_type" class="chosen-select" style="width:300px" onChange="allowed_photo_extension_list_view()">
				<option value="y" <?php selected('y', userpro_media_get_option('media_photo_type')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_photo_type')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="show_photos_to_followers"><?php _e('Show photos only to followers','userpro-media'); ?></label></th>
		<td>
			<select name="show_photos_to_followers" id="show_photos_to_followers" class="chosen-select" style="width:300px">
				<option value="1" <?php selected('1', userpro_media_get_option('show_photos_to_followers')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="0" <?php selected('0', userpro_media_get_option('show_photos_to_followers')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top" id="photo_extension_list">
		<th scope="row"><label for="media_photo_extension_list"><?php _e('Allowed Extensions','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_photo_extension_list" id="media_photo_extension_list" value="<?php echo userpro_media_get_option('media_photo_extension_list'); ?>" class="regular-text" />
			<span class="description"><?php _e('comma separated list of extensions user can upload from front end. for Ex: jpg,jpeg,png,gif','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="photo_size_limit">
		<th scope="row"><label for="media_photo_size_limit"><?php _e('Max Upload Size For Images','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_photo_size_limit" id="media_photo_size_limit" value="<?php echo userpro_media_get_option('media_photo_size_limit'); ?>" class="regular-text" />
			<span class="description"><?php _e('Please Enter the Max Upload limit for Images in MB','userpro-media'); ?></span>
		</td>
	</tr>
	
	<tr valign="top" id="photo_number_limit">
		<th scope="row"><label for="media_photo_number_limit"><?php _e('No. Of Images','userpro-media'); ?></label></th>
		<td>
		<?php
				if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
				$roles = $wp_roles->get_names();
				foreach($roles as $k=>$v) {
					
				?>
				<label><?php echo $v; ?></label>
			<input type="text" name="media_photo_number_limit_<?php echo $k ;?>" id="media_photo_number_limit_<?php echo $k ;?>" value="<?php echo userpro_media_get_option('media_photo_number_limit_'.$k); ?>" class="regular-text" />
				<?php } ?>
			<span class="description"><?php _e('Please Enter the no. of images that a user can upload. Note: Set -1 for unlimited no of images','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="photo_upload_count">
		<th scope="row"><label for="media_photo_upload_count"><?php _e('Show Upload Count For Images','userpro-media'); ?></label></th>
		<td>
			<select name="media_photo_upload_count" id="media_photo_upload_count" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_photo_upload_count')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_photo_upload_count')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="media_video_type"><?php _e('Videos','userpro-media'); ?></label></th>
		<td>
			<select name="media_video_type" id="media_video_type" class="chosen-select" style="width:300px" onChange="allowed_video_extension_list_view()">
				<option value="y" <?php selected('y', userpro_media_get_option('media_video_type')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_video_type')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="show_videos_to_followers"><?php _e('Show videos only to followers','userpro-media'); ?></label></th>
		<td>
			<select name="show_videos_to_followers" id="show_videos_to_followers" class="chosen-select" style="width:300px">
				<option value="1" <?php selected('1', userpro_media_get_option('show_videos_to_followers')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="0" <?php selected('0', userpro_media_get_option('show_videos_to_followers')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top" id="video_extension_list">
		<th scope="row"><label for="media_video_extension_list"><?php _e('Allowed Extensions','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_video_extension_list" id="media_video_extension_list" value="<?php echo userpro_media_get_option('media_video_extension_list'); ?>" class="regular-text" />
			<span class="description"><?php _e('comma separated list of extensions user can upload from front end. for Ex: mp4,avi,mpg,flv','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="video_size_limit">
		<th scope="row"><label for="media_video_size_limit"><?php _e('Max Upload Size For Videos','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_video_size_limit" id="media_video_size_limit" value="<?php echo userpro_media_get_option('media_video_size_limit'); ?>" class="regular-text" />
			<span class="description"><?php _e('Please Enter the Max Upload limit for Videos in MB','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="video_number_limit">
		<th scope="row"><label for="media_video_number_limit"><?php _e('No.Of Videos','userpro-media'); ?></label></th>
		<td>
		
			<?php
				if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
				$roles = $wp_roles->get_names();
				foreach($roles as $k=>$v) {
					
				?>
				<label><?php echo $v; ?></label>
			<input type="text" name="media_video_number_limit_<?php echo $k; ?>" id="media_video_number_limit_<?php echo $k; ?>" value="<?php echo userpro_media_get_option('media_video_number_limit_'.$k); ?>" class="regular-text" />
			<?php } ?>
			<span class="description"><?php _e('Please Enter the no. of videos that a user can upload. Note: Set -1 for unlimited no of videos','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="video_upload_count">
		<th scope="row"><label for="media_video_upload_count"><?php _e('Show Upload Count For Videos','userpro-media'); ?></label></th>
		<td>
			<select name="media_video_upload_count" id="media_video_upload_count" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_video_upload_count')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_video_upload_count')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="media_music_type"><?php _e('Music','userpro-media'); ?></label></th>
		<td>
			<select name="media_music_type" id="media_music_type" class="chosen-select" style="width:300px" onChange="allowed_music_extension_list_view()">
				<option value="y" <?php selected('y', userpro_media_get_option('media_music_type')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_music_type')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="show_music_to_followers"><?php _e('Show music only to followers','userpro-media'); ?></label></th>
		<td>
			<select name="show_music_to_followers" id="show_music_to_followers" class="chosen-select" style="width:300px">
				<option value="1" <?php selected('1', userpro_media_get_option('show_music_to_followers')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="0" <?php selected('0', userpro_media_get_option('show_music_to_followers')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top" id="music_extension_list">
		<th scope="row"><label for="media_music_extension_list"><?php _e('Allowed Extensions','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_music_extension_list" id="media_music_extension_list" value="<?php echo userpro_media_get_option('media_music_extension_list'); ?>" class="regular-text" />
			<span class="description"><?php _e('comma separated list of extensions user can upload from front end. for Ex: mp3,wav','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="music_size_limit">
		<th scope="row"><label for="media_music_size_limit"><?php _e('Max Upload Size For Audio Files','userpro-media'); ?></label></th>
		<td>
			<input type="text" name="media_music_size_limit" id="media_music_size_limit" value="<?php echo userpro_media_get_option('media_music_size_limit'); ?>" class="regular-text" />
			<span class="description"><?php _e('Please Enter the Max Upload limit for Audio Files in MB','userpro-media'); ?></span>
		</td>
	</tr>
	
	<tr valign="top" id="music_number_limit">
		<th scope="row"><label for="media_music_number_limit"><?php _e('No.Of Audios','userpro-media'); ?></label></th>
		<td>
			<?php
				if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
				$roles = $wp_roles->get_names();
				foreach($roles as $k=>$v) {
					
				?>
				<label><?php echo $v; ?></label>
			<input type="text" name="media_music_number_limit_<?php echo $k;?>" id="media_music_number_limit_<?php echo $k;?>" value="<?php echo userpro_media_get_option('media_music_number_limit_'.$k); ?>" class="regular-text" />
				<?php } ?>
			<span class="description"><?php _e('Please Enter the no. of audios that a user can upload. Note: Set -1 for unlimited no of audios','userpro-media'); ?></span>
		</td>
	</tr>

	<tr valign="top" id="music_upload_count">
		<th scope="row"><label for="media_music_upload_count"><?php _e('Show Upload Count For Audios','userpro-media'); ?></label></th>
		<td>
			<select name="media_music_upload_count" id="media_music_upload_count" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_media_get_option('media_music_upload_count')); ?>><?php _e('Yes','userpro-media'); ?></option>
				<option value="n" <?php selected('n', userpro_media_get_option('media_music_upload_count')); ?>><?php _e('No','userpro-media'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="media_roles_cant_upload_media[]"><?php _e('Restrict Roles From uploading media','userpro'); ?></label></th>
		<td>
			<select name="media_roles_cant_upload_media[]" id="media_roles_cant_upload_media" multiple="multiple" class="chosen-select" style="width:300px" data-placeholder="<?php _e('Select roles','userpro-media'); ?>">
				<?php
				if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
				$roles = $wp_roles->get_names();
				foreach($roles as $k=>$v) {
				
				?>
				<option value="<?php echo $k; ?>" <?php userpro_is_selected($k, userpro_media_get_option('media_roles_cant_upload_media') ); ?>><?php echo $v; ?></option>
				<?php } ?>
			</select>
			<span class="description"><?php _e('Enter the roles you want to restrict from uploading media from media manager.','userpro-media'); ?></span>
		</td>
	</tr>
	

	
	
</table>

<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro-media'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro-media'); ?>"  />
</p>

</form>
<script type="text/javascript">
function allowed_photo_extension_list_view(){
	if(document.getElementById('media_photo_type').value=="y")
	{
		document.getElementById("photo_extension_list").style.display="";
		document.getElementById("photo_size_limit").style.display="";
		document.getElementById("photo_number_limit").style.display="";
		document.getElementById("photo_upload_count").style.display="";
	}
	else if(document.getElementById('media_photo_type').value=="n")
	{
		document.getElementById("photo_extension_list").style.display="none";
		document.getElementById("photo_size_limit").style.display="none";
		document.getElementById("photo_number_limit").style.display="none";
		document.getElementById("photo_upload_count").style.display="none";
	}
}
function allowed_video_extension_list_view(){
	if(document.getElementById('media_video_type').value=="y")
	{
		document.getElementById("video_extension_list").style.display="";
		document.getElementById("video_size_limit").style.display="";
		document.getElementById("video_number_limit").style.display="";
		document.getElementById("video_upload_count").style.display="";
	}
	else if(document.getElementById('media_video_type').value=="n")
	{
		document.getElementById("video_extension_list").style.display="none";
		document.getElementById("video_size_limit").style.display="none";
		document.getElementById("video_number_limit").style.display="none";
		document.getElementById("video_upload_count").style.display="none";
	}
}


function allowed_music_extension_list_view(){
	if(document.getElementById('media_music_type').value=="y")
	{
		document.getElementById("music_extension_list").style.display="";
		document.getElementById("music_size_limit").style.display="";
		document.getElementById("music_number_limit").style.display="";
		document.getElementById("music_upload_count").style.display="";
	}
	else if(document.getElementById('media_music_type').value=="n")
	{
		document.getElementById("music_extension_list").style.display="none";
		document.getElementById("music_size_limit").style.display="none";
		document.getElementById("music_number_limit").style.display="none";
		document.getElementById("music_upload_count").style.display="none";
	}
}
</script>
