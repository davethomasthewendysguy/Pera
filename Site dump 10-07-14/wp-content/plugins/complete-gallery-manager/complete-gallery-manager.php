<?php
/**
Plugin Name: Complete Gallery Manager for Wordpress
Plugin URI: http://plugins.righthere.com/complete-gallery-manager/
Description: Complete Gallery Manager for WordPress is an exquisite jQuery plugin for creating magical galleries with Images, Posts, Pages and Videos. This is an incredible versatile plugin, which lets you create amazing looking galleries very easily. From simple fully responsive galleries or with infinite scroll, with this plugin it is very easy.
Version: 3.3.7 rev42213
Author: Rasmus R. Sorensen (RightHere LLC)
Author URI: http://plugins.righthere.com
**/


define("CGM_VERSION",'3.3.7');
define("CGM_SLUG", plugin_basename( __FILE__ ) );

define("COMPLETE_GALLERY_PATH", ABSPATH . 'wp-content/plugins/' . basename(dirname(__FILE__)).'/' ); 
define("COMPLETE_GALLERY_URL", trailingslashit(get_option('siteurl')) . 'wp-content/plugins/' . basename(dirname(__FILE__)) . '/' ); 

global $complete_gallery_display;
	   $complete_gallery_display = '';
	   
require_once COMPLETE_GALLERY_PATH.'inc/touch_generator.php';
require_once COMPLETE_GALLERY_PATH.'inc/isotope_generator.php';
require_once(COMPLETE_GALLERY_PATH.'inc/install.php'); 

register_activation_hook(__FILE__, 'cgm_install_capabilities2');





class complete_gallery_manager_plugin { 
	var $id = 'cgm';
	var $tmp_folder  = 'cgm';
	var $tmp_file = 'css.css';
	var $plugin_page; 
	var $menu_name;
	var $gallery_count_id = 0;
	var $gallery_script_load = array();
	var $gallery_css_load = array();
	var $short_code_name = 'complete_gallery';


		function custom_upload_mimes ( $existing_mimes=array() ) {
		$existing_mimes['ibooks'] = 'application/x-ibooks+zip'; 
		return $existing_mimes;
		}



	function complete_gallery_manager_plugin(){
		$this->menu_name = __('CGM Settings','cgm');
		require_once(COMPLETE_GALLERY_PATH.'inc/isotope_settings.php');
		require_once(COMPLETE_GALLERY_PATH.'inc/touch_settings.php');
		
		add_action("plugins_loaded", array(&$this,"plugins_loaded") );	
		add_action("admin_menu", array(&$this,"admin_menu") );
		
		add_action('init', array(&$this,"my_theme_scripts") );
		add_filter('upload_mimes', array(&$this,"custom_upload_mimes"));
		
		if(is_admin()){
			require_once COMPLETE_GALLERY_PATH.'options-panel/load.pop.php';
			rh_register_php('options-panel',COMPLETE_GALLERY_PATH.'options-panel/class.PluginOptionsPanelModule.php', '2.3.2');
		}
	}
	
	function admin_menu(){
		if(is_admin() && (current_user_can('manage_options') || current_user_can('cgm_create_gallery'))){         
            add_menu_page( $this->menu_name, 
            			   $this->menu_name, 
            			   'cgm_create_gallery', 
            			   ($this->id.'-start'), 
            			   array(&$this,'get_started_options'), 
            			   COMPLETE_GALLERY_URL.'images/cgm.png' );
            			   
            $this->plugin_page = add_submenu_page(($this->id.'-start'),
            									  __("Get Started",'cgm'), 
            									  __("Get Started",'cgm'), 
            									  'cgm_create_gallery',
            									  ($this->id.'-start'), 
            									  array(&$this,'get_started_options') );
            
            
            add_action( 'admin_head-'. $this->plugin_page,array(&$this,'get_started_options_head') );
            		    
        	do_action(($this->id.'-options-menu'));
        	
        	
			if(current_user_can('manage_options') || current_user_can('cgm_insert_gallery')){         	
            	require_once COMPLETE_GALLERY_PATH.'admin/TinyMCE-extra-button.php';
            	new cgm_tinymce_extra_button();
            }
		}
	}
	
	
	function my_theme_scripts() {
		wp_enqueue_script( "jquery" ); 
		wp_enqueue_script( "jquery-effects-pulsate" );
	}   

    function plugins_loaded(){
    	cgm_install_capabilities();

    	add_action('wp_head', array(&$this,'wpheader'));	

        $this->create_sub_menu();
        add_shortcode($this->short_code_name, array(&$this,'do_shortcode'));
        add_filter('widget_text', 'do_shortcode');
    }	
    
    
	function wpheader(){
		echo '<link rel="stylesheet" type="text/css" href="'.COMPLETE_GALLERY_URL.'css/prettyPhoto.css" />';
	}
    
	function create_sub_menu(){ 	
		global $cgm_admin_post_list;
		require_once COMPLETE_GALLERY_PATH.'admin/admin_post_list.php';		 	
		$cgm_admin_post_list = new cgm_admin_post_list($this->id);
		
		if(is_admin() && (current_user_can('cgm_create_gallery') || current_user_can('cgm_options') ||  current_user_can('cgm_license') ||  current_user_can('manage_options'))){

			$settings = array(
				'id'					=> $this->id.'-opt',
				'plugin_id'				=> $this->id,
				'menu_id'				=> $this->id.'-opt',
				'capability'			=> 'cgm_options',
				'capability_license'	=> 'cgm_license',
				'options_varname'		=> 'cgm_options',
				'page_title'			=> __('Options','cgm'),
				'menu_text'				=> __('Options','cgm'),
				'option_menu_parent'	=> ($this->id.'-start'),
				'options_panel_version'	=> '2.3.2',
				'notification'			=> (object)array(
					'plugin_version'=>  CGM_VERSION,
					'plugin_code' 	=> 'CGM',
					'message'		=> __('Complete gallery manager update %s is available!','cgm').' <a href="%s">'.__('Please update now','cgm')
				),
				'registration' 		=> true,
				'theme'					=> false,
				'import_export'  		=> false,
				'import_export_options' => false,
				'pluginslug'	=> CGM_SLUG,
				'api_url' 		=> "http://plugins.righthere.com"
				);	
			
			do_action('rh-php-commons');		
			new PluginOptionsPanelModule($settings);
		 	
            require_once COMPLETE_GALLERY_PATH.'admin/option.panel.php';
            new cgm_options($this->id);
		}
	}	
	
	
	function do_shortcode($atts) {
		global $complete_gallery_display;

		$post_id = '';
		if(!empty($atts['id'])){
			$post_id = $atts['id'];
		}

		
		$return_content = '';
		
		if(!empty($post_id)){
			
			$temp_custom_field = get_post_custom($post_id);
			
			if(!empty($temp_custom_field["cgm_flag"][0])){
				$cgm_flag = $temp_custom_field["cgm_flag"][0];	
				$cgm_settings = $temp_custom_field["cgm_settings"][0];
				$cgm_width  = $temp_custom_field["cgm_width"][0];
				$cgm_height = $temp_custom_field["cgm_height"][0];	
	
				$return_content .= '<div id="completegallery'.$this->gallery_count_id.'" ';
				$return_content .='style="overflow:visible;';
				
				if(!empty($atts['style'])){
					$return_content .= $atts['style'];
				}
				
				if(!empty($cgm_width) and $cgm_width > 0){
					$return_content .= ' width:'.$cgm_width.'px ';
				} else {
					$return_content .= ' width:100% ';
				}
				
				if(!empty($cgm_height) and $cgm_height > 0){
					$return_content .= ' height:'.$cgm_height.'px ';
				}
										
				$return_content .='" class="completegallery completegallery'.$post_id.' ';
				if(!empty($atts['class'])){
					$return_content .= $atts['class'].' ';
				}
				$return_content .='"';
				
				$return_content .= '>';
				
				
				$tmp_ext = array();
				
				$tmp_externcontroles = array('catID','sort','sortDir','layout');

				foreach($tmp_externcontroles as $tmp_extcontrole){
					if(!empty($_REQUEST['cgm_'.$tmp_extcontrole]) or !empty($atts[strtolower($tmp_extcontrole)])){
						if(!empty($_REQUEST['cgm_'.$tmp_extcontrole])){
							$tmp_ext[$tmp_extcontrole] = $_REQUEST['cgm_'.$tmp_extcontrole];
						} else if(!empty($atts[strtolower($tmp_extcontrole)])){
							$tmp_ext[$tmp_extcontrole] = $atts[strtolower($tmp_extcontrole)];
						}
						
						if(!empty($tmp_ext[$tmp_extcontrole]) && !empty($tmp_extcontrole) && $tmp_extcontrole == 'catID'){
							$tmp_ext[$tmp_extcontrole] = intval($tmp_ext[$tmp_extcontrole]);
						}
					}
				}
				
				
				$tmp_ext = urlencode(json_encode($tmp_ext));

				if($cgm_flag != 'isotope'){
					$return_content .= $this->generate_loader($cgm_settings);
				}
				if(!empty($cgm_flag)) {		
		   			foreach($complete_gallery_display[$cgm_flag]['class_js'] as $tmp_js_key =>  $tmp_js ){ 
						if(empty($this->gallery_script_load[$tmp_js_key])){
			   				if(empty($tmp_js)){
			   					wp_enqueue_script( $tmp_js_key ); 
			   				} else {
			   					if(substr($tmp_js_key, 0, 1) == '*'){
			   						$return_content .= '<script src="'.$tmp_js.'" type="text/javascript"></script>';
			   					} else {
			    					wp_register_script( $tmp_js_key, $tmp_js, array(), '1.0',false);
			    					wp_enqueue_script( $tmp_js_key ); 
			    				}
			   				}
			   				$this->gallery_script_load[$tmp_js_key] = true;
			   			}
		  			 }
		  			 
		   			foreach($complete_gallery_display[$cgm_flag]['class_css'] as $tmp_css_key =>  $tmp_css ){ 
						if(empty($this->gallery_css_load[$tmp_css_key])){
		    				wp_register_style( $tmp_css_key, $tmp_css);
		    				wp_enqueue_style( $tmp_css_key ); 
		    				$this->gallery_css_load[$tmp_css_key] = true;		
		    			}	
		  			}		 
				
					if(!empty($cgm_settings) and !empty($cgm_flag)){
						if(!empty($complete_gallery_display[$cgm_flag]['call_js_func'])){
						
							$tmp = COMPLETE_GALLERY_URL;
							$tmp = str_replace("https", "http", $tmp);
						
							$return_content .= '<script type="text/javascript">';
							$return_content .= 'jQuery(document).ready(function($){';
							$return_content .= $complete_gallery_display[$cgm_flag]['call_js_func'].'('.$this->gallery_count_id.',\''.$cgm_settings.'\','.$post_id.',\''.$tmp.'\',false,\''.$tmp_ext.'\');';
							$return_content .=	'});</script>';
						}
					}
					
					if($cgm_flag == 'isotope'){
						global $$complete_gallery_display[$cgm_flag]['class_php'];
						$cgm_gallery_data = get_post_meta($post_id, "cgm-gallery-data",true);
						echo '<div style="display:none;" id="cgmtemp'.$this->gallery_count_id.'">'.$$complete_gallery_display[$cgm_flag]['class_php']->$complete_gallery_display[$cgm_flag]['call_php_func']($this->gallery_count_id,$cgm_gallery_data,$cgm_settings,$cgm_flag,false,false,$post_id,$tmp_ext).'</div>';
					}
					
					
				}
	
				$return_content .= '</div>';
			}
		}
		//$return_content .= '<div class="clear" style="clear:both;"></div>';
		$this->gallery_count_id += 1;
     	return $return_content;
	}
	
	function generate_loader($tmp){
		$tmp = json_decode(urldecode($tmp));
		
		$return_content = '';
		if(!empty($tmp->cgm_preloader) and !empty($tmp->cgm_preloader->show)){
			$tmp_css = $this->CSS_generator($tmp->cgm_preloader);
			
			if(!empty($tmp->cgm_preloader->prewidth)){
				$tmp_css .= 'width:'.$tmp->cgm_preloader->prewidth.'px;';
			} else {
				$tmp_css .= 'width:100%;';	
			}
			
			if(!empty($tmp->cgm_preloader->posalign)){
				if($tmp->cgm_preloader->posalign == 'center'){
					$tmp_css .= 'margin:auto;';
				} else if($tmp->cgm_preloader->posalign == 'right'){
					$tmp_css .= 'margin-left:auto;';
				}
			}
			
			if(!empty($tmp->cgm_preloader->textalign)){
				$tmp_css .= 'text-align:'.$tmp->cgm_preloader->textalign.';';	
			}
			
			if(!empty($tmp->cgm_preloader->fontSize)){
				$tmp_css .= 'line-height:'.($tmp->cgm_preloader->fontSize).'px;';	
			}
			
			
			$randomid = 'preloader_'.rand();
			
			$return_content .= '<div id="'.$randomid.'" style="'.$tmp_css.'" >';
			
			$return_content .= '<span>';
			

				if(!empty($tmp->cgm_preloader->loadingText)){
					$return_content .= $tmp->cgm_preloader->loadingText;		
				}

			$return_content .= '</span>';
			$return_content .= '</div>';
			
			$return_content .= '<script type="text/javascript">jQuery(document).ready(function($){jQuery("#'.$randomid.' span").effect("pulsate", { times:10 }, 4000);})</script>';
			
			
		} else {
			$tmp = '';
		}
		return $return_content;
	}
	
	function CSS_generator($tmp){
		$tmp_css = '';
		if(!empty($tmp)){	
			if(!empty($tmp->fontSize)){$tmp_css .= 'font-size:'.$tmp->fontSize.'px !important;';}
			if(!empty($tmp->textColor)){$tmp_css .= 'color:'.$tmp->textColor.' !important;';}	
			if(!empty($tmp->family)){$tmp_css .= 'font-family:'.$tmp->family.' !important;';}	
			if(!empty($tmp->lineHeigh)){$tmp_css .= 'line-heigh: '.$tmp->lineHeigh.'px !important;';}					
			if(!empty($tmp->underline)){$tmp_css .= 'text-decoration: underline !important;';} else {
				$tmp_css .= 'text-decoration: none !important;';}	
			
			if(!empty($tmp->bold)){$tmp_css .= 'font-weight: bold !important;';} else {
				$tmp_css .= 'font-weight: normal !important;';}	
			
			if(!empty($tmp->italic)){$tmp_css .= 'font-style:italic !important;';} else {
				$tmp_css .= 'font-style:none !important;';}	
			
			
			if(!empty($tmp->opacity)){$tmp_css .= 'opacity:'.$tmp->opacity.' !important;';}
			if(!empty($tmp->margin)){$tmp_css .= 'margin:'.$tmp->margin.' !important;';}
			if(!empty($tmp->padding)){$tmp_css .= 'padding:'.$tmp->padding.' !important;';}	
			if(!empty($tmp->borderColor)){$tmp_css .= 'border-color:'.$tmp->borderColor.' !important;';}
			if(!empty($tmp->borderWidth)){$tmp_css .= 'border-width:'.$tmp->borderWidth.'px !important;';}
			if(!empty($tmp->borderRadius)){$tmp_css .= 'border-radius:'.$tmp->borderRadius.'px !important;';}		
			if(!empty($tmp->borderStyle)){$tmp_css .= 'border-style:'.$tmp->borderStyle.' !important;';}
			if(!empty($tmp->backgroundColor)){$tmp_css .= 'background-color:'.$tmp->backgroundColor.' !important;';}
			
			
			$boxshadowopacity = 0;
			$boxshadowcolor = '#';
		
			if(!empty($tmp->boxShadowOpacity)){$boxshadowopacity = $tmp->boxShadowOpacity;}
			if(!empty($tmp->boxShadowColor)){$boxshadowcolor = $tmp->boxShadowColor;}
			
			if(!empty($boxshadowopacity) and !empty($boxshadowcolor) and $boxshadowcolor != '#'){
				$boxShadowX = 0;
				$boxShadowY = 0;
				$boxShadowBlue = 0;
				
				$tmp_css .= 'box-shadow: '; 

				if(!empty($tmp->boxShadowX)){$boxShadowX = $tmp->boxShadowX;}
				if(!empty($tmp->boxShadowY)){$boxShadowY = $tmp->boxShadowY;}
				
				if(!empty($tmp->boxShadowBlue)){$boxShadowBlue = $tmp->boxShadowBlue;}
				
				$tmp_css .= $boxShadowX.'px ';
				$tmp_css .= $boxShadowY.'px ';
				$tmp_css .= $boxShadowBlue.'px ';
				
			$shadowrbg = $this->HexToRGB(str_replace('#','',$boxshadowcolor));
				$tmp_css .= ' rgba('.$shadowrbg['r'].','.$shadowrbg['g'].','.$shadowrbg['b'].','.$boxshadowopacity.') '; 
				
				if(!empty($tmp->boxShadowNoInter) && $tmp->boxShadowNoInter){
					$tmp_css .= '!important;';
				} else {
					$tmp_css .= 'inset !important;';
				}
				
				
				
			} else {
				$tmp_css .= 'box-shadow: none !important;';
				
			}	
			
			
			
			$textshadowopacity = 0;
			$textshadowcolor = '#';
		
			if(!empty($tmp->textShadowOpacity)){$textshadowopacity = $tmp->textShadowOpacity;}
			if(!empty($tmp->textShadowColor)){$textshadowcolor = $tmp->textShadowColor;}
			
			if(!empty($textshadowopacity) and !empty($textshadowcolor) and $textshadowcolor != '#'){
				$shadowrbg = $this->HexToRGB(str_replace('#','',$textshadowcolor));
				$tmp_css .= 'text-shadow: rgba('.$shadowrbg['r'].','.$shadowrbg['g'].','.$shadowrbg['b'].','.$textshadowopacity.') '; 
				$textShadowX = 0;
				$textShadowY = 0;
				$textShadowBlue = 0;
				
				if(!empty($tmp->textShadowX)){$textShadowX = $tmp->textShadowX;}
				if(!empty($tmp->textShadowY)){$textShadowY = $tmp->textShadowY;}
				
				if(!empty($tmp->textShadowBlue)){$textShadowBlue = $tmp->textShadowBlue;}
				
				$tmp_css .= $textShadowX.'px ';
				$tmp_css .= $textShadowY.'px ';
				$tmp_css .= $textShadowBlue.'px ';
				
				$tmp_css .= ' !important;';
			} else {
				$tmp_css .= 'text-shadow: none !important;';
				
			}	
		}	
		
		return $tmp_css;
	}
	
	
	
