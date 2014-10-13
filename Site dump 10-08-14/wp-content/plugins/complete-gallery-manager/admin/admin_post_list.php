<?php

class cgm_admin_post_list { 
	var $parent_id;
	var $parent_menu_id;
	var $plugin_page;
	var $post_type = 'complete_gallery';
	var $form_setting = '';
	var $gallery_script_load = array();
	var $gallery_css_load = array();
	
    // Start up functions
	function cgm_admin_post_list($parent_id){
		// set up varibles
        $this->parent_id = $parent_id; 
        $this->parent_menu_id = $parent_id.'-start';      

        // set start action
		add_action($parent_id.'-options-menu', array(&$this,'admin_menu'), 50, 0);
		add_action( 'init', array(&$this,'create_post_type') );
		add_action("admin_init", array(&$this,'admin_init'));
	}
	
	// create post types
	function create_post_type() {
		// create defualt post type
		register_post_type($this->parent_id.'-'.$this->post_type, array(
			'label' => __('CGM Settings','evt'),
			'labels' => array(
				'name' 				=> __('Complete Gallery Manager','cgm'),
				'singular_name' 	=> __('Gallery','cgm'),
				'add_new' 			=> __('Add New Gallery','cgm'),
				'edit_item' 		=> __('Edit Gallery','cgm'),
				'new_item' 			=> __('New Gallery','cgm'),
				'view_item'			=> __('View Gallery','cgm'),
				'search_items'		=> __('Search Gallery','cgm'),
				'not_found'			=> __('No Gallery Found','cgm'),
				'not_found_in_trash'=> __('No Gallery Found In Trash','cgm'),
				'add_new_item'		=> __('Add New Gallery','cgm')
			),
			'public' => true,
            'show_ui'             => $this->parent_menu_id,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
			'capability_type' => 'post',
    		'rewrite' => array('slug' => __('cgm','cgm')),
			'hierarchical' => false,
			'has_archive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'supports' => array('title','editor', 'thumbnail'),
			'exclude_from_search' => true,
		));

		 register_taxonomy('cgm-category',$this->parent_id.'-'.$this->post_type, array(
		    'hierarchical' => true,
			'public' => true,
			'capability_type' => 'post',
		    'show_ui'             => $this->parent_menu_id,
		    'show_tagcloud'        => false,
		    'show_in_nav_menus'   => false,
			'exclude_from_search' => false,
		    'query_var' => false
		 ));
		 
	     $check_install = get_option('cgm_version_check_fl'); 	
		 if($check_install < CGM_VERSION){
		 	flush_rewrite_rules();  
		 	update_option('cgm_version_check_fl',CGM_VERSION);
		 }
	}

	
	// save and and meta_box
	function admin_init(){
			// change list
  			add_filter('manage_edit-'.$this->parent_id.'-'.$this->post_type.'_columns', 
  					   array(&$this,'add_new_columns'));
  					   
  			add_action('manage_'.$this->parent_id.'-'.$this->post_type.'_posts_custom_column', 
  					   array(&$this,'manage_columns'), 10, 2);
  			
  			// set action to save post
			add_action('save_post', array(&$this,'save_details'));
			
			// set action up metaboxes
  			add_meta_box("cgm-settings-meta", 
  						 __("Gallery Settings","cgm"), 
  						 array(&$this,'meta_load_settings'), 
  						 $this->parent_id.'-'.$this->post_type, 
  						 "advanced", 
  						 "core");
  				
  				
  						
			if(current_user_can('cgm_upload_images') || current_user_can('cgm_select_images')){
  				add_meta_box("cgm-add-images-meta", 
  						 __("Add Media","cgm"), 
  						 array(&$this,'meta_add_images'), 
  						 $this->parent_id.'-'.$this->post_type, 
  						 "normal", 
  						 "high");
			}
  				
  			add_meta_box("cgm-selected-images-meta", 
  						 __("Inserted Media","cgm"), 
  						 array(&$this,'meta_selected_images'), 
  						 $this->parent_id.'-'.$this->post_type, 
  						 "normal", 
  						 "default");
  				

  						 
  			add_meta_box("cgm-settings-docs-meta", 
  						 __("Gallery Comments","cgm"), 
  						 array(&$this,'meta_load_comments'), 
  						 $this->parent_id.'-'.$this->post_type, 
  						 "side", 
  						 "low");
  			
  			
  			add_meta_box("cgm-settings-preview-meta", 
  						 __("Gallery Preview","cgm"), 
  						 array(&$this,'meta_load_preview'), 
  						 $this->parent_id.'-'.$this->post_type, 
  						 "normal", 
  						 "default");

	}
	
	//create menu 
	function admin_menu(){
		if(is_admin() && (current_user_can('cgm_create_gallery') or current_user_can('manage_options'))){
			$this->plugin_page = add_submenu_page($this->parent_menu_id,
								 __("List Gallery",'cgm'),
								 __("List Gallery",'cgm'),
								 'cgm_create_gallery', 
								 'edit.php?post_type='.$this->parent_id.'-'.$this->post_type);
									 
			$this->plugin_page = add_submenu_page($this->parent_menu_id,
								 __("Add Gallery",'evt'),
								 __("Add Gallery",'evt'),
								 'cgm_create_gallery', 
								 'post-new.php?post_type='.$this->parent_id.'-'.$this->post_type);		
			
			$this->plugin_page = add_submenu_page($this->parent_menu_id,
								 __("Categories",'evt'),
								 __("Categories",'evt'),
								 'cgm_create_gallery', 
								 'edit-tags.php?post_type='.$this->parent_id.'-'.$this->post_type.'&taxonomy=cgm-category');


            add_action( 'admin_head-post-new.php', array(&$this,'create_header'));
            add_action( 'admin_head-edit.php', array(&$this,'create_header'));
            add_action( 'admin_head-post.php', array(&$this,'create_header'));
        }
	}

	function disableAutoSave(){
	    wp_deregister_script('autosave');
	}



