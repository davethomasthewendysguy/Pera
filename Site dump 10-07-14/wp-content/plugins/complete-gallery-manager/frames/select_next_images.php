<?php

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

global $wpdb,$cgm_isotope_generator;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!isset($_POST['post_id'])){
	send_error_die(__('No post id are received','evt'));
}

if(empty($_POST['tmp_id'])){
	$_POST['tmp_id'] = 0;
}
$max_count = 20;
if(!empty($_POST['max_count'])){
	$max_count = $_POST['max_count'];
}


$cgm_gallery_data = get_post_meta($_POST['post_id'], "cgm-gallery-data",true);	
$cgm_settings = get_post_meta($_POST['post_id'], "cgm_settings",true);

$return_data = $cgm_isotope_generator->load_images_gallery_new($_POST['tmp_id'],$cgm_gallery_data,$cgm_settings,$_POST['count'],$max_count);

$response = array(
    'R'	=> 'OK',
    'DATA' => $return_data[1],
    'MOREDATA' => $return_data[0],
    'COUNT' => ($_POST['count']+20),
    'TMPID' => $_POST['tmp_id'],
    'POSTID' => $_POST['post_id']
);

die(json_encode($response));
?>