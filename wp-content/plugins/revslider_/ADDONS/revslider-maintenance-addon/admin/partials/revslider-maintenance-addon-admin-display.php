<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Revslider_Maintenance_Addon
 * @subpackage Revslider_Maintenance_Addon/admin/partials
 */

//saved values
$revslider_maintenance_addon_values = array();
parse_str(get_option('revslider_maintenance_addon'), $revslider_maintenance_addon_values);

//defaults
$revslider_maintenance_addon_values['revslider-maintenance-addon-type'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-type']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-type'] : 'slider';
$revslider_maintenance_addon_values['revslider-maintenance-addon-active'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-active']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-active'] : '0';
$revslider_maintenance_addon_values['revslider-maintenance-addon-slider'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-slider']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-slider'] : '';
$revslider_maintenance_addon_values['revslider-maintenance-addon-page'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-page']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-page'] : '';

$date=date_create(date('Y-m-d G:i',time()));
date_add($date,date_interval_create_from_date_string("2 days"));
$default_date = date_format($date,"F d, Y");
$default_hour = date_format($date,"G");
$default_minute = date_format($date,"i");

$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day'] : $default_date;
$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'] : $default_hour;
$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'] : $default_minute;

$revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive'] : '0';
$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] : '0';

// Available Sliders
$slider = new RevSlider();
$arrSliders = $slider->getArrSliders();
$defSlider = "";