	// create header 
	function create_header(){
		if($this->is_post_type()){
  			global $complete_gallery_display,$wp_version;
		
		
  			add_action( 'wp_print_scripts', array(&$this,'disableAutoSave') );
		
          	require_once(COMPLETE_GALLERY_PATH.'inc/uh_formsettings/formsettings.php');
  			$this->form_setting = new uh_form_structure('cgm');
		
    		echo '<script>  
    			var COMPLETE_GALLERY_URL = "'.COMPLETE_GALLERY_URL.'";
    			var cgm_upload_images = "'.current_user_can('cgm_upload_images').'";
       			var cgm_select_images = "'.current_user_can('cgm_select_images').'";
       			var cgm_wp_version = parseFloat("'.$wp_version.'");
    		</script>';
		

			wp_enqueue_script('media-upload'); 
			wp_enqueue_script('thickbox'); 
			wp_enqueue_script('my-upload'); 
			wp_enqueue_style('thickbox');
			wp_enqueue_script('jquery'); 
			wp_enqueue_script('jquery-ui-core'); 
			wp_enqueue_script('jquery-ui-accordion'); 
			wp_enqueue_script('jquery-ui-sortable'); 

			// farbtastic
			wp_print_styles( 'farbtastic' );
			wp_print_scripts( 'farbtastic' );
			
			// add wp-pointer
    		wp_enqueue_style( 'wp-pointer' );
    		wp_enqueue_script( 'wp-pointer' );
    	
    	
    		//wp_register_style( 'cgm_list_gallery', COMPLETE_GALLERY_URL.'css/admin_post_list.css');
		//wp_enqueue_style( 'myStylesheet', WP_PLUGIN_URL . '/path/stylesheet.css' );

    		wp_register_script( 'fileuploader', COMPLETE_GALLERY_URL.'js/fileuploader.js');
    		wp_enqueue_script( 'fileuploader' ); 	

    		wp_register_script( 'cgm_list_gallery', COMPLETE_GALLERY_URL.'js/list_gallery.js');
    		wp_enqueue_script( 'cgm_list_gallery' ); 

    		echo '<link rel="stylesheet" type="text/css" href="'.COMPLETE_GALLERY_URL.'css/admin_post_list.css" />';
    		echo '<link rel="stylesheet" type="text/css" href="'.COMPLETE_GALLERY_URL.'inc/uh_formsettings/formsettings.css" />';






  			foreach($complete_gallery_display as $cg_display){
   				foreach($cg_display['class_js'] as $tmp_key =>  $tmp_data ){ 
					if(empty($this->gallery_script_load[$tmp_key])){
	   					if(empty($tmp_data)){
	   						wp_enqueue_script( $tmp_key ); 
	   					} else {
	   						if(substr($tmp_data, 0, 1) == '*'){
	   							$return_content .= '<script src="'.$tmp_data.'" type="text/javascript"></script>';
	   						} else {
	   					
	    						wp_register_script( $tmp_key, $tmp_data, array(), '1.0',false);
	    						wp_enqueue_script( $tmp_key ); 
	    					}

	   					}
	   					$this->gallery_script_load[$tmp_key] = true;
   					}
			
  			 	}
  			 	
   				foreach($cg_display['class_css'] as $tmp_key =>  $tmp_data ){ 
					if(empty($this->gallery_css_load[$tmp_key])){
						echo '<link rel="stylesheet" type="text/css" href="'.$tmp_data.'" />';
    				}		
  			 	}
  			}
		}
	}
	
	// Controle list columns.
	function add_new_columns($default_columns) {
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['id'] = _x('ID', 'cgm');
		$new_columns['title'] = _x('Title', 'cgm');
		$new_columns['comm'] = _x('Comments', 'cgm');
		$new_columns['shortcode'] = _x('Shortcode', 'cgm');
		$new_columns['author'] = __('Author','cgm');
		$new_columns['date'] = _x('Date', 'cgm');
		$new_columns['tools'] = _x('Tools', 'cgm');
		return $new_columns;
	}
	
	// Controles data input in rows
	function manage_columns($column_name, $id) {
		global $complete_gallery_manager_plugin;
		switch ($column_name) {
		case 'id':
			echo $id;
		    break;
		case 'shortcode':
			echo $complete_gallery_manager_plugin->globalt_shorcode_generator(array('id'=>$id));
			break;
			
		case 'comm':
  			$custom = get_post_custom($id);
  			if(!empty($custom["cgm_comments"])){
  				$comments = $custom["cgm_comments"][0];
  				if(strlen($comments) > 200){
  					$comments = substr($comments,0,200).'…';
  				}
  			}
  			echo $comments;
  			break;
		case 'tools':
			echo '<input type="submit" class="button-secondary" value="Duplicate" onClick="cgm_dubblicate_object(this,'.$id.');return false;">';
			break;
		default:
			break;
		} // end switch
	}

	// Create Meta Box the input comments
	function meta_load_comments(){
  		global $post;
		echo '<p><textarea style="width:100%" name="cgm_comments">'.get_post_meta($post->ID, 'cgm_comments', true).'</textarea></p>';
	}
	
