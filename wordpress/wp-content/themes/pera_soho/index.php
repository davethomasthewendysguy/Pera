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
			<h1 class="uppercase center entry-title">Blog</h1>
		</div>
	</div>

	<div id="primary" class="content-area full-module white-background">
		<main id="main" class="site-main full-module-inside" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php pera_soho_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<div id="contact" class="full-module white-background"><!--CONTACT-->
		<div class="full-module-inside">
			<h3 class="uppercase center">Contact</h3>
			
			<div class="info-box">
				<img src="<?php echo $bloginfo ;?>filigre-top.png" alt="Filigre border" />
				
				<div class="equal-columns margin-large-top margin-medium-bottom">
					<h4 class="center uppercase">INQUIRIES</h4>

					<p class="center small-font">Private Events<br/ >
					<a href="mailto:events@pera-soho.com">events@pera-soho.com</a><br/ >
					<br/ >
					Job Opportunities<br/ >
					<a href="mailto:resumes@pera-soho.com">resumes@pera-soho.com</a><br/ >
					<br/ >
					General Inquiries & Feedback<br/ >
					<a href="mailto:hello@pera-soho.com">hello@pera-soho.com</a></p>
				</div>
				<div class="equal-columns">
					<img class="center" src="<?php echo $bloginfo ;?>logo.png" alt="Pera Soho" />
			
					<p class="margin-small-top">54 Thompson Street<br />
					New York, NY 10012<br />
					at the corner of Broome Street<br />
					<br />
					212.878.6305</p>
				</div>
				<div class="equal-columns margin-large-top margin-medium-bottom">
					<h4 class="center uppercase">OUR MIDTOWN LOCATION</h4>

					<p class="center small-font"><a href="http://www.peranyc.com">Pera Mediterranean Brasserie<br />
					303 Madison Ave<br />
					New York, NY 10017<br />
					<br />
					(212) 878-6301</a></p>
				</div>
				
				<img src="<?php echo $bloginfo ;?>filigre-bottom.png" alt="Filigre border" />
			</div>
		</div>
	</div>
</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
