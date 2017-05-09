<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.themepunch.com
 * @since             1.0.0
 * @package           Rev_addon_prevnext_posts
 *
 * @wordpress-plugin
 * Plugin Name:       Slider Revolution Previous and Next Posts Add-On
 * Plugin URI:        http://revolution.themepunch.com
 * Description:       Add previous and next Posts to your single post with style & Slider Revolution
 * Version:           1.0.0
 * Author:            ThemePunch
 * Author URI:        http://www.themepunch.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rev_addon_prevnext_posts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define("REV_ADDON_PREVNEXT_POSTS_VERSION", "1.0.0");

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rev_addon_prevnext_posts-activator.php
 */
function activate_rev_addon_prevnext_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rev_addon_prevnext_posts-activator.php';
	Rev_addon_prevnext_posts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rev_addon_prevnext_posts-deactivator.php
 */
function deactivate_rev_addon_prevnext_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rev_addon_prevnext_posts-deactivator.php';
	Rev_addon_prevnext_posts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rev_addon_prevnext_posts' );
register_deactivation_hook( __FILE__, 'deactivate_rev_addon_prevnext_posts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rev_addon_prevnext_posts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rev_addon_prevnext_posts() {

	$plugin = new Rev_addon_prevnext_posts();
	$plugin->run();

}
run_rev_addon_prevnext_posts();