	function meta_add_images(){
		global $post,$wpdb,$complete_gallery_manager_plugin;

		$cgm_get_image_scalse = $complete_gallery_manager_plugin->cgm_get_image_scalse();

		$cgm_options = get_option('cgm_options');
		
		if(!empty($cgm_options['reset_settings']) and $cgm_options['reset_settings']){
			$current_user = wp_get_current_user();
			if ($current_user->ID > 0){
				update_user_meta($current_user->ID, 'wp_user-settings', '');
				$cgm_options['reset_settings'] = 0;
				update_option('cgm_options',$cgm_options);
			}
		}
		
		$cgm_auto_lock = get_post_meta($post->ID, 'cgm-auto-lock', true);
		$cgm_auto_lock_type = get_post_meta($post->ID, 'cgm-auto-lock-type', true);
		$cgm_auto_lock_arrays = explode(',', $cgm_auto_lock);
		$cgm_auto_lock_name = '';
		
		if(!empty($cgm_auto_lock_arrays)){
			foreach($cgm_auto_lock_arrays as $cgm_auto_lock_array){
				if($cgm_auto_lock_name != ''){
					$cgm_auto_lock_name .= ', ';
				}
				if(!empty($cgm_auto_lock_type) and $cgm_auto_lock_type == 'page'){
					$cgm_auto_lock_name .= get_the_title($cgm_auto_lock_array);
				} else if(!empty($cgm_auto_lock_type) and $cgm_auto_lock_type == 'post'){
					$cgm_auto_lock_name .= get_the_category_by_ID($cgm_auto_lock_array);
				}
			}
		}
		
		$tmp_othercss = '';
		if(!empty($cgm_auto_lock) and !empty($cgm_auto_lock_type)){
			$tmp_othercss = 'class="hidden"';
		}

		
		$cgm_auto_lock_w = get_post_meta($post->ID, 'cgm-auto-lock-w', true);
		$cgm_auto_lock_h = get_post_meta($post->ID, 'cgm-auto-lock-h', true);
		$cgm_auto_lock_s = get_post_meta($post->ID, 'cgm-auto-lock-s', true);	
		
		$datasource = get_post_meta($post->ID, 'cgm-data-source', true);
		$my_wp_query = new WP_Query();
		?>
		<input type="hidden" id="cgm_hidden_data_source" name="cgm_hidden_data_source" value="<?php echo $datasource; ?>">
		<div id="cgm-drag-drop_load_data" class="cgm-drag-drop_load_data">
			<ul><li <?php echo $datasource==0?'class="active"':$tmp_othercss ?>>Images</li>
				<li <?php echo $datasource==1?'class="active"':$tmp_othercss ?>>Posts</li>
				<li <?php echo $datasource==2?'class="active"':$tmp_othercss ?>>Pages</li>
				<li <?php echo $datasource==3?'class="active"':$tmp_othercss ?>>Custom Post Types</li>
				<li <?php echo $datasource==4?'class="active"':$tmp_othercss ?> style="display:none;">Facebook</li>
				<li <?php echo $datasource==5?'class="active"':$tmp_othercss ?> style="display:none;">Google+</li>
				<li <?php echo $datasource==6?'class="active"':$tmp_othercss ?> style="display:none;">Pinterest</li>
				<li <?php echo $datasource==7?'class="active"':$tmp_othercss ?>>Flickr</li>
				<li <?php echo $datasource==8?'class="active"':$tmp_othercss ?>>Videos</li>
				<li <?php echo $datasource==9?'class="active"':$tmp_othercss ?>>Galleries</li>
			</ul>
		</div>
		<div id="cgm-source-header" class="cgm-source-header">
			<ul><li <?php echo $datasource==0?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/image32.png">
					<h2>Images</h2>
					<p>Add images by drag and drop or select files from your computer, or select images directly from the Media Library.</p>
				</li>
				<li <?php echo $datasource==1?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/wordpress_post32.png">
					<h2>Posts</h2>
					<p>Add a single post or add all posts from a category</p>
				</li>
				<li <?php echo $datasource==2?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/wordpress_page32.png">
					<h2>Pages</h2>
					<p>Add a single Page or all the Children of a Page</p>	
				</li>
				<li <?php echo $datasource==3?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/wordpress_post32.png">
					<h2>Custom Post Types</h2>
					<p>Add a single custom post</p>
				</li>
				<li <?php echo $datasource==4?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/facebook32.png">
					<h2>Facebook</h2>
					<p>You can load single images or vides or you can lock it on a bible</p>
				</li>
				<li <?php echo $datasource==5?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/google+32.png">
					<h2>Google+</h2>
					<p>Loading data from google+ with signle og lib</p>
				</li>
				<li <?php echo $datasource==6?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/priterest32.png">
					<h2>Pinterest</h2>
					<p>Loading data from pinterest account</p>
				</li>
				<li <?php echo $datasource==7?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/flickr32.png">
					<h2>Flickr</h2>
					<p>Loading data from flickr account (<b><?php echo ($cgm_options['flickr_accountname'] != '' ? $cgm_options['flickr_accountname'] : 'No account added' ); ?></b>)</p>
				</li>
				<li <?php echo $datasource==8?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/video32.png">
					<h2>Videos</h2>
					<p>Add YouTube or Vimeo Videos</p>
				</li>
				<li <?php echo $datasource==9?'style="display:block"':'style="display:none"' ?>>
					<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/gallery32.png">
					<h2>Galleries</h2>
					<p>Add a single Gallery or multiple Galleries</p>
				</li>
			</ul>
		</div>		
		<div class="cgm-source-border" id="cgm-source-border">
			<div class="cgm-source-lockdown" id="cgm-source-lockdown" <?php echo ($cgm_auto_lock_type!='' && $cgm_auto_lock !='')?'style="display:block"':'style="display:none"' ?>>
			
				<span id="cgm-lockdown-title"><?php echo $cgm_auto_lock_type=='post'?'Auto Load Post':'Auto Load Page';?></span><br>
				<span id="cgm-lockdown-subtitle"><?php echo $cgm_auto_lock_type=='post'?'Category id(s): ':'Page id(s): ';echo $cgm_auto_lock_name;?></span><br><br>
				<span id="cgm-lockdown-imagesize">
				<select style="width:150px" id="cgm-gallery-auto-select-s"  onChange="cgm_preview();">
					<?php
						if(!empty($cgm_get_image_scalse)){
							foreach($cgm_get_image_scalse as $cgm_get_image_scals_key => $cgm_get_image_scals){
								echo '<option value="'.$cgm_get_image_scals_key.'" ';
								
								if($cgm_auto_lock_s == $cgm_get_image_scals_key){
									echo ' selected="selected" ';
								}
								
								echo '>'.ucfirst($cgm_get_image_scals_key).' ('.$cgm_get_image_scals['width'].'x'.$cgm_get_image_scals['height'].')</option>';
								
								
							}
						}
					?>			
					
				</select></span> or <input onKeyUp="cgm_preview_delay();" type="text" style="width:60px" id="cgm-gallery-auto-select-w" value="<?php echo $cgm_auto_lock_w; ?>">x<input type="text" style="width:60px" onKeyUp="cgm_preview_delay();" id="cgm-gallery-auto-select-h" value="<?php echo $cgm_auto_lock_h; ?>">px<br>
				
				
				<span id="cgm-lockdown-release"><input type="submit" onClick="cgm_auto_lockdown_images();return false;" class="button-secondary" value="Release Auto Update"></span><br>
			</div>
			<div class="cgm-source-loading" id="cgm-source-loading" style="display:none">
				<img src="<?php echo COMPLETE_GALLERY_URL; ?>images/loader.gif">
			</div>
			<div class="cgm-source cgm-source-image" id="cgm-source-image" <?php echo $datasource==0?'style="display:block"':'style="display:none"' ?>>
				<div class="cgm-drag-drop" id="cgm-drag-drop"></div>
			</div>
			<div class="cgm-source cgm-source-post" id="cgm-source-post" <?php echo $datasource==1?'style="display:block"':'style="display:none"' ?>>
				<table><tr>
					   <td width="300px" valign="top">
					   		<h4>Single Post</h4>
					   		<ul id="cgm_post_add_list" class="cgm_ul_index_list">
							<?php	
								$args = array(
								    'numberposts'     => -1,
								    'orderby'         => 'post_title',
								    'order'           => 'ASC',
								    'post_type'		  => 'post',
								    'post_status'     => 'publish' );
								$posts_array = get_posts( $args );
								if(!empty($posts_array)){
									foreach ($posts_array as $tmp_get_post ) {
										if(has_post_thumbnail($tmp_get_post->ID)){
											echo '<li>';
											echo '<input type="checkbox" ref="'.get_post_thumbnail_id( $tmp_get_post->ID ).'" value="'.$tmp_get_post->ID.'"><span style="min-width: 40px;padding-left: 10px;">'.$tmp_get_post->ID. '</span><span style="max-width:200px">'.$tmp_get_post->post_title . '</span>';
											echo '</li>';
										}	
									}	
								} else {
									echo '<li>There is no post with attached image</li>';
								}
							?>
					   		</ul>
					   		 <input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: left; margin-right: -15px;" id="cgm_post_add" value="Insert Post(s)" class="button">
						</td>
						<td width="300px" valign="top">
					   		<h4>Posts from Category</h4>
					   		<ul id="cgm_post_category_add_list" class="cgm_ul_index_list">
							<?php	
							$args = array(
									'type'                     => 'post',
									'orderby'                  => 'name',
									'order'                    => 'ASC',
									'hide_empty'               => 1,
									'hierarchical'             => 1,
									'taxonomy'                 => 'category',
									'pad_counts'               => false );
							
							$taxonomies = get_categories($args);
							$tmp_total_count = 0;
								if(!empty($taxonomies)){
									foreach ($taxonomies as $taxonomie ) {
										$querys = $my_wp_query->query( array('posts_per_page'=>-1, 'category__in' => array($taxonomie->term_id)));
										$count = 0;
										foreach($querys as $query){
											if(has_post_thumbnail($query->ID)){$count++;}
										}
										if($count > 0){
											$tmp_total_count += $count;
											echo '<li>';
											echo '<input type="checkbox" value="'.$taxonomie->term_id.'"><span style="min-width: 40px;padding-left: 10px;">'.$taxonomie->term_id. '</span><span style="max-width:200px">'.$taxonomie->name . ' ('.$count.')</span>';
											echo '</li>';
										}	
									}
									
									if(empty($tmp_total_count)){
										echo '<li>There is no Post(s) with attached image(s) in the Category</li>';	
									}
										
								} else {
									echo '<li>There is no Categorys</li>';
								}
							?>
					   		</ul>
					   		 <input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: left; margin-right: -15px;" id="cgm_post_category_add" value="Insert Post(s)" class="button"><span class="cgm_sub_auto"><input id="cgm_post_sub_auto" type="checkbox" value="1" <?php echo $cgm_auto_lock_type=='post'?'checked="checked"':'';?>> Auto update</span>							
							
							
							
						</td>   
					</tr>
				</table>
				
			</div>
			<div class="cgm-source cgm-source-page" id="cgm-source-page" <?php echo $datasource==2?'style="display:block"':'style="display:none"' ?>>
				<table><tr>
					   <td width="300px" valign="top">
					   		<h4>Single Page</h4>
					   		<ul id="cgm_page_add_list" class="cgm_ul_index_list">
							<?php	
								$all_wp_pages = $my_wp_query->query(array('post_type' => 'page','orderby' => 'title', 'order' => 'ASC','post_status'     => 'publish','numberposts'     => -1,'nopaging'=>true));
								
								if(!empty($all_wp_pages)){
									foreach ($all_wp_pages as $tmp_get_page ) {
										if(has_post_thumbnail($tmp_get_page->ID)){
											echo '<li>';
											echo '<input type="checkbox" ref="'.get_post_thumbnail_id( $tmp_get_page->ID ).'" value="'.$tmp_get_page->ID.'"><span style="min-width: 40px;padding-left: 10px;">'.$tmp_get_page->ID. '</span><span style="max-width:200px">'.$tmp_get_page->post_title . '</span>';
											echo '</li>';
										}	
									}	
								} else {
									echo '<li>There is no sub-page(s) with attached image(s)</li>';
								}
							?>
					   		</ul>
					   		 <input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: left; margin-right: -15px;" id="cgm_page_add" value="Insert Page(s)" class="button">
						</td>
						<td width="300px" valign="top">
					   		<h4>Add all sub-pages</h4>
					   		<ul id="cgm_page_parrent_add_list" class="cgm_ul_index_list">
							<?php	
								$tmp_total_count = 0;
							
								foreach($all_wp_pages as $all_wp_page){
									$portfolio_children = get_page_children($all_wp_page->ID, $all_wp_pages);
									$count = 0;
									foreach($portfolio_children as $portfolio){
										if(has_post_thumbnail($portfolio->ID)){$count++;}
									}
								
									if($count > 0){
										$tmp_total_count += $count;
											echo '<li>';
											echo '<input type="checkbox" value="'.$all_wp_page->ID.'"><span style="min-width: 40px;padding-left: 10px;">'.$all_wp_page->ID. '</span><span style="max-width:200px">'.$all_wp_page->post_title . ' ('.$count.')</span>';
											echo '</li>';
									}
									
									
								}
								if(empty($tmp_total_count)){
									echo '<li>There is no Page(s) with Featured Image(s)</li>';
								}
							?>
					   		</ul>
					   		 <input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: left; margin-right: -15px;" id="cgm_page_parrent_add" value="Insert Page(s)" class="button"><span class="cgm_sub_auto"><input id="cgm_page_sub_auto" type="checkbox" value="1" <?php echo $cgm_auto_lock_type=='page'?'checked="checked"':'';?>> Auto update</span>					
						</td>   
					</tr>
				</table>
			</div>
			<div class="cgm-source cgm-source-cpost" id="cgm-source-cpost" <?php echo $datasource==3?'style="display:block"':'style="display:none"' ?>>
				<table><tr>
				
				<?php
					$post_types=get_post_types(); 
					if(!empty($post_types)){
						$temp_array_temp = array('post','page','attachment','revision','nav_menu_item','cgm-complete_gallery');
						foreach($post_types as $key_post_type => $post_type){
							if(in_array($post_type, $temp_array_temp)){
								unset($post_types[$key_post_type]);
							}
						}
					}

				
				
				
					if(!empty($post_types)){
						foreach($post_types as $post_type){
							echo '<td width="300px" valign="top" style="margin-right: 10px;">';
							echo 	'<h4>'.$post_type.'</h4>';
					   		echo 	'<ul id="cgm_cpost_add_list_'.$post_type.'" class="cgm_ul_index_list">';
							
							$args = array(
							    'numberposts'     => -1,
							    'orderby'         => 'post_title',
							    'order'           => 'ASC',
							    'post_type'		  => $post_type,
							    'post_status'     => 'publish' );
							    
							$posts_array = get_posts( $args );
							$tmp_count_tmp = 0;
							if(!empty($posts_array)){
								foreach ($posts_array as $tmp_get_post ) {
									if(has_post_thumbnail($tmp_get_post->ID)){
										$tmp_count_tmp++;
										echo '<li>';
										echo 	'<input type="checkbox" ref="'.get_post_thumbnail_id( $tmp_get_post->ID ).'" value="'.$tmp_get_post->ID.'"><span style="min-width: 40px;padding-left: 10px;">'.$tmp_get_post->ID. '</span><span style="max-width:200px">'.$tmp_get_post->post_title . '</span>';
										echo '</li>';
									}	
								}	
							} 
							if($tmp_count_tmp == 0){
								echo '<li>There is no post with attached image</li>';
							}
							$tmp_count_tmp = 0;
							
							echo '</ul>';
							echo '<input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: left; margin-right: -15px;" value="Insert Post(s)" onClick="cgm_fn_saveCustomPostType(\'#cgm_cpost_add_list_'.$post_type.'\');return false;" class="button">';
							echo '</td>';
						}	
					} else {
						echo '<td width="300px" valign="top">';
					   	echo 	'<h4>You have no custom post types</h4>';
					   	echo '</td>';
					}
				?>
					</tr>
				</table>	
			</div>
			<div class="cgm-source cgm-source-facebook" id="cgm-source-facebook" <?php echo $datasource==4?'style="display:block"':'style="display:none"' ?>>
				<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/facebook32.png"><h2>Facebook</h2>
				<p>You can load single images or vides or you can lock it on a bible</p>	
			</div>
			<div class="cgm-source cgm-source-google" id="cgm-source-google" <?php echo $datasource==5?'style="display:block"':'style="display:none"' ?>>
				<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/google+32.png"><h2>Google+</h2>
				<p>Loading data from google+ with signle og lib</p>	
			</div>
			<div class="cgm-source cgm-source-pinterest" id="cgm-source-pinterest" <?php echo $datasource==6?'style="display:block"':'style="display:none"' ?>>
				<img class="cgm-source-icon" src="<?php echo COMPLETE_GALLERY_URL; ?>images/source_icons/priterest32.png"><h2>Pinterest</h2>
				<p>Loading data from pinterest account</p>	
			</div>
			<div class="cgm-source cgm-source-flickr" id="cgm-source-flickr" <?php echo $datasource==7?'style="display:block"':'style="display:none"' ?>>
				<?php        

					if(!empty($cgm_options['flickr_accountname']) && !empty($cgm_options['flickr_apikey'])){
						require_once(COMPLETE_GALLERY_PATH.'inc/phpFlickr.php');
					
						$flickr_api = new phpFlickr($cgm_options['flickr_apikey']);
						$flickr_user_id = $flickr_api->people_findByUsername($cgm_options['flickr_accountname']);
						
												
						if($flickr_api->getErrorMsg() != ''){
							echo __('Error') . ': '  . $flickr_api->getErrorMsg();
						} else {
							$flickr_user_id = $flickr_user_id['id'];
							$flickr_photosets = $flickr_api->photosets_getList($flickr_user_id);
							$flickr_photogalleries = $flickr_api->galleries_getList($flickr_user_id);
							?>
						   <table>
						   		<tr>
						   		
						   		
								   <td width="300px" valign="top">
									   	<div class="cgm-drag-drop-inside">
									   		<h4>List All Images</h4>
									   		<p class="cgm-drag-drop-buttons"><input class="button" type="submit" onClick="cgm_flickr_show('photouser','<?php echo $flickr_user_id; ?>');return false;" value="Select images"></p>
									   	</div>
								   </td>
								   <td width="300px" valign="top">
								   		<h4>Photo Set</h4>
								   		<ul class="cgm_ul_index_list">
										<?php	
											if(!empty($flickr_photosets['total'])){
												foreach($flickr_photosets['photoset'] as $tempphotoset){
													if(!empty($tempphotoset['photos'])){
														echo '<li>';
														echo '<span style="min-width: 40px;padding-left: 10px;"><a onClick="cgm_flickr_show(\'photoset\',\''.$tempphotoset['id'].'\');return false;" href="#">Show</a></span><span style="max-width:200px">'.$tempphotoset['title'].' ('.$tempphotoset['photos'].')</span>';
														echo '</li>';	
													}
												}									
											} else {
												echo '<li>';
												echo '<span style="min-width: 400px;padding-left: 10px;">You have not made any photoset under flickr</span>';
												echo '</li>';	
											}
										?>
								   		</ul>
								   	</td>
									<td width="300px" valign="top">
										<h4>Photo Gallery</h4>
								   		<ul class="cgm_ul_index_list">
										<?php	
											if(!empty($flickr_photogalleries['galleries']['total'])){
												foreach($flickr_photogalleries['galleries']['gallery'] as $tempphotogalleries){
													if(!empty($tempphotogalleries['count_photos'])){
														echo '<li>';
														echo '<span style="min-width: 40px;padding-left: 10px;"><a onClick="cgm_flickr_show(\'photogalleri\',\''.$tempphotogalleries['id'].'\');return false;" href="#">Show</a></span><span style="max-width:200px">'.$tempphotogalleries['title'].' ('.$tempphotogalleries['count_photos'].')</span>';
														echo '</li>';	
													}
												}									
											} else {
												echo '<li>';
												echo '<span style="min-width: 400px;padding-left: 10px;">You have not made any photo gallary under flickr</span>';
												echo '</li>';	
											}
										?>
								   		</ul>					
									</td>   
								</tr>
							</table>
						<?php 		
						}	
					} else {
						echo __('To use flickr do you need to input the account information under CGM Settings -> Options -> Flickr Settings','cgm');	
					}
				?>
			</div>
			<div class="cgm-source cgm-source-video" id="cgm-source-video" <?php echo $datasource==8?'style="display:block"':'style="display:none"' ?>>
				<table><tr><td width="400px" valign="top">Copy your YouTube or Vimeo url into the field. The system will automatically use the preview image from the video. If you which to use a different preview image, then select one from your Media Library.
				<p><input id="cgm_youtupe_vimeo_url" style="width:100%"></p>

				<p><input type="button" style="position: relative; z-index: 0;" id="cgm_youtupe_vimeo_preview" value="Select preview image" class="button"> <input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: right; margin-right: -15px;" id="cgm_youtupe_vimeo_add" value="Insert Video" class="button"></p>
				</td><td width="50px;"></td>
				
				
				<td width="150px" valign="top"><div id="cgm_youtupe_vimeo_preview_image"></div><div id="cgm_youtupe_vimeo_preview_image_remove" style="display:none;">Remove selected image</div>
				
				</td></tr></table>
				<input type="hidden" id="cgm_youtupe_vimeo_preview_id">
			</div>
			
			
			<div class="cgm-source cgm-source-gallery" id="cgm-source-gallery" <?php echo $datasource==9?'style="display:block"':'style="display:none"' ?>>
				<table><tr>
					   <td width="300px" valign="top">
					   		<h4>Galleries</h4>
					   		<ul id="cgm_gallery_add_list" class="cgm_ul_index_list">
							<?php	
								$args = array(
								    'numberposts'     => -1,
								    'orderby'         => 'post_title',
								    'order'           => 'ASC',
								    'post_type'		  => $this->parent_id.'-'.$this->post_type,
								    'post_status'     => 'publish' );
								$posts_array = get_posts( $args );

								if(!empty($posts_array)){
									$count = 0;
									foreach ($posts_array as $tmp_get_post ) {
										if(has_post_thumbnail($tmp_get_post->ID)){
											echo '<li>';
											echo '<input type="checkbox" ref="'.get_post_thumbnail_id( $tmp_get_post->ID ).'" value="'.$tmp_get_post->ID.'"><span style="min-width: 40px;padding-left: 10px;">'.$tmp_get_post->ID. '</span><span style="max-width:200px">'.$tmp_get_post->post_title . '</span>';
											echo '</li>';
											$count++;
										}	
									}	
									
									if($count == 0){
										echo '<li>There is no gallery with attached image</li>';
									}
									
								} else {
									echo '<li>There is no gallery with attached image</li>';
								}
							?>
					   		</ul>
					   		 <input type="button" class="button-primary" style="position: relative; z-index: 0;position: relative; z-index: 0; float: left; margin-right: -15px;" id="cgm_gallery_add" value="Insert Gallerie(s)" class="button">
						</td>  
					</tr>
				</table>
			</div>
		</div>
		<?php
	}

