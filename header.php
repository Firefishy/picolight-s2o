<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title><?php
		global $page, $paged;

		wp_title( '|', true, 'right' );

		bloginfo( 'name' );

		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'picolight' ), max( $paged, $page ) );

		?></title>

	<?php global $picolight_options;
	$picolight_settings = get_option( 'picolight_options', $picolight_options ); ?>		

	<?php if( $picolight_settings['custom_favicon'] ) { ?>
		<link rel="shortcut icon" href="<?php echo $picolight_settings['custom_favicon']; ?>" title="Favicon" />
	<?php } ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper">
	<div id="header">
		<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<p class="description"><?php bloginfo('description'); ?></p>
		<img id="headerimage" src="<?php header_image(); ?>" alt="" />
		<div id="mainnav">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		</div>
	</div>
	<div id="main">
