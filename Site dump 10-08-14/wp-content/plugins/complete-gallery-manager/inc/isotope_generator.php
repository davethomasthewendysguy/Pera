<?php 
class cgm_isotope_generator_class {
	var $tmp_id = '';
	var $tmp_post_id = '';
	var $tmp_images = '';
	var $tmp_settings = '';
	var $tmp_type = '';
	var $tmp_folder  = 'cgm';
	var $tmp_file = 'css.css';
	var $tmp_categoryes = array();
	var $tmp_prewiev = false;
	var $tmp_prewiev_load_images = false;
	var $tmp_current_count = 0;
	var $tmp_auto_lock_w = 0;
	var $tmp_auto_lock_h = 0;
	var $tmp_auto_lock_s = '';
	var $imageGalleryCurrent = 0;
	var $imageGalleryTotal = 0;	

	function load_images_gallery_new($id,$images,$settings,$current_count,$overriteloadnumber){
		$this->tmp_id = $id;
		$this->tmp_images = json_decode(urldecode($images));
		$this->tmp_settings = json_decode(urldecode($settings));
		$this->tmp_current_count = $current_count;
		
		
		if(!empty($overriteloadnumber)){
			$this->tmp_settings->cgm_universallScroll->loadNumber = $overriteloadnumber;
		}

		$images = $this->images_generate();
		$more_images = true;
		
		if($this->imageGalleryCurrent>=$this->imageGalleryTotal){
			$more_images = false;
		}
		return array($more_images,$images);	
	}
	


	function cgm_drawIsoTope_gallery($id,$images,$settings,$type,$prewiev = false,$prewiev_load_images=false,$post_id=0,$tmp_extra=''){
		global $complete_gallery_manager_plugin;
		$container = '';
		$this->tmp_folder  = $complete_gallery_manager_plugin->tmp_folder;
		$this->tmp_file = $complete_gallery_manager_plugin->tmp_file;
		
		$upload_dir = wp_upload_dir();
		
		$this->tmp_id = $id;
		$this->tmp_post_id = $post_id; 
		
		$this->tmp_images = json_decode(urldecode($images));
		$this->tmp_settings = json_decode(urldecode($settings));
		$this->tmp_extra = json_decode(urldecode($tmp_extra));
		$this->tmp_type = $type;
		$this->tmp_prewiev = $prewiev;
		$this->tmp_prewiev_load_images = $prewiev_load_images;
		

		
		if($this->tmp_prewiev_load_images){
			$images = $this->images_generate();	
		}
		
		$checkversion = get_post_meta($post_id, "cgm_version",true);	
	
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
    		$container .=  '<link rel="stylesheet" type="text/css" href="'.$upload_dir['baseurl'].'/'.$this->tmp_folder.'/tmp_'.$this->tmp_post_id.$this->tmp_file.'?ver='.date('YmdHis').'" />';
    		$container .= '<script>cgm_loadcss(\''.$upload_dir['baseurl'].'/'.$this->tmp_folder.'/tmp_'.$this->tmp_post_id.$this->tmp_file.'\', "css");</script>';
		} else {
    		$container .=  '<link rel="stylesheet" type="text/css" href="'.$upload_dir['baseurl'].'/'.$this->tmp_folder.'/'.$this->tmp_post_id.$this->tmp_file.'?ver='.date('YmdHis').'" />';
		}


		$image_content = '';
		
		
		$image_content .= '<div class="cgm_isotype_bg_'.$this->tmp_post_id.'" style="display:none;" id="cgm_isotype_bg_'.$this->tmp_id.'">';
		if($this->tmp_prewiev_load_images){
			$image_content .= $images;
		} else {
			$this->get_auto_lock_data();
			if(!empty($this->tmp_images)){
				foreach($this->tmp_images as $tmp_img_key => $tmp_img_data){
					$tmp_cats = '';
					if(!empty($tmp_img_data->category)){
						foreach($tmp_img_data->category as $tmp_cat){
							if(!empty($tmp_cats)){
								$tmp_cats .= ' '; 
							}
								
							$this->tmp_categoryes[$tmp_cat] = $tmp_cat;
							$tmp_cats .= 'categoryid'.$tmp_cat;
						}
					}
				
					$tmp = $tmp[0] = $tmp[1] = $tmp[2] = '';
					
					if(!empty($tmp_img_data->imageselected ) and  $tmp_img_data->imageselected != 'custom'){
						$tmp = wp_get_attachment_image_src($tmp_img_data->postid, $tmp_img_data->imageselected);	
					} else if(!empty($tmp_img_data->customwidth) && !empty($tmp_img_data->customheight)){
						$tmp[1] = $tmp_img_data->customwidth;
						$tmp[2] = $tmp_img_data->customheight;
					}
					$image_content .= '<div data-row="'.$tmp_img_key.'" class="cgm_items cgm_loading cgm_loading_'.$tmp_img_key.' '.$tmp_cats.'" id="cgm_items" style="height:'.$tmp[2].'px;width:'.$tmp[1].'px;"></div>';
					
				}
			}
		}
		$image_content .= '</div>';
		
		if(!empty($this->tmp_settings->cgm_menu->pos->type) && ($this->tmp_settings->cgm_menu->pos->type == 'ldt' || $this->tmp_settings->cgm_menu->pos->type == 'sbst' || $this->tmp_settings->cgm_menu->pos->type == 'sbstb' || $this->tmp_settings->cgm_menu->pos->type == 'ldtb') && (!isset($this->tmp_settings->cgm_showmenu) || !empty($this->tmp_settings->cgm_showmenu))){
			$container .= '<div class="cgm_isotype_menu_'.$this->tmp_post_id.'" id="cgm_isotype_menu_'.$this->tmp_id.'">';

				$container .= $this->fullscreen_generate();	
				$container .= $this->sort_generate();
				$container .= $this->sort_order_generate();			
				$container .= $this->layout_generate();
				$container .= $this->filter_generate();
			$container .= '</div>';
		$container .= '<div class="clear" style="clear:both"></div>';
		}
		
		
		$container .= $image_content;
		$container .= '<div id="universall_scroll" class="universall_scroll"><div></div><span style="display:none">false</span></div>';
		
		if(!empty($this->tmp_settings->cgm_menu->pos->type) && ($this->tmp_settings->cgm_menu->pos->type == 'ldb' || $this->tmp_settings->cgm_menu->pos->type == 'sbsb'  || $this->tmp_settings->cgm_menu->pos->type == 'sbstb' || $this->tmp_settings->cgm_menu->pos->type == 'ldtb') && (!isset($this->tmp_settings->cgm_showmenu) || !empty($this->tmp_settings->cgm_showmenu))){
			$container .= '<div class="clear" style="clear:both"></div>';
			$container .= '<div class="cgm_isotype_menu_'.$this->tmp_post_id.'" id="cgm_isotype_menu_'.$this->tmp_id.'">';
				$container .= $this->fullscreen_generate();	
				$container .= $this->sort_generate();
				$container .= $this->sort_order_generate();
				$container .= $this->layout_generate();
				$container .= $this->filter_generate();
			$container .= '</div>';
		}
		
