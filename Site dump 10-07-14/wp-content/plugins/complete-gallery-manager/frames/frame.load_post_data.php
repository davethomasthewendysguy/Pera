<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');


require_once(COMPLETE_GALLERY_PATH.'inc/uh_formsettings/formsettings.php');
$content_data = "";
global $wpdb,$complete_gallery_display;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','evt'));
}

if(!isset($_POST['post_id'])){
	send_error_die(__('No post id are received','evt'));
}

if(!isset($_POST['type'])){
	send_error_die(__('No types are received','evt'));
}

$post_data_set = '';
$post_custom = '';
$post_custom_data = '';
$post_option_data = '';
$post_eximg_data = '';


$call_js_file = '';
$call_js_func= '';
$call_php_file = '';
$call_php_func = '';

if(!empty($complete_gallery_display)){
	$complete_gallery_d = $complete_gallery_display[$_POST['type']];
	if(!empty($complete_gallery_d) and $complete_gallery_d['type'] == $_POST['type']){
		if(!empty($complete_gallery_d['call_js_file'])){
			$call_js_file = $complete_gallery_d['call_js_file'];
		}
		if(!empty($complete_gallery_d['call_js_func'])){
			$call_js_func = $complete_gallery_d['call_js_func'];
		}
		
		if(!empty($complete_gallery_d['call_php_file'])){
			$call_php_file = $complete_gallery_d['call_php_file'];
		}
			
		if(!empty($complete_gallery_d['call_php_func'])){
			$call_php_func = $complete_gallery_d['call_php_func'];
		}
			
		if(!empty($complete_gallery_d['option'])){
			$post_option_data = $complete_gallery_d['option'];
		}
		if(!empty($complete_gallery_d['packages'])){
			$post_packages = $complete_gallery_d['packages'];
		}
	}
}


$form_setting_test = new uh_form_structure('cgm','cgm_preview',$_POST['post_id']);

$post_custom = get_post_custom($_POST['post_id']);
if(!empty($post_custom['cgm_data'][0])){
	$post_custom = json_decode($post_custom['cgm_data'][0],true);
}

if(!empty($post_option_data)){
	foreach($post_option_data as $key => $tmps){
		$tmp_data_save1 = '';
		if(!empty($post_custom) && !empty($tmps['name']) && !empty($post_custom[$tmps['name']])){
			$tmp_data_save1 = $post_custom[$tmps['name']];	
		}
		$post_data_set .= $form_setting_test->create_form($tmps,$key,$tmp_data_save1);
	}
}



if(!empty($post_custom["cgm_flag"])){
  	$custom_flag = $post_custom["cgm_flag"][0];
} else {
  	$custom_flag = '';
}

$response = array(
    'R'	=> 'OK',
    'DATA_SET' => $post_data_set,
    'TYPE' => $_POST['type'],
    'CORE' => $post_packages,
    'FLAG' => $custom_flag,
    'CALLJSFILE' =>$call_js_file,
    'CALLJSFUNC' => $call_js_func,
    'CALLPHPFILE' => $call_php_file,
    'CALLPHPFUNC' => $call_php_func
);

die(json_encode($response));
?>