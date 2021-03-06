<?php
/**
 * Template Name: Landing Page
 *
 * @package WooFramework
 * @subpackage Template
 */

get_header('landing');
?>
       
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">

    	<div id="main-sidebar-container">

			<!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main">                     
			<?php
				woo_loop_before();
				
				if (have_posts()) { $count = 0;
					while (have_posts()) { the_post(); $count++;
						woo_get_template_part( 'content', 'page' ); // Get the page content template file, contextually.
					}
				}
				
				woo_loop_after();
			?>     
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
		
		</div><!-- /#main-sidebar-container -->

    </div><!-- /#content -->
	<?php woo_content_after(); ?>

<?php get_footer('landing'); ?>