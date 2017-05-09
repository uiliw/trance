var flg = 0;
function completeness_progressBar(percent, $element) {
	$element.find('div').animate({ width: percent+"%" }, 3000);
	$element.find('span').html(percent + "%&nbsp;");	
}

function calculate_completion_percent_dynamically(elm, total_percentage){
	var field_name = jQuery(elm).attr('name');
	var value = jQuery(elm).val();
	var field_split = field_name.split("-"); 
	var field = field_split[0];
	var my_data = jQuery('#data_field').data(field);
	if( (jQuery.type( my_data ) != "undefined")  && (jQuery(elm).val()) ){
		total_percentage = parseInt(total_percentage) + parseInt(my_data);
		completeness_progressBar(total_percentage, jQuery('#progressBar'));
	}    	
	else if(!jQuery(elm).val() || jQuery(elm).val() == "" ){
			total_percentage = parseInt(total_percentage) - parseInt(my_data);
		completeness_progressBar(total_percentage, jQuery('#progressBar'));
	}
}

/*for edit and registration*/
jQuery(document).ready(function() {
	var total_percentage = 0;
	var pre_percentage = jQuery('#progressBar span').html();
	pre_percentage_val = parseInt(pre_percentage);
	total_percentage = parseInt(total_percentage) + parseInt(pre_percentage_val[0]);

	jQuery(document).on('change','div.userpro-input input[type="text"], div.userpro-input input[type="password"]',function(){
		
		var pre_percentage = jQuery('#progressBar span').html();
		if( ( this.defaultValue == "" ) && (!jQuery(this).hasClass('changed')) ){
			calculate_completion_percent_dynamically(this, parseInt(pre_percentage));
			jQuery(this).addClass('changed');
		}else if(jQuery(this).val() == ""){
			calculate_completion_percent_dynamically(this, parseInt(pre_percentage));
			jQuery(this).removeClass('changed');
		}
		this.defaultValue = jQuery(this).val();
	});

	jQuery(document).on('click','div.userpro-input input:radio',function(){
		var radio_name = jQuery(this).attr('name'); 
		var pre_percentage = jQuery('#progressBar span').html();
 		if(!jQuery(this).closest('.userpro-radio-wrap').find('span').hasClass('checked')) {
			calculate_completion_percent_dynamically(jQuery(this), parseInt(pre_percentage));
		}
	}); 

	jQuery(document).on('click','div.userpro-input input:checkbox',function(){
		var checkbox_name = jQuery(this).attr('name'); 
		var pre_percentage = jQuery('#progressBar span').html();
 		if(!jQuery(this).closest('.userpro-checkbox-wrap').find('span').hasClass('checked')) {
			calculate_completion_percent_dynamically(jQuery(this), parseInt(pre_percentage));
		}
	}); 

	jQuery(document).on('change','div.userpro-input select',function(){
	  	var select_name = jQuery(this).attr("name");
		var pre_percentage = jQuery('#progressBar span').html();

		if( (jQuery(this).val() != "") && (!jQuery(this).hasClass('changed')) ){
			calculate_completion_percent_dynamically(jQuery('select[name='+select_name+']'), parseInt(pre_percentage));
			jQuery(this).addClass('changed');
		}
		else if(jQuery(this).val() == ""){
			jQuery(this).removeClass('changed');
		}
	});

	jQuery(document).on('click','div.userpro-input .userpro-pic-upload',function(){
		if(jQuery('.userpro-input .userpro-button.red').length){
			var parentTag = jQuery( '.userpro-input .userpro-button.red' ).parent();
			var pre_percentage = jQuery('#progressBar span').html();
			calculate_completion_percent_dynamically(jQuery(parentTag).find('input')[1] , parseInt(pre_percentage));
		}
	});

	jQuery(document).on('click','div.userpro-input .userpro-button.red',function(){
		var parentTag = jQuery( '.userpro-input .userpro-button.red' ).parent();
		var pre_percentage = jQuery('#progressBar span').html();
		var field_name = jQuery(jQuery(parentTag).find('input')[1]).attr('name');
		var field_split = field_name.split("-"); 
		var field = field_split[0];
		var my_data = jQuery('#data_field').data(field);
		var pre_percentage = jQuery('#progressBar span').html();
		var tot_per = parseInt(pre_percentage) - parseInt(my_data);
		completeness_progressBar(tot_per, jQuery('#progressBar'));
	});
});
