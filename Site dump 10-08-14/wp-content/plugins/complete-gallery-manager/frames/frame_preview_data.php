<?php

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

global $complete_gallery_display;

if(!empty($$complete_gallery_display[$_POST['type']]['class_php'])){
	$post_return_data = $$complete_gallery_display[$_POST['type']]['class_php']->$complete_gallery_display[$_POST['type']]['call_php_func'](0,$_POST['images'],$_POST['settings'],$_POST['type'],true,true,$_POST['currentid']);
}
$response = array(
    'R'	=> 'OK',
    'RETURN_DATA' => $post_return_data
);

die(json_encode($response));
?>