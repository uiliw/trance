<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Revslider_Maintenance_Addon
 * @subpackage Revslider_Maintenance_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Revslider_Maintenance_Addon
 * @subpackage Revslider_Maintenance_Addon/admin
 * @author     ThemePunch <info@themepunch.com>
 */
class Revslider_Maintenance_Addon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Revslider_Maintenance_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Revslider_Maintenance_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/revslider-maintenance-addon-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style('e2b-admin-ui-css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);

		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Revslider_Maintenance_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Revslider_Maintenance_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/revslider-maintenance-addon-admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'revslider_maintenance_addon', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			));
		}

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		//$rev_slider_addon_values = get_option('revslider_sharing_addon_sizes');
		//$rev_slider_addon_values = unserialize($rev_slider_addon_values);
		include_once( 'partials/revslider-maintenance-addon-admin-display.php' );
	}

	/**
	 * Saves Values for this Add-On
	 *
	 * @since    1.0.0
	 */
	public function save_maintenance() {
		// Verify that the incoming request is coming with the security nonce
		if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax_revslider_maintenance_addon_nonce' ) ) {
			if(isset($_REQUEST['revslider_maintenance_form'])){
				update_option( "revslider_maintenance_addon", $_REQUEST['revslider_maintenance_form'] );
				die( '1' );
			}
			else{
				die( '0' );
			}
		} 
		else {
			die( '-1' );
		}
	}

	/**
	 * Add placeholders for timer
	 *
	 * @since    1.0.0
	 */
	public function add_placeholder() {
		echo '<tr><td><a href="javascript:UniteLayersRev.insertTemplate(\'%t_days%\')">%t_days%</a></td><td>'.__('Maintencance Timer - Remaining days',"revslider-maintenance-addon").'</td></tr>';
		echo '<tr><td><a href="javascript:UniteLayersRev.insertTemplate(\'%t_hours%\')">%t_hours%</a></td><td>'.__('Maintencance Timer - Remaining hours',"revslider-maintenance-addon").'</td></tr>';
		echo '<tr><td><a href="javascript:UniteLayersRev.insertTemplate(\'%t_minutes%\')">%t_minutes%</a></td><td>'.__('Maintencance Timer - Remaining minutes',"revslider-maintenance-addon").'</td></tr>';
		echo '<tr><td><a href="javascript:UniteLayersRev.insertTemplate(\'%t_seconds%\')">%t_seconds%</a></td><td>'.__('Maintencance Timer - Remaining seconds',"revslider-maintenance-addon").'</td></tr>';
	}

}
