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
 * Template Name: Pera-logue
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
		<main id="main" class="site-main full-module-blog-inside" role="main">
			
			<?php $args = array(
				'cat' => '95',
				'post_type' => 'post',
				'posts_per_page' => 1
			);
			
			query_posts($args); ?>
			
			<h3 class="uppercase"><div class="float-left"><a href="/category/specials/">Special Offers</a></div><div style="position:relative; top:10px; font-size:20px; text-shadow:initial;" class="float-right"><a href="/category/specials/">View All</a></div></h3>
			
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
				
				<?php //pera_soho_paging_nav(); ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			
			<?php wp_reset_query(); ?>
			
			
			<?php $args = array(
				'cat' => '94',
				'post_type' => 'post',
				'posts_per_page' => 1
			);
			
			query_posts($args); ?>
			
			<h3 class="uppercase"><div class="float-left"><a href="/category/news/">Blog</a></div><div style="position:relative; top:10px; font-size:20px; text-shadow:initial;" class="float-right"><a href="/category/news/">View All</a></div></h3>
			
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
				
				<?php //pera_soho_paging_nav(); ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			
			<?php wp_reset_query(); ?>
			
		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php include("contact.php"); ?>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside-bottom">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
