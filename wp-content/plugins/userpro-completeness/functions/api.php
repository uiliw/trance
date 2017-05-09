<?php
class userpro_completeness_api{	
	function __construct() {
		
	}
	
	function calculate_Percentage(){
		$total_percentage = 100;
		$field_percentage = 0;
		$userpro_completeness_save_field = get_option('userpro_completeness_save_field'); 
		if(!empty($userpro_completeness_save_field)){
			foreach($userpro_completeness_save_field as $k=>$v) {
				if($field_percentage <= $total_percentage){
					$field_percentage += $v['percentage'];
				}
			}
		}
		return $field_percentage;
	}


	function get_completeness_usermeta_info($user_id = null){
		$userpro_completeness_save_field = array();
		$user_id = isset($user_id) ? $user_id : get_current_user_id(); 
		$userpro_completeness_save_field = get_option('userpro_completeness_save_field');
		$current_user_cpercentage = 0;		
		if(!empty($userpro_completeness_save_field)){
			foreach($userpro_completeness_save_field as $k => $v){
				$user_meta_val = get_user_meta($user_id,$k,true);
				if( isset($user_meta_val) && !empty($user_meta_val))
				{
					$current_user_cpercentage += $v['percentage'];
				}
			}
		}
		return $current_user_cpercentage;
	}
}

$userpro_completeness_api = new userpro_completeness_api();
?>
