<?php

function woo_header_inside_top() { woo_do_atomic( 'woo_header_inside_top' ); }
function woo_header_inside_bottom() { woo_do_atomic( 'woo_header_inside_bottom' ); }

add_filter('title_before', 'title_before_filter', 10, 1);
if ( ! function_exists( 'title_before_filter' ) ) {
	function title_before_filter($val) {
		global $post;

		$title_before = get_post_meta($post->ID, '_page_title_before', false);

		if ( '' != $title_before[0] )
			return $title_before[0];

		return $val;
	}
}

add_filter('title_after', 'title_after_filter', 10, 1);
if ( ! function_exists( 'title_after_filter' ) ) {
	function title_after_filter($val) {
		global $post;

		$title_after = get_post_meta($post->ID, '_page_title_after', false);

		if ( '' != $title_after[0] )
			return $title_after[0];

		return $val;
	}
}

add_filter( 'body_class','woo_page_specific_body_class', 10 );	
if ( !function_exists('woo_page_specific_body_class') ) {
function woo_page_specific_body_class( $classes ) {
	global $post;

	$page_options = get_post_meta($post->ID, '', false);

	if ( ! is_array( $page_options ) )
		return $classes;

	if ( 0 != $post->post_parent ) {
		$parent_page_options = get_post_meta($post->post_parent , '', false);

		if ( array_key_exists('_page_additioanal_classes', $parent_page_options)  ) {
			if ('' != $parent_page_options['_page_additioanal_classes'][0] ) {
				$classes[] = trim( implode(' ', array_unique( explode(' ', $parent_page_options['_page_additioanal_classes'][0] ) ) ) );
			}
		}
	}

	if ( array_key_exists('_page_additioanal_classes', $page_options)  ) {
		if ('' != $page_options['_page_additioanal_classes'][0] ) {
			$classes[] = trim( implode(' ', array_unique( explode(' ', $page_options['_page_additioanal_classes'][0] ) ) ) );
		}
	}

	return $classes;
}
}