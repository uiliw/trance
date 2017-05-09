<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$settings = $this->main->get_settings();
$socials = $this->main->get_social_networks();
$archive_skins = $this->main->get_archive_skins();

$fees = isset($settings['fees']) ? $settings['fees'] : array();
$currencies = $this->main->get_currencies();

// WordPress Pages
$pages = get_pages();

// Verify the Purchase Code
$verify = $envato->get_MEC_info('info');
?>
<div class="wrap" id="mec-wrap">
    <h1><?php _e('Modern Events Calendar', 'mec'); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="<?php echo $this->main->remove_qs_var('tab'); ?>" class="nav-tab nav-tab-active"><?php echo __('Settings', 'mec'); ?></a>
        <?php if(isset($this->settings['booking_status']) and $this->settings['booking_status']): ?>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-reg-form'); ?>" class="nav-tab"><?php echo __('Booking Form', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-gateways'); ?>" class="nav-tab"><?php echo __('Payment Gateways', 'mec'); ?></a>
        <?php endif; ?>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-notifications'); ?>" class="nav-tab"><?php echo __('Notifications', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-styling'); ?>" class="nav-tab"><?php echo __('Styling Options', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-customcss'); ?>" class="nav-tab"><?php echo __('Custom CSS', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-support'); ?>" class="nav-tab"><?php echo __('Support', 'mec'); ?></a>
    </h2>
    <div class="mec-container">
        <form id="mec_settings_form">
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('General Options', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_archive_title"><?php _e('Archive Page Title', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" id="mec_settings_archive_title" name="mec[settings][archive_title]" value="<?php echo ((isset($settings['archive_title']) and trim($settings['archive_title']) != '') ? $settings['archive_title'] : 'Events'); ?>" />
                        <a class="mec-tooltip" title="<?php esc_attr_e("Default value is Events", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_default_skin_archive"><?php _e('Archive Page Skin', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_default_skin_archive" name="mec[settings][default_skin_archive]">
                            <?php foreach($archive_skins as $archive_skin): ?>
                            <option value="<?php echo $archive_skin['skin']; ?>" <?php if(isset($settings['default_skin_archive']) and $archive_skin['skin'] == $settings['default_skin_archive']) echo 'selected="selected"'; ?>><?php echo $archive_skin['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a class="mec-tooltip" title="<?php esc_attr_e("Default value is Calendar/Monthly View", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_default_skin_category"><?php _e('Category Page Skin', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_default_skin_category" name="mec[settings][default_skin_category]">
                            <?php foreach($archive_skins as $archive_skin): ?>
                            <option value="<?php echo $archive_skin['skin']; ?>" <?php if(isset($settings['default_skin_category']) and $archive_skin['skin'] == $settings['default_skin_category']) echo 'selected="selected"'; if(!isset($settings['default_skin_category']) and $archive_skin['skin'] == 'list') echo 'selected="selected"'; ?>><?php echo $archive_skin['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a class="mec-tooltip" title="<?php esc_attr_e("Default value is List View", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_time_format"><?php _e('Time Format', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_time_format" name="mec[settings][time_format]">
                            <option value="12" <?php if(isset($settings['time_format']) and '12' == $settings['time_format']) echo 'selected="selected"'; ?>><?php _e('12 hours format with AM/PM', 'mec'); ?></option>
                            <option value="24" <?php if(isset($settings['time_format']) and '24' == $settings['time_format']) echo 'selected="selected"'; ?>><?php _e('24 hours format', 'mec'); ?></option>
                        </select>
                        <a class="mec-tooltip" title="<?php esc_attr_e("This option is for showing start/end time of events on frontend of website.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_multiple_day_show_method"><?php _e('Multiple Day Events', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_multiple_day_show_method" name="mec[settings][multiple_day_show_method]">
                            <option value="first_day_listgrid" <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'first_day_listgrid') echo 'selected="selected"'; ?>><?php _e('Show only first day on List/Grid skins', 'mec'); ?></option>
                            <option value="first_day" <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'first_day') echo 'selected="selected"'; ?>><?php _e('Show only first day on all skins', 'mec'); ?></option>
                            <option value="all_days" <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'all_days') echo 'selected="selected"'; ?>><?php _e('Show all days', 'mec'); ?></option>
                        </select>
                        <a class="mec-tooltip" title="<?php esc_attr_e("For showing all days of multiple day events on frontend or only show the first day.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_archive_status"><?php _e('Events Archive Status', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_archive_status" name="mec[settings][archive_status]">
                            <option value="1" <?php if(isset($settings['archive_status']) and $settings['archive_status'] == '1') echo 'selected="selected"'; ?>><?php _e('Enabled (Recommended)', 'mec'); ?></option>
                            <option value="0" <?php if(isset($settings['archive_status']) and !$settings['archive_status']) echo 'selected="selected"'; ?>><?php _e('Disabled', 'mec'); ?></option>
                        </select>
                        <a class="mec-tooltip" title="<?php esc_attr_e("If you disable it, then you should create a page as archive page of MEC. Page's slug must equals to \"Main Slug\" of MEC. Also it will disable all of MEC rewrite rules.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <?php $weekdays = $this->main->get_weekday_i18n_labels(); ?>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_weekdays"><?php _e('Weekdays', 'mec'); ?></label>
                    <div class="mec-col-8">
                        <?php $mec_weekdays = $this->main->get_weekdays(); foreach($weekdays as $weekday): ?>
                        <label for="mec_settings_weekdays_<?php echo $weekday[0]; ?>">
                            <input type="checkbox" id="mec_settings_weekdays_<?php echo $weekday[0]; ?>" name="mec[settings][weekdays][]" value="<?php echo $weekday[0]; ?>" <?php echo (in_array($weekday[0], $mec_weekdays) ? 'checked="checked"' : ''); ?> />
                            <?php echo $weekday[1]; ?>
                        </label>
                        <?php endforeach; ?>
                        <a class="mec-tooltip" title="<?php esc_attr_e('Proceed with caution. Default is set to Monday, Tuesday, Wednesday, Thursday and Friday.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_weekends"><?php _e('Weekends', 'mec'); ?></label>
                    <div class="mec-col-8">
                        <?php $mec_weekends = $this->main->get_weekends(); foreach($weekdays as $weekday): ?>
                        <label for="mec_settings_weekends_<?php echo $weekday[0]; ?>">
                            <input type="checkbox" id="mec_settings_weekends_<?php echo $weekday[0]; ?>" name="mec[settings][weekends][]" value="<?php echo $weekday[0]; ?>" <?php echo (in_array($weekday[0], $mec_weekends) ? 'checked="checked"' : ''); ?> />
                            <?php echo $weekday[1]; ?>
                        </label>
                        <?php endforeach; ?>
                        <a class="mec-tooltip" title="<?php esc_attr_e('Proceed with caution. Default is set to Saturday and Sunday.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Slugs/Permalinks', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_slug"><?php _e('Main Slug', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" id="mec_settings_slug" name="mec[settings][slug]" value="<?php echo ((isset($settings['slug']) and trim($settings['slug']) != '') ? $settings['slug'] : 'events'); ?>" />
                        <a class="mec-tooltip" title="<?php esc_attr_e("Default value is events. Valid characters are lowercase a-z, - character and numbers.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_category_slug"><?php _e('Category Slug', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" id="mec_settings_category_slug" name="mec[settings][category_slug]" value="<?php echo ((isset($settings['category_slug']) and trim($settings['category_slug']) != '') ? $settings['category_slug'] : 'mec-category'); ?>" />
                        <a class="mec-tooltip" title="<?php esc_attr_e("It's slug of MEC categories, you can change it to events-cat or something else. Default value is mec-category. Valid characters are lowercase a-z, - character and numbers.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Event Details/Single Event Page', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_single_event_date_format1"><?php _e('Single Event Date Format', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" id="mec_settings_single_event_date_format1" name="mec[settings][single_date_format1]" value="<?php echo ((isset($settings['single_date_format1']) and trim($settings['single_date_format1']) != '') ? $settings['single_date_format1'] : 'M d Y'); ?>" />
                        <a class="mec-tooltip" title="<?php esc_attr_e('Default is M d Y', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_single_event_date_method"><?php _e('Date Method', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_single_event_date_method" name="mec[settings][single_date_method]">
                            <option value="next" <?php echo (isset($settings['single_date_method']) and $settings['single_date_method'] == 'next') ? 'selected="selected"' : ''; ?>><?php _e('Next occurrence date', 'mec'); ?></option>
                            <option value="referred" <?php echo (isset($settings['single_date_method']) and $settings['single_date_method'] == 'referred') ? 'selected="selected"' : ''; ?>><?php _e('Referred date', 'mec'); ?></option>
                        </select>
                        <a class="mec-tooltip" title="<?php esc_attr_e('"Referred date" shows the event date based on referred date in event list.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Currency Options', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_currency"><?php _e('Currency', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select name="mec[settings][currency]" id="mec_settings_currency" onchange="jQuery('#mec_settings_currency_symptom_container .mec-settings-currency-symptom-prev').html(this.value);">
                            <?php foreach($currencies as $currency=>$currency_name): ?>
                            <option value="<?php echo $currency; ?>" <?php echo ((isset($settings['currency']) and $settings['currency'] == $currency) ? 'selected="selected"' : ''); ?>><?php echo $currency_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_currency_symptom"><?php _e('Currency Sign', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" name="mec[settings][currency_symptom]" id="mec_settings_currency_symptom" value="<?php echo (isset($settings['currency_symptom']) ? $settings['currency_symptom'] : ''); ?>" />
                        <a class="mec-tooltip" title="<?php esc_attr_e("Default value will be \"currency\" if you leave it empty.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_currency_sign"><?php _e('Currency Position', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select name="mec[settings][currency_sign]" id="mec_settings_currency_sign">
                            <option value="before" <?php echo ((isset($settings['currency_sign']) and $settings['currency_sign'] == 'before') ? 'selected="selected"' : ''); ?>><?php _e('Before $10', 'mec'); ?></option>
                            <option value="after" <?php echo ((isset($settings['currency_sign']) and $settings['currency_sign'] == 'after') ? 'selected="selected"' : ''); ?>><?php _e('After 10$', 'mec'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_thousand_separator"><?php _e('Thousand Separator', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" name="mec[settings][thousand_separator]" id="mec_settings_thousand_separator" value="<?php echo (isset($settings['thousand_separator']) ? $settings['thousand_separator'] : ','); ?>" />
                    </div>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_decimal_separator"><?php _e('Decimal Separator', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" name="mec[settings][decimal_separator]" id="mec_settings_decimal_separator" value="<?php echo (isset($settings['decimal_separator']) ? $settings['decimal_separator'] : '.'); ?>" />
                    </div>
                </div>
                <div class="mec-form-row">
                    <div class="mec-col-2">
                        <label for="mec_settings_decimal_separator_status">
                            <input type="hidden" name="mec[settings][decimal_separator_status]" value="1" />
                            <input type="checkbox" name="mec[settings][decimal_separator_status]" id="mec_settings_decimal_separator_status" <?php echo ((isset($settings['decimal_separator_status']) and $settings['decimal_separator_status'] == '0') ? 'checked="checked"' : ''); ?> value="0" />
                            <?php _e('No decimal', 'mec'); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Google Maps Options', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][google_maps_status]" value="0" />
                        <input onchange="jQuery('#mec_google_maps_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][google_maps_status]" <?php if(isset($settings['google_maps_status']) and $settings['google_maps_status']) echo 'checked="checked"'; ?> /> <?php _e('Show Google Maps on event page', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_google_maps_container_toggle" class="<?php if((isset($settings['google_maps_status']) and !$settings['google_maps_status']) or !isset($settings['google_maps_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_google_maps_api_key"><?php _e('API Key', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_google_maps_api_key" name="mec[settings][google_maps_api_key]" value="<?php echo ((isset($settings['google_maps_api_key']) and trim($settings['google_maps_api_key']) != '') ? $settings['google_maps_api_key'] : ''); ?>" />
                            <a class="mec-tooltip" title="<?php esc_attr_e("Required!", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3"><?php _e('Zoom level', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <select name="mec[settings][google_maps_zoomlevel]">
                                <?php for($i = 5; $i <= 21; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php if(isset($settings['google_maps_zoomlevel']) and $settings['google_maps_zoomlevel'] == $i) echo 'selected="selected"'; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3"><?php _e('Google Maps Style', 'mec'); ?></label>
                        <?php $styles = $this->main->get_googlemap_styles(); ?>
                        <div class="mec-col-4">
                            <select name="mec[settings][google_maps_style]">
                                <option value=""><?php _e('Default', 'mec'); ?></option>
                                <?php foreach($styles as $style): ?>
                                <option value="<?php echo $style['key']; ?>" <?php if(isset($settings['google_maps_style']) and $settings['google_maps_style'] == $style['key']) echo 'selected="selected"'; ?>><?php echo $style['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3"><?php _e('Direction on single event', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <select name="mec[settings][google_maps_get_direction_status]">
                                <option value="0"><?php _e('Disabled', 'mec'); ?></option>
                                <option value="1" <?php if(isset($settings['google_maps_get_direction_status']) and $settings['google_maps_get_direction_status'] == 1) echo 'selected="selected"'; ?>><?php _e('Simple Method', 'mec'); ?></option>
                                <option value="2" <?php if(isset($settings['google_maps_get_direction_status']) and $settings['google_maps_get_direction_status'] == 2) echo 'selected="selected"'; ?>><?php _e('Advanced Method', 'mec'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_google_maps_date_format1"><?php _e('Lightbox Date Format', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_google_maps_date_format1" name="mec[settings][google_maps_date_format1]" value="<?php echo ((isset($settings['google_maps_date_format1']) and trim($settings['google_maps_date_format1']) != '') ? $settings['google_maps_date_format1'] : 'M d Y'); ?>" />
                            <a class="mec-tooltip" title="<?php esc_attr_e('Default value is M d Y', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3"><?php _e('Google Maps API', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <label>
                                <input type="hidden" name="mec[settings][google_maps_dont_load_api]" value="0" />
                                <input value="1" type="checkbox" name="mec[settings][google_maps_dont_load_api]" <?php if(isset($settings['google_maps_dont_load_api']) and $settings['google_maps_dont_load_api']) echo 'checked="checked"'; ?> /> <?php _e("Don't load Google Maps API library", 'mec'); ?>
                            </label>
                            <a class="mec-tooltip" title="<?php esc_attr_e("Check it only if another plugin/theme is loading the Google Maps API", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Google Recaptcha Options', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][google_recaptcha_status]" value="0" />
                        <input onchange="jQuery('#mec_google_recaptcha_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][google_recaptcha_status]" <?php if(isset($settings['google_recaptcha_status']) and $settings['google_recaptcha_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable Google Recaptcha', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_google_recaptcha_container_toggle" class="<?php if((isset($settings['google_recaptcha_status']) and !$settings['google_recaptcha_status']) or !isset($settings['google_recaptcha_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label>
                            <input type="hidden" name="mec[settings][google_recaptcha_booking]" value="0" />
                            <input value="1" type="checkbox" name="mec[settings][google_recaptcha_booking]" <?php if(isset($settings['google_recaptcha_booking']) and $settings['google_recaptcha_booking']) echo 'checked="checked"'; ?> /> <?php _e('Enable on booking form', 'mec'); ?>
                        </label>
                    </div>
                    <div class="mec-form-row">
                        <label>
                            <input type="hidden" name="mec[settings][google_recaptcha_fes]" value="0" />
                            <input value="1" type="checkbox" name="mec[settings][google_recaptcha_fes]" <?php if(isset($settings['google_recaptcha_fes']) and $settings['google_recaptcha_fes']) echo 'checked="checked"'; ?> /> <?php _e('Enable on "Frontend Event Submittion" form', 'mec'); ?>
                        </label>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_google_recaptcha_sitekey"><?php _e('Site Key', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_google_recaptcha_sitekey" name="mec[settings][google_recaptcha_sitekey]" value="<?php echo ((isset($settings['google_recaptcha_sitekey']) and trim($settings['google_recaptcha_sitekey']) != '') ? $settings['google_recaptcha_sitekey'] : ''); ?>" />
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_google_recaptcha_secretkey"><?php _e('Secret Key', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_google_recaptcha_secretkey" name="mec[settings][google_recaptcha_secretkey]" value="<?php echo ((isset($settings['google_recaptcha_secretkey']) and trim($settings['google_recaptcha_secretkey']) != '') ? $settings['google_recaptcha_secretkey'] : ''); ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Export Module Options', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][export_module_status]" value="0" />
                        <input onchange="jQuery('#mec_export_module_options_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][export_module_status]" <?php if(isset($settings['export_module_status']) and $settings['export_module_status']) echo 'checked="checked"'; ?> /> <?php _e('Show export module (iCal export and add to Google calendars) on event page', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_export_module_options_container_toggle" class="<?php if((isset($settings['export_module_status']) and !$settings['export_module_status']) or !isset($settings['export_module_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <ul id="mec_export_module_options" class="mec-form-row">
                            <?php
                            $event_options = array('googlecal'=>__('Google Calendar', 'mec'), 'ical'=>__('iCal', 'mec'));
                            foreach($event_options as $event_key=>$event_option): ?>
                            <li id="mec_sn_<?php echo esc_attr($event_key); ?>" data-id="<?php echo esc_attr($event_key); ?>" class="mec-form-row mec-switcher <?php echo ((isset($settings['sn'][$event_key]) and $settings['sn'][$event_key]) ? 'mec-enabled' : 'mec-disabled'); ?>">
                                <label class="mec-col-3"><?php echo esc_html($event_option); ?></label>
                                <div class="mec-col-2">
                                    <input class="mec-status" type="hidden" name="mec[settings][sn][<?php echo esc_attr($event_key); ?>]" value="<?php echo (isset($settings['sn'][$event_key]) ? $settings['sn'][$event_key] : '1'); ?>" />
                                    <label for="mec[settings][sn][<?php echo esc_attr($event_key); ?>]"></label>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Countdown Options', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][countdown_status]" value="0" />
                        <input onchange="jQuery('#mec_count_down_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][countdown_status]" <?php if(isset($settings['countdown_status']) and $settings['countdown_status']) echo 'checked="checked"'; ?> /> <?php _e('Show countdown module on event page', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_count_down_container_toggle" class="<?php if((isset($settings['countdown_status']) and !$settings['countdown_status']) or !isset($settings['countdown_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_countdown_list"><?php _e('Countdown Style', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <select id="mec_settings_countdown_list" name="mec[settings][countdown_list]">
                                <option value="default" <?php echo ((isset($settings['countdown_list']) and $settings['countdown_list'] == "default") ? 'selected="selected"' : ''); ?> ><?php _e('Plain Style', 'mec'); ?></option>
                                <option value="flip" <?php echo ((isset($settings['countdown_list']) and $settings['countdown_list'] == "flip") ? 'selected="selected"' : ''); ?> ><?php _e('Flip Style', 'mec'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Social Networks', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][social_network_status]" value="0" />
                        <input onchange="jQuery('#mec_social_network_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][social_network_status]" <?php if(isset($settings['social_network_status']) and $settings['social_network_status']) echo 'checked="checked"'; ?> /> <?php _e('Show social network module', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_social_network_container_toggle" class="<?php if((isset($settings['social_network_status']) and !$settings['social_network_status']) or !isset($settings['social_network_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <ul id="mec_social_networks" class="mec-form-row">
                            <?php foreach($socials as $social): ?>
                            <li id="mec_sn_<?php echo esc_attr($social['id']); ?>" data-id="<?php echo esc_attr($social['id']); ?>" class="mec-form-row mec-switcher <?php echo ((isset($settings['sn'][$social['id']]) and $settings['sn'][$social['id']]) ? 'mec-enabled' : 'mec-disabled'); ?>">
                                <label class="mec-col-3"><?php echo esc_html($social['name']); ?></label>
                                <div class="mec-col-2">
                                    <input class="mec-status" type="hidden" name="mec[settings][sn][<?php echo esc_attr($social['id']); ?>]" value="<?php echo (isset($settings['sn'][$social['id']]) ? $settings['sn'][$social['id']] : '1'); ?>" />
                                    <label for="mec[settings][sn][<?php echo esc_attr($social['id']); ?>]"></label>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Frontend Event Submission', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_fes_list_page"><?php _e('Events List Page', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_fes_list_page" name="mec[settings][fes_list_page]">
                            <option value="">----</option>
                            <?php foreach($pages as $page): ?>
                            <option <?php echo ((isset($settings['fes_list_page']) and $settings['fes_list_page'] == $page->ID) ? 'selected="selected"' : ''); ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <p class="description"><?php echo sprintf(__('Put %s shortcode into the page.', 'mec'), '<code>[MEC_fes_list]</code>'); ?></p>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_fes_form_page"><?php _e('Add/Edit Events Page', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <select id="mec_settings_fes_form_page" name="mec[settings][fes_form_page]">
                            <option value="">----</option>
                            <?php foreach($pages as $page): ?>
                            <option <?php echo ((isset($settings['fes_form_page']) and $settings['fes_form_page'] == $page->ID) ? 'selected="selected"' : ''); ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <p class="description"><?php echo sprintf(__('Put %s shortcode into the page.', 'mec'), '<code>[MEC_fes_form]</code>'); ?></p>
                </div>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][fes_guest_status]" value="0" />
                        <input value="1" type="checkbox" name="mec[settings][fes_guest_status]" <?php if(isset($settings['fes_guest_status']) and $settings['fes_guest_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable event submission by guest (Not logged-in) users', 'mec'); ?>
                    </label>
                </div>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][fes_note]" value="0" />
                        <input onchange="jQuery('#mec_fes_note_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][fes_note]" <?php if(isset($settings['fes_note']) and $settings['fes_note']) echo 'checked="checked"'; ?> /> <?php _e('Enable note field', 'mec'); ?>
                    </label>
                    <a class="mec-tooltip" title="<?php esc_attr_e("Users can put a note for editors while they're submitting the event. Also you can put %%event_note%% into the new event notification in order to get users' note in email.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                </div>
                <div id="mec_fes_note_container_toggle" class="<?php if((isset($settings['fes_note']) and !$settings['fes_note']) or !isset($settings['fes_note'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_fes_note_visibility"><?php _e('Visibility of Note', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <select id="mec_settings_fes_note_visibility" name="mec[settings][fes_note_visibility]">
                                <option <?php echo ((isset($settings['fes_note_visibility']) and $settings['fes_note_visibility'] == 'always') ? 'selected="selected"' : ''); ?> value="always"><?php _e('Always', 'mec'); ?></option>
                                <option <?php echo ((isset($settings['fes_note_visibility']) and $settings['fes_note_visibility'] == 'pending') ? 'selected="selected"' : ''); ?> value="pending"><?php _e('While event is not published', 'mec'); ?></option>
                            </select>
                        </div>
                        <a class="mec-tooltip" title="<?php esc_attr_e("Event Note shows on Frontend Submission Form and Edit Event in backend.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Exceptional days', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][exceptional_days]" value="0" />
                        <input value="1" type="checkbox" name="mec[settings][exceptional_days]" <?php if(isset($settings['exceptional_days']) and $settings['exceptional_days']) echo 'checked="checked"'; ?> /> <?php _e('Show exceptional days option on Add/Edit events page', 'mec'); ?>
                        <a class="mec-tooltip" title="<?php esc_attr_e('Using this option you can include/exclude certain days to/from event occurrence dates.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                    </label>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Booking', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][booking_status]" value="0" />
                        <input onchange="jQuery('#mec_booking_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][booking_status]" <?php if(isset($settings['booking_status']) and $settings['booking_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable booking module', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_booking_container_toggle" class="<?php if((isset($settings['booking_status']) and !$settings['booking_status']) or !isset($settings['booking_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_booking_date_format1"><?php _e('Date Format', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_booking_date_format1" name="mec[settings][booking_date_format1]" value="<?php echo ((isset($settings['booking_date_format1']) and trim($settings['booking_date_format1']) != '') ? $settings['booking_date_format1'] : 'Y-m-d'); ?>" />
                            <a class="mec-tooltip" title="<?php esc_attr_e('Default is Y-m-d', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_booking_maximum_dates"><?php _e('Maximum Dates', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="number" id="mec_settings_booking_maximum_dates" name="mec[settings][booking_maximum_dates]" value="<?php echo ((isset($settings['booking_maximum_dates']) and trim($settings['booking_maximum_dates']) != '') ? $settings['booking_maximum_dates'] : '6'); ?>" placeholder="<?php esc_attr_e('Default is 6', 'mec'); ?>" min="1" />
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_booking_thankyou_page"><?php _e('Thank You Page', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <select id="mec_settings_booking_thankyou_page" name="mec[settings][booking_thankyou_page]">
                                <option value="">----</option>
                                <?php foreach($pages as $page): ?>
                                <option <?php echo ((isset($settings['booking_thankyou_page']) and $settings['booking_thankyou_page'] == $page->ID) ? 'selected="selected"' : ''); ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <a class="mec-tooltip" title="<?php esc_attr_e('User redirects to this page after booking. Leave it empty if you want to disable it.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                    <h5 class="mec-form-subtitle"><?php _e('Email verification', 'mec'); ?></h5>
                    <div class="mec-form-row">
                        <div class="mec-col-12">
                            <label for="mec_settings_booking_auto_verify_free">
                                <input type="hidden" name="mec[settings][booking_auto_verify_free]" value="0" />
                                <input type="checkbox" name="mec[settings][booking_auto_verify_free]" id="mec_settings_booking_auto_verify_free" <?php echo ((isset($settings['booking_auto_verify_free']) and $settings['booking_auto_verify_free'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                <?php _e('Auto verification for free bookings', 'mec'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <div class="mec-col-12">
                            <label for="mec_settings_booking_auto_verify_paid">
                                <input type="hidden" name="mec[settings][booking_auto_verify_paid]" value="0" />
                                <input type="checkbox" name="mec[settings][booking_auto_verify_paid]" id="mec_settings_booking_auto_verify_paid" <?php echo ((isset($settings['booking_auto_verify_paid']) and $settings['booking_auto_verify_paid'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                <?php _e('Auto verification for paid bookings', 'mec'); ?>
                            </label>
                        </div>
                    </div>
                    <h5 class="mec-form-subtitle"><?php _e('Booking Confirmation', 'mec'); ?></h5>
                    <div class="mec-form-row">
                        <div class="mec-col-12">
                            <label for="mec_settings_booking_auto_confirm_free">
                                <input type="hidden" name="mec[settings][booking_auto_confirm_free]" value="0" />
                                <input type="checkbox" name="mec[settings][booking_auto_confirm_free]" id="mec_settings_booking_auto_confirm_free" <?php echo ((isset($settings['booking_auto_confirm_free']) and $settings['booking_auto_confirm_free'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                <?php _e('Auto confirmation for free bookings', 'mec'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <div class="mec-col-12">
                            <label for="mec_settings_booking_auto_confirm_paid">
                                <input type="hidden" name="mec[settings][booking_auto_confirm_paid]" value="0" />
                                <input type="checkbox" name="mec[settings][booking_auto_confirm_paid]" id="mec_settings_booking_auto_confirm_paid" <?php echo ((isset($settings['booking_auto_confirm_paid']) and $settings['booking_auto_confirm_paid'] == '1') ? 'checked="checked"' : ''); ?> value="1" />
                                <?php _e('Auto confirmation for paid bookings', 'mec'); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Coupons', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][coupons_status]" value="0" />
                        <input onchange="jQuery('#mec_coupons_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][coupons_status]" <?php if(isset($settings['coupons_status']) and $settings['coupons_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable coupons module', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_coupons_container_toggle" class="<?php if((isset($settings['coupons_status']) and !$settings['coupons_status']) or !isset($settings['coupons_status'])) echo 'mec-util-hidden'; ?>">
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Taxes / Fees', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][taxes_fees_status]" value="0" />
                        <input onchange="jQuery('#mec_taxes_fees_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][taxes_fees_status]" <?php if(isset($settings['taxes_fees_status']) and $settings['taxes_fees_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable taxes / fees module', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_taxes_fees_container_toggle" class="<?php if((isset($settings['taxes_fees_status']) and !$settings['taxes_fees_status']) or !isset($settings['taxes_fees_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <button class="button" type="button" id="mec_add_fee_button"><?php _e('Add Fee', 'mec'); ?></button>
                    </div>
                    <div class="mec-form-row" id="mec_fees_list">
                        <?php $i = 0; foreach($fees as $key=>$fee): if(!is_numeric($key)) continue; $i = max($i, $key); ?>
                        <div class="mec-box" id="mec_fee_row<?php echo $i; ?>">
                            <div class="mec-form-row">
                                <input class="mec-col-12" type="text" name="mec[settings][fees][<?php echo $i; ?>][title]" placeholder="<?php esc_attr_e('Fee Title', 'mec'); ?>" value="<?php echo (isset($fee['title']) ? $fee['title'] : ''); ?>" />
                            </div>
                            <div class="mec-form-row">
                                <span class="mec-col-4">
                                    <input type="text" name="mec[settings][fees][<?php echo $i; ?>][amount]" placeholder="<?php esc_attr_e('Amount', 'mec'); ?>" value="<?php echo (isset($fee['amount']) ? $fee['amount'] : ''); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Fee amount, considered as fixed amount if you set the type to amount otherwise considered as percentage', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </span>
                                <span class="mec-col-4">
                                    <select name="mec[settings][fees][<?php echo $i; ?>][type]">
                                        <option value="percent" <?php echo ((isset($fee['type']) and $fee['type'] == 'percent') ? 'selected="selected"' : ''); ?>><?php _e('Percent', 'mec'); ?></option>
                                        <option value="amount" <?php echo ((isset($fee['type']) and $fee['type'] == 'amount') ? 'selected="selected"' : ''); ?>><?php _e('Amount', 'mec'); ?></option>
                                    </select>
                                </span>
                                <button class="button" type="button" id="mec_remove_fee_button<?php echo $i; ?>" onclick="mec_remove_fee(<?php echo $i; ?>);"><?php _e('Remove', 'mec'); ?></button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" id="mec_new_fee_key" value="<?php echo $i+1; ?>" />
                    <div class="mec-util-hidden" id="mec_new_fee_raw">
                        <div class="mec-box" id="mec_fee_row:i:">
                            <div class="mec-form-row">
                                <input class="mec-col-12" type="text" name="mec[settings][fees][:i:][title]" placeholder="<?php esc_attr_e('Fee Title', 'mec'); ?>" />
                            </div>
                            <div class="mec-form-row">
                                <span class="mec-col-4">
                                    <input type="text" name="mec[settings][fees][:i:][amount]" placeholder="<?php esc_attr_e('Amount', 'mec'); ?>" />
                                    <a class="mec-tooltip" title="<?php esc_attr_e('Fee amount, considered as fixed amount if you set the type to amount otherwise considered as percentage', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                                </span>
                                <span class="mec-col-4">
                                    <select name="mec[settings][fees][:i:][type]">
                                        <option value="percent"><?php _e('Percent', 'mec'); ?></option>
                                        <option value="amount"><?php _e('Amount', 'mec'); ?></option>
                                    </select>
                                </span>
                                <button class="button" type="button" id="mec_remove_fee_button:i:" onclick="mec_remove_fee(:i:);"><?php _e('Remove', 'mec'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('BuddyPress Integration', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][bp_status]" value="0" />
                        <input onchange="jQuery('#mec_bp_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][bp_status]" <?php if(isset($settings['bp_status']) and $settings['bp_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable BuddyPress Integration', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_bp_container_toggle" class="<?php if((isset($settings['bp_status']) and !$settings['bp_status']) or !isset($settings['bp_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label>
                            <input type="hidden" name="mec[settings][bp_attendees_module]" value="0" />
                            <input value="1" type="checkbox" name="mec[settings][bp_attendees_module]" <?php if(isset($settings['bp_attendees_module']) and $settings['bp_attendees_module']) echo 'checked="checked"'; ?> /> <?php _e('Show "Attendees Module" in event details page', 'mec'); ?>
                        </label>
                    </div>
                    <div class="mec-form-row">
                        <label>
                            <input type="hidden" name="mec[settings][bp_add_activity]" value="0" />
                            <input value="1" type="checkbox" name="mec[settings][bp_add_activity]" <?php if(isset($settings['bp_add_activity']) and $settings['bp_add_activity']) echo 'checked="checked"'; ?> /> <?php _e('Add booking activity to user profile', 'mec'); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('Mailchimp Integration', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label>
                        <input type="hidden" name="mec[settings][mchimp_status]" value="0" />
                        <input onchange="jQuery('#mec_mchimp_status_container_toggle').toggle();" value="1" type="checkbox" name="mec[settings][mchimp_status]" <?php if(isset($settings['mchimp_status']) and $settings['mchimp_status']) echo 'checked="checked"'; ?> /> <?php _e('Enable Mailchimp Integration', 'mec'); ?>
                    </label>
                </div>
                <div id="mec_mchimp_status_container_toggle" class="<?php if((isset($settings['mchimp_status']) and !$settings['mchimp_status']) or !isset($settings['mchimp_status'])) echo 'mec-util-hidden'; ?>">
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_mchimp_api_key"><?php _e('API Key', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_mchimp_api_key" name="mec[settings][mchimp_api_key]" value="<?php echo ((isset($settings['mchimp_api_key']) and trim($settings['mchimp_api_key']) != '') ? $settings['mchimp_api_key'] : ''); ?>" />
                            <a class="mec-tooltip" title="<?php esc_attr_e("Required!", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_mchimp_list_id"><?php _e('List ID', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <input type="text" id="mec_settings_mchimp_list_id" name="mec[settings][mchimp_list_id]" value="<?php echo ((isset($settings['mchimp_list_id']) and trim($settings['mchimp_list_id']) != '') ? $settings['mchimp_list_id'] : ''); ?>" />
                            <a class="mec-tooltip" title="<?php esc_attr_e("Required!", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                    <div class="mec-form-row">
                        <label class="mec-col-3" for="mec_settings_mchimp_subscription_status"><?php _e('Subscription Status', 'mec'); ?></label>
                        <div class="mec-col-4">
                            <select name="mec[settings][mchimp_subscription_status]" id="mec_settings_mchimp_subscription_status">
                                <option value="subscribed" <?php if(isset($settings['mchimp_subscription_status']) and $settings['mchimp_subscription_status'] == 'subscribed') echo 'selected="selected"'; ?>><?php _e('Subscribe automatically', 'mec'); ?></option>
                                <option value="pending" <?php if(isset($settings['mchimp_subscription_status']) and $settings['mchimp_subscription_status'] == 'pending') echo 'selected="selected"'; ?>><?php _e('Subscribe by verification', 'mec'); ?></option>
                            </select>
                            <a class="mec-tooltip" title="<?php esc_attr_e('If you choose "Subscribe by verification" then an email will send to user by mailchimp for subscription verification.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mec-options-fields">
                <h4 class="mec-form-subtitle"><?php _e('MEC Activation', 'mec'); ?></h4>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_purchase_code"><?php _e('Purchase Code', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" name="mec[settings][purchase_code]" id="mec_settings_purchase_code" value="<?php echo (isset($settings['purchase_code']) ? $settings['purchase_code'] : ''); ?>" />
                    </div>
                    <?php if(isset($verify->code)): ?>
                    <span class="mec-purchase-verify mec-success"><?php _e('Verified', 'mec'); ?></span>
                    <?php else: ?>
                    <span class="mec-purchase-verify mec-error"><?php _e('UnVerified', 'mec'); ?></span>
                    <?php endif; ?>
                    <a class="mec-tooltip" title="<?php esc_attr_e("Please insert your purchase code validation. read documentation for more information.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                </div>
                <div class="mec-form-row">
                    <label class="mec-col-3" for="mec_settings_envato_token"><?php _e('Token Code', 'mec'); ?></label>
                    <div class="mec-col-4">
                        <input type="text" name="mec[settings][envato_token]" id="mec_settings_envato_token" value="<?php echo (isset($settings['envato_token']) ? $settings['envato_token'] : ''); ?>" />
                    </div>
                    <?php if(!isset($verify->error)): ?>
                    <span class="mec-token-verify mec-success"><?php _e('Verified', 'mec'); ?></span>
                    <?php elseif(isset($verify->error_description)): ?>
                    <span class="mec-token-verify mec-error"><?php _e($verify->error_description, 'mec'); ?></span>
                    <?php else: ?>
                    <span class="mec-token-verify mec-error"><?php _e('UnVerified', 'mec'); ?></span>
                    <?php endif; ?>
                    <a class="mec-tooltip" title="<?php esc_attr_e("Enter your token code to activate auto update feature. read documentation for more information.", 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
                </div>
            </div>     
            <div class="mec-options-fields">
                <button id="mec_settings_form_button" class="button button-primary mec-button-primary" type="submit"><?php _e('Save Changes', 'mec'); ?></button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
jQuery("#mec_settings_form").on('submit', function(event)
{
    event.preventDefault();
    
    // Add loading Class to the button
    jQuery("#mec_settings_form_button").addClass('loading').text("<?php esc_attr_e('Saved', 'mec'); ?>");

    if(jQuery(".mec-purchase-verify").text() != '<?php esc_attr_e('Verified', 'mec'); ?>')
    {
        jQuery(".mec-purchase-verify").text("<?php esc_attr_e('Checking ...', 'mec'); ?>");
        jQuery(".mec-token-verify").text("<?php esc_attr_e('Checking ...', 'mec'); ?>");
    } 
    
    var settings = jQuery("#mec_settings_form").serialize();
    jQuery.ajax(
    {
        type: "POST",
        url: ajaxurl,
        data: "action=mec_save_settings&"+settings,
        success: function(data)
        {
            // Remove the loading Class to the button
            setTimeout(function(){
                jQuery("#mec_settings_form_button").removeClass('loading').text("<?php esc_attr_e('Save Changes', 'mec'); ?>");
                
                if(jQuery(".mec-purchase-verify").text() != '<?php esc_attr_e('Verified', 'mec'); ?>')
                {
                    jQuery(".mec-purchase-verify").text("<?php esc_attr_e('Please Refresh Page', 'mec'); ?>");
                    jQuery(".mec-token-verify").text("<?php esc_attr_e('Please Refresh Page', 'mec'); ?>");
                }
            }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            setTimeout(function(){
                jQuery("#mec_settings_form_button").removeClass('loading').text("<?php esc_attr_e('Save Changes', 'mec'); ?>");
            }, 1000);
        }
    });
});
</script>