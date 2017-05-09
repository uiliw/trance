jQuery(document).ready(function() {

function userpro_completeness_save_field(t){
		var fieldTr = jQuery(t).parent().parent();
			var editedFieldPercentage = fieldTr.find('td.fields_percentage input.fields_input_percentage').val();
			var selectedFieldName = fieldTr.find('td.fields_name input.fields_name_hidden').val();
			var displayFieldName = fieldTr.find('td.fields_name label').html();
		jQuery.ajax({
			url: ajaxurl,
			data: "action=userpro_completeness_save_field&field_action=fieldEdit&selectField="+selectedFieldName+"&fieldPercentage="+editedFieldPercentage+"&displayField"+displayFieldName,
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				
					jQuery("div span.userpro-remaining-progress").html(data.rp);
				
					fieldTr.find('.fields_percentage label').show();
					fieldTr.find('.fields_percentage input.fields_input_percentage').hide();
					fieldTr.find('.fields_action div.fields_edit_btn').show();
					fieldTr.find('.fields_action div.fields_save_btn').hide();
					fieldTr.find('.fields_action div.fields_delete_btn').hide();
									
					fieldTr.find('.fields_percentage label').html(data.savedFieldPercentage);
					fieldTr.find('.fields_percentage input.fields_input_percentage').val(data.savedFieldPercentage);
					
					if(data.record_exists == false ){
						alert(data.msg);
					}				
				
			}
		});

}

function userpro_completeness_edit_field(t){
	var fieldTr = jQuery(t).parent().parent();
	fieldTr.find('.fields_percentage label').hide();
	fieldTr.find('.fields_percentage input.fields_input_percentage').show();
	fieldTr.find('.fields_action div.fields_edit_btn').hide();
	fieldTr.find('.fields_action div.fields_save_btn').css({"display":"inline-block"});
	fieldTr.find('.fields_action div.fields_delete_btn').css({"display":"inline-block"});	
	
}

function userpro_completeness_delete_field(t){
	var fieldTr = jQuery(t).parent().parent();
	var selectedFieldName = fieldTr.find('td.fields_name input.fields_name_hidden').val();
	var displayFieldName = fieldTr.find('td.fields_name label').html(); 
	jQuery.ajax({
		url: ajaxurl,
		data: "action=userpro_completeness_save_field&field_action=fieldDelete&selectField="+selectedFieldName+"&displayFieldName="+displayFieldName,
		dataType: 'JSON',
		type: 'POST',
		success:function(data){ 
				jQuery("div span.userpro-remaining-progress").html(data.rp);				
				fieldTr.remove();
				//if(jQuery('tr.userpro-completeness-add div.chosen-container').html() == selectedFieldName){
					
				//}
			}
	});
	
}

	jQuery("#userpro-field-save").click(function(){ 
		var userproFieldPercentage = document.getElementById("userpro-field-percentage").value; 
		var userproSelectFields = document.getElementById("select_fields").value; 

		jQuery.ajax({
			url: ajaxurl,
			data: "action=userpro_completeness_save_field&field_action=fieldSave&selectField="+userproSelectFields+"&fieldPercentage="+userproFieldPercentage,
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				if(data.record_exists == true){
					jQuery("div span.userpro-remaining-progress").html(data.rp);
					jQuery("tr#add-field-tr").before(data.currentList);
					
					jQuery(".fields_edit_btn").click( function(){
						
						userpro_completeness_edit_field(this);			
					});
					jQuery(".fields_save_btn").click( function(){
						userpro_completeness_save_field(this);	
					});
					jQuery(".fields_delete_btn").click( function(){
						userpro_completeness_delete_field(this);				
					});
					}
				else if(data.record_exists == false ){
					alert(data.msg);
				}
				
			}
		});
		jQuery('tr.userpro-completeness-add').css({'display':"none"});
	
	});
	
	//function to show add new field for percentage
	jQuery('#userpro-add-field').on('click', function(e){ 
		jQuery('tr.userpro-completeness-add').show();
		jQuery('tr.userpro-completeness-add td.chosen-select').css({"display":'none'});
		jQuery('tr.userpro-completeness-add div.chosen-container').show();
		jQuery('tr.userpro-completeness-add div.chosen-container').css({"min-width":"250px"});	
	});
	
	// function to edit single field
	jQuery(".fields_edit_btn").click( function(){
		
		userpro_completeness_edit_field(this);	
		
	});

	//function to save updated field. 
	jQuery(".fields_save_btn").click( function(){
		userpro_completeness_save_field(this);	
	});
	
	//function to delete selected field. 
	jQuery(".fields_delete_btn").click( function(){
		userpro_completeness_delete_field(this);				
	});		
		
});//doc.ready ends
function progressBar(percent, $element) {
		var progressBarWidth = percent * $element.width() / 100;
		$element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
	}

jQuery( document ).ready(function() { 
	jQuery('tr.userpro-completeness-add').hide();
	jQuery('.chosen-container .chosen-results').find('.disabled').removeClass('result-selected');
	jQuery('.chosen-container .chosen-results').find('.disabled').last().next().addClass('result-selected');
	//jQuery('#select_fields').hide();
});
