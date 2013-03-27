<?php
/* picolight Theme Options */
 
function picolight_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'picolight-theme-options', get_template_directory_uri().'/includes/theme-options.css', false );
	wp_enqueue_script( 'picolight-theme-options', get_template_directory_uri().'/includes/theme-options.js', array( 'farbtastic' ) );
	wp_enqueue_style( 'farbtastic' );

	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('picolight-image-upload', get_template_directory_uri().'/includes/jquery-upload.js', array(
		'jquery',
		'media-upload',
		'thickbox'
	));
	wp_enqueue_script('picolight-image-upload');
	wp_enqueue_style('thickbox');

	wp_localize_script('picolight-image-upload', 'picolight_localizing_upload_js', array(
		'use_this_image' => __('Use This Image', 'picolight')
    ));
}

add_action( 'admin_enqueue_scripts', 'picolight_admin_enqueue_scripts' );
 
// Default options values
$picolight_options = array(
	'custom_color' => '#364D96',
	'custom_favicon' => '',
	'custom_header_height' => '288'
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function picolight_register_settings() {
	// Register the settings
	register_setting( 'picolight_theme_options', 'picolight_options', 'picolight_validate_options' );
}

add_action( 'admin_init', 'picolight_register_settings' );


function picolight_theme_options() {
	// Add theme options page to the addmin menu
	add_theme_page( __( 'Options', 'picolight'), __( 'Options', 'picolight'), 'edit_theme_options', 'theme_options', 'picolight_theme_options_page');
}

add_action( 'admin_menu', 'picolight_theme_options' );

// Function to generate options page
function picolight_theme_options_page() {
	global $picolight_options, $picolight_categories, $picolight_layouts;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php screen_icon(); echo '<h2>'.get_current_theme().' '.__( 'Options', 'picolight' ).'</h2>';
	// This shows the page's name and an icon if one has been provided ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved', 'picolight' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'picolight_options', $picolight_options ); ?>
	
	<?php settings_fields( 'picolight_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	<table class="form-table">

	<tr valign="top"><th scope="row"><label for="custom_color"><?php _e('Custom Link Color', 'picolight'); ?></label></th>
	<td>
	<input id="custom_color" name="picolight_options[custom_color]" type="text" value="<?php  esc_attr_e($settings['custom_color']); ?>" />
	<a href="#" class="pickcolor hide-if-no-js" id="custom_color-example"></a>
	<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e(_e( 'Select a Color', 'picolight' )); ?>">
	<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	<br />
	<small class="description"><?php _e('Default link color: #364D96', 'picolight'); ?></small>
	</td>
	</tr>

	<tr valign="top"><th scope="row"><label for="custom_favicon"><?php _e('Custom favicon', 'picolight'); ?></label></th>
	<td>
	<input id="upload-favicon" name="picolight_options[custom_favicon]" type="text" value="<?php  esc_attr_e($settings['custom_favicon']); ?>" />
	<input type="button" class="button hide-if-no-js" id="upload-favicon-button" value="<?php _e('Upload Image', 'picolight'); ?>" />
	<br />
	</td>
	</tr>

	<tr valign="top"><th scope="row"><label for="custom_header_height"><?php _e('Custom header height', 'picolight'); ?></label></th>
	<td>
	<input id="custom_header_height" name="picolight_options[custom_header_height]" type="text" value="<?php esc_attr_e($settings['custom_header_height']); ?>" />
	<br />
	<small class="description"><?php _e('Default header height: 288 px. After you changed this value you can', 'picolight'); ?> <a href="<?php echo home_url(); ?>/wp-admin/themes.php?page=custom-header" target="_blank"><?php _e('upload a new header image', 'picolight'); ?></a>.</small>
	</td>
	</tr>
	
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Options', 'picolight'); ?>" /></p>

	</form>

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="XY5N7E3URRC2C">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="">
	<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
	</form>

	</div>

	<?php
}

function picolight_validate_options( $input ) {
	global $picolight_options, $picolight_categories, $picolight_layouts;

	$settings = get_option( 'picolight_options', $picolight_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['custom_color'] = wp_filter_nohtml_kses($input['custom_color']);
	$input['custom_header_height'] = wp_filter_nohtml_kses($input['custom_header_height']);
	if ($input['custom_header_height'] == '' || $input['custom_header_height'] == '0') {
		$input['custom_header_height'] = '288';
	}
	$input['custom_favicon'] = esc_url_raw($input['custom_favicon']);
	
	return $input;
}

endif;  // EndIf is_admin()


// Custom CSS for Link Colors
function picolight_insert_custom_color(){
?>

<?php 
	global $picolight_options;
	$picolight_settings = get_option( 'picolight_options', $picolight_options );
?>
<?php if( $picolight_settings['custom_color'] != '' ) : ?>
<style type="text/css">
	a, #comments h3, h3#reply-title {color: <?php echo $picolight_settings['custom_color'] ; ?>;}
</style>
<?php endif; ?>
<?php
}

add_action('wp_head', 'picolight_insert_custom_color');
