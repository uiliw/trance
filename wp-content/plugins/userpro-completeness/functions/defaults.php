<?php

	/* get a global option */
	function userpro_completeness_get_option( $option ) {
		$userpro_default_options = userpro_completeness_default_options();
		$settings = get_option('userpro_completeness');
		switch($option){
		
			default:
				if (isset($settings[$option])){
					return $settings[$option];
				} else {
					if(isset($userpro_default_options[$option]))
					return $userpro_default_options[$option];
				}
				break;
	
		}

	}
	
	/* set a global option */
	function userpro_completeness_set_option($option, $newvalue){
		$settings = get_option('userpro_completeness');

		$settings[$option] = $newvalue;
		update_option('userpro_completeness', $settings);
	}
	
	/* default options */
	function userpro_completeness_default_options(){
		global $userpro ;
		$array['userpro_threshold_percentage'] = '';
		$array['userpro_completeness_restriction_redirect_url']= '';

		return apply_filters('userpro_completeness_default_options_array', $array);
	}

	function userpro_completeness_is_selected($k, $arr){
		
		if (isset($arr) && is_array($arr) && in_array($k, $arr)) {
			
			echo 'selected="selected"';
		}elseif ( $arr == $k ) {
			
			echo 'selected="selected"';
		}
		
	}
