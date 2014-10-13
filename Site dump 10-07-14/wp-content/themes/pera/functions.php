<?php
/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

function woo_output_alt_stylesheet() {}
function woo_shortcode_stylesheet() {}
function woo_output_custom_css() {}
function woo_custom_styling() {}
function woo_enqueue_custom_styling() {};

// Set path to WooFramework and theme specific functions
$functions_path = get_template_directory() . '/functions/';
$includes_path = get_template_directory() . '/includes/';

// WooFramework
require_once ( $functions_path . 'admin-init.php' );            // Framework Init

if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {
    //Enable Tumblog Functionality and theme is upgraded
    update_option( 'woo_needs_tumblog_upgrade', 'false' );
    update_option( 'tumblog_woo_tumblog_upgraded', 'true' );
    update_option( 'tumblog_woo_tumblog_upgraded_posts_done', 'true' );
    require_once ( $functions_path . 'admin-tumblog-quickpress.php' );  // Tumblog Dashboard Functionality
}

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

class Woo_Navigation extends Walker_Nav_Menu {

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';



        $class_names = $value = '';



        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $classes[] = 'wtf menu-item-' . $item->ID;



        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';



        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );

        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';



        $output .= $indent . '<li' . $id . $value . $class_names .'>';



        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';

        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';

        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $attributes .= ! empty( $item->custom )        ? ' onclick="'   . $item->custom .'"' : '';



        $item_output = $args->before;

        $item_output .= '<a'. $attributes .'>';

        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        $item_output .= '</a>';

        $item_output .= $args->after;



        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }


    function end_el( &$output, $item, $depth = 0, $args = array() ) {

        $output .= "</li>\n";

    }

}

$includes = array(
                'includes/theme-admin-setup.php',           // Options panel settings and custom settings
                'includes/theme-admin-hooks.php',           // Options panel settings and custom settings
                'includes/theme-options.php',           // Options panel settings and custom settings
                'includes/theme-functions.php',         // Custom theme functions
                'includes/theme-actions.php',           // Theme actions & user defined hooks
  //              'includes/theme-comments.php',          // Custom comments/pingback loop
                'includes/theme-js.php',                // Load JavaScript via wp_enqueue_script
                'includes/sidebar-init.php',            // Initialize widgetized areas
                'includes/theme-advanced-menus.php',            // Theme widgets
                'includes/theme-widgets.php'          // Theme widgets
                );

// Theme-Specific
$includes[] = 'includes/theme-advanced.php';            // Advanced Theme Functions
$includes[] = 'includes/theme-shortcodes.php';          // Custom theme shortcodes
// Modules
//$includes[] = 'includes/woo-layout/woo-layout.php';
//$includes[] = 'includes/woo-meta/woo-meta.php';
//$includes[] = 'includes/woo-hooks/woo-hooks.php';

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );

foreach ( $includes as $i ) {
    locate_template( $i, true );
}

// Load WooCommerce functions, if applicable.
if ( is_woocommerce_activated() ) {
    locate_template( 'includes/theme-woocommerce.php', true );
}

// WooTumblog Loader
if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {
define( 'WOOTUMBLOG_ACTIVE', true ); // Define a constant for use in our theme's templating engine.
require_once ( $includes_path . 'tumblog/theme-tumblog.php' );      // Tumblog Output Functions
// Test for Post Formats
if ( get_option( 'woo_tumblog_content_method' ) == 'post_format' ) {
    require_once( $includes_path . 'tumblog/wootumblog_postformat.class.php' );
} else {
    require_once ($includes_path . 'tumblog/theme-custom-post-types.php' ); // Custom Post Types and Taxonomies
}

// Test for Post Formats
if ( get_option( 'woo_tumblog_content_method' ) == 'post_format' ) {
    global $woo_tumblog_post_format;
    $woo_tumblog_post_format = new WooTumblogPostFormat();
    if ( $woo_tumblog_post_format->woo_tumblog_upgrade_existing_taxonomy_posts_to_post_formats()) {
        update_option( 'woo_tumblog_post_formats_upgraded', 'true' );
    }
}
}

