<?php
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 // Setup the tag to be used for the header area (`h1` on the front page and `span` on all others).
 $heading_tag = 'span';
 if ( is_home() OR is_front_page() ) { $heading_tag = 'h1'; }

 // Get our website's name, description and URL. We use them several times below so lets get them once.
 $site_title = get_bloginfo( 'name' );
 $site_url = home_url( '/' );
 $site_description = get_bloginfo( 'description' );

 global $woo_options;
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes('html'); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes('html'); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes('html'); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes('html'); ?>> <!--<![endif]-->
<head>
<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
<meta http-equiv="x-dns-prefetch-control" content="off">
<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php wp_head(); ?>
<?php woo_head(); ?>
<!-- BugHerd -->
<script type='text/javascript'>
  (function (d, t) {
    var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
    bh.type = 'text/javascript';
    bh.src = '//www.bugherd.com/sidebarv2.js?apikey=9oj0g0spv5miorcrdzybiq';
    s.parentNode.insertBefore(bh, s);
  })(document, 'script');
</script>

<!-- Google Call Tracking -->
<script type="text/javascript">
(function(a,e,c,f,g,b,d){var h={ak:"1026805733",cl:"knEqCPahiVYQ5Z_P6QM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
</script>
</head>
<?php

$addClass = '';
if(!is_front_page() && !is_home()) $addClass = ' not-home ' ;
$addClass .= ' not-landing ' ;

 ?>
<body <?php body_class($addClass); ?> onload="_googWcmGet('phone-number', '(212) 365-6305')">

<div class="super-wrapper">
<div class="whole-wrapper">

<?php woo_top(); ?>

<div id="main-wrapper">
	<?php woo_header_before(); ?>
	<div class="top-widget-container">
		<div class="col-full">
			<div class="right-top-widget">
				<?php woo_sidebar('right-top-header'); ?>
			</div><!-- .right-top-widget -->

			<div class="left-top-widget">
				<?php woo_sidebar('left-top-header'); ?>
			</div><!-- .left-top-widget -->
		</div>
	</div><!-- .top-widget-container -->

	<div id="header">
			<div class="col-full">
			<?php woo_header_inside_top(); ?>

			<?php woo_header_inside(); ?>

			<div id="logo">
			<?php
				// Website heading/logo and description text.
				if ( isset( $woo_options['woo_logo'] ) && ( '' != $woo_options['woo_logo'] ) ) {
					$logo_url = $woo_options['woo_logo'];
					if ( is_ssl() ) $logo_url = str_replace( 'http://', 'https://', $logo_url );

					echo '<a href="' . esc_url( $site_url ) . '" title="' . esc_attr( $site_description ) . '"><img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_title ) . '" /></a>' . "\n";
				} // End IF Statement

				echo '<' . $heading_tag . ' class="site-title"><a href="' . esc_url( $site_url ) . '">' . $site_title . '</a></' . $heading_tag . '>' . "\n";
				if ( $site_description ) { echo '<span class="site-description">' . $site_description . '</span>' . "\n"; }
			?>
			</div><!-- /#logo -->

		    <!-- <h3 class="nav-toggle icon"><a href="#navigation"><?php _e( 'Navigation', 'woothemes' ); ?></a></h3>-->

			<?php if ( isset( $woo_options['woo_ad_top'] ) && ( 'true' == $woo_options['woo_ad_top'] ) ) { ?>
	        <div id="topad">

			<?php if ( ( isset( $woo_options['woo_ad_top_adsense'] ) ) && ( '' != $woo_options['woo_ad_top_adsense'] ) ) {
	            echo stripslashes( get_option('woo_ad_top_adsense') );
	        } else {
	        	$top_ad_image = $woo_options['woo_ad_top_image'];
	        	if ( is_ssl() ) $top_ad_image = str_replace( 'http://', 'https://', $top_ad_image );
	        ?>
	            <a href="<?php echo esc_url( get_option( 'woo_ad_top_url' ) ); ?>"><img src="<?php echo esc_url( $top_ad_image ); ?>" alt="" /></a>
	        <?php } ?>

	        </div><!-- /#topad -->
	        <?php } ?>
	        <?php woo_header_after(); ?>
	        <?php woo_header_inside_bottom(); ?>
		</div>
	</div><!-- /#header -->

	<div id="wrapper">
	<div class="sub-navigation">
		<?php
			wp_nav_menu(
				array( 'theme_location' => 'sub-menu',
					   'menu_class' => '',
					   'container' => false,
					   'container_class' => '',
					   'walker' => new Woo_Navigation()
				)
			);
			?>

			<div class="social-links">
				<a href="<?php echo $woo_options['woo_facebook_link']; ?>" target="_blank" class="social-links fb"></a>
				<a href="<?php echo $woo_options['woo_twitter_link']; ?>" target="_blank" class="social-links twitter"></a>
				<a href="<?php echo $woo_options['woo_google_link']; ?>" target="_blank" class="social-links google"></a>
			</div>

	</div>

