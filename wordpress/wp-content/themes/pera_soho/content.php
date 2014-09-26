<?php
/**
 * @package pera_soho
 */
?>

<?php
	$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";
?>

<article id="post-<?php the_ID(); ?> <?php post_class('specials-module-inside margin-large-bottom'); ?>>
	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<header class="entry-header">
			<?php the_title( sprintf( '<h1 class="entry-title center uppercase"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

			<?php if('post' == get_post_type()) : ?>
			<div class="entry-meta">
				<?php pera_soho_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
	
		<header class="entry-header">
			<?php 
				if(has_post_thumbnail()) { ?>
				
					<a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail('post-thumbnail', array('class' => "featured-image margin-medium-bottom")); ?></a>
				<?php }
			?>
		
			<?php the_title( sprintf( '<h3 class="entry-title uppercase no-margin-bottom"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

			<?php if('post' == get_post_type()) : ?>
			<div class="entry-meta">
				<?php pera_soho_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
		 
			<?php the_content( __( 'Continue reading', 'pera_soho' ) ); ?>
		
			<div id="sharing-container" class="sharing-container">
				<?php echo do_shortcode('[hupso]'); ?>
				<?php //likebtn_post(); ?>
			</div>
		
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'pera_soho' ),
					'after'  => '</div>',
				) );
			?>	
						
			<?php
				//echo get_ssb();
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				//$categories_list = get_the_category_list( __( ', ', 'pera_soho' ) );
				//if ( $categories_list && pera_soho_categorized_blog() ) :
			?>
			<!--<span class="cat-links">
				<?php //printf( __( 'Posted in %1$s', 'pera_soho' ), $categories_list ); ?>
			</span>-->
			<?php //endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'pera_soho' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', 'pera_soho' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'pera_soho' ), __( '1 Comment', 'pera_soho' ), __( '% Comments', 'pera_soho' ) ); ?></span>
		<?php endif; ?>

		<?php //edit_post_link( __( 'Edit', 'pera_soho' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside-bottom">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
</article><!-- #post-## -->