		$container .= '<div class="clear" style="clear:both"></div>';
		return $container;

	}

	function sort_order_generate(){
		$return_sortss = '';
		if(!empty($this->tmp_settings->cgm_sort)){
			if(!empty($this->tmp_settings->cgm_sort->order) && $this->tmp_settings->cgm_sort->order == 'true'){
				$return_sortss = '<div class="cgm_sort_order"><ul>';
				$sortdefault = 'ASC';
				if(!empty($this->tmp_settings->cgm_sort->directiondefault)){
					$sortdefault = $this->tmp_settings->cgm_sort->directiondefault;
				}
				if(!empty($this->tmp_extra->sortDir) && (strtoupper($this->tmp_extra->sortDir) == 'DESC' || strtoupper($this->tmp_extra->sortDir) == 'ASC')){
					$sortdefault = strtoupper($this->tmp_extra->sortDir);
				}
				
				
					
				
				
				
				$return_sortss .= '<li><a href="#" '.($sortdefault == 'ASC' ? 'class="selected"' : '').' onclick="cgm_sort_order_system('.$this->tmp_id.',true,this);return false;">Ascending</a></li>';
				$return_sortss .= '<li><a href="#" '.($sortdefault == 'DESC' ? 'class="selected"' : '').' onclick="cgm_sort_order_system('.$this->tmp_id.',false,this);return false">Descending</a></li>';
				$return_sortss .= '</ul></div>';		
			}		
		}
		
		return $return_sortss;
	}
	
	function fullscreen_generate(){
		$return = '';
		if(!empty($this->tmp_settings->cgm_fullscreenbutton)){
			if(!empty($this->tmp_settings->cgm_menu->pos->showtitle) && $this->tmp_settings->cgm_menu->pos->showtitle){
				$return .=	'<lable>'.__('Fullscreen','cgm').':</lable> ';
			}
			
			$tmp_text = '';
			$tmp_exittext = '';
			
			if(!empty($this->tmp_settings->cgm_fullscreentext)){
				$tmp_text = $this->tmp_settings->cgm_fullscreentext;
			}
			
			if(!empty($this->tmp_settings->cgm_fullscreenexittext)){
				$tmp_exittext = $this->tmp_settings->cgm_fullscreenexittext;
			}
			
			$return .= '<div class="cgm_sort"><ul><li><a id="cgm-iso-fullscreen-button" href="#" onclick="cgm_fn_iso_fullscreen('.$this->tmp_id.',this,\''.$tmp_text.'\',\''.$tmp_exittext.'\','.$this->tmp_settings->cgm_fullscreenbutton.');return false">'.$tmp_text.'</a></li></ul></div>';
		}
		
		return $return;
	}	

	function sort_generate(){
		$return_sort = '';
		if(!empty($this->tmp_settings->cgm_sort)){
			$sortdata = $this->tmp_settings->cgm_sort;
			$default = $sortdata->default;
			
			
			if(!empty($this->tmp_extra->sort)){
						$tmp = strtolower($this->tmp_extra->sort);
					}

			
			if(!empty($this->tmp_extra->sort) && ( $tmp == 'index' || $tmp == 'title' || $tmp == 'date' || $tmp == 'desc' || $tmp == 'link' || $tmp == 'imagesize' || $tmp == 'random')){
					
					if('imagesize' == $tmp){
						$default = 'imageSize';
					} else {
						$default = $tmp;
					}
					
			}
			
			
			
			if(!empty($this->tmp_settings->cgm_menu->pos->showtitle) && $this->tmp_settings->cgm_menu->pos->showtitle){
				$return_sort .=	'<lable>'.__('Sort','cgm').':</lable> ';
			}
			if(!empty($sortdata->index)){
				$return_sort .= '<li><a href="#" '.($default == 'index' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'index\',this);return false">Index</a></li>';
			}
			if(!empty($sortdata->title)){
				$return_sort .= '<li><a href="#" '.($default == 'title' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'title\',this);return false">Title</li>';
			}
			
			if(!empty($sortdata->date)){
				$return_sort .= '<li><a href="#" '.($default == 'date' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'date\',this);return false">Date</li>';
			}
			
			if(!empty($sortdata->desc)){
				$return_sort .= '<li><a href="#" '.($default == 'desc' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'desc\',this);return false">Description</li>';
			}

			if(!empty($sortdata->link)){
				$return_sort .= '<li><a href="#" '.($default == 'link' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'link\',this);return false">Link</li>';
			}
			if(!empty($sortdata->imageSize)){
				$return_sort .= '<li><a href="#" '.($default == 'imageSize' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'imageSize\',this);return false">Image Size</li>';
			}
			
			if(!empty($sortdata->random)){
				$return_sort .= '<li><a href="#" '.($default == 'random' ? 'class="selected"' : '').' onclick="cgm_sort_system('.$this->tmp_id.',\'random\',this);return false">Random</li>';
			}
			
			if(!empty($return_sort)){
				$return_sort = '<div class="cgm_sort"><ul>'.$return_sort.'</ul></div>';	
			}
		}
		return $return_sort;
	}
	
	function layout_generate(){
		$return_layout = '';
		if(!empty($this->tmp_settings->cgm_layout)){
			$tmp = $this->tmp_settings->cgm_layout;
			$default = $tmp->default;
			
			
			if(!empty($this->tmp_extra->layout)&&($this->tmp_extra->layout=='masonry'||$this->tmp_extra->layout=='fitRows'||$this->tmp_extra->layout=='cellsByRow'||$this->tmp_extra->layout=='straightDown'||$this->tmp_extra->layout=='masonryHorizontal'||$this->tmp_extra->layout=='fitColumns'||$this->tmp_extra->layout=='cellsByColumn'||$this->tmp_extra->layout=='straightAcross')){
					$default = $this->tmp_extra->layout;
			}	
			
			
			
			
			$default_height = '';
			if(!empty($this->tmp_settings->cgm_height)){
				$default_height = $this->tmp_settings->cgm_height.'px';
			} else {
				$default_height = '100%';
			}
			
			$default_width = '';
			if(!empty($this->tmp_settings->cgm_width)){
				$default_width = $this->tmp_settings->cgm_width.'px';
			} else {
				$default_width = '100%';
			}
			
			if(!empty($this->tmp_settings->cgm_menu->pos->showtitle) && $this->tmp_settings->cgm_menu->pos->showtitle){
				$return_layout .=	'<lable>'.__('Layout','cgm').':</lable> ';
			}
			
			if(!empty($tmp->masonry)){
				$return_layout .= '<li><a href="#" title="masonry" '.($default == 'masonry' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'masonry\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Masonry</a></li>';
			}
			if(!empty($tmp->fitRows)){
				$return_layout .= '<li><a href="#" title="fitRows" '.($default == 'fitRows' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'fitRows\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Fit Rows</a></li>';
			}
			if(!empty($tmp->cellsByRow)){
				$return_layout .= '<li><a href="#" title="cellsByRow" '.($default == 'cellsByRow' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'cellsByRow\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Cells By Row</a></li>';
			}

			if(!empty($tmp->straightDown)){
				$return_layout .= '<li><a href="#" title="straightDown" '.($default == 'straightDown' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'straightDown\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Straight Down</a></li>';
			}
			if(!empty($tmp->masonryHorizontal)){
				$return_layout .= '<li><a href="#" title="masonryHorizontal" '.($default == 'masonryHorizontal' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'masonryHorizontal\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Masonry Horizontal</a></li>';
			}

			if(!empty($tmp->fitColumns)){
				$return_layout .= '<li><a href="#" title="fitColumns" '.($default == 'fitColumns' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'fitColumns\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Fit Columns</a></li>';
			}			
			
			if(!empty($tmp->cellsByColumn)){
				$return_layout .= '<li><a href="#" title="cellsByColumn" '.($default == 'cellsByColumn' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'cellsByColumn\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Cells By Column</a></li>';
			}
			
			if(!empty($tmp->straightAcross)){
				$return_layout .= '<li><a href="#" title="straightAcross" '.($default == 'straightAcross' ? 'class="selected"' : '').' onclick="cgm_layout_system('.$this->tmp_id.',\'straightAcross\',\''.$default_width.'\',\''.$default_height.'\',this);return false;">Straight Across</a></li>';
			}			

			if(!empty($return_layout)){
				$return_layout = '<div class="cgm_layout"><ul>'.$return_layout.'</ul></div>';		
			}
		}
		return $return_layout;
	}
	
	function filter_generate(){
		$return_filter = '';
		$combination_filters = '';
		$default_cat = '';

		if(!empty($this->tmp_settings->cgm_filterscategory)){
			$combination_filters = json_decode(urldecode($this->tmp_settings->cgm_filterscategory));
		}
		
		if(!empty($this->tmp_extra->catID) && $this->tmp_extra->catID > 0){
				$default_cat = $this->tmp_extra->catID;
		}		
			

		$categorysort = '';


		if($this->tmp_settings->cgm_filtersDirrection == 'MANUALT'){
			
			if(!empty($this->tmp_settings->cgm_filtersSortOrder)){
				$categorysort = $saved_data = explode(',',$this->tmp_settings->cgm_filtersSortOrder);
			}
			
			$this->tmp_settings->cgm_filtersDirrection = 'ASC';
		}



		$taxonomies=get_categories(array('hide_empty' => 0,'taxonomy' => 'cgm-category','orderby' => 'name','order'=> $this->tmp_settings->cgm_filtersDirrection));
		
		
		if(!empty($categorysort) and !empty($taxonomies)){
			$taxonomies_bk = array();
			
			foreach($categorysort as $catsort){
				foreach($taxonomies as $tmpkey => $tmpss){
					if($tmpss->term_id == $catsort){
						$taxonomies_bk[] = (object)array('term_id' => $tmpss->term_id, 'name'=> $tmpss->name);
						unset($taxonomies[$tmpkey]);
						break;
					}
				}
			}
			
			if(!empty($taxonomies)){
				foreach($taxonomies as $tmpkey => $tmpss){
					$taxonomies_bk[] = (object)array('term_id' => $tmpss->term_id, 'name'=> $tmpss->name);
				}
			}
			$taxonomies = $taxonomies_bk;
		}
		
		
		
		
		
		
		if(!empty($this->tmp_settings->cgm_filters) and  !empty($combination_filters) and  count($combination_filters)>0){

			
			foreach($combination_filters as $combination_filter){
				$return_filter .= '<div class="cgm_filter"><ul>';

				if(!empty($this->tmp_settings->cgm_filtersShowLabel) && $this->tmp_settings->cgm_filtersShowLabel == 'true'){
					$return_filter .=	'<li><lable>'.__($combination_filter->name,'cgm').':</lable></li>';
				}				

				$return_filter .= '<li><a href="#"  rel=""';
				
				
				if(empty($default_cat)){
					$return_filter .= ' class="selected"';
				}
				
				$return_filter .= ' onclick="cgm_filter_combination_system('.$this->tmp_id.',\'\',this);return false">';
				
				
				if(!empty($this->tmp_settings->cgm_filtersAllText)){
					$return_filter .= $this->tmp_settings->cgm_filtersAllText;
				} else {
					$return_filter .= 'All';
				}
				
				$return_filter .= '</a></li>';

				foreach($taxonomies as $taxonomie){
					$tmp_name = '';
					$tmp_catid = '';
					if(!empty($combination_filter->data)){
						foreach($combination_filter->data as $tmp_cat){
							if($taxonomie->term_id == $tmp_cat && in_array($tmp_cat, $this->tmp_categoryes)){
								$tmp_name = $taxonomie->name;
							}
						}
					}

					if(!empty($tmp_name)){
						$return_filter .= '<li><a';
						
						if(!empty($default_cat) and $default_cat==$taxonomie->term_id){
							$return_filter .= ' class="selected"';
						}
				
						$return_filter .= ' rel="categoryid'.$taxonomie->term_id.'" href="#" onclick="cgm_filter_combination_system('.$this->tmp_id.',\'categoryid'.$taxonomie->term_id.'\',this);return false">'.$tmp_name.'</a></li>';	
					}
				}

				$return_filter .= '</ul></div>';
		
			}
			
		} else if(!empty($this->tmp_settings->cgm_filters) and count($this->tmp_categoryes)>0){
		
			$return_filter = '<div class="cgm_filter"><ul><li><a href="#"';
			
			if(empty($default_cat)){
				$return_filter .= ' class="selected"';
			}

			$return_filter .= ' onclick="cgm_filter_system('.$this->tmp_id.',\'*\',this);return false">';
			
			if(!empty($this->tmp_settings->cgm_filtersAllText)){
				$return_filter .= $this->tmp_settings->cgm_filtersAllText;
			} else {
				$return_filter .= 'All';
			}
			
			$return_filter .= '</a></li>';

			

			foreach($taxonomies as $taxonomie){
				$tmp_name = '';
				$tmp_catid = '';
				foreach($this->tmp_categoryes as $tmp_cat){
					if($taxonomie->term_id == $tmp_cat){
						$tmp_name = $taxonomie->name;
					}
				}
				if(!empty($tmp_name)){
					$return_filter .= '<li><a';
					
					if(!empty($default_cat) and $default_cat==$taxonomie->term_id){
						$return_filter .= ' class="selected"';
					}
					$return_filter .= ' href="#" onclick="cgm_filter_system('.$this->tmp_id.',\'categoryid'.$taxonomie->term_id.'\',this);return false">'.$tmp_name.'</a></li>';	
				}
			}

			$return_filter .= '</ul></div>';		
		}
		
		return $return_filter;
		
	}
	
	
	function get_auto_lock_data(){
		if(!empty($this->tmp_images->auto_lock_id) and !empty($this->tmp_images->auto_lock_type) ){
			$tmp_auto_lock_id = $this->tmp_images->auto_lock_id;
			$tmp_auto_lock_type = $this->tmp_images->auto_lock_type;
			if(!empty($this->tmp_images->auto_lock_w)){
				$this->tmp_auto_lock_w = $this->tmp_images->auto_lock_w;
			}
			$this->tmp_auto_lock_h = '';
			if(!empty($this->tmp_images->auto_lock_h)){
				$this->tmp_auto_lock_h = $this->tmp_images->auto_lock_h;
			}
			
			if(!empty($this->tmp_auto_lock_h) and !empty($this->tmp_auto_lock_w)){
				$this->tmp_auto_lock_s = 'custom';
			}
			
			if(!empty($this->tmp_images->auto_lock_s) and (empty($this->tmp_auto_lock_h) or empty($this->tmp_auto_lock_w))){
				$this->tmp_auto_lock_s = $this->tmp_images->auto_lock_s;
				$tmp_hw_tmp = $complete_gallery_manager_plugin->cgm_get_image_scalse($this->tmp_auto_lock_s);
				
				if('post-thumbnail' == $this->tmp_auto_lock_s){
					$this->tmp_auto_lock_s = 'thumbnail';
				} else if('large-feature' == $this->tmp_auto_lock_s){
					$this->tmp_auto_lock_s = 'large';
				} else if('small-feature' == $this->tmp_auto_lock_s){	
					$this->tmp_auto_lock_s = 'small';		
				} else {
					$this->tmp_auto_lock_s = 'custom';
				}
				
				
				if(!empty($tmp_hw_tmp)){
					$this->tmp_auto_lock_h = $tmp_hw_tmp['height'];
					$this->tmp_auto_lock_w = $tmp_hw_tmp['width'];
				}
				
			}

			$this->tmp_images = '';
		
			$my_wp_query = new WP_Query();
			$all_wp_pages = $my_wp_query->query(array('post_type' => 'page','post_status' => 'publish','numberposts'=> -1,'nopaging'=>true));
		
			$tmp_image_id_datas = explode(',', $tmp_auto_lock_id);
			if($tmp_auto_lock_type == 'post'){
				if(!empty($tmp_image_id_datas)){
					foreach ($tmp_image_id_datas as $tmp_taxonomie) {
						$querys = $my_wp_query->query( array( 'category__in' => array($tmp_taxonomie)));
						foreach($querys as $query){
							if(has_post_thumbnail($query->ID)){
								$this->tmp_images[$query->ID] = (object)array('postid' => get_post_thumbnail_id($query->ID),
														'attactedid' => $query->ID,
														'customwidth' => $this->tmp_auto_lock_w,
														'customheight' => $this->tmp_auto_lock_h,
														'imageselected' => $this->tmp_auto_lock_s,
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
														'customwidth' => $this->tmp_auto_lock_w,
														'customheight' => $this->tmp_auto_lock_h,
														'imageselected' => $this->tmp_auto_lock_s,
														'linkoverwrite' => 'default',
														'show' => "true",
														'typeobject' => 'page');
							
						}
					}	
				}
	
			}
			
		}	
	}
	
	function addLink($tmp_image,$click_function,$extra_css_caption,$show_decs,$full_screen_tmp){
		if(!empty($tmp_image->typeobject) and ($tmp_image->typeobject=='youtube' or $tmp_image->typeobject=='vimeo') and ($click_function == '1' || $click_function =='prettyPhoto')){
			return '<a style="display: block;'.$extra_css_caption.'" href="'.$tmp_image->link.'" rel="prettyPhoto[pp_gal]" title="'.($show_decs == 'true' ? $tmp_image->description : '').'">';
		} else if(!empty($click_function) and $click_function=='prettyPhoto'){
			return '<a style="display: block;'.$extra_css_caption.'" href="'.$full_screen_tmp.'" rel="prettyPhoto[pp_gal]" title="'.($show_decs == 'true' ? $tmp_image->description : '').'">';
		} else if(!empty($click_function) and $click_function=='click'){
			return '<a style="display: block;'.$extra_css_caption.'" href="'.$tmp_image->link.'">';
		} else if(!empty($click_function) and $click_function=='clickNew'){
			return '<a target="_black" style="display: block;'.$extra_css_caption.'" href="'.$tmp_image->link.'">';
		} else if(!empty($click_function) and $click_function !='1' and substr($click_function, 0, 2) == 'ex'){
			return '<a style="display: block;'.$extra_css_caption.'" href="#" onClick="cgm_changeImages('.$this->tmp_id.',this,\''.$click_function.'\');return false;" >';
		} else if(!empty($click_function) and $click_function !='1' and substr($click_function, 0, 3) == 'hex'){
			return '<a style="display: block;'.$extra_css_caption.'" href="#" onMouseOut="cgm_changeImages('.$this->tmp_id.',this,\''.$click_function.'\');return false;" onMouseOver="cgm_changeImages('.$this->tmp_id.',this,\''.$click_function.'\');return false;" onclick="return false;" >';
		} else {
			return '<a style="display: block;'.$extra_css_caption.'cursor: default;" href="#" onClick="return false" >';
		}	
	}
	
	function AddFigCaption($click_function,$extra_css_caption2,$tmp_image){
		$return_images = '';
		
		if(((!empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title)) or (!empty($this->tmp_settings->cgm_captions->showdecs) and $this->tmp_settings->cgm_captions->showdecs and $tmp_image->description )) and $this->tmp_settings->cgm_captions->type != 'title_below' and $this->tmp_settings->cgm_captions->type != 'none'){
			$return_images .= '<figcaption ';
			
			if(!empty($click_function) and $click_function !='1'){
				$return_images .= ' style="padding:0px;margin:0px;cursor:pointer;'.$extra_css_caption2.'" ';	
			} else if(!empty($this->tmp_settings->cgm_captions->type) == 'boxes'){
				$return_images .= ' style="'.$extra_css_caption2.'" ';
			}
	
			$return_images .= '>';
			if($this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title)){
				$return_images .= 	'<h1>'.$tmp_image->title.'</h1>';				
			}
			
			if($this->tmp_settings->cgm_captions->showdecs and !empty($tmp_image->description)){
				$return_images .= 	'<p>'.do_shortcode( $tmp_image->description).'</p>';				
			}
			$return_images .= '</figcaption>';
			$return_images .= '</figure>';
		}
		
		if(!empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title) and !empty($tmp_image->title) and $this->tmp_settings->cgm_captions->type == 'title_below'){
			$return_images .= 	'<div class="cgm_figcaption"><h1 style="padding: 0px; margin: 0px; line-height: '.$imageselected_h_tmp.'px;">'.$tmp_image->title.'</h1></div>';
		
		} else if(!empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title) and !empty($tmp_image->title) and $this->tmp_settings->cgm_captions->type == 'title_decs_below'){
			$return_images .= 	'<div class="cgm_figcaption"><h1 style="padding: 0px; margin: 0px; line-height: '.$imageselected_h_tmp.'px;">'.$tmp_image->title.'</h1><p>'.$tmp_image->description.'</p></div>';
		
		}	
		
		return $return_images;
		
	}

	function addTopIcons($tmp_image,$click_function){
		if(!empty($this->tmp_settings->cgm_overlayicon->video) && $this->tmp_settings->cgm_overlayicon->video && ($tmp_image->typeobject=='youtube' or $tmp_image->typeobject=='vimeo')){
			return '<img id="cgm_video_play_icon" src="'.COMPLETE_GALLERY_URL.'images/video_icon@2x.png" alt="'.$tmp_image->title.'" style="box-shadow:none !important;" />';
		} else if(!empty($this->tmp_settings->cgm_overlayicon->gallary) && $this->tmp_settings->cgm_overlayicon->gallary && ($tmp_image->typeobject=='gallery')){
			return '<img id="cgm_video_play_icon" src="'.COMPLETE_GALLERY_URL.'images/gallery_icon@2x.png" alt="'.$tmp_image->title.'" style="box-shadow:none !important;" />';
		} else if(!empty($this->tmp_settings->cgm_overlayicon->post) && $this->tmp_settings->cgm_overlayicon->post  && $tmp_image->typeobject=='post' && $click_function != '1'){
			return '<img id="cgm_video_play_icon" src="'.COMPLETE_GALLERY_URL.'images/post_icon@2x.png" alt="'.$tmp_image->title.'" style="box-shadow:none !important;" />';
		} else if(!empty($this->tmp_settings->cgm_overlayicon->page) && $this->tmp_settings->cgm_overlayicon->page  && $tmp_image->typeobject=='page'  && $click_function != '1'){
			return '<img id="cgm_video_play_icon" src="'.COMPLETE_GALLERY_URL.'images/pages_icon@2x.png" alt="'.$tmp_image->title.'" style="box-shadow:none !important;" />';
		} else if(!empty($this->tmp_settings->cgm_overlayicon->link) && $this->tmp_settings->cgm_overlayicon->link && ($click_function=='clickNew' or $click_function=='click')){
			return '<img id="cgm_video_play_icon" src="'.COMPLETE_GALLERY_URL.'images/link_icon@2x.png" alt="'.$tmp_image->title.'" style="box-shadow:none !important;" />';
		}
else if(!empty($this->tmp_settings->cgm_overlayicon->prettyphoto) && $this->tmp_settings->cgm_overlayicon->prettyphoto &&  $click_function=='prettyPhoto' && $click_function != '1'){
			return '<img id="cgm_video_play_icon" src="'.COMPLETE_GALLERY_URL.'images/prettyphoto_icon@2x.png" alt="'.$tmp_image->title.'" style="box-shadow:none !important;" />';
		} else {
			return '';
		}
	}
	
	
	function images_generate(){
		global $wpdb,$complete_gallery_manager_plugin,$wp_version;
		
		$upload_dir = wp_upload_dir();
		$click_functions = '';
		$total_number = 0;
		$show_decs = '';
		$return_images = '';
		$return_array = array();
		
		
		if(!empty($this->tmp_settings->cgm_mouseEventClick) and $this->tmp_settings->cgm_mouseEventClick != 1){
			$click_functions = $this->tmp_settings->cgm_mouseEventClick;
		}
		
		if(!empty($this->tmp_settings->cgm_universallScroll) and !empty($this->tmp_settings->cgm_universallScroll->loadNumber) and $this->tmp_settings->cgm_universallScroll->loadNumber > 0){
			$total_number = $this->tmp_settings->cgm_universallScroll->loadNumber;
		}
		
		if(!empty($this->tmp_settings->cgm_pretty) and !empty($this->tmp_settings->cgm_pretty->showdecs) and $this->tmp_settings->cgm_pretty->showdecs){
			$show_decs = $this->tmp_settings->cgm_pretty->showdecs;
		}
		
		$tmp_pm_css = '';
		
		if(!empty($this->tmp_settings->cgm_item)){
			if(!empty($this->tmp_settings->cgm_item->margin)){
				$tmp_pm_css .= 'margin:'.$this->tmp_settings->cgm_item->margin.';';
			}
			
			if(!empty($this->tmp_settings->cgm_item->padding)){
				$tmp_pm_css .= 'padding:'.$this->tmp_settings->cgm_item->padding.';';
			}	
		}

		
		$count_image = 1;
		$count_image_total = 1;


		$this->get_auto_lock_data();

		if(!empty($this->tmp_images)){	
			foreach($this->tmp_images as $tmp_image_key => $tmp_image){
				if($count_image > $this->tmp_current_count || $this->tmp_current_count == 0){
					if($count_image > ($total_number+$this->tmp_current_count) &&  $total_number > 0){
						$count_image_total++;
					} else {
						$imageselected = 0;
				
						$click_function = $click_functions;
						
						

						if(!empty($tmp_image->linkoverwrite) and $tmp_image->linkoverwrite != 'default' ){
							$click_function = $tmp_image->linkoverwrite;
						} else {
							if($tmp_image->typeobject=='gallery'){
								$click_function = 'clickNew';
							}
							
						}
						

						$post_exists = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '" . $tmp_image->postid . "'", 'ARRAY_A');
						
						
						$tmp_image->date = '00000000';

						if(!empty($tmp_image->show) and $tmp_image->show == 'true' && !empty($post_exists)){
							if(!empty($post_exists['post_date'])){
								$tmp_image->date = date("YmdHis",strtotime($post_exists['post_date']));
							}
						
							if(!empty($tmp_image->imageselected)){
								$imageselected = $tmp_image->imageselected;
							}
							$imageselected_w = '';
							$imageselected_h = '';
							$imageselected_url = '';
							
							if(!empty($this->tmp_prewiev_load_images)){
								$tmp_cats = '';
								if(!empty($tmp_image->category)){
									foreach($tmp_image->category as $tmp_cat){
										if(!empty($tmp_cats)){
											$tmp_cats .= ' '; 
										}
										
										$this->tmp_categoryes[$tmp_cat] = $tmp_cat;
										$tmp_cats .= 'categoryid'.$tmp_cat;
									}
								}
							}
		
							if(!empty($tmp_image->attactedid) and is_numeric($tmp_image->attactedid)){
							
								$post_tmp = get_post($tmp_image->attactedid); 

								$tmp_image->title = $post_tmp->post_title;
								$tmp_image->date = date('YmdHis',strtotime($post_tmp->post_date));
								$tmp_image->link = get_permalink($tmp_image->attactedid);
								if(empty($tmp_image->typeobject) or $tmp_image->typeobject != 'gallery'){
									$tmp_image->description = strip_tags($post_tmp->post_content);
								}
							}
							

							if(!empty($this->tmp_settings->cgm_captions->maxNumberWord)){
								$tmp_image->description = $complete_gallery_manager_plugin->wordlimit($tmp_image->description,$this->tmp_settings->cgm_captions->maxNumberWord,$this->tmp_settings->cgm_captions->maxNumberWordIndicator);
							}
				
							$tmp_imgs = '';
							$tmp_type_sizes = array('thumbnail','medium','large','full','custom');
							
							
							if(!empty($this->tmp_images->auto_lock_id) and !empty($this->tmp_images->auto_lock_type) and !empty($this->tmp_auto_lock_w) and !empty($this->tmp_auto_lock_h)){
								$tmp_image->customwidth = $this->tmp_auto_lock_w;
								$tmp_image->customheight = $this->tmp_auto_lock_h;
								$imageselected = 'custom';
							}
							
							
							
							
							foreach($tmp_type_sizes as $tmp_type_size){
								if($tmp_type_size == 'custom'){
									$tmp_infoff = wp_get_attachment_image_src($tmp_image->postid,'full');
									$tmp_infos = get_post_meta($tmp_image->postid, '_wp_attached_file', true); 

									if(substr($tmp_infos, 0, 1) != '/'){
										$tmp_infos = '/'.$tmp_infos;
									}

									$tmp_info = pathinfo($tmp_infos);
									
									if(!empty($tmp_image->customwidth) and !empty($tmp_image->customheight)){
										$tmp_name = $upload_dir['basedir'].$tmp_info['dirname'].'/'.$tmp_info['filename'].'-'.$tmp_image->customwidth.'x'.$tmp_image->customheight.'.'.$tmp_info['extension'];
										
										if (file_exists($tmp_name)) {
											$tmp_loaded[0] = $upload_dir['baseurl'].$tmp_info['dirname'].'/'.$tmp_info['filename'].'-'.$tmp_image->customwidth.'x'.$tmp_image->customheight.'.'.$tmp_info['extension'];
											$tmp_loaded[1] = $tmp_image->customwidth;
											$tmp_loaded[2] = $tmp_image->customheight;

										} else {
											
											if($wp_version >= 3.5){
												$tmp_tmp_image = wp_get_image_editor( $upload_dir['basedir'].$tmp_infos );
												if ( ! is_wp_error( $tmp_tmp_image ) ) {
													$tmp_tmp_image->resize( $tmp_image->customwidth,$tmp_image->customheight,1);
													$tmp_tmp_image->save( $tmp_name );

													$tmp_loaded[0] = $upload_dir['baseurl'].$tmp_info['dirname'].'/'.$tmp_info['filename'].'-'.$tmp_image->customwidth.'x'.$tmp_image->customheight.'.'.$tmp_info['extension'];
													$tmp_loaded[1] = $tmp_image->customwidth;
													$tmp_loaded[2] = $tmp_image->customheight;
												} else {
													$tmp_standart = image_resize( ($upload_dir['basedir'].$tmp_infos), $tmp_image->customwidth,$tmp_image->customheight,1);
													if(is_object($tmp_standart)){
														$tmp_loaded = $tmp_infoff;
													} else {
														$tmp_tmp_name = basename($tmp_standart);
														$tmp_tmp_size = explode("-", $tmp_tmp_name);
														$tmp_tmp_size = explode(".", $tmp_tmp_size[(count($tmp_tmp_size)-1)]);
														$tmp_tmp_size = explode("x", $tmp_tmp_size[(count($tmp_tmp_size)-2)]);
				
														$tmp_loaded[0] = $upload_dir['baseurl'].$tmp_info['dirname'].'/'.$tmp_info['filename'].'-'.$tmp_image->customwidth.'x'.$tmp_image->customheight.'.'.$tmp_info['extension'];
														$tmp_loaded[1] = $tmp_image->customwidth;
														$tmp_loaded[2] = $tmp_image->customheight;
													};
												}
											} else {
												$tmp_standart = image_resize( ($upload_dir['basedir'].$tmp_infos), $tmp_image->customwidth,$tmp_image->customheight,1);
		
		
												if(is_object($tmp_standart)){
													$tmp_standart = image_resize( ($upload_dir['basedir'].$tmp_infos), $tmp_image->customwidth,$tmp_image->customheight,1);
												}
		
												if(is_object($tmp_standart)){
													$tmp_standart = image_resize( ($upload_dir['basedir'].$tmp_info['dirname'].'/'. $tmp_info['filename'].'-'.$tmp_infoff[1].'x'.$tmp_infoff[2].'.'. $tmp_info['extension']), $tmp_image->customwidth,$tmp_image->customheight,1);
												}
		
												if(is_object($tmp_standart)){
													$tmp_loaded = $tmp_infoff;
												} else {
													$tmp_tmp_name = basename($tmp_standart);
													$tmp_tmp_size = explode("-", $tmp_tmp_name);
													$tmp_tmp_size = explode(".", $tmp_tmp_size[(count($tmp_tmp_size)-1)]);
													$tmp_tmp_size = explode("x", $tmp_tmp_size[(count($tmp_tmp_size)-2)]);
			
													$tmp_loaded[0] = $upload_dir['baseurl'].$tmp_info['dirname'].'/'.$tmp_info['filename'].'-'.$tmp_image->customwidth.'x'.$tmp_image->customheight.'.'.$tmp_info['extension'];
													$tmp_loaded[1] = $tmp_image->customwidth;
													$tmp_loaded[2] = $tmp_image->customheight;	
												};
											}
										}
										
										

										

									}
								} else {
									$tmp_loaded = wp_get_attachment_image_src($tmp_image->postid,$tmp_type_size);
								}
							
								if($tmp_type_size != 'custom' || ($tmp_type_size == 'custom' && !empty($tmp_image->customwidth) && !empty($tmp_image->customheight))){
								$tmp_imgs .= '<div style="display:none" class="dif_img';
								
								
								if($imageselected == $tmp_type_size){
									$tmp_imgs .= ' current';
									$imageselected_w = $tmp_loaded[1];
									$imageselected_h = $tmp_loaded[2];
									$imageselected_url = $tmp_loaded[0];
								}
		
								if($tmp_type_size == 'full'){
									$full_screen_tmp = $tmp_loaded[0];
									
								}
		
		
								$tmp_imgs .= '">';
								$tmp_imgs .= '<span class="height">'.$tmp_loaded[2].'</span>';
								$tmp_imgs .= '<span class="width">'.$tmp_loaded[1].'</span>';
								$tmp_imgs .= '<span class="url">'.$tmp_loaded[0].'</span>';
								$tmp_imgs .= '</div>';
								}
							}

							if(empty($this->tmp_prewiev_load_images)){
								$return_images = '';
							} else {
								$return_images .= '<div id="cgm_items" class="cgm_items '.$tmp_cats.'" style="';
							}
							$imageselected_h_tmp = '';							
							if(!empty($this->tmp_settings->cgm_captions->h1->fontSize) and !empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title) and !empty($tmp_image->title) and $this->tmp_settings->cgm_captions->type == 'title_below'){
								$imageselected_h_tmp = $this->tmp_settings->cgm_captions->h1-fontSize + ($this->tmp_settings->cgm_captions->h1->fontSize)+10;
							}
							
							if(!empty($this->tmp_settings->cgm_captions->type) && $this->tmp_settings->cgm_captions->type == 'boxes'){
								$return_images .= 'border:none !important;';
								$return_images .= 'background:none !important;';
							}	
							
							$return_images .= 'width:'.$imageselected_w.'px;';
							$return_images .= $tmp_pm_css;
							$return_images .= 'height:'.($imageselected_h+$imageselected_h_tmp).'px;"';
		
		
							if(empty($this->tmp_prewiev_load_images)){
								$tmp_styles = $return_images;
								$return_images = '';
							} else {
								$return_images .= '>';
							}
		
							$tmp_image->title = __($tmp_image->title,"cgm");
							$tmp_image->description = __($tmp_image->description,"cgm");
							$tmp_image->title = strip_tags($tmp_image->title);
							$tmp_image->title = str_replace('"', '\'', $tmp_image->title);
							$tmp_image->description = str_replace('"', '\'', $tmp_image->description);
							
									
							if(((!empty($this->tmp_settings->cgm_captions->showtitle) and $this->tmp_settings->cgm_captions->showtitle and !empty($tmp_image->title)) or (!empty($this->tmp_settings->cgm_captions->showdecs) and $this->tmp_settings->cgm_captions->showdecs and $tmp_image->description )) and $this->tmp_settings->cgm_captions->type != 'title_below' and $this->tmp_settings->cgm_captions->type != 'none'){
								$return_images .= '<figure class="captions '.$this->tmp_settings->cgm_captions->type.'" ';
															
									if(!empty($this->tmp_settings->cgm_captions->type) && $this->tmp_settings->cgm_captions->type == 'boxes'){
										$return_images .= ' style="width:'.$imageselected_w.'px;height:'.$imageselected_h.'px;" ';
									}	
								
								$return_images .= '>';

							}
							
							$extra_css_caption = '';
							$extra_css_caption2 = '';
							if(!empty($this->tmp_settings->cgm_captions->type) && $this->tmp_settings->cgm_captions->type == 'boxes'){
								$extra_css_caption = '-moz-transform:  rotateX(90deg) translateZ('.($imageselected_w/2).'px);
  -webkit-transform:rotateX(90deg) translateZ('.($imageselected_h/2).'px);
  -ms-transform:rotateX(90deg) translateZ('.($imageselected_h/2).'px);
  -o-transform:rotateX(90deg) translateZ('.($imageselected_h/2).'px);
  transform:rotateX(90deg) translateZ('.($imageselected_h/2).'px);';
  
								$extra_css_caption2 = '-moz-transform:  rotateX(0deg) translateZ('.($imageselected_w/2).'px);
  -webkit-transform:rotateX(0deg) translateZ('.($imageselected_h/2).'px) ;
  -ms-transform:rotateX(0deg) translateZ('.($imageselected_h/2).'px);
  -o-transform:rotateX(0deg) translateZ('.($imageselected_h/2).'px) ;
  transform:rotateX(0deg) translateZ('.($imageselected_h/2).'px);';
  					
								$extra_css_caption .= 'height:'.$imageselected_h.'px;width:'.$imageselected_w.'px;';
								$extra_css_caption2 .= 'height:'.$imageselected_h.'px;width:'.$imageselected_w.'px;';
							}
							
							

								$return_images .= $this->addLink($tmp_image,$click_function,$extra_css_caption,$show_decs,$full_screen_tmp);

								$return_images .= '<img src="'.$imageselected_url.'" style="width:'.$imageselected_w.'px;height:'.$imageselected_h.'px;padding:0px;margin:0px;visibility: visible !important;" alt="'.$tmp_image->title.'" />';

								$return_images .= $this->addTopIcons($tmp_image,$click_function);


		
								$return_images .= '<div class="default_image" style="display:none">'.$imageselected.'</div>';
								$return_images .= '<div class="index" style="display:none">'.$tmp_image_key.'</div>';
								$return_images .= '<div class="title" style="display:none">'.$tmp_image->title.'</div>';					
								$return_images .= '<div class="tag" style="display:none">'.$tmp_image->link.'</div>';								
								$return_images .= '<div class="random" style="display:none">'.rand(1,10000).'</div>';
								$return_images .= '<div class="date" style="display:none">'.$tmp_image->date.'</div>';
								$return_images .= '<div class="desc" style="display:none">'.$tmp_image->description.'</div>';
								$return_images .= '<div class="size" style="display:none">'.($imageselected_w*$imageselected_h).'</div>';		
								
								if($click_function!='click' and $click_function!='clickNew' and $click_function!='prettyPhoto' and $click_function !='1'){								
									$return_images .= '<div class="imageSize" style="display:none"> '. $tmp_imgs . '</div>';
								}
									$return_images .= '</a>';

								$return_images .= $this->AddFigCaption($click_function,$extra_css_caption2,$tmp_image);

							if(empty($this->tmp_prewiev_load_images)){
								$return_array[]=array('style'=>$tmp_styles,'content'=>$return_images,'ID'=>($tmp_image_key));
							} else {
								$return_images .= '</div>';
							}
								
							$count_image_total++;
							$count_image++;					
						}
					}
				}	else {
					$count_image_total++;
					$count_image++;
				}
			if(!empty($tmp_image->category)){
				foreach($tmp_image->category as $tmp_cat){
					$this->tmp_categoryes[$tmp_cat] = $tmp_cat;
				}
			}
	
			}
		}
		
		$this->imageGalleryCurrent = $count_image;
		$this->imageGalleryTotal = $count_image_total;
		
		if(empty($this->tmp_prewiev_load_images)){
			return $return_array;
		} else {
			return $return_images;
		}
		
		
	}
	
	function css_generate($rendertomainfile = false){
		global $complete_gallery_manager_plugin;
	
		$tmp_css = '';
	
		if(!empty($this->tmp_settings->cgm_animation->type) && $this->tmp_settings->cgm_animation->type != 'jQuery'){

			$tmp_css .= '.isotope .isotope-item {';
			$tmp_css .= 	'-webkit-transition-duration: 0.8s !important;';
			$tmp_css .= 	'-moz-transition-duration: 0.8s !important;';
			$tmp_css .= 	'-ms-transition-duration: 0.8s !important;';
			$tmp_css .= 	'-o-transition-duration: 0.8s !important;';
			$tmp_css .= 	'transition-duration: 0.8s !important;';
			$tmp_css .= '}';
			
			if(!empty($this->tmp_settings->cgm_animation->duration)){
				$dub = $this->tmp_settings->cgm_animation->duration;
				$dub = number_format(($dub/1000), 2, '.', '');
				$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.'.isotope .isotope-item {';
				$tmp_css .= 	'-webkit-transition-duration: '.$dub.'s !important;';
				$tmp_css .= 	'-moz-transition-duration: '.$dub.'s !important;';
				$tmp_css .= 	'-ms-transition-duration: '.$dub.'s !important;';
				$tmp_css .= 	'-o-transition-duration: '.$dub.'s !important;';
				$tmp_css .= 	'transition-duration: '.$dub.'s !important;';
				$tmp_css .= '}';
			}
			
				$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.'.isotope {-webkit-transition-property: height, width;-moz-transition-property: height, width;-ms-transition-property: height, width;-o-transition-property: height, width;transition-property: height, width;}';
				$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.'.isotope .isotope-item {-webkit-transition-property: -webkit-transform, opacity;-moz-transition-property:    -moz-transform, opacity;-ms-transition-property:-ms-transform, opacity;-o-transition-property:top, left, opacity;transition-property:transform, opacity;}';	
			
			$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.'.isotope.no-transition,
			.isotope.no-transition .isotope-item,
			.isotope .isotope-item.no-transition {
			  -webkit-transition-duration: 0s;
			     -moz-transition-duration: 0s;
			      -ms-transition-duration: 0s;
			       -o-transition-duration: 0s;
			          transition-duration: 0s;
			}';
		}
		
		$tmp_css .= '.completegallery'.$this->tmp_post_id.' .isotope-hidden {display: none !important;}';
		
		// --------------- background start -------------------------
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' {';
		if(!empty($this->tmp_settings->cgm_height)){
			$tmp_css .= 'height:'.$this->tmp_settings->cgm_height.'px !important;';
		}
		
		if($this->tmp_prewiev){
			$tmp_css .= 'min-height:200px !important;';
		} else {
			$tmp_css .= 'min-height:150px !important;';
		}
			
		$tmp_css .= 'overflow:hidden !important;';
		
		if(!empty($this->tmp_settings->cgm_width)){
			$tmp_css .= 'width:'.$this->tmp_settings->cgm_width.'px !important;';
		} else {
			$tmp_css .= 'width:100% !important;';
		}
		
		if(!empty($this->tmp_settings->cgm_background)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_background);	
		}
		$tmp_css .= '}';	
		// --------------- background end -------------------------

		// --------------- Captions start -------------------------
		$tmp_css .='.cgm_isotype_bg_'.$this->tmp_post_id.' #cgm_video_play_icon {left: 50% !important;margin-left: -48px !important;margin-top: -48px !important;position: absolute !important;top: 50% !important;height: 96px !important;width: 96px; !important;background-size: contain;';

			if(!empty($this->tmp_settings->cgm_overlayicon->opacity)){
				$tmp_css .='opacity: '.$this->tmp_settings->cgm_overlayicon->opacity.' !important;';
			} else {
				$tmp_css .='opacity: 0.9  !important;';
			}

		$tmp_css .='}';

		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items figcaption h1, .cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items .cgm_figcaption h1 {margin-bottom: 0px !important;padding-bottom: 0px !important;margin-top: 0 !important;padding-top: 0 !important;';
		if(!empty($this->tmp_settings->cgm_captions->h1)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_captions->h1);	
		}
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items figcaption p, .cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items .cgm_figcaption p {';
		$tmp_css .= 'word-wrap: break-word;margin-bottom: 0 !important;padding-bottom: 0 !important;margin-top: 0 !important;padding-top: 0 !important;';
		if(!empty($this->tmp_settings->cgm_captions->p)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_captions->p);	
		}
		$tmp_css .= 'line-height: 130% !important;';
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items figure {';
		
		if(!empty($this->tmp_settings->cgm_captions->type) && ($this->tmp_settings->cgm_captions->type == 'flip horizontal' || $this->tmp_settings->cgm_captions->type == 'flip vertical')){
		} else {
			$tmp_css .= 'overflow: hidden !important;';
		}		
		if(!empty($this->tmp_settings->cgm_background->borderRadius)){
			$tmp_css .= 'border-radius:'.$this->tmp_settings->cgm_background->borderRadius.'px !important;';
		} else if(!empty($this->tmp_settings->cgm_item->borderRadius)){
			$tmp_css .= 'border-radius:'.$this->tmp_settings->cgm_item->borderRadius.'px !important;';
		}
		$tmp_css .= '}';
				
					
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items .cgm_figcaption {';
		if(!empty($this->tmp_settings->cgm_captions)){
			$tmp = $this->tmp_settings->cgm_captions;
			if(!empty($tmp->align)){$tmp_css .= 'text-align:'.$tmp->align.' !important;';}	
			if(!empty($tmp->padding)){$tmp_css .= 'padding:'.$tmp->padding.' !important;';}	
		}
		$tmp_css .= '}';
				
				
				
				
				

		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items figcaption {';
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

		// --------------- Items start -------------------------
		
		$tmp_css .= '.cgm_loading {';
		$tmp_css .= 'background-image:url("'.COMPLETE_GALLERY_URL.'images/loader2.png") !important;';
		$tmp_css .= 'background-size:32px 10px !important;';
		$tmp_css .= 'background-repeat: no-repeat !important;';
		$tmp_css .= 'background-position: center center !important;';
		$tmp_css .= 'opacity: 0.2 !important;';	

		
		$tmp_css .= '}';
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items .dif_img {display:none;}';
		
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items img {';
		$tmp_css .= 'max-width: none !important;';
		$tmp_css .= 'min-width: none !important;';
		$tmp_css .= 'margin: 0px !important;';
		if(!empty($this->tmp_settings->cgm_item)){
			$itemdata = $this->tmp_settings->cgm_item;
			if(!empty($itemdata->imageRadius)){$tmp_css .= 'border-radius:'.$itemdata->imageRadius.'px !important;';}
		}
		$tmp_css .= '}';	
		
		
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items img, .cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items a , .cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items span , .cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items div {
		
		-moz-transition:0.2s linear;
		-webkit-transition:0.2s linear;
		-o-transition:0.2s linear;
		-ms-transition:0.2s linear;
		transition:0.2s linear;
		}';
		
		$tmp_css .= '.cgm_isotype_bg_'.$this->tmp_post_id.' .cgm_items {';
		$tmp_css .= 'max-width: none !important;';
		$tmp_css .= 'min-width: none !important;';
		
		if(!empty($this->tmp_settings->cgm_captions) and ($this->tmp_settings->cgm_captions->type == 'title_decs_below' or $this->tmp_settings->cgm_captions->type == 'title_below')){
			$tmp_css .= 'height: auto !important;';
		}
		
		if(!empty($this->tmp_settings->cgm_item)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_item);		
		}
		$tmp_css .= '}';	
		// --------------- background end -------------------------
	
		// --------------- li ul start ----------------------------
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' ul {';
		$tmp_css .= 'list-style: none outside none !important;';
		$tmp_css .= 'margin: 0 !important;';
		$tmp_css .= 'list-style: none !important;';
		$tmp_css .= '}';

		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' ul ul {';
		$tmp_css .= 'margin-left: 1.5em !important;';
		$tmp_css .= 'list-style: none !important;';
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li {';
		$tmp_css .= 'float: left !important;';
		$tmp_css .= 'margin-bottom: 0.2em !important;';
		$tmp_css .= 'margin: 0px !important;';
		$tmp_css .= 'padding: 0px !important;';
		$tmp_css .= 'background: none !important;';
		$tmp_css .= 'list-style: none !important;';
		$tmp_css .= 'background-image: none !important;';
		$tmp_css .= 'content: "" !important;';
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:before {';
		$tmp_css .= 'list-style: none !important;';
		$tmp_css .= 'content: "" !important;';
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:after {';
		$tmp_css .= 'list-style: none !important;';
		$tmp_css .= 'content: "" !important;';
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a {';
		$tmp_css .= 'line-height: 24px !important;';
		$tmp_css .= 'list-style: none !important;';
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a:active {';

			if(!empty($this->tmp_settings->cgm_menu) and !empty($this->tmp_settings->cgm_menu->pushed)){
				$tmp = $this->tmp_settings->cgm_menu->pushed;
				$textshadowopacity = 0;
				$textshadowcolor = '#';
			
				if(!empty($tmp->textShadowOpacity)){$textshadowopacity = $tmp->textShadowOpacity;}
				if(!empty($tmp->textShadowColor)){$textshadowcolor = $tmp->textShadowColor;}
				if(!empty($textshadowopacity) and !empty($textshadowcolor)  and $textshadowcolor != '#'){
					$shadowrbg = $complete_gallery_manager_plugin->HexToRGB(str_replace('#','',$textshadowcolor));
					$tmp_css .= 'box-shadow: ';
					
					$textShadowX = 0;
					$textShadowY = 0;
					$textShadowBlue = 0;
					
					if(!empty($tmp->textShadowX)){$textShadowX = $tmp->textShadowX;}
					if(!empty($tmp->textShadowY)){$textShadowY = $tmp->textShadowY;}
					if(!empty($tmp->textShadowBlue)){$textShadowBlue = $tmp->textShadowBlue;}
					
					$tmp_css .= $textShadowX.'px ';
					$tmp_css .= $textShadowY.'px ';
					$tmp_css .= $textShadowBlue.'px ';
					$tmp_css .= ' rgba('.$shadowrbg['r'].','.$shadowrbg['g'].','.$shadowrbg['b'].','.$textshadowopacity.') ';
					$tmp_css .= ' inset;';
				}	
			} else {
				$tmp_css .= 'box-shadow: 0 0px 0px rgba(0, 0, 0, 0.6) inset;';
			}

		$tmp_css .= '}';

		if(!empty($this->tmp_settings->cgm_menu) and !empty($this->tmp_settings->cgm_menu->border) and !empty($this->tmp_settings->cgm_menu->border->borderSeperator)){
			$tmp_color['r'] = '255';
			$tmp_color['g'] = '255';
			$tmp_color['b'] ='255';

			if(!empty($this->tmp_settings->cgm_menu->border->borderColor)){
				$tmp_color = $complete_gallery_manager_plugin->HexToRGB($this->tmp_settings->cgm_menu->border->borderColor);
			}
		
			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a {';
			$tmp_css .= 'border-left: 1px solid rgba('.$tmp_color['r'].', '.$tmp_color['g'].', '.$tmp_color['b'].', 0.3);';
			$tmp_css .= 'border-right: 1px solid rgba(0, 0, 0, 0.2);';
			$tmp_css .= '}';
		} else {
			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a {';
			$tmp_css .= 'border-left: 0px solid rgba(255, 255, 255, 0.3);';
			$tmp_css .= 'border-right: 0px solid rgba(0, 0, 0, 0.2);';
			$tmp_css .= '}';
		}
		
		if(!empty($this->tmp_settings->cgm_menu) and !empty($this->tmp_settings->cgm_menu->border) and !empty($this->tmp_settings->cgm_menu->border->borderRadius)){
		
			if(!empty($this->tmp_settings->cgm_filterscategory)){
				$combination_filters = json_decode(urldecode($this->tmp_settings->cgm_filterscategory));	
			}

			if(!empty($this->tmp_settings->cgm_filters) and  !empty($combination_filters) and  count($combination_filters)>0 and !empty($this->tmp_settings->cgm_filtersShowLabel) && $this->tmp_settings->cgm_filtersShowLabel == 'true'){
			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:nth-child(2) a {';
			$tmp_css .= 'border-radius: '.$this->tmp_settings->cgm_menu->border->borderRadius.'px 0 0 '.$this->tmp_settings->cgm_menu->border->borderRadius.'px !important;';
			$tmp_css .= '}';
			} else {
			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:first-child a {';
			$tmp_css .= 'border-left: medium none !important;';
			$tmp_css .= 'border-radius: '.$this->tmp_settings->cgm_menu->border->borderRadius.'px 0 0 '.$this->tmp_settings->cgm_menu->border->borderRadius.'px !important;';
			$tmp_css .= '}';	
			}
			
			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:last-child a {';
			$tmp_css .= 'border-radius: 0 '.$this->tmp_settings->cgm_menu->border->borderRadius.'px '.$this->tmp_settings->cgm_menu->border->borderRadius.'px 0 !important;';
			$tmp_css .= '}';
		} else {
			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:first-child a {';
			$tmp_css .= 'border-left: medium none !important;';
			$tmp_css .= 'border-radius: 0 !important;';
			$tmp_css .= '}';

			$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:last-child a {';
			$tmp_css .= 'border-radius: 0 !important;';
			$tmp_css .= '}';
		}
		
		if(!empty($this->tmp_settings->cgm_menu) and !empty($this->tmp_settings->cgm_menu->border)){
			$tmp = $this->tmp_settings->cgm_menu->border;

			if(empty($tmp->borderStyle) or $tmp->borderStyle == 'none'){
				$tmp_s = '';
			} else {
				$tmp_s = $tmp->borderStyle;
			}
			
			if(empty($tmp->borderColor)){
				$tmp_c = '#ffffff';
			} else {
				$tmp_c = $tmp->borderColor;
			}	
			
			if(empty($tmp->borderWidth)){
				$tmp_w =  0;
			} else {
				$tmp_w = $tmp->borderWidth;
			}			
			
			if(!empty($tmp_s)){
				$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:first-child a {';
				$tmp_css .= 'border-left: '.$tmp_w.'px '.$tmp_s.' '.$tmp_c.' !important;';
				$tmp_css .= 'border-left-color:'.$tmp_c.' !important;';
				$tmp_css .= '}';

				$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li:last-child a {';
				$tmp_css .= 'border-right:'.$tmp_w.'px '.$tmp_s.' '.$tmp_c.' !important;';
				$tmp_css .= 'border-right-color:'.$tmp_c.' !important;';
				$tmp_css .= '}';
			
				$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a {';
				$tmp_css .= 'border-top-color:'.$tmp_c.' !important; ';
				$tmp_css .= 'border-bottom-color:'.$tmp_c.' !important; ';
				$tmp_css .= 'border-top: '.$tmp_w.'px '.$tmp_s.' '.$tmp_c .' !important;';
				$tmp_css .= 'border-bottom: '.$tmp_w.'px '.$tmp_s.' '.$tmp_c .' !important;';
				$tmp_css .= '}';	
			} 
		}
		// --------------- li ul end ----------------------------


		// --------------- menu pos start -------------------------
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' div:first-child {';
		$tmp_css .=	'margin-left: 0px !important;';	
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' div:last-child {';
		$tmp_css .=	'margin-rigth: 0px !important;';	
		$tmp_css .= '}';
		
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' div {';
				
		$tmp_css .= 'list-style: none !important;';
		if(!empty($this->tmp_settings->cgm_menu)){
			if(!empty($this->tmp_settings->cgm_menu->pos)){
			$tmp = $this->tmp_settings->cgm_menu->pos;
				if(!empty($tmp->align)){
					$tmp_css .= 'float:'.$tmp->align.';';
				}	
				
				if(!empty($tmp->margin)){
					$tmp_css .= 'margin: '.$tmp->margin.';';
				}
				if(!empty($tmp->type) and ($tmp->type == 'ldt' or $tmp->type == 'ldb' )){
					$tmp_css .= 'clear:both;';
				}		
			}
		}
		$tmp_css .= '}';

		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' lable {';
		$tmp_css .= 'padding-right: 5px !important;';
		$tmp_css .= 'float: left !important;';
				
		if(!empty($this->tmp_settings->cgm_menu)){
			if(!empty($this->tmp_settings->cgm_menu->pos)){		
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_menu->pos);	
			}
		}
		$tmp_css .= '}';

		// --------------- menu pos end ---------------------------
		
		// --------------- menu default start -------------------------
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a {';
		
		
		if(!empty($this->tmp_settings->cgm_menu)){
		
			$tmp_fromcolor = '';
			$tmp_fromopacity = 0;
			$tmp_tocolor = '';
			$tmp_toopacity = 0;		
			if(!empty($this->tmp_settings->cgm_menu->gradientfrom) && !empty($this->tmp_settings->cgm_menu->gradientfrom->color) && $this->tmp_settings->cgm_menu->gradientfrom->color != '#'){		
				$tmp_fromcolor = $complete_gallery_manager_plugin->HexToRGB($this->tmp_settings->cgm_menu->gradientfrom->color);	
			}
			if(!empty($this->tmp_settings->cgm_menu->gradientto) && !empty($this->tmp_settings->cgm_menu->gradientto->color) && $this->tmp_settings->cgm_menu->gradientto->color != '#'){		
				$tmp_tocolor = $complete_gallery_manager_plugin->HexToRGB($this->tmp_settings->cgm_menu->gradientto->color);	
			}
			
			if(!empty($this->tmp_settings->cgm_menu->gradientfrom) && !empty($this->tmp_settings->cgm_menu->gradientfrom->opacity)){		
				$tmp_fromopacity = $this->tmp_settings->cgm_menu->gradientfrom->opacity;	
			}	
			
			if(!empty($this->tmp_settings->cgm_menu->gradientto) && !empty($this->tmp_settings->cgm_menu->gradientto->opacity)){		
				$tmp_toopacity = $this->tmp_settings->cgm_menu->gradientto->opacity;	
			}		
			
			
			if(!empty($tmp_fromcolor) and !empty($tmp_tocolor) and (!empty($tmp_fromopacity) or !empty($tmp_toopacity))){	
			$tmp_css .= 'background-image: linear-gradient(bottom, rgba('.$tmp_fromcolor['r'].', '.$tmp_fromcolor['g'].', '.$tmp_fromcolor['b'].', '.$tmp_fromopacity.') 0%, rgba('.$tmp_tocolor['r'].', '.$tmp_tocolor['g'].', '.$tmp_tocolor['b'].', '.$tmp_toopacity.') 100%) !important;';
			$tmp_css .= 'background-image: -o-linear-gradient(bottom, rgba('.$tmp_fromcolor['r'].', '.$tmp_fromcolor['g'].', '.$tmp_fromcolor['b'].', '.$tmp_fromopacity.') 0%, rgba('.$tmp_tocolor['r'].', '.$tmp_tocolor['g'].', '.$tmp_tocolor['b'].', '.$tmp_toopacity.') 100%) !important;';
			$tmp_css .= 'background-image: -moz-linear-gradient(bottom, rgba('.$tmp_fromcolor['r'].', '.$tmp_fromcolor['g'].', '.$tmp_fromcolor['b'].', '.$tmp_fromopacity.') 0%, rgba('.$tmp_tocolor['r'].', '.$tmp_tocolor['g'].', '.$tmp_tocolor['b'].', '.$tmp_toopacity.') 100%) !important;';
			$tmp_css .= 'background-image: -webkit-linear-gradient(bottom, rgba('.$tmp_fromcolor['r'].', '.$tmp_fromcolor['g'].', '.$tmp_fromcolor['b'].', '.$tmp_fromopacity.') 0%, rgba('.$tmp_tocolor['r'].', '.$tmp_tocolor['g'].', '.$tmp_tocolor['b'].', '.$tmp_toopacity.') 100%) !important;';
			$tmp_css .= 'background-image: -ms-linear-gradient(bottom, rgba('.$tmp_fromcolor['r'].', '.$tmp_fromcolor['g'].', '.$tmp_fromcolor['b'].', '.$tmp_fromopacity.') 0%, rgba('.$tmp_tocolor['r'].', '.$tmp_tocolor['g'].', '.$tmp_tocolor['b'].', '.$tmp_toopacity.') 100%) !important;';
	
			$tmp_css .= 'background-image: -webkit-gradient(
				linear,
				left bottom,
				left top,
				color-stop(0, rgba('.$tmp_fromcolor['r'].', '.$tmp_fromcolor['g'].', '.$tmp_fromcolor['b'].', '.$tmp_fromopacity.')),
				color-stop(1, rgba('.$tmp_tocolor['r'].', '.$tmp_tocolor['g'].', '.$tmp_tocolor['b'].', '.$tmp_toopacity.'))
			) !important;';
			
			}	
		}
		
		$tmp_css .= 'padding: 0.4em 0.5em !important;';
		$tmp_css .= 'display: block !important;';
		
		if(!empty($this->tmp_settings->cgm_menu)){
			if(!empty($this->tmp_settings->cgm_menu->normal)){
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_menu->normal);
			}
		}
		$tmp_css .= '}';	
		// --------------- menu default start-------------------------

		// --------------- menu hover start -------------------------
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a:hover {';
		if(!empty($this->tmp_settings->cgm_menu)){
			if(!empty($this->tmp_settings->cgm_menu->hover)){
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_menu->hover);
			}
		}
		$tmp_css .= '}';	
		// --------------- menu hover start-------------------------


		// --------------- menu select start -------------------------
		$tmp_css .= '.cgm_isotype_menu_'.$this->tmp_post_id.' li a.selected {';
		$tmp_css .= 'text-shadow: none;';
		
		if(!empty($this->tmp_settings->cgm_menu)){
			if(!empty($this->tmp_settings->cgm_menu->selected)){
				$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_menu->selected);
			}
		}
		$tmp_css .= '}';	
		// --------------- menu default start-------------------------

		$tmp_css .= '.pp_social .facebook {';
		$tmp_css .= 'line-height: 1px;';
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
		$tmp_css .= 'line-height: 1px;';
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
		$tmp_css .= 'line-height: 1px;';
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
		$tmp_css .= 'float: left !important;';
		$tmp_css .= 'margin-left: 5px !important;';
		$tmp_css .= 'line-height: 1px;';
		
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->google)){
				$tmp_css .=	'display:block !important;';
				$tmp_css .=	'float:left !important;';
			} else {
				$tmp_css .=	'display:none !important;';
			}
		}	
		$tmp_css .= '}';
		
		
		$tmp_css .= '.pp_social .downloadimage {';
		$tmp_css .= 'float: left !important;';
		$tmp_css .= 'margin-left: 5px !important;';
		$tmp_css .= 'line-height: 1px;';
		
		if(!empty($this->tmp_settings->cgm_pretty)){
			if(!empty($this->tmp_settings->cgm_pretty->download)){
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

		// universal scroll
		
		$tmp_css .= '.completegallery'.$this->tmp_post_id.' .universall_scroll {';

		$tmp_css .= 'margin-left: 50% !important;';
		$tmp_css .= 'display: none;';
		$tmp_css .= 'text-align: center !important;';
		$tmp_css .= 'width: 250px !important;';
		$tmp_css .= 'z-index:800 !important;';		
		$tmp_css .= '}';
		
		// fullscreen
		
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
		
		$tmp_css .= '.cgm-iso-fullscreen {
		    bottom: 0 !important;
		    left: 0 !important;
		    position: fixed !important;
		    right: 0 !important;
		    top: 0 !important;
		    z-index: 10000 !important;
		    overflow:auto !important;
		    background-color: rgba('.$tmp_fullscreen_r.', '.$tmp_fullscreen_g.', '.$tmp_fullscreen_b.', '.$tmp_fullscreen_a.') !important;
		}';
		
		$tmp_css .= '.completegallery'.$this->tmp_post_id.' .universall_scroll div {';
		$tmp_css .= 	'margin-left: -125px !important;';
		$tmp_css .= 	'width: 250px !important;';

		if(!empty($this->tmp_settings->cgm_universallScroll)){
			$tmp_css .= $complete_gallery_manager_plugin->CSS_generator($this->tmp_settings->cgm_universallScroll);
		}
		$tmp_css .= '}';
		
		
	
		$upload_dir = wp_upload_dir();
		
		if(!is_dir($upload_dir['basedir'].'/'.$this->tmp_folder)){
			mkdir($upload_dir['basedir'].'/'.$this->tmp_folder, 0777);
			
		}
		
		$cssFile = COMPLETE_GALLERY_PATH.'css/captions.css';
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
		} else {
				$tmp_hover_size = 50;
		}

		
		$tmp_css .= str_replace(array('--SizeHover--','--SizeTitle--','--SizeTitleLine--'), array($tmp_hover_size.'%',($tmp_font_size+10+($tmp_font_size/2)).'px',$tmp_font_size_padding.'px'), $tmp_css_cap);
		
			

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

$cgm_isotope_generator = new cgm_isotope_generator_class();
?>