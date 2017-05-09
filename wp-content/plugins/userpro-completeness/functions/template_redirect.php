<?php

add_action('template_redirect', 'userpro_completeness_template');


function userpro_completeness_template() {

	$userpro_completeness_api = new userpro_completeness_api();
	$total_field_percentage = $userpro_completeness_api->get_completeness_usermeta_info();
	$userpro_completeness_threshold_percentage = userpro_completeness_get_option('userpro_completeness_threshold_percentage');
	$userpro = new userpro_api();
		
    if (userpro_completeness_get_option('userpro_completeness_enable_restriction')) {
	if($total_field_percentage < $userpro_completeness_threshold_percentage){
	
	$current_page_link = get_page_link();
	$current_id = url_to_postid(get_page_link());

	$edit_page_default_link = $userpro ->permalink(get_current_user_id(),"edit");
	$edit_page_default_id = url_to_postid($edit_page_default_link);
	
	$r_link = userpro_completeness_get_option('userpro_completeness_restriction_redirect_url');	
	if(isset($r_link)){
		$r_link_id = url_to_postid($r_link);	
	}

	$redirect_id = empty($r_link) ? $edit_page_default_id : $r_link_id;

	if($redirect_id != $current_id)
	{
		$redirect_path = empty($r_link) ? $edit_page_default_link : $r_link;	
        	wp_safe_redirect($redirect_path);
		 exit();
	}

       
	}
    }
}

?>
