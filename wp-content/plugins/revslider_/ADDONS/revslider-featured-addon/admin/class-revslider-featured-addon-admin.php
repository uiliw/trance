<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Revslider_Featured_Addon
 * @subpackage Revslider_Featured_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Revslider_Featured_Addon
 * @subpackage Revslider_Featured_Addon/admin
 * @author     ThemePunch <info@themepunch.com>
 */
class Revslider_Featured_Addon_Admin {

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

	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Revslider_featured_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Revslider_featured_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$current_screen = get_current_screen();
		if(isset($current_screen->post_type) && $current_screen->post_type=="post"){ 
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/revslider-featured-addon-admin.css', array(), $this->version, 'all' );
		}
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_style('edit_layers', plugin_dir_url( __FILE__ ) .'../../revslider/admin/assets/css/edit_layers.css', array(), RevSliderGlobals::SLIDER_REVISION);
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
		 * defined in Revslider_featured_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Revslider_featured_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/revslider-featured-addon-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'revslider_featured_addon', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			));
			wp_enqueue_script('rev_admin', plugin_dir_url( __FILE__ ) .'../../revslider/admin/assets/js/rev_admin.js', array(), RevSliderGlobals::SLIDER_REVISION );
			wp_enqueue_script('unite_settings', plugin_dir_url( __FILE__ ) .'../../revslider/admin/assets/js/settings.js', array(), RevSliderGlobals::SLIDER_REVISION );
			wp_enqueue_script('tipsy', plugin_dir_url( __FILE__ ) .'../../revslider/admin/assets/js/jquery.tipsy.js', array(), RevSliderGlobals::SLIDER_REVISION );
		} else {
			global $pagenow;
			$screen = get_current_screen();
			
			if( in_array( $pagenow , array("post-new.php","post.php") ) && $screen->post_type == "post" )
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/revslider-featured-addon-page-post-admin.js', array( 'jquery' ), $this->version, false );	
		}
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'partials/revslider-featured-addon-admin-display.php' );
	}

	/**
	 * Saves Values for this Add-On
	 *
	 * @since    1.0.0
	 */
	public function save_featured() {
		// Verify that the incoming request is coming with the security nonce
		if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax_revslider_featured_addon_nonce' ) ) {
			if(isset($_REQUEST['revslider_featured_form'])){
				update_option( "revslider_featured_addon", $_REQUEST['revslider_featured_form'] );
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
	 * Adds metabox for selecting slider
	 *
	 * @since    1.0.0
	 */
	function featured_slider_add_metabox () {
		add_meta_box( 'featuredsliderdiv', __( 'Featured Slider Revolution', 'text-domain' ), array($this,'featured_slider_metabox'), 'post', 'side', 'low');
	}

	function featured_slider_metabox ( $post ) {
		global $content_width;
		$revslider_id = get_post_meta( $post->ID, 'revslider_featured_slider_id', true );
		$old_content_width = $content_width;
		
		$content_width = 254;

		// Available Sliders
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSliders();

  		$slider_select_options = "";
		foreach($arrSliders as $sliderony){
			$slider_id = $sliderony->getId();
			$slides = $sliderony->getFirstSlideIdFromGallery();
			$isFromPosts = $sliderony->isSlidesFromPosts();
			$isFromStream = $sliderony->isSlidesFromStream();
			if(!empty($slides)){
				$first_slide_id = $slides[key($slides)]->getID();
				$slider_type = 'gallery';
				$preicon = "revicon-picture-1";
				$strSource = __("Gallery",'revslider');
				$numSlides = $sliderony->getNumSlidesRaw();
				$numReal = $sliderony->getNumRealSlides();

				$slider_type = 'gallery';
				if($isFromPosts == true){
					$strSource = __('Posts','revslider');
					$preicon ="revicon-doc";
					$rowClass = "class='row_alt'";
					$numReal = $sliderony->getNumRealSlides();
					$slider_type = 'posts';
					//check if we are woocommerce
					if($sliderony->getParam("source_type","gallery") == 'woocommerce'){
						$strSource = __('WooCommerce','revslider');
						$preicon ="revicon-doc";
						$rowClass = "class='row_alt'";
						$slider_type = 'woocommerce';
					}
				}elseif($isFromStream !== false){
					$strSource = __('Social','revslider');
					$preicon ="revicon-doc";
					$rowClass = "class='row_alt'";
					switch($isFromStream){
						case 'facebook':
							$strSource = __('Facebook','revslider');
							$preicon ="eg-icon-facebook";
							$numReal = $sliderony->getNumRealSlides(false, 'facebook');
							$slider_type = 'facebook';
						break;
						case 'twitter':
							$strSource = __('Twitter','revslider');
							$preicon ="eg-icon-twitter";
							$numReal = $sliderony->getNumRealSlides(false, 'twitter');
							$slider_type = 'twitter';
						break;
						case 'instagram':
							$strSource = __('Instagram','revslider');
							$preicon ="eg-icon-info";
							$numReal = $sliderony->getNumRealSlides(false, 'instagram');
							$slider_type = 'instagram';
						break;
						case 'flickr':
							$strSource = __('Flickr','revslider');
							$preicon ="eg-icon-flickr";
							$numReal = $sliderony->getNumRealSlides(false, 'flickr');
							$slider_type = 'flickr';
						break;
						case 'youtube':
							$strSource = __('YouTube','revslider');
							$preicon ="eg-icon-youtube";
							$numReal = $sliderony->getNumRealSlides(false, 'youtube');
							$slider_type = 'youtube';
						break;
						case 'vimeo':
							$strSource = __('Vimeo','revslider');
							$preicon ="eg-icon-vimeo";
							$numReal = $sliderony->getNumRealSlides(false, 'vimeo');
							$slider_type = 'vimeo';
						break;
						
					}
				}
				$first_slide_image_thumb = $slides[key($slides)]->get_image_attributes($slider_type);

				if(intval($numSlides) == 0){
					$first_slide_id = 'new&slider='.$id;
				}else{
					$slides = $sliderony->getFirstSlideIdFromGallery();
					
					if(!empty($slides)){
						$first_slide_id = $slides[key($slides)]->getID();
						//$first_slide_id = ($isFromPosts == true) ? $slides[key($slides)]->templateID : $slides[key($slides)]->getID();
						
						$first_slide_image_thumb = $slides[key($slides)]->get_image_attributes($slider_type);
					}else{
						$first_slide_id = 'new&slider='.$id;
					}
				}


			}

			$editSlidesLink = $numSlides;
			$numReal="";

			//$slides_number = $numSlides;
			$slider_select_options .= '<option value="'.$slider_id.'" data-firstslide="'.$first_slide_id.'" data-class="'.$first_slide_image_thumb['class'].'" data-style="'.$first_slide_image_thumb['style'].'" data-image="'.$first_slide_image_thumb['url'].'" '.selected( $revslider_id, $slider_id , 0 ).' data-slides="'.$editSlidesLink.'" data-source="'.$strSource.'">'. $sliderony->getTitle() . '</option>';
		} 
			
					
		?>
		<ul class="featured-list_sliders">
			<li class="featured-slider-slide featured-slider-stype-all featured-slider-stype-<?php echo $slider_type; ?>">
				<div class="featured-slider-main-metas">
					<span class="featured-slider-firstslideimage" id="preview_featured_slider"></span>
					<span  class="featured-slider-grad-bg featured-slider-bg-top"></span>				
					<span class="featured-slider-source"><?php echo "<i class=".$preicon."></i><span class=featured-slider-source>".$strSource; ?></span></span>
					<span class="featured-slider-star"><a target="_new" id="featured_slider_edit_link" href="<?php echo $editSlidesLink; ?>" class="rev-toogle-fav" id="reg-toggle-id-<?php echo $slider_id; ?>"><span class="featured-slider-star dashicons dashicons-edit"></span></a></span>
					<span class="featured-slider-slidenr"><?php echo $numSlides; if($numReal !== '') echo ' ('.$numReal.')'; ?></span>
				</div>
				<span class="featured-slider-title-wrapper">
					<select id="revslider_featured_slider_id" name="revslider_featured_slider_id" class="featured-slider-title">
						<option value=""><?php _e("No Featured Slider Revolution","revslider-featured-addon"); ?></option>
				      	<?php echo $slider_select_options; ?>
					</select>
				</span>
			</li>
		</ul>
		<p class="hide-if-no-js howto" id="set-post-thumbnail-desc"><?php _e('Select/Edit featured Slider Revolution','revslider-featured-addon'); ?></p>
		<p class="hide-if-no-js" ><a href="admin.php?page=rev_addon" target="_new" id="featured-slider-set-options"><?php _e('Set AddOn options','revslider-featured-addon'); ?></a></p>
		<?php
	}

	function featured_slider_save ( $post_id ) {
		if( isset( $_POST['revslider_featured_slider_id'] ) ) {
			$slider_id =  (int) $_POST['revslider_featured_slider_id'] ;
			update_post_meta( $post_id, 'revslider_featured_slider_id', $slider_id );
		}
	}

}
