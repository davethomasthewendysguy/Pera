<?php 
class cgm_touch_generator_class {
	var $tmp_id = '';
	var $tmp_post_id = '';
	var $tmp_images = '';
	var $tmp_settings = '';
	var $tmp_type = '';
	var $tmp_folder  = 'cgm';
	var $tmp_file = 'css.css';
	var $tmp_prewiev = false;
	var $tmp_current_count = 0;
	var $hw_css = '';

	function cgm_drawTouch_gallery($id,$images,$settings,$type,$prewiev = false,$prewiev_load_images=false,$post_id=0){
		global $complete_gallery_manager_plugin;
		
		$this->tmp_folder  = $complete_gallery_manager_plugin->tmp_folder;
		$this->tmp_file = $complete_gallery_manager_plugin->tmp_file;
		
		$upload_dir = wp_upload_dir();
		
		$this->tmp_id = $id;
		$this->tmp_post_id = $post_id; 
		
		$this->tmp_images = json_decode(urldecode($images));
		$this->tmp_settings = json_decode(urldecode($settings));
		$this->tmp_type = $type;
		
		$this->tmp_prewiev = $prewiev;

		$checkversion = get_post_meta($post_id, "cgm_version",true);	
		$container  ='';
		if(empty($checkversion)){
			$checkversion = 0;
		}

		if($checkversion < CGM_VERSION){
			$container = $this->css_generate(true);
			update_post_meta($post_id, "cgm_version",CGM_VERSION);
		} else if($prewiev || !file_exists($upload_dir['basedir'].'/'.$this->tmp_folder.'/'.$this->tmp_post_id.$this->tmp_file)){
			$container = $this->css_generate();		
		}
		
		
		if($prewiev) {
			if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
    			$container .= '<script>cgm_loadcss(\''.$upload_dir['baseurl'].'/'.$this->tmp_folder.'/tmp_'.$this->tmp_post_id.$this->tmp_file.'?ver='.date('YmdHis').'\', "css");</script>';
			} else {
	    		$container .=  '<link rel="stylesheet" type="text/css" href="'.$upload_dir['baseurl'].'/'.$this->tmp_folder.'/tmp_'.$this->tmp_post_id.$this->tmp_file.'?ver='.date('YmdHis').'" />';
			}		
		} else {
    		$container .=  '<link rel="stylesheet" type="text/css" href="'.$upload_dir['baseurl'].'/'.$this->tmp_folder.'/'.$this->tmp_post_id.$this->tmp_file.'?ver='.date('YmdHis').'" />';
			
		}
		
		$slidersizetmp = '';	
		if(!empty($this->tmp_settings->cgm_slidersize)){
			$slidersizetmp = $this->tmp_settings->cgm_slidersize;
		}
		
		$tmp_width = '500px';
		$tmp_height = '300px';
		if(!empty($slidersizetmp)){
			if($slidersizetmp == 'fullwidth'){
				if(!empty($this->tmp_settings->cgm_ts_height) && $this->tmp_settings->cgm_ts_height > 0){
					$tmp_height = $this->tmp_settings->cgm_ts_height.'px';
				}
				$tmp_width = '100%';		
			} else if($slidersizetmp == 'fullheight'){
				if(!empty($this->tmp_settings->cgm_ts_width) && $this->tmp_settings->cgm_ts_width > 0){
					$tmp_width = $this->tmp_settings->cgm_ts_width.'px';
				}
				$tmp_height = '100%';
			} else if($slidersizetmp == 'thumbnail' or $slidersizetmp == 'medium' or $slidersizetmp == 'large' ){	
				$tmpsizewp = $complete_gallery_manager_plugin->cgm_get_image_scalse();
				
				if(!empty($tmpsizewp[$slidersizetmp]['width']) && $tmpsizewp[$slidersizetmp]['width'] > 0){
					$tmp_width = $tmpsizewp[$slidersizetmp]['width'].'px';
				}
				if(!empty($tmpsizewp[$slidersizetmp]['height']) && $tmpsizewp[$slidersizetmp]['height'] > 0){
					$tmp_height = $tmpsizewp[$slidersizetmp]['height'].'px';
				}
				
			} else {
				if(!empty($this->tmp_settings->cgm_ts_width) && $this->tmp_settings->cgm_ts_width > 0){
					$tmp_width = $this->tmp_settings->cgm_ts_width.'px';
				}
				if(!empty($this->tmp_settings->cgm_ts_height) && $this->tmp_settings->cgm_ts_height > 0){
					$tmp_height = $this->tmp_settings->cgm_ts_height.'px';
				}
			}
		}
		
		$this->hw_css = 'max-width: '.$tmp_width.';height: '.$tmp_height.';';
		
		
		
		
    	if(!empty($this->tmp_settings->cgm_pageinShow) && $this->tmp_settings->cgm_pageinShow && 
    	!empty($this->tmp_settings->cgm_sliderdirection) && $this->tmp_settings->cgm_sliderdirection == 'horizontal' && (empty($this->tmp_settings->cgm_pageinShowInside) && !$this->tmp_settings->cgm_pageinShowInside)&& ($this->tmp_settings->cgm_pageinPosition == 'topleft' or $this->tmp_settings->cgm_pageinPosition == 'topcenter' or $this->tmp_settings->cgm_pageinPosition == 'topright')){
    		$container .= '<div class="cgm-pagination cgm-pagination-'.$this->tmp_post_id.' cgm-pagination-h-'.$this->tmp_post_id.' pagination'.$this->tmp_id.'" style="max-width: '.$tmp_width.';position: relative; backface-visibility: hidden; margin: 10px auto ! important;"></div>';	
    	}
    	

    	$container .= '<div style="'.$this->hw_css.'" class="cgm-swiper-container cgm-swiper-container-'.$this->tmp_post_id.' swiper'.$this->tmp_id.'">';
    	if(!empty($this->tmp_settings->cgm_pageinShow) && $this->tmp_settings->cgm_pageinShow && 
    	!empty($this->tmp_settings->cgm_sliderdirection) && $this->tmp_settings->cgm_sliderdirection == 'vertical'){
    	$container .= 	'<div class="cgm-pcv-'.$this->tmp_post_id.'"><div class="cgm-pagination cgm-pagination-'.$this->tmp_post_id.' cgm-pagination-v-'.$this->tmp_post_id.' pagination'.$this->tmp_id.'"></div></div>';
    	}
    	
