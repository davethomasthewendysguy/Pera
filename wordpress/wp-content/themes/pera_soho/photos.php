<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Template Name: Photos layout
 * @package pera_soho
 */

$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";

get_header(); ?>

<div id="below-fold">
	<div id="events-container" class="full-module white-background live-menu"><!--BRUNCH MENU-->
		<div class="full-module-inside">
			<h3 class="uppercase center"><?php the_title(); ?></h3>
			
			<!--<p class="center">Vel hac eu integer mattis natoque et? Elementum, aenean sed, proin augue ultrices dolor facilisis massa? Phasellus sed, magna a sagittis! Cum augue arcu elementum platea tincidunt facilisis et enim, vut est pellentesque nisi, vut? Ridiculus augue parturient dis elementum. Aliquam, mattis habitasse vut porta ultricies, quis turpis, diam.</p>-->
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	
	<div class="full-module white-background">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'photo-page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<?php include("contact.php"); ?>
</div>

<?php get_footer(); ?>
