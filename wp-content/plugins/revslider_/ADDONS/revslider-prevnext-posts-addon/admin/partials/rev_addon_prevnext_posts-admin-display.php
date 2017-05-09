<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Rev_addon_prevnext_posts
 * @subpackage Rev_addon_prevnext_posts/admin/partials
 */

	$rev_slider_addon_values = array();
	parse_str(get_option('rev_slider_addon_prevnext_posts'), $rev_slider_addon_values);


	// Available Sliders
	$slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	$defSlider = "";
	
	$rel_sliders = get_option( "rev_slider_addon_prevnext_posts");
	parse_str($rel_sliders, $rel_sliders_array);

	// Available Post Types
	$args = array(
		   'public'   => true,
		   '_builtin' => false
		);

	$output = 'objects'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'

	$post_types = get_post_types( $args, $output, $operator ); 
	$post_types_slugs = array("post");
?>

<div id="rev_addon_prevnext_posts_settings_slideout" class="rs-sbs-slideout-wrapper" style="display:none">
	<div class="rs-sbs-header">
		<div class="rs-sbs-step"><i class="eg-icon-cog"></i></div>
		<div class="rs-sbs-title"><?php _e('Adjacent Posts', 'rev_addon_prevnext_posts'); ?></div>
		<div class="rs-sbs-close"><i class="eg-icon-cancel"></i></div>
	</div>
	<div class="rs-submenu-wrapper">
		<ul class="rs-submenu-tabs-source rs-submenu-tabs" style="display:inline-block; ">		
			<li id="source_based_settings_li" class="selected" data-content="#subcat-source-post"><?php _e('Posts', 'rev_addon_prevnext_posts'); ?></li>					
			<?php // types will be a list of the post type names
			$post_types_labels[0] = __('Posts', 'rev_addon_prevnext_posts');
        	foreach ( $post_types  as $post_type ) {
        		$post_types_slugs[] = $post_type->rewrite["slug"];
        		$post_types_labels[] = $post_type->labels->name;
			?>
				<li data-content="#subcat-source-<?php echo $post_type->rewrite["slug"]; ?>"><?php echo $post_type->labels->name; ?></li>
			<?php 
			} 

			?>
		</ul>
	</div>
	<div class="tp-clearfix"></div>
	<div class="rs-sbs-slideout-inner">

	<!-- Start Settings -->
	<form id="rs-addon-prevnext_post-form">
		<div class=" rs-dash-widget-registered">
			<?php // types will be a list of the post type names
				$post_type_counter = 0;
	        	foreach ( $post_types_slugs  as $post_type_slug ) {
	        		$post_type_label = $post_types_labels[$post_type_counter++];
	        		$rev_addon_prevnext_posts_display = $post_type_slug == 'post' ? 'display: block' : 'display:none';
				?>
					<div id="subcat-source-<?php echo $post_type_slug; ?>" class="subcat-wrapper" style="<?php echo $rev_addon_prevnext_posts_display;?>">				
						
						<?php 

				      		$rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy-only'] = isset($rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy-only']) ? $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy-only'] : '0';

					      	if($post_type_slug == "post"){
					      		$category_headline = __("Category","revslider-prevnext-addon");
					      		$category_substring = __('Only display posts from current post\'s category','revslider-prevnext-addon');
					      		$category_text = __("Category only","revslider-prevnext-addon");	
					      	}
					      	else {
					      		$category_headline = $post_type_label ." - " . __("Taxonomy (Category)","revslider-prevnext-addon");
					      		$category_substring = __('Only display posts from current post\'s taxonomy','revslider-prevnext-addon');
					      		$category_text = __("Taxonomy only","revslider-prevnext-addon");		
					      	}

				      	?>


						<div class="rs-dash-content-with-icon">
							<div class="rs-dash-strong-content"><?php echo $category_headline; ?></div>
							<div><?php echo $category_substring; ?></div>				
						</div>
					    <div class="rs-dash-content-space"></div>
					    <input type="checkbox" class="rs-addon-prevnext-taxonomy-check" name="<?php echo 'rs-addon-prevnext-'.$post_type_slug.'-taxonomy-only';?>" value="<?php echo $post_type_slug; ?>" data-type="<?php echo $post_type_slug; ?>" <?php checked( $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy-only'], $post_type_slug , 1 ); ?>> <?php echo $category_text; ?>

				      	<div class="rs-addon-prevnext-taxonomy-detail" id="rs-addon-prevnext-<?php echo $post_type_slug; ?>-details">
					      	<div class="rs-dash-content-space"></div>
					      	<div style="clear:both;" class="rs-dash-content-with-icon">
								<div class="rs-dash-strong-content"><?php _e("Taxonomy","revslider-prevnext-addon"); ?></div>
								<div><?php _e('Display only posts from same taxonomy','rev_addon_prevnext_posts'); ?></div>				
							</div>
					      	<div class="rs-dash-content-space"></div>
					      	<select name="rs-addon-prevnext-<?php echo $post_type_slug; ?>-taxonomy">
								<?php 
									$taxonomy_objects = get_object_taxonomies( $post_type_slug , 'objects' );
									$rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy'] = isset($rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy']) ? $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy'] : '';
									foreach ($taxonomy_objects as $taxonomy_object_key => $taxonomy_object) { ?>
										<?php if($taxonomy_object_key!="post_tag"){?><option value="<?php echo $taxonomy_object_key; ?>" <?php selected( $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-taxonomy'], $taxonomy_object_key, 1 ); ?> ><?php echo $taxonomy_object->labels->name; ?></option><?php } 
									} 
								?>
						    </select>
						</div>

						<div class="rs-dash-content-space"></div>

						<div class="rs-dash-strong-content"><?php _e("Automatically add Slider","rev_addon_prevnext_posts"); ?></div>
						<div><?php _e('Select a Slider of the <strong>"Default slider" type</strong>:','rev_addon_prevnext_posts'); ?></div>				
						<div class="rs-dash-content-space"></div>
						
						<?php 	
							$slider_select_options = "";
							foreach($arrSliders as $sliderony){
								if( $sliderony->getParam('source_type')=="gallery" ){
									$rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-slider'] = isset($rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-slider']) ? $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-slider'] : '';
									$slider_select_options .= '<option value="'.$sliderony->getAlias().'" '.selected( $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-slider'], $sliderony->getAlias(), 0 ).'>'. $sliderony->getTitle() . '</option>';
								}
							} 
						?>

						<select name="rs-addon-prevnext-<?php echo $post_type_slug; ?>-slider" class="rs-addon-prevnext-slider-switch rs-addon-prevnext-<?php echo $post_type_slug; ?>-slider" data-type="<?php echo $post_type_slug; ?>">
						 	<option value=""><?php _e('- Do not add a slider -','rev_addon_prevnext_posts'); ?></option>
						 	<?php
								echo $slider_select_options;
					        ?>
				      	</select>
						
						<?php if ($slider_select_options==""){
							echo "<br><br><div>";
							_e('There is no Slider of the <strong>"Default Slider" type</strong> available.','rev_addon_prevnext_posts');
							echo "</div>";
						}  ?>
						<div class="rs-addon-prevnext-slider-position">
							<div style="clear:both;" class="rs-dash-content-space"></div>
							<div class="rs-dash-content-with-icon">
								<div class="rs-dash-strong-content"><?php _e("Slider Position","rev_addon_prevnext_posts"); ?></div>
								<div><?php _e('Display the automatic slider above or below the normal post content','rev_addon_prevnext_posts'); ?></div>				
							</div>
							<div class="rs-dash-content-space"></div>
							<select name="rs-addon-prevnext-<?php echo $post_type_slug; ?>-position" class="rs-addon-prevnext-<?php echo $post_type_slug; ?>-position">
								<?php $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-position'] = empty($rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-position']) ? 'bottom' : $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-position']; ?>
								<option value="top" <?php selected( $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-position'], 'top', 1 ) ?> ><?php _e('Above'); ?> </option>
							 	<option value="bottom" <?php selected( $rev_slider_addon_values['rs-addon-prevnext-'.$post_type_slug.'-position'], 'bottom', 1 ) ?> ><?php _e('Below'); ?> </option>
					      	</select>
					    </div>
				    </div>
				      	
				<?php 
				} // end foreach
			?>
			<div class="rs-dash-content-space"></div>
		</div>
		<span id="ajax_rev_slider_addon_prevnext_posts_nonce" class="hidden"><?php echo wp_create_nonce( 'ajax_rev_slider_addon_prevnext_posts_nonce' ) ?></span>
		<div class="rs-dash-bottom-wrapper">
			<span style="display:none" id="rs_addon-prevnext_posts-wait" class="loader_round">Please Wait...</span>					
			<a href="javascript:void(0);" id="rs-addon-prevnext_posts-save" class="rs-dash-button">Save</a>
		</div>		
	</form>
<!-- End Settings -->

</div>	</div>