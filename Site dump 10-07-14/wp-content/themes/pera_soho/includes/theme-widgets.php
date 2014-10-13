<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Load the widgets, with support for overriding the widget via a child theme.
/*-----------------------------------------------------------------------------------*/

$widgets = array(
				'includes/widgets/widget-woo-adspace.php', 
				'includes/widgets/widget-woo-blogauthor.php', 
				'includes/widgets/widget-woo-embed.php', 
				'includes/widgets/widget-woo-flickr.php', 
				'includes/widgets/widget-woo-search.php', 
				'includes/widgets/widget-woo-subscribe.php', 
				'includes/widgets/widget-woo-tabs.php', 
				'includes/widgets/widget-woo-twitter.php', 
				'includes/widgets/widget-woo-feedback.php', 
				'includes/widgets/widget-woo-component.php'
				);

// Allow child themes/plugins to add widgets to be loaded.
$widgets = apply_filters( 'woo_widgets', $widgets );
				
foreach ( $widgets as $w ) {
	locate_template( $w, true );
}

/*---------------------------------------------------------------------------------*/
/* Deregister Default Widgets */
/*---------------------------------------------------------------------------------*/

if (!function_exists('woo_deregister_widgets')) {

	function woo_deregister_widgets(){

	    unregister_widget('WP_Widget_Search');

        unregister_widget('WP_Nav_Menu_Widget');

	}

}

add_action('widgets_init', 'woo_deregister_widgets');  

class Woo_Custom_Menu extends WP_Widget {

    function __construct() {

        $widget_ops = array( 'description' => __('Use this widget to add one of your custom menus as a widget.') );

        parent::__construct( 'nav_menu', __('Woo Custom Menu'), $widget_ops );

    }



    function widget($args, $instance) {

        // Get menu

        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;



        if ( !$nav_menu )

            return;



        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );



        echo $args['before_widget'];



        if ( !empty($instance['title']) )

            echo $args['before_title'] . $instance['title'] . $args['after_title'];



        wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu , 'walker' => new Woo_Navigation()) );



        echo $args['after_widget'];

    }



    function update( $new_instance, $old_instance ) {

        $instance['title'] = strip_tags( stripslashes($new_instance['title']) );

        $instance['nav_menu'] = (int) $new_instance['nav_menu'];

        return $instance;

    }



    function form( $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : '';

        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';



        // Get menus

        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );



        // If no menus exists, direct the user to go and create some.

        if ( !$menus ) {

            echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';

            return;

        }

        ?>

        <p>

            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>

            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />

        </p>

        <p>

            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>

            <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">

        <?php

            foreach ( $menus as $menu ) {

                echo '<option value="' . $menu->term_id . '"'

                    . selected( $nav_menu, $menu->term_id, false )

                    . '>'. $menu->name . '</option>';

            }

        ?>

            </select>

        </p>

        <?php

    }

} 



register_widget( 'Woo_Custom_Menu' );
?>