if ( ! is_admin() ) {
// Output stylesheet and custom.css after Canvas custom styling
remove_action( 'wp_head', 'woothemes_wp_head' );
add_action( 'woo_head', 'woothemes_wp_head' );
if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' && get_option( 'woo_custom_rss' ) == 'true' ) {
    add_filter( 'the_excerpt_rss', 'woo_custom_tumblog_rss_output' );
    add_filter( 'the_content_rss', 'woo_custom_tumblog_rss_output' );
}
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

function menu_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'menu' => null,
        'title' => null,
        'class' => ''
        ), $atts ) );
    $config = array(
        'menu' => $menu,
        'container' => false,
        'menu_class' => 'subpages menu-nav',
        'echo' => false,
        'walker' => new Woo_Navigation()
    );
    if($title != null) $output = '<h3 class="shortnav-title"><a href="javascript:void(0);">' . $title . '</a></h3>' ;
    return '<div class="shortnav ' . $class . '">' . $output . wp_nav_menu( $config ) . '</div>';
}
add_shortcode('page_menu', 'menu_shortcode');



function post_listing($atts){ extract( shortcode_atts( array(
        'post_type' => 'post',
        'posts_per_page' => '1',
        'trim' => 27,
        'class' => '',
        'title' => '',
        'pagination' => false,
        'list_only' => false,
        'post_status' => 'publish',
        'order' => 'DESC'
    ), $atts ) );

    $today = getdate();
    global $wp_query;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $date = '';
    if($list_only == true){
      $date = array(
                'year'  => $today["year"],
            'month' => $today["mon"],
            'day'   => $today["mday"] - 1
                );
    }
    $args = array(
    'posts_per_page'   => $posts_per_page,
    'offset'           => 0,
    'category'         => '',
    'orderby'          => 'post_date',
    'order'            => $order,
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => $post_type,
    'post_mime_type'   => '',
    'post_parent'      => '',
    'paged'            => $paged,
    'post_status'      => $post_status,
    'suppress_filters' => true,
    'date_query' => array(

        array(
            'after' => $date
            )
        )

     );

    $posts_array = get_posts( $args );

    $post_query = new WP_Query($args);

    $wp_query->max_num_pages = $post_query->max_num_pages;

    $output = '';
    $addedClass = '';
    $output .= '<div class="post-listing ' . $class . '">';
    if($title != null) $output .= '<h3 class="post-title">' . $title . '</h3>' ;

    foreach( $posts_array as $post ) {
        $addedClass = '';
        setup_postdata( $post );
        $output .= '<div class="post-container post-container' . $count . '">';
        $output .= '<div class="post-date">';



        $output .= custom_post_date($post->ID);


        $output .= '</div>';

        $post_link = ('post' == $post_type) ? get_post_permalink($post->ID, true) : get_permalink($post->ID);

        $output .= '<div class="post-content">';
         if(get_the_post_thumbnail($post->ID,'thumbnail' ) != null){
            $output .= '<a href="' . get_permalink($post->ID) . '" class="post-thumbnail">' . get_the_post_thumbnail($post->ID,'thumbnail') . '</a>';
         }
         if($list_only == false){


            $output .= '<h3 class="post-content-title">' .  '<a href="' . get_permalink($post->ID) . '">' . ((get_post_meta($post->ID, '_page_title_alias', 'true') == "") ? get_the_title($post->ID) : get_post_meta($post->ID, '_page_title_alias', 'true')) . '</a>' . '</h3>';

            if ( "" != get_post_meta($post->ID, '_yoast_wpseo_metadesc', 'true') ) {
                $output .= '<p class="post-description">' . get_post_meta($post->ID, '_yoast_wpseo_metadesc', 'true') . '</p>';
            } else if ( "" != $post->post_excerpt ) {
                $output .= '<p class="post-description">' . $post->post_excerpt . '</p>';
            } else {
                $output .= '<p class="post-description">' . substr(strip_tags(do_shortcode(get_the_content($post->ID))),0,200) . '...</p>';
            }

            $output .= '<a href="' . $post_link . '" class="read-more"><span>read more</span></a>';

         }
         else{
            $output .= '<h3 class="post-content-title">'  . get_the_title($post->ID)  . '</h3>';
            $output .= '<div class="post-description">' . get_the_content($post->ID) . '</div>';
         }
         $output .= '</div></div>';


    }



    if($pagination == true || $pagination == 'true'){
        $output .= woo_pagination(array("echo" => false,"show_all"=>true));
    }

    $output .=  '<div class="fix"></div>';
    $output .= '</div>';

    wp_reset_postdata();

    return $output;

}

