<?php
/**
 * Template Name: News layout
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
*/

get_header(); ?>

<div id="content-overlay">
	<?php
		do_action('skeleton_before_content');
		get_template_part('loop', 'index');
		do_action('skeleton_after_content');
	?>
</div>

<!-- LOOG -->

<!--Arrow Navigation-->
<a id="prevslide" class="load-item"></a>
<a id="nextslide" class="load-item"></a>

<!--Control Bar-->
<div id="controls-wrapper" class="load-item">
	<div id="controls">
		
		<a id="play-button"><img id="pauseplay" src="<?php echo get_template_directory_uri(); ?>/img/pause.png"/></a>
		
		<?php //if (is_active_sidebar('bottom-widget-area')) : ?>
			<div class="">
				<?php dynamic_sidebar('bottom-widget-area'); ?>
			</div>
		<?php //endif;?>
	</div>
</div>

<div id="below-fold">
	<?php wp_footer();?>
</div>

<?php
	//get_sidebar();
	get_footer();
?>