<?php 
 	global $complete_gallery_display,$_wp_additional_image_sizes;
	$options_panel = '';
	$options_panel[] = array('type' => 'div_start');	
	
	
	$options_panel[] = array('title'=>'Template Settings',
							 'type' => 'themeselectorStart',
							 'slidertype' => 'isotope',
							 'help_main' => __('Select main template','cgm'),
							 'help_save' => __('Save your template','cgm'),
							 'help_delete' => __('Remove templates','cgm'),
							 'ID'=>'theme_settings');
	
	$options_panel[] = array('title'=> 'General Settings',
							 'type' => 'title',
							 'ID'=>'general_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'general_settings');
	
	$options_panel[] = array('title'=> 'Height', 
							 'name' => 'height',
							 'type' => 'number',
							 'help' => __('Height of the gallery in pixels. If left empty it will be 100%','cgm'));
							 
	$options_panel[] = array('title'=> 'Width', 
							 'name' => 'width',
							 'type' => 'number',
							 'help' => __('Width of the gallery in pixels. If left empty it will be 100%','cgm'));
	
	$options_panel[] = array('title'=> 'Show Menu', 
							 'name' => 'showmenu',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show menu','cgm'));
	
	
	$options_panel[] = array('title'=> 'Show fullscreen Button', 
							 'name' => 'fullscreenbutton',
							 'type' => 'dropdown',
							 'default' => '0',
							 'list' =>  array(  '0'=>'Off',
											    '1'=>'Full Browser',
											    '2'=>'Full Screen'),
							'help' => __('Set fullscreen button','cgm'));
	
	
	
		$options_panel[] = array('title'=> 'Fullscreen text', 
							 'name' => 'fullscreentext',
							 'type' => 'string',
							 'default' => 'Fullscreen',
							 'help' => __('Set fullscreen button text','cgm'));
	
	$options_panel[] = array('title'=> 'Exit Fullscreen text', 
							 'name' => 'fullscreenexittext',
							 'type' => 'string',
							 'default' => 'Exit Fullscreen',
							 'help' => __('Set fullscreen button text','cgm'));
	
	$options_panel[] = array('title'=> 'Fullscreen bg color', 
							 'name' => 'fullscreenbuttonbgcolor',
							 'type' => 'color',
							 'default' => '#000000',
							 'help' => __('Set the color of the background','cgm'));
	
	$options_panel[] = array('title'=> 'Fullscreen bg opacity', 
							 'name' => 'fullscreenbuttonbgopacity',
							 'type' => 'number',
							 'default' => 1,
							 'help' => __('opacity','cgm'));
	
	
	
	$mouseEventClick[1] = 'Off';
	$mouseEventClick['click'] = 'Goto link';
	$mouseEventClick['clickNew'] = 'Goto link new page';
	$mouseEventClick['prettyPhoto'] = 'Pretty Photo';
	$mouseEventClick['exAll'] = 'Expand to next size';
	$mouseEventClick['ex0'] = 'Click to Expand to thumbnail';
	$mouseEventClick['ex1'] = 'Click to Expand to medium';
	$mouseEventClick['ex2'] = 'Click to Expand to large';
	$mouseEventClick['ex3'] = 'Click to Expand to full';
	$mouseEventClick['ex4'] = 'Click to Expand to custom';
	$mouseEventClick['hex0'] = 'Hover to Expand to thumbnail';
	$mouseEventClick['hex1'] = 'Hover to Expand to medium';
	$mouseEventClick['hex2'] = 'Hover to Expand to large';
	$mouseEventClick['hex3'] = 'Hover to Expand to full';
	$mouseEventClick['hex4'] = 'Hover to Expand to custom';

	$options_panel[] = array('title'=> 'Mouse Click',
								'name' => 'mouseEventClick',
								'type' => 'dropdown', 
								'list'=> $mouseEventClick,
								'default' => 'prettyPhoto',
								'help' => __('Choose action by click','cgm'));

	$options_panel[] = array('title'=> 'Animation type',
							 'name' => 'animation__type',
							 'type' => 'dropdown',
							 'default' => 'best-available', 
							 'list' =>  array(  'best-available'=>'Best Available',
							 					'jQuery'=>'jQuery',
											    'css'=>'Css'),
							 'help' => __('Choose the animation type','cgm'));		
							 	
	$options_panel[] = array('title'=> 'Animation duration', 
							 'name' => 'animation__duration',
							 'type' => 'number',
							 'default' => '800',
							 'help' => __('Set the duration of the animation in milliseconds','cgm'));
							 	
	$options_panel[] = array('title'=> 'Animation easing',
							 'name' => 'animation__easing',
							 'type' => 'dropdown', 
							 'list' =>  array(  'linear'=>'Linear',
											    'swing'=>'Swing',
												'easeInQuad'=>'Ease In Quad',
												'easeOutQuad'=>'Ease Out Quad',
												'easeInOutQuad'=>'Ease In Out Quad',
												'easeInCubic'=>'Ease In Cubic',
												'easeOutCubic'=>'Ease Out Cubic',
												'easeInOutCubic'=>'Ease In Out Cubic',
												'easeInQuart'=>'Ease In Quart',
												'easeOutQuart'=>'Ease Out Quart',
												'easeInOutQuart'=>'Ease In Out Quart',
												'easeInQuint'=>'Ease In Quint',
												'easeOutQuint'=>'Ease Out Quint',
												'easeInOutQuint'=>'Ease In Out Quint',
												'easeInSine'=>'Ease In Sine',
												'easeOutSine'=>'Ease Out Sine',
												'easeInOutSine'=>'Ease In Out Sine',
												'easeInExpo'=>'Ease In Expo',
												'easeOutExpo'=>'Ease Out Expo',
												'easeInOutExpo'=>'Ease In Out Expo',
												'easeInCirc'=>'Ease In Circ',
												'easeOutCirc'=>'Ease Out Circ',
												'easeInOutCirc'=>'Ease In Out Circ',
												'easeInElastic'=>'Ease In Elastic',
												'easeOutElastic'=>'Ease Out Elastic',
												'easeInOutElastic'=>'Ease In Out Elastic',
												'easeInBack'=>'Ease In Back',
												'easeOutBack'=>'Ease Out Back',
												'easeInOutBack'=>'Ease In Out Back',
												'easeInBounce'=>'Ease In Bounce',
												'easeOutBounce'=>'Ease Out Bounce',
												'easeInOutBounce'=>'Ease In Out Bounce'),
							 'help' => __('Choose the default easing setting. Please notice this only applies if you choose jQuery as animation type.','cgm'));

	$options_panel[] = array('type' => 'groupEnd');
	$options_panel[] = array('title'=> 'Layout Settings',
							 'type' => 'title',
							 'ID'=>'layout_settings');				 		
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'layout_settings');
							
							 		
	$options_panel[] = array('title'=> 'Default layout',
							 'name' => 'layout__default',
							 'type' => 'dropdown', 
							 'list' =>  array('masonry'=>'Masonry',
							 			 	  'fitRows'=>'Fit Rows',
							 			 	  'cellsByRow'=>'Cells By Row',
							 			 	  'straightDown'=>'Straight Down',
							 			 	  'masonryHorizontal'=>'Masonry Horizontal',
							 			 	  'fitColumns'=>'Fit Columns',
							 			 	  'cellsByColumn'=>'Cells By Column',
							 			 	  'straightAcross'=>'Straight Across'),
							 'help' => __('Choose the default layout setting','cgm'));								 		
							 		
	$options_panel[] = array('title'=> 'Show Masonry', 
							 'name' => 'layout__masonry',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Masonry in layout menu','cgm'));		
							 			 		
	$options_panel[] = array('title'=> 'Show Fit Rows', 
							 'name' => 'layout__fitRows',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Fit Rows in layout menu','cgm'));							 		
							 		
	$options_panel[] = array('title'=> 'Show Cells By Row', 
							 'name' => 'layout__cellsByRow',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Cells By Row in layout menu','cgm'));	 		
							 		
	$options_panel[] = array('title'=> 'Show Straight Down', 
							 'name' => 'layout__straightDown',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Straight Down in layout menu','cgm'));		
							 			
	$options_panel[] = array('title'=> 'Show Masonry Horizontal', 
							 'name' => 'layout__masonryHorizontal',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Masonry Horizontal in layout menu','cgm'));
							 							 	
	$options_panel[] = array('title'=> 'Show Fit Columns layout', 
							 'name' => 'layout__fitColumns',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show fitColumns in layout menu','cgm'));	 		
							 		
	$options_panel[] = array('title'=> 'Show Cells By Column', 
							 'name' => 'layout__cellsByColumn',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Cells By Column in layout menu','cgm'));
							 	
	$options_panel[] = array('title'=> 'Show Straight Across', 
							 'name' => 'layout__straightAcross',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Straight Across in layout menu','cgm'));						 	
							 	
	$options_panel[] = array('type' => 'groupEnd');	 
	
	
	// ------------- filter settings
		
	$options_panel[] = array('title'=> 'Filter Settings',
							 'type' => 'title',
							 'ID'=>'filter_settings');		
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'filter_settings');
							 
						 	
	$options_panel[] = array('title'=> 'Show Category Menu', 
							 'name' => 'filters',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Category filter menu','cgm'));				
							 			
	$options_panel[] = array('title'=> 'All button text', 
							 'name' => 'filtersAllText',
							 'type' => 'string',
							 'default' => 'All',
							 'help' => __('Show all button filter menu','cgm'));	
		 			
	$categoryMenuEventClick['ASC'] = 'Ascending';
	$categoryMenuEventClick['DESC'] = 'Descending';
	$categoryMenuEventClick['MANUALT'] = 'Manual';

	$options_panel[] = array('title'=> 'Category Menu Sort',
								'name' => 'filtersDirrection',
								'type' => 'dropdown', 
								'list'=> $categoryMenuEventClick,
								'help' => __('Choose Ascending or Descending sorting for the Category menu.','cgm'));		
						 	
						 	
	$options_panel[] = array('title'=> 'Category Menu Manual', 
							 'name' => 'filtersSortOrder',
							 'type' => 'categorysort',
							 'help' => __('Manually sort category menu. When done update gallery.','cgm'));	
						 	
						 	
	$options_panel[] = array('title'=> 'Show Combination Label', 
							 'name' => 'filtersShowLabel',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Combination Filters label','cgm'));	
						 	
	$options_panel[] = array('title'=> 'Combination filters', 
							 'name' => 'filterscategory',
							 'type' => 'categorygroup',
							 'help' => __('Add a Combination Filter and then assign categories to the filter.','cgm'));			 	
		 	
	$options_panel[] = array('type' => 'groupEnd');
	
	
	//--------------------- Sort settings
	
	
	$options_panel[] = array('title'=> 'Sort Settings',
							 'type' => 'title',
							 'ID'=>'sort_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'sort_settings');	
							 
	$options_panel[] = array('title'=> 'Show direction menu', 
							 'name' => 'sort__order',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Sort Direction filter menu','cgm')); 							 
							 
	$options_panel[] = array('title'=> 'Defualt sort Direction',
								'name' => 'sort__directiondefault',
								'type' => 'dropdown', 
								'list'=> $categoryMenuEventClick,
								'help' => __('Choose Ascending or Descending sorting direcrtion','cgm'));	 					 
	$options_panel[] = array('title'=> 'Default sort',
							 'name' => 'sort__default',
							 'type' => 'dropdown', 
							 'list' =>  array('index'=>'Index','title'=>'Title','date'=>'Date','desc'=>'Description','link'=>'Link','imgsize'=>'Image size','random'=>'Random'),
							 'help' => __('Choose the default sort setting','cgm'));	 
							 		 
	$options_panel[] = array('title'=> 'Sort index', 
							 'name' => 'sort__index',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show sort id in the sort menu','cgm'));						 
							 
	$options_panel[] = array('title'=> 'Sort title', 
							 'name' => 'sort__title',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show sort title in the sort menu','cgm'));	
	
	$options_panel[] = array('title'=> 'Sort date', 
							 'name' => 'sort__date',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show sort date in the sort menu','cgm'));	
							 	 
	$options_panel[] = array('title'=> 'Sort description', 
							 'name' => 'sort__desc',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show sort description in the short menu','cgm'));					 		
							 			
	$options_panel[] = array('title'=> 'Sort link', 
							 'name' => 'sort__link',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show sort link in the sort menu','cgm'));							 			
							 			
	$options_panel[] = array('title'=> 'Sort image size', 
							 'name' => 'sort__imageSize',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show image size in the sort menu','cgm'));		
	
	$options_panel[] = array('title'=> 'Sort Images Random', 
							 'name' => 'sort__random',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Random order images in the sort menu','cgm'));		
	$options_panel[] = array('type' => 'groupEnd');	
	
	
	
	
	
	
	
	//--------------------- Icon settings
	
	
		$options_panel[] = array('title'=> 'Overlay Icon Settings',
							 'type' => 'title',
							 'ID'=>'overlayicon_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'overlayicon_settings');	
							  		 
							  		 
	$options_panel[] = array('title'=> 'Opacity filter', 
							 'name' => 'overlayicon__opacity',
							 'type' => 'number',
							 'default' => '0.9',
							 'help' => __('Set Opacity Filter','cgm'));					  		 
							  		 
	$options_panel[] = array('title'=> 'Video icon', 
							 'name' => 'overlayicon__video',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show overlay icon on thumbnail for Video','cgm'));						 
							 
	$options_panel[] = array('title'=> 'Gallery icon', 
							 'name' => 'overlayicon__gallary',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show overlay icon on thumbnail for Gallery','cgm'));	
	
	$options_panel[] = array('title'=> 'Link icon', 
							 'name' => 'overlayicon__link',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon on thumbnail for Link','cgm'));						 
							 
	$options_panel[] = array('title'=> 'Pretty photo icon', 
							 'name' => 'overlayicon__prettyphoto',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon on thumbnail','cgm'));	
							 
	$options_panel[] = array('title'=> 'Post icon', 
							 'name' => 'overlayicon__post',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon on thumbnail for Post','cgm'));				 
							 
	$options_panel[] = array('title'=> 'Page icon', 
							 'name' => 'overlayicon__page',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon on thumbnail for Page','cgm'));							 
							 
							 
	$options_panel[] = array('type' => 'groupEnd');
	
	
	
	
	// --------------------- Pretty photo
	
	
	$options_panel[] = array('title'=> 'Pretty Photo Settings',
							 'type' => 'title',
							 'ID'=>'pretty_photo_settings');		 	
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'pretty_photo_settings');
	
	$options_panel[] = array('title'=> 'Show Title', 
							 'name' => 'pretty__showtitle',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show title above images','cgm'));
							 
	$options_panel[] = array('title'=> 'Show Description', 
							 'name' => 'pretty__showdecs',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show description below images','cgm'));
							 		 	
							 
	$options_panel[] = array('title'=> 'Show thumbnails', 
							 'name' => 'pretty__thumbnails',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show thumbnails on mouse over','cgm'));					 
							 
							 
							 
							 
	$options_panel[] = array('title'=> 'Show Facebook button', 
							 'name' => 'pretty__facebook',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Facebook Like button','cgm'));	 	
							 		 	
							 
	$options_panel[] = array('title'=> 'Show Tweet button', 
							 'name' => 'pretty__tweet',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Tweet button','cgm'));		 		 	
							 		 	
							 
	$options_panel[] = array('title'=> 'Show Pinterest button', 
							 'name' => 'pretty__pinterest',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Pinterest button','cgm'));	 		 	

							 
	$options_panel[] = array('title'=> 'Show Google+ button', 
							 'name' => 'pretty__google',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show Google+ button','cgm'));	 		 	

	$options_panel[] = array('title'=> 'Show Download button', 
							 'name' => 'pretty__download',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show Download button','cgm'));



	$options_panel[] = array('title'=> 'Overlay BG Color', 
							 'name' => 'pretty__overlaybgcolor',
							 'type' => 'color',
							 'default' => '#000000',
							 'help' => __('Overlay backgroud color','cgm'));	
							 
	$options_panel[] = array('title'=> 'Overlay Opacity ', 
							 'name' => 'pretty__overlayopacity',
							 'type' => 'number',
							 'default' => '0.8',
							 'help' => __('Set Opacity Filter','cgm'));		



	$options_panel[] = array('title'=> 'Autoplay Slideshow', 
							 'name' => 'pretty__autoplayslideshow',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Autoplay Slideshow','cgm'));		
							 	
	$options_panel[] = array('title'=> 'Slideshow', 
							 'name' => 'pretty__slideshow',
							 'type' => 'number',
							 'default' => '5000',
							 'help' => __('Slideshow time milliseconds. Default value is 5000','cgm'));
							 
	$options_panel[] = array('title'=> 'Theme',
							 'name' => 'pretty__theme',
							 'type' => 'dropdown', 
							 'list' =>  array(  'pp_default'=>'Default',
											    'light_rounded'=>'Light Rounded',
												'dark_rounded'=>'Dark Rounded',
												'light_square'=>'Light Square',
												'dark_square'=>'Dark Square',
												'facebook'=>'Facebook'),
							 'help' => __('Choose template for prettyPhoto','cgm'));					 	
		 	

	$options_panel[] = array('title'=> 'Animation Speed',
							 'name' => 'pretty__animationspeed',
							 'type' => 'dropdown', 
							 'default' => 'normal',
							 'list' =>  array(  'slow'=>'Slow',
											    'normal'=>'Normal',
												'fast'=>'Fast'),
							 'help' => __('Set animation speed for prettyPhoto','cgm'));	
	$options_panel[] = array('type' => 'groupEnd');
	
	
	
	// --------------- Captions Settings
	
	
	$options_panel[] = array('title'=> 'Captions Settings',
							 'type' => 'title',
							 'ID'=>'captions_settings');	
							 
							 	 	
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'captions_settings');
	
	$options_panel[] = array('title'=> 'Show Title', 
							 'name' => 'captions__showtitle',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show title of image','cgm'));
							 
	$options_panel[] = array('title'=> 'Show Description', 
							 'name' => 'captions__showdecs',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show description of image','cgm'));
							 		 			 		 	
	$options_panel[] = array('title'=> 'Max word of description', 
							 'name' => 'captions__maxNumberWord',
							 'type' => 'dropdown',
							 'default' => '',
							 'list' =>  array(  ''=>'Show all',
											    '5'=>'5',
											    '10'=>'10',
												'15'=>'15',
												'20'=>'20',
												'25'=>'25',
												'30'=>'30',
												'35'=>'35',
												'40'=>'40',
												'45'=>'45',
												'50'=>'50',										
												'75'=>'75',
												'100'=>'100',
												'125'=>'125',
												'150'=>'150'),
							 'help' => __('Show only number of words in description text','cgm'));	 	
							 		 	
							 		 	
	$options_panel[] = array('title'=> 'Max word indicator', 
							 'name' => 'captions__maxNumberWordIndicator',
							 'type' => 'dropdown',
							 'default' => '...',
							 'list' =>  array(  ' <lable>...'.'</lable>'=>'...',
							 				    ' <lable>[ ... ]'.'</lable>'=>'[ ... ]',
											    '. <lable>'.__('read more','cgm').'</lable>'=> __('read more','cgm'),
											    '. <lable>'.__('Read more','cgm').'</lable>'=> __('Read more','cgm'),
											    '. <lable>'.__('Read More','cgm').'</lable>'=> __('Read More','cgm'),
											    '. <lable>'.__('READ MORE','cgm').'</lable>'=> __('READ MORE','cgm'),
											    '. <lable>'.__('more','cgm').'</lable>'=> __('more','cgm'),
											    '. <lable>'.__('More','cgm').'</lable>'=> __('More','cgm'),
											    '. <lable>'.__('MORE','cgm').'</lable>'=> __('MORE','cgm'),
												''=>'No indicator'),
							 'help' => __('Show indicator','cgm'));		
							 		 	
							 		 	
							 		 	
	$options_panel[] = array('title'=> 'Type',
							 'name' => 'captions__type',
							 'type' => 'dropdown',
							 'default' => 'push bottom',
							 'list' =>  array(  'none'=>'No Captions',
							 					'title_below'=>'Title below',
							 					'title_decs_below' => 'Title + Desc below',
							 					'boxes'=>'3d Box',
							 					'appear titlebottom'=>'Title always + Appear description',
							 					'push left'=>'Push Left',
											    'push right'=>'Push Right',
												'push top'=>'Push Top',
												'push bottom'=>'Push Bottom',
												'push top left'=>'Push Top + Left',
												'push top right'=>'Push Top + Right',
												'push bottom left'=>'Push Bottom + Left',
												'push bottom right'=>'Push Bottom + Right',
												'appear left'=>'Appear Left',
												'appear right'=>'Appear Right',										
												'appear top'=>'Appear Top',
												'appear bottom'=>'Appear Bottom',
												'appear always left'=>'Appear Always Left',
												'appear always right'=>'Appear Always Right',
												'appear always top'=>'Appear Always Top',
												'appear always bottom'=>'Appear Always Bottom',
												'flip horizontal'=>'Flip Horizontal',
												'flip vertical'=>'Flip Vertical',
												),
							 'help' => __('Choose the caption template. Please notice that the Flip effect is only supported by Webkit browsers like Chrome and Safari.','cgm'));
	
	$options_panel[] = array('title'=> 'Hover area size %', 
							 'name' => 'captions__hoversize',
							 'type' => 'number',
							 'default' => '50',
							 'help' => __('This hover size is set in %','cgm')); 
	
	$options_panel[] = array('title'=> 'Align',
							 'name' => 'captions__align',
							 'type' => 'dropdown', 
							 'list' =>  array(  'left'=>'Left',
											    'center'=>'Center',
												'right'=>'Right'),
							 'help' => __('Set the alignment for caption','cgm'));
	
	
	$options_panel[] = array('title'=> 'Title Text size', 
							 'name' => 'captions__h1__fontSize',
							 'type' => 'number',
							 'default' => '16',
							 'help' => __('Set the font size. If not set the default is 16','cgm')); 
							 
	$options_panel[] = array('title'=> 'Title Text Color', 
							 'name' => 'captions__h1__textColor',
							 'type' => 'color',
							 'default' => '#333333',
							 'help' => __('Set the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Title Font family', 
							 'name' => 'captions__h1__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Choose the font family','cgm')); 

	$options_panel[] = array('title'=> 'Title Underline', 
							 'name' => 'captions__h1__underline',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show underline on the title','cgm'));	

	$options_panel[] = array('title'=> 'Title Bold', 
							 'name' => 'captions__h1__bold',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Make the title bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Title Italic', 
							 'name' => 'captions__h1__italic',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Make the title italic','cgm'));
	
							 
	$options_panel[] = array('title'=> 'Title shadow color', 
							 'name' => 'captions__h1__textShadowColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Title shadow opacity', 
							 'name' => 'captions__h1__textShadowOpacity',
							 'type' => 'number',
							 'default' => '0.85',
							 'help' => __('Set the Alpha (transparency) value. If not set the deafault is 0.85.','cgm'));
							 
	$options_panel[] = array('title'=> 'Title shadow x', 
							 'name' => 'captions__h1__textShadowX',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Title shadow y', 
							 'name' => 'captions__h1p__textShadowY',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Title shadow blur', 
							 'name' => 'captions__h1__textShadowBlue',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the blue radius of the shadow','cgm'));
	
	$options_panel[] = array('title'=> 'Desc. Text size', 
							 'name' => 'captions__p__fontSize',
							 'type' => 'number',
							 'default' => '12',
							 'help' => __('Set the font size. If not set the default value is 12','cgm')); 
							 
	$options_panel[] = array('title'=> 'Desc. Text Color', 
							 'name' => 'captions__p__textColor',
							 'type' => 'color',
							 'default' => '#333333',
							 'help' => __('Set the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Desc. Font family', 
							 'name' => 'captions__p__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Choose the font family for the description','cgm')); 

	$options_panel[] = array('title'=> 'Desc. Underline', 
							 'name' => 'captions__p__underline',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Make the description underlined','cgm'));	

	$options_panel[] = array('title'=> 'Desc. Bold', 
							 'name' => 'captions__p__bold',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Make the description bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Desc. Italic', 
							 'name' => 'captions__p__italic',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Make the description italic','cgm'));
						 
	$options_panel[] = array('title'=> 'Desc. shadow color', 
							 'name' => 'captions__p__textShadowColor',
							 'type' => 'color',
							 'help' => __('Set the color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Desc. shadow opacity', 
							 'name' => 'captions__p__textShadowOpacity',
							 'type' => 'number',
							 'help' => __('Set the Alpha (transparency) value','cgm'));
							 
	$options_panel[] = array('title'=> 'Desc. shadow x', 
							 'name' => 'captions__p__textShadowX',
							 'type' => 'number',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Desc. shadow y', 
							 'name' => 'captions__p__textShadowY',
							 'type' => 'number',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Desc. shadow blur', 
							 'name' => 'captions__p__textShadowBlue',
							 'type' => 'number',
							 'help' => __('Set the blur radius of the shadow','cgm'));

	$options_panel[] = array('title'=> 'Padding', 
							 'name' => 'captions__padding',
							 'type' => 'string',
							 'default'=> '4px 4px 4px 4px',
							 'help' => __('You can set padding like normal css, e.g <br><br><b>padding:10px 5px 15px 20px</b><br>top padding is 10px<br>right padding is 5px<br>bottom padding is 15px<br>left padding is 20px<br><br><b>padding:10px 5px 15px</b><br>top padding is 10px<br>right and left padding are 5px<br>bottom padding is 15px<br><br><b>padding:10px 5px</b><br>top and bottom padding are 10px<br>right and left padding are 5px<br><br><b>padding:10px</b><br>all four paddings are 10px','cgm'));

	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'captions__backgroundColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('The background color for the main area of the gallery. Can be either a simple HTML color string, e.g. red or #00cc00, or an object with the following properties.','cgm'));	
							 								 	
	$options_panel[] = array('title'=> 'Background Opacity', 
							 'name' => 'captions__opacity',
							 'type' => 'number',
							 'default' => '0.8',
							 'help' => __('Set the background opacity. If not set the default value is 0.8.','cgm'));

	$options_panel[] = array('type' => 'groupEnd');
	
	// ------------------ New line
	
	$options_panel[] = array('type' => 'div_break',
							 'extra_td'=>array('width'=>'50%'));					 	
							 
	// ------------------ New line
	
	$options_panel[] = array('title'=> 'Universal Scroll Settings',
							 'type' => 'title',
							 'ID'=>'universal_scroll_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'universal_scroll_settings');
	
	$options_panel[] = array('title'=> 'Pictures loaded',
							 'name' => 'universallScroll__loadNumber',
							 'type' => 'dropdown', 
							 'list' =>  array(''=>'None',10=>'10',25=>'25', 50=>'50',75=>'75',100=>'100',125=>'125',150=>'150',175=>'175',200=>'200'),
							 'help' => __('Universal scroll show numbers of objects','cgm'));	

	
	
	$options_panel[] = array('title'=> 'Text size', 
							 'name' => 'universallScroll__fontSize',
							 'type' => 'number',
							 'default' => '15',
							 'help' => __('Set the Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Text Color', 
							 'name' => 'universallScroll__textColor',
							 'type' => 'color',
							 'default' => '#333333',
							 'help' => __('Set the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Font family', 
							 'name' => 'universallScroll__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Set the Font family','cgm')); 

	$options_panel[] = array('title'=> 'Underline', 
							 'name' => 'universallScroll__underline',
							 'type' => 'boolean',
							 'help' => __('Show underline','cgm'));	

	$options_panel[] = array('title'=> 'Bold', 
							 'name' => 'universallScroll__bold',
							 'type' => 'boolean',
							 'help' => __('Show bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Italic', 
							 'name' => 'universallScroll__italic',
							 'type' => 'boolean',
							 'help' => __('Show italic','cgm'));		 
							 
	$options_panel[] = array('title'=> 'Text shadow color', 
							 'name' => 'universallScroll__textShadowColor',
							 'type' => 'color',
							 'help' => __('Set the color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Text shadow opacity', 
							 'name' => 'universallScroll__textShadowOpacity',
							 'type' => 'number',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow x', 
							 'name' => 'universallScroll__textShadowX',
							 'type' => 'number',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Text shadow y', 
							 'name' => 'universallScroll__textShadowY',
							 'type' => 'number',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow blur', 
							 'name' => 'universallScroll__textShadowBlue',
							 'type' => 'number',
							 'help' => __('Set the blur radius of the shadows','cgm'));	 
							 
							 
	$options_panel[] = array('title'=> 'Padding', 
							 'name' => 'universallScroll__padding',
							 'type' => 'string',
							 'default'=> '5px 5px 5px 5px',
							 'help' => __('You can set padding like normal css, e.g <br><br><b>padding:10px 5px 15px 20px</b><br>top padding is 10px<br>right padding is 5px<br>bottom padding is 15px<br>left padding is 20px<br><br><b>padding:10px 5px 15px</b><br>top padding is 10px<br>right and left padding are 5px<br>bottom padding is 15px<br><br><b>padding:10px 5px</b><br>top and bottom padding are 10px<br>right and left padding are 5px<br><br><b>padding:10px</b><br>all four paddings are 10px','cgm'));
							 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'universallScroll__backgroundColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'universallScroll__borderColor',
							 'type' => 'color',
							 'default' => '#dcdcdc',
							 'help' => __('Set the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'universallScroll__borderWidth',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the Width of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'universallScroll__borderRadius',
							 'type' => 'number',
							 'default' => '0',
							 'help' => __('Set the Radius of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'universallScroll__borderStyle',
							 'type' => 'dropdown',
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm')); 
							 
	$options_panel[] = array('type' => 'groupEnd');
	
	
	$options_panel[] = array('title'=> 'Preloader Settings',
							 'type' => 'title',
							 'ID'=>'preloader_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'preloader_settings');

	$options_panel[] = array('title'=> 'Show Preloader Menu', 
							 'name' => 'preloader__show',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Select whether to Show or not Show the Preloader','cgm'));	
							 
	$options_panel[] = array('title'=> 'Preloader Text', 
							 'name' => 'preloader__loadingText',
							 'type' => 'string',
							 'default' => 'Loading',
							 'help' => __('Set the Preloader text','cgm')); 
							 
	$options_panel[] = array('title'=> 'Preloader Width', 
							 'name' => 'preloader__prewidth',
							 'type' => 'number',
							 'default' => '200',
							 'help' => __('If you remove the value or set it to 0 the width will be 100%','cgm')); 
							 
	$options_panel[] = array('title'=> 'Preloader Aligment',
							 'name' => 'preloader__posalign',
							 'type' => 'dropdown',
							 'default' => 'center',
							 'list' =>  array('left'=>'Left','center'=>'Center','right'=>'Right'),
							 'help' => __('Set the alignment of the Preloader box','cgm')); 
							 

	$options_panel[] = array('title'=> 'Text Aligment',
							 'name' => 'preloader__textalign',
							 'type' => 'dropdown',
							 'default' => 'center',
							 'list' =>  array('left'=>'Left','center'=>'Center','right'=>'Right'),
							 'help' => __('Set the alignment of the text in the Preloader box','cgm')); 

	$options_panel[] = array('title'=> 'Text Size', 
							 'name' => 'preloader__fontSize',
							 'type' => 'number',
							 'default' => '15',
							 'help' => __('Set the Font Size used for the text in the Preloader','cgm')); 
							 
	$options_panel[] = array('title'=> 'Text Color', 
							 'name' => 'preloader__textColor',
							 'type' => 'color',
							 'default' => '#333333',
							 'help' => __('Set the Color of the Text in the Preloader box','cgm'));
							 
	$options_panel[] = array('title'=> 'Font Family', 
							 'name' => 'preloader__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Set the Font Family used for the Preloader text','cgm')); 

	$options_panel[] = array('title'=> 'Underline', 
							 'name' => 'preloader__underline',
							 'type' => 'boolean',
							 'help' => __('Select whether to Underline or not Underline the text in the Preloader','cgm'));	

	$options_panel[] = array('title'=> 'Bold', 
							 'name' => 'preloader__bold',
							 'type' => 'boolean',
							 'help' => __('Select whether to make the text in the preloader Bold or not Bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Italic', 
							 'name' => 'preloader__italic',
							 'type' => 'boolean',
							 'help' => __('Select whether to make the text in the Preloader Italic or not Italic','cgm'));		 
							 
	$options_panel[] = array('title'=> 'Text Shadow Color', 
							 'name' => 'preloader__textShadowColor',
							 'type' => 'color',
							 'help' => __('Set the Color of Shadow to the Preloader text','cgm'));
		
	$options_panel[] = array('title'=> 'Text Shadow Opacity', 
							 'name' => 'preloader__textShadowOpacity',
							 'type' => 'number',
							 'help' => __('Set the Opacity (alpha transparency) of the Text Shadow in the Preloader','cgm'));
							 
	$options_panel[] = array('title'=> 'Text Shadow x', 
							 'name' => 'preloader__textShadowX',
							 'type' => 'number',
							 'help' => __('Set the x position (offset) of the text shadow in the preloader','cgm'));
					
	$options_panel[] = array('title'=> 'Text Shadow y', 
							 'name' => 'preloader__textShadowY',
							 'type' => 'number',
							 'help' => __('Set the y position (offset) of the text shadow in the Preloader','cgm'));
							 
	$options_panel[] = array('title'=> 'Text Shadow Blur', 
							 'name' => 'preloader__textShadowBlue',
							 'type' => 'number',
							 'help' => __('Set the Blur Radius of the text shadow in the Preloader','cgm'));	 
							 
							 
	$options_panel[] = array('title'=> 'Padding', 
							 'name' => 'preloader__padding',
							 'type' => 'string',
							 'default'=> '5px 5px 5px 5px',
							 'help' => __('You can set padding like normal css, e.g <br><br><b>padding:10px 5px 15px 20px</b><br>top padding is 10px<br>right padding is 5px<br>bottom padding is 15px<br>left padding is 20px<br><br><b>padding:10px 5px 15px</b><br>top padding is 10px<br>right and left padding are 5px<br>bottom padding is 15px<br><br><b>padding:10px 5px</b><br>top and bottom padding are 10px<br>right and left padding are 5px<br><br><b>padding:10px</b><br>all four paddings are 10px','cgm'));
							 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'preloader__backgroundColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Background Color of the Preloader','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'preloader__borderColor',
							 'type' => 'color',
							 'default' => '#dcdcdc',
							 'help' => __('Set the Color of the Border of the Preloader','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'preloader__borderWidth',
							 'type' => 'number',
							 'help' => __('Set the Width of the Border in the Preloader','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'preloader__borderRadius',
							 'type' => 'number',
							 'default' => '0',
							 'help' => __('Set the Radius of the Border in the Preloader. This effect will created rounded corners','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'preloader__borderStyle',
							 'type' => 'dropdown',
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm')); 
							 
	$options_panel[] = array('type' => 'groupEnd');	
	
	// --------- item style settings
						
						
	$options_panel[] = array('title'=> 'Item Style Settings',
							 'type' => 'title',
							 'ID'=>'item_style_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'item_style_settings');
							 
	$options_panel[] = array('title'=> 'Margin between items', 
							 'name' => 'item__margin',
							 'type' => 'string',
							 'default'=> '5px 5px 5px 5px',
							 'help' => __('You can set margin like normal css, e.g <br><br><b>margin:10px 5px 15px 20px</b><br>top margin is 10px<br>right margin is 5px<br>bottom margin is 15px<br>left margin is 20px<br><br><b>margin:10px 5px 15px</b><br>top margin is 10px<br>right and left margin are 5px<br>bottom margin is 15px<br><br><b>margin:10px 5px</b><br>top and bottom margin are 10px<br>right and left margin are 5px<br><br><b>margin:10px</b><br>all four margin are 10px','cgm'));
	
	$options_panel[] = array('title'=> 'Padding', 
							 'name' => 'item__padding',
							 'type' => 'string',
							 'default'=> '5px 5px 5px 5px',
							 'help' => __('You can set padding like normal css, e.g <br><br><b>padding:10px 5px 15px 20px</b><br>top padding is 10px<br>right padding is 5px<br>bottom padding is 15px<br>left padding is 20px<br><br><b>padding:10px 5px 15px</b><br>top padding is 10px<br>right and left padding are 5px<br>bottom padding is 15px<br><br><b>padding:10px 5px</b><br>top and bottom padding are 10px<br>right and left padding are 5px<br><br><b>padding:10px</b><br>all four paddings are 10px','cgm'));
							 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'item__backgroundColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'item__borderColor',
							 'type' => 'color',
							 'default' => '#dcdcdc',
							 'help' => __('Se the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'item__borderWidth',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the Width of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'item__borderRadius',
							 'type' => 'number',
							 'help' => __('Set the Radius of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Images Radius', 
							 'name' => 'item__imageRadius',
							 'type' => 'number',
							 'help' => __('Set the Radius of the images','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'item__borderStyle',
							 'type' => 'dropdown',
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));

	$options_panel[] = array('type' => 'groupEnd');
	
	
	// ---------------------- Background settings
	
	
	$options_panel[] = array('title'=> 'Background Settings',
							 'type' => 'title',
							 'ID'=>'background_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'background_settings');
							 	
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'background__backgroundColor',
							 'type' => 'color',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'background__borderColor',
							 'type' => 'color',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'background__borderWidth',
							 'type' => 'number',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'background__borderRadius',
							 'type' => 'number',
							 'help' => __('Set the Radius of the border','cgm'));

	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'background__borderStyle',
							 'type' => 'dropdown', 
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));
		 	 			
	$options_panel[] = array('type' => 'groupEnd');	
	
	
	// --------------------- Menu settings
	
	
	$options_panel[] = array('title'=> 'Menu Settings',
							 'type' => 'title',
							 'ID'=>'menu_pos_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'menu_pos_settings');
							 
	$options_panel[] = array('title'=> 'Margin between menus', 
							 'name' => 'menu__pos__margin',
							 'type' => 'string',
							 'default'=> '10px 5px 10px 5px',
							 'help' => __('You can set margin like normal css, e.g <br><br><b>margin:10px 5px 15px 20px</b><br>top margin is 10px<br>right margin is 5px<br>bottom margin is 15px<br>left margin is 20px<br><br><b>margin:10px 5px 15px</b><br>top margin is 10px<br>right and left margin are 5px<br>bottom margin is 15px<br><br><b>margin:10px 5px</b><br>top and bottom margin are 10px<br>right and left margin are 5px<br><br><b>margin:10px</b><br>all four margin are 10px','cgm'));
	
	
	/*$options_panel[] = array('title'=> 'Show title', 
							 'name' => 'menu__pos__showtitle',
							 'type' => 'boolean',
							 'help' => __('Show description','cgm'));*/
							 		 	
	$options_panel[] = array('title'=> 'Position',
							 'name' => 'menu__pos__type',
							 'type' => 'dropdown', 
							 'list' =>  array(  'sbst'=>'Side by side top',
											    'sbsb'=>'Side by side bottom',
											    'sbstb'=>'Side by side top + bottom',
												'ldt'=>'List down top',
												'ldb'=>'List down bottom',
												'ldtb'=>'List down top + bottom'
												),
							 'help' => __('Choose template for menu location','cgm'));
	
	$options_panel[] = array('title'=> 'Align',
							 'name' => 'menu__pos__align',
							 'type' => 'dropdown', 
							 'list' =>  array('left'=>'Left','right'=>'Right'),
							 'help' => __('Choose alignment for menu','cgm'));


	$options_panel[] = array('title'=> 'Separator', 
							 'name' => 'menu__border__borderSeperator',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Set the Width of the border','cgm'));
							 
							 
	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'menu__border__borderColor',
							 'type' => 'color',
							 'default' => '#cdcdcd',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'menu__border__borderWidth',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the Width of the border','cgm'));					 
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'menu__border__borderRadius',
							 'type' => 'number',
							 'help' => __('Set the Radius of the border','cgm'));

							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'menu__border__borderStyle',
							 'type' => 'dropdown', 
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));








	$options_panel[] = array('title'=> 'Gradient Top Color', 
							 'name' => 'menu__gradientto__color',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Gradient Top Opacity', 
							 'name' => 'menu__gradientto__opacity',
							 'type' => 'number',
							 'default' => 0.5,
							 'help' => __('Set the Alpha (transparency)','cgm'));


	$options_panel[] = array('title'=> 'Gradient Bottom Color', 
							 'name' => 'menu__gradientfrom__color',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Gradient Bottom Opacity', 
							 'name' => 'menu__gradientfrom__opacity',
							 'type' => 'number',
							 'default' => 0.0,
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Press box shadow color', 
							 'name' => 'menu__pushed__textShadowColor',
							 'type' => 'color',
							 'default' => '#000000',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Press box shadow opacity', 
							 'name' => 'menu__pushed__textShadowOpacity',
							 'type' => 'number',
							 'default' => 0.6,
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Press box shadow x', 
							 'name' => 'menu__pushed__textShadowX',
							 'type' => 'number',
							 'default' => 0,
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Press box shadow y', 
							 'name' => 'menu__pushed__textShadowY',
							 'type' => 'number',
							 'default' => 2,
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Press box shadow blur', 
							 'name' => 'menu__pushed__textShadowBlue',
							 'type' => 'number',
							 'default' => 8,
							 'help' => __('Set the blur radius of the shadows','cgm'));


/*
	$options_panel[] = array('title'=> 'Title Text size', 
							 'name' => 'menu__pos__fontSize',
							 'type' => 'number',
							 'help' => __('Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Title Text Color', 
							 'name' => 'menu__pos__textColor',
							 'type' => 'color',
							 'help' => __('Color of the border.','cgm'));
							 
	$options_panel[] = array('title'=> 'Title line heigh', 
							 'name' => 'menu__pos__lineHeigh',
							 'type' => 'number',
							 'help' => __('Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Title Font family', 
							 'name' => 'menu__pos__family',
							 'type' => 'string',
							 'help' => __('Font family','cgm')); 

	$options_panel[] = array('title'=> 'Title Underline', 
							 'name' => 'menu__pos__underline',
							 'type' => 'boolean',
							 'help' => __('Show underline','cgm'));	

	$options_panel[] = array('title'=> 'Title Bold', 
							 'name' => 'menu__pos__bold',
							 'type' => 'boolean',
							 'help' => __('Show bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Title Italic', 
							 'name' => 'menu__pos__italic',
							 'type' => 'boolean',
							 'help' => __('Show italic','cgm'));
	*/
	
	$options_panel[] = array('type' => 'groupEnd');	
	
	
	
	// --------------- menu style settings
		 					 			
	$options_panel[] = array('title'=> 'Menu Style Settings',
							 'type' => 'title',
							 'ID'=>'menu_style_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'menu_style_settings');
	 
	$options_panel[] = array('title'=> 'Text size', 
							 'name' => 'menu__normal__fontSize',
							 'type' => 'number',
							 'default' => '14',
							 'help' => __('Set the Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Text Color', 
							 'name' => 'menu__normal__textColor',
							 'type' => 'color',
							 'default' => '#333333',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Font family', 
							 'name' => 'menu__normal__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Set the Font family','cgm')); 

	$options_panel[] = array('title'=> 'Underline', 
							 'name' => 'menu__normal__underline',
							 'type' => 'boolean',
							 'help' => __('Make the menu underlined','cgm'));	

	$options_panel[] = array('title'=> 'Bold', 
							 'name' => 'menu__normal__bold',
							 'type' => 'boolean',
							 'help' => __('Make the menu bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Italic', 
							 'name' => 'menu__normal__italic',
							 'type' => 'boolean',
							 'help' => __('Make the menu italic','cgm'));		 
							 
							 
	$options_panel[] = array('title'=> 'Text shadow color', 
							 'name' => 'menu__normal__textShadowColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Text shadow opacity', 
							 'name' => 'menu__normal__textShadowOpacity',
							 'type' => 'number',
							 'default' => '0.85',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow x', 
							 'name' => 'menu__normal__textShadowX',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Text shadow y', 
							 'name' => 'menu__normal__textShadowY',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow blur', 
							 'name' => 'menu__normal__textShadowBlue',
							 'type' => 'number',
							 'default' => '2',
							 'help' => __('Set the blur radius of the shadow','cgm'));
							 	 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'menu__normal__backgroundColor',
							 'type' => 'color',
							 'default' => '#ececec',
							 'help' => __('The background color for the main area of the gallery. Can be either a simple HTML color string, e.g. red or #00cc00, or an object with the following properties.','cgm'));
							 
	$options_panel[] = array('type' => 'groupEnd');	
	
	
	//-------------------- menu hover settings
	
			 
	$options_panel[] = array('title'=> 'Menu Style Hover Settings',
							 'type' => 'title',
							 'ID'=>'menu_style_hover_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'menu_style_hover_settings');
	
	$options_panel[] = array('title'=> 'Text size', 
							 'name' => 'menu__hover__fontSize',
							 'type' => 'number',
							 'default' => '14',
							 'help' => __('Set the Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Text Color', 
							 'name' => 'menu__hover__textColor',
							 'type' => 'color',
							 'default' => '#de5216',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Font family', 
							 'name' => 'menu__hover__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Set the Font family','cgm')); 

	$options_panel[] = array('title'=> 'Underline', 
							 'name' => 'menu__hover__underline',
							 'type' => 'boolean',
							 'help' => __('Make the menu underlined','cgm'));	

	$options_panel[] = array('title'=> 'Bold', 
							 'name' => 'menu__hover__bold',
							 'type' => 'boolean',
							 'help' => __('Make the menu bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Italic', 
							 'name' => 'menu__hover__italic',
							 'type' => 'boolean',
							 'help' => __('Make the menu italic','cgm'));		 
							 
	$options_panel[] = array('title'=> 'Text shadow color', 
							 'name' => 'menu__hover__textShadowColor',
							 'type' => 'color',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Text shadow opacity', 
							 'name' => 'menu__hover__textShadowOpacity',
							 'type' => 'number',
							 'default' => '0.85',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow x', 
							 'name' => 'menu__hover__textShadowX',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Text shadow y', 
							 'name' => 'menu__hover__textShadowY',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow blur', 
							 'name' => 'menu__hover__textShadowBlue',
							 'type' => 'number',
							 'default' => '2',
							 'help' => __('Set the blur radius of the shadow','cgm'));	 
							 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'menu__hover__backgroundColor',
							 'type' => 'color',
							 'default' => '#fafafa',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, e.g. red or #00cc00, or an object with the following properties.','cgm'));
	$options_panel[] = array('type' => 'groupEnd');
	
	
	// ------------------------------ menu style selected settings
	
	
	$options_panel[] = array('title'=> 'Menu Style Selected Settings',
							 'type' => 'title',
							 'ID'=>'menu_style_selected_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'menu_style_selected_settings');
	
	$options_panel[] = array('title'=> 'Text size', 
							 'name' => 'menu__selected__fontSize',
							 'type' => 'number',
							 'default' => '14',
							 'help' => __('Set the Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Text Color', 
							 'name' => 'menu__selected__textColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Font family', 
							 'name' => 'menu__selected__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Set the Font family','cgm')); 

	$options_panel[] = array('title'=> 'Underline', 
							 'name' => 'menu__selected__underline',
							 'type' => 'boolean',
							 'help' => __('Make the menu underlined','cgm'));	

	$options_panel[] = array('title'=> 'Bold', 
							 'name' => 'menu__selected__bold',
							 'type' => 'boolean',
							 'help' => __('Make the menu bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Italic', 
							 'name' => 'menu__selected__italic',
							 'type' => 'boolean',
							 'help' => __('Make the menu italic','cgm'));		 
							 
	$options_panel[] = array('title'=> 'Text shadow color', 
							 'name' => 'menu__selected__textShadowColor',
							 'type' => 'color',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Text shadow opacity', 
							 'name' => 'menu__selected__textShadowOpacity',
							 'type' => 'number',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow x', 
							 'name' => 'menu__selected__textShadowX',
							 'type' => 'number',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Text shadow y', 
							 'name' => 'menu__selected__textShadowY',
							 'type' => 'number',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow blur', 
							 'name' => 'menu__selected__textShadowBlue',
							 'type' => 'number',
							 'help' => __('Set the blur radius of the shadows','cgm'));
							 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'menu__selected__backgroundColor',
							 'type' => 'color',
							 'default' => '#1b749d',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, e.g. red or #00cc00, or an object with the following properties.','cgm'));
	$options_panel[] = array('type' => 'groupEnd');
	$options_panel[] = array('type' => 'div_end'); 
	
	$options_panel[] = array('type' => 'themeselectorEnd',
							 'slidertype' => 'isotope',
							 'ID'=>'theme_settings');
		   
	  
	$complete_gallery_display['isotope'] = array('type'=>'isotope',
										 'title'=>'Isotope',
										 'packages' => 'isotope',
										 'option'=>$options_panel,
										 'class_css' => array('prettyPhoto'=>COMPLETE_GALLERY_URL.'css/prettyPhoto.css'),
										 
										 'class_js' => array('jquery'=>'','isotope_min'=>COMPLETE_GALLERY_URL.'js/isotope/jquery.isotope.min.js', 'cgm_isotope_gallery'=>COMPLETE_GALLERY_URL.'js/isotope_gallery.js',
										 'cgm_all_gallery'=>COMPLETE_GALLERY_URL.'js/all_gallery.js',
										 
										 'infinitescroll_min'=>COMPLETE_GALLERY_URL.'js/isotope/jquery.infinitescroll.min.js','prettyPhoto'=>COMPLETE_GALLERY_URL.'js/jquery.prettyPhoto.js','jquery-effects-core'=>''),
										 'class_php' => 'cgm_isotope_generator',						 
										 'call_php_func' => 'cgm_drawIsoTope_gallery',
										 'call_js_func' => 'cgm_drawIsoTope_gallery'
										 );
?>