add_shortcode( 'post_listing', 'post_listing' );



/*
 *Program Name : Custom Post Type
 */

/*
 * Creating a post type. End this comment to enable */
class thg_event_class{
    function thg_add_event(){
        $support_editors = array('title','thumbnail','editor','revisions');
        //$taxonomies = array('category','post_tag');
        $labels = array(
                        'name' => __('Event','thg'),
                        'singular_name' => __('Event','thg'),
                        'add_new' => __('Add New','thg'),
                        'add_new_item' => __('Add New Item to Event','thg'),
                        'edit' => __('Edit Event','thg'),
                        'edit_item' => __('Edit Event','thg'),
                        'new_item' => __('New Event item','thg'),
                        'view' => __('View Event','thg'),
                        'view_item' => __('View Event','thg'),
                        'search_item' => __('Search Items to Event','thg'),
                        'not_found' => __('No item found in Event','thg'),
                        'not_found_in_trash' => __('No Event item found in Trash','thg'),
                        'parent' => __('Parent Event','thg')
                        );

        $args = array(
                      'labels' => $labels,
                      'description' => __('Event custom post type.','thg'),
                      'show_ui' => true,
                      'exclude_from_search' =>false,
                      'supports' => $support_editors,
                      'public' => true,
                      'menu_icon' => get_template_directory_uri() . '/functions/images/option-icon-calendar.png',
                      'has_archive' => true,
                      'menu_position' => 5
                      );
        //Register artist post type
        register_post_type('event', $args);
    }

}
add_action('init',array('thg_event_class','thg_add_event'));


class thg_jazz_class{
    function thg_add_jazz(){
        $support_editors = array('title','editor');
        //$taxonomies = array('category','post_tag');
        $labels = array(
                        'name' => __('Jazz','thg'),
                        'singular_name' => __('Jazz','thg'),
                        'add_new' => __('Add New','thg'),
                        'add_new_item' => __('Add New Item to Jazz','thg'),
                        'edit' => __('Edit Jazz','thg'),
                        'edit_item' => __('Edit Jazz','thg'),
                        'new_item' => __('New Jazz item','thg'),
                        'view' => __('View Jazz','thg'),
                        'view_item' => __('View Jazz','thg'),
                        'search_item' => __('Search Items to Jazz','thg'),
                        'not_found' => __('No item found in Jazz','thg'),
                        'not_found_in_trash' => __('No Jazz item found in Trash','thg'),
                        'parent' => __('Parent Jazz','thg')
                        );

        $args = array(
                      'labels' => $labels,
                      'description' => __('Jazz custom post type.','thg'),
                      'show_ui' => true,
                      'exclude_from_search' =>false,
                      'supports' => $support_editors,
                      'public' => true,
                      'menu_icon' => get_template_directory_uri() . '/functions/images/option-icon-calendar.png',
                      'has_archive' => true,
                      'menu_position' => 5
                      );
        //Register artist post type
        register_post_type('jazz', $args);
    }

}
add_action('init',array('thg_jazz_class','thg_add_jazz'));


function custom_post_date($id = '') {

    $output = '';

    if( $id != null ) {

    	$event_date = get_post_meta($id, '_page_event_date', 'true');

    	if ( "" != $event_date ) {
    		$output = '<span class="day">' . date('d', strtotime($event_date)) . '</span><span class="month">' . date('M', strtotime($event_date)) . '</span><span class="year">' . date('Y', strtotime($event_date)) . '</span>' ;
    	} else {
 		    $output = '<span class="day">' . get_the_time('d',$id) . '</span><span class="month">' . get_the_time('M',$id) . '</span><span class="year">' . get_the_time('Y',$id) . '</span>' ;
    	}
    }

    return $output;
}
add_action('custom_post_date','custom_post_date');

function new_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

add_filter('the_content', 'remove_empty_p', 999);
function remove_empty_p($content){
    $content = force_balance_tags($content);
    return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)?(\s|&nbsp;)*</p>#', '', $content);
}

function gm_twitter_bar( $atts, $content = null ) {
    /*extract( shortcode_atts( array(
        'class' => 'caption',
    ), $atts ) );*/

    return '<span class="' . esc_attr($class) . '">' . $content . '</span>';
}
/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>