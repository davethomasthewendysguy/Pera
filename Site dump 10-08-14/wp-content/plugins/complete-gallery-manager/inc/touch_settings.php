<?php 
 	global $complete_gallery_display,$_wp_additional_image_sizes;
	$options_panel = '';
	$options_panel[] = array('type' => 'div_start');	
	
	
	$options_panel[] = array('title'=>'Template Settings',
							 'type' => 'themeselectorStart',
							 'slidertype' => 'touch',
							 'help_main' => __('Select main template','cgm'),
							 'help_save' => __('Save your template','cgm'),
							 'help_delete' => __('Remove templates','cgm'),
							 'ID'=>'theme_settings');
	
	$options_panel[] = array('title'=> 'General Settings',
							 'type' => 'title',
							 'ID'=>'general_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'general_settings');
	
	
	$selectsizes['thumbnail'] = 'Thumbnail';
	$selectsizes['medium'] = 'Medium';
	$selectsizes['large'] = 'Large';
	$selectsizes['fullwidth'] = 'Auto Width';
	$selectsizes['custom'] = 'Custom';


	$options_panel[] = array('title'=> 'Select slider size',
								'name' => 'slidersize',
								'type' => 'dropdown', 
								'list'=> $selectsizes,
								'default' => 'large',
								'extra' => array('id'=>'cgm_slidersize','onChange'=>'cgm_fn_touch_autocorrect(this,\'#cgm_ts_width\',\'#cgm_ts_height\');cgm_preview();'),
								'help' => __('Choose a slider size','cgm'));
	
	$options_panel[] = array('title'=> 'Width', 
							 'name' => 'ts_width',
							 'type' => 'number',
							 'default' => 600,
							 'extra' => array('id'=>'cgm_ts_width'),
							 'help' => __('Width of the gallery in pixels. If left empty it will be 100%','cgm'));

	
	$options_panel[] = array('title'=> 'Height', 
							 'name' => 'ts_height',
							 'type' => 'number',
							 'default' => 300,
							 'extra' => array('id'=>'cgm_ts_height'),
							 'help' => __('Height of the gallery in pixels. If left empty it will be 100%','cgm'));
							 
							 
	$options_panel[] = array('title'=> 'Show fullscreen Button', 
							 'name' => 'fullscreenbutton_show',
							 'type' => 'dropdown',
							 'default' => '0',
							 'list' =>  array(  '0'=>'Off',
											    '1'=>'Full Browser',
											    '2'=>'Full Screen'),
							'help' => __('Set fullscreen button','cgm'));			 
							 
							 
	$options_panel[] = array('title'=> 'Full screen Button Pos',
							 'name' => 'fullscreenbutton',
							 'type' => 'dropdown', 
							 'default' => 'topright',
							 'list' =>  array(	'topleft'=>'Top Left',
												'topright'=>'Top Right',
												'bottomleft'=>'Bottom Left',
												'bottomright'=>'Bottom Right'),
							 'help' => __('Choose positon for the indicator','cgm'));	
							 
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
							 
							 

	$mouseEventClick2[1] = 'Off';
	$mouseEventClick2['click'] = 'Goto link';
	$mouseEventClick2['clickNew'] = 'Goto link new page';
	$mouseEventClick2['prettyPhoto'] = 'Pretty Photo';

	$options_panel[] = array('title'=> 'Mouse Click',
								'name' => 'mouseEventClick',
								'type' => 'dropdown', 
								'list'=> $mouseEventClick2,
								'default' => 'prettyPhoto',
								'help' => __('Choose action by click','cgm'));

	$options_panel[] = array('type' => 'groupEnd');


	// --------------------- Slider settings
	
	$options_panel[] = array('title'=> 'Slider Settings',
							 'type' => 'title',
							 'ID'=>'slider_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'slider_settings');
	
	$selectdirection['horizontal'] = 'Horizontal mode';
	$selectdirection['vertical'] = 'Vertical mode';


	$options_panel[] = array('title'=> 'Slider dirrection',
								'name' => 'sliderdirection',
								'type' => 'dropdown', 
								'list'=> $selectdirection,
								'default' => 'large',
								'help' => __('Choose a slider size','cgm'));
	
	
	$selectType[''] = 'Normal mode';
	$selectType['freemode'] = 'Free mode';
	$selectType['freemodefloat'] = 'Free mode float';

	$options_panel[] = array('title'=> 'Slider type',
								'name' => 'slidertype',
								'type' => 'dropdown', 
								'list'=> $selectType,
								'help' => __('Choose a slider type','cgm'));
	
	
	$options_panel[] = array('title'=> 'Auto Play', 
						 'name' => 'sliderAutoPlay',
						 'type' => 'boolean',
						 'default' => 'false',
						 'help' => __('Auto play','cgm'));
	
	$options_panel[] = array('title'=> 'Auto Play Time', 
						 'name' => 'sliderAutoPlayTime',
						 'type' => 'number',
						 'default' => 5000,
						 'help' => __('Auto play time','cgm'));
	
	$options_panel[] = array('title'=> 'Loop slider', 
							 'name' => 'sliderloop',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show images in loop','cgm'));

	$selectSliderNumbers[1] = '1';
	$selectSliderNumbers[2] = '2';
	$selectSliderNumbers[3] = '3';
	$selectSliderNumbers[4] = '4';
	$selectSliderNumbers[5] = '5';
	$selectSliderNumbers[6] = '6';
	
	$options_panel[] = array('title'=> 'Image Pr Slider',
								'name' => 'imageprslide',
								'type' => 'dropdown', 
								'list'=> $selectSliderNumbers,
								'default' => 1,
								'help' => __('Choose a number of image pr slider','cgm'));



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
							 'help' => __('Show Opacity filter','cgm'));  
							  		 
	$options_panel[] = array('title'=> 'Video icon', 
							 'name' => 'overlayicon__video',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show overlay icon','cgm'));						 
							 
	$options_panel[] = array('title'=> 'Gallary icon', 
							 'name' => 'overlayicon__gallary',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show overlay icon','cgm'));	
	
	$options_panel[] = array('title'=> 'Link icon', 
							 'name' => 'overlayicon__link',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon','cgm'));						 
							 
	$options_panel[] = array('title'=> 'Pretty photo icon', 
							 'name' => 'overlayicon__prettyphoto',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon','cgm'));	
							 
	$options_panel[] = array('title'=> 'Post icon', 
							 'name' => 'overlayicon__post',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon','cgm'));				 
							 
	$options_panel[] = array('title'=> 'Page icon', 
							 'name' => 'overlayicon__page',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show overlay icon','cgm'));							 
							 
							 
	$options_panel[] = array('type' => 'groupEnd');
	
	
	
	$options_panel[] = array('title'=> 'Arrow Normal Settings',
							 'type' => 'title',
							 'ID'=>'arrownormal_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'arrownormal_settings');

	$options_panel[] = array('title'=> 'Show arrows', 
						 'name' => 'arrowShow',
						 'type' => 'boolean',
						 'default' => 'true',
						 'help' => __('ShowArrows','cgm'));


	$options_panel[] = array('title'=> 'Size', 
							 'name' => 'arrownormal__width',
							 'type' => 'number',
							 'default' => '40',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Opacity', 
							 'name' => 'arrownormal__opacity',
							 'type' => 'number',
							 'default' => '0.3',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'arrownormal__borderColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'arrownormal__borderWidth',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));					 
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'arrownormal__borderRadius',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Radius of the border','cgm'));

							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'arrownormal__borderStyle',
							 'type' => 'dropdown', 
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));


							 
	$options_panel[] = array('title'=> 'Box shadow color', 
							 'name' => 'arrownormal__boxShadowColor',
							 'type' => 'color',
							 'default' => '#555555',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Box shadow opacity', 
							 'name' => 'arrownormal__boxShadowOpacity',
							 'type' => 'number',
							 'default' => '0.5',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('type' => 'groupEnd');
	
	
	$options_panel[] = array('title'=> 'Arrow Hover Settings',
							 'type' => 'title',
							 'ID'=>'arrowhover_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'arrowhover_settings');

	$options_panel[] = array('title'=> 'Opacity', 
							 'name' => 'arrowhover__opacity',
							 'type' => 'number',
							 'default' => '0.8',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'arrowhover__borderColor',
							 'type' => 'color',
							 'default' => '#aaaaaa',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'arrowhover__borderWidth',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));					 
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'arrowhover__borderRadius',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Radius of the border','cgm'));

							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'arrowhover__borderStyle',
							 'type' => 'dropdown', 
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));


							 
	$options_panel[] = array('title'=> 'Box shadow color', 
							 'name' => 'arrowhover__boxShadowColor',
							 'type' => 'color',
							 'default' => '#555555',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Box shadow opacity', 
							 'name' => 'arrowhover__boxShadowOpacity',
							 'type' => 'number',
							 'default' => '0.5',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('type' => 'groupEnd');
	
	
	
// ------------------ New line
	
	
	
	
	
	
	$options_panel[] = array('title'=> 'PreLoader Settings',
							 'type' => 'title',
							 'ID'=>'preloader_settings');
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'preloader_settings');

	$options_panel[] = array('title'=> 'Show Preloader Menu', 
							 'name' => 'preloader__show',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show loader screen','cgm'));	
							 
	$options_panel[] = array('title'=> 'Preloader text', 
							 'name' => 'preloader__loadingText',
							 'type' => 'string',
							 'default' => 'Loading',
							 'help' => __('Set the text for Pre-loaderen','cgm')); 
							 
	$options_panel[] = array('title'=> 'Preloader width', 
							 'name' => 'preloader__prewidth',
							 'type' => 'number',
							 'default' => '200',
							 'help' => __('if set to zero will it be set as 100%','cgm')); 
							 
	$options_panel[] = array('title'=> 'Preloader aligment',
							 'name' => 'preloader__posalign',
							 'type' => 'dropdown',
							 'default' => 'center',
							 'list' =>  array('left'=>'Left','center'=>'Center','right'=>'Right'),
							 'help' => __('align box','cgm')); 
							 

	$options_panel[] = array('title'=> 'Text aligment',
							 'name' => 'preloader__textalign',
							 'type' => 'dropdown',
							 'default' => 'center',
							 'list' =>  array('left'=>'Left','center'=>'Center','right'=>'Right'),
							 'help' => __('text align','cgm')); 

	$options_panel[] = array('title'=> 'Text size', 
							 'name' => 'preloader__fontSize',
							 'type' => 'number',
							 'default' => '15',
							 'help' => __('Set the Font size','cgm')); 
							 
	$options_panel[] = array('title'=> 'Text Color', 
							 'name' => 'preloader__textColor',
							 'type' => 'color',
							 'default' => '#333333',
							 'help' => __('Set the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Font family', 
							 'name' => 'preloader__family',
							 'type' => 'string',
							 'default' => 'Helvetica',
							 'help' => __('Set the Font family','cgm')); 

	$options_panel[] = array('title'=> 'Underline', 
							 'name' => 'preloader__underline',
							 'type' => 'boolean',
							 'help' => __('Show underline','cgm'));	

	$options_panel[] = array('title'=> 'Bold', 
							 'name' => 'preloader__bold',
							 'type' => 'boolean',
							 'help' => __('Show bold','cgm'));	
							 
	$options_panel[] = array('title'=> 'Italic', 
							 'name' => 'preloader__italic',
							 'type' => 'boolean',
							 'help' => __('Show italic','cgm'));		 
							 
	$options_panel[] = array('title'=> 'Text shadow color', 
							 'name' => 'preloader__textShadowColor',
							 'type' => 'color',
							 'help' => __('Set the color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Text shadow opacity', 
							 'name' => 'preloader__textShadowOpacity',
							 'type' => 'number',
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow x', 
							 'name' => 'preloader__textShadowX',
							 'type' => 'number',
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Text shadow y', 
							 'name' => 'preloader__textShadowY',
							 'type' => 'number',
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Text shadow blur', 
							 'name' => 'preloader__textShadowBlue',
							 'type' => 'number',
							 'help' => __('Set the blur radius of the shadows','cgm'));	 
							 
							 
	$options_panel[] = array('title'=> 'Padding', 
							 'name' => 'preloader__padding',
							 'type' => 'string',
							 'default'=> '5px 5px 5px 5px',
							 'help' => __('You can set padding like normal css, e.g <br><br><b>padding:10px 5px 15px 20px</b><br>top padding is 10px<br>right padding is 5px<br>bottom padding is 15px<br>left padding is 20px<br><br><b>padding:10px 5px 15px</b><br>top padding is 10px<br>right and left padding are 5px<br>bottom padding is 15px<br><br><b>padding:10px 5px</b><br>top and bottom padding are 10px<br>right and left padding are 5px<br><br><b>padding:10px</b><br>all four paddings are 10px','cgm'));
							 
	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'preloader__backgroundColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'preloader__borderColor',
							 'type' => 'color',
							 'default' => '#dcdcdc',
							 'help' => __('Set the color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'preloader__borderWidth',
							 'type' => 'number',
							 'help' => __('Set the Width of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'preloader__borderRadius',
							 'type' => 'number',
							 'default' => '0',
							 'help' => __('Set the Radius of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'preloader__borderStyle',
							 'type' => 'dropdown',
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm')); 
							 
	$options_panel[] = array('type' => 'groupEnd');
	
	
	
	
	
	
	
	
	
	$options_panel[] = array('type' => 'div_break',
							 'extra_td'=>array('width'=>'50%'));					 	
			

$options_panel[] = array('title'=> 'Page indicator Settings',
							 'type' => 'title',
							 'ID'=>'pagein_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'pagein_settings');
	
	$options_panel[] = array('title'=> 'Show page indicator', 
							 'name' => 'pageinShow',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show pageindicator in loop','cgm'));
							 
	$options_panel[] = array('title'=> 'Show inside', 
							 'name' => 'pageinShowInside',
							 'type' => 'boolean',
							 'default' => 'true',
							 'help' => __('Show pageindicator inside only in horizontal mode','cgm'));

	$options_panel[] = array('title'=> 'Position',
							 'name' => 'pageinPosition',
							 'type' => 'dropdown', 
							 'default' => 'bottomcenter',
							 'list' =>  array(  'topleft'=>'Top Left',
											    'topcenter'=>'Top Center',
												'topright'=>'Top Right',
												'bottomleft'=>'Bottom Left',
												'bottomcenter'=>'Bottom Center',
												'bottomright'=>'Bottom Right'),
							 'help' => __('Choose positon for the indicator','cgm'));	


	$options_panel[] = array('title'=> 'Margin between', 
							 'name' => 'pageinMarginBetween',
							 'type' => 'number',
							 'default' => '3',
							 'help' => __('Slideshow time milliseconds. Default value is 5000','cgm'));


	$options_panel[] = array('type' => 'groupEnd');


	$options_panel[] = array('title'=> 'Page indicator Normal Settings',
							 'type' => 'title',
							 'ID'=>'pageinnormal_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'pageinnormal_settings');


	$options_panel[] = array('title'=> 'Opacity', 
							 'name' => 'pageinNormal__opacity',
							 'type' => 'number',
							 'default' => '0.5',
							 'help' => __('Set the Width of the border','cgm'));	

	$options_panel[] = array('title'=> 'Width', 
							 'name' => 'pageinNormal__width',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Height', 
							 'name' => 'pageinNormal__height',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'pageinNormal__backgroundColor',
							 'type' => 'color',
							 'default' => '#a8f3aa',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));

	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'pageinNormal__borderColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'pageinNormal__borderWidth',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the Width of the border','cgm'));					 
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'pageinNormal__borderRadius',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Radius of the border','cgm'));

							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'pageinNormal__borderStyle',
							 'type' => 'dropdown', 
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));


							 
	$options_panel[] = array('title'=> 'Box shadow color', 
							 'name' => 'pageinNormal__boxShadowColor',
							 'type' => 'color',
							 'default' => '#555555',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Box shadow opacity', 
							 'name' => 'pageinNormal__boxShadowOpacity',
							 'type' => 'number',
							 'default' => 1.0,
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Box shadow x', 
							 'name' => 'pageinNormal__boxShadowX',
							 'type' => 'number',
							 'default' => 0,
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Box shadow y', 
							 'name' => 'pageinNormal__boxShadowY',
							 'type' => 'number',
							 'default' => 1,
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Box shadow blur', 
							 'name' => 'pageinNormal__boxShadowBlue',
							 'type' => 'number',
							 'default' => 2,
							 'help' => __('Set the blur radius of the shadows','cgm'));

	$options_panel[] = array('type' => 'groupEnd');



	$options_panel[] = array('title'=> 'Page indicator Hover Settings',
							 'type' => 'title',
							 'ID'=>'pageinhover_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'pageinhover_settings');

	$options_panel[] = array('title'=> 'Width', 
							 'name' => 'pageinHover__width',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Height', 
							 'name' => 'pageinHover__height',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));


	$options_panel[] = array('title'=> 'Opacity', 
							 'name' => 'pageinHover__opacity',
							 'type' => 'number',
							 'default' => '1.0',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'pageinHover__backgroundColor',
							 'type' => 'color',
							 'default' => '#a8f3aa',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));

	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'pageinHover__borderColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'pageinHover__borderWidth',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the Width of the border','cgm'));					 
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'pageinHover__borderRadius',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Radius of the border','cgm'));

							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'pageinHover__borderStyle',
							 'type' => 'dropdown', 
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));


							 
	$options_panel[] = array('title'=> 'Box shadow color', 
							 'name' => 'pageinHover__boxShadowColor',
							 'type' => 'color',
							 'default' => '#555555',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Box shadow opacity', 
							 'name' => 'pageinHover__boxShadowOpacity',
							 'type' => 'number',
							 'default' => 1.0,
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Box shadow x', 
							 'name' => 'pageinHover__boxShadowX',
							 'type' => 'number',
							 'default' => 0,
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Box shadow y', 
							 'name' => 'pageinHover__boxShadowY',
							 'type' => 'number',
							 'default' => 1,
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Box shadow blur', 
							 'name' => 'pageinHover__boxShadowBlue',
							 'type' => 'number',
							 'default' => 2,
							 'help' => __('Set the blur radius of the shadows','cgm'));

	$options_panel[] = array('type' => 'groupEnd');


	$options_panel[] = array('title'=> 'Page indicator Active Settings',
							 'type' => 'title',
							 'ID'=>'pageinactive_settings');	 
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'pageinactive_settings');

	$options_panel[] = array('title'=> 'Width', 
							 'name' => 'pageinActiv__width',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Height', 
							 'name' => 'pageinActiv__height',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Width of the border','cgm'));


	$options_panel[] = array('title'=> 'Opacity', 
							 'name' => 'pageinActiv__opacity',
							 'type' => 'number',
							 'default' => '1.0',
							 'help' => __('Set the Width of the border','cgm'));

	$options_panel[] = array('title'=> 'Background Color', 
							 'name' => 'pageinActiv__backgroundColor',
							 'type' => 'color',
							 'default' => '#2f9933',
							 'help' => __('The background color for the main area of the chart. Can be either a simple HTML color string, for example: red or #00cc00, or an object with the following properties.','cgm'));

	$options_panel[] = array('title'=> 'Border Color', 
							 'name' => 'pageinActiv__borderColor',
							 'type' => 'color',
							 'default' => '#ffffff',
							 'help' => __('Set the Color of the border','cgm'));
							 
	$options_panel[] = array('title'=> 'Border Width', 
							 'name' => 'pageinActiv__borderWidth',
							 'type' => 'number',
							 'default' => '1',
							 'help' => __('Set the Width of the border','cgm'));					 
							 
	$options_panel[] = array('title'=> 'Border Radius', 
							 'name' => 'pageinActiv__borderRadius',
							 'type' => 'number',
							 'default' => '10',
							 'help' => __('Set the Radius of the border','cgm'));

							 
	$options_panel[] = array('title'=> 'Border Style',
							 'name' => 'pageinActiv__borderStyle',
							 'type' => 'dropdown', 
							 'default' => 'solid',
							 'list' =>  array('none'=>'None','dotted'=>'Dotted','dashed'=>'Dashed','solid'=>'Solid','double'=>'Double','groove'=>'Groove','ridge'=>'Ridge','inset'=>'Inset','outset'=>'Outset'),
							 'help' => __('Set the style of border:<br><br><b>dotted</b> - Defines a dotted border.<br><b>dashed</b> - Defines a dashed border.<br><b>solid</b> - Defines a solid border.<br><b>double</b> - Defines two borders. The width of the two borders are the same as the border-width value.<br><b>groove</b> - Defines a 3D grooved border. The effect depends on the border-color value.<br><b>ridge</b> - Defines a 3D ridged border. The effect depends on the border-color value.<br><b>inset</b> - Defines a 3D inset border. The effect depends on the border-color value.<br><b>outset</b> - Defines a 3D outset border. The effect depends on the border-color value.<br>','cgm'));


							 
	$options_panel[] = array('title'=> 'Box shadow color', 
							 'name' => 'pageinActiv__boxShadowColor',
							 'type' => 'color',
							 'default' => '#555555',
							 'help' => __('Set the Color of the shadow','cgm'));
		
	$options_panel[] = array('title'=> 'Box shadow opacity', 
							 'name' => 'pageinActiv__boxShadowOpacity',
							 'type' => 'number',
							 'default' => 1.0,
							 'help' => __('Set the Alpha (transparency)','cgm'));
							 
	$options_panel[] = array('title'=> 'Box shadow x', 
							 'name' => 'pageinActiv__boxShadowX',
							 'type' => 'number',
							 'default' => 0,
							 'help' => __('Set the x position of the shadow','cgm'));
					
	$options_panel[] = array('title'=> 'Box shadow y', 
							 'name' => 'pageinActiv__boxShadowY',
							 'type' => 'number',
							 'default' => 1,
							 'help' => __('Set the y position of the shadow','cgm'));
							 
	$options_panel[] = array('title'=> 'Box shadow blur', 
							 'name' => 'pageinActiv__boxShadowBlue',
							 'type' => 'number',
							 'default' => 2,
							 'help' => __('Set the blur radius of the shadows','cgm'));

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
							 'help' => __('Show Downl0ad button','cgm'));	



	$options_panel[] = array('title'=> 'Autoplay Slideshow', 
							 'name' => 'pretty__autoplayslideshow',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Autoplay Slideshow','cgm'));		
							 								 	
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
							 'help' => __('Choose animation speed for prettyPhoto','cgm'));	
	$options_panel[] = array('type' => 'groupEnd');
	
	
	
	// --------------- Captions Settings
	
	
	$options_panel[] = array('title'=> 'Captions Settings',
							 'type' => 'title',
							 'ID'=>'captions_settings');	
							 
							 	 	
	$options_panel[] = array('type' => 'groupStart',
							 'ID'=>'captions_settings');
	
	$options_panel[] = array('title'=> 'Show', 
							 'name' => 'captionsShow',
							 'type' => 'boolean',
							 'default' => 'false',
							 'help' => __('Show underline on the title','cgm'));
	
	
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
							 'default' => 'appear bottom',
							 'list' =>  array(  'appear left'=>'Appear Left',
												'appear right'=>'Appear Right',															 					'appear titlebottom'=>'Title always + Appear description',	
												'appear top'=>'Appear Top',
												'appear bottom'=>'Appear Bottom',
												'appear always left'=>'Appear Always Left',
												'appear always right'=>'Appear Always Right',
												'appear always top'=>'Appear Always Top',
												'appear always bottom'=>'Appear Always Bottom'
												),
							 'help' => __('Choose the caption template. Please notice that the Flip effect is only supported by Webkit browsers like Chrome and Safari.','cgm'));
	
	$options_panel[] = array('title'=> 'Hover area size %', 
							 'name' => 'captions__hoversize',
							 'type' => 'number',
							 'default' => '0',
							 'help' => __('This hover size is set in %, if set to zero will it try to find the best resio','cgm'));
	
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
			 
	$options_panel[] = array('type' => 'div_end'); 
	
	$options_panel[] = array('type' => 'themeselectorEnd',
							 'slidertype' => 'touch',
							 'ID'=>'theme_settings');
		   
	  
	$complete_gallery_display['touch'] = array('type'=>'touch',
										 'title'=>'Touch slider',
										 'packages' => 'touch',
										 'option'=>$options_panel,
										 'class_css' => array('prettyPhoto'=>COMPLETE_GALLERY_URL.'css/prettyPhoto.css'),
										 
										 'class_js' => array('jquery'=>'','idangerous_swiper'=>COMPLETE_GALLERY_URL.'js/idangerous/idangerous.swiper-1.5.min.js',
										 'cgm_all_gallery'=>COMPLETE_GALLERY_URL.'js/all_gallery.js', 'cgm_touch_gallery'=>COMPLETE_GALLERY_URL.'js/touch_gallery.js','prettyPhoto'=>COMPLETE_GALLERY_URL.'js/jquery.prettyPhoto.js'),
										 'class_php' => 'cgm_touch_generator',						 
										 'call_php_func' => 'cgm_drawTouch_gallery',
										 'call_js_func' => 'cgm_drawTouch_gallery'
										 );
?>