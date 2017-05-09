<form method="post" action="">
<?php $options=get_option('userpro_media');?>
<h3><?php _e('Instagram Settings','userpro-media'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="instagram_app_key"><?php _e('Instagram Client ID','userpro-media'); ?></label></th>
		<td>
         <input type="text" name="instagram_app_key" id="instagram_app_key" value="<?php if(userpro_media_get_option('instagram_app_key')) { echo userpro_media_get_option('instagram_app_key'); } else{ echo $options['instagram_app_key'];} ?>" class="regular-text" />
			<span class="description"><?php _e('Open <a href="http://instagram.com/developer/">http://instagram.com/developer/</a> create a new app and edit its settings to make it work on your domain. In App Settings, please paste the Client ID into this field.','userpro-media'); ?></span>		
		</td>
	</tr>

    <tr valign="top">
		<td>
         <a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo $options['instagram_app_key']; ?>&redirect_uri=<?php echo admin_url('admin.php?page=userpro-media&tab=instagram'); ?>&response_type=token&scope=public_content" class="button instabutton" ><?php _e('Generate Instagram Access Token','userpro-media') ?></a>	
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="instagram_access_token"><?php _e('Instagram Access Token','userpro-media'); ?></label></th>
		<td>
         <input type="text" name="instagram_access_token" id="instagram_access_token" value="<?php echo get_option('UMM_instagram_access_token'); ?>" class="regular-text" />
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="instagram_img_count"><?php _e('Instagram Images to show on user profile','userpro-media'); ?></label></th>
		<td>
         <input type="text" name="instagram_img_count" id="instagram_img_count" value="<?php echo $options['instagram_img_count']; ?>" class="regular-text" />
			<span class="description"><?php _e('Number of images to display on users profile.','userpro-media'); ?></span>
		</td>
	</tr>
	

</table>

<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro-media'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro-media'); ?>"  />
</p>

</form>
