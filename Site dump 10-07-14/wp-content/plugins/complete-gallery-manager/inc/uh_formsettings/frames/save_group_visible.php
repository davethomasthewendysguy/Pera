<?php
ob_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../../../wp-load.php');

$content = ob_get_contents();
ob_end_clean();

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','cgw'));
}

if(!isset($_POST['tmp_id']) || !isset($_POST['cgw_group_hide']) ){
	send_error_die(__('No data retrieved.','cgw'));
}


$current_user = wp_get_current_user(); 
$array = get_user_meta($current_user->ID,'cgw_show_hide_settings',true);
if(!empty($_POST['tmp_id'])){
	$array[$_POST['tmp_id']] = $_POST['cgw_group_hide'];
	
	update_user_meta( $current_user->ID,'cgw_show_hide_settings', $array);
}
?>