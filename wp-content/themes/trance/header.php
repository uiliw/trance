<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package trance
 */

$container = get_theme_mod( 'trance_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="search-overlay"></div>
<div class="hfeed site" id="page">
<div class="background-header">
	<!-- ******************* The Navbar Area ******************* -->
	<div class="wrapper-top-navbar d-flex align-items-center " id="wrapper-top-navbar">
		<ul class="mr-auto">
			<li><a href="#" title="<?php echo __( 'Portuguese','trance' ) ?>"><img src="<?php echo get_template_directory_uri()?>/img/flag-brazil.png" alt="<?php echo __( 'Portuguese','trance' ) ?>" data-rjs="2"> </a> </li>
			<li><a href="#" title="<?php echo __( 'English','trance' ) ?>"><img src="<?php echo get_template_directory_uri()?>/img/flag-usa.png" alt="<?php echo __( 'English','trance' ) ?>" data-rjs="2"> </a> </li>
			<li><a href="#" title="<?php echo __( 'Spanish','trance' ) ?>"><img src="<?php echo get_template_directory_uri()?>/img/flag-spain.png" alt="<?php echo __( 'Spanish','trance' ) ?>" data-rjs="2"> </a> </li>
		</ul>
		<ul class="ml-auto">
			<li>
				<div class="search">
					<div class="search__bg"></div>
					<div class="search__box">
						<input type="text" class="search__input" placeholder="Search"/>
						<div class="search__line"></div>
						<div class="search__close"></div>
					</div>
				</div>
			</li>
			<li class="social"><a href="#" class="btn-face" title="<?php echo __( 'Facebook Oficial','trance' ) ?>"><i class="fa fa-facebook"></i> </a> </li>
			<li class="social"><a href="#" class="btn-insta" title="<?php echo __( 'Instagram Oficial','trance' ) ?>"><i class="fa fa-instagram"></i> </a> </li>

		</ul>

	</div>
	<!-- ******************* The Navbar Area ******************* -->
	<div class="wrapper-fluid wrapper-navbar" id="wrapper-navbar">

		<a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content',
		'trance' ); ?></a>

		<nav class="navbar navbar-toggleable-md navbar-scroll">

		<?php if ( 'container' == $container ) : ?>
<!--			<div class="container">-->
		<?php endif; ?>

				<button class="navbar-toggler pull-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

					<!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>

						<?php if ( is_front_page() && is_home() ) : ?>

							<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>

						<?php else : ?>

							<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>

						<?php endif; ?>


					<?php } else {
						the_custom_logo();
					} ?><!-- end custom logo -->

				<!-- The WordPress Menu goes here -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'collapse navbar-collapse align-items-end flex-column',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav mt-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'walker'          => new WP_Bootstrap_Navwalker(),
					)
				); ?>
			<div class="dropdown profile">
				<?php
				if ( is_user_logged_in() ) { ?>
					<div class="rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php
						$current_user_id=get_current_user_id();
						$name = userpro_profile_data('first_name', $current_user_id);
						echo get_avatar( $current_user_id, '32', '', $name, array( 'width' => 32, 'height' => 32 ,'class' => array( 'rounded-circle' ) ) );
						?>
					</div>


					<div class="dropdown-menu dropdown-menu-right animation slideUpIn" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>">Dashboard</a>
						<a class="dropdown-item" href="<?php echo wp_logout_url( home_url() ); ?>">Sair</a>
					</div>
				<?php } else { ?>


					<i class="fa fa-user-circle-o fa-2x" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

					<div class="dropdown-menu dropdown-menu-right animation slideUpIn" aria-labelledby="dropdownMenuButton">
						<span class="dropdown-item"><a class="popup-login" href="#">Login</a></span>
						<span class="dropdown-item"><a class="popup-register" href="#">Registrar</a></span>
					</div>
				<?php } ?>


			</div>
			<?php if ( 'container' == $container ) : ?>
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- .wrapper-navbar end -->
</div>