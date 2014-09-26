<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package pera_soho
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!--RUN ADAPTIVE IMAGES PHP SCRIPT-->
<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';</script>

<!--FOR LIKE BUTTON-->
<meta name="likebtn-website-verification" content="f03a03c8cdd875e8" />

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

<?php wp_head(); ?>
<?php if(is_front_page()) { ?>
<script async type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(function(){
		
			jQuery.supersized({
		
				// Functionality
				slideshow               :   1,			// Slideshow on/off
				autoplay				:	1,			// Slideshow starts playing automatically
				start_slide             :   1,			// Start slide (0 is random)
				stop_loop				:	0,			// Pauses slideshow on last slide
				random					: 	0,			// Randomize slide order (Ignores start slide)
				slide_interval          :   5000,		// Length between transitions
				transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
				transition_speed		:	1000,		// Speed of transition
				new_window				:	0,			// Image links open in new window/tab
				pause_hover             :   0,			// Pause slideshow on hover
				keyboard_nav            :   1,			// Keyboard navigation on/off
				performance				:	3,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
				image_protect			:	1,			// Disables image dragging and right click with Javascript
													   
				// Size & Position						   
				min_width		        :   0,			// Min width allowed (in pixels)
				min_height		        :   0,			// Min height allowed (in pixels)
				vertical_center         :   1,			// Vertically center background
				horizontal_center       :   1,			// Horizontally center background
				fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
				fit_portrait         	:   1,			// Portrait images will not exceed browser height
				fit_landscape			:   0,			// Landscape images will not exceed browser width
													   
				// Components							
				slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
				thumb_links				:	0,			// Individual thumb links for each slide
				thumbnail_navigation    :   0,			// Thumbnail navigation
				slides 					:  	[			// Slideshow Images
													{image : 'wp-content/themes/pera_soho/images/slides/1.jpg', title : 'Image Credit: Big Idea'},
													{image : 'wp-content/themes/pera_soho/images/slides/2.jpg', title : 'Image Credit: Big Idea'},
													{image : 'wp-content/themes/pera_soho/images/slides/3.jpg', title : 'Image Credit: Big Idea'},
													{image : 'wp-content/themes/pera_soho/images/slides/4.jpg', title : 'Image Credit: Big Idea'},
													{image : 'wp-content/themes/pera_soho/images/slides/5.jpg', title : 'Image Credit: Big Idea'},							
													{image : 'wp-content/themes/pera_soho/images/slides/6.jpg', title : 'Image Credit: Big Idea'}
											],
										
				// Theme Options			   
				progress_bar			:	0,			// Timer for each slide							
				mouse_scrub				:	0
			});
		});
	});
</script>
<?php } ?>

<style type="text/css">
	ul#demo-block{margin:0 15px 15px 15px;}
	ul#demo-block li{margin:0 0 10px 0; padding:10px; display:inline; float:left; clear:both; color:#aaa; background:url('img/bg-black.png'); font:11px Helvetica, Arial, sans-serif;}
	ul#demo-block li a{color:#eee; font-weight:bold;}
</style>
</head>

<body <?php body_class(); ?>>

<?php $bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/"; ?>

<!--OPEN TABLE WIDGET OVERLAY-->
<div class="open-table modal-hide center">
	<a class="close-open-table-modal" href="">X</a>
	<script type="text/javascript" src="https://secure.opentable.com/frontdoor/default.aspx?rid=76933&restref=76933&bgcolor=F6F6F3&titlecolor=cba978&subtitlecolor=0F0F0F&btnbgimage=https://secure.opentable.com/frontdoor/img/ot_btn_red.png&otlink=FFFFFF&icon=dark&mode=short"></script><a href="http://www.opentable.com/pera-soho-reservations-new-york?rtype=ism&restref=76933" class="OT_ExtLink">Pera Soho (76933), New York / Tri-State Area Reservations</a>
</div>
<div class="overlay">
</div>

<div id="page" class="hfeed site">
	<div id="content" class="site-content">
		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2" role="navigation">
			<h3 class="menu-toggle center margin-small-top"><img width="208" height="104" src="<?php echo $bloginfo; ?>logo.png" /></h3>
			
			<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		</nav><!-- #site-navigation -->

		<div id="main-menu" class="full-module cream-background fixed-menu">
			<div class="full-module-menu-inside">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<div id="showRightPush" class="menu-toggle"><img src="<?php echo $bloginfo; ?>burger-menu.png" /></div>
					<a href="<?php echo home_url(); ?>"><img class="mobile-menu-logo" width="30" height="30" src="<?php echo $bloginfo ;?>small-black-star.png" /></a>
			
					<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pera_soho' ); ?></a>
					<?php if(is_front_page()) {
						wp_nav_menu( array('theme_location' => 'primary'));
					} else {
						wp_nav_menu( array('theme_location' => 'secondary'));
					} ?>
				</nav><!-- #site-navigation -->
			</div>
		</div>