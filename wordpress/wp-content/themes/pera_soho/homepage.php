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
	<div id="about-us" class="full-module white-background"><!--LOCATION AND HOURS-->
		<div class="full-module-inside">
			<a class="open-reservation-box" href="#"><img width="230" height="37" class="modal-pop-up center margin-medium" src="<?php echo $bloginfo ;?>make-a-reservation.png" alt="Make a Reservation" /></a>
			
			<h3 class="uppercase center">Location & Hours</h3>
			
			<div class="info-box">
				<img src="<?php echo $bloginfo ;?>filigre-top.png" alt="Filigre border" />
				
				<div class="column1">
					<p><a target="_blank" href="https://www.google.com/maps/place/Pera+Soho/@40.723831,-74.003389,17z/data=!3m1!4b1!4m2!3m1!1s0x89c2598c80b90e3d:0x8c053fe36e7d8561">54 Thompson St (and Broome St)<br />
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
		<div class="separator-inside margin-medium-bottom">
			<a target="_blank" href="https://www.google.com/maps/place/54+Thompson+St/@40.7239637,-74.0036697,19z/data=!4m2!3m1!1s0x89c2598c7d22693d:0x5089669e6943b531"><img src="<?php echo $bloginfo; ?>matchbook-map.png" alt="Separator" /></a>
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo; ?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<div class="full-module white-background"><!--ABOUT US-->
		<div class="full-module-inside" style="padding-top:20px;"><!--PADDING TOP HACK TO MAKE ABOUT COPY VISIBLE WITHOUT SCROLLING-->
			<h3 class="uppercase center">About</h3>
	
			<div class="center-copy">
				<?php while(have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
	
	<div class="full-module fixed-background roof-background optimize-sharpness" data-type="background" data-speed="40"><!--PARALLAX STAR-->
		<img class="full-width" src="<?php echo $bloginfo ;?>star-pattern.png" alt="Star Pattern" />
	</div>
	
	<div id="specials" class="full-module white-background"><!--SPECIALS-->
		<div class="specials-module-inside">
			<h3 class="uppercase center">Pera-Logue</h3>
			
			<?php the_post(); ?>
			
			<div class="homepage-specials" style="overflow:auto;">
				<?php
					//GET LATEST 2 SPECIALS
					$news_posts = get_posts(array(
						'post_type' => 'post',
						'posts_per_page' => 2, // Unlimited posts
						'orderby' => 'date', // Order by date
						'category' => 91
					)); 
				?>
				
				<?php if($news_posts): 
					foreach ($news_posts as $post): 
						setup_postdata($post);

						$thumb_src = null;
						if (has_post_thumbnail($post->ID)) {
							$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team-thumb' );
							$thumb_src = $src[0];
						}
						?>
						
						<article class="four-column">
							<?php if ( $thumb_src ): ?>
								<a href="<?php echo get_permalink(); ?>"><img width="220" height="220" src="<?php echo $thumb_src; ?>" alt="<?php the_title(); ?>"></a>
							<?php endif; ?>
					
							<h5 class="center uppercase"><?php the_title(); ?></h5>
					
							<?php the_excerpt(); ?>						
						</article><!-- /.profile -->

					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php wp_reset_query(); ?>				
				
				<?php
					//GET LATEST 2 POSTS
					$news_posts = get_posts(array(
						'post_type' => 'post',
						'posts_per_page' => 2, // Unlimited posts
						'orderby' => 'date', // Order by date
						'category' => -91
					)); 
				?>
				
				<?php if($news_posts): 
					foreach ($news_posts as $post): 
						setup_postdata($post);

						$thumb_src = null;
						if (has_post_thumbnail($post->ID)) {
							$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team-thumb' );
							$thumb_src = $src[0];
						}
						?>
						
						<article class="four-column">
							<?php if ( $thumb_src ): ?>
								<a href="<?php echo get_permalink(); ?>"><img width="220" height="220" src="<?php echo $thumb_src; ?>" alt="<?php the_title(); ?>"></a>
							<?php endif; ?>
					
							<h5 class="center uppercase"><?php the_title(); ?></h5>
					
							<?php the_excerpt(); ?>						
						</article><!-- /.profile -->

					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			
			<div class="center bold uppercase"><a href="/pera-logue/">View All</a></div>
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
				<img style="width:100%;" src="<?php echo $bloginfo ;?>filigre-top.png" alt="Filigre border" />
					<nav id="food-navigation" class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'food' ) ); ?>
					</nav>
				<img style="width:100%;" src="<?php echo $bloginfo ;?>filigre-bottom.png" alt="Filigre border" />
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
				<p class="center">World-renowned Mediterranean hospitality underscores our culture and our commitment to your special occasion at Pera SoHo.<br />
				<br />
				<a href="events/"><img class="center" src="<?php echo $bloginfo ;?>learn-more.png" alt="Book with Us" /></a></p>
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