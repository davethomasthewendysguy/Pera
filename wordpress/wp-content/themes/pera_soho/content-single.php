<?php
/**
 * @package pera_soho
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
			if(has_post_thumbnail()) { ?>
			
				<?php the_post_thumbnail('post-thumbnail', array('class' => "featured-image margin-medium-bottom")); ?>
			<?php }
		?>
	</header>
	
	<header class="entry-header">
		<?php the_title( '<h3 class="entry-title uppercase no-margin-bottom">', '</h3>' ); ?>

		<div class="entry-meta">
			<?php pera_soho_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<div class="entry-content">
		<?php the_content(); ?>
		
		<div id="sharing-container" class="sharing-container">
			<?php echo do_shortcode('[hupso]'); ?>
			<?php //likebtn_post(); ?>
		</div>
		
		<?php
			wp_link_pages(array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'pera_soho' ),
				'after'  => '</div>',
			));
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'pera_soho' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'pera_soho' ) );

			if ( ! pera_soho_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'pera_soho' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'pera_soho' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'pera_soho' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'pera_soho' );
				}

			} // end check for categories on this blog

			/* printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			); */
		?>

		<?php edit_post_link( __( 'Edit', 'pera_soho' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