	function meta_load_settings(){
  		global $post,$complete_gallery_display,$complete_gallery_manager_plugin;
		   $cgm_list_type = get_post_meta($post->ID, 'cgm-list-type', true);
  		   $cgm_settings = get_post_meta($post->ID, 'cgm_settings', true);	
  		   $custom_flag = get_post_meta($post->ID, 'cgm_flag', true);	
  		   
  		   	$cgm_options = get_option('cgm_options');
  		
  		   if(empty($cgm_list_type)){
	  		   $cgm_list_type = 'list';
  		   }
  		
  		
  			$tmpsizewps = $complete_gallery_manager_plugin->cgm_get_image_scalse();
  		
 			echo '<script>
 					var COMPLETE_GALLERY_URL = "'.COMPLETE_GALLERY_URL.'";
 					var cqw_list_type = "'.$cgm_list_type.'";
 					var cgm_post_id = '.$post->ID.';
 					var cgm_no_images_text = \''.__('No image selected','cgm').'\';';
 					
 					
 					
 					
 					if(!empty($cgm_options['overwrite_to_old'])){
	 					echo 'var cgm_overwrite_to_old = true;';
 					} else {
	 					echo 'var cgm_overwrite_to_old = false;';
 					}
 					
 					if(!empty($tmpsizewps)){
 					foreach($tmpsizewps as $tmp_key => $temp_data){

	 					if($tmp_key == 'post-thumbnail'){
		 					$tmp_key = 'thumbnail';
	 					} else if($tmp_key == 'large-feature'){
		 					$tmp_key = 'large';
	 					} else if($tmp_key == 'small-feature'){
		 					$tmp_key = 'small';
	 					}

						if($tmp_key == 'thumbnail' || $tmp_key == 'large' || $tmp_key == 'small'){
							echo 'var cgm_sizes_'.$tmp_key.'_width = '.$temp_data['width'].';';
							echo 'var cgm_sizes_'.$tmp_key.'_height = '.$temp_data['height'].';';
						}
 					}
 					}
 					
 					
 			echo '</script> '; 
  		
  			$tmp_array = '';
  			$tmp_array['title'] = 'Select gallery type';
   			$tmp_array['name'] = 'flag'; 		
  			$tmp_array['type'] = 'dropdown';
  			$tmp_array['extra']['onChange'] = 'cgm_getData(this);';
  			$tmp_array['extra']['id'] = 'cgm_flag';
  			$tmp_array['extra']['style'] = 'max-width:200px';
  			$tmp_array['extra_lable']['style'] = 'width:150px';  
  				
  			foreach($complete_gallery_display as $tmp){
  				$tmp_array['list'][$tmp['type']] = $tmp['title'];
  			}
  			
  		
			echo '<div>'.$this->form_setting->create_form($tmp_array,0,$custom_flag).'</div>';	
			echo '<div id="cgm_data_set"></div>';	
			echo '<div class="clear"></div>';
			echo '<input type="hidden" id="cgm_hidden_settings" name="cgm_hidden_settings" value="'.$cgm_settings.'" >';	
	}



