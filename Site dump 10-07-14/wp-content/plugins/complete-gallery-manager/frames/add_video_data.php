<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

error_reporting(E_ERROR | E_PARSE);

global $cgm_admin_post_list;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','act'));
}


function cgm_video_image_retrive_data($url){
	$image_url = parse_url($url);

	if($image_url['host'] == 'www.youtube.com' || $image_url['host'] == 'youtube.com' || $image_url['host'] == 'youtu.be'){
		$query = array();
		parse_str($image_url['query'], $query);

		if(empty($query) && empty($query['v'])){
			$tmp_array = explode('/', $image_url['path']);
		
			if(count($tmp_array) == 2){
				$query['v'] = $tmp_array[1];
			}
		}

		if(empty($query) && empty($query['v'])){
			return array('');
		} else {
		$tmpurl = "http://gdata.youtube.com/feeds/api/videos/". $query['v'];
		$doc = new DOMDocument;
		$doc->load($tmpurl);


		$title = $query['v'];
		$description = '';
		if(!empty($doc)){
			
			if(!empty($doc->getElementsByTagName("title")->item(0)->nodeValue)){
				$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;	
			}
			if(!empty($doc->getElementsByTagName("content")->item(0)->nodeValue)){
				$description = $doc->getElementsByTagName("content")->item(0)->nodeValue;	
			}
		}
		return array('youtube',"http://img.youtube.com/vi/".$query['v']."/0.jpg",$query['v'],strip_tags($title),strip_tags($description),'');

		}
	} else if($image_url['host'] == 'www.vimeo.com' || $image_url['host'] == 'vimeo.com' || $image_url['host'] == 'player.vimeo.com'){
	
		$urlnumber = substr($image_url['path'], 1);
		$urlnumber = str_replace('video/','',$urlnumber);
		
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$urlnumber.".php"));

		$title = $urlnumber;
		$description = '';

		if(!empty($hash[0]['title'])){
			$title = $hash[0]['title'];
		}
		if(!empty($hash[0]['description'])){
			$description = $hash[0]['description'];
		}
		
		if(!empty($hash[0]["thumbnail_large"])){
			return array('vimeo',$hash[0]["thumbnail_large"],$urlnumber,strip_tags($title),strip_tags($description),'http://vimeo.com/'.$urlnumber);
		} else if($hash[0]["thumbnail_medium"]){
			return array('vimeo',$hash[0]["thumbnail_medium"],$urlnumber,strip_tags($title),strip_tags($description),'http://vimeo.com/'.$urlnumber);
		} else {
			return array('vimeo',$hash[0]["thumbnail_small"],$urlnumber,strip_tags($title),strip_tags($description),'http://vimeo.com/'.$urlnumber);
		}
	}

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





if($_POST['cqw_list_type'] != 'grid'){
	$CLASSTYPE1 = 'object-listtype1';	 	
} else if($_POST['cqw_list_type'] == 'grid'){
	$CLASSTYPE1 = 'object-gridtype1';	 	
}

$result = '';
$count = $_POST['cgm_current_img_selelcted'];

if(!empty($_POST['videoURL'])){
	$url_return = cgm_video_image_retrive_data($_POST['videoURL']);
	$_POST['datatype'] = $url_return[0];

	if(empty($url_return[1]) && empty($_POST['listDataImage'])){
	
		$result= array('R'=>'ERROR','MSG' => 'The system cannot add a preview image automatically. This can be due to the privacy settings on the video.
Click OK and then add a preview image manually and then insert the video.');
		die(json_encode($result));		
	}





	if(empty($_POST['listDataImage'])){
		$_POST['listDataImage'] = cgm_handlePreview($url_return[0],$url_return[1],$url_return[2],$url_return[3],$url_return[4]);
		$_POST['listDataImage'] = $_POST['listDataImage']['postid'];	
	}
	if(!empty($url_return[5])){
		$_POST['videoURL'] = $url_return[5];	
	}


	if(!empty($_POST['listDataImage'])){
			$result .= $cgm_admin_post_list->create_template(array('[CLASSTYPE1]'=> $CLASSTYPE1,
													  '[TITLE]'=>$url_return[3],
													  '[CONTENT]'=>	$url_return[4],
													  '[LINK]'=>$_POST['videoURL'],
													  '[POSTID]'=> $_POST['listDataImage'],
													  '[CGM-MAIN_SHOW]'=> true,
													  '[INDEXNUMBER]'=> $count,
													  '[TYPEOBJECT]' => $_POST['datatype'],
													  '[ATTACTEDID]' => '',
													  '[CATEGORY]'=> ''),false,$_POST['currentid']);
	
			$count++;	
	}

}
$result= array('R'=>'OK','DATA' => $result);
echo json_encode($result);	 
?>