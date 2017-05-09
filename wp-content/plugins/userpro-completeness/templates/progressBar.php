<?php 
$userpro_completeness_api = new userpro_completeness_api(); 
	if(isset($args['user_id'])){
      		$current_user_percentage = $userpro_completeness_api->get_completeness_usermeta_info($args['user_id']);
	}
	else{
		$current_user_percentage = 0;
	}

      $userpro_completeness_save_field = get_option('userpro_completeness_save_field');

	$data = "";
	foreach($userpro_completeness_save_field as $k => $v){ 
		$data.='data-'.$k.'='.$v['percentage'].' ';
	}
?>
<div id="data_field" <?php echo $data; ?> ></div>

<?php

      $progressbar_color=userpro_completeness_get_option('progress_bar');
      if(!isset($progressbar_color))$progressbar_color="default";
?>

<div id="progressBar" class="jquery-ui-like"><div class="<?php echo $progressbar_color;?>"></div><span></span></div>

<script>
	completeness_progressBar('<?php echo $current_user_percentage;?>' , jQuery('#progressBar'));
</script>
