<?php 
add_shortcode('userpro_progressbar','display_progressbar');

function display_progressbar()
{
	wp_register_script('completeness_progressbar_js', UPC_PLUGIN_URL.'assets/completeness_progressbar.js');
	wp_enqueue_script('completeness_progressbar_js');
?>
<div id="progressBardash" class="jquery-ui-like"><div><span></span></div></div>
<?php $userpro_completeness_api = new userpro_completeness_api(); 
      $current_user_percentage = $userpro_completeness_api->get_completeness_usermeta_info(); 
	?>
<script>
	completeness_progressBar('<?php echo $current_user_percentage;?>' , jQuery('#progressBardash'));
</script>

<?php }?>
