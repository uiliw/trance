<?php

class userpro_completeness_admin {

	var $options;

	function __construct() {
	
		/* Plugin slug and version */
		$this->slug = 'userpro';
		$this->subslug = 'userpro-completeness';
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->plugin_data = get_plugin_data( UPC_PLUGIN_DIR . '/user-pro_completeness.php', false, false);
		$this->version = $this->plugin_data['Version'];
		
		/* Priority actions */
		add_action('userpro_admin_menu_hook', array(&$this, 'add_menu'), 9);
		add_action('admin_init', array(&$this, 'admin_init'), 10);
		
	}
	
	function admin_init() {
	
		$this->tabs = array(
			'settings' => __('User Completeness','userpro-completeness'),
			'field-setup'=>__('Field Setup','userpro-completeness'),
			'completeness_licensing'=>__('Licensing','userpro-completeness')
		);
		$this->default_tab = 'settings';
		
		$this->options = get_option('userpro_completeness');
		if (!get_option('userpro_completeness')) {
			update_option('userpro_completeness', userpro_completeness_default_options() );
		}
		
	}
		
	function add_menu() {
		add_submenu_page( 'userpro', __('Profile Completeness','userpro-completeness'), __('Profile Completeness','userpro-completeness'), 'manage_options', 'userpro-completeness', array(&$this, 'admin_page') );
	}

	function admin_tabs( $current = null ) {
			$tabs = $this->tabs;
			$links = array();
			if ( isset ( $_GET['tab'] ) ) {
				$current = $_GET['tab'];
			} else {
				$current = $this->default_tab;
			}
			foreach( $tabs as $tab => $name ) :
				if ( $tab == $current ) :
					$links[] = "<a class='nav-tab nav-tab-active' href='?page=".$this->subslug."&tab=$tab'>$name</a>";
				else :
					$links[] = "<a class='nav-tab' href='?page=".$this->subslug."&tab=$tab'>$name</a>";
				endif;
			endforeach;
			foreach ( $links as $link )
				echo $link;
	}

	function get_tab_content() {

		$screen = get_current_screen();
		if( strstr($screen->id, $this->subslug ) ) {
			if ( isset ( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
			} else {
				$tab = $this->default_tab;
			}
			require_once UPC_PLUGIN_DIR.'admin/panels/'.$tab.'.php';
		}
	}
	
	function save() {
	
		$this->options['userpro_threshold_percentage'] = '';
		
		/* other post fields */
		foreach($_POST as $key => $value) {
			if ($key != 'submit') {
				if (!is_array($_POST[$key])) {
					$this->options[$key] = esc_attr($_POST[$key]);
				} else {
					$this->options[$key] = $_POST[$key];
				}
			}
		}
		
		update_option('userpro_completeness', $this->options);
		echo '<div class="updated"><p><strong>'.__('Settings saved.','userpro-fav').'</strong></p></div>';
	}

	function reset() {
		update_option('userpro_completeness', userpro_completeness_default_options() );
		$this->options = array_merge( $this->options, userpro_completeness_default_options() );
		echo '<div class="updated"><p><strong>'.__('Settings are reset to default.','userpro-fav').'</strong></p></div>';
	}

	function verify_completeness_license() {
		global $userpro;
		$this->options = get_option( 'userpro_completeness' );
		$code = $_POST['userpro_completeness_code'];
		$this->options['userpro_completeness_code'] = $code;
		if ($code == ''){
			echo '<div class="error"><p><strong>'.__('Please enter a purchase code.','userpro-completeness').'</strong></p></div>';
		} else {
			if ( $userpro->verify_purchase($code, '13z89fdcmr2ia646kphzg3bbz0jdpdja', 'DeluxeThemes', '14942712') ){
				echo '<div class="updated fade"><p><strong>'.__('Thanks for activating UserPro Completeness!','userpro-completeness').'</strong></p></div>';
			} else {
				echo '<div class="error"><p><strong>'.__('You have entered an invalid purchase code or the Envato API could be down at the moment.','userpro-completeness').'</strong></p></div>';
			}
		}
		update_option('userpro_completeness', $this->options);
	}

	function admin_page() {

		if (isset($_POST['submit'])) {
			$this->save();
		}

		if (isset($_POST['reset-options'])) {
			$this->reset();
		}
		
		if (isset($_POST['rebuild-pages'])) {
			$this->rebuild_pages();
		}
		if (isset($_POST['completeness_verify_button'])){
			$this->verify_completeness_license();
		}
		
	?>
	
		<div class="wrap <?php echo $this->slug; ?>-admin">
			
			<?php userpro_admin_bar(); ?>
			
			<h2 class="nav-tab-wrapper"><?php $this->admin_tabs(); ?></h2>

			<div class="<?php echo $this->slug; ?>-admin-contain">
				
				<?php $this->get_tab_content(); ?>
				
				<div class="clear"></div>
				
			</div>
			
		</div>

	<?php }

}
$userpro_completeness_admin = new  userpro_completeness_admin();
