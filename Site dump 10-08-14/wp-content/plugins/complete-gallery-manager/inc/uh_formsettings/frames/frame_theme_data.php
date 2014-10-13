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

$cgm_loop_count = -1;
$cgm_loop_array = array();

$cgm_loop_array_total = array();

function cgm_loopfunction($tmp_array){
	global $cgm_loop_count,$cgm_loop_array,$cgm_loop_array_total;
	$cgm_loop_count++;
	if(!empty($tmp_array)){
		foreach($tmp_array as $tmp_key => $tmp_data){
			if($cgm_loop_count == 0){
				$tmp_key = substr($tmp_key, 4);
			}
		
			if(is_array($tmp_data)){
				$cgm_loop_array[$cgm_loop_count] = $tmp_key;
				cgm_loopfunction($tmp_data);
			} else {
				$tmp = '';
				for($i=0;$i<$cgm_loop_count;$i++){
					$tmp .= $cgm_loop_array[$i] . '__';
				}
				$cgm_loop_array_total[$tmp . $tmp_key] = $tmp_data;
				
			}
			
		}
		$cgm_loop_count--;
	}
}


function cgm_loopupdateall(){
	global $cgm_loop_array_total,$wpdb;
	
	
	$check_for_others = $wpdb->get_results( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key='cgm_flag' and meta_value='".$_POST['tslider']."' group by post_id" );
	
	
	if(!empty($check_for_others)) {
		foreach($check_for_others as $tmp_t_data){
			if(!empty($_POST['cgm_post_id']) and $_POST['cgm_post_id'] == $tmp_t_data){
			} else {
				$checkcgm_data = get_post_meta($tmp_t_data, 'cgm_data', true); 
				if(!empty($checkcgm_data) and $checkcgm_data['templatetype_'.$_POST['tslider']] == $_POST['tname'] and !empty($_POST['tname'])){					
						update_post_meta($tmp_t_data, 'cgm_data', $cgm_loop_array_total); 
				}
			}
			
		}
	}
}




if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','cgw'));
}

if(empty($_POST['tname']) || empty($_POST['tslider']) || empty($_POST['tsettings']) ){
	send_error_die(__('Error in resiving data','cgw'));		
}

if($_POST['tstatus'] == 'savenewfile'){
	$tmp_array = get_option('cgm-templatetypelist_'.$_POST['tslider']);
	
	if(!empty($tmp_array[$_POST['tname']])){
		send_error_die(__('Error the template name have already been used','cgw'));		
	}
	
	global $cgm_loop_array_total;

	cgm_loopfunction(json_decode(urldecode( $_POST['tsettings']),true));

	$tmp_array[$_POST['tname']] = $cgm_loop_array_total;
	arsort($tmp_array);
	update_option('cgm-templatetypelist_'.$_POST['tslider'],$tmp_array);
	$temp_array2 = '';
	
	if(!empty($tmp_array)){
		foreach($tmp_array as $ttmmpp_key => $ttmmpp_data){
			$temp_array2 .= '<option value="'.$ttmmpp_key.'">'.$ttmmpp_key.'</option>';
		}
	}

	
	die(json_encode(array('R'=>'OK','DATA'=>$temp_array2,'MSG'=>'The template has been saved '.$_POST['tname'])));
	
} else if($_POST['tstatus'] == 'savewriteower'){
	$tmp_array = get_option('cgm-templatetypelist_'.$_POST['tslider']);


	global $cgm_loop_array_total;

	cgm_loopfunction(json_decode(urldecode( $_POST['tsettings']),true));
	cgm_loopupdateall();

	$tmp_array[$_POST['tname']] = $cgm_loop_array_total;
	update_option('cgm-templatetypelist_'.$_POST['tslider'],$tmp_array);
	
	die(json_encode(array('R'=>'OK','MSG'=>'The template has been updated '.$_POST['tname'])));
	
} else if($_POST['tstatus'] == 'delete'){
	$tmp_array = get_option('cgm-templatetypelist_'.$_POST['tslider']);

	unset($tmp_array[$_POST['tname']]);
	update_option('cgm-templatetypelist_'.$_POST['tslider'],$tmp_array);
	
	die(json_encode(array('R'=>'OK','MSG'=>'The template '.$_POST['tname'] .' has been delete')));
} else if($_POST['tstatus'] == 'loaddata'){


	$tmp_array = get_option('cgm-templatetypelist_'.$_POST['tslider']);
	die(json_encode(array('R'=>'OK','DATA'=> $tmp_array[$_POST['tname']])));
} else {
	send_error_die(__('Error no action has been resived','cgw'));	
}



?>