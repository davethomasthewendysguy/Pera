<?php
/**
 * Template Name: Home
 *
 * The blog page template displays the "blog-style" template on a sub-page. 
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;
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
            
             <h2 class="title"><a href="">Blog</a></h2><hr>   

			<?php get_template_part( 'loop', 'blog' ); ?>
                    
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
		</div><!-- /#main-sidebar-container -->             

    </div><!-- /#content -->
	<?php woo_content_after(); ?>
		
<?php get_footer(); ?>