<?php

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');
require_once(COMPLETE_GALLERY_PATH.'inc/phpFlickr.php');
error_reporting(E_ERROR | E_PARSE);

global $cgm_admin_post_list;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','act'));
}

function cgm_handlePreview($type,$url,$tmpname,$nameid,$decs = ''){
	global $wpdb,$complete_gallery_manager_plugin;
    
	$upload_dir = wp_upload_dir();
	$uploadDirectory = $upload_dir['path'].'/';
	$uploadUrl = $upload_dir['url'].'/';
	
    if (!is_writable($uploadDirectory)){
            return array('error' => __("Server error. Upload directory isn't writable.",'cgm') );
    }

	$filename = $type.$tmpname; 
    $ext = 'jpg';
	$checkresults = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key='_cgm_filename' and meta_value = '".$type.$tmpname."'");
	
	if(!empty($checkresults) && !empty($checkresults[0]->post_id)){
		return array('success'=>true,'postid'=>$checkresults[0]->post_id);
	}	
   
    sleep(3);
    if(file_exists($uploadDirectory . $filename . '.' . $ext)) {
    	$filename .= rand(10, 99);
    }
    
    
    
        
    if (file_put_contents($uploadDirectory . $filename . '.' . $ext, file_get_contents($url))){
        
        	$create_scales = $complete_gallery_manager_plugin->cgm_get_image_scalse();
        	$return_img = '';
        	$post_attacement_meta = '';
        
        
        	foreach($create_scales as $key_tmp => $create_scale){
        		$tmp_standart = '';
        		$tmp_standart = image_resize( ($uploadDirectory . $filename . '.' . $ext), $create_scale['width'],
        									 $create_scale['height'], 
        									 $create_scale['crop']);
        		
        		if(!is_object($tmp_standart)){
        			$tmp_name = basename($tmp_standart);
        			$tmp_size = explode("-", $tmp_name);
        			$tmp_size = explode(".", $tmp_size[(count($tmp_size)-1)]);
        			$tmp_size = explode("x", $tmp_size[(count($tmp_size)-2)]);
        		
        			$post_attacement_meta['sizes'][$key_tmp] = array('file'=>$tmp_name,
        															 'width'=>$tmp_size[0],
        															 'height'=>$tmp_size[1]);
        		
        			$return_img[] = array('name'=>$key_tmp,
        								  'url'=>$uploadUrl.$tmp_name,
        								  'filename'=>$filename,
        								  'width'=>$tmp_size[0],
        								  'height'=>$tmp_size[1]);
        		}
        	}
        	$tmp_size = '';
        	$tmp_size = getimagesize(($uploadDirectory . $filename . '.' . $ext));
        	
        	$return_img[] = array('name'=>'Full Size',
        						  'url'=>$uploadUrl.$filename . $ext,
        						  'filename'=>$filename,
        						  'width'=>$tmp_size[0],
        						  'height'=>$tmp_size[1]);
        						  
        				
        	$post_attacement_meta['width'] = $tmp_size[0];			
        	$post_attacement_meta['height'] = $tmp_size[0];	        				
        	$post_attacement_meta['file'] = $upload_dir['subdir'].'/'.$filename . '.' . $ext;	 
        	        		
        	$post_attacement_meta['image_meta']['aperture'] = 0;
        	$post_attacement_meta['image_meta']['credit'] = '';
        	$post_attacement_meta['image_meta']['camera'] = '';
        	$post_attacement_meta['image_meta']['caption'] = '';
        	$post_attacement_meta['image_meta']['created_timestamp'] = 0;
        	$post_attacement_meta['image_meta']['copyright'] = '';
        	$post_attacement_meta['image_meta']['focal_length'] = 0;
        	$post_attacement_meta['image_meta']['iso'] = 0;
        	$post_attacement_meta['image_meta']['shutter_speed'] = 0;
        	$post_attacement_meta['image_meta']['title'] = '';					  
   						  
        				
  			$my_post = array(
     			'post_title' => wp_strip_all_tags($nameid),
     			'post_content' =>$decs,
     			'post_status' => 'inherit',
     			'post_author' => 1,
     			'post_mime_type' => $tmp_size['mime'],
     			'post_type' =>'attachment',
     			'post_parent' => 0,
     			'guid' => $uploadUrl.$filename . '.' . $ext,
     			'post_name' => wp_strip_all_tags($filename)
  			);
  			
  			$tmp_post_id = wp_insert_post( $my_post );					
        	if(!empty($tmp_post_id)){
        		update_post_meta($tmp_post_id, '_wp_attached_file', $upload_dir['subdir'].'/'.$filename . '.' . $ext);
        		update_post_meta($tmp_post_id, '_wp_attachment_metadata', $post_attacement_meta);
        		update_post_meta($tmp_post_id, '_cgm_filename', $type.$tmpname);
        		
        	}		
            return array('success'=>true,'postid'=>$tmp_post_id);
    } else {
        return array('error'=> __('Could not save preview image.','cgm') .  __('The preview image was cancelled, or server error encountered','cgm') );
    }
    
}    

function cgm_handle_flickr_data($tmp_image){
	global $flickr_api;
	
	$tmp_data = $flickr_api->photos_getInfo($tmp_image);
	if(empty($tmp_data)){
		return array();
	}
	$tmp_data = $tmp_data['photo'];
	$return_array = array();
	
	$return_array[0] = $flickr_api->buildPhotoURL($tmp_data,'large');
	$return_array[1] = strip_tags($tmp_data['title']);
	$return_array[2] = strip_tags($tmp_data['description']);
	$return_array[3] = $tmp_data['urls']['url'][0]['_content'];	

	return $return_array;
}



if($_POST['cqw_list_type'] != 'grid'){
	$CLASSTYPE1 = 'object-listtype1';	 	
} else if($_POST['cqw_list_type'] == 'grid'){
	$CLASSTYPE1 = 'object-gridtype1';	 	
}

$result = '';
$count = $_POST['cgm_current_img_selelcted'];
$temp_count = 0;


if(!empty($_POST['cgm_load_id_list'])){
	global $flickr_api;
	$cgm_options = get_option('cgm_options');
	$flickr_api = new phpFlickr($cgm_options['flickr_apikey']);

	$tmp_id_array = explode(",", $_POST['cgm_load_id_list']);

	if(!empty($tmp_id_array)){
		foreach($tmp_id_array as $tmp_id_array_single){
			$url_return = cgm_handle_flickr_data($tmp_id_array_single);
			
			$temp_data = array();
			$temp_data_id = '';
			
			if(!empty($url_return)){
				$temp_data = cgm_handlePreview('flickr',$url_return[0],$tmp_id_array_single,$url_return[1],$url_return[2]);
				$temp_data_id = $temp_data['postid'];
			}


			if(!empty($temp_data_id)){
					$result .= $cgm_admin_post_list->create_template(array('[CLASSTYPE1]'=> $CLASSTYPE1,
															  '[TITLE]'=>$url_return[1],
															  '[CONTENT]'=>	$url_return[2],
															  '[LINK]'=>$url_return[3],
															  '[POSTID]'=> $temp_data_id,
															  '[CGM-MAIN_SHOW]'=> true,
															  '[INDEXNUMBER]'=> $count,
															  '[TYPEOBJECT]' => 'flickr',
															  '[ATTACTEDID]' => '',
															  '[CATEGORY]'=> ''),false,$_POST['currentid']);
			
					$count++;
					$temp_count++;
			}
		}
	}
}
$result= array('R'=>'OK','DATA' => $result,'COUNT' => $count,'TEMPCOUNT'=>$temp_count);
echo json_encode($result);	 
?>