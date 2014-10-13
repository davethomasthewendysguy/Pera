	<?php

$get_started_url = COMPLETE_GALLERY_URL.'images/getstarted/';

echo '<div class="wrap cgm-about-wrap">';
echo 	'<h1>'.__( 'Welcome to Complete Gallery Manager').'</h1>';

echo 	'<div class="cgm-about-text">'.__( 'Thank you for installing this plugin! This is a exquisite jQuery plugin for creating magical layouts (galleries) for your WordPress powered website.').'</div>';

echo 	'<div class="wp-cgm-badge"></div>';

echo 	'<div class="changelog">';
echo    	'<h3>'. __( 'Easier Gallery Management').'</h3>';

echo 		'<div class="feature-section images-stagger-right">';
echo			'<div class="feature-images">';
echo				'<img src="'.$get_started_url.'selected-images.png" width="265" class="angled-right" />';
echo				'<img src="'.$get_started_url.'gallery-settings.png" width="265" class="angled-left" />';
echo 			'</div>';
 
echo			'<div class="left-feature">';
echo				'<h4>'.__( 'Get Started in 3 Easy Steps!').'</h4>';
echo				'<p>'.__( 'It is not always easy to manage multiple and large galleries of pictures in WordPress. There is a lot of gallery plugins available for WordPress, some are really good, but we feel that they often lack an easy interface to create and manage multiple galleries.' ).'</p>';
echo				'<p>'.__( 'Using Complete Gallery Manager will make it fun and fast to manage and create galleries for your website.' ).'</p>';
echo				'<p>'._e( 'Follow these 3 Easy Steps to Get Started.' ).'</p>';

echo				'<ol>';
echo					'<li>'.__( 'Select the <a href="post-new.php?post_type=cgm-complete_gallery">Add Gallery</a> menu and enter a name for your gallery and click Publish.' ).'</li>';
echo					'<li>'.__( 'Add your images either by simply drag and drop into the interface or select images directly from your Media Library in WordPress.' ).'</li>';
echo					'<li>'.__( 'Immediately preview your gallery and start tweaking the many different settings. When done click Update. And you are good to go!' ).'</li>';
echo				'</ol>';			
			
echo				'<div class="feature-images">';
echo					'<img src="'.$get_started_url.'insert-gallery.png" width="265" class="angled-right" />';
echo				'</div>';

echo				'<h4>'.__( 'Easily insert Galleries in your Pages or Posts' ).'</h4>';
echo				'<p>' .__( 'It is really easy for you to insert your galleries into Pages, Posts or Custom Posts Types. Simply click on the \'G\' icon above the visual editor, and then choose the gallery you want to insert.').'</p>';
echo				'<p>'.__('You can also insert multiple galleries into the same Page or Post.' ).'</p>';
echo			'</div>';
echo		'</div>';
echo	'</div>';



echo	'<div class="changelog">';
echo		'<h3>'.__( 'Some of the features' ).'</h3>';

echo		'<div class="feature-section text-features">';
echo			'<h4>'.__( 'Layout modes' ).'</h4>';
echo			'<p>'. __( 'Choose between 8 different layout modes; Masonry, Fit Rows, Cell by Row, Straight Down, Masonry Horizontal, Fit Columns Layout, Cells by Columns, Straight Across.' ).'</p>';
echo		'<div>';

echo			'<h4>'.__( 'Sorting'  ).'</h4>';
echo			'<p>'.__( 'You can easily re-order item elements (pictures) with the sorting feature. Use either CSS based filtering or jQuery. Choose between 32 different easing animation settings.').'</p>';

echo			'<h4>'.__( 'Filtering'  ).'</h4>';
echo			'<p>'.__( 'You can easily hide and reveal item elements (pictures) with jQuery selectors.').'</p>';

echo		'</div>';
echo 	'</div>';
echo	'<div class="feature-section screenshot-features">';
echo		'<div class="angled-left">';
echo			'<img src="'.$get_started_url.'layout-settings.png" />';
echo			'<h4>'. __( 'Add-ons' ).'</h4>';
echo			'<p>' .__( 'The plugin lets you easily manage and create multiple galleries, and you will be able to get Add-ons for the plugin, which will let you create other types of galleries like image sliders and carousels.' ).'</p>';
echo		'</div>';
echo		'<div class="angled-right">';
echo			'<img src="'.$get_started_url.'gallery-preview.png" />';
echo			'<h4>'.__( 'Moderation' ).'</h4>';
echo			'<p>'. __( 'The plugin enables a wealth of functionality, but just because you can take advantage of its many features, doesn\'t mean you necessarily should. For each feature you implement you should consider the benefit for your users. Don\'t make the interface more complex than necessary. Less is more!' ).'</p>';
echo		'</div>';
echo	'</div>';
echo '</div>';



echo '<div class="return-to-dashboard">';

if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ){
	echo '<a href="'.esc_url( network_admin_url( 'update-core.php' ) ).'">';
		echo (is_multisite() ? _e( 'Return to Updates' ) : _e( 'Return to Dashboard &rarr; Updates' ));
	echo '</a> |';


}
	echo '<a href="<?php echo esc_url( admin_url() ); ?>">'._e( 'Go to Dashboard &rarr; Home' ).'</a>';
	echo '</div>';     
echo '</div>';   
 
?>