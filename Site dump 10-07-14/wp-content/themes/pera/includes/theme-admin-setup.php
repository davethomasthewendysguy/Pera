<?php

add_action('wp_head', 'woo_output_theme_css_includes');

if ( ! function_exists( 'woo_output_theme_css_includes' ) ) {
	/**
	 * Output the HTML for the Font Awesome file.
	 * @since  2.0.0
	 * @return void
	 */
	function woo_output_theme_css_includes() {
		
		
	} // End woo_output_custom_css()
}

add_action('wp_head', 'woo_output_theme_modernizr');

if ( ! function_exists( 'woo_output_theme_modernizr' ) ) {
	/**
	 * Output the HTML for the Modernizr file.
	 * @since  2.0.0
	 * @return void
	 */
	function woo_output_theme_modernizr() {
		echo "\n" . '<!-- Modernizr -->' . "\n" . '<script type="text/javascript" src="' . get_template_directory_uri() . '/includes/js/modernizr.js"></script>' . "\n";
	} // End woo_output_custom_css()
}