	// Create a preview MetaBox
	function meta_load_preview(){
		echo '<div id="cgm_preview" style="overflow:auto;">'.__('No Gallery has been selected','cgm').'</div>';
		echo '<div class="clear"></div>';
	}
		
	// Creating the setup border
	function meta_selected_images(){
		global $post,$wpdb;
	
		$cgm_list_type = get_post_meta($post->ID, 'cgm-list-type', true);
		$tmp_data_lists =json_decode(urldecode(get_post_meta($post->ID, 'cgm-gallery-data', true)));
		echo '<ul id="cgm_image_list" style="display:none;">';
		
		$count = 0;
		if(count($tmp_data_lists) > 0){
			if($cgm_list_type != 'grid'){
				$CLASSTYPE1 = 'object-listtype1';	 	
			} else if($cgm_list_type == 'grid'){
				$CLASSTYPE1 = 'object-gridtype1';	 	
			}
					
			foreach($tmp_data_lists as $tmp_key => $tmp_data){
				$post_exists = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '" . $tmp_data->postid . "'", 'ARRAY_A');
	
			
				if($post_exists){
					echo $this->create_template(array('[CLASSTYPE1]'=> $CLASSTYPE1,
													  '[TITLE]'=> $tmp_data->title,
													  '[CONTENT]'=>	$tmp_data->description,
													  '[LINK]'=> $tmp_data->link,
													  '[CGM-MAIN_SHOW]'=> $tmp_data->show,
													  '[INDEXNUMBER]'=> ($tmp_key+1),
													  '[POSTID]' => $tmp_data->postid,
													  '[IMAGESELECTED]' => $tmp_data->imageselected,
													  '[CUSTOMHEIGHT]' => $tmp_data->customheight,
													  '[CUSTOMWIDTH]' => $tmp_data->customwidth,
													  '[ATTACTEDID]' => $tmp_data->attactedid,
													  '[TYPEOBJECT]' => $tmp_data->typeobject,
													  '[LINK-OVERWRITE]' => $tmp_data->linkoverwrite,
													  '[CATEGORY]'=> (array)$tmp_data->category),false,$post->ID);
					$count ++;	
				}
			}
		} else {
			echo __('No image selected','cgm');
		}
		echo '</ul>';
		echo '<input id="cgm-gallery-data" type="hidden" name="cgm-gallery-data" value="'.get_post_meta($post->ID, 'cgm-gallery-data', true).'">';

		echo '<input id="cgm-gallery-auto-lock-type" type="hidden" name="cgm-gallery-auto-lock-type" value="'.get_post_meta($post->ID, 'cgm-auto-lock-type', true).'">';
		
		echo '<input id="cgm-gallery-auto-lock" type="hidden" name="cgm-gallery-auto-lock" value="'.get_post_meta($post->ID, 'cgm-auto-lock', true).'"><div class="clear"></div>';

		echo '<input id="cgm-gallery-auto-lock-w" type="hidden" name="cgm-gallery-auto-lock-w" value="'.get_post_meta($post->ID, 'cgm-auto-lock-w', true).'"><div class="clear"></div>';

		echo '<input id="cgm-gallery-auto-lock-h" type="hidden" name="cgm-gallery-auto-lock-h" value="'.get_post_meta($post->ID, 'cgm-auto-lock-h', true).'"><div class="clear"></div>';
		
		echo '<input id="cgm-gallery-auto-lock-s" type="hidden" name="cgm-gallery-auto-lock-s" value="'.get_post_meta($post->ID, 'cgm-auto-lock-s', true).'"><div class="clear"></div>';

		echo '<script>var cgm_current_img_selelcted = '.$count.';</script>';
	}

