<?php
/**
 * Post Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `single.php` template file, contextually, as well as in archive lists or search results.
 *
 * @package WooFramework
 * @subpackage Template
 */

/**
 * Settings for this template file.
 *
 * This is where the specify the HTML tags for the title.
 * These options can be filtered via a child theme.
 *
 * @link http://codex.wordpress.org/Plugin_API#Filters
 */
 global $woo_options;

 $title_before = apply_filters( 'title_before', '<h1 class="title">');
 $title_after = apply_filters( 'title_after', '</h1>');

 if ( ! is_single() ) {

 	$title_before = apply_filters( 'title_before', '<h2 class="title">');
 	$title_after = apply_filters( 'title_after', '</h2>');

	$title_before = $title_before . '<a href="' . get_permalink( get_the_ID() ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
	$title_after = '</a>' . $title_after;

 }

 $page_link_args = apply_filters( 'woothemes_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) );

 woo_post_before();
?>
<div <?php post_class('singlep'); ?>>
	<div class="singlep-date">
		<?php echo custom_post_date($post->ID); ?>
	</div>
	<div class="singlep-content">
		<?php
			woo_post_inside_before();

			the_title('<h1 class="singlep-title">','</h1>');
		?>
		<div class="singlep-social">

		</div>

			<div class="entry">

				<?php

					

					/*woo_post_meta();*/
				?>


			    <?php
			    	if ( $woo_options['woo_post_content'] == 'content' || is_single() ) { the_content(__('Continue Reading &rarr;', 'woothemes') ); } else { the_excerpt(); }
			    	if ( $woo_options['woo_post_content'] == 'content' || is_singular() ) wp_link_pages( $page_link_args );
			    ?>
			</div><!-- /.entry -->
			<div class="fix"></div>
		<?php
			/*woo_post_inside_after();*/
		?>
	</div>
	<div class="fix"></div>
</div><!-- /.post -->
<?php
/*	woo_post_after();*/
	/*$comm = $woo_options[ 'woo_comments' ];
	if ( ( $comm == 'post' || $comm == 'both' ) && is_single() ) { comments_template(); }*/
?>