<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package pera_soho
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'pera_soho' ),
				'after'  => '</div>',
			) );
		?>
		
		<div class="full-module white-background">
			<div class="separator-inside">
				<footer class="entry-footer">
					<?php if(is_user_logged_in()) { ?>
					<div class="margin-medium">
						<?php edit_post_link( __( 'Edit', 'pera_soho' ), '<span class="edit-link">', '</span>' ); ?>
					</div>
					<?php } ?>
				</footer><!-- .entry-footer -->
			</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
