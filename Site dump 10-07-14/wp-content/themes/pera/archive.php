<?php
/**
 * Archive Template
 *
 * The archive template is a placeholder for archives that don't have a template file. 
 * Ideally, all archives would be handled by a more appropriate template according to the
 * current page context (for example, `tag.php` for a `post_tag` archive).
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;
 get_header();
?>      
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
        
        <?php get_sidebar( 'alt' ); ?>   

    	<div id="main-sidebar-container">    
		
            <!-- #main Starts -->
            <?php woo_main_before(); ?>

            <?php get_sidebar(); ?>
            
            <div id="main" class="col-left">
            	
			<?php get_template_part( 'loop', 'archive' ); ?>
                    
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
		</div><!-- /#main-sidebar-container -->   
    </div><!-- /#content -->
	<?php woo_content_after(); ?>
		
<?php get_footer(); ?>