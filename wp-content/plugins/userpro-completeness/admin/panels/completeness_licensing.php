<form method="post" action="">
<h3><?php _e('UserPro Completeness Licensing','userpro-completeness'); ?></h3>
<table class="form-table">

<tr valign="top">		
		<th scope="row"><label for="userpro_completeness_code"><?php _e('Enter your purchase code','userpro-completeness'); ?></label></th>
		<td>
			<input type="text" style="width:300px !important;" name="userpro_completeness_code" id="userpro_completeness_code" value="<?php echo (userpro_completeness_get_option('userpro_completeness_code')); ?>" class="regular-text" />
		</td>

</tr>
</table>

<p class="submit">
	<input type="submit" name="completeness_verify_button" id="completeness_verify_button" class="button button-primary" value="<?php _e('Save Changes','userpro-completeness'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro-completeness'); ?>"  />
</p>

</form>
