<?php
	$total_percentage = 100;
	$userpro_completeness_api = new userpro_completeness_api();
	$total_field_percentage = $userpro_completeness_api->calculate_Percentage();
	$remaining_progress = $total_percentage - $total_field_percentage;
?>
<h3><?php _e('Setup Fields','userpro-completeness'); ?></h3>
<table class="form-table">
<tr valign="top">
	<?php //$remaining_progress = 100 ?>
	<td>
	
	<div><?php _e('Remaining progress:','userpro-completeness'); ?> <strong><span class="userpro-remaining-progress"><?php echo $remaining_progress; ?></span>%</strong></div>
	</td>
	
</tr>
<?php		$userpro_completeness_saved_fields=array();
		$userpro_completeness_saved_fields = get_option('userpro_completeness_save_field'); 
		if(!empty($userpro_completeness_saved_fields))		
		foreach($userpro_completeness_saved_fields as $k => $v){
		 include(UPC_PLUGIN_DIR.'/templates/percentageList.php'); 

	}?>



<tr id="add-field-tr" valign="top">
	<td>
	<input type="button" class="button" style="width:100px !important;" name="userpro-add-field" value="Add Field" id="userpro-add-field" />	
	</td>
</tr>
<tr valign="top" class="userpro-completeness-add">
	

		<th scope="row"><label for="select_fields"><?php _e('Select Field','userpro-completeness'); ?></label></th>
		<td>
			<select name="select_fields" id="select_fields" class="chosen-select" style="width:200px" data-placeholder="<?php _e('Select Fields','userpro-completeness'); ?>">
				<?php
				$flag = true;
				$field_names = get_option("userpro_fields_groups");
				foreach($field_names['edit']['default'] as $k=>$v) {
					if (array_key_exists('label', $v)) {
						$fields_having_percentage=array();
						$fields_having_percentage = get_option('userpro_completeness_save_field'); 
						
						if(!empty($fields_having_percentage))
						$fields_Keys = array_keys($fields_having_percentage,true);  
						else
						$fields_Keys = array();
							
								if(!empty($fields_Keys) && in_array($k,$fields_Keys)){  ?>
									<option value="<?php echo $k; ?>" ><?php echo $v['label']; ?></option>		

				<?php }
				      else{ 
				?>
									<option value="<?php echo $k; ?>" <?php echo $flag ? "selected" : ""; ?>><?php echo $v['label']; ?></option>
				<?php  
				$flag= false;
					} 
					}
				} ?>
			</select>
			<span class="description"><?php _e('Select edit profile form field to be included in profile completeness.','userpro'); ?></span>
		</td>
	</tr>
	<tr valign="top" class="userpro-completeness-add">
	<th scope="row"><label for="userpro-field-percentage"><?php _e('Field\'s Percentage','userpro-completeness'); ?></label></th>
	<td>
			<input type="text" style="width:300px !important;" name="userpro-field-percentage" id="userpro-field-percentage" value="<?php echo (userpro_completeness_get_option('userpro-field-percentage')) ? userpro_completeness_get_option('userpro-field-percentage') : ''; ?>" class="regular-text" />
			<span class="description"><?php _e('Enter Profile completion Threshold percentage.','userpro-completeness'); ?></span>
		</td>	
</tr>
<tr valign="top" class="userpro-completeness-add">
	<td>
	<input type="button" class="button" style="width:100px !important;" name="userpro-field-save" value="Save" id="userpro-field-save" />	
	</td>
</tr>
</table>
