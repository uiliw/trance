<?php
// Creating the widget 
class upc_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'upc_widget', 
		
		// Widget name will appear in UI
		__('Completeness Points Widget', 'userpro-completeness'), 
		
		// Widget description
		array( 'description' => __( 'User Profile Completeness Points', 'userpro-completeness' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		$userpro_completeness_save_field = get_option('userpro_completeness_save_field');
		
		?>
		<div class="completeness-percentage">
		<?php 
			$remaining_progressbar_color=userpro_completeness_get_option('progress_bar');
			if(!isset($remaining_progressbar_color))$remaining_progressbar_color="default";
			$userpro_completeness_api = new userpro_completeness_api();
			$current_percentage = $userpro_completeness_api->get_completeness_usermeta_info(get_current_user_id());
			?>
			<label style="font-weight: bold;"><?php echo "Profile : ".$current_percentage."% Completed";?></label>
			<div id="remainingprogressBar" class="jquery-ui-like"><div class="<?php echo $remaining_progressbar_color;?>"></div><span style="position: absolute;"></span></div><br>
			<script>
					completeness_progressBar('<?php echo $current_percentage;?>' , jQuery('#remainingprogressBar'));
			</script>
			<?php
			if(!empty($userpro_completeness_save_field)){
				foreach($userpro_completeness_save_field as $k => $v){
					$user_meta_val = get_user_meta(get_current_user_id(),$k,true);
					if(empty($user_meta_val)){?>
						<label class="upc-field-key"><?php echo $v['displayName']; ?> : </label><label class="upc-field-value" style="font-weight: bold;"><?php echo $v['percentage']; ?>%</label><br>
					<?php }
				}
			}?>
		</div>
		<?php 
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Remaining Completeness Points', 'userpro-completeness' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class upc_widget ends here

// Register and load the widget
function upc_load_widget() {
	$userpro_completeness_api = new userpro_completeness_api();
	$current_percentage = $userpro_completeness_api->get_completeness_usermeta_info(get_current_user_id());
	
	if(is_user_logged_in() && $current_percentage != 100)
		register_widget( 'upc_widget' );
}
add_action( 'widgets_init', 'upc_load_widget' );