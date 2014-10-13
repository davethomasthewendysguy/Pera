<?php
/**
  *	Plugin Name: Woo Widget Media Query
  *	Description: Toggle widget visibility per media query.
  *	Version: 0.0.1
  *	Author: Doms Mariano
  *	Credit: Forked from ZigPress's (ZigWidgetClass at http://www.zigpress.com/plugins/zigwidgetclass/)
  *	License: GPLv2
  */


if (!class_exists('Woo_Widget_Media_Query')) {
	class Woo_Widget_Media_Query {
		public function __construct() {
			add_filter('widget_form_callback', array($this, 'filter_widget_form_callback'), 11, 2);
			add_filter('widget_update_callback', array($this, 'filter_widget_update_callback'), 11, 2);
			add_filter('dynamic_sidebar_params', array($this, 'filter_dynamic_sidebar_params'), 11);
		}

		function filter_widget_form_callback($instance, $widget) {
			if (!isset($instance['min_width'])) 
				$instance['min_width'] = 0;
			
			if (!isset($instance['max_width'])) 
				$instance['max_width'] = 0;
			
			if (!isset($instance['in'])) 
				$instance['in'] = 0;
			
			if (!isset($instance['out'])) 
				$instance['out'] = 0;

			if (!isset($instance['classes'])) 
				$instance['classes'] = '';
		
		?>
			<div class="Woo_Widget_Classes" style="border: 1px solid #ccc; border-radius: 4px; background: #f9f9f9; background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y5ZjlmOSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmMmYzZjciIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+); background: -moz-linear-gradient(top,  #f9f9f9 0%, #f2f3f7 100%); /* FF3.6+ */ background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f9f9f9), color-stop(100%,#f2f3f7)); /* Chrome,Safari4+ */ background: -webkit-linear-gradient(top,  #f9f9f9 0%,#f2f3f7 100%); /* Chrome10+,Safari5.1+ */ background: -o-linear-gradient(top,  #f9f9f9 0%,#f2f3f7 100%); /* Opera 11.10+ */ background: -ms-linear-gradient(top,  #f9f9f9 0%,#f2f3f7 100%); /* IE10+ */ background: linear-gradient(to bottom,  #f9f9f9 0%,#f2f3f7 100%); /* W3C */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f9f9f9', endColorstr='#f2f3f7',GradientType=0 ); /* IE6-8 */ padding: 5px; margin-bottom: 5px;   ">
		
				<p><i><?php _e('Widget Classes', 'woothemes'); ?></i></p>

				<div>
					<p>
						<input class="widefat" type="text" name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][classes]' value="<?php echo $instance['classes']; ?>"/>
					</p>

					<p><i>For a little help on CSS classes, <a href="http://www.cssbasics.com/css-classes/" target="_blank">this tutorial will be very helpfull for beginners.</a></i></p>
				</div>

			</div><!-- /.Woo_Widget_Classes -->

			<div class="woo_widget_media_query" style="border: 1px solid #ccc; border-radius: 4px; background: #f9f9f9; background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y5ZjlmOSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmMmYzZjciIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+); background: -moz-linear-gradient(top,  #f9f9f9 0%, #f2f3f7 100%); /* FF3.6+ */ background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f9f9f9), color-stop(100%,#f2f3f7)); /* Chrome,Safari4+ */ background: -webkit-linear-gradient(top,  #f9f9f9 0%,#f2f3f7 100%); /* Chrome10+,Safari5.1+ */ background: -o-linear-gradient(top,  #f9f9f9 0%,#f2f3f7 100%); /* Opera 11.10+ */ background: -ms-linear-gradient(top,  #f9f9f9 0%,#f2f3f7 100%); /* IE10+ */ background: linear-gradient(to bottom,  #f9f9f9 0%,#f2f3f7 100%); /* W3C */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f9f9f9', endColorstr='#f2f3f7',GradientType=0 ); /* IE6-8 */ padding: 5px; margin-bottom: 5px;   ">
		
				<p><i><?php _e('Widget Visibility', 'woothemes'); ?></i></p>

				<div>
					<p>
						<select class="widefat" name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][in]' id='widget-<?php echo $widget->id_base?>-<?php echo $widget->number?>-show'>
							<option value="0" <?php selected('0', $instance['in']); ?>><?php _e('Do nothing ', 'woothemes'); ?></option>
							<option value="1" <?php selected('1', $instance['in']); ?>><?php _e('Hide widget ', 'woothemes'); ?></option>
							<option value="2" <?php selected('2', $instance['in']); ?>><?php _e('Show widget ', 'woothemes'); ?></option>
						</select>
					</p>

					<p><?php _e('when browser width is at least ', 'woothemes'); ?></p>

					<p>
						<input type="text" name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][min_width]' value="<?php echo $instance['min_width']; ?>"/> px
					</p>

					<p><?php _e('and at most ', 'woothemes'); ?></p>

					<p>
						<input type="text" class="stepper" name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][max_width]' value="<?php echo $instance['max_width']; ?>"/> px.
					</p>

					<p><?php _e('And then, outside this range I want to: ', 'woothmes'); ?></p>

					<p>
						<select class="widefat" name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][out]' id='widget-<?php echo $widget->id_base?>-<?php echo $widget->number?>-out'>
							<option value="0" <?php selected('0', $instance['out']); ?>><?php _e('do nothing.', 'woothemes'); ?></option>
							<option value="1" <?php selected('1', $instance['out']); ?>><?php _e('hide widget.', 'woothemes'); ?></option>
							<option value="2" <?php selected('2', $instance['out']); ?>><?php _e('show widget.', 'woothemes'); ?></option>
						</select>
					</p>
				</div>

			</div><!-- /.woo_widget_media_query -->

			<?php
			return $instance;
		}


		function filter_widget_update_callback($instance, $new_instance) {
			$instance['min_width'] = $new_instance['min_width'];
			$instance['max_width'] = $new_instance['max_width'];
			$instance['in'] = $new_instance['in'];
			$instance['out'] = $new_instance['out'];
			$instance['classes'] = $new_instance['classes'];
			return $instance;
		}


		function filter_dynamic_sidebar_params($params) {
			global $wp_registered_widgets;
			
			/* Assume there are errors. Change this value depending on the parameters supplied. */
			$has_error 				= true;
			
			/* Get the widget intance's string ID. */	
			$widget_id 				= $params[0]['widget_id'];
						
			/* Get the current widget array. */
			$widget 				= $wp_registered_widgets[$widget_id];

			/* Get the widget intance's numeric ID.*/
			$option_number 			= $widget['params'][0]['number'];

			/* Retrieve the option_name from the widget array. */
			if ( ! ( $widget_option = $widget['callback'][0]->option_name ) ) {
				$widget_option 		= $widget['callback_wl_redirect'][0]->option_name;
			} 
			
			/* Get widget based on name. */
			$option_name 			= get_option( $widget_option );

			/* Shortcut. Define varibles that will contain parameters from the widget. */
			$settings 				= array('in','out','max_width','min_width', 'classes');
			
			/* Apply default values by setting everything to 0. */
			$defaults				= array_fill_keys( $settings, 0 );

			/* Retrieve raw value of widget parameters.*/
			$defaults['in'] 		= $option_name[$option_number]['in'];
			$defaults['out'] 		= $option_name[$option_number]['out'];
			$defaults['max_width']	= $option_name[$option_number]['max_width'];
			$defaults['min_width'] 	= $option_name[$option_number]['min_width'];
			$defaults['classes'] 		= $option_name[$option_number]['classes'];
				
			/* If for some reason no raw value is retrieved, give it 0.*/	
			if ( '' == $defaults['in'] )
				$defaults['in'] = 0; 

			/* If for some reason no raw value is retrieved or value given is not a number, give it 0. */
			if ( '0' == $defaults['max_width'] || !is_numeric($defaults['max_width']))
				$defaults['max_width'] = 0;
			else 
				$defaults['max_width'] = absint($defaults['max_width']); // Convert to integer.	
				
			/* If for some reason no raw value is retrieved or value given is not a number, give it 0. */
			if ( '' == $defaults['min_width'] || !is_numeric($defaults['min_width'])) 
				$defaults['min_width'] = 0;
			else 
				$defaults['min_width'] = absint($defaults['min_width']); // Convert to integer.
				
			/* If for some reason no raw value is retrieved, give it 0.*/		
			if ( '' == $defaults['out'] )
				$defaults['out'] = 0;

			if ( '' == $defaults['classes'] )
				$defaults['classes'] = ''; 

			/* Extract array to PHP variables.*/
			extract( $defaults, EXTR_SKIP );
			
			/* If the user supplied a min-width that is greater that or equal to the max-width, consider it an error. */			
			if ($min_width >= $max_width)
				$has_error = true;
			else 
				$has_error = false;

			/* If the max-width parameter 0, consider it an error. */
			if ($max_width == 0 )
				$has_error = true;

			/* If there are no errors, proceed. */
			$classes = array_unique( explode(' ', strip_tags( $classes ) ) );
			array_push( $classes , $widget['classname'] );
			$classes = trim( implode( " ", array_unique( $classes ) ) );

			$params[0]['before_widget'] = str_replace( $widget['classname'] ,  $classes, $params[0]['before_widget'] );
			
			/* If there are no errors, proceed. */
			if ( ! $has_error) {

				/* If the user and opted to do nothing, then do not procdeed. */
				if ( ! ( $in == 0 && $out == 0 ) ) {

					$params[0]['after_widget'] .= '<style type="text/css">';
						
						/* If the user opted to nothing within the range specified, then do not proceed. */
						if ($in != 0) {

							/* Print the media query stylesheet that shows or hides the widget within [min_width, max_width] */
							$params[0]['after_widget'] .= '@media only screen and (min-width: ' . $min_width . 'px) and (max-width: ' . $max_width . 'px) {';
								$params[0]['after_widget'] .= '#' . (string) $params[0]['widget_id'];
									$params[0]['after_widget'] .= '{';
									$params[0]['after_widget'] .= 'display: ';

										if (absint($in) == 1) {
											$params[0]['after_widget'] .= 'none; ';
										}

										if (absint($in) == 2)
											$params[0]['after_widget'] .= 'block; ';

									$params[0]['after_widget'] .= '}';
							$params[0]['after_widget'] .= '}';
						}

						/* If the user opted to nothing outside the specified the range specified, then do not proceed. */
						if ($out != 0) {
						
							/* Print the media query stylesheet that shows or hides the widget within [0, min_width) */
							$params[0]['after_widget'] .= '@media only screen and (min-width: ' . 0 . 'px) and (max-width: ' . ($min_width - 1) . 'px) {';
								$params[0]['after_widget'] .= '#' . (string) $params[0]['widget_id'];
									$params[0]['after_widget'] .= '{';
									$params[0]['after_widget'] .= 'display: ';

										if ($out == 1)
											$params[0]['after_widget'] .= 'none; ';

										if ($out == 2)
											$params[0]['after_widget'] .= 'block; ';

									$params[0]['after_widget'] .= '}';
							$params[0]['after_widget'] .= '}';

							/* Print the media query stylesheet that shows or hides the widget within (max-width, positive infinity) */
							$params[0]['after_widget'] .= '@media only screen and (min-width: ' . ($max_width + 1) . 'px) {';
								$params[0]['after_widget'] .= '#' . (string) $params[0]['widget_id'];
									$params[0]['after_widget'] .= '{';
									$params[0]['after_widget'] .= 'display: ';

										if ($out == 1)
											$params[0]['after_widget'] .= 'none; ';

										if ($out == 2)
											$params[0]['after_widget'] .= 'block; ';

									$params[0]['after_widget'] .= '}';
							$params[0]['after_widget'] .= '}';
						}

					$params[0]['after_widget'] .= '</style>';
				}
			}	

			return $params;
		}
	}
}

$Woo_Widget_Media_Query = new Woo_Widget_Media_Query();