	function HexToRGB($hex) {
		$hex = str_replace("#", "", $hex);
		$color = array();
 
		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		} else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
 
		return $color;
	}
	
	
	function globalt_shorcode_generator($array_datas){
		$return_content = '['.$this->short_code_name.' ';
		
		if(!empty($array_datas)){
			foreach($array_datas as $key => $array_data){
				$return_content .= $key . '="'.$array_data.'" ';			
			}
		}
		
		$return_content .= ']';
		
		return $return_content;
	}
	
	
    function get_started_options_head(){
     	wp_register_style( 'cgm_get_started', COMPLETE_GALLERY_URL.'css/get_started.css');
		wp_enqueue_style( 'cgm_get_started');
    } 	
	
	function get_started_options(){
		include_once(COMPLETE_GALLERY_PATH.'admin/getstarted.php');
    }
    
	function cgm_get_image_scalse($type = ''){
		global $_wp_additional_image_sizes;
		
		$image_sizes = $_wp_additional_image_sizes;
		
		
		//if(empty($image_sizes['post-thumbnail'])){
			$image_sizes['post-thumbnail'] = array('width'=>get_option( 'thumbnail_size_w' ), 'height'=>get_option( 'thumbnail_size_h' ), 'crop' => true);
		//}
		if(empty($image_sizes['medium-feature'])){
			$image_sizes['medium-feature'] = array('width'=>get_option( 'medium_size_w' ), 'height'=>get_option( 'medium_size_h' ),  'crop' => false);
		}	
		if(empty($image_sizes['large-feature'])){
			$image_sizes['large-feature'] = array('width'=>get_option( 'large_size_w' ), 'height'=>get_option( 'large_size_h' ),  'crop' => false);
		}

		if(!empty($type)){
			return $image_sizes[$type];
		} else {
			return $image_sizes;	
		}

	}		
	
	function wordlimit($string, $length = 50, $ellipsis = "...") {
	  $words = explode(' ', strip_tags($string));
	  if (count($words) > $length) {
	    return implode(' ', array_slice($words, 0, $length)) . $ellipsis;
	  }
	  else {
	    return $string;
	  }
	}
	
	
}
$complete_gallery_manager_plugin = new complete_gallery_manager_plugin();