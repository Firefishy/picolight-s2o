<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script type='text/javascript' src='/wp-includes/js/jquery/jquery.js'></script>
<script type='text/javascript' src='<?php echo get_template_directory_uri();?>/js/jquery.cycle.lite.js'></script>
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

<body onload="$('#headerimage').cycle({fx: 'fade', speed: 1000, timeout: 7000});" <?php body_class(); ?>>
<div id="wrapper">
	<div id="header">
		<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<p class="description"><?php bloginfo('description'); ?></p>
	         <div id="headerimage">
                <div id="div-rich-data"><div class="info">
                        <h2>Rich data</h2>
                        <p>OpenStreetMap data is rich and detailed, containing huge amounts
                        of data which is relevant to people on the ground - the people who
                        collected it.</p>
                        <p>Features include:</p>
                        <ul>
                                <li>Roads, railways, waterways, etc...</li>
                                <li>Restaurants, shops, stations, ATMs and more.</li>
                                <li>Walking and cycling paths.</li>
                                <li>Buildings, campuses, etc...</li>
                        </ul>
                </div></div>
                <div id="div-up-to-date"><div class="info">
                        <h2>Up to date</h2>
                        <p>OpenStreetMap is updated every minute of every hour of every day,
                        and these updates are available to you in real-time.</p>
                        <p>Our fantastic community is making OpenStreetMap better right now. If there are
                        features you need - you can add them and see them live within minutes.</p>
                </div></div>
                <div id="div-tune-xp"><div class="info">
                        <h2>Tune your experience</h2>
                        <p>Why does your map have to look the same as every other one on the
                        internet?</p>
                        <p>With OpenStreetMap data you can create your own map, showing
                        the features that <em>you</em> want to show, the features which are
                        important to <em>your</em> users.</p>
                </div></div>
                <div id="div-global"><div class="info">
                        <h2>Global data</h2>
                        <p>OpenStreetMap data covers the whole world, making it easy to
                        support users in any country, or every country.</p>
                        <p>With localised and translated names, you can see maps in the
                        language you want to see them in.</p>
                </div></div>
                <div id="div-no-license-fee"><div class="info">
                        <h2>No licensing fee</h2>
                        <p>OpenStreetMap data is free and open - there is no subscription
                        fee and no page-view fee.</p>
                        <p>With OpenStreetMap data, your only obligations are to attribute
                        and share-alike, as explained in our license.</p>
                </div></div>
        </div>

<!--		<img id="headerimage" src="<?php header_image(); ?>" alt="" /> -->
		<div id="mainnav">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		</div>
	</div>
	<div id="main">