    	if(!empty($this->tmp_settings->cgm_fullscreenbutton) && !empty($this->tmp_settings->cgm_fullscreenbutton_show)){
    		$container .= '<div onClick="cgm_fn_fullscreen(this,'.$this->tmp_id.','.$this->tmp_settings->cgm_fullscreenbutton_show.');" class="cgm-fullscreen cgm_'.$this->tmp_settings->cgm_fullscreenbutton.' cgm_fullscreen_open"></div>';	
    	}
    	
    	
     	if(!empty($this->tmp_settings->cgm_pageinShow) && $this->tmp_settings->cgm_pageinShow && 
    	!empty($this->tmp_settings->cgm_sliderdirection) && $this->tmp_settings->cgm_sliderdirection == 'horizontal' && !empty($this->tmp_settings->cgm_pageinShowInside) && $this->tmp_settings->cgm_pageinShowInside){
    	$container .= 	'<div class="cgm-pc-'.$this->tmp_post_id.'"><div class="cgm-pagination cgm-pagination-'.$this->tmp_post_id.' cgm-pagination-hi-'.$this->tmp_post_id.' pagination'.$this->tmp_id.'"></div></div>';
    	}
    	
    	if(!empty($this->tmp_settings->cgm_arrowShow) && $this->tmp_settings->cgm_arrowShow){
    	
    		if(!empty($this->tmp_settings->cgm_sliderdirection) && $this->tmp_settings->cgm_sliderdirection == 'horizontal'){
    			$container .= 	'<div onClick="cgm_fn_touch_dirrection(\'left\','.$this->tmp_id.')" class="cgm-arrow-left cgm-arrow-'.$this->tmp_post_id.' cgm-arrow-left-'.$this->tmp_post_id.'"></div>';
    			$container .= 	'<div onClick="cgm_fn_touch_dirrection(\'right\','.$this->tmp_id.')" class="cgm-arrow-right cgm-arrow-'.$this->tmp_post_id.' cgm-arrow-right-'.$this->tmp_post_id.'"></div>';	
    		} else {
    			$container .= 	'<div onClick="cgm_fn_touch_dirrection(\'left\','.$this->tmp_id.')" class="cgm-arrow-left cgm-arrow-'.$this->tmp_post_id.' cgm-arrow-top-'.$this->tmp_post_id.'"></div>';
    			$container .= 	'<div onClick="cgm_fn_touch_dirrection(\'right\','.$this->tmp_id.')" class="cgm-arrow-right cgm-arrow-'.$this->tmp_post_id.' cgm-arrow-bottom-'.$this->tmp_post_id.'"></div>';	
    		}

    	}
    	

    	
    	$container .= 	'<div class="cgm-swiper-wrapper-'.$this->tmp_post_id.' swiper-wrapper">';
    	$container .= 	$this->images_generate($tmp_width,$tmp_height); 
    	$container .= 	'</div>';
    	$container .= '</div>';
    	
    	if(!empty($this->tmp_settings->cgm_pageinShow) && $this->tmp_settings->cgm_pageinShow && 
    	!empty($this->tmp_settings->cgm_sliderdirection) && $this->tmp_settings->cgm_sliderdirection == 'horizontal' && (empty($this->tmp_settings->cgm_pageinShowInside) && !$this->tmp_settings->cgm_pageinShowInside)&& ($this->tmp_settings->cgm_pageinPosition == 'bottomleft' or $this->tmp_settings->cgm_pageinPosition == 'bottomcenter' or $this->tmp_settings->cgm_pageinPosition == 'bottomright')){
    		$container .= '<div class="cgm-pagination cgm-pagination-'.$this->tmp_post_id.' cgm-pagination-h-'.$this->tmp_post_id.' pagination'.$this->tmp_id.'" style="max-width: '.$tmp_width.';position: relative; backface-visibility: hidden; margin: 10px auto ! important;"></div>';	
    	}

		$container .= '<div class="clear" style="clear:both"></div>';
		
