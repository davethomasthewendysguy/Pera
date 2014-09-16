<?php
/**
 * The Header for our theme.
 *
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
 */
?>
<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html <?php language_attributes();?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Add CSS3 PIE Rules for IE 7-9
================================================== -->

<!--[if IE]>
<style type="text/css">
html.ie #navigation,
html.ie a.button,
html.ie .cta,
html.ie .wp-caption,
html.ie #breadcrumbs,
html.ie a.more-link,
html.ie .gallery .gallery-item img,
html.ie .gallery .gallery-item img.thumbnail,
html.ie .widget-container,
html.ie #author-info {behavior: url("<?php echo get_stylesheet_directory_uri();?>/PIE.php");position: relative;}</style>
<![endif]-->


<!-- Mobile Specific Metas
================================================== -->

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!-- Favicons
================================================== -->

<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri();?>/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri();?>/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri();?>/images/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri();?>/images/apple-touch-icon-114x114.png" />

<?php wp_head(); ?>


<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(function(){
		
			jQuery.supersized({
		
				// Functionality
				slideshow               :   1,			// Slideshow on/off
				autoplay				:	1,			// Slideshow starts playing automatically
				start_slide             :   1,			// Start slide (0 is random)
				stop_loop				:	0,			// Pauses slideshow on last slide
				random					: 	0,			// Randomize slide order (Ignores start slide)
				slide_interval          :   8000,		// Length between transitions
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
													{image : 'wp-content/themes/skeleton/images/slider/1.jpg', title : 'Image Credit: Big Idea'},
													{image : 'wp-content/themes/skeleton/images/slider/2.jpg', title : 'Image Credit: Big Idea'},  
													{image : 'wp-content/themes/skeleton/images/slider/3.jpg', title : 'Image Credit: Big Idea'}
											],
										
				// Theme Options			   
				progress_bar			:	1,			// Timer for each slide							
				mouse_scrub				:	0
			});
		});
	});
</script>

<style type="text/css">
	ul#demo-block{margin:0 15px 15px 15px;}
	ul#demo-block li{margin:0 0 10px 0; padding:10px; display:inline; float:left; clear:both; color:#aaa; background:url('img/bg-black.png'); font:11px Helvetica, Arial, sans-serif;}
	ul#demo-block li a{color:#eee; font-weight:bold;}
</style>
</head>
<body <?php body_class(); ?>>

<div id="header-container">
	<?php
		do_action('skeleton_above_header');
		do_action('skeleton_header');
		do_action('skeleton_below_header');
		do_action('skeleton_navbar');
	?>
</div>