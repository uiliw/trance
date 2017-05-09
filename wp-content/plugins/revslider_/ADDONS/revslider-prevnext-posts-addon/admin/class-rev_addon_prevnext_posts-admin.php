<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Rev_addon_prevnext_posts
 * @subpackage Rev_addon_prevnext_posts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rev_addon_prevnext_posts
 * @subpackage Rev_addon_prevnext_posts/admin
 * @author     ThemePunch <info@themepunch.com>
 */
class Rev_addon_prevnext_posts_Admin {

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
		 * defined in Rev_addon_prevnext_posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rev_addon_prevnext_posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rev_addon_prevnext_posts-admin.css', array(), $this->version, 'all' );
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
		 * defined in Rev_addon_prevnext_posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rev_addon_prevnext_posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rev_addon_prevnext_posts-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'rev_slider_addon_prevnext_posts', array(
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
		include_once( 'partials/rev_addon_prevnext_posts-admin-display.php' );
	}

	/**
	 * Saves Values for this Add-On
	 *
	 * @since    1.0.0
	 */
	public function save_prevnext_posts() {
		// Verify that the incoming request is coming with the security nonce
		if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax_rev_slider_addon_prevnext_posts_nonce' ) ) {
			if(isset($_REQUEST['rel_post_form'])){
				update_option( "rev_slider_addon_prevnext_posts", $_REQUEST['rel_post_form'] );
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
	 * Adds new Tab header to the layer meta selection
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_prev_meta_tabs($args){
		//only for specific posts
		if($args['slider_type']!="gallery") return false;
		
		//insert meta tab header
		echo str_replace(
		    array("INSERT_TAB_SLUG","INSERT_ICON_CLASS","INSERT_TAB_NAME"),
		    array("prevpost", "revicon-doc",__("Previous Post",'rev_addon_prevnext_posts') ),
		    $args["dummy"]
		);
	}

	/**
	 * Adds new Tab header to the layer meta selection
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_next_meta_tabs($args){
		//only for specific posts
		if($args['slider_type']!="gallery") return false;
		
		//insert meta tab header
		echo str_replace(
		    array("INSERT_TAB_SLUG","INSERT_ICON_CLASS","INSERT_TAB_NAME"),
		    array("nextpost", "revicon-doc",__("Next Post",'rev_addon_prevnext_posts') ),
		    $args["dummy"]
		);
	}

	/**
	 * Adds new meta table to the new tabs headers
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_prev_meta_tab_content($args){
		//only for specific posts
		if($args['slider_type']!="gallery") return false;

		//build meta table
		echo str_replace("INSERT_TAB_SLUG", 'prevpost', $args["tab_head"]);
		$rows = array(
			array("slug"=>"prev_title","name"=>__("Post Title",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_excerpt","name"=>__("Post Excerpt",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_content","name"=>__("Post content",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_content:words:10","name"=>__("Post content limit by words",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_content:chars:10","name"=>__("Post content limit by chars",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_link","name"=>__("The link to the post",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_date","name"=>__("Date created",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_date_modified","name"=>__("Date modified",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_author_name","name"=>__("Author name",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_num_comments","name"=>__("Number of comments",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_catlist","name"=>__("List of categories with links",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_catlist_raw","name"=>__("List of categories without links",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_taglist","name"=>__("List of tags with links",'rev_addon_prevnext_posts') ),
			array("slug"=>"prev_id","name"=>__("Post ID",'rev_addon_prevnext_posts') ),
		);

		$avail_image_sizes = get_intermediate_image_sizes();
		array_unshift($avail_image_sizes, "full");
		foreach ($avail_image_sizes as $size) {
			$rows[]=array("slug"=>"prev_image_".$size."_url","name"=>__("Featured Image ".ucwords(str_replace("_"," ",$size))." URL",'rev_addon_prevnext_posts') );
			$rows[]=array("slug"=>"prev_image_".$size."_html","name"=>__("Featured Image ".ucwords(str_replace("_"," ",$size))." HTML",'rev_addon_prevnext_posts') );
		}
		    
		foreach($rows as $row)
			echo str_replace(
			    array("INSERT_META_SLUG","INSERT_META_NAME"),
			    array($row['slug'], $row['name'] ),
			    $args["tab_row"]
			);
		echo $args["tab_foot"];
	}

	/**
	 * Adds new meta table to the new tabs headers
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_next_meta_tab_content($args){
		//only for specific posts
		if($args['slider_type']!="gallery") return false;

		//build meta table
		echo str_replace("INSERT_TAB_SLUG", 'nextpost', $args["tab_head"]);
		$rows = array(
			array("slug"=>"next_title","name"=>__("Post Title",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_excerpt","name"=>__("Post Excerpt",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_content","name"=>__("Post content",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_content:words:10","name"=>__("Post content limit by words",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_content:chars:10","name"=>__("Post content limit by chars",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_link","name"=>__("The link to the post",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_date","name"=>__("Date created",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_date_modified","name"=>__("Date modified",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_author_name","name"=>__("Author name",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_num_comments","name"=>__("Number of comments",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_catlist","name"=>__("List of categories with links",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_catlist_raw","name"=>__("List of categories without links",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_taglist","name"=>__("List of tags with links",'rev_addon_prevnext_posts') ),
			array("slug"=>"next_id","name"=>__("Post ID",'rev_addon_prevnext_posts') ),
		);

		$avail_image_sizes = get_intermediate_image_sizes();
		array_unshift($avail_image_sizes, "full");
		foreach ($avail_image_sizes as $size) {
			$rows[]=array("slug"=>"next_image_".$size."_url","name"=>__("Featured Image ".ucwords(str_replace("_"," ",$size))." URL",'rev_addon_prevnext_posts') );
			$rows[]=array("slug"=>"next_image_".$size."_html","name"=>__("Featured Image ".ucwords(str_replace("_"," ",$size))." HTML",'rev_addon_prevnext_posts') );
		}
		    
		foreach($rows as $row)
			echo str_replace(
			    array("INSERT_META_SLUG","INSERT_META_NAME"),
			    array($row['slug'], $row['name'] ),
			    $args["tab_row"]
			);
		echo $args["tab_foot"];
	}


}
