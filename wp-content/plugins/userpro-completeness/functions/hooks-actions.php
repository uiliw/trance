<?php



add_filter('updb_default_options_array','userpro_progressbar_in_dashboard','10','1');
function userpro_progressbar_in_dashboard($array)
{
	$template_path= UPC_PLUGIN_DIR.'templates/';
	$olddata=$array['updb_available_widgets'];
	$newdata= array ('progressbar'=>array('title'=>'Progressbar', 'template_path'=>$template_path ));	
    	$array['updb_available_widgets']=   array_merge($olddata,$newdata);

	$oldunsetwidgets=$array['updb_unused_widgets'];
	$newunsetwidgets= array( 'progressbar');
	$array['updb_unused_widgets']= array_merge($oldunsetwidgets,$newunsetwidgets);

	return $array;
}

add_action('wp_ajax_nopriv_userpro_completeness_save_field', 'userpro_completeness_save_field');
add_action('wp_ajax_userpro_completeness_save_field', 'userpro_completeness_save_field');
add_action("userpro_after_profile_head", "userpro_completeness_progress_bar" ,11,1);
add_action('userpro_before_fields', 'userpro_completeness_register_progress_bar', 10, 1 );

function userpro_completeness_register_progress_bar( $args ){
      	$userpro_dynamic_completeness = userpro_completeness_get_option('userpro_dynamic_registration_completeness');
	$total_percentage = 100;
	$userpro_completeness_api = new userpro_completeness_api();
	$total_field_percentage = $userpro_completeness_api->calculate_Percentage();
	$remaining_progress = $total_percentage - $total_field_percentage;

	if($userpro_dynamic_completeness == 1 && $args['template']=='register' && $remaining_progress != 100){
		wp_register_script('completeness_progressbar_js', UPC_PLUGIN_URL.'assets/completeness_progressbar.js');
		wp_enqueue_script('completeness_progressbar_js');
		require_once(UPC_PLUGIN_DIR.'/templates/progressBar.php');
	}
}

function userpro_completeness_progress_bar($args)
{
	$total_percentage = 100;
	$userpro_completeness_api = new userpro_completeness_api();
	$total_field_percentage = $userpro_completeness_api->calculate_Percentage();
	$remaining_progress = $total_percentage - $total_field_percentage;

	if(($args['template']=='view' || $args['template']=='edit') && $remaining_progress != 100) {
		wp_register_script('completeness_progressbar_js', UPC_PLUGIN_URL.'assets/completeness_progressbar.js');
		wp_enqueue_script('completeness_progressbar_js');
		require_once(UPC_PLUGIN_DIR.'/templates/progressBar.php');
	}

}

function userpro_completeness_save_field(){	
	$total_percentage = 100;
	//declaration
	$current_percentage_list;
        $msg;	
	
	$userpro_completeness_api = new userpro_completeness_api();
	$total_field_percentage = $userpro_completeness_api->calculate_Percentage();
	$remaining_progress = $total_percentage - $total_field_percentage;
	$record_exists = false;	
	
	$userpro_completeness_save_field = array();
	$userpro_completeness_save_field = get_option('userpro_completeness_save_field');	
        
	$field_name = $_POST['selectField']; 
	if(isset($_POST['fieldPercentage'])){
		$fieldPercentage = $_POST['fieldPercentage'];
	}	

	if( $_POST['field_action']== 'fieldSave'){
		
		if(!empty($field_name) && !empty($fieldPercentage) ){
			
			
			$field_names=array();
			$field_names = get_option("userpro_fields_groups");
			$fieldDispalyName = $field_names['edit']['default'][$field_name]['label'];
			
			if(($total_field_percentage+$fieldPercentage) <= $total_percentage){
					if(empty($userpro_completeness_save_field))
					{
						$userpro_completeness_save_field[$field_name]= array(
										    "percentage" => $fieldPercentage,
										    "displayName" => $fieldDispalyName
										);
					$record_exists = true;

			}			


				elseif(! array_key_exists($field_name,$userpro_completeness_save_field) ){
				
					$userpro_completeness_save_field[$field_name]= array(
										    "percentage" => $fieldPercentage,
										    "displayName" => $fieldDispalyName
										);
					$record_exists = true;
				}
				else{
					$msg = "The field ".$field_name ." already exists";
					$fieldPercentage = $userpro_completeness_save_field[$field_name]['percentage'];
				}
			}
			else{ 
					$msg = "Profile completeness setup has already reached 100%";
				}					
		}
		else if(empty($fieldPercentage)){
			$msg = "Please Enter the Percentage.";
		}
	}
	else if( $_POST['field_action']== 'fieldEdit'){
			if(!empty($field_name) && !empty($fieldPercentage)){
				if((($total_field_percentage-$userpro_completeness_save_field[$field_name]['percentage'])+$fieldPercentage) <= $total_percentage){
					$userpro_completeness_save_field[$field_name]['percentage'] = $fieldPercentage ;
					$record_exists = true;
				}
				else{ 
					$msg = "Profile completeness setup has already reached 100%";
					$fieldPercentage = $userpro_completeness_save_field[$field_name]['percentage'];
				}
			}
		
	}
	else if( $_POST['field_action']== 'fieldDelete'){

			if(!empty($field_name)){
				unset($userpro_completeness_save_field[$field_name]);
				$record_exists = true;
			}
	}

	if($total_field_percentage <= $total_percentage && $record_exists == true ){
		update_option("userpro_completeness_save_field",$userpro_completeness_save_field);
	}

	if( $_POST['field_action']== 'fieldSave'){
		$k = $field_name;
			$v = array("percentage" =>$fieldPercentage,
				   "displayName" =>$fieldDispalyName);
		ob_start();
			include(UPC_PLUGIN_DIR.'/templates/percentageList.php');
			$current_percentage_list = ob_get_contents();
			 		
		ob_end_clean();
		
	}
	$total_field_percentage = $userpro_completeness_api->calculate_Percentage();
	$remaining_progress = $total_percentage - $total_field_percentage;
	$return_success = json_encode(array(
						"rp" => $remaining_progress, 
						"savedFieldname" => $field_name, 
						"savedFieldPercentage" => isset($fieldPercentage)?$fieldPercentage:"",
						"displayName" => isset($fieldDispalyName)?$fieldDispalyName:"",
						"currentList"=>isset($current_percentage_list)?$current_percentage_list:"",
						"record_exists" =>$record_exists,
						"msg" => isset($msg)?$msg:"",
						)); 

	echo $return_success; die;
}
?>
