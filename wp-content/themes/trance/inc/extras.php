<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package understrap
 */

if ( ! function_exists( 'understrap_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function understrap_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'understrap_body_classes' );

// Removes tag class from the body_class array to avoid Bootstrap markup styling issues.
add_filter( 'body_class', 'adjust_body_class' );

if ( ! function_exists( 'adjust_body_class' ) ) {
	/**
	 * Setup body classes.
	 *
	 * @param string $classes CSS classes.
	 *
	 * @return mixed
	 */
	function adjust_body_class( $classes ) {

		foreach ( $classes as $key => $value ) {
			if ( 'tag' == $value ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;

	}
}

// Filter custom logo with correct classes.
add_filter( 'get_custom_logo', 'change_logo_class' );

if ( ! function_exists( 'change_logo_class' ) ) {
	/**
	 * Replaces logo CSS class.
	 *
	 * @param string $html Markup.
	 *
	 * @return mixed
	 */
	function change_logo_class( $html ) {

		$html = str_replace( 'class="custom-logo"', 'class="img-responsive"', $html );
		$html = str_replace( 'class="custom-logo-link"', 'class="navbar-brand custom-logo-link"', $html );
		$html = str_replace( 'alt=""', 'title="Home" alt="logo"' , $html );

		return $html;
	}
}

/**
 * Display navigation to next/previous post when applicable.
 */
if ( ! function_exists( 'understrap_post_nav' ) ) :

	function understrap_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>

		<div class="row">
			<div class="col-md-12">
				<nav class="navigation post-navigation">
					<h2 class="sr-only"><?php _e( 'Post navigation', 'trance' ); ?></h2>
					<div class="nav-links">
						<?php

							if ( get_previous_post_link() ) {
								previous_post_link( '<span class="nav-previous float-xs-left">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'trance' ) );
							}
							if ( get_next_post_link() ) {
								next_post_link( '<span class="nav-next float-xs-right">%link</span>',     _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'trance' ) );
							}
						?>
					</div><!-- .nav-links -->
				</nav><!-- .navigation -->
			</div>
		</div>
		<?php
	}
endif;


add_filter( 'wp_generate_attachment_metadata', 'retina_support_attachment_meta', 10, 2 );
function retina_support_attachment_meta( $metadata, $attachment_id ) {
	foreach ( $metadata as $key => $value ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $image => $attr ) {
				if ( is_array( $attr ) )
					retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
			}
		}
	}
	return $metadata;
}

function retina_support_create_images( $file, $width, $height, $crop = false ) {
	if ( $width || $height ) {
		$resized_file = wp_get_image_editor( $file );
		if ( ! is_wp_error( $resized_file ) ) {
			$filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );

			$resized_file->resize( $width * 2, $height * 2, $crop );
			$resized_file->save( $filename );

			$info = $resized_file->get_size();

			return array(
				'file' => wp_basename( $filename ),
				'width' => $info['width'],
				'height' => $info['height'],
			);
		}
	}
	return false;
}

add_filter( 'delete_attachment', 'delete_retina_support_images' );
function delete_retina_support_images( $attachment_id ) {
	$meta = wp_get_attachment_metadata( $attachment_id );
	$upload_dir = wp_upload_dir();
	$path = pathinfo( $meta['file'] );
	foreach ( $meta as $key => $value ) {
		if ( 'sizes' === $key ) {
			foreach ( $value as $sizes => $size ) {
				$original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
				$retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
				if ( file_exists( $retina_filename ) )
					unlink( $retina_filename );
			}
		}
	}
}