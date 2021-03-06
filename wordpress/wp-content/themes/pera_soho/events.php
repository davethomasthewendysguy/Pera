<?php
/**
 * Template Name: Events layout
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
*/

$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";

get_header(); ?>

<div id="below-fold">
	<div id="events-container" class="full-module white-background live-menu"><!--BRUNCH MENU-->
		<div class="full-module-inside">
			<h3 class="uppercase center">Events</h3>
				
				<div class="center-copy">
					<?php while(have_posts()) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<?php the_post();
	
	/*$args = array(
		'post_type'  => 'events',
		'meta_key'   => 'age',
		'orderby'    => 'meta_value_num',
		'order'      => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'age',
				'value'   => array( 3, 4 ),
				'compare' => 'IN',
			),
		),
	);
	$query = new WP_Query( $args );*/
	
	//Get 'Event' posts
	$events_posts = get_posts(array(
		'post_type' => 'events',
		'posts_per_page' => -1, // Unlimited posts
		'meta_key'   => 'page_position',
		'orderby' => 'meta_value_num', // Order by Page Position
		'order' => 'ASC'
	)); ?>
	
	<div class="full-module white-background">
		<?php
			$i = 0;
			
			if($events_posts): 
				foreach($events_posts as $post): 
					setup_postdata($post);

					//GET SLIDER ID FOR DISPLAY
					$event_slider = null;
				
					$event_slider = get_post_meta($post->ID, rev_slider_id, true);
					
					//GET THUMBNAIL FOR BACKUP IF SLIDER IS NOT PRESENT
					$thumb_src = null;
					if ( has_post_thumbnail($post->ID) ) {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'team-thumb' );
						$thumb_src = $src[0];
					}
					?>
			
					<article class="full-module-inside margin-large-bottom">
						<h3 class="center uppercase"><?php the_title(); ?></h3>						
								
						<div class="info-box-medium <?php if($i % 2) { echo 'margin-medium-left float-right'; } else { echo 'margin-medium-right float-left'; } ?>">
							<img class="full-width-image block" src="<?php echo $bloginfo; ?>filigre-top-small.png" alt="Filigre border" />
							<?php the_content(); ?>	
						
							<img class="full-width-image block absolute bottom-5px max-width-428" src="<?php echo $bloginfo; ?>filigre-bottom-small.png" alt="Filigre border" />
						</div>
						
						<div class="event-slider-container">
							<?php if($event_slider): ?>
								<?php putRevSlider("event_room_".$event_slider); ?>				
							<?php elseif($thumb_src): ?>
						
							<img class="featured-image float-left" src="<?php echo $thumb_src; ?>" alt="<?php the_title(); ?>">
						</div>
						<?php endif; ?>
					</article><!-- /.profile -->
				
					<?php $i++; ?>
				<?php endforeach; ?>
			<?php endif;
		?>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<div id="booking" class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="booking-module-inside">
			<h3 class="uppercase center">Interested in booking your event with us?</h3>
			
			<?php echo do_shortcode('[contact-form-7 id="91" title="Event Reservation Form"]'); ?>
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside-bottom">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<?php include("contact.php"); ?>
</div>

<?php
//do_action('skeleton_before_content');
//get_template_part('loop', 'index');
//do_action('skeleton_after_content');
//get_sidebar();
get_footer();
?>