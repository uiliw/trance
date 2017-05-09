<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Revslider_featured_Addon
 * @subpackage Revslider_featured_Addon/admin/partials
 */

//saved values
$revslider_featured_addon_values = array();
parse_str(get_option('revslider_featured_addon'), $revslider_featured_addon_values);

//defaults
$revslider_featured_addon_values['revslider-featured-addon-type'] = isset($revslider_featured_addon_values['revslider-featured-addon-type']) ? $revslider_featured_addon_values['revslider-featured-addon-type'] : 'single';
$revslider_featured_addon_values['revslider-featured-addon-slider'] = isset($revslider_featured_addon_values['revslider-featured-addon-slider']) ? $revslider_featured_addon_values['revslider-featured-addon-slider'] : '';
$revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-image'] = isset($revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-image']) ? $revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-image'] : 'off';
$revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-slider'] = isset($revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-slider']) ? $revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-slider'] : 'off';
$revslider_featured_addon_values['revslider-featured-addon-write-when-no-featured-image'] = isset($revslider_featured_addon_values['revslider-featured-addon-write-when-no-featured-image']) ? $revslider_featured_addon_values['revslider-featured-addon-write-when-no-featured-image'] : 'off';

// Available Sliders
$slider = new RevSlider();
$arrSliders = $slider->getArrSliders();
$defSlider = "";

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="revslider_featured_addon_settings_slideout" class="rs-sbs-slideout-wrapper" style="display:none">
	<div class="rs-sbs-header">
		<div class="rs-sbs-step"><i class="eg-icon-cog"></i></div>
		<div class="rs-sbs-title"><?php _e('Featured Slider', 'revslider-featured-addon'); ?></div>
		<div class="rs-sbs-close"><i class="eg-icon-cancel"></i></div>
	</div>
	
	<div class="tp-clearfix"></div>
	<div class="rs-sbs-slideout-inner">
	<!-- Start Settings -->
		<form id="revslider-featured-addon-form">
			
				
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Featured Slider","revslider-featured-addon"); ?></div>
					<div><?php _e('Display on all posts automatically or <br>manual on single posts?','revslider-featured-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
		      	<input name="revslider-featured-addon-type" <?php checked( $revslider_featured_addon_values['revslider-featured-addon-type'], 'single' , 1 ); ?> type="radio" value="single">&nbsp;&nbsp;<?php _e('Single Posts Option','revslider-featured-addon'); ?>
		      	&nbsp;&nbsp;
		      	<input name="revslider-featured-addon-type" <?php checked( $revslider_featured_addon_values['revslider-featured-addon-type'], 'auto' , 1 ); ?> type="radio" value="auto">&nbsp;&nbsp;<?php _e('All Posts Auto','revslider-featured-addon'); ?>
		      	
		      	<div class="rs-dash-content-space"></div>
				
		      	<div id="revslider_featured_type_auto" class="revslider_featured_type_details">
		      		<div class="rs-dash-content-with-icon">
						<div class="rs-dash-strong-content"><?php _e("Slider","revslider-featured-addon"); ?></div>
						<div><?php _e('Display selected slider on all posts','revslider-featured-addon'); ?></div>	
					</div>

			      	<div class="rs-dash-content-space"></div>
		      		<select name="revslider-featured-addon-slider">
			      	<?php
			      		$slider_select_options = "";
						foreach($arrSliders as $sliderony){
							$slider_alias = $sliderony->getAlias();
							echo '<option value="'.$slider_alias.'" '.selected( $revslider_featured_addon_values['revslider-featured-addon-slider'], $slider_alias , 0 ).'>'. $sliderony->getTitle() . '</option>';
						} 
					?>
					</select>

		      		<div class="rs-dash-content-space"></div>
				
					<input type="checkbox" class="tp-moderncheckbox revslider-featured-addon-overwrite-featured-image" data-unchecked="off" id="revslider-featured-addon-overwrite-featured-image" name="revslider-featured-addon-overwrite-featured-image"  <?php checked( $revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-image'], "on", 1 ); ?>> <?php _e('Overwrite Featured Image','revslider-featured-addon'); ?>
					
					<div class="rs-dash-content-space"></div>

					<input type="checkbox" class="tp-moderncheckbox revslider-featured-addon-overwrite-featured-slider" name="revslider-featured-addon-overwrite-featured-slider" id="revslider-featured-addon-overwrite-featured-slider" <?php checked( $revslider_featured_addon_values['revslider-featured-addon-overwrite-featured-slider'], "on", 1 ); ?>> <?php _e('Overwrite Featured Slider set in Post','revslider-featured-addon'); ?>
					
					<div class="rs-dash-content-space"></div>

					<input type="checkbox" class="tp-moderncheckbox revslider-featured-addon-write-when-no-featured-image" data-unchecked="off" id="revslider-featured-addon-write-when-no-featured-image" name="revslider-featured-addon-write-when-no-featured-image"  <?php checked( $revslider_featured_addon_values['revslider-featured-addon-write-when-no-featured-image'], "on", 1 ); ?>> <?php _e('Write when no featured image set in Post','revslider-featured-addon'); ?>
						
					<div class="rs-dash-content-space"></div>
		      	</div>
		      	<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Important Note:","revslider-featured-addon"); ?></div>
					<div><?php _e('If this feature does not work in your theme <br>please check out this <a href="https://www.themepunch.com/revslider-doc/add-on-featured-slider/#theme_not_support">short tutorial</a> to code in manually.','revslider-featured-addon'); ?></div>				
				</div>
			
			<span id="ajax_revslider_featured_addon_nonce" class="hidden"><?php echo wp_create_nonce( 'ajax_revslider_featured_addon_nonce' ) ?></span>
			<div class="rs-dash-bottom-wrapper">
				<span style="display:none" id="revslider-featured-addon-wait" class="loader_round">Please Wait...</span>					
				<a href="javascript:void(0);" id="revslider-featured-addon-save" class="rs-dash-button">Save</a>
			</div>	
		</form>
	<!-- End Settings -->
	</div>
</div>