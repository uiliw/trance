<?php
add_shortcode('media_manager', 'userpro_view_media_manager' );
	function userpro_view_media_manager($arguments) {


	
	$args = shortcode_atts(array(
        'media' => 'view',
	'user_id'=>''
    ),$arguments);

	if(!empty($args['user_id']))
	{
		$user_id = $args['user_id'];
		
	}
	else
	{
		$user_id = get_current_user_id();
	}
	$i = rand(1, 1000);
	$default_args =  array(
		"template" => "view",
		"media_display" =>"n",
		"user_id"=> $user_id,
		"unique_id"=>$i,
		"media"=>$args['media']
		
		);
	
	if($args['media'] == "view")
	{
  	
		do_action('userpro_after_fields', $default_args);
		}	
}
?>
