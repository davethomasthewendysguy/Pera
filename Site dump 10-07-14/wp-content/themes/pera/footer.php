<?php
/**
 * Footer Template
 *
 * Here we setup all logic and XHTML that is required for the footer section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;


?>

		<div class="fix"></div><!--/.fix-->
		</div><!-- /#wrapper -->
	</div><!-- /#main-wrapper -->
<?php
	woo_footer_top();
 	woo_footer_before();
?>

		<div class="twitter-footer">
			<div class="col-full" >
				<?php
					if ( woo_active_sidebar( 'twitter-footer' ) ) {
						woo_sidebar('twitter-footer');
					}
				?>
			</div>
		</div>
		<div class="footer-wrapper">
			<div class="footer-logo col-full"></div>
			<div id="footer">

				<div class="footer-container col-full">
				<?php woo_footer_inside(); ?>
					<?php
						for($i = 1 ; $i <= 4 ; $i++){
							if ( woo_active_sidebar( 'footer-' . $i ) ) {
								echo '<div class="footer-widget' . $i . ' footer-widget">';
									woo_sidebar('footer-' . $i);
								echo '</div>';
							}
						}

					?>
				</div>

			</div><!-- /#footer  -->
		</div><!-- .footer-wrapper -->
		<div class="copyright-container">
			<div class="col-full">
				<div id="emailgroup" class="col-left">
					<?php
						if ( woo_active_sidebar( 'bottom-widget' ) ) {
							woo_sidebar('bottom-widget');
						}
					?>
				</div>

				<div id="credit" class="col-right">
					<?php woo_footer_right(); ?>
				</div>
			</div>
		</div>

		<?php woo_footer_after(); ?>

		<div class="fix"></div><!--/.fix-->

		<?php wp_footer(); ?>
		<?php woo_foot(); ?>
	</div>
</div>
	</body>
</html>