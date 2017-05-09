<?php

////////////////////////////////////////////////////////////////////////
// User Pro Profile URL Integration ////////////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_profile_url', 'wpdiscuz_up_profile_url', 10, 2);
function wpdiscuz_up_profile_url($profile_url, $user) {
    if ($user && class_exists('userpro_api')) {
        global $userpro; $profile_url = $userpro->permalink($user->ID);
    }
    return $profile_url;
}

////////////////////////////////////////////////////////////////////////
// User Pro Badges Integration ////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_after_label', 'wpdiscuz_up_after_label_html', 110, 2);
function wpdiscuz_up_after_label_html($afterLabelHtml, $comment) {
    if ($comment->user_id && class_exists('userpro_api')) {
        $afterLabelHtml .= userpro_show_badges($comment->user_id, $inline = true);
    }
    return $afterLabelHtml;
}




/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load functions to secure your WP install.
 */
require get_template_directory() . '/inc/security.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';
