<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

global $wpdb,$evt_class_run;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

function cgm_dublicate_post_meta_all($current_id,$new_id){
	global $wpdb;
	    $wpdb->query("
		SELECT `meta_key`, `meta_value`
		FROM $wpdb->postmeta
		WHERE `post_id` = $current_id
	");
	foreach($wpdb->last_result as $v){
	    update_post_meta($new_id, $v->meta_key, $v->meta_value);
	};
}

    
function cgm_duplicate_post_create_duplicate($post_id) {
	if(!empty($post_id)){
		$post = get_post($post_id); 
		$new_post = array(
				'menu_order' => $post->menu_order,
				'comment_status' => $post->comment_status,
				'ping_status' => $post->ping_status,
				'pinged' => $post->pinged,
				'post_author' => $post->post_author,
				'post_content' => $post->post_content,
				'post_date' => $post->post_date,
				'post_excerpt' => $post->post_excerpt,
				'post_parent' => $post->post_parent,
				'post_password' => $post->post_password,
				'post_status' => $post->post_status,
				'post_title' => $post->post_title . ' (duplicate)',
				'post_type' => $post->post_type,
				'to_ping' => $post->to_ping 
		);
		$new_post_id = wp_insert_post($new_post);
			
		cgm_dublicate_post_meta_all($post_id,$new_post_id);
			
		return 'Post id '.$post_id.' has been duplicate to id '.$new_post_id;
	} else {
		return 'No id data';
	}
}


if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','evt'));
}

if(!isset($_POST['post_id'])){
	send_error_die(__('No post id are received','evt'));
}


$msg = cgm_duplicate_post_create_duplicate($_POST['post_id']);
 
$response = array(
    'R'	=> 'OK',
    'MSG' => $msg
);

die(json_encode($response));
?>