<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Rev_addon_rel_posts
 * @subpackage Rev_addon_rel_posts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rev_addon_rel_posts
 * @subpackage Rev_addon_rel_posts/admin
 * @author     ThemePunch <info@themepunch.com>
 */
class Rev_addon_rel_posts_Admin {

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
		 * defined in Rev_addon_rel_posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rev_addon_rel_posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rev_addon_rel_posts-admin.css', array(), $this->version, 'all' );
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
		 * defined in Rev_addon_rel_posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rev_addon_rel_posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rev_addon_rel_posts-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'rev_slider_addon_rel_posts', array(
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
		include_once( 'partials/rev_addon_rel_posts-admin-display.php' );
	}

	/**
	 * Saves Values for this Add-On
	 *
	 * @since    1.0.0
	 */
	public function save_rel_posts() {
		// Verify that the incoming request is coming with the security nonce
		if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax_rev_slider_addon_rel_posts_nonce' ) ) {
			if(isset($_REQUEST['rel_post_form'])){
				update_option( "rev_slider_addon_rel_posts", $_REQUEST['rel_post_form'] );
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
	 * Select Taxonomy Values Dropdown
	 *
	 * @since    1.0.0
	 */
	public function select_taxonomy ($taxonomy,$taxonomy_default = ""){
		if (is_array($taxonomy_default)) {
	          foreach ($taxonomy_default as $key => $post_term) {
	              $taxonomy = str_replace(' value="' . $post_term . '"', ' value="' . $post_term . '" selected="selected"', $taxonomy);
	          }
	    } else {
	          $taxonomy = str_replace(' value="' . $taxonomy_default . '"', ' value="' . $taxonomy_default . '" selected="selected"', $taxonomy);
	    }
	    return $taxonomy;
	}

	/**
	 * Add 
	 *
	 * @since    1.0.0
	 */
	public function rev_addons_filter( $addons ) {
	    $addons['revslider-rel-posts-addon'] = (object) array(
			'slug'			=> 'revslider-rel-posts-addon',
			'version_from'	=> '5.2.0', //at which version should it be shown
			'version_to'	=> '9.9.9', //if higher than here, it will be removed
			'title'			=> 'Related Posts',
			'line_1'		=> 'Add related Posts Sliders',
			'line_2'		=> 'to your post content',
			'available'		=> '1.0.0',
			'background'	=> '',
			'button'		=> 'Configure'
		);
	    return $addons;
	}
}
