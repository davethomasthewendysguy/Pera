<?php
/**
 * pera_soho functions and definitions
 *
 * @package pera_soho
 */



@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'pera_soho_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pera_soho_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on pera_soho, use a find and replace
	 * to change 'pera_soho' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pera_soho', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'pera_soho' ),
		'secondary' => __( 'Secondary Menu (Not Homepage)', 'pera_soho' ),
		'food' => __( 'Food Menu', 'pera_soho' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'pera_soho_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
}
endif; // pera_soho_setup
add_action( 'after_setup_theme', 'pera_soho_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function pera_soho_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'pera_soho' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'pera_soho_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pera_soho_scripts() {
	wp_enqueue_style( 'pera_soho-style', get_stylesheet_uri() );

	//wp_enqueue_script( 'pera_soho-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'pera_soho-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_script( 'pera_custom', get_template_directory_uri() . '/js/pera.js', array(), '20141007', true );
	
	//wp_enqueue_script( 'tipr', get_template_directory_uri() . '/js/tipr.js', array(), '20140711', true );
	
	//wp_enqueue_script( 'tipr', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', array(), '20140711', true );
	
	if(is_front_page()) {
		wp_enqueue_script( 'supersized', get_template_directory_uri() . '/js/supersized.3.2.7.min.js', array(), '20140506', true );
	
		wp_enqueue_script( 'shutter_theme', get_template_directory_uri() . '/theme/supersized.shutter.min.js', array(), '20140506', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pera_soho_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';





/**
 * Add Post Thumbnail functionality
 */
add_theme_support( 'post-thumbnails' ); 


/**
 * Register `Specials` post type
 */
/*function special_post_type() {
   
   // Labels
	$labels = array(	
		'name' => _x("Special", "post type general name"),
		'singular_name' => _x("Special", "post type singular name"),
		'menu_name' => 'Specials',
		'add_new' => _x("Add New", "special item"),
		'add_new_item' => __("Add New Special"),
		'edit_item' => __("Edit Special"),
		'new_item' => __("New Special"),
		'view_item' => __("View Special"),
		'search_items' => __("Search Specials"),
		'not_found' =>  __("No Profiles Found"),
		'not_found_in_trash' => __("No Specials Found in Trash"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('specials', array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/specials-icon.png',
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail')
	) );
}
add_action( 'init', 'special_post_type', 0 );*/


/**
 * Register `Specials` post type
 */
function events_post_type() {
   
   // Labels
	$labels = array(	
		'name' => _x("Event Rooms", "post type general name"),
		'singular_name' => _x("Event Rooms", "post type singular name"),
		'menu_name' => 'Event Rooms',
		'add_new' => _x("Add New", "event item"),
		'add_new_item' => __("Add New Event Room"),
		'edit_item' => __("Edit Event Room"),
		'new_item' => __("New Event Room"),
		'view_item' => __("View Event Room"),
		'search_items' => __("Search Event Rooms"),
		'not_found' =>  __("No Profiles Found"),
		'not_found_in_trash' => __("No Events Found in Trash"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('events', array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/events-icon.png',
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail')
	) );
}
add_action( 'init', 'events_post_type', 0 );


/**
 * Adds a box to the main column on the Event Rooms edit screens.
 */
function myplugin_add_meta_box() {

	$screens = array( 'events' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'myplugin_sectionid',
			__( 'Slider ID', 'myplugin_textdomain' ),
			'myplugin_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );

/**
 * Adds a box to the main column on the Event Rooms edit screens.
 */
function myplugin_add_meta_box2() {

	$screens = array( 'events' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'myplugin_page_position',
			__( 'Page Position', 'myplugin_textdomain' ),
			'myplugin_meta_box_callback2',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box2' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_meta_box_callback($post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'rev_slider_id', true );

	echo '<label for="rev_slider_id">';
	_e( 'Enter the proper ID (number from the Rev Slider page)', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="rev_slider_id" name="rev_slider_id" value="' . esc_attr( $value ) . '" size="25" />';
}

function myplugin_meta_box_callback2($post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box2', 'myplugin_meta_box_nonce2' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'page_position', true );

	echo '<label for="page_position">';
	_e( 'Enter the page position', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="page_position" name="page_position" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, its safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['rev_slider_id'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['rev_slider_id'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'rev_slider_id', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data2( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce2'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce2'], 'myplugin_meta_box2' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, its safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['page_position'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['page_position'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'page_position', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data2' );

/**
 * Limit excerpts to 30 words
 */
function custom_excerpt_length($length) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more($more) {
    global $post;
	return '<br /><a class="moretag" href="'. get_permalink($post->ID) . '">Read more...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');