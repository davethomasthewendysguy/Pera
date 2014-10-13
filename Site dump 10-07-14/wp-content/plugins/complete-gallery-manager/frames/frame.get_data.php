<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');


global $complete_gallery_display;
if(!empty($_POST['post_id'])){
	$post_id = $_POST['post_id'];
} else {
	die();
}

$gallery_count_id = $_POST['gallery_count_id'];

$cgm_flag = get_post_meta($post_id, "cgm_flag",true);	
$cgm_settings = get_post_meta($post_id, "cgm_settings",true);
$cgm_gallery_data = get_post_meta($post_id, "cgm-gallery-data",true);		
		
$cgm_width  = get_post_meta($post_id, "cgm_width",true);	
$cgm_height = get_post_meta($post_id, "cgm_height",true);	


global $$complete_gallery_display[$cgm_flag]['class_php'];
					
if(!empty($$complete_gallery_display[$cgm_flag]['class_php'])){
	$return_content = $$complete_gallery_display[$cgm_flag]['class_php']->$complete_gallery_display[$cgm_flag]['call_php_func']($gallery_count_id,$cgm_gallery_data,$cgm_settings,$cgm_flag,false,false,$post_id);
}

$upload_dir = wp_upload_dir();
$cssurl = $upload_dir['baseurl'].'/cgm/'.$_POST['post_id'].'css.css';


$response = array(
    'R'	=> 'OK',
    'RETURN_DATA' => $return_content,
    'CSS' => $cssurl
);

die(json_encode($response));
?>