	// saves all data into the post meta
	function save_details(){
  		global $post,$wpdb,$complete_gallery_manager_plugin;
  		
   		if(isset($_POST["cgm-list-type"])){
			update_post_meta($post->ID, "cgm-list-type", $_POST["cgm-list-type"]);
  		} 	
  		
   		if(isset($_POST["cgm-gallery-data"])){
			update_post_meta($post->ID, "cgm-gallery-data", $_POST["cgm-gallery-data"]);
  		} 	
  		
   		if(isset($_POST["cgm_flag"])){
			update_post_meta($post->ID, "cgm_flag", $_POST["cgm_flag"]);	
  		} 	
  			
  		if($this->is_post_type()){
			update_post_meta($post->ID, "cgm_settings", $_POST["cgm_hidden_settings"]);	
			update_post_meta($post->ID, "cgm_comments", $_POST["cgm_comments"]);
			update_post_meta($post->ID, "cgm_width", $_POST["cgm_width"]);	
			update_post_meta($post->ID, "cgm_height", $_POST["cgm_height"]);
			update_post_meta($post->ID, "cgm-data-source", $_POST["cgm_hidden_data_source"]);
  		
			$tmp_array = '';
			
			update_post_meta($post->ID, "cgm-auto-lock-type", $_POST["cgm-gallery-auto-lock-type"]);	
			update_post_meta($post->ID, "cgm-auto-lock", $_POST["cgm-gallery-auto-lock"]);
			
			update_post_meta($post->ID, "cgm-auto-lock-s", $_POST["cgm-gallery-auto-lock-s"]);	
			update_post_meta($post->ID, "cgm-auto-lock-w", $_POST["cgm-gallery-auto-lock-w"]);
			update_post_meta($post->ID, "cgm-auto-lock-h", $_POST["cgm-gallery-auto-lock-h"]);			
			foreach($_POST as $key => $data_tmp)
			{
				if(substr($key, 0, 4) == 'cgm_' && $key != "cgm_flag" && $key != "cgm_comments" )				{
					$key = str_replace("cgm_", "",$key);
					
					if(empty($data_tmp)){
						$tmp_array[$key] = '-0-';	
					} else {
						$tmp_array[$key] = $data_tmp;	
					}

					
				}
			}
			
			
			if(!empty($tmp_array)){
				update_post_meta($post->ID, "cgm_data", json_encode($tmp_array));			
			}

			if(!empty($post->ID)){
  				$wpdb->update( $wpdb->posts, 
  		array( 'post_content' => $complete_gallery_manager_plugin->globalt_shorcode_generator(array('id'=>$post->ID,"style"=>"width:100%;height:100%"))), 
  		array( 'ID' => $post->ID ));
  			}
  			
  			
  			
	  		$upload_dir = wp_upload_dir();
			$tmp_folder  = $complete_gallery_manager_plugin->tmp_folder;
			$tmp_file = $complete_gallery_manager_plugin->tmp_file;
			
			if(!is_dir($upload_dir['basedir'].'/'.$tmp_folder)){
				mkdir($upload_dir['basedir'].'/'.$tmp_folder, 0777);
			}
		
			if (!$upload_dir['error'] && file_exists($upload_dir['basedir'].'/'.$tmp_folder.'/tmp_'.$post->ID.$tmp_file)) {
				if (!copy($upload_dir['basedir'].'/'.$tmp_folder.'/tmp_'.$post->ID.$tmp_file, $upload_dir['basedir'].'/'.$tmp_folder.'/'.$post->ID.$tmp_file)) {
					echo "failed to copy ( this will not work online, to fix this manual rename the css file )";
					echo $upload_dir['basedir'].'/'.$tmp_folder.'/tmp_'.$post->ID.$tmp_file;
					echo ' To ' . $upload_dir['basedir'].'/'.$tmp_folder.'/'.$post->ID.$tmp_file;
				}
			}
  		}
  			
	}
	
