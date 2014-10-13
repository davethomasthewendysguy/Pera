<?php

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

global $complete_gallery_manager_plugin;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','act'));
}

if(!isset($_POST['post_id']) && $_POST['post_id']>0){
	send_error_die(__('No post id pleas contact support.','act'));
}

$comments = get_post_meta($_POST['post_id'], 'cgm_comments', true);


if(empty($comments)){
	$comments = __('No comments','act');
}

$preview = '';

if ( has_post_thumbnail($_POST['post_id'],'thumbnail')) {
	$preview = wp_get_attachment_image_src( get_post_thumbnail_id( $_POST['post_id'] ), 'medium'  );
} else {
	$preview[0] = COMPLETE_GALLERY_URL.'images/no_photo.jpg';
}



$cgm_gallery_data = get_post_meta($_POST['post_id'], "cgm-gallery-data",true);
$tmp_images = json_decode(urldecode($cgm_gallery_data));



		
$tmp_categoryes = array();
		
		
if(!empty($tmp_images)){
	foreach($tmp_images as $tmp_img_key => $tmp_img_data){

		if(!empty($tmp_img_data->category)){
			foreach($tmp_img_data->category as $tmp_keyyy => $tmp_cat){
				$tmp_categoryes[$tmp_cat] = $tmp_cat;
			}
		}	
	}
}

$taxonomies=get_categories(array('hide_empty' => 0,'taxonomy' => 'cgm-category','orderby' => 'name','order'=> 'ASC'));
$return_filter = '';
if(!empty($taxonomies) and !empty($tmp_categoryes)){
	foreach($taxonomies as $taxonomie){
		$tmp_name = '';
		$tmp_catid = '';
		foreach($tmp_categoryes as $tmp_cat){
			if($taxonomie->term_id == $tmp_cat){
				$tmp_name = $taxonomie->name;
			}
		}
		if(!empty($tmp_name)){
			$return_filter .= '<option value=\''.$taxonomie->term_id.'\'>'.$tmp_name.'</option>';
		}
	}	
}

$response = array(
    'R'	=> 'OK',
    'SHORTCODE' => $complete_gallery_manager_plugin->globalt_shorcode_generator(array('id'=>$_POST['post_id'])),
    'COMMENTS' =>$comments,
    'PREVIEW' => $preview,
    'CATEGORY' => $return_filter
);

die(json_encode($response));
?>