// Available Pages
$pages = get_pages(array());
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="revslider_maintenance_addon_settings_slideout" class="rs-sbs-slideout-wrapper" style="display:none">
	<div class="rs-sbs-header">
		<div class="rs-sbs-step"><i class="eg-icon-cog"></i></div>
		<div class="rs-sbs-title"><?php _e('Coming Soon & Maintenance', 'revslider-maintenance-addon'); ?></div>
		<div class="rs-sbs-close"><i class="eg-icon-cancel"></i></div>
	</div>
	<div class="rs-submenu-wrapper" id="revslider-maintenance-addon-submenu" style="display:none">
		<ul class="rs-submenu-tabs-maintenance rs-submenu-tabs" style="display:inline-block; ">		
			<li id="maintenance_based_settings_li" class="selected" data-content="#subcat-maintenance-main"><?php _e('Page Settings', 'revslider-maintenance-addon'); ?></li>			
			<li id="maintenance_based_settings_li2" class="" data-content="#subcat-maintenance-countdown"><?php _e('Timer Settings', 'revslider-maintenance-addon'); ?></li>
		</ul>
	</div>
	<div class="tp-clearfix"></div>
	<div class="rs-sbs-slideout-inner">
	<!-- Start Settings -->
		<form id="revslider-maintenance-addon-form">
			<div id="subcat-maintenance-main" class="subcat-wrapper">
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Activate Coming Soon/Maintenance Mode","revslider-maintenance-addon"); ?></div>
					<div><?php _e('Turn it on (for non-admin users)?','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
				<input type="checkbox" name="revslider-maintenance-addon-active" value="1" <?php checked( $revslider_maintenance_addon_values['revslider-maintenance-addon-active'], '1' , 1 ); ?>> <?php _e("Active","revslider-maintenance-addon"); ?>
				<div class="rs-dash-content-space"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Maintenance Content","revslider-maintenance-addon"); ?></div>
					<div><?php _e('Display a slider or a whole page content?','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
		      	<input name="revslider-maintenance-addon-type" <?php checked( $revslider_maintenance_addon_values['revslider-maintenance-addon-type'], 'slider' , 1 ); ?> type="radio" value="slider">&nbsp;&nbsp;Slider
		      	&nbsp;&nbsp;
		      	<input name="revslider-maintenance-addon-type" <?php checked( $revslider_maintenance_addon_values['revslider-maintenance-addon-type'], 'page' , 1 ); ?> type="radio" value="page">&nbsp;&nbsp;Page
		      	
		      	<div class="rs-dash-content-space"></div>
				
		      	<div id="revslider_maintenance_type_slider" class="revslider_maintenance_type_details">
		      		<div class="rs-dash-content-with-icon">
						<div class="rs-dash-strong-content"><?php _e("Slider","revslider-maintenance-addon"); ?></div>
						<div><?php _e('Display full page with the selected slider','revslider-maintenance-addon'); ?></div>	
					</div>

			      	<div class="rs-dash-content-space"></div>
		      		<select name="revslider-maintenance-addon-slider">
			      	<?php
			      		$slider_select_options = "";
						foreach($arrSliders as $sliderony){
							$slider_alias = $sliderony->getAlias();
							echo '<option value="'.$slider_alias.'" '.selected( $revslider_maintenance_addon_values['revslider-maintenance-addon-slider'], $slider_alias , 0 ).'>'. $sliderony->getTitle() . '</option>';
						} 
					?>
					</select>

					<div class="rs-dash-content-space"></div>
					<div class="rs-dash-content-with-icon">
							<div class="rs-dash-strong-content"><?php _e("Page Title","revslider-maintenance-addon"); ?></div>
							<div><?php _e('Page Title for Maintenance page','revslider-maintenance-addon'); ?></div>	
					</div>
					
					<div class="rs-dash-content-space"></div>
				    <input name="revslider-maintenance-addon-page-title" style="width:300px" type="text" value="<?php echo isset($revslider_maintenance_addon_values['revslider-maintenance-addon-page-title']) ? stripslashes($revslider_maintenance_addon_values['revslider-maintenance-addon-page-title']) : '';?>">
		      	</div>
		      	
		      	<div id="revslider_maintenance_type_page" class="revslider_maintenance_type_details">
					<div class="rs-dash-content-with-icon">
							<div class="rs-dash-strong-content"><?php _e("Page","revslider-maintenance-addon"); ?></div>
							<div><?php _e('Select a page content to be displayed (works with <a href="https://revolution.themepunch.com">RevSlider</a> and <a href="https://essential.themepunch.com">EssGrid</a> shortcodes, other shortcodes not guaranteed to function).','revslider-maintenance-addon'); ?></div>	
					</div>
					<div class="rs-dash-content-space"></div>
			      	<select name="revslider-maintenance-addon-page">
				      	<?php
				      		foreach($pages as $page){
				      			if(!$page->post_password) echo '<option value="'.$page->ID.'" '.selected( $revslider_maintenance_addon_values['revslider-maintenance-addon-page'], $page->ID , 0 ).'>'. $page->post_title . '</option>';
							}
						?>
					</select>
		      	</div>
		      	<div class="rs-dash-content-space"></div>
		      	<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Use Timer","revslider-maintenance-addon"); ?></div>
					<div><?php _e('End date and time plus Countdown','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
				<input type="checkbox" name="revslider-maintenance-addon-countdown-active" id="revslider-maintenance-addon-countdown-active" value="1" <?php checked( $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'], '1' , 1 ); ?>> <?php _e("Timer Active","revslider-maintenance-addon"); ?>
			</div>	
			<div id="subcat-maintenance-countdown" class="subcat-wrapper" style="display:none">
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("End Date","revslider-maintenance-addon"); ?></div>
					<div><?php _e('Select the ending day (YYYY-MM-DD)','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
				<input type="input" id="datepicker" name="revslider-maintenance-addon-countdown-day" value="<?php  echo $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day']; ?>" class="datepicker" />
				
				<div class="rs-dash-content-space"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("End Time","revslider-maintenance-addon"); ?></div>
					<div><?php _e('Till what time the page/slider should be shown?','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
				<select id="hourpicker" name="revslider-maintenance-addon-countdown-hour">
					<?php 
					for($i=0;$i<24;$i++){
						if($i < 13){
							$hour = $i." am";
						}
						else{
							$hour = ($i-12)." pm";
						}
						echo '<option value="'.$i.'" '.selected( $i, $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'], 0 ).'>'.$hour.'</option>';
					}
					?>
				</select> :
				<select id="minutepicker" name="revslider-maintenance-addon-countdown-minute">
					<?php 
					for($i=0;$i<60;$i++){
						if($i < 10){
							$minute = "0".$i;
						}
						else{
							$minute = $i;
						}
						echo '<option value="'.$minute.'" '.selected( $i, $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'], 0 ).'>'.$minute.'</option>';
					}
					?>
				</select>
				<div class="rs-dash-content-space"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Deactivate automatically","revslider-maintenance-addon"); ?></div>
					<div><?php _e('Turn add-on off after timer ends?','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
				<input type="checkbox" name="revslider-maintenance-addon-auto-deactive" value="1" <?php checked( $revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive'], '1' , 1 ); ?>> <?php _e("Auto Deactivate","revslider-maintenance-addon"); ?>
				<div class="rs-dash-content-space"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Placeholders","revslider-maintenance-addon"); ?></div>
					<div><?php _e('Use this placeholders in your text layers if you want to show a countdown (also available in text layers "Insert Meta"','revslider-maintenance-addon'); ?></div>				
				</div>
				<div class="rs-dash-content-space"></div>
				<div>
					<table class="placeholder_table">
						<tr>
							<td><strong>%t_days%</strong></td>
							<td>Remaining days</td>
						</tr>
						<tr>
							<td><strong>%t_hours%</strong></td>
							<td>Remaining hours</td>
						</tr>
						<tr>
							<td><strong>%t_minutes% </strong></td>
							<td>Remaining minutes</td>
						</tr>
						<tr>
							<td><strong>%t_seconds% </strong></td>
							<td>Remaining seconds</td>
						</tr>
					</table>
				</div>
			</div>
			<span id="ajax_revslider_maintenance_addon_nonce" class="hidden"><?php echo wp_create_nonce( 'ajax_revslider_maintenance_addon_nonce' ) ?></span>
			<div class="rs-dash-bottom-wrapper">
				<span style="display:none" id="revslider-maintenance-addon-wait" class="loader_round">Please Wait...</span>					
				<a href="javascript:void(0);" id="revslider-maintenance-addon-save" class="rs-dash-button">Save</a>
			</div>	
		</form>
	<!-- End Settings -->
	</div>
</div>