	function create_template_size($array_data,$tmp_controle=false){
		$tmp_content = '';
	
		if($array_data['[IMGSIZEID]'] == 'custom'){
			$tmp_content .= '<br>';
			$tmp_content .= '<input style="margin-right: 4px;" type="radio" class="image-size-controle" name="[SIZECONTROLE]" value="[IMGSIZEID]" [CHECK]><lable>[IMGSIZENAME] ( <input id="object-custom-width" class="image-size-controle-value" value="'.$array_data['[CUSTOMWIDTH]'].'">x<input id="object-custom-height" class="image-size-controle-value" value="'.$array_data['[CUSTOMHEIGHT]'].'"> )</lable>';	
		} else {
			$tmp_content .= '<input  style="margin-right: 4px;" type="radio" class="image-size-controle" name="[SIZECONTROLE]" value="[IMGSIZEID]" [CHECK]><lable>[IMGSIZENAME] ([WIDTH]x[HEIGHT])</lable>';		
		}
		
	
		$tmp_content .= '<br>';
	
		if($tmp_controle){
			return $tmp_content;
		} else {
			foreach($array_data as $key=>$tmp_data){
				$tmp_content = str_replace(strtoupper($key),$tmp_data, $tmp_content);
			}
			return $tmp_content;
		}
	
	
	}
	
