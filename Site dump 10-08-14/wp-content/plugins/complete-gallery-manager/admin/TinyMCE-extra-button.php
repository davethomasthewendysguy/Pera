<?php
class cgm_tinymce_extra_button {
	var $post;
	
	function cgm_tinymce_extra_button ($args=array()){
		add_action("admin_head-post.php",array(&$this,'insert_tool_head'));
		add_action("admin_head-post-new.php",array(&$this,'insert_tool_head'));		
		add_action("admin_head-index.php",array(&$this,'insert_tool_head'));			
		add_action('media_buttons_context',array(&$this,'media_buttons_context'));
		//add_action('wp_ajax_mce_list_fields', array(&$this,'mce_list_fields'));
	}
	
	function insert_tool_head(){
    	// add creation of statistics
		wp_register_style( 'cgm-insert-tool', COMPLETE_GALLERY_URL.'css/insert_tool.css', array(),'1.0.0');
		wp_print_styles('cgm-insert-tool');
		wp_register_script( 'cgm-insert-tool', COMPLETE_GALLERY_URL.'js/insert_tool.js', array(),'1.0.0');
		wp_print_scripts('cgm-insert-tool');
 		echo '<script>
 				var COMPLETE_GALLERY_URL = "'.COMPLETE_GALLERY_URL.'";
 				
 		</script> '; 		
		
		
		
		
		add_action('admin_footer',array(&$this,'shortcode_dialog'),1);
	}
	
	function shortcode_dialog(){
		$args = array( 'post_type' => 'cgm-complete_gallery', 'numberposts' => -1); 
		$cgm_gallery = get_posts( $args );
?>
<div id="cgm-insert-tool" class="cgm-dialog-cont">
	<div class="cgm-dialog-overlay"></div>
	<div class="cgm-dialog">
		<div class="cgm-dialog-head">
			<div class="cgm-dialog-head-text"><?php _e("Add Complete Gallery", 'cgm')?></div>
			<div class="cgm-close-icon">
				<a class="cgm-close-icon-a" title="Close" href="javascript:void(0);" alt="Close"><img src="<?php echo COMPLETE_GALLERY_URL?>images/tb-close.png" /></a>			
			</div>
		</div>	
		<div class="cgm-dialog-body" style="width:400px;">
        	<div id="insert_cgm">
				<label class="cgm-mce-label"><?php _e("Complete Gallery", 'cgm')?></label>
				<div class="cgm-mce-input">
					<select style="width:350px" id="cgm_chart_selected">
						<option value=""><?php _e("-- Select Gallery --", 'cgm')?></option>
						<?php 
						if ($cgm_gallery) {
							foreach ( $cgm_gallery as $post ) {
								if(empty($post->post_title))
									$post->post_title = __("(no title)", 'cgm');	
								 		
								echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';
							}
						}
						?>
					</select>
				</div> 
			</div>
			<div id="data_loaded_cgm" style="display:none">
				<label class="cgm-mce-label"><?php _e("CSS Class", 'cgm')?></label>
				<div class="cgm-mce-input"><input style="width:350px;" type="text" id="cgm_class"></div>
				<label class="cgm-mce-label"><?php _e("Style", 'cgm')?></label>
				<div class="cgm-mce-input"><input style="width:350px;" type="text" id="cgm_style"></div>

				<label class="cgm-mce-label"><?php _e("CSS properties", 'cgm')?></label>
				<div class="cgm-mce-input" style="margin-top: 3px;">
					<label for="border">Border</label>
					<input type="text" onKeyUp="cgm_input_change_value()" value="" style="width: 30px; margin-right: 10px;" name="cgm_border" id="cgm_border" maxlength="5">

					<label for="vspace">Vertical space</label>
					<input type="text" onKeyUp="cgm_input_change_value()" value="" style="width: 30px; margin-right: 10px;" name="cgm_vspace" id="cgm_vspace" maxlength="5">

					<label for="hspace">Horizontal space</label>
					<input type="text" onKeyUp="cgm_input_change_value()" value="" style="width: 30px; margin-right: 10px;" name="cgm_hspace" id="cgm_hspace" maxlength="5">
				</div>
				
				<label class="cgm-mce-label"><?php _e("Alignment", 'cgm')?></label>
				<div class="cgm-mce-input" style="margin-top: 3px;" id="cgm_radio_list">
						<input type="radio" value="alignnone" checked="checked"id="cgm_alignnone" name="cgm_align">
						<label class="cgm-image-align-label cgm-image-align-none-label" for="alignnone">None</label>
						<input type="radio" value="alignleft" id="cgm_alignleft" name="cgm_align">
						<label class="cgm-image-align-label cgm-image-align-left-label" for="alignleft">Left</label>
						<input type="radio" value="aligncenter" id="cgm_aligncenter" name="cgm_align">
						<label class="cgm-image-align-label cgm-image-align-center-label" for="aligncenter">Center</label>
						<input type="radio" value="alignright" id="cgm_alignright" name="cgm_align">
						<label class="cgm-image-align-label cgm-image-align-right-label" for="alignright">Right</label>
				</div>

				
				
				<div id="cgm_shortcode" class="cgm-mce-input" style="display:none;"></div>
				<label class="cgm-mce-label"><?php _e("Overwrite start pos", 'cgm')?></label>
				<div class="cgm-mce-input">
					<select style="width:85px" id="cgm_layout">
						<option value=""><?php _e("--Layout--", 'cgm')?></option>
						<?php 
						
						$tplayout = array('masonry' => 'Masonry',
										  'fitRows' => 'Fit Rows',
										  'cellsByRow' => 'Cells By Row',
										  'straightDown' => 'Straight Down',
										  'masonryHorizontal' => 'Masonry Horizontal',
										  'fitColumns' => 'Fit Columns',
										  'cellsByColumn' => 'Cells By Column',
										  'straightAcross' => 'Straight Across');

						
						if (!empty($tplayout)) {
							foreach ( $tplayout as $tp_key => $tp_data  ) {

								echo '<option value="'.$tp_key.'">'.$tp_data.'</option>';
							}
						}
						?>
					</select>

					<select style="width:85px" id="cgm_sort">
						<option value=""><?php _e("---Sort---", 'cgm')?></option>
						<?php 
						
						$tpsort = array('index' => 'Index',
										  'title' => 'Title',
										  'date' => 'Date',
										  'desc' => 'Description',
										  'link' => 'Link',
										  'imageSize' => 'Image size',
										  'random' => 'Random');

						
						if (!empty($tpsort)) {
							foreach ( $tpsort as $tp_key => $tp_data  ) {

								echo '<option value="'.$tp_key.'">'.$tp_data.'</option>';
							}
						}
						?>
					</select>
					
					<select style="width:85px" id="cgm_sortDir">
						<option value=""><?php _e("-Sort Dir-", 'cgm')?></option>
						<?php 
						
						$tpsortDir = array('asc' => 'Asc',
										  'desc' => 'Desc');

						
						if (!empty($tpsortDir)) {
							foreach ( $tpsortDir as $tp_key => $tp_data  ) {

								echo '<option value="'.$tp_key.'">'.$tp_data.'</option>';
							}
						}
						?>
					</select>
					
					<select style="width:85px" id="cgm_carID">
						<option value=""><?php _e("--Cat ID--", 'cgm')?></option>

					</select>
					
					
				</div>






				<div class="cgm-mce-buttons">
						<input type="button" OnClick="javascript:insert_cgm_shortcode();" class="button-primary" value="<?php _e("Insert Chart", 'cgm')?>" />
				</div>
				
			</div>     
		</div>
		
		<div class="cgm-dialog-body">
        	<div id="preview_cgm">
        		<label class="cgm-mce-label"><?php _e("Preview", 'cgm')?></label>
				<div id="preview_gallery_cgm" class="cgm-mce-input"></div>
        	</div>
        </div>
	</div>
</div>
<?php	
	}
	
	function media_buttons_context($context){
	
		$screen = get_current_screen();
	
		if(true){ 
		 $out = '<a class="button" id="cgm-insert-tool-trigger" href="javascript:void(0);" title="'. __("Add CGM", 'cgm').'">CGM</a>';
		} else {
		
		 $out = '<a class="button" id="cgm-insert-tool-trigger" href="javascript:void(0);" title="'. __("Add CGM", 'cgm').'">CGM</a>';
		
        	/*$out = '<a id="cgm-insert-tool-trigger" href="javascript:void(0);" title="'. __("Add Complete Gallery", 'cgm').'"><img src="'.COMPLETE_GALLERY_URL."/images/cgm.png".'" alt="'. __("Add Complete Gallery", 'cgm') . '" /></a>';*/
		}

        return $context . $out;
	}
}
?>