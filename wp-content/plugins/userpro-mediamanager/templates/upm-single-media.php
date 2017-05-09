<?php
	global $userpro_media_manager,$userpro_media_api;
	$target_file_uri = $userpro_media_api->get_uploads_url_media(get_current_user_id()).basename($ret[$i]['target_file_uri']);
?>
<tr>
	<input type="hidden" class="upm-thumnail-path" value="<?php echo $ret[$i]['target_file']; ?>" />
	<input type="hidden" class="upm-media-name" value="<?php echo $ret[$i]['media_name']; ?>">
	<input type="hidden" class="upm-media-filetype" value="<?php echo $_GET['filetype']; ?>">
	<input type="hidden" class="upm-media-id" value="<?php echo $media_id++; ?>">
	<?php if( $_GET['filetype'] == 'photo' ){?>
	<td class="upm-uploaded-media-src" data-src="<?php echo $target_file_uri; ?>"><img src="<?php echo $ret[$i]['target_file_uri']; ?>"></td>
	<td><input type="text" placeholder="Enter caption" data-media_id = "<?php echo $media_id;?>"  class="media_caption" /></td>
	<?php } else if( $_GET['filetype'] == 'video' ){ ?>
	<td class="upm-uploaded-media-src" data-src="<?php echo $target_file_uri; ?>"><video><source src="<?php echo $ret[$i]['target_file_uri'];?>"></source></source></video></td>
	<?php } else if( $_GET['filetype'] == 'music' ){?>
	<td style="width:140px;" class="upm-uploaded-media-src" data-src="<?php echo $target_file_uri; ?>"><audio controls><source src="<?php echo $ret[$i]['target_file_uri']; ?>"></source></audio></td>
	<?php }
	?>
	<td class="upm-src-name" style="width:100px;display:none;"><?php echo $ret[$i]['target_file_name'];?></td>
	<?php if( userpro_media_get_option('media_restrict') == 'y' ){?>	
	<td>
		<select name = "upm_media_restriction" class = "upm_media_restriction" >
			<option value="private"><?php _e('Select Visibility','userpro-mediamanager');?>
			<option value="private"><?php _e('Private','userpro-mediamanager');?></option>
			<option value="public"><?php _e('Public','userpro-mediamanager');?></option>
		</select>
	</td>
	<?php }?>
	<td>
		<input type="button" value="Save" class="save-single-upload" onclick="dash_save_upload(this)"/>
		<img src="<?php echo $userpro->skin_url(); ?>loading.gif" alt="" class="userpro-loading" />
	</td>
	
</tr>
