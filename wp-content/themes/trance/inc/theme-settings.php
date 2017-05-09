<?php
/**
 * Check and setup theme's default settings
 *
 * @package trance
 *
 */
function setup_theme_default_settings() {

	// check if settings are set, if not set defaults.
	// Caution: DO NOT check existence using === always check with == .
	// Latest blog posts style.
	$trance_posts_index_style = get_theme_mod( 'trance_posts_index_style' );
	if ( '' == $trance_posts_index_style ) {
		set_theme_mod( 'trance_posts_index_style', 'default' );
	}

	// Sidebar position.
	$trance_sidebar_position = get_theme_mod( 'trance_sidebar_position' );
	if ( '' == $trance_sidebar_position ) {
		set_theme_mod( 'trance_sidebar_position', 'right' );
	}

	// Container width.
	$trance_container_type = get_theme_mod( 'trance_container_type' );
	if ( '' == $trance_container_type ) {
		set_theme_mod( 'trance_container_type', 'container' );
	}
}
