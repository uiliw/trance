<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Revslider_Maintenance_Addon
 * @subpackage Revslider_Maintenance_Addon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Revslider_Maintenance_Addon
 * @subpackage Revslider_Maintenance_Addon/public
 * @author     ThemePunch <info@themepunch.com>
 */
class Revslider_Maintenance_Addon_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/revslider-maintenance-addon-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/revslider-maintenance-addon-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Maintenance Page
	 *
	 * Displays the coming soon page for anyone who's not logged in.
	 * The login page gets excluded so that you can login if necessary.
	 *
	 * @return void
	 */
	public function maintenance_mode() {
		global $pagenow;
		
		$revslider_maintenance_addon_values = array();
		$revslider_maintenance_addon_values_option = get_option('revslider_maintenance_addon');
		parse_str($revslider_maintenance_addon_values_option, $revslider_maintenance_addon_values);

		//Date Defaults
		$date=date_create(date('Y-m-d G:i',time()));
		$default_date = date_format($date,"F d, Y");
		$default_hour = date_format($date,"G");
		$default_minute = date_format($date,"i");

		$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day'] : $default_date;
		$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'] : $default_hour;
		$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'] : $default_minute;
		$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] : '0';

		//if autodeactivate is on and set autodeactivate
		if(isset($revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive']) && $revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive']){
			//if now exceeded end date turn maintenance off
			if( $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] && (strtotime($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day']." ".$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'].":".$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'])-current_time( 'timestamp' )) <= 0 ){
				$revslider_maintenance_addon_values_option = str_replace("revslider-maintenance-addon-active=1", "revslider-maintenance-addon-active=0", $revslider_maintenance_addon_values_option);
				update_option( 'revslider_maintenance_addon', $revslider_maintenance_addon_values_option);
				$revslider_maintenance_addon_values['revslider-maintenance-addon-active'] = 0;
			}
		}



		//if not login page, admin user, addon inactive show maintenance page
		if ( $pagenow !== 'wp-login.php' && $pagenow !=='revslider-sharing-addon-call.php' && $pagenow !=='revslider-login-addon-public-display.php' && ! current_user_can( 'manage_options' ) && ! is_admin() && isset($revslider_maintenance_addon_values['revslider-maintenance-addon-active']) && $revslider_maintenance_addon_values['revslider-maintenance-addon-active'] ) {
			header( 'HTTP/1.1 Service Unavailable', true, 503 );
			header( 'Content-Type: text/html; charset=utf-8' );
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/revslider-maintenance-addon-public-display.php' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . 'partials/revslider-maintenance-addon-public-display.php' );
			}
			die();
		}
	}
}
