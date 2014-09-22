<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package pera_soho
 */

$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";

get_header(); ?>
<div id="below-fold" class="four-oh-four-background">
	<div id="primary" class="content-area full-module">
		<main id="main" class="site-main full-module-inside" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title uppercase center margin-medium-top"><?php _e( '404 / Sayfa bulunamadı (Page Not Found)', 'pera_soho' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p class="center"><?php _e( 'It looks like nothing was found at this location. Use the links up top to return to the site.', 'pera_soho' ); ?></p>

					<?php //get_search_form(); ?>

					<?php //the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( pera_soho_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<!--<div class="widget widget_categories">-->
						<!--<h2 class="widgettitle"><?php //_e( 'Most Used Categories', 'pera_soho' ); ?></h2>-->
						<!--<ul>-->
						<?php
							/*wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );*/
						?>
						<!--</ul>-->
					<!--</div>--><!-- .widget -->
					<?php endif; ?>

					<?php
						/* translators: %1$s: smiley */
						//$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'pera_soho' ), convert_smilies( ':)' ) ) . '</p>';
						//the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php //the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>