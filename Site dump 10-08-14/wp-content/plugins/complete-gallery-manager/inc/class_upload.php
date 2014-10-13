<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class cgm_qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
		if(false===$temp){
			$upload_dir = wp_upload_dir();
			$filename = tempnam($upload_dir['path'],'tmp_uload')."<br >";
			$temp = fopen($filename,'w+');		
		}
		$metaDatas = stream_get_meta_data($temp);
		$tmpFilename = $metaDatas['uri'];		
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
		//----- attempt to validate the content.
		$allowed_mime_types = get_allowed_mime_types();
//error_log( print_r($allowed_mime_types,true)."\n",3,ABSPATH.'save.log' );
		if ( ! function_exists( 'wp_check_filetype_and_ext' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$wp_filetype = wp_check_filetype_and_ext( $tmpFilename, $this->getName(), false );
		//extract( $wp_filetype );		
		if(false!==$wp_filetype['proper_filename']){
			fclose($temp);
			return false;
		}
		if ( ( !$wp_filetype['type'] || !$wp_filetype['ext'] )){
			$this->error = __( 'Sorry, this file type is not permitted for security reasons.' );
			fclose($temp);
			return false;
		}
		if( !in_array($wp_filetype['type'],$allowed_mime_types) ){
			$this->error = __( 'Sorry, this file type is not permitted for security reasons.' );
			fclose($temp);
			return false;
		}
		
		if(function_exists('finfo_open')){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
	    	$mime_type = finfo_file($finfo, $tmpFilename);
			finfo_close($finfo);
			if( false!==$mime_type && !in_array($mime_type,$allowed_mime_types) ){
				$this->error = __( 'Sorry, this file type is not permitted for security reasons.' );
				fclose($temp);
				return false;
			}					
		}else if(function_exists('mime_content_type')){
			$mime_type = mime_content_type($tmpFilename);
			if( false!==$mime_type && !in_array($mime_type,$allowed_mime_types) ){
				$this->error = __( 'Sorry, this file type is not permitted for security reasons.' );
				fclose($temp);
				return false;
			}								
		}
		
		//-----
		
        if ($realSize != $this->getSize()){   
			fclose($temp);         
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        fclose($temp);
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            //throw new Exception(__('Getting content length is not supported.','cgm'));
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class cgm_qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class cgm_qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new cgm_qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new cgm_qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        $this->sizeLimit = $uploadSize;
        
        /*if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
			die(json_encode((object)array('error'=>sprintf( __('increase post_max_size and upload_max_filesize to %s','cgm') ,$size))));
			//die("{'error':'".sprintf('increase post_max_size and upload_max_filesize to %s',$size)."'}");    
        } */       
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload( $replaceOldFile = FALSE){
    	global $wpdb,$complete_gallery_manager_plugin,$wp_version;
    
		$upload_dir = wp_upload_dir();
		$uploadDirectory = $upload_dir['path'].'/';
		$uploadUrl = $upload_dir['url'].'/';
        if (!is_writable($uploadDirectory)){
            return array('error' => __("Server error. Upload directory isn't writable.",'cgm') );
        }
        sleep(3);
        if (!$this->file){
            return array('error' => __('No files were uploaded.','cgm') );
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => __('File is empty','cgm') );
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => __('File is too large ','cgm').'(max size: '.(($this->sizeLimit/1024)/1024).'mb)' );
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' =>  sprintf( __('File has an invalid extension, it should be one of %s','cgm') , $these));
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
        
        	$create_scales = $complete_gallery_manager_plugin->cgm_get_image_scalse();
        	$return_img = '';
        	$post_attacement_meta = '';
        
        
        	foreach($create_scales as $key_tmp => $create_scale){
        		$tmp_standart = '';
        		
        		if((float)$wp_version >= 3.5){
					$tmp_standart = wp_get_image_editor( $uploadDirectory . $filename . '.' . $ext ); // Return an implementation that extends <tt>WP_Image_Editor</tt>
					if ( ! is_wp_error( $tmp_standart ) ) {
					    $tmp_standart->resize( $create_scale['width'], $create_scale['height'], $create_scale['crop'] );
					    $tmp_standart->save( $uploadDirectory . $filename .'-'.$create_scale['width'].'x'.$create_scale['height']. '.' . $ext );
	
	
						$tmp_name = $filename .'-'.$create_scale['width'].'x'.$create_scale['height']. '.' . $ext ;
	        			$tmp_size[0] = $create_scale['width'];
	        			$tmp_size[1] = $create_scale['height'];
	        			$tmp_size[2] = $create_scale['crop'];
	        			
	        			
	        			if($key_tmp == 'post-thumbnail'){
		        			$post_attacement_meta['sizes']['thumbnail'] = array('file'=>$tmp_name,
		        															 'width'=>$tmp_size[0],
		        															 'height'=>$tmp_size[1]);
	        			} else if($key_tmp == 'medium-feature'){
		        			$post_attacement_meta['sizes']['medium'] = array('file'=>$tmp_name,
		        															 'width'=>$tmp_size[0],
		        															 'height'=>$tmp_size[1]);
	        			} else if($key_tmp == 'large-feature'){
		        			$post_attacement_meta['sizes']['large'] = array('file'=>$tmp_name,
		        															 'width'=>$tmp_size[0],
		        															 'height'=>$tmp_size[1]);
	        			}
	        		
	        			$post_attacement_meta['sizes'][$key_tmp] = array('file'=>$tmp_name,
	        															 'width'=>$tmp_size[0],
	        															 'height'=>$tmp_size[1]);
	        			$return_img[] = array('name'=>$key_tmp,
	        								  'url'=>$uploadUrl.$tmp_name,
	        								  'filename'=> $filename,
	        								  'width'=>$tmp_size[0],
	        								  'height'=>$tmp_size[1]);
	
	
	
	
					}
        		} else {
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
        	}
        	
        	
        	$tmp_size = '';
        	$tmp_size = getimagesize(($uploadDirectory . $filename . '.' . $ext));
        	

        	$return_img[] = array('name'=>'Full Size',
        						  'url'=>$uploadUrl.$filename . '.' . $ext,
        						  'filename'=>$filename,
        						  'width'=>$tmp_size[0],
        						  'height'=>$tmp_size[1]);
        						  
        				
        	$post_attacement_meta['width'] = $tmp_size[0];			
        	$post_attacement_meta['height'] = $tmp_size[1];	        				
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
     			'post_title' => wp_strip_all_tags($filename),
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
        		
        	}		
        	
        	global $cgm_admin_post_list;
        	
			$return_imgdata = $cgm_admin_post_list->create_template(array('[CLASSTYPE1]'=> $_GET['cqw_list_type'],
												  '[TITLE]'=> $filename,
												  '[CONTENT]'=>	'',
												  '[LINK]'=> get_permalink( $tmp_post_id ),
												  '[POSTID]'=> $tmp_post_id,
												  '[CGM-MAIN_SHOW]'=> true,
												  '[TYPEOBJECT]' => 'image',
												  '[ATTACTEDID]' => '',
												  '[INDEXNUMBER]'=> $_GET['cgm_current_img_selelcted'],
												  '[CATEGORY]'=> ''),false,$_GET['currentid']);
		  
            return array(
				'success'=>true,
				'r_data'=>$return_img,
				'template' =>$return_imgdata
			);
        } else {
            return array('error'=> __('Could not save uploaded file.','cgm') .  __('The upload was cancelled, or server error encountered','cgm') );
        }
        
    }    
}