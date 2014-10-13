<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');


global $wpdb;

$return_one = false;
if(isset($_GET['return_one'])){
	$return_one = $_GET['return_one'];
	
}


$special_type = '';
if(isset($_GET['special_type'])){
	$special_type = $_GET['special_type'];
	
}

$special_id = '';
if(isset($_GET['special_id'])){
	$special_id = $_GET['special_id'];
	
}


?>
<script>

var $container = jQuery('#cgm_content_tools');	
var cgm_tooles_sort = 'post_date';
var cgm_tooles_size = 125;
var cgm_tooles_diff = 100; 
var cgm_tooles_current = 0; 
var cgm_content_tools_scroll_active = false;
jQuery(document).ready(function($){

	var cgm_content_tools_scroll_max = 0;
	var cgm_content_tools_scroll_over = 0;
	jQuery('#cgm_content_tools').scroll(function () {
		cgm_content_tools_scroll_max = jQuery(this)[0].scrollHeight - jQuery(this).height();
		if(jQuery(this).scrollTop() > cgm_content_tools_scroll_max-100 && jQuery(this).scrollTop() > cgm_content_tools_scroll_over && cgm_content_tools_scroll_active){
			cgm_content_tools_scroll_active = false;
			cgm_tools_data();
		}
	});
	
	$container.isotope({
		itemSelector : '.element',
		filter: '*',
		visibleStyle :{ opacity : <?php echo $return_one==true?'1.0':'0.4'; ?>, scale : 1 }
	}); 
	
	cgm_tools_data();
});

function cgm_activate_click(tmp_this){
	if('<?php echo $return_one; ?>' == 'true'){
		cgm_youtube_preview_image(jQuery(tmp_this).attr('data-id'),jQuery(tmp_this).css("background-image"));
		tb_remove();
	} else {
		if(jQuery(tmp_this).hasClass('imageselect')){
			jQuery(tmp_this).removeClass('imageselect');
		} else {
			jQuery(tmp_this).addClass('imageselect');
		}			
	}
};

function cgm_tools_select_all(tmp_bool){
	jQuery('#cgm_content_tools div').each(function(index) {
		if(tmp_bool) {
			jQuery(this).removeClass('imageselect');
    		jQuery(this).addClass('imageselect');		
		} else {
			jQuery(this).removeClass('imageselect');
		}
	});
}



 function cgm_tools_add_new(tmp_data){
	var $newItems = jQuery(tmp_data);
	$container.isotope( 'insert', $newItems );
	cgm_content_tools_scroll_active = true;
 }


 function cgm_tools_size(tmp_size,tmp_this){
 	if(cgm_tooles_size != tmp_size){
		jQuery(tmp_this).parent().children('a').each(function(index) {
    		jQuery(this).removeClass('select');				
		});
    	jQuery(tmp_this).addClass('select');	
    	jQuery('#cgm_content_tools div').each(function(index) {
			jQuery(this).removeClass('imagesize'+cgm_tooles_size);	
			jQuery(this).addClass('imagesize'+tmp_size);	
		});
		
		$container.isotope();
    	cgm_tooles_size = tmp_size;
    }
 }
 
 function cgm_tools_sort(tmp_sort,tmp_this){
 	if(cgm_tooles_sort != tmp_sort){
		jQuery(tmp_this).parent().children('a').each(function(index) {
    		jQuery(this).removeClass('select');				
		});
    	jQuery(tmp_this).addClass('select');


	 	cgm_tooles_sort = tmp_sort;
	 	cgm_tooles_diff = 100; 
	 	cgm_tooles_current = 0; 
		cgm_content_tools_scroll_max = 0;
		cgm_content_tools_scroll_over = 0;

    	jQuery('#cgm_content_tools').html('');
    	$container.isotope( 'destroy' );
    	
    	$container.isotope({
			itemSelector : '.element',
			filter: '*',
			visibleStyle :{ opacity : 0.4, scale : 1 }
		}); 
    	
    	cgm_tools_data();
  
    }
 }
 

 function cgm_tools_data(){
 	jQuery('#cgm_bottom_tools_help').show();
 	jQuery('#cgm_bottom_tools_help_div').html('Loading new data');
	jQuery('#cgm_bottom_tools_help').fadeIn(500, function() {
		jQuery.post('<?php echo COMPLETE_GALLERY_URL; ?>frames/select_images_pop_up_data.php',{cgm_tooles_sort:cgm_tooles_sort,cgm_tooles_size:cgm_tooles_size,cgm_tooles_diff:cgm_tooles_diff,cgm_tooles_current:cgm_tooles_current,special_type:'<?php echo $special_type; ?>',special_id:'<?php echo $special_id; ?>'},function(data){
			cgm_tooles_current = data.CURRENT; 
			if(data.R == 'OK'){
				jQuery('#cgm_bottom_tools_xy span').html(cgm_tooles_current);
			
				cgm_tools_add_new(data.DATA);			
			}
			
			jQuery('#cgm_bottom_tools_help').fadeOut(500, function() {
				jQuery('#cgm_bottom_tools_help_div').html(data.MSG);
				jQuery('#cgm_bottom_tools_help').fadeIn(500, function() {	
					jQuery('#cgm_bottom_tools_help').delay(1000).fadeOut(500, function() {jQuery(this).hide()});	
				})			
			});
			
		},'json');
	});
 }
 
 
 
