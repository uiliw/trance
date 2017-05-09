jQuery(document).ready(function(){
	//jQuery('.userpro' ).find('.userpro-profile-img-btn').remove();
	jQuery('#dashboard-profile-customizer ul').sortable();
	jQuery( "ul.droptrue" ).sortable({
		  connectWith: "ul"
	});

	jQuery( "#save_widgets" ).click(function(){
		updb_save_widgets();
	});
	jQuery(document).on('click','.updb-edit-post',function(){
            
            //var id = '.userpro-edit-post-'+jQuery(this).data('postid');
            updb_edit_post(jQuery(this).data('postid'));
            
        });
        jQuery(document).on('click','.updb-add-new-post',function(){
            updb_edit_post('');
        });
	function updb_save_widgets(){
		var col1 = jQuery('#updb-customizer_1').sortable('toArray').toString();
		var col2 = jQuery('#updb-customizer_2').sortable('toArray').toString();
		var col3 = jQuery('#updb-customizer_3').sortable('toArray').toString();
		var unused_widget = jQuery('#updb_unused_widget').sortable('toArray').toString();
		jQuery('.userpro-loading').show().addClass('inline');
		jQuery.ajax({
			url: userpro_ajax_url,
			data:{action:'updb_save_widgets', col1:col1, col2:col2, col3:col3, unused_widget:unused_widget},
			type:'POST',
			dataType:'JSON',
			success: function(res){
				jQuery('.userpro-loading').hide().removeClass('inline');
				userpro_overlay_confirmation( 'Profile Updated Successfully' );
			}
		});
	}
	function updb_edit_post(post_id){
            
            jQuery.ajax({
                url: userpro_ajax_url,
                data: "action=updb_edit_post&post_id="+post_id,
                type:'POST',
                dataType:'JSON',
                success: function(res){
                    if (jQuery('body').find('.userpro-overlay').length==0) {
                        jQuery('body').append('<div class="userpro-overlay"/><div class="userpro-overlay-inner"/>');
                    }
                    jQuery('.userpro-overlay-inner').html(res.response);
                    
                    userpro_chosen();
                    userpro_ajax_picupload();
                    userpro_overlay_center('.userpro-overlay-inner');
                }
                
            });
        }
        jQuery(window).ajaxComplete(function(event,xhr,options) {
            var string = '';
            if(xhr.responseJSON !== undefined && xhr.responseJSON.modal_msg !== undefined){
                string = xhr.responseJSON.modal_msg;
                if((string.indexOf('Your submission has been published') > -1) || string.indexOf('Your submission has been sent! It will be reviewed shortly') > -1){
                    location.reload(); 
                }
            }
        });
});







