<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');
require_once(COMPLETE_GALLERY_PATH.'inc/class_upload.php');


function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','act'));
}
  
$allowedExtensions = array();

$uploader = new cgm_qqFileUploader($allowedExtensions);
$result = $uploader->handleUpload();
echo json_encode($result);	 
?>