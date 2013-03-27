<?php

add_action( 'after_setup_theme', 'picolight_setup' );

if ( ! function_exists( 'picolight_setup' ) ):

/**
 * Sets up theme defaults and registers support for various WordPress features.
*/
function picolight_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'picolight', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'picolight' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Thumbnails
	set_post_thumbnail_size( '150', '150', true );

	//Sidebars
	function picolight_sidebars(){
		register_sidebar(array(
			'name' => __('Sidebar', 'picolight'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}
	add_action('widgets_init', 'picolight_sidebars');

	define('HEADER_TEXTCOLOR', '');
	define('HEADER_IMAGE', '%s/images/headers/shore.jpg'); // %s is the template dir uri
	define('HEADER_IMAGE_WIDTH', 1050); // use width and height appropriate for your theme

	global $picolight_options;
	$picolight_settings = get_option( 'picolight_options', $picolight_options );

	if( $picolight_settings['custom_header_height'] ) { 
		$custom_header_height = $picolight_settings['custom_header_height'];
	}
	
	define('HEADER_IMAGE_HEIGHT', $custom_header_height);
	define('NO_HEADER_TEXT', true );

	add_custom_image_header('', 'picolight_admin_header_style');

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'chessboard' => array(
		'url' => '%s/images/headers/chessboard.jpg',
		'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Chessboard', 'picolight' )
		),
		'hanoi' => array(
		'url' => '%s/images/headers/hanoi.jpg',
		'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Hanoi', 'picolight' )
		),
		'lanterns' => array(
		'url' => '%s/images/headers/lanterns.jpg',
		'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Lanterns', 'picolight' )
		),
		'pine-core' => array(
		'url' => '%s/images/headers/pine-cone.jpg',
		'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Pine-cone', 'picolight' )
		),
		'shore' => array(
		'url' => '%s/images/headers/shore.jpg',
		'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Shore', 'picolight' )
		),
		'trolley' => array(
		'url' => '%s/images/headers/trolley.jpg',
		'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Trolley', 'picolight' )
		),
		'wheel' => array(
		'url' => '%s/images/headers/wheel.jpg',
		'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Wheel', 'picolight' )
		),
		'willow' => array(
		'url' => '%s/images/headers/willow.jpg',
		'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Willow', 'picolight' )
		)
	) );
}
endif;


if ( ! function_exists( 'picolight_admin_header_style' ) ) :

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 * Referenced via add_custom_image_header() in picolight_setup().
 */
 
function picolight_admin_header_style() {
?><style type="text/css">
        #headimg {
            width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
            height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
            background: no-repeat;
        }
   </style>
<?php
}
endif;

// content width
if (!isset($content_width)) {
	$content_width = 630;
}


// comments = all comments - pings
add_filter('get_comments_number', 'picolight_comment_count', 0);
function picolight_comment_count($count) {
        if ( ! is_admin() ) {
                global $id;
                $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
                return count($comments_by_type['comment']);
        } else {
                return $count;
        }
}

if ( ! function_exists( 'picolight_comment' ) ) :

function picolight_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'picolight' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'picolight' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="comment_gravatar">
			<?php
				$avatar_size = 60;
				echo get_avatar( $comment, $avatar_size );
			?>
		</div>
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author vcard">
				<?php
					/* translators: 1: comment author, 2: date and time */
					printf( __( '%1$s %2$s', 'picolight' ),
						sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
						sprintf( '<div class="comment-meta-date"><a href="%1$s"><span class="time">%3$s</span></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'picolight' ), get_comment_date(), get_comment_time() )
						)
					);
				?>

				<?php edit_comment_link( __( '(Edit)', 'picolight' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
			</div><!-- .comment-author .vcard -->

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'picolight' ); ?></em>
				<br />
			<?php endif; ?>
			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'picolight' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for picolight_comment()


if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );


// scripts
function picolight_scripts() {
	if (is_singular() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_script('respond', get_template_directory_uri().'/js/respond.min.js');
}
add_action('wp_enqueue_scripts', 'picolight_scripts');

// show categories
function picolight_show_categories() {
	$cats = get_the_category_list(', ');

	// show only, if there are any
	if ($cats != '') {
		echo ' &middot; ';
		_e('Categories: ', 'picolight');
		echo $cats;
	}
}

// show tags
function picolight_show_tags() {
	$tags = get_the_tag_list('', ', ');

	// show only, if there are any
	if ($tags != '') {
		echo ' &middot; ';
		_e('Tags: ', 'picolight');
		echo $tags;
	}
}

// extra theme settings
require_once (get_template_directory().'/includes/theme-options.php');

?>