</script>
<?php

$image_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}posts where post_type ='attachment'");

if(empty($image_count)){
	$image_count = 0;
}


echo '<div id="cgm_top_tools">';
echo  '<div id="cwg_tools_left">
		<a href="#" onClick="cgm_tools_size(25,this);return false;">25x25</a>
		<a href="#" onClick="cgm_tools_size(50,this);return false;">50x50</a>
		<a href="#" onClick="cgm_tools_size(75,this);return false;">75x75</a>
		<a href="#" onClick="cgm_tools_size(100,this);return false;">100x100</a>
		<a href="#" class="select" onClick="cgm_tools_size(125,this);return false;">125x125</a>
		<a href="#" onClick="cgm_tools_size(150,this);return false;">150x150</a>
	   </div>';
	   
if(empty($special_type) and empty($special_id) ){	   
echo  '<div id="cwg_tools_right">
		<a href="#" onClick="cgm_tools_sort(\'ID\',this);return false;">ID</a>
		<a href="#" onClick="cgm_tools_sort(\'title\',this);return false;">Name</a>
		<a href="#" class="select" onClick="cgm_tools_sort(\'date\',this);return false;">Date</a>
	   </div>';
} 	   
	   
echo '</div>';
echo '<div id="cgm_bottom_tools_help"><div id="cgm_bottom_tools_help_div">Loading new data</div></div>';
echo '<div id="cgm_content_tools" class="cgm_content_tools">';
echo '</div>';
echo '<div id="cgm_bottom_tools">';

if(!empty($special_type) and !empty($special_id) ){
echo '<div style="float:left;"><input onclick="cgm_tools_select_all(false);" type="submit" value="Deselect all" style="margin-right:10px" class="button-secondary"><input  onclick="cgm_tools_select_all(true);" type="submit" value="Select all" class="button-secondary"></div><input type="submit" value="Cancel" onClick="tb_remove();" style="margin-right:10px" class="button-secondary"><input type="submit" value="Insert" class="button-primary" onClick="cgm_flickr_tb_callback(\'#cgm_content_tools\',\''.$special_type.'\');tb_remove();">';
} else if(!$return_one){
echo '<div style="float:left;"><input onclick="cgm_tools_select_all(false);" type="submit" value="Deselect all" style="margin-right:10px" class="button-secondary"><input  onclick="cgm_tools_select_all(true);" type="submit" value="Select all" class="button-secondary"></div><input type="submit" value="Cancel" onClick="tb_remove();" style="margin-right:10px" class="button-secondary"><input type="submit" value="Insert" class="button-primary" onClick="cgm_tb_callback(\'#cgm_content_tools\');tb_remove();">';	
}
echo '</div>';
if(!empty($special_type) and !empty($special_id) ){
	echo '<div id="cgm_bottom_tools_xy" class="cgm_bottom_tools_xy">Loaded : <span>0</span></div>';
} else {
	echo '<div id="cgm_bottom_tools_xy" class="cgm_bottom_tools_xy">Loaded : <span>0</span> of '.$image_count.'</div>';	
}

?>