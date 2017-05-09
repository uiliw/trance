<tr id = "<?php echo $k.'_tr'; ?>" valign="top">
	<td class= "fields_name" id = "<?php echo $k; ?>"> 
		<label for="<?php echo $k; ?>"><?php echo $v['displayName']; ?></label> 	
		<input class="fields_name_hidden" id= "text_<?php echo $k;?>" type = "hidden" name = "field_name_hidden" value="<?php echo $k; ?>" />
	</td> 
	<td class = "fields_percentage" id = "<?php echo $k.'_'.$v['percentage']; ?>">    
		<label for="<?php echo $k.'_'.$v['percentage']; ?>"><?php echo $v['percentage']; ?></label> 

		<input style="display:none;" class="fields_input_percentage" id= "text_<?php echo $k;?>" type = "text" name = "edit" value="<?php echo $v['percentage']; ?>" />
	</td>
	<td class = "fields_action">
		<div class="fields_edit_btn" id= "edit_<?php echo $k;?>"></div>
		<div class="fields_save_btn" style="display:none;" id= "save_<?php echo $k;?>"></div>
		<div class="fields_delete_btn" style="display:none;" id= "delete_<?php echo $k;?>"></div>
	</td>
</tr>				 			

