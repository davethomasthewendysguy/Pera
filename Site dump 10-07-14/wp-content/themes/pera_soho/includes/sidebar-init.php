<?php
// Register widgetized areas
if ( ! function_exists( 'the_widgets_init' ) ) {
	function the_widgets_init() {
	    if ( ! function_exists( 'register_sidebars' ) )
	        return;

		// Widgetized sidebars
		register_sidebar( array( 'name' => __( 'Left Top Header', 'woothemes' ), 'id' => 'left-top-header', 'description' => __( 'The Left Top Header sidebar for your website', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget widget-on-primary %2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
		register_sidebar( array( 'name' => __( 'Right Top Header', 'woothemes' ), 'id' => 'right-top-header', 'description' => __( 'The Right Top Header sidebar for your website', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget widget-on-primary %2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
	    register_sidebar( array( 'name' => __( 'Primary', 'woothemes' ), 'id' => 'primary', 'description' => __( 'The default primary sidebar for your website, used in two or three-column layouts.', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget widget-on-primary %2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
	    register_sidebar( array( 'name' => __( 'Secondary', 'woothemes' ), 'id' => 'secondary', 'description' => __( 'A secondary sidebar for your website, used in three-column layouts.', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget widget-on-secondary %2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );

		// Footer widgetized areas
		$total = get_option( 'woo_footer_sidebars', 3 );
		if ( ! $total ) $total = 3;
		for ( $i = 1; $i <= intval( $total ); $i++ ) {
			register_sidebar( array( 'name' => sprintf( __( 'Footer %d', 'woothemes' ), $i ), 'id' => sprintf( 'footer-%d', $i ), 'description' => sprintf( __( 'Widgetized Footer Region %d.', 'woothemes' ), $i ), 'before_widget' => '<div id="%1$s" class="widget widget-on-footer %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
		}

		register_sidebar( array( 'name' => __( 'Footer Twitter', 'woothemes' ), 'id' => 'twitter-footer', 'description' => __( 'Widgetized area above the footer for the Twitter Bar.', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="%2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
		register_sidebar( array( 'name' => __( 'Above Footer', 'woothemes' ), 'id' => 'above-footer', 'description' => __( 'Widgetized area above the footer.', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="%2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
		register_sidebar( array( 'name' => __( 'Bottom Widget', 'woothemes' ), 'id' => 'bottom-widget', 'description' => __( 'Widgetized area below the footer.', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget-on-homepage %2$s">', 'after_widget' => '</div><div class="fix"></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
	} // End the_widgets_init()
}

add_action( 'init', 'the_widgets_init' );
?>