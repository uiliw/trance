<form method="post" action="">
<h3><?php _e('General Settings','userpro-completeness'); ?></h3>
<table class="form-table">

<tr valign="top">		
		<th scope="row"><label for="userpro_completeness_threshold_percentage"><?php _e('Threshold Percentage','userpro-completeness'); ?></label></th>
		<td>
			<input type="text" style="width:300px !important;" name="userpro_completeness_threshold_percentage" id="userpro_completeness_threshold_percentage" value="<?php echo (userpro_completeness_get_option('userpro_completeness_threshold_percentage')) ? userpro_completeness_get_option('userpro_completeness_threshold_percentage') : ''; ?>" class="regular-text" />
			<span class="description"><?php _e('Enter Profile completion threshold percentage.','userpro-completeness'); ?></span>
		</td>

</tr>
<tr valign="top">		
		<th scope="row"><label for="userpro_completeness_enable_restriction"><?php _e('Restriction to View Full Site','userpro-completeness'); ?></label></th>
		<td>
			<select name="userpro_completeness_enable_restriction" id="userpro_completeness_enable_restriction" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_completeness_get_option('userpro_completeness_enable_restriction')); ?>><?php _e('Yes','userpro-completeness'); ?></option>
				<option value="0" <?php selected(0, userpro_completeness_get_option('userpro_completeness_enable_restriction')); ?>><?php _e('No','userpro-completeness'); ?></option>
			</select>
		</td>

</tr>
<tr valign="top">		
		<th scope="row"><label for="userpro_completeness_restriction_redirect_url"><?php _e('Restriction Redirect URL','userpro-completeness'); ?></label></th>
		<td>
			<?php $userpro_pages = get_option("userpro_pages");
		$edit_page_default_link = get_permalink($userpro_pages['edit']);  ?>
			<input type="text" style="width:300px !important;" name="userpro_completeness_restriction_redirect_url" id="userpro_completeness_restriction_redirect_url" value="<?php echo (userpro_completeness_get_option('userpro_completeness_restriction_redirect_url')) ? userpro_completeness_get_option('userpro_completeness_restriction_redirect_url') :$edit_page_default_link ; ?>" class="regular-text" />
			<span class="description"><?php _e('Enter Redirect URL for users who have not completed profile upto threshold.','userpro-completeness'); ?></span>
		</td>

</tr>
<tr valign="top">		
		<th scope="row"><label for="progress_bar"><?php _e('Select Progressbar Color','userpro-completeness'); ?></label></th>
		<td>
			<select name="progress_bar" id="progress_bar" class="chosen-select" style="width:300px">
				<option value="pc_blue_gloss" <?php selected('pc_blue_gloss', userpro_completeness_get_option('progress_bar')); ?>><?php _e('Blue Gloss','userpro-completeness'); ?></option>	
				<option value="pc_yellow_gloss" <?php selected('pc_yellow_gloss', userpro_completeness_get_option('progress_bar')); ?>><?php _e('Yellow Gloss','userpro-completeness'); ?></option>
				<option value="pc_red_gloss" <?php selected('pc_red_gloss', userpro_completeness_get_option('progress_bar')); ?>><?php _e('Red Gloss','userpro-completeness'); ?></option>	
				<option value="pc_pink_gloss" <?php selected('pc_pink_gloss', userpro_completeness_get_option('progress_bar')); ?>><?php _e('Pink Gloss','userpro-completeness'); ?></option>
				<option value="pc_orange_gloss" <?php selected('pc_orange_gloss', userpro_completeness_get_option('progress_bar')); ?>><?php _e('Orange Gloss','userpro-completeness'); ?></option>
				<option value="pc_green_gloss" <?php selected('pc_green_gloss', userpro_completeness_get_option('progress_bar')); ?>><?php _e('Green Gloss','userpro-completeness'); ?></option>
			</select>
		</td>
</tr>

<tr valign="top">
		<th scope="row"><label for="userpro_dynamic_registration_completeness"><?php _e('Enable Dynamic Progress Bar for Registration','userpro-completeness'); ?></label></th>
		<td>
			<select name="userpro_dynamic_registration_completeness" id="userpro_dynamic_registration_completeness" class="chosen-select" style="width:300px">				
				<option value="1" <?php selected(1, userpro_completeness_get_option('userpro_dynamic_registration_completeness')); ?>><?php _e('Yes','userpro-completeness'); ?></option>
				<option value="0" <?php selected(0, userpro_completeness_get_option('userpro_dynamic_registration_completeness')); ?>><?php _e('No','userpro-completeness'); ?></option>
 			</select>
		</td>
</tr>
</table>

<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro-completeness'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro-completeness'); ?>"  />
</p>

</form>
