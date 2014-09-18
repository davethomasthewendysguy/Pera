<?php
/**
 * Template Name: Homepage layout
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
*/

if(!(empty($_GET["meal_option"]))) {
	$meal_option = $_GET["meal_option"];
} else {
	$meal_option == 2;
}

$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";

get_header(); ?>

<div id="logo-overlay">
	<nav id="site-navigation2" class="top-navigation" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		<!--<h1><img src="<?php echo $bloginfo ;?>logo-large.png" alt="Pera Logo" /></h1>-->
	</nav>
</div>


<div id="below-fold">
	<div class="full-module white-background"><!--LOCATION AND HOURS-->
		<div class="full-module-inside">
			<a class="open-reservation-box" href="#"><img width="230" height="37" class="modal-pop-up center margin-medium" src="<?php echo $bloginfo ;?>make-a-reservation.png" alt="Make a Reservation" /></a>
			
			<h3 class="uppercase center">Location & Hours</h3>
			
			<div class="info-box">
				<img src="<?php echo $bloginfo ;?>filigre-top.png" alt="Filigre border" />
				
				<div class="column1">
					<p><a target="_blank" href="https://www.google.com/maps/place/Pera+Soho/@40.723831,-74.003389,17z/data=!3m1!4b1!4m2!3m1!1s0x89c2598c80b90e3d:0x8c053fe36e7d8561">54 Thompson Street (and Broome)<br />
					New York, NY 10012</a><br />
					Ph. <a href="tel:+1-212-878-6305">212.878.6305</a></p>
				</div>
				<div class="column2">
					<p>Sunday - Thursday<br />
					12:00pm - 10:30pm</p>
				</div>
				<div class="column2">
					<p>Friday - Saturday<br />
					12:00pm - 11:30pm</p>
				</div>
				
				<p>*Kitchen closes 30 minutes prior to published closing times</p>
				
				<img src="<?php echo $bloginfo ;?>filigre-bottom.png" alt="Filigre border" />
			</div>
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo; ?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<div id="about-us" class="full-module white-background"><!--ABOUT US-->
		<div class="full-module-inside">
			<h3 class="uppercase center">About</h3>
	
			<p class="center">Our signature mezes and entree dishes that are so popular with New Yorkers made the trip with us when we opened another Pera in Soho. But we took our customers off the beaten path into parts of Eastern Mediterranean cuisine that rarely make it across the Atlantic. Like only the best restaurants in New York, we challenge your taste buds with incredible creations, such as Pistachio Crusted Snapper and Marinated Sliced Sirloin Steak “Shaslik.</p>
		</div>
	</div>
	
	<div class="full-module fixed-background roof-background optimize-sharpness" data-type="background" data-speed="40"><!--PARALLAX STAR-->
		<img class="full-width" src="<?php echo $bloginfo ;?>star-pattern.png" alt="Star Pattern" />
	</div>
	
	<div id="specials" class="full-module white-background"><!--SPECIALS-->
		<div class="specials-module-inside">
			<h3 class="uppercase center">Pera-Logue</h3>
			
			<?php the_post(); ?>
			
			<div class="homepage-specials">
				<?php
					//Get 'Special' posts
					$news_posts = get_posts(array(
						'post_type' => 'post',
						'posts_per_page' => 1, // Unlimited posts
						'orderby' => 'date', // Order by date
						'category' => -4
					)); 
				?>
				
				<?php if($news_posts): 
					foreach ($news_posts as $post): 
						setup_postdata($post);

						// Resize and CDNize thumbnails using Automattic Photon service
						$thumb_src = null;
						if (has_post_thumbnail($post->ID)) {
							$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team-thumb' );
							$thumb_src = $src[0];
						}
						?>
						
						<article class="four-column">
							<?php if ( $thumb_src ): ?>
								<a href="<?php echo get_permalink(); ?>"><img width="140" height="140" src="<?php echo $thumb_src; ?>" alt="<?php the_title(); ?>"></a>
							<?php endif; ?>
					
							<h5 class="center uppercase"><?php the_title(); ?></h5>
					
							<?php the_excerpt(); ?>						
						</article><!-- /.profile -->

					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php wp_reset_query(); ?>
				
				<?php
					//Get 'featured' posts
					$news_posts = get_posts(array(
						'post_type' => 'post',
						'posts_per_page' => 3, // Unlimited posts
						'orderby' => 'date', // Order by date
						'category' => 4
					)); 
				?>
				
				<?php if($news_posts): 
					foreach ($news_posts as $post): 
						setup_postdata($post);

						// Resize and CDNize thumbnails using Automattic Photon service
						$thumb_src = null;
						if (has_post_thumbnail($post->ID)) {
							$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team-thumb' );
							$thumb_src = $src[0];
						}
						?>
						
						<article class="four-column">
							<?php if ( $thumb_src ): ?>
								<a href="<?php echo get_permalink(); ?>"><img width="140" height="140" src="<?php echo $thumb_src; ?>" alt="<?php the_title(); ?>"></a>
							<?php endif; ?>
					
							<h5 class="center uppercase"><?php the_title(); ?></h5>
					
							<?php the_excerpt(); ?>						
						</article><!-- /.profile -->

					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<div id="menus" class="full-module white-background"><!--MENU-->
		<div class="full-module-inside">
			<h3 class="uppercase center">Menu</h3>
			
			<div class="info-box margin-medium-bottom">
				<img src="<?php echo $bloginfo ;?>filigre-top.png" alt="Filigre border" />
					<nav id="food-navigation" class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'food' ) ); ?>
					</nav>
				<img src="<?php echo $bloginfo ;?>filigre-bottom.png" alt="Filigre border" />
			</div>
		</div>
	</div>
	
	<div class="full-module fixed-background raw-ingredients-background optimize-sharpness" data-type="background" data-speed="40"><!--PARALLAX SMALL STAR-->
		<img class="full-width" src="<?php echo $bloginfo ;?>small-star-pattern.png" alt="Star Pattern" />
	</div>
	
	<div id="events" class="full-module white-background"><!--EVENTS-->
		<div class="specials-module-inside">
			<h3 class="uppercase center">Events</h3>
			
			<div class="info-box-small">
				<img class="full-width-image block" src="<?php echo $bloginfo ;?>filigre-top-small.png" alt="Filigre border" />
				<p>Pera offers an array of on-premise and off-premise options ranging from formal to casual get togethers and whether it be a corporate event or a celebration with friends and family.<br />
				<br />
				<a href="events/"><img class="center" src="<?php echo $bloginfo ;?>book-with-us.png" alt="Book with Us" /></a></p>
				<img class="full-width-image block absolute bottom-5px max-width-274" src="<?php echo $bloginfo ;?>filigre-bottom-small.png" alt="Filigre border" />
			</div>
			
			<?php putRevSlider("homepage_events") ?>
		</div>
	</div>
	
	<div class="full-module fixed-background train-wallpaper-background optimize-sharpness" data-type="background" data-speed="40"><!--PARALLAX TRAIN-->
		<img class="full-width" src="<?php echo $bloginfo ;?>logo-alt-pattern.png" alt="Train Wall" />
	</div>
	
	<?php include("contact.php"); ?>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside-bottom">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
</div>

<?php
//do_action('skeleton_before_content');
//get_template_part('loop', 'index');
//do_action('skeleton_after_content');
//get_sidebar();
get_footer();
?>