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
 * @package           Revslider_404_Addon
 *
 * @wordpress-plugin
 * Plugin Name:       Slider Revolution 404 Page Add-On
 * Plugin URI:        https://revolution.themepunch.com
 * Description:       Build your own 404 Page with Slider Revolution!
 * Version:           1.0.1
 * Author:            ThemePunch
 * Author URI:        https://www.themepunch.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       revslider-404-addon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define("REV_ADDON_404_VERSION", "1.0.1");
define("REV_ADDON_404_URL", str_replace('index.php','',plugins_url( 'index.php', __FILE__ )));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-revslider-404-addon-activator.php
 */
function activate_revslider_404_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-revslider-404-addon-activator.php';
	Revslider_404_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-revslider-404-addon-deactivator.php
 */
function deactivate_revslider_404_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-revslider-404-addon-deactivator.php';
	Revslider_404_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_revslider_404_addon' );
register_deactivation_hook( __FILE__, 'deactivate_revslider_404_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-revslider-404-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_revslider_404_addon() {

	$plugin = new Revslider_404_Addon();
	$plugin->run();

}
run_revslider_404_addon();
