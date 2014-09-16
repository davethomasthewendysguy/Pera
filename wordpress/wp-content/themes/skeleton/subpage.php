<?php
/**
 * Template Name: Subpage layout
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
*/

if(!(empty($_GET["meal_option"]))) {
	$meal_option = $_GET["meal_option"];
} else {
	$meal_option == 2;
}

get_header(); ?>

<div id="content-overlay">	
	<?php get_template_part( 'loop', 'page' ); ?>
</div>

<!-- LOOG -->

<!--Thumbnail Navigation-->
<!--<div id="prevthumb"></div>
<div id="nextthumb"></div>-->

<!--Arrow Navigation-->
<a id="prevslide" class="load-item"></a>
<a id="nextslide" class="load-item"></a>

<!--<div id="thumb-tray" class="load-item">
	<div id="thumb-back"></div>
	<div id="thumb-forward"></div>
</div>-->

<!--Time Bar-->
<!--<div id="progress-back" class="load-item">
	<div id="progress-bar"></div>
</div>-->

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

<div id="below-fold2">
	<?php wp_footer();?>
</div>

<?php
//do_action('skeleton_before_content');
//get_template_part('loop', 'index');
//do_action('skeleton_after_content');
//get_sidebar();
get_footer();
?>