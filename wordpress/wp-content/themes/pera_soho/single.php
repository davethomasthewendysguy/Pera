<?php
/**
 * The Template for displaying all single posts.
 *
 * @package pera_soho
 */

$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";

get_header(); ?>

<div id="below-fold">
	<div id="primary" class="content-area full-module white-background">
		<main id="main" class="site-main full-module-inside" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php pera_soho_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

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
<div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>