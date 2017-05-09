<?php
/*
Plugin Name: User profile Completeness Add-on for UserPro
Plugin URI: http://codecanyon.net/user/DeluxeThemes/portfolio?ref=DeluxeThemes
Description: Allow users to see progress of profile completion.
Version: 1.5
Author: Deluxe Themes
Author URI: http://codecanyon.net/user/DeluxeThemes/portfolio?ref=DeluxeThemes
*/
?>
<?php
if(!defined('ABSPATH')) {exit;}

if(!defined("abc")) define("abc",'1');
if(!class_exists('UPC_userPro_completeness') ) :

class UPC_userPro_completeness {
	
	private static $_instance;
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
		$this->define_constant();
		$this->includes();
		if(class_exists('userpro_api') ) 
			$userpro = new userpro_api();	
		if(! isset($userpro)){
			add_action('admin_notices',array($this , 'UPC_userpro_activation_notices'));
			return 0;
		}
		else
		{	
			add_action('wp_enqueue_scripts', array($this , 'load_styles') , 999);
			add_action('wp_enqueue_scripts', array($this,'load_assets') , 999);
			add_action('admin_enqueue_scripts', array($this , 'admin_load_styles') , 999);
			add_action('admin_enqueue_scripts', array($this,'admin_load_assets') , 999);

			add_action('wp_head',array($this,'pluginname_ajaxurl'));
		}
		
	}
	
	public function includes() {	
		require_once(UPC_PLUGIN_DIR.'/functions/api.php');
		require_once(UPC_PLUGIN_DIR.'/functions/userprocheck.php');
		require_once(UPC_PLUGIN_DIR.'/functions/hooks-actions.php');
		require_once(UPC_PLUGIN_DIR.'/functions/defaults.php');
		require_once(UPC_PLUGIN_DIR.'/admin/admin.php');		
		require_once(UPC_PLUGIN_DIR.'/functions/template_redirect.php');
		require_once(UPC_PLUGIN_DIR.'/functions/shortcode.php');
		require_once(UPC_PLUGIN_DIR.'/widgets/widget-completeness_points.php');
	}
	
	function pluginname_ajaxurl() {
		?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
	<?php
	}
	
	public function admin_load_styles(){
		wp_register_style('completeness_css', UPC_PLUGIN_URL.'assets/completeness.css');
		wp_enqueue_style('completeness_css');
	}
	
	public function admin_load_assets(){
		wp_register_script('completeness_js', UPC_PLUGIN_URL.'assets/completeness.js');
		wp_enqueue_script('completeness_js');
	}

	public function load_styles(){
		wp_register_style('completeness_progressbar_css', UPC_PLUGIN_URL.'assets/completeness_progressbar.css');
		wp_enqueue_style('completeness_progressbar_css');
	}
	
	public function load_assets(){
		wp_register_script('completeness_progressbar_js', UPC_PLUGIN_URL.'assets/completeness_progressbar.js');
		wp_enqueue_script('completeness_progressbar_js');
	}
	
	public function define_constant(){
		
		if( !defined( 'USERPRO_PLUGIN_URL' ) ) define('USERPRO_PLUGIN_URL',WP_PLUGIN_URL.'/userpro/');
		if( !defined( 'USERPRO_PLUGIN_DIR' ) ) define('USERPRO_PLUGIN_DIR',WP_PLUGIN_DIR.'/userpro/');
		
		define('UPC_PLUGIN_URL',plugin_dir_url(__FILE__ ));
		define('UPC_PLUGIN_DIR',plugin_dir_path(__FILE__ ));
			
	}
	
	function UPC_userpro_activation_notices(){
		echo '<div class="error" role="alert"><p>Attention: User-Pro user profile Completeness requires User-Pro to be installed and activated.</p></div>';
		deactivate_plugins( plugin_basename( __FILE__ ) );
		return 0;
	}

}
endif;


function userpro_completeness_plugin_first() {
	// ensure path to this file is via main wp plugin path
	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
	$active_plugins = get_option('active_plugins');
	$this_plugin_key = array_search($this_plugin, $active_plugins);
	if (in_array($this_plugin, $active_plugins)) { 
		unset($active_plugins[$this_plugin_key]);
		array_push($active_plugins , $this_plugin);

		update_option('active_plugins', $active_plugins);
	}
}

function userpro_completeness_init() {
	load_plugin_textdomain('userpro-completeness', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('init', 'userpro_completeness_init');

add_action("activated_plugin", "userpro_completeness_plugin_first");

$UPC = UPC_userPro_completeness::instance();



register_activation_hook(UPC_PLUGIN_DIR.'/user-pro_completeness.php', 'UPC_activate_plugin');
function UPC_activate_plugin(){
	global $userpro;
	$UPC = UPC_userPro_completeness::instance();
	if(isset($userpro)){
		
	}else{
		add_action('admin_notices',array($UPC , 'UPC_userpro_activation_notices'));
		return 0;
	}
}

require_once(dirname(__FILE__)."/admin/userpro-completeness-updates.php");
new WPUpdatesPluginUpdater_1462( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));
?>