	function create_template($array_data,$tmp_controle=false,$current_post_id = 0){
		// categoryes
		if(!empty($current_post_id)){
			$lock_terms = wp_get_post_terms($current_post_id,'cgm-category'); 
		}

		
		
	  	$create_default_categoryes = '';
		$taxonomies=get_categories(array('hide_empty' => 0,'taxonomy' => 'cgm-category'));
		if(!empty($taxonomies)){
			foreach($taxonomies as $taxonomie){
				$create_default_categoryes_tmp = '<input  style="margin-right: 4px;" type="checkbox" id="categoryid'.$taxonomie->term_id.'" value="'.$taxonomie->term_id.'" ';
				
				if(!empty($array_data['[CATEGORY]'])){
					foreach($array_data['[CATEGORY]'] as $cat){
						if($cat == $taxonomie->term_id){
							$create_default_categoryes_tmp .= ' checked="checked" ';
							break;
						}
					}
				}
				$create_default_categoryes_tmp .= ' >'.$taxonomie->name.'<br>';
				
				if(!empty($lock_terms)){
					foreach($lock_terms as $lock_term){
						if($lock_term->term_id == $taxonomie->term_id){
							$create_default_categoryes .= $create_default_categoryes_tmp;
							break;
						}
					}
				} else {
					$create_default_categoryes .= $create_default_categoryes_tmp;	
				}
			}	
		}
		
		// image sizes
		$type_sizes = array('thumbnail','medium','large','full');

		$images_size = '';
		$template = '';
		
		if(!empty($array_data['[POSTID]'])){
		
			if(empty($array_data['[IMAGESELECTED]'])){
				$array_data['[IMAGESELECTED]'] = 'thumbnail';
			}
			
			$tmp_preview_img = '';
		
			$random_name = rand(1,999999). 'image-size-controle' . rand(1,999999);
		
			foreach($type_sizes as $type_size){		
				$tmp_img = wp_get_attachment_image_src($array_data['[POSTID]'],$type_size);

				$tmp_check = '';
				if($type_size == $array_data['[IMAGESELECTED]']){
					$tmp_check = ' checked="checked" ';
				}
				
				if(!empty($tmp_img)){
					if(empty($tmp_preview_img)){
						$tmp_preview_img = $tmp_img[0];	
					}
				
					$images_size .= $this->create_template_size(array('[IMGSIZEID]'=> $type_size,
																	  '[SIZECONTROLE]' => $random_name,
																	  '[CHECK]' => $tmp_check,
																	  '[IMGSIZENAME]' => $type_size,
																	  '[WIDTH]' => $tmp_img[1],
																	  '[HEIGHT]' => $tmp_img[2]),false);
				}
			}
			
			$tmp_check = '';
			if('custom' == $array_data['[IMAGESELECTED]']){
				$tmp_check = ' checked="checked" ';
			}
			
			if(empty($array_data['[CUSTOMHEIGHT]'])){
				$array_data['[CUSTOMHEIGHT]'] = '';
			}
			
			if(empty($array_data['[CUSTOMWIDTH]'])){
				$array_data['[CUSTOMWIDTH]'] = '';
			}

			$images_size .= $this->create_template_size(array('[IMGSIZEID]'=> 'custom',
															  '[SIZECONTROLE]' => $random_name,
															  '[CHECK]' => $tmp_check,
															  '[IMGSIZENAME]' => 'Custom',
															  '[CUSTOMHEIGHT]' => $array_data['[CUSTOMHEIGHT]'],
															  '[CUSTOMWIDTH]' => $array_data['[CUSTOMWIDTH]']),false);
			


			
			if(empty($array_data['[LINK-OVERWRITE]'])){
				$array_data['[LINK-OVERWRITE]'] = '';
			}
															  	

			$tmp_lockdown = '';
			$tmp_lockdown_title = '';
			$tmp_lockdown_desc = '';
			$tmp_lockdown_link = '';
			
			if($array_data['[TYPEOBJECT]'] == 'youtube' || $array_data['[TYPEOBJECT]'] == 'vimeo') {
				$tmp_lockdown_link = ' DISABLED="DISABLED" ';
			}
			
			if($array_data['[TYPEOBJECT]'] == 'post' || $array_data['[TYPEOBJECT]'] == 'cpost' || $array_data['[TYPEOBJECT]'] == 'page') {
				$tmp_lockdown_title = ' DISABLED="DISABLED" ';
				$tmp_lockdown_desc = ' DISABLED="DISABLED" ';
				$tmp_lockdown_link = ' DISABLED="DISABLED" ';
				
				$post_tmp = get_post($array_data['[ATTACTEDID]']); 
				$array_data['[LINK]'] = get_permalink($array_data['[ATTACTEDID]']);
				$array_data['[CONTENT]'] = strip_tags($post_tmp->post_content);
				$array_data['[TITLE]'] = $post_tmp->post_title;
			}
			
			if($array_data['[TYPEOBJECT]'] == 'gallery') {
				$tmp_lockdown_title = ' DISABLED="DISABLED" ';
				$tmp_lockdown_link = ' DISABLED="DISABLED" ';
				
				$post_tmp = get_post($array_data['[ATTACTEDID]']); 
				$array_data['[LINK]'] = get_permalink($array_data['[ATTACTEDID]']);
				$array_data['[TITLE]'] = $post_tmp->post_title;
			}
			

			// show type..
			if(!empty($array_data['[CGM-MAIN_SHOW]']) && $array_data['[CGM-MAIN_SHOW]'] == 'true'){
				$template = '<li class="[CLASSTYPE1] [TYPEOBJECT]">';
			} else {
				$template = '<li class="[CLASSTYPE1] [TYPEOBJECT] hidedeaktiv">';
			}
			
			//main title
			$template .= '<div class="mainTitle"><table cellspacing="0px" cellpadding="0px" width="100%"><tr>';
			$template .= 	'<td width="0%"><div id="main-number" title="'.__('Index','cgm').'" alt="'.__('Index','cgm').'" class="main-number">[INDEXNUMBER]</div></td>';
			$template .= 	'<td width="100%"><input '.$tmp_lockdown_title.' id="object-title" class="object-title" type="text" value="[TITLE]"></td>';
			$template .= 	'<td width="0%"><div class="main-move" title="'.__('Sort','cgm').'" alt="'.__('Sort','cgm').'"></div></td>';
	
			$template .= 	'<td width="0%">';
			if(!empty($array_data['[CGM-MAIN_SHOW]']) && $array_data['[CGM-MAIN_SHOW]'] == 'true'){
					$template .= '<div class="main-show" title="'.__('Show','cgm').'" alt="'.__('Show','cgm').'" onClick="cgm_change_status_image(this)"><input id="object-main-status" type="hidden" name="object-main-status" value="true"></div>';
			} else {
						$template .= '<div class="main-hide" title="'.__('Show','cgm').'" alt="'.__('Show','cgm').'" onClick="cgm_change_status_image(this)"><input id="cgm-object-main-status" type="hidden" name="cgm-object-main-status" value="false"></div>';
			}		
			$template .= 	'</td>';
			$template .= 	'<td width="0%"><div class="main-remove" title="'.__('Remove','cgm').'" alt="'.__('Remove','cgm').'" onClick="cgm_remove_new_image(this)"></div></div></td>';	
			
			
			$template .= 	'<td width="0%">';
			$template .= 				'<div class="main-role-up" title="'.__('Role up','cgm').'" alt="'.__('Role up','cgm').'" onClick="cgm_role_up_down(this)"></div>';	
			$template .= 	'</td>';
			
			$template .= 	'</tr></table></div>';
			
			
			// content
			$template .= '<div class="groupClass">';
			$template .= '<table width="100%"><tr>';
			$template .= 				'<td  width="0%"><div class="object-image-[TYPEOBJECT]"></div><div class="object-image" style="background-image:url(\''.$tmp_preview_img.'\')">';
			$template .= 				'</div></td>';
			$template .= 				'<td width="40%"><div class="object-content"><div class="small_contatiners">';
			$template .=						'<div class="object-lable">'.__('Link','cgm').':</div>';
			$template .= 						'<input '.$tmp_lockdown_link.' id="object-link" class="object-tag" type="text" value="[LINK]">';
			$template .=						'<div style="padding-top: 10px" class="object-lable">'.__('Link overwrite','cgm').':</div>';
			$template .= 						'<select id="object-link-overwrite" class="object-tag">';
													$mouseEventClicks['default'] = 'default';
													$mouseEventClicks[1] = 'Off';
													$mouseEventClicks['click'] = 'Goto link';
													$mouseEventClicks['clickNew'] = 'Goto link new page';
													$mouseEventClicks['prettyPhoto'] = 'Pretty Photo';
													$mouseEventClicks['exAll'] = 'Click to Expand to next size';
													$mouseEventClicks['ex0'] = 'Click to Expand to thumbnail';
													$mouseEventClicks['ex1'] = 'Click to Expand to medium';
													$mouseEventClicks['ex2'] = 'Click to Expand to large';
													$mouseEventClicks['ex3'] = 'Click to Expand to full';
													$mouseEventClicks['ex4'] = 'Click to Expand to custom';
													$mouseEventClicks['hex0'] = 'Hover to Expand to thumbnail';
													$mouseEventClicks['hex1'] = 'Hover to Expand to medium';
													$mouseEventClicks['hex2'] = 'Hover to Expand to large';
													$mouseEventClicks['hex3'] = 'Hover to Expand to full';
													$mouseEventClicks['hex4'] = 'Hover to Expand to custom';
													
													foreach($mouseEventClicks as $mouseEventClick_key => $mouseEventClick){
														$template .= '<option value="'.$mouseEventClick_key.'" ';
														
														if($array_data['[LINK-OVERWRITE]'] == $mouseEventClick_key){
															$template .= ' selected="selected"';
														}
														$template .= ' >'.$mouseEventClick.'</option>';		
													}
			$template .=						'</select>';
			$template .=						'<div style="padding-top: 10px" class="object-lable">'.__('Description','cgm').':</div>';
			$template .= 						'<textarea '.$tmp_lockdown_desc.' id="object-description" class="object-textarial">[CONTENT]</textarea>';		
			$template .= 				'</div></div></td>';	
			$template .= 					'<td width="40%"><div class="object-content"><div class="small_contatiners">';
			$template .=						'<div class="object-lable">'.__('Category','cgm').':</div>';
			$template .=						'<div class="object-category">';
			$template .=							$create_default_categoryes;
			$template .=						'</div>';
			$template .= 					'</div></div></td>';		
			$template .= 					'<td width="20%"><div class="object-imagesize"><div class="small_contatiners">';
			$template .=						'<div class="object-lable">'.__('Image size','cgm').':</div>';
			$template .=						'<div class="object-imagegroup">';
			$template .= 							$images_size;
			$template .= 						'</div></div></td>';	
			$template .= '</tr></table>';
			$template .= '<input id="object-post_id" type="hidden" value="[POSTID]">';
			$template .= '<input id="object-attacted_id" type="hidden" value="[ATTACTEDID]">';
			$template .= '<input id="object-type-object" type="hidden" value="[TYPEOBJECT]">';
			$template .= '</div>';
			$template .= '</li>';	
		}

		if($tmp_controle){
			return $template;
		} else {
			foreach($array_data as $test_key=>$test_tmp_data){
				if(!is_array($test_tmp_data)){
					$template = str_replace(strtoupper($test_key),$test_tmp_data, $template);
				}
			}
			return $template;
		}
	}
	
	// checks if it is the right post type
	function is_post_type(){
		global $post;
		
		
		if(empty($post)){
			$post = (object)array();
			$post->post_type = '';
		}
		
		if((!empty($_GET['post_type']) and !empty($this->parent_id) and !empty($this->post_type) and !empty($post) and !empty($post->post_type) and $_GET['post_type'] == $this->parent_id.'-'.$this->post_type) || $post->post_type == $this->parent_id.'-'.$this->post_type){
			return true;
		} else if(!empty($_POST['post_type']) and !empty($this->parent_id) and !empty($this->post_type) and $_POST['post_type'] == $this->parent_id.'-'.$this->post_type){
			return true;
		} else {
			return false;
		}
	}
}
?>