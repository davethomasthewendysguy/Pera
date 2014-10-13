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

$addClass = 'landing page';

?>
<body <?php body_class($addClass); ?> onload="_googWcmGet('phone-number', '(212) 878-6301')">

<div class="super-wrapper">
	<div class="whole-wrapper">
		<?php woo_top(); ?>

		<div id="main-wrapper">

			<?php woo_header_before(); ?>

			<div id="header">
				<div class="col-full">
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

					<?php woo_header_after(); ?>

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
					</div><!-- /.sub-navigation -->

					<div class="shortnav navigation-drop">
						<h3 class="shortnav-title"><a href="javascript:void(0);">Change Location</a></h3>
						<?php
							wp_nav_menu(
								array( 'theme_location' => 'change-location',
									   'menu_class' => '',
									   'container' => false,
									   'container_class' => '',
									   'walker' => new Woo_Navigation()
								)
							);
						?>
					</div><!-- /.navigation-drop /.shortnav -->
				</div><!-- /.col-full -->
			</div><!-- /#header -->

			<div id="wrapper">