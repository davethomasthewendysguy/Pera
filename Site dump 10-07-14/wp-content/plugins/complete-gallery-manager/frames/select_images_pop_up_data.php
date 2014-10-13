<?php

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');
require_once(COMPLETE_GALLERY_PATH.'inc/phpFlickr.php');


$special_type = '';
if(isset($_POST['special_type'])){
	$special_type = $_POST['special_type'];
	
}

$special_id = '';
if(isset($_POST['special_id'])){
	$special_id = $_POST['special_id'];
	
}

$posts_array = array();
$content = '';
$count_images = 0;

if(!empty($special_id) and !empty($special_type)){
	$temp_data = '';
	$cgm_options = get_option('cgm_options');
	$flickr_api = new phpFlickr($cgm_options['flickr_apikey']);
	if($special_type == 'photogalleri') {
		$temp_data = $flickr_api->galleries_getPhotos($special_id);
		
		if(!empty($temp_data['photos']['photo']) && count($temp_data['photos']['photo'])>0 && count($temp_data['photos']['photo'])>$_POST['cgm_tooles_current']){
			foreach($temp_data['photos']['photo'] as $temp_photoset){
				$content .= '<div title="'.$temp_photoset['title'].'" alt="'.$temp_photoset['title'].'" onClick="cgm_activate_click(this);" class="element imagesize'.$_POST['cgm_tooles_size'].'" data-ID="'.$temp_photoset['id'].'"';
				$image = '';
			 	$image = $flickr_api->buildPhotoURL($temp_photoset,'medium');
				$content .= ' style="background-image:url(\''.$image.'\')">';	
			 	$content .= '</div>';
			 	$count_images++;	
			}	
		}
		
		
	} else if($special_type == 'photoset') {
		$temp_data = $flickr_api->photosets_getPhotos($special_id);
		
		if(!empty($temp_data['photoset']['photo']) && count($temp_data['photoset']['photo'])>0 && count($temp_data['photoset']['photo'])>$_POST['cgm_tooles_current']){
			foreach($temp_data['photoset']['photo'] as $temp_photoset){
				$content .= '<div title="'.$temp_photoset['title'].'" alt="'.$temp_photoset['title'].'" onClick="cgm_activate_click(this);" class="element imagesize'.$_POST['cgm_tooles_size'].'" data-ID="'.$temp_photoset['id'].'"';
				$image = '';
			 	$image = $flickr_api->buildPhotoURL($temp_photoset,'medium');
				$content .= ' style="background-image:url(\''.$image.'\')">';	
			 	$content .= '</div>';
			 	$count_images++;	
			}	
		}
	} else if($special_type == 'photouser'){
		$temp_data = $flickr_api->people_getPublicPhotos($special_id, NULL, $_POST['cgm_tooles_current'], $_POST['cgm_tooles_diff']);
		
		if(!empty($temp_data['photos']['photo']) && count($temp_data['photos']['photo'])>0 && count($temp_data['photos']['photo'])>$_POST['cgm_tooles_current']){
			foreach($temp_data['photos']['photo'] as $temp_photoset){
				$content .= '<div title="'.$temp_photoset['title'].'" alt="'.$temp_photoset['title'].'" onClick="cgm_activate_click(this);" class="element imagesize'.$_POST['cgm_tooles_size'].'" data-ID="'.$temp_photoset['id'].'"';
				$image = '';
			 	$image = $flickr_api->buildPhotoURL($temp_photoset,'medium');
				$content .= ' style="background-image:url(\''.$image.'\')">';	
			 	$content .= '</div>';
			 	$count_images++;	
			}	
		}	
	}
} else {

	global $complete_gallery_manager_plugin;
	$create_scales = $complete_gallery_manager_plugin->cgm_get_image_scalse();
	
	$args = array(
	    'numberposts'     => $_POST['cgm_tooles_diff'],
	    'offset'          => $_POST['cgm_tooles_current'],
	    'orderby'         => $_POST['cgm_tooles_sort'],
	    'order'           => 'DESC',
	    'post_type'       => 'attachment');
	
	$posts_array = get_posts( $args );
	
	foreach($posts_array as $post_array){
		$content .= '<div title="'.$post_array->post_name.'" alt="'.$post_array->post_name.'" onClick="cgm_activate_click(this);" class="element imagesize'.$_POST['cgm_tooles_size'].'" data-ID="'.$post_array->ID.'"';
	 	$image=wp_get_attachment_image_src($post_array->ID);
		$content .= ' style="background-image:url(\''.$image[0].'\')">';	
	 	$content .= '</div>';
	 	$count_images++;	
	}
}

if($count_images>0){
	$response = array(
	    'R'	=> 'OK',
	    'DATA' => $content,
	    'MSG' => 'New Images ('.$count_images.' Items)',
	    'CURRENT' => ($_POST['cgm_tooles_current']+$count_images)
	);
} else {
	$response = array(
	    'R'	=> 'NODATA',
	    'MSG' => 'No More Images',
	    'CURRENT' => $_POST['cgm_tooles_current']
	);
}

die(json_encode($response));
?>







