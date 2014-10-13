<?php
/**
 * "Tumblog" Taxonomy Archive Template
 *
 * This template file is used when displaying an archive of posts in the
 * "tumblog" taxonomy. This is used with WooTumblog.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
 get_header();
?>
       
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
        
        <?php get_sidebar( 'alt' ); ?>    

    	<div id="main-sidebar-container">

            <?php get_sidebar(); ?> 
		
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main" class="col-left">
            	<?php get_template_part( 'loop', 'tumblog' ); ?>
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
		</div><!-- /#main-sidebar-container -->         

    </div><!-- /#content -->
	<?php woo_content_after(); ?>
	
<?php get_footer(); ?>
