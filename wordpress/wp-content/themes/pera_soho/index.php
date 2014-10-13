<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pera_soho
 */
 
$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";

get_header(); ?>

<div id="below-fold">
	<div id="posts-container" class="full-module white-background"><!--BRUNCH MENU-->
		<div class="full-module-inside no-padding-bottom">
			<h1 class="uppercase center entry-title">Pera-Logue</h1>
		</div>
	</div>

	<div id="primary" class="content-area full-module white-background">
		<main id="main" class="site-main full-module-inside" role="main">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<div class="blog-container">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						?>

					<?php endwhile; ?>
				</div>
				
				<?php get_sidebar(); ?>
				
				<?php pera_soho_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>
				
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php include("contact.php"); ?>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside-bottom">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
				
				<img src="<?php echo $bloginfo ;?>filigre-bottom.png" alt="Filigre border" />
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