		return $container;

	}
	
	function images_generate($tmp_overall_width,$tmp_overall_height){
		global $wpdb,$complete_gallery_manager_plugin;
		$return_images = '';
		
		$upload_dir = wp_upload_dir();
		
	
		$click_functions = '';
		$show_decs = '';
		if(!empty($this->tmp_settings->cgm_mouseEventClick) and $this->tmp_settings->cgm_mouseEventClick != 1){
			$click_functions = $this->tmp_settings->cgm_mouseEventClick;
		}
		
		if(!empty($this->tmp_settings->cgm_pretty) and !empty($this->tmp_settings->cgm_pretty->showtitle) and $this->tmp_settings->cgm_pretty->showtitle){
			$show_title = $this->tmp_settings->cgm_pretty->showtitle;
		}
		
		if(!empty($this->tmp_settings->cgm_pretty) and !empty($this->tmp_settings->cgm_pretty->showdecs) and $this->tmp_settings->cgm_pretty->showdecs){
			$show_decs = $this->tmp_settings->cgm_pretty->showdecs;
		}
		
		if(!empty($this->tmp_images->auto_lock_id) and !empty($this->tmp_images->auto_lock_type) ){
			$tmp_auto_lock_id = $this->tmp_images->auto_lock_id;
			$tmp_auto_lock_type = $this->tmp_images->auto_lock_type;
			$tmp_auto_lock_s = '';
			if(!empty($this->tmp_images->auto_lock_s)){
				$tmp_auto_lock_s = $this->tmp_images->auto_lock_s;
			}
			$tmp_auto_lock_w = '';
			if(!empty($this->tmp_images->auto_lock_w)){
				$tmp_auto_lock_w = $this->tmp_images->auto_lock_w;
			}
			$tmp_auto_lock_h = '';
			if(!empty($this->tmp_images->auto_lock_h)){
				$tmp_auto_lock_h = $this->tmp_images->auto_lock_h;
			}
			
			if(!empty($tmp_auto_lock_h) and !empty($tmp_auto_lock_w)){
				$tmp_auto_lock_s = 'custom';
			}
			
			
			$this->tmp_images = '';
		
			$my_wp_query = new WP_Query();
			$all_wp_pages = $my_wp_query->query(array('post_type' => 'page','orderby' => 'title', 'order' => 'ASC','post_status' => 'publish','numberposts'=> -1,'nopaging'=>true));
		
			$tmp_image_id_datas = explode(',', $tmp_auto_lock_id);
			if($tmp_auto_lock_type == 'post'){
				if(!empty($tmp_image_id_datas)){
					foreach ($tmp_image_id_datas as $tmp_taxonomie) {
						$querys = $my_wp_query->query( array( 'category__in' => array($tmp_taxonomie)));
						foreach($querys as $query){
							if(has_post_thumbnail($query->ID)){
								$this->tmp_images[$query->ID] = (object)array('postid' => get_post_thumbnail_id($query->ID),
														'attactedid' => $query->ID,
														'customwidth' => $tmp_auto_lock_w,
														'customheight' => $tmp_auto_lock_h,
														'imageselected' => $tmp_auto_lock_s,
														'linkoverwrite' => 'default',
														'show' => "true",
														'typeobject' => 'post');
							

							}
						}	
					}
										
				}
			} else if($tmp_auto_lock_type == 'page'){
				foreach($tmp_image_id_datas as $tmp_image_id_data){
					$portfolio_children = get_page_children($tmp_image_id_data, $all_wp_pages);

					foreach($portfolio_children as $portfolio){
						if(has_post_thumbnail($portfolio->ID)){
							$this->tmp_images[$portfolio->ID] = (object)array('postid' => get_post_thumbnail_id($portfolio->ID),
														'attactedid' => $portfolio->ID,
														'customwidth' => $tmp_auto_lock_w,
														'customheight' => $tmp_auto_lock_h,
														'imageselected' => $tmp_auto_lock_s,
														'linkoverwrite' => 'default',
														'show' => "true",
														'typeobject' => 'page');
							
						}
					}	
				}
	
			}
			
		}
		
		if(!empty($this->tmp_images)){	
			foreach($this->tmp_images as $tmp_image_key => $tmp_image){
				$click_function = $click_functions;
						
				if(!empty($tmp_image->linkoverwrite) and $tmp_image->linkoverwrite != 'default' ){
					$click_function = $tmp_image->linkoverwrite;
				} else {
					if($tmp_image->typeobject=='gallery'){
						$click_function = 'clickNew';
					}
							
				}
				
				$post_exists = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '" . $tmp_image->postid . "'", 'ARRAY_A');
						
				if(!empty($tmp_image->show) and $tmp_image->show == 'true' && $post_exists){
					if(!empty($tmp_image->imageselected)){
						$imageselected = $tmp_image->imageselected;
					}
							
					if(!empty($tmp_image->attactedid) and is_numeric($tmp_image->attactedid)){
						$post_tmp = get_post($tmp_image->attactedid);
						$tmp_image->title = $post_tmp->post_title;
						$tmp_image->link = get_permalink($tmp_image->attactedid);
						if(empty($tmp_image->typeobject) or $tmp_image->typeobject != 'gallery'){
							$tmp_image->description = strip_tags($post_tmp->post_content);
						}
					}
									
					if(!empty($this->tmp_settings->cgm_captions->maxNumberWord)){
						$tmp_image->description = $complete_gallery_manager_plugin->wordlimit($tmp_image->description,$this->tmp_settings->cgm_captions->maxNumberWord,$this->tmp_settings->cgm_captions->maxNumberWordIndicator);
					}
				

					$slidersize = 'full';

				
					$tmp_loaded = wp_get_attachment_image_src($tmp_image->postid,$slidersize);

					$return_images .= '<div ';
					
					if(!empty($click_function)){
						$return_images .= ' onmouseup="cgm_fn_touch_on_release(this);return false;" ';
					}
					
					$return_images .= ' class="cgm-swiper-slide-'.$this->tmp_post_id.' swiper-slide" style="'.($click_function != '' ? 'cursor: pointer;' : '').'background-size:cover;background-position:center;background-image:url(\''.$tmp_loaded[0].'\');'.$this->hw_css.'" alt="'.$tmp_image->title.'" >';
					
					if(!empty($this->tmp_settings->cgm_overlayicon->video) && $this->tmp_settings->cgm_overlayicon->video && ($tmp_image->typeobject=='youtube' or $tmp_image->typeobject=='vimeo')){
						$return_images .= '<div id="cgm_video_play_icon" style="background-image:url(\''.COMPLETE_GALLERY_URL.'images/video_icon@2x.png\');" ></div>';
					} else if(!empty($this->tmp_settings->cgm_overlayicon->gallary) && $this->tmp_settings->cgm_overlayicon->gallary && ($tmp_image->typeobject=='gallery')){
						$return_images .= '<div id="cgm_video_play_icon" style="background-image:url(\''.COMPLETE_GALLERY_URL.'images/gallery_icon@2x.png\');" ></div>';
					} else if(!empty($this->tmp_settings->cgm_overlayicon->post) && $this->tmp_settings->cgm_overlayicon->post  && $tmp_image->typeobject=='post' && $click_function != '1'){
						$return_images .= '<div id="cgm_video_play_icon" style="background-image:url(\''.COMPLETE_GALLERY_URL.'images/post_icon@2x.png\');" ></div>';
					} else if(!empty($this->tmp_settings->cgm_overlayicon->page) && $this->tmp_settings->cgm_overlayicon->page  && $tmp_image->typeobject=='page'  && $click_function != '1'){
						$return_images .= '<div id="cgm_video_play_icon" style="background-image:url(\''.COMPLETE_GALLERY_URL.'images/pages_icon@2x.png\');"></div>';
					} else if(!empty($this->tmp_settings->cgm_overlayicon->link) && $this->tmp_settings->cgm_overlayicon->link && ($click_function=='clickNew' or $click_function=='click')){
						$return_images .= '<div id="cgm_video_play_icon" style="background-image:url(\''.COMPLETE_GALLERY_URL.'images/link_icon@2x.png\');"></div>';
					}
else if(!empty($this->tmp_settings->cgm_overlayicon->prettyphoto) && $this->tmp_settings->cgm_overlayicon->prettyphoto &&  $click_function=='prettyPhoto' && $click_function != '1'){
						$return_images .= '<div id="cgm_video_play_icon" style="background-image:url(\''.COMPLETE_GALLERY_URL.'images/prettyphoto_icon@2x.png\');"></div>';
					}
					
					

					if(!empty($tmp_image->typeobject) and ($tmp_image->typeobject=='youtube' or $tmp_image->typeobject=='vimeo') and ($click_function == '1' || $click_function =='prettyPhoto')){
						$return_images .= '<a style="display:none" title="'.($show_decs == 'true' ? $tmp_image->description : '').'" href="'.$tmp_image->link.'" rel="prettyPhoto[pp_gal]"><img style="display:none" alt="'.($show_title == 'true' ? $tmp_image->title : '').'" />';
					$return_images .= '</a>';
					} else if(!empty($click_function) and $click_function=='prettyPhoto'){
						$return_images .= '<a style="display:none" title="'.($show_decs == 'true' ? $tmp_image->description : '').'" href="'.$tmp_loaded[0].'" rel="prettyPhoto[pp_gal]"><img style="display:none" alt="'.($show_title == 'true' ? $tmp_image->title : '').'" />';
					$return_images .= '</a>';
					} else if(!empty($click_function) and $click_function=='click'){
						$return_images .= '<a style="display: none;" href="'.$tmp_image->link.'">';
						$return_images .= '</a>';
					} else if(!empty($click_function) and $click_function=='clickNew'){
						$return_images .= '<a target="_black" style="display: none;" href="'.$tmp_image->link.'">';
						$return_images .= '</a>';
					}
					
				if(((!empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title)) or (!empty($this->tmp_settings->cgm_captions->showdecs) and !empty($tmp_image->description))) and (!empty($this->tmp_settings->cgm_captionsShow) and $this->tmp_settings->cgm_captionsShow == 'true')){
					
						if($this->tmp_settings->cgm_captions->type == 'appear top' || $this->tmp_settings->cgm_captions->type == 'appear bottom'|| $this->tmp_settings->cgm_captions->type == 'appear always top'   || $this->tmp_settings->cgm_captions->type == 'appear always bottom'  ) {
						
							$tmp_overall_heights = str_replace('px', '', $tmp_overall_height);
							$tmp_overall_heights = 'max-height: '.($tmp_overall_height/2) . 'px;max-width:'.$tmp_overall_width.';';
							
						} else {
							$tmp_overall_widths = str_replace('px', '', $tmp_overall_width);
							$tmp_overall_widths = str_replace('%', '', $tmp_overall_widths);
						
							$tmp_overall_heights = 'height:'.$tmp_overall_height.';max-width:'.($tmp_overall_widths/3).'px;';
							
						}
						
					
						$return_images .= '<figcaption class="captions '.$this->tmp_settings->cgm_captions->type.'">';
						if(!empty($this->tmp_settings->cgm_captions->showtitle) and !empty($tmp_image->title)){
							$return_images .= 	'<h1>'.$tmp_image->title.'</h1>';	
						}		
						
						if(!empty($this->tmp_settings->cgm_captions->showdecs) and $tmp_image->description){
							$return_images .= 	'<p>'.$tmp_image->description.'</p>';		
						}		
			
						$return_images .= '</figcaption>';
					}
					
					
	    	    	$return_images .= '</div>';		
				}
			}
		}
		return $return_images;
	}
	
	function css_generate($rendertomainfile = false){
		global $complete_gallery_manager_plugin;
	
		$tmp_css = '';
		$tmp_css .= '.cgm-swiper-container-'.$this->tmp_post_id.' {
			margin:0 auto;
			position:relative;
			overflow:hidden;
			-webkit-backface-visibility:hidden;
			-moz-backface-visibility:hidden;
			-ms-backface-visibility:hidden;
			-o-backface-visibility:hidden;
			backface-visibility:hidden;
		}';

		$tmp_css .= '.cgm-swiper-wrapper-'.$this->tmp_post_id.' {
			position:relative;
			width:100%;
			-webkit-transition-property:-webkit-transform;
			-webkit-transition-duration:0s;
			-webkit-transform:translate3d(0px,0,0);
			-webkit-transition-timing-function:ease;
			
			-moz-transition-property:-moz-transform;
			-moz-transition-duration:0s;
			-moz-transform:translate3d(0px,0,0);
			-moz-transition-timing-function:ease;
			
			-o-transition-property:-o-transform;
			-o-transition-duration:0s;
			-o-transform:translate3d(0px,0,0);
			-o-transition-timing-function:ease;
			
			-ms-transition-property:-ms-transform;
			-ms-transition-duration:0s;
			-ms-transform:translate3d(0px,0,0);
			-ms-transition-timing-function:ease;
			
			transition-property:transform;
			transition-duration:0s;
			transform:translate3d(0px,0,0);
			transition-timing-function:ease;
			
		}';

		$tmp_css .= '.cgm-swiper-slide-'.$this->tmp_post_id.' {
			float:left;
			-webkit-transform:translate3d(0,0,0);
			position: relative;
		}';
		







		$tmp_css .= '.cgm-swiper-main-'.$this->tmp_post_id.' {
			position: relative;
			margin-bottom: 20px;
		}';
 

		$tmp_css .= '.cgm-content-slide-'.$this->tmp_post_id.' {
			background: #fff;
			padding: 20px;
			border-radius: 5px;
		}';
		
	
		
		$tmp_css .= '.cgm-pagination-'.$this->tmp_post_id.' {
			   display: block;
			   position: absolute;
			   width: 100%;
		}';
		
		
		// -------------- fullscreen
		
		$tmp_css .= '.cgm-fullscreen_activate_item {
			    max-width: none !important;
			    background-repeat: no-repeat !important;
			    background-size: contain !important;
		}';	
		
		$tmp_fullscreen_r = '0';	
		$tmp_fullscreen_g = '0';
		$tmp_fullscreen_b = '0';
		$tmp_fullscreen_a = '0';
		
		if(!empty($this->tmp_settings->cgm_fullscreenbuttonbgcolor) and $this->tmp_settings->cgm_fullscreenbuttonbgcolor != '#'){
		$temptemp = $complete_gallery_manager_plugin->HexToRGB($this->tmp_settings->cgm_fullscreenbuttonbgcolor);		
		
		$tmp_fullscreen_r = $temptemp['r'];	
		$tmp_fullscreen_g = $temptemp['g'];
		$tmp_fullscreen_b = $temptemp['b'];
		
		};
		
		if(!empty($this->tmp_settings->cgm_fullscreenbuttonbgopacity)){
		$tmp_fullscreen_a = $this->tmp_settings->cgm_fullscreenbuttonbgopacity;	
		};		
		
		
		
		$tmp_css .= '.cgm-fullscreen_activate {
			    bottom: 0 !important;
			    height: 100% !important;
			    max-height: 100% !important;
			    width: 100% !important;
			    max-width: 100% !important;
			    left: 0 !important;
			    position: fixed !important;
			    right: 0 !important;
			    top: 0 !important;
			    width: 100% !important;
			    z-index: 10000 !important;
			    background-color: rgba('.$tmp_fullscreen_r.', '.$tmp_fullscreen_g.', '.$tmp_fullscreen_b.', '.$tmp_fullscreen_a.') !important;
		}';		
		
		$tmp_css .= '.cgm-fullscreen {
			   display: block;
			   position: absolute;
			   width:48px;
			   height:48px;
			   background-repeat: no-repeat;
			   background-size: 48px 48px;
			   cursor:pointer;
			   opacity: 0.7 !important;
		}';
		
		$tmp_css .= '.cgm_topleft {
			top: 5px !important;
			left: 5px !important;
		}';
		
		
		$tmp_css .= '.cgm_topright {
			top: 5px !important;
			right: 5px !important;
		}';		
		
		$tmp_css .= '.cgm_bottomleft {
			bottom: 5px !important;
			left: 5px !important;
		}';
		
		
		$tmp_css .= '.cgm_bottomright {
			bottom: 5px !important;
			right: 5px !important;
		}';
		
		$tmp_css .= '.cgm_fullscreen_open {
			background-image:url(\''.COMPLETE_GALLERY_URL.'images/go_fullscreen_icon@2x.png\');
			z-index:5000;
		}';

		$tmp_css .= '.cgm_fullscreen_close {
			background-image:url(\''.COMPLETE_GALLERY_URL.'images/back_fullscreen_icon@2x.png\');
			z-index:16777271;	
		}';
		
	
		
		// -------------- arrows
		
		if(!empty($this->tmp_settings->cgm_arrownormal) && !empty($this->tmp_settings->cgm_arrownormal->width)){
		$this->tmp_settings->cgm_arrownormal->height = $this->tmp_settings->cgm_arrownormal->width;
		};
		
		
		$tmp_css .= '.cgm-arrow-'.$this->tmp_post_id.' {
		 		z-index: 2000;
		 		position: absolute;
		 		cursor:pointer;
				transform:rotate(45deg);
				-ms-transform:rotate(45deg);
				-moz-transform:rotate(45deg);
				-webkit-transform:rotate(45deg);
				-o-transform:rotate(45deg);
		 		top: 50%;';
		 		
			$tmp_css .= 'transition:opacity 0.5s linear;';
			$tmp_css .= '-moz-transition:opacity 0.5s linear;';
			$tmp_css .= '-webkit-transition:opacity 0.5s linear;';
			$tmp_css .= '-o-transition:opacity 0.5s linear;';

				if(!empty($this->tmp_settings->cgm_arrownormal) && !empty($this->tmp_settings->cgm_arrownormal->width)){
					$tmp_css .= 'width:'.$this->tmp_settings->cgm_arrownormal->width.'px !important;';
					$tmp_css .= 'margin-left: '.($this->tmp_settings->cgm_arrownormal->width/2).'px !important; ';
					$tmp_css .= 'margin-right: '.($this->tmp_settings->cgm_arrownormal->width/2).'px !important; ';
				} else {
					$tmp_css .= 'width:40px !important;';
					$tmp_css .= 'margin-left: 20px !important;';
					$tmp_css .= 'margin-right: 20px !important;';
				}
		 		
				if(!empty($this->tmp_settings->cgm_arrownormal) && !empty($this->tmp_settings->cgm_arrownormal->height)){
					$tmp_css .= 'height:'.$this->tmp_settings->cgm_arrownormal->height.'px !important;';
					$tmp_css .= 'margin-top: -'.($this->tmp_settings->cgm_arrownormal->height/2).'px !important;';
				} else {
					$tmp_css .= 'height:40px !important;';
					$tmp_css .= 'margin-top: -20px !important;';
				}
		 		
		$tmp_css .= '}';
		 
		 
		 $border_style_normal = '';
		 if(!empty($this->tmp_settings->cgm_arrownormal->borderStyle)){
			$border_style_normal = $this->tmp_settings->cgm_arrownormal->borderStyle;
		 }
		 $border_style_hover = '';
		 if(!empty($this->tmp_settings->cgm_arrowhover->borderStyle)){
			$border_style_hover = $this->tmp_settings->cgm_arrowhover->borderStyle;
		 }
		  
		
		
		 $tmp_css .= '.cgm-arrow-left-'.$this->tmp_post_id.' {';
			 	if(!empty($this->tmp_settings->cgm_arrownormal)){
					$this->tmp_settings->cgm_arrownormal->boxShadowX = -2;
					$this->tmp_settings->cgm_arrownormal->boxShadowY = 2;
					$this->tmp_settings->cgm_arrownormal->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrownormal->boxShadowNoInter = true;
					
					if(!empty($border_style_normal)){
						$this->tmp_settings->cgm_arrownormal->borderStyle = 'none none '.$border_style_normal . ' ' . $border_style_normal;
					}
					 
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrownormal);
				}
		$tmp_css .= 'left: 10px; 
		 }';
		 
		 $tmp_css .= '.cgm-arrow-left-'.$this->tmp_post_id.':hover {';
			 	if(!empty($this->tmp_settings->cgm_arrowhover)){
					$this->tmp_settings->cgm_arrowhover->boxShadowX = -2;
					$this->tmp_settings->cgm_arrowhover->boxShadowY = 2;
					$this->tmp_settings->cgm_arrowhover->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrowhover->boxShadowNoInter = true;
					
					if(!empty($border_style_hover)){
						$this->tmp_settings->cgm_arrowhover->borderStyle = 'none none '.$border_style_hover . ' ' . $border_style_hover;
					}
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrowhover);
				}
		$tmp_css .= '}';
		 

		 $tmp_css .= '.cgm-arrow-right-'.$this->tmp_post_id.' {';
		 			 	if(!empty($this->tmp_settings->cgm_arrownormal)){
					$this->tmp_settings->cgm_arrownormal->boxShadowX = 2;
					$this->tmp_settings->cgm_arrownormal->boxShadowY = -2;
					$this->tmp_settings->cgm_arrownormal->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrownormal->boxShadowNoInter = true;
					
					if(!empty($border_style_normal)){
						$this->tmp_settings->cgm_arrownormal->borderStyle = $border_style_normal . ' ' . $border_style_normal.' none none';
					}
					
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrownormal);
				}
		 $tmp_css .= 'right: 15px; 
		 }';
		 
		 
		 
		 
		 
		
		 $tmp_css .= '.cgm-arrow-right-'.$this->tmp_post_id.':hover {';
		 	if(!empty($this->tmp_settings->cgm_arrowhover)){
					$this->tmp_settings->cgm_arrowhover->boxShadowX = 2;
					$this->tmp_settings->cgm_arrowhover->boxShadowY = -2;
					$this->tmp_settings->cgm_arrowhover->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrowhover->boxShadowNoInter = true;
					if(!empty($border_style_hover)){
						$this->tmp_settings->cgm_arrowhover->borderStyle = $border_style_hover . ' ' . $border_style_hover.' none none';
					}
					
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrowhover);
			}
			
		 $tmp_css .= '}';
		
		

	
		 $tmp_css .= '.cgm-arrow-bottom-'.$this->tmp_post_id.' {';
			 	if(!empty($this->tmp_settings->cgm_arrownormal)){
					$this->tmp_settings->cgm_arrownormal->boxShadowX = 2;
					$this->tmp_settings->cgm_arrownormal->boxShadowY = 2;
					$this->tmp_settings->cgm_arrownormal->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrownormal->boxShadowNoInter = true;
					
					if(!empty($border_style_normal)){
						$this->tmp_settings->cgm_arrownormal->borderStyle = 'none '. $border_style_normal . ' ' . $border_style_normal . ' none';
					}
					 
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrownormal);
				}
				
				if(!empty($this->tmp_settings->cgm_arrownormal) && !empty($this->tmp_settings->cgm_arrownormal->width)){
					$tmp_css .= 'margin-left: -'.($this->tmp_settings->cgm_arrownormal->width/2).'px !important; ';
					$tmp_css .= 'margin-right: 0px !important; ';
				} else {
					$tmp_css .= 'margin-left: -20px !important;';
					$tmp_css .= 'margin-right: 0px !important;';
				}
				
				
				
				
				
				
		$tmp_css .= 'left: 50%;
					 bottom: 20px !important;
					 top: auto !important;
					 margin-top: 0 !important;
		 }';
		 
		 $tmp_css .= '.cgm-arrow-bottom-'.$this->tmp_post_id.':hover {';
			 	if(!empty($this->tmp_settings->cgm_arrowhover)){
					$this->tmp_settings->cgm_arrowhover->boxShadowX = 2;
					$this->tmp_settings->cgm_arrowhover->boxShadowY = 2;
					$this->tmp_settings->cgm_arrowhover->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrowhover->boxShadowNoInter = true;
					
					if(!empty($border_style_hover)){
						$this->tmp_settings->cgm_arrowhover->borderStyle = 'none '. $border_style_hover . ' ' . $border_style_hover . ' none';
					}
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrowhover);
				}
		$tmp_css .= '}';
		 

		 $tmp_css .= '.cgm-arrow-top-'.$this->tmp_post_id.' {';
		 			 	if(!empty($this->tmp_settings->cgm_arrownormal)){
					$this->tmp_settings->cgm_arrownormal->boxShadowX = -2;
					$this->tmp_settings->cgm_arrownormal->boxShadowY = -2;
					$this->tmp_settings->cgm_arrownormal->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrownormal->boxShadowNoInter = true;
					
					if(!empty($border_style_normal)){
						$this->tmp_settings->cgm_arrownormal->borderStyle = $border_style_normal . ' none none ' . $border_style_normal;
					}
					
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrownormal);
				}
				
				if(!empty($this->tmp_settings->cgm_arrownormal) && !empty($this->tmp_settings->cgm_arrownormal->width)){
					$tmp_css .= 'margin-left: -'.($this->tmp_settings->cgm_arrownormal->width/2).'px !important; ';
					$tmp_css .= 'margin-right: 0px !important; ';
				} else {
					$tmp_css .= 'margin-left: -20px !important;';
					$tmp_css .= 'margin-right: 0px !important;';
				}
				
		 $tmp_css .= 'left: 50%; 
		 			  top: 20px !important;
					  bottom: auto !important;
					  margin-top: 0 !important;
		 }';
		
		 $tmp_css .= '.cgm-arrow-top-'.$this->tmp_post_id.':hover {';
		 	if(!empty($this->tmp_settings->cgm_arrowhover)){
					$this->tmp_settings->cgm_arrowhover->boxShadowX = -2;
					$this->tmp_settings->cgm_arrowhover->boxShadowY = -2;
					$this->tmp_settings->cgm_arrowhover->boxShadowBlue = 1;
					$this->tmp_settings->cgm_arrowhover->boxShadowNoInter = true;
					if(!empty($border_style_hover)){
						$this->tmp_settings->cgm_arrowhover->borderStyle = $border_style_hover . ' none none ' . $border_style_hover;
					}
					
					$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_arrowhover);
			}
			
		 $tmp_css .= '}';

		
		
		// -------------- pagination
		
		
		$tmp_css .= '.cgm-pagination-'.$this->tmp_post_id.' span {
			cursor:pointer;';
			if(!empty($this->tmp_settings->cgm_pageinNormal) && !empty($this->tmp_settings->cgm_pageinNormal->opacity)){
				$tmp_css .= 'opacity:'.$this->tmp_settings->cgm_pageinNormal->opacity.';';
			}
			$tmp_css .= 'transition:width 0.5s,height 0.5s, opacity 0.5s linear;';
			$tmp_css .= '-moz-transition:width 0.5s,height 0.5s, opacity 0.5s linear;';
			$tmp_css .= '-webkit-transition:width 0.5s,height 0.5s, opacity 0.5s linear;';
			$tmp_css .= '-o-transition:width 0.5s,height 0.5s, opacity 0.5s linear;
		}';		
		

		
		$tmp_css .= '.cgm-pagination-'.$this->tmp_post_id.':hover span {';
			if(!empty($this->tmp_settings->cgm_pageinHover) && !empty($this->tmp_settings->cgm_pageinHover->opacity))			{
				$tmp_css .= 'opacity:'.$this->tmp_settings->cgm_pageinHover->opacity.' !important;';
			}
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm-pagination-'.$this->tmp_post_id.' span:not(.swiper-active-switch):hover  {';
			if(!empty($this->tmp_settings->cgm_pageinHover)){
				$this->tmp_settings->cgm_pageinHover->opacity = 0;
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_pageinHover);
				
				if(isset($this->tmp_settings->cgm_pageinHover->width)){
					$tmp_css .= 'width:'.$this->tmp_settings->cgm_pageinHover->width.'px !important;';	
				} else {
					$tmp_css .= 'width:10px !important;';	
				}	
				if(isset($this->tmp_settings->cgm_pageinHover->height)){
					$tmp_css .= 'height:'.$this->tmp_settings->cgm_pageinHover->height.'px !important;';	
				} else {
					$tmp_css .= 'height:10px !important;';	
				}
			}	
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm-pagination-'.$this->tmp_post_id.' .swiper-pagination-switch  {';
			if(!empty($this->tmp_settings->cgm_pageinNormal)){
				if($this->tmp_settings->cgm_pageinHover->opacity){
					$this->tmp_settings->cgm_pageinHover->opacity = 0;
				}
				
				
				if(isset($this->tmp_settings->cgm_pageinNormal->width)){
					$tmp_css .= 'width:'.$this->tmp_settings->cgm_pageinNormal->width.'px !important;';	
				} else {
					$tmp_css .= 'width:10px !important;';	
				}
				if(isset($this->tmp_settings->cgm_pageinNormal->height)){
					$tmp_css .= 'height:'.$this->tmp_settings->cgm_pageinNormal->height.'px !important;';	
				} else {
					$tmp_css .= 'height:10px !important;';	
				}
			
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_pageinNormal);
			}
			
			$tmp_css .= 'margin: 3px;
		}';
		
		$tmp_css .= '.cgm-pagination-'.$this->tmp_post_id.' .swiper-active-switch  {
					cursor:default !important;';
			if(!empty($this->tmp_settings->cgm_pageinActiv)){
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_pageinActiv);
				
				if(isset($this->tmp_settings->cgm_pageinActiv->width)){
					$tmp_css .= 'width:'.$this->tmp_settings->cgm_pageinActiv->width.'px !important;';	
				} else {
					$tmp_css .= 'width:10px !important;';	
				}	
				if(isset($this->tmp_settings->cgm_pageinActiv->height)){
					$tmp_css .= 'height:'.$this->tmp_settings->cgm_pageinActiv->height.'px !important;';	
				} else {
					$tmp_css .= 'height:10px !important;';	
				}
				
			}

		$tmp_css .= '}';
		
		
		
		$margin_between = '3px';
		
		if(isset($this->tmp_settings->cgm_pageinMarginBetween)){
			$margin_between = $this->tmp_settings->cgm_pageinMarginBetween.'px';
		}
		
		
		$tmp_css .= '.cgm-pagination-h-'.$this->tmp_post_id.' {
			width: 100%;';
			$tmp_css .= 'margin-left: 0px !important;';
			$tmp_css .= 'margin-right: 0px !important;';
			if(!empty($this->tmp_settings->cgm_pageinPosition)){
				if($this->tmp_settings->cgm_pageinPosition == 'topleft' or $this->tmp_settings->cgm_pageinPosition == 'bottomleft'){
					$tmp_css .= 'text-align:left;';
				} else if($this->tmp_settings->cgm_pageinPosition == 'topright' or $this->tmp_settings->cgm_pageinPosition == 'bottomright'){
					$tmp_css .= 'text-align:right;';
				} else {
					$tmp_css .= 'text-align:center;';
				}
			} else {
				$tmp_css .= 'text-align:center;';
			}
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm-pagination-h-'.$this->tmp_post_id.' .swiper-pagination-switch {
			display: inline-block;
			margin: 0 '.$margin_between.';
		}';
				
				
		$tmp_css .= '.cgm-pcv-'.$this->tmp_post_id.' {
			display: block;
		    position: absolute;
		    height: 100%;';
		    
			if(!empty($this->tmp_settings->cgm_pageinPosition)){
				if($this->tmp_settings->cgm_pageinPosition == 'bottomright' or $this->tmp_settings->cgm_pageinPosition == 'topright'){
					$tmp_css .= 'right: 32px;';
				}
			}
		    
		    
		    
		    
		$tmp_css .= '}';
				
				
		$tmp_css .= '.cgm-pagination-v-'.$this->tmp_post_id.' {
			z-index: 20;
			margin:10px;
			width:auto !important;';
			
			if(!empty($this->tmp_settings->cgm_pageinPosition)){
				if($this->tmp_settings->cgm_pageinPosition == 'topleft' or $this->tmp_settings->cgm_pageinPosition == 'topcenter' or $this->tmp_settings->cgm_pageinPosition == 'topright'){
					$tmp_css .= 'top:0px;';
				} else if($this->tmp_settings->cgm_pageinPosition == 'bottomleft' or $this->tmp_settings->cgm_pageinPosition == 'bottomcenter' or $this->tmp_settings->cgm_pageinPosition == 'bottomright'){
					$tmp_css .= 'bottom:0px;';
				}
			}
			
		$tmp_css .= '}';		
				
		$tmp_css .= '.cgm-pagination-v-'.$this->tmp_post_id.' .swiper-pagination-switch {
			display: block;
			margin: 0 0 '.$margin_between.';
		}';


		$tmp_css .= '.cgm-pc-'.$this->tmp_post_id.' {
			display: block;
		    position: absolute;
			width: 100%;';
			if(!empty($this->tmp_settings->cgm_pageinPosition)){
				if($this->tmp_settings->cgm_pageinPosition == 'topleft' or $this->tmp_settings->cgm_pageinPosition == 'topcenter' or $this->tmp_settings->cgm_pageinPosition == 'topright'){
					$tmp_css .= 'top:0px;';
				} else if($this->tmp_settings->cgm_pageinPosition == 'bottomleft' or $this->tmp_settings->cgm_pageinPosition == 'bottomcenter' or $this->tmp_settings->cgm_pageinPosition == 'bottomright'){
					$tmp_css .= 'bottom:0px;';
				}
			}
			
		$tmp_css .= '}';


		$tmp_css .= '.cgm-pagination-hi-'.$this->tmp_post_id.'  {';
			if(!empty($this->tmp_settings->cgm_pageinPosition)){
				if($this->tmp_settings->cgm_pageinPosition == 'topleft' or $this->tmp_settings->cgm_pageinPosition == 'bottomleft'){
					$tmp_css .= 'text-align:left;';
				} else if($this->tmp_settings->cgm_pageinPosition == 'topright' or $this->tmp_settings->cgm_pageinPosition == 'bottomright'){
					$tmp_css .= 'text-align:right;';
				} else {
					$tmp_css .= 'text-align:center;';
				}
			} else {
				$tmp_css .= 'text-align:center;';
			}

		$tmp_css .= 'z-index: 10;
			   		 position: relative !important;
			   width: auto !important;
			   margin:10px;
		}';
		$tmp_css .= '.cgm-pagination-hi-'.$this->tmp_post_id.' .swiper-pagination-switch {
			display: inline-block;
			margin: 0 '.$margin_between.';
		}';
		

		// --------------- Captions start -------------------------
		$tmp_css .='.cgm-swiper-wrapper-'.$this->tmp_post_id.' #cgm_video_play_icon {left: 50% !important;margin-left: -48px !important;margin-top: -48px !important;position: relative !important;top: 50% !important;height: 96px !important;width: 96px; !important;background-size: contain;';

			if(!empty($this->tmp_settings->cgm_overlayicon->opacity)){
				$tmp_css .='opacity: '.$this->tmp_settings->cgm_overlayicon->opacity.' !important;';
			} else {
				$tmp_css .='opacity: 0.9  !important;';
			}

		$tmp_css .='}';

		$tmp_css .= '.cgm-swiper-slide-'.$this->tmp_post_id.' figcaption h1 {margin-top:0px !important;padding-top:0px !important;margin-bottom: 0;padding-bottom: 0;';
		if(!empty($this->tmp_settings->cgm_captions->h1)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_captions->h1);	
		}
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm-swiper-slide-'.$this->tmp_post_id.' figcaption p {';
		$tmp_css .= 'margin-top: 0 !important;';
		$tmp_css .= 'margin-bottom: 0 !important;';
		$tmp_css .= 'padding-bottom: 0 !important;';
		$tmp_css .= 'padding-top: 0 !important;';
		if(!empty($this->tmp_settings->cgm_captions->p)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_captions->p);	
		}
		$tmp_css .= '}';

		$tmp_css .= '.cgm-swiper-slide-'.$this->tmp_post_id.' .captions {';
		if(!empty($this->tmp_settings->cgm_captions)){
			$tmp = $this->tmp_settings->cgm_captions;
			$opacity = 0;
			$backgroundColor = '#ffffff';
			
			if(!empty($tmp->opacity)){$opacity = $tmp->opacity;}
			if(!empty($tmp->backgroundColor)){$backgroundColor = $tmp->backgroundColor;}
			if(!empty($opacity) and !empty($backgroundColor) ){
				$rbg = $complete_gallery_manager_plugin->HexToRGB(str_replace('#','',$backgroundColor));
				$tmp_css .= 'background-color: rgba('.$rbg['r'].','.$rbg['g'].','.$rbg['b'].','.$opacity.') !important;';
			}		
			if(!empty($tmp->padding)){$tmp_css .= 'padding:'.$tmp->padding.' !important;';}	
			if(!empty($tmp->align)){$tmp_css .= 'text-align:'.$tmp->align.' !important;';}	
		}
		$tmp_css .= '}';
		// --------------- Captions end ---------------------------

		$tmp_css .= '.pp_social .facebook {';
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->facebook)){
				$tmp_css .=	'display:block !important;';
				$tmp_css .=	'float:left !important;';
			} else {
				$tmp_css .=	'display:none !important;';
			}
		}
		$tmp_css .= '}';
		
		
		$tmp_css .= '.pp_social .pinterest {';
		$tmp_css .= 'float: left;';
		$tmp_css .= 'margin-left: 5px;';
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->pinterest)){
				$tmp_css .=	'display:block !important;';
				$tmp_css .=	'float:left !important;';
			} else {
				$tmp_css .=	'display:none !important;';
			}
		}
		$tmp_css .= '}';
			
		$tmp_css .= '.pp_social .twitter {';
		$tmp_css .= 'float: left;';
		$tmp_css .= 'margin-left: 5px;';
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->tweet)){
				$tmp_css .=	'display:block !important;';
				$tmp_css .=	'float:left !important;';
			} else {
				$tmp_css .=	'display:none !important;';
			}
		}	
		$tmp_css .= '}';


		$tmp_css .= '.pp_social .google {';
		$tmp_css .= 'float: left;';
		$tmp_css .= 'margin-left: 5px;';
		
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->google)){
				$tmp_css .=	'display:block !important;';
				$tmp_css .=	'float:left !important;';
			} else {
				$tmp_css .=	'display:none !important;';
			}
		}	
		$tmp_css .= '}';
		
		$tmp_css .= '.pp_overlay {';
		
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->overlayopacity)){
				$tmp_css .=	'opacity:'.$this->tmp_settings->cgm_pretty->overlayopacity.' !important;';
			}
			
			if(!empty($this->tmp_settings->cgm_pretty->overlaybgcolor)){
				$tmp_css .=	'background-color:'.$this->tmp_settings->cgm_pretty->overlaybgcolor.' !important;';
			}
		}	
		$tmp_css .= '}';
		
		
				$upload_dir = wp_upload_dir();
	
				if((!empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title)) or (!empty($this->tmp_settings->cgm_captions->showdecs) and $this->tmp_settings->cgm_captions->showdecs) && (!empty($this->tmp_settings->cgm_captionsShow) && $this->tmp_settings->cgm_captionsShow == 'true')){	
	
			$tmp_css .= '.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-right,
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-right {
							opacity:0.2 !important;
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}
						
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-right:hover,
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-right:focus  {
							opacity:'.($this->tmp_settings->cgm_arrowhover->opacity != '' ? $this->tmp_settings->cgm_arrowhover->opacity : '1.0').' !important;
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}
						
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-left,
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-left {
							opacity:0.2 !important;
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}
						
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-left:hover,
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-arrow-left:focus {
							opacity:'.($this->tmp_settings->cgm_arrowhover->opacity != '' ? $this->tmp_settings->cgm_arrowhover->opacity : '1.0').' !important;
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}
						
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-pagination,
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-pagination {
							opacity:'.($this->tmp_settings->cgm_pageinNormal->opacity != '' ? $this->tmp_settings->cgm_pageinNormal->opacity : '1.0').' !important;							
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}
						
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-pagination:hover,
						.cgm-swiper-container-'.$this->tmp_post_id.' .cgm-pagination:focus  {
							opacity:'.($this->tmp_settings->cgm_pageinHover->opacity != '' ? $this->tmp_settings->cgm_pageinHover->opacity : '1.0').' !important;
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}

						.cgm-swiper-wrapper-'.$this->tmp_post_id.' #cgm_video_play_icon {
							opacity:0.2 !important;							
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}
						
						.cgm-swiper-wrapper-'.$this->tmp_post_id.' #cgm_video_play_icon:hover,
						.cgm-swiper-wrapper-'.$this->tmp_post_id.' #cgm_video_play_icon:focus {
							opacity:'.($this->tmp_settings->cgm_overlayicon->opacity >0 ? $this->tmp_settings->cgm_overlayicon->opacity : '1.0').' !important;					
							-moz-transition:0.4s ease-in-out;
							-webkit-transition:0.4s ease-in-out;
							-o-transition:0.4s ease-in-out;
							-ms-transition:0.4s ease-in-out;
							transition:0.4s ease-in-out;
						}';
	
	
			$cssFile = COMPLETE_GALLERY_PATH.'css/captions_slider.css';
			$fh = fopen($cssFile, 'r');
			$tmp_css_cap = fread($fh,filesize($cssFile));		
			fclose($fh);
			$tmp_font_size = 16;
			
			if(!empty($this->tmp_settings->cgm_captions->h1) && !empty($this->tmp_settings->cgm_captions->h1->fontSize)){
					$tmp_font_size = $this->tmp_settings->cgm_captions->h1->fontSize;
			}
			
			if($tmp_font_size < 26){
				$tmp_font_size_padding = ($tmp_font_size/5)+(($tmp_font_size/5)-1);		
			} else {
				$tmp_font_size_padding = ($tmp_font_size/4)+(($tmp_font_size/4)-1);
			}
			
			if(!empty($this->tmp_settings->cgm_captions->hoversize)){
					$tmp_hover_size = $this->tmp_settings->cgm_captions->hoversize;
			}
			
			
	
			
			$tmp_css .= str_replace(array('--SizeHover--','--SizeTitle--','--SizeTitleLine--'), array($tmp_hover_size.'%',($tmp_font_size+10).'px',$tmp_font_size_padding.'px'), $tmp_css_cap);
	
		}
		
		if($rendertomainfile){
			$myFile = $upload_dir['basedir'].'/'.$this->tmp_folder.'/'.$this->tmp_post_id.$this->tmp_file;
			$fh = fopen($myFile, 'w') or die("can't open file");
	
			fwrite($fh,  $tmp_css);
			fclose($fh);
			
			$myFile = $upload_dir['basedir'].'/'.$this->tmp_folder.'/tmp_'.$this->tmp_post_id.$this->tmp_file;
		} else {
			$myFile = $upload_dir['basedir'].'/'.$this->tmp_folder.'/tmp_'.$this->tmp_post_id.$this->tmp_file;
		}

		$fh = fopen($myFile, 'w') or die("can't open file");

		fwrite($fh,  $tmp_css);
		fclose($fh);

		return 	'';	
		
	}
}

$cgm_touch_generator = new cgm_touch_generator_class();
?>