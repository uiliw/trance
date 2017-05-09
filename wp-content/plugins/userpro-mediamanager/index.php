<?php
/*
Plugin Name: Media Managing Add-on for UserPro
Plugin URI: http://codecanyon.net/user/DeluxeThemes/portfolio?ref=DeluxeThemes
Description: Allow users to add media(audio, video and photos)to their profile.
Version: 3.5
Author: Deluxe Themes
Author URI: http://codecanyon.net/user/DeluxeThemes/portfolio?ref=DeluxeThemes
*/
define('userpro_media_url',plugin_dir_url(__FILE__ ));
define('userpro_media_path',plugin_dir_path(__FILE__ ));
	/* init */
	function userpro_media_init() {
		load_plugin_textdomain('userpro-media', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}
	add_action('init', 'userpro_media_init');

	
	/* functions */
	foreach (glob(userpro_media_path . 'functions/*.php') as $filename) { require_once $filename; }

	/* administration */
	if (is_admin()){
		foreach (glob(userpro_media_path . 'admin/*.php') as $filename) { include $filename; }
	}
