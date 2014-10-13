<?php

class cgm_options {
	var $screen_title = 'Options';
	var $screen_menu = 'Options';    
	var $plugin_id;
	var $tdom = 'cgm';
	
	function cgm_options($parent_id){
		$this->plugin_id = $parent_id.'-opt';
		add_filter("pop-options_{$this->plugin_id}",array(&$this,'options'),10,1);		
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
    
	function options($t){
        global $wpdb;

		$i = count($t);
		
		if(empty($i)){
			$i = 0;
		}
		
		//-------------------------	Generelle Settings	
		$i++;
		$t[$i] = (object) array();
		$t[$i]->id 			= 'Generalte-settings'; 
		$t[$i]->label 		= __('General Settings','cgm');//title on tab
		$t[$i]->right_label	= __('Input data','cgm');//title on tab
		$t[$i]->page_title	= __('General Settings','cgm');//title on content
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		
		
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));
		
		if(empty($uploadSize)){
			$uploadSize = 100000;
		}
		if(empty($postSize)){
			$postSize = 100000;
		}
		
		 
		
		$temp = array();
		
		$temp[] = (object)array(
				'id'	=> 'overwrite_to_old',
				'type'	=> 'checkbox',
				'label'	=> __('Other Media updater/selector','cgm'),
				'description' => __('If you have problems with the media selector then use the other version','cgm'),
				'el_properties'=>array('style'=>'margin-bottom: 50px;'),
				'save_option'=>true,
				'load_option'=>true
		);
		
		
		
		
		$temp[] = (object)array(
				'id'	=> 'uploadsize',
				'type'	=> 'text',
				'label'	=> __('Upload size','cgm'),
				'default' => $postSize/1024/102,
				'description' => __('The allowed upload file size is set to your servers default. You can decrease the allowed upload file size for Complete Gallery Manager, but if you want to increase it you need to change the file upload size allowed in your servers php.ini.','cgm') . '<br><br>'.'Post max size:' .$postSize/1024/1024 .'mb<br>Upload max filesize: '.$uploadSize/1024/1024,
				'el_properties'=>array('style'=>'width:250px;margin-bottom: 250px;'),
				'save_option'=>true,
				'load_option'=>true
		);
		
		$temp[] = (object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','cgm'),
				'class' => 'button-primary',
				'save_option'=>false,
				'el_properties'=>array('style'=>'width:100%;'),
				'load_option'=>false
			);			
			
		$t[$i]->options = $temp;
		
		
		
	$i++;
		$t[$i] = (object) array();
		$t[$i]->id 			= 'Flickr-settings'; 
		$t[$i]->label 		= __('Flickr Settings','cgm');//title on tab
		$t[$i]->right_label	= __('Account detail','cgm');//title on tab
		$t[$i]->page_title	= __('Flickr Settings','cgm');//title on content
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;

		
		$temp = array();
		$temp[] = (object)array(
				'id'	=> 'flickr_accountname',
				'type'	=> 'text',
				'label'	=> __('Account name','cgm'),
				'description' => __('Add your account name here','cgm'),
				'el_properties'=>array('style'=>'width:250px;margin-bottom: 50px;'),
				'save_option'=>true,
				'load_option'=>true
		);
		
		$temp[] = (object)array(
				'id'	=> 'flickr_apikey',
				'type'	=> 'text',
				'label'	=> __('Api key','cgm'),
				'description' => __('Before we can access your data do we need a api key, you can create it','cgm').' ' . '<a target="_black" href="http://www.flickr.com/services/apps/create/noncommercial/">'.__('here','cgm').'</a><br \><br \>'.__('1. fill out the form with Name ("Complete gallery manager WP"),reason and agree','cgm').'<br \>'.__('2. Submit information and then copy the key here', 'cgm'),
				'el_properties'=>array('style'=>'width:250px;margin-bottom: 50px;margin-left:40px;margin-bottom:90px;'),
				'save_option'=>true,
				'load_option'=>true
		);
		
		$temp[] = (object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','cgm'),
				'class' => 'button-primary',
				'save_option'=>false,
				'el_properties'=>array('style'=>'width:100%;'),
				'load_option'=>false
			);			
			
		$t[$i]->options = $temp;
		
		
$i++;
		$t[$i] = (object) array();
		$t[$i]->id 			= 'reset-settings'; 
		$t[$i]->label 		= __('Reset Settings','cgm');//title on tab
		$t[$i]->right_label	= __('Troubleshooting (Reset Account Details)','cgm');//title on tab
		$t[$i]->page_title	= __('Reset Settings','cgm');//title on content
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;

		
		$temp = array();
		$temp[] = (object)array(
				'id'	=> 'reset_settings',
				'type'	=> 'checkbox',
				'label'	=> __('Reset Account Settings','cgm'),
				'description' => __('Check this option if you experience problems with inserting/uploading images when using WordPress 3.5.x.','cgm'),
				'el_properties'=>array('style'=>'margin-bottom: 50px;'),
				'save_option'=>true,
				'load_option'=>true
		);
		
		$temp[] = (object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','cgm'),
				'class' => 'button-primary',
				'save_option'=>false,
				'el_properties'=>array('style'=>'width:100%;'),
				'load_option'=>false
			);			
			
		$t[$i]->options = $temp;
		
		
		
		
		
		return $t;
	}
}
?>