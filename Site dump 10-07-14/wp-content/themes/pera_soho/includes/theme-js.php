<?php
/*-----------------------------------------------------------------------------------*/
/* Theme Frontend JavaScript */
/*-----------------------------------------------------------------------------------*/


if ( ! is_admin() ) { add_action( 'wp_enqueue_scripts', 'woothemes_enqueue_javascript' ); }

if ( ! function_exists( 'woothemes_enqueue_javascript' ) ) {
	function woothemes_enqueue_javascript() {
		wp_enqueue_script( 'migrate', 'http://code.jquery.com/jquery-migrate-1.1.0.js', array( 'jquery' ) );
		//wp_enqueue_script( 'third-party', get_template_directory_uri() . '/includes/js/third-party.js', array( 'jquery' ) );
		//wp_register_script( 'widgetSlider', get_template_directory_uri() . '/includes/js/slides.min.jquery.js', array( 'jquery' ) );
		//wp_register_script( 'flexslider', get_template_directory_uri() . '/includes/js/jquery.flexslider.min.js', array( 'jquery' ) );
		//wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/includes/js/jquery.prettyPhoto.js', array( 'jquery' ) );
		//wp_register_script( 'jCarousel', get_template_directory_uri() . '/includes/js/jquery.jcarousel.min.js', array( 'jquery' ) );
		//wp_enqueue_script( 'nineSlice', get_template_directory_uri() . '/includes/js/jquery.scale9grid-0.9.3.min.js', array( 'jquery' ) );

		//wp_enqueue_script( 'easing', get_template_directory_uri() . '/includes/js/vendor/jquery.easing.1.3.js');
		//wp_enqueue_script( 'superfish', get_template_directory_uri() . '/includes/js/vendor/superfish.js');
		//wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/includes/js/vendor/hoverIntent.js');
		//wp_enqueue_script( 'tweenmax', get_template_directory_uri() . '/includes/js/vendor/_dependent/greensock/TweenMax.min.js');
		//wp_enqueue_script( 'iscrol', get_template_directory_uri() . '/includes/js/vendor/_mobile/iscroll.js');
		//wp_enqueue_script( 'scrollmagic', get_template_directory_uri() . '/includes/js/vendor/jquery.scrollmagic.min.js');
		//wp_enqueue_script( 'scrollmagicdebug', get_template_directory_uri() . '/includes/js/vendor/jquery.scrollmagic.debug.js');
		
		//wp_enqueue_script( 'general', get_template_directory_uri() . '/includes/js/general.js', array( 'jquery', 'third-party' ) );
		//wp_enqueue_script( 'special', get_template_directory_uri() . '/includes/js/special.js');
		wp_enqueue_script( 'main', get_template_directory_uri() . '/includes/js/main.js');
	}
}

if ( ! is_admin() ) { add_action( 'wp_print_scripts', 'woothemes_print_javascript' ); }

if ( ! function_exists( 'woothemes_print_javascript' ) ) {
	function woothemes_print_javascript() {  
		do_action( 'woothemes_print_javascript' );
		$data = array( 'select_a_page' => __( 'Select a page:', 'woothemes' ), 'site_url' => site_url() );
		//wp_localize_script( 'general', 'woo_localized_data', $data );
		wp_localize_script( 'main', 'woo_localized_data', $data );
	} // End woothemes_print_javascript()
}



/*-----------------------------------------------------------------------------------*/
/* Theme Frontend CSS */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) { add_action( 'wp_print_styles', 'woothemes_add_css' ); }

if ( ! function_exists( 'woothemes_add_css' ) ) {
	function woothemes_add_css() {
		global $woo_options; 
		wp_register_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' );
		wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/includes/css/prettyPhoto.css' );
		wp_register_style( 'non-responsive', get_template_directory_uri() . '/css/non-responsive.css' );
		
		do_action( 'woothemes_add_css' );
	} // End woothemes_add_css()
}

/*-----------------------------------------------------------------------------------*/
/* Theme Admin JavaScript */
/*-----------------------------------------------------------------------------------*/

if ( is_admin() ) { add_action( 'admin_print_scripts', 'woothemes_add_admin_javascript' ); }
if ( is_admin() ) { add_action( 'wp_print_scripts', 'woothemes_add_admin_css' ); }

if ( ! function_exists( 'woothemes_add_admin_javascript' ) ) {
	function woothemes_add_admin_javascript() {
		global $pagenow;
		
		if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && ( get_post_type() == 'page' ) ) {
			wp_enqueue_script( 'woo-postmeta-options-custom-toggle', get_template_directory_uri() . '/includes/js/meta-options-custom-toggle.js', array( 'jquery' ), '1.0.0' );
		}
		
	} // End woothemes_add_admin_javascript()
}

if ( ! function_exists( 'woothemes_add_admin_css' ) ) {
	function woothemes_add_admin_css() {
		wp_enqueue_style( 'theme_admin_css', get_template_directory_uri() . '/includes/css/theme-admin.css' );
	} // End woothemes_add_admin_css()
}
?>