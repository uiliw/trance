<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.themepunch.com
 * @since             1.0.0
 * @package           Revslider_Featured_Addon
 *
 * @wordpress-plugin
 * Plugin Name:       Slider Revolution Featured Slider Add-on
 * Plugin URI:        https://www.themepunch.com
 * Description:       Replace Posts' Featured Images with RevSliders if the theme allows it
 * Version:           1.0.0
 * Author:            ThemePunch
 * Author URI:        https://www.themepunch.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       revslider-featured-addon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define("REV_ADDON_FEATURED_VERSION", "1.0.0");
define("REV_ADDON_FEATURED_URL", str_replace('index.php','',plugins_url( 'index.php', __FILE__ )));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-revslider-featured-addon-activator.php
 */
function activate_revslider_featured_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-revslider-featured-addon-activator.php';
	Revslider_Featured_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-revslider-featured-addon-deactivator.php
 */
function deactivate_revslider_featured_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-revslider-featured-addon-deactivator.php';
	Revslider_Featured_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_revslider_featured_addon' );
register_deactivation_hook( __FILE__, 'deactivate_revslider_featured_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-revslider-featured-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_revslider_featured_addon() {

	$plugin = new Revslider_Featured_Addon();
	$plugin->run();

	

}
run_revslider_featured_addon();
