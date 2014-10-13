// Current global variables
var cqw_first_animation = true;
var cgm_uploader;
var cgm_preview_new_window = false;
var cgm_popup = '';
var cgm_save_resize_value = 10;
var cgm_preview_pos = '#cgm_preview';
var cgm_settings_pos = '#cgm_data_set';
var cgm_slidertype_pos = '#cgm_flag';
var cgm_hidden_settings = '#cgm_hidden_settings'
var cgm_settings = '';
var cgm_type = '';
var cgm_images = '';
var cgm_preview_lockdown = false;

var cgm_checktype_type = '';
var cgm_checktype_core = '';
var cgm_checktype_flag = '';
var cgm_uploading_images_running = 0;

// -----------------------------------------------------------------------------------------------
// --------------------------------------- Startup functions ---------------------------------------
// -----------------------------------------------------------------------------------------------




window.send_to_editor = function(html) {
	jQuery('#cgm-source-loading').show();
	var cgm_total_count = 0;
	var cgm_load_id_list = '';
	
	html = '<div>'+html+'</div>';
	
	jQuery('img',html).each(function(){
		cgm_total_count ++;
		if(cgm_load_id_list != ''){
			cgm_load_id_list +=',';
		}
		
		var temparray = new Array();
		temparray = jQuery(this).attr('class').split(' ');
		
		for(var i = 0; i<temparray.length;i++){
			if(temparray[i].match(/wp-image-/gi)){
				cgm_load_id_list += temparray[i].replace('wp-image-','');
			}
		}
	});
	
	jQuery.post(COMPLETE_GALLERY_URL+'frames/select_images_render.php',{cgm_current_img_selelcted:cgm_current_img_selelcted,cqw_list_type:cqw_list_type,currentid:cgm_post_id,cgm_load_id_list:cgm_load_id_list},function(data){
			if(data.R == 'OK'){
				cgm_add_new_image(data.DATA);		
				cgm_preview();	
			} else {
				alert(data.MSG);
				
			}
			jQuery('#cgm-source-loading').hide();
		},'json');
	cgm_current_img_selelcted += cgm_total_count;
	
	cgm_total_count = null;
	cgm_load_id_list = null;
}


function cgm_show_loading_menu(){
jQuery(document).ready(function($){
	jQuery('#cgm-source-loading').show();
});
}

jQuery(document).ready(function($){
	
	if(jQuery('#cgm-drag-drop').attr('class') != undefined){
		jQuery(window).resize(cgm_resize_metaboxes);
	
		jQuery( "#cgm_image_list" ).sortable({handle: '.main-move'});
		jQuery( "#cgm_image_list" ).bind( "sortstop", function(event, ui) {
			cgm_numbering_image();
			cgm_preview();
		});
		var cgm_template_upload_test = '';
		 
		if(parseFloat(cgm_wp_version) < 3.5 || cgm_overwrite_to_old){
			cgm_template_upload_test = '<table width="100%"><tr>';
		
			if(cgm_upload_images){
				cgm_template_upload_test += '<td><div style="height:200px;"  class="cgm-qq-upload-list" id="cgm-qq-upload-list"></div></td>';
			}
			if(cgm_upload_images){
				cgm_template_upload_test += '<td width="100%"><div style="height:200px;" class="cgm-drag-drop-area"><div class="cgm-drag-drop-inside"><p class="cgm-drag-drop-info">Upload files by drop</p><p>or</p><p class="cgm-drag-drop-buttons"><input type="button" class="button" value="Select Files" id="cgm_plupload-browse-button" style="position: relative; z-index:20;"></p></div></div></td>';
			}
		
			if(cgm_select_images){
				cgm_template_upload_test += '<td width="100%"><div style="height:200px;"  class="cgm-drag-drop-area-select"><div class="cgm-drag-drop-inside"><p class="cgm-drag-drop-info">Select images</p><p>media</p><p class="cgm-drag-drop-buttons"><input type="button" class="button" value="Select Files" id="cgm_upload_image_button" style="position: relative; z-index: 0;"></p></div></div></td>';
			}
			
			cgm_template_upload_test += '</tr></table>';
		
	
			if(cgm_upload_images) {
			
		    	cgm_uploader = new qq.FileUploader({    
		        	template : cgm_template_upload_test,
		        
		        	fileTemplate: '<li>' +
			                '<span class="cgm-qq-upload-file"></span>' +
			                '<span class="cgm-qq-upload-spinner"></span>' +
			                '<span class="cgm-qq-upload-progressbar"></span>' +
			                '<a class="cgm-qq-upload-cancel" href="#">Cancel</a>' +
			                '<span class="cgm-qq-up load-failed-text">Failed</span>' +
			                '<span class="cgm-qq-upload-success-text">Done</span>' +
			                '<span class="cgm-qq-upload-size"></span>' +
			            '</li>',     
			        
			        
			        
			        classes: {
			        // used to get elements from templates
			        button: 'cgm-drag-drop-buttons',
			        drop: 'cgm-drag-drop-area',
			        dropActive: 'cgm-drag-drop-area-active',
			        list: 'cgm-qq-upload-list',
			        progressBar: 'cgm-qq-upload-progressbar',
			                    
			        file: 'cgm-qq-upload-file',
			        spinner: 'cgm-qq-upload-spinner',
			        size: 'cgm-qq-upload-size',
			        cancel: 'cgm-qq-upload-cancel',
			
			        success: 'cgm-qq-upload-success',
			        fail: 'cgm-qq-upload-fail'},
			
			        element: document.getElementById('cgm-drag-drop'),
			        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
			        action: COMPLETE_GALLERY_URL+'/frames/upload-images.php?cgm_current_img_selelcted='+cgm_current_img_selelcted+'&cqw_list_type='+cqw_list_type + '&currentid='+cgm_post_id,
			        onSubmit: function(id, fileName){
			        	cgm_current_img_selelcted++;
			        	cgm_uploading_images_running++;                                 
			        	if(cqw_first_animation){
			        		jQuery(".cgm-qq-upload-list").css('display','block');
							jQuery(".cgm-qq-upload-list").animate({
								width: "350px",
							}, 500 );
							
							jQuery(".cgm-qq-upload-list").parent().width(300);
							cqw_first_animation = false;
			        	}	
			        },
			        onComplete: function(id, fileName, responseJSON){
			        	if(responseJSON.success){
							if(responseJSON.r_data.length > 0){
								cgm_add_new_image(responseJSON.template);
			        			jQuery('#cgm-qq-upload-list li').eq(id).children(".cgm-qq-upload-success-text").show();
			
							}
							
							
							cgm_uploading_images_running--;
			    			if(cgm_uploading_images_running==0){
			          			cgm_preview();                              
			        		}
			        	}
			        }
			    }); 
		    } else {
		    	jQuery('#cgm-drag-drop').html(cgm_template_upload_test);
		    }
	    
	    } else {
		    cgm_template_upload_test = '<table width="100%"><tr>';
			if(cgm_select_images && cgm_upload_images){
				cgm_template_upload_test += '<td width="100%"><div class="cgm-drag-drop-area-select2" style="border:none;"><div class="cgm-drag-drop-inside" style="width:400px"><p class="cgm-drag-drop-info">Select images / Upload images</p><p>media</p><p class="cgm-drag-drop-buttons"><a type="button" onClick="cgm_show_loading_menu();" class="button insert-media add_media" style="position: relative; z-index: 0;">Select Files</a></p></div></div></td>';
			} else if(cgm_select_images){
				cgm_template_upload_test += '<td width="100%"><div class="cgm-drag-drop-area-select"><div class="cgm-drag-drop-inside"><p class="cgm-drag-drop-info">Select images</p><p>media</p><p class="cgm-drag-drop-buttons"><input type="button" class="button" value="Select Files" id="cgm_upload_image_button" style="position: relative; z-index: 0;"></p></div></div></td>';
			}
			
			cgm_template_upload_test += '</tr></table>';
		    jQuery('#cgm-drag-drop').html(cgm_template_upload_test);  
	    }
	    
	    cgm_template_upload_test = null;
	
	    
		// hide other metaboxes
		jQuery('#advanced-sortables,#side-sortables,#normal-sortables').children().each(function(i,o){
			if(!cgm_check_meta_boxes(jQuery(this).attr('id'))){
				jQuery(this).hide();
			};
		});
		
		// Add show/hide/resize functions
		var cgm_width_text = jQuery('#cgm-settings-preview-meta h3 span').width() + 17;
		var cgm_tmp_text = '<input style="margin-left:'+(cgm_width_text+15)+'px;position: absolute; margin-top: 3px;cursor:pointer;" class="button-secondary" onClick="cgm_select_image_preview();return false;" type="submit" value="Update">';

		jQuery('#cgm-settings-preview-meta').prepend(cgm_tmp_text);
		
		//add radio button on select image bar
		cgm_width_text = 110 + 30;
		cgm_tmp_text = '<div id="cgm-status" class="status" style="margin-left: '+cgm_width_text+'px;"> <input onclick="cgm_change_list_form(\'list\')" type="radio" name="cgm-list-type" value="list" class="cgm-status-radio" ';
		
		if(cqw_list_type != 'grid'){
			cgm_tmp_text += 'checked="checked"';
		}
		
		cgm_tmp_text +=  '><img src="'+COMPLETE_GALLERY_URL+'images/list.png" class="cgm-status-img"><input onclick="cgm_change_list_form(\'grid\')" name="cgm-list-type" type="radio" value="grid" class="cgm-status-radio"';
		
		if(cqw_list_type == 'grid'){
			cgm_tmp_text += 'checked="checked"';
		}
		cgm_tmp_text += '><img src="'+COMPLETE_GALLERY_URL+'images/grid.png" class="cgm-status-img">';
		
		cgm_tmp_text += '<input style="margin-top:-5px" class="button-secondary" onClick="cgm_remove_all_images();return false;" type="submit" value="Remove all inserted Media">';
		
		
		cgm_tmp_text += '</div>';
		
		jQuery('#cgm-selected-images-meta').prepend(cgm_tmp_text);
		
		cgm_width_text = null;
		cgm_tmp_text = null;
		
		// start creating list
		cgm_getData();	
		
	}		
		
});

// -----------------------------------------------------------------------------------------------
// --------------------------------------- Button functions ---------------------------------------
// -----------------------------------------------------------------------------------------------
function cgm_urldecode (str) {
    return decodeURIComponent((str + '').replace(/\+/g, '%20'));
}
jQuery(document).ready(function() {
	jQuery("#cgm-category-all").change(function () {
		cgm_category_update_all();   
    });

	// select image from button
	jQuery('#cgm_upload_image_button, .cgm-drag-drop .cgm-drag-drop-area-select').click(function() {
 		tb_show('Select images', COMPLETE_GALLERY_URL+'frames/select_images_pop_up.php?popup=1');
 		return false;
	});
	jQuery('#cgm_plupload-browse-button').click(function() {
 		jQuery(this).parent().children('input[type=file]').click();
 		return false;
	});


	jQuery('#submitpost #publish').click(function() {
		cgm_generate_images();
	});
	
	jQuery('#cgm_youtupe_vimeo_preview_image_remove').click(function() {
		jQuery('#cgm_youtupe_vimeo_preview_image').css("background-image",'');	
		jQuery('#cgm_youtupe_vimeo_preview_id').val('');
		jQuery('#cgm_youtupe_vimeo_preview_image_remove').hide();

	});
	
	jQuery('#cgm_gallery_add').click(function() {
		var tmp_string_img = '';
		var tmp_string_post = '';
		
		jQuery('#cgm_gallery_add_list input:checked').each(function(){
			if(tmp_string_post != ''){
				tmp_string_post += ',';
			}
			
			tmp_string_post += jQuery(this).val();
		
		
			if(tmp_string_img != ''){
				tmp_string_img += ',';
			}
			tmp_string_img += jQuery(this).attr('ref');
		});
		
		cgm_load_new_data_post_page_data(tmp_string_img,tmp_string_post,'gallery');
		tmp_string_img = null;
		tmp_string_post = null;

	});
	
	jQuery('#cgm_post_add').click(function() {
		var tmp_string_img = '';
		var tmp_string_post = '';
		
		jQuery('#cgm_post_add_list input:checked').each(function(){
			if(tmp_string_post != ''){
				tmp_string_post += ',';
			}
			
			tmp_string_post += jQuery(this).val();

			if(tmp_string_img != ''){
				tmp_string_img += ',';
			}
			tmp_string_img += jQuery(this).attr('ref');
		});
		
		cgm_load_new_data_post_page_data(tmp_string_img,tmp_string_post,'post');
		tmp_string_img = null;
		tmp_string_post = null;

	});
	
	
	jQuery('#cgm_post_sub_auto').click(function() {
		if(jQuery(this).attr('checked') == 'checked'){
			cgm_auto_lockup_images('post');
		} else {
			cgm_auto_lockdown_images('post');	
		}
	});
	
	jQuery('#cgm_page_sub_auto').click(function() {
		if(jQuery(this).attr('checked') == 'checked'){
			cgm_auto_lockup_images('page');
		} else {
			cgm_auto_lockdown_images('page');	
		}
	});
	
	jQuery('#cgm_post_category_add').click(function() {
		var tmp_string_post = '';
		
		jQuery('#cgm_post_category_add_list input:checked').each(function(){
			if(tmp_string_post != ''){
				tmp_string_post += ',';
			}
			tmp_string_post += jQuery(this).val();
		});
		
		cgm_load_new_data_post_page_data('postc',tmp_string_post,'post');
		tmp_string_post = null;
	});
	
	jQuery('#cgm_page_add').click(function() {
		var tmp_string_img = '';
		var tmp_string_post = '';
		
		jQuery('#cgm_page_add_list input:checked').each(function(){
			if(tmp_string_post != ''){
				tmp_string_post += ',';
			}
			
			tmp_string_post += jQuery(this).val();
		
		
			if(tmp_string_img != ''){
				tmp_string_img += ',';
			}
			tmp_string_img += jQuery(this).attr('ref');
		});
		
		cgm_load_new_data_post_page_data(tmp_string_img,tmp_string_post,'page');
		tmp_string_img = null;
		tmp_string_post = null;
	});
	
	jQuery('#cgm_page_parrent_add').click(function() {
		var tmp_string_post = '';
		
		jQuery('#cgm_page_parrent_add_list input:checked').each(function(){
			if(tmp_string_post != ''){
				tmp_string_post += ',';
			}
			
			tmp_string_post += jQuery(this).val();
		});
		
		cgm_load_new_data_post_page_data('pagep',tmp_string_post,'page');
		tmp_string_post = null;
	});
	
	
	
	jQuery('#cgm_youtupe_vimeo_add').click(function() {
		if(jQuery('#cgm_youtupe_vimeo_url').val() != ''){
cgm_load_new_data_video_data(jQuery('#cgm_youtupe_vimeo_preview_id').val(),jQuery('#cgm_youtupe_vimeo_url').val(),'video');
		} else {
			alert('No url found, pleas write one');
		}
	});
	
	jQuery('#cgm_youtupe_vimeo_preview').click(function() {
 		tb_show('Select images', COMPLETE_GALLERY_URL+'frames/select_images_pop_up.php?popup=1&return_one=true');
 		return false;
	});
	
	
	
	
	jQuery('#cgm-drag-drop_load_data ul li').click(function() {
		if(jQuery('#cgm-gallery-auto-lock-type').val() != '' && jQuery('#cgm-gallery-auto-lock').val() != '' ){
			return false;
		}
	
		jQuery('#cgm-drag-drop_load_data ul').find('.active').removeClass('active');
		jQuery(this).addClass('active');
		
		var tmp_index = jQuery(this).index();
		
		jQuery('#cgm_hidden_data_source').val(tmp_index);
		jQuery('.cgm-source-border > div').eq(1).hide();
		jQuery('.cgm-source-border > div').eq(2).hide();
		jQuery('.cgm-source-border > div').eq(3).hide();
		jQuery('.cgm-source-border > div').eq(4).hide();
		jQuery('.cgm-source-border > div').eq(5).hide();
		jQuery('.cgm-source-border > div').eq(6).hide();
		jQuery('.cgm-source-border > div').eq(7).hide();
		jQuery('.cgm-source-border > div').eq(8).hide();
		jQuery('.cgm-source-border > div').eq(9).hide();
		jQuery('.cgm-source-border > div').eq(10).hide();
		jQuery('.cgm-source-border > div').eq(11).hide();
		jQuery('.cgm-source-border > div').eq(tmp_index+2).show();
		
		
		jQuery('.cgm-source-header ul > li').hide();
		jQuery('.cgm-source-header ul > li').eq(tmp_index).show();
		
		tmp_index = null;
	});

	

});

function cgm_fn_saveCustomPostType(tmp_address) {
		var tmp_string_img = '';
		var tmp_string_post = '';
		
		jQuery(tmp_address+' input:checked').each(function(){
			if(tmp_string_post != ''){
				tmp_string_post += ',';
			}
			
			tmp_string_post += jQuery(this).val();

			if(tmp_string_img != ''){
				tmp_string_img += ',';
			}
			tmp_string_img += jQuery(this).attr('ref');
		});

		if(tmp_string_post != ''){
			cgm_load_new_data_post_page_data(tmp_string_img,tmp_string_post,'cpost');	
		} else {
			alert('No post have been selected');
		}
		
		tmp_string_img = null;
		tmp_string_post = null;
		
}


function cgm_auto_lockup_images(tmp_type){
	var cgm_temp_string = '';
	var cgm_temp_id = '';
	var cgm_list_id_pos = '';
	var cgm_lock_down_title = '';
	var cgm_lock_down_subtitle = '';
	var cgm_lock_down_alert = '';
		
	if(tmp_type == 'post'){
		cgm_list_id_pos = '#cgm_post_category_add_list input';
		cgm_lock_down_title = 'Auto Load Post';
		cgm_lock_down_subtitle = 'Category id(s): ';
		cgm_lock_down_alert = 'Please select at least one category';
	} else if(tmp_type == 'page'){
		cgm_list_id_pos = '#cgm_page_parrent_add_list input';
		cgm_lock_down_title = 'Auto Load Page';
		cgm_lock_down_subtitle = 'Page id(s): ';
		cgm_lock_down_alert = 'Please select at least one post with sub-pages';
	}
	
	jQuery(cgm_list_id_pos).each(function(){
		if(jQuery(this).attr('checked') == 'checked'){
			if(cgm_temp_string != ''){
				cgm_temp_string += ', ';
				cgm_temp_id += ',';
			}
			
			cgm_temp_string += jQuery(this).next().next().html().replace(/\((\d+)\)/g, 
    "").slice(0,-1);
			
			cgm_temp_id += jQuery(this).val();
		}
	});
		
	if(cgm_temp_string == ''){
		jQuery('#cgm_page_sub_auto').removeAttr('checked');
		jQuery('#cgm_post_sub_auto').removeAttr('checked');
		jQuery('#cgm-gallery-auto-lock').val('');
		jQuery('#cgm-gallery-auto-lock-type').val('');
		jQuery('#cgm-gallery-auto-lock-s').val('');
		jQuery('#cgm-gallery-auto-lock-w').val('');
		jQuery('#cgm-gallery-auto-lock-h').val('');
		
		alert(cgm_lock_down_alert);
		return;
	}
	
	jQuery('#cgm-gallery-auto-lock').val(cgm_temp_id);
	jQuery('#cgm-gallery-auto-lock-type').val(tmp_type);
	jQuery('#cgm-gallery-auto-lock-s').val(jQuery('#cgm-gallery-auto-select-s').val());
	jQuery('#cgm-gallery-auto-lock-w').val(jQuery('#cgm-gallery-auto-select-w').val());
	jQuery('#cgm-gallery-auto-lock-h').val(jQuery('#cgm-gallery-auto-select-h').val());
	
	
	jQuery('#cgm-source-lockdown #cgm-lockdown-title').html(cgm_lock_down_title);
	jQuery('#cgm-source-lockdown #cgm-lockdown-subtitle').html(cgm_lock_down_subtitle+' ' +cgm_temp_string);
	jQuery('#cgm-source-lockdown').show();
	cgm_lockdown_menu_button();
	cgm_preview();
	
	cgm_temp_string = null;
	cgm_temp_id = null;
	cgm_list_id_pos = null;
	cgm_lock_down_title = null;
	cgm_lock_down_subtitle = null;
	cgm_lock_down_alert = null;
	
}

function cgm_auto_lockdown_images(){
	jQuery('#cgm_page_sub_auto').removeAttr('checked');
	jQuery('#cgm_post_sub_auto').removeAttr('checked');
	
	jQuery('#cgm-gallery-auto-lock-s').val('');
	jQuery('#cgm-gallery-auto-lock-w').val('');
	jQuery('#cgm-gallery-auto-lock-h').val('');
	jQuery('#cgm-gallery-auto-lock').val('');
	jQuery('#cgm-gallery-auto-lock-type').val('');
	jQuery('#cgm-source-lockdown').hide();
	cgm_lockdown_menu_button();
	cgm_preview();
}

function cgm_lockdown_menu_button(){
	if(jQuery('#cgm-gallery-auto-lock-type').val() != '' && jQuery('#cgm-gallery-auto-lock').val() != '' ){
		jQuery('#cgm-drag-drop_load_data li').not('.active').each(function(){
			jQuery(this).addClass('hidden');
		});
	} else {
		jQuery('#cgm-drag-drop_load_data li').not('.active').each(function(){
			jQuery(this).removeClass('hidden');
		});
	}
}

var cgm_delay_myTimeout = '';
function cgm_preview_delay(){
	
	clearTimeout(cgm_delay_myTimeout)
	cgm_delay_myTimeout = setTimeout(function () {
	    cgm_preview();
	  }, 1000);
}

// -----------------------------------------------------------------------------------------------
// --------------------------------------- Image Contole functions ---------------------------------------
// -----------------------------------------------------------------------------------------------

function cgm_flickr_show(tmp_type,tmp_id) {
 		tb_show('Select images', COMPLETE_GALLERY_URL+'frames/select_images_pop_up.php?popup=1&special_type='+tmp_type+'&special_id='+tmp_id);
 		return false;
}

function cgm_flickr_tb_callback(tmp_id,tmp_type){

	var cgm_total_count = 0;
	var cgm_load_id_list = '';
	jQuery(tmp_id + ' .imageselect').each(function(i,o){
		cgm_total_count ++;
		
		if(cgm_load_id_list != ''){
			cgm_load_id_list +=',';
		}
		
		cgm_load_id_list += jQuery(this).attr('data-id');
		
	});
	jQuery('#cgm-source-loading').show();
	jQuery.post(COMPLETE_GALLERY_URL+'frames/add_flickr_data.php',{datatype:tmp_type,cgm_current_img_selelcted:cgm_current_img_selelcted,cqw_list_type:cqw_list_type,currentid:cgm_post_id,cgm_load_id_list:cgm_load_id_list},function(data){
			jQuery('#cgm-source-loading').hide();
			if(data.R == 'OK'){
				cgm_add_new_image(data.DATA);		
				cgm_preview();
				cgm_current_img_selelcted = data.COUNT;
			} else {
				alert(data.MSG);
				
			}

		},'json');
	cgm_current_img_selelcted += cgm_total_count;
	cgm_total_count = null;
	cgm_load_id_list = null;
}


function cgm_load_new_data_video_data(listDataImage,videoURL,datatype){

	jQuery('#cgm-source-loading').show();
	
	jQuery.post(COMPLETE_GALLERY_URL+'frames/add_video_data.php',{datatype:datatype,listDataImage:listDataImage,videoURL:videoURL,cgm_current_img_selelcted:cgm_current_img_selelcted,cqw_list_type:cqw_list_type,currentid:cgm_post_id},function(data){
		jQuery('#cgm-source-loading').hide();
		if(data.R == 'OK'){
			cgm_add_new_image(data.DATA);		
			cgm_preview();
		} else {

			alert(data.MSG.replace(/--line--/g,'\n'));
		}
	},'json');
}



function cgm_load_new_data_post_page_data(listDataImage,listDataPost,datatype){
	jQuery('#cgm-source-loading').show();
	jQuery.post(COMPLETE_GALLERY_URL+'frames/add_post_page_data.php',{datatype:datatype,listDataImage:listDataImage,listDataPost:listDataPost,cgm_current_img_selelcted:cgm_current_img_selelcted,cqw_list_type:cqw_list_type,currentid:cgm_post_id},function(data){
		jQuery('#cgm-source-loading').hide();
		if(data.R == 'OK'){
			cgm_add_new_image(data.DATA);		
			cgm_preview();	
			alert(data.COUNT+' Has been added');
		} else {
			alert(data.MSG);
		}
	},'json');
}


function cgm_generate_settings(){
	cgm_settings = new Object();
	jQuery(cgm_settings_pos+' input[type=radio]:checked').each(function(i,o){
		if(jQuery(this).attr('name') && jQuery(this).val()){
			cgm_change_string_to_object_by_dot(jQuery(this).attr('name'),jQuery(this).val());
		}
	});	
			
	jQuery(cgm_settings_pos + ' input[type=checkbox]:checked').each(function(i,o){
		if(jQuery(this).attr('name') && jQuery(this).val()){
			cgm_change_string_to_object_by_dot(jQuery(this).attr('name'),jQuery(this).val());
		}
	});	
			
	jQuery(cgm_settings_pos + ' input[type=text]').each(function(i,o){
	
		if(jQuery(this).attr('name') && jQuery(this).val() && jQuery(this).val() != '#'){
			if(jQuery(this).attr('name') == 'cgm_backgroundColor'){
				if(typeof(cgm_settings['backgroundColor']) !== 'undefined' && typeof(cgm_settings['backgroundColor']['fill']) !== 'undefined'){
				}else{
					cgm_change_string_to_object_by_dot(jQuery(this).attr('name')+'__fill',jQuery(this).val());
				}
			} else {
				cgm_change_string_to_object_by_dot(jQuery(this).attr('name'),jQuery(this).val());
			}
		}
	});	
	
	jQuery(cgm_settings_pos + ' input[type=hidden]').each(function(i,o){
	
		if(jQuery(this).attr('name') && jQuery(this).val() && jQuery(this).val() != '#'){
			if(jQuery(this).attr('name') == 'cgm_backgroundColor'){
				if(typeof(cgm_settings['backgroundColor']) !== 'undefined' && typeof(cgm_settings['backgroundColor']['fill']) !== 'undefined'){
				}else{
					cgm_change_string_to_object_by_dot(jQuery(this).attr('name')+'__fill',jQuery(this).val());
				}
			} else {
				cgm_change_string_to_object_by_dot(jQuery(this).attr('name'),jQuery(this).val());
			}
		}
	});	
			
	jQuery(cgm_settings_pos+' select').each(function(i,o){
		if(jQuery(this).attr('name') && jQuery(this).val()){
			cgm_change_string_to_object_by_dot(jQuery(this).attr('name'),jQuery(this).val());
		}
	});	
			
	jQuery(cgm_settings_pos+' textarea').each(function(i,o){
		if(jQuery(this).attr('name') && jQuery(this).val()){
			cgm_change_string_to_object_by_dot(jQuery(this).attr('name'),jQuery(this).val());
		}
	});	
	
	if(jQuery('#cgm_filterscategory').attr('name') && jQuery('#cgm_filterscategory').val()){
cgm_change_string_to_object_by_dot(jQuery('#cgm_filterscategory').attr('name'),jQuery('#cgm_filterscategory').val());
	}
	
	jQuery(cgm_hidden_settings).val(encodeURI(JSON.stringify(cgm_settings, null, 2)));
}


function cgm_generate_images(){
		var return_array = new Object();
		var cgm_tmp_auto_load_lock = jQuery('#cgm-gallery-auto-lock').val();
		var cgm_tmp_auto_load_lock_type = jQuery('#cgm-gallery-auto-lock-type').val();
		
		if((cgm_tmp_auto_load_lock != undefined && cgm_tmp_auto_load_lock != '') && (cgm_tmp_auto_load_lock_type != undefined && cgm_tmp_auto_load_lock_type != '')){
			jQuery('#cgm-selected-images-meta').hide();
			return_array.auto_lock_id = cgm_tmp_auto_load_lock;
			return_array.auto_lock_type = cgm_tmp_auto_load_lock_type;
			jQuery('#cgm-gallery-auto-lock-s').val(jQuery('#cgm-gallery-auto-select-s').val());
			jQuery('#cgm-gallery-auto-lock-w').val(jQuery('#cgm-gallery-auto-select-w').val());
			jQuery('#cgm-gallery-auto-lock-h').val(jQuery('#cgm-gallery-auto-select-h').val());
			return_array.auto_lock_s = jQuery('#cgm-gallery-auto-lock-s').val();
			return_array.auto_lock_w = jQuery('#cgm-gallery-auto-lock-w').val();
			return_array.auto_lock_h = jQuery('#cgm-gallery-auto-lock-h').val();
			cgm_lockdown_menu_button();
		} else {
			cgm_lockdown_menu_button();
			jQuery('#cgm-selected-images-meta').show();
			jQuery('#cgm_image_list li').each(function(i,o) {
				return_array[i]= new Object();
				return_array[i].show = jQuery(this).find('#object-main-status').val();
				return_array[i].title = jQuery(this).find('#object-title').val();
				return_array[i].description = jQuery(this).find('#object-description').val();		
				return_array[i].link = jQuery(this).find('#object-link').val();	
				return_array[i].category = new Object();
				return_array[i].postid = jQuery(this).find('#object-post_id').val();
				return_array[i].attactedid = jQuery(this).find('#object-attacted_id').val();
				return_array[i].typeobject = jQuery(this).find('#object-type-object').val();
				return_array[i].linkoverwrite = jQuery(this).find('#object-link-overwrite option:selected').val();
				return_array[i].customheight = jQuery(this).find('#object-custom-height').val();
				return_array[i].customwidth = jQuery(this).find('#object-custom-width').val();	
				return_array[i].link = return_array[i].link.replace(/'/g, "&lsquo;");			
				return_array[i].title = return_array[i].title.replace(/'/g, "&lsquo;");
				return_array[i].description = return_array[i].description.replace(/'/g, "&lsquo;");		
				
				jQuery(this).find(".object-category input[type=checkbox]").each( 
	   				function(ii,oo) { 
	   					if(jQuery(this).attr('checked')){
	   						return_array[i].category[ii] = jQuery(this).val();
	   					}
	    			} 
				);	
				
				return_array[i].imageselected = jQuery(this).find(".object-imagegroup input[type=radio]:checked").val();		
			});	
		}
		
		
		
		
		
		jQuery('#cgm-selected-images-meta #cgm-gallery-data').val(encodeURI(JSON.stringify(return_array,null, 2)));
		
		
		setTimeout(function(){
			jQuery('#cgm_image_list').show()
		}, 100 )
		
		return_array = null;
		cgm_tmp_auto_load_lock = null;
		cgm_tmp_auto_load_lock_type = null;
		
		
}

function cgm_youtube_preview_image(tmp_id,tmp_url){
	if(tmp_url != ''){
		jQuery('#cgm_youtupe_vimeo_preview_image').css("background-image",tmp_url);	
	}
	if(tmp_id != ''){
		jQuery('#cgm_youtupe_vimeo_preview_id').val(tmp_id);
		jQuery('#cgm_youtupe_vimeo_preview_image_remove').show();
	}
};

function cgm_tb_callback(tmp_id){
	var cgm_total_count = 0;
	var cgm_load_id_list = '';
	jQuery(tmp_id + ' .imageselect').each(function(i,o){
		cgm_total_count ++;
		
		if(cgm_load_id_list != ''){
			cgm_load_id_list +=',';
		}
		
		cgm_load_id_list += jQuery(this).attr('data-id');
		
	});
	
		jQuery.post(COMPLETE_GALLERY_URL+'frames/select_images_render.php',{cgm_current_img_selelcted:cgm_current_img_selelcted,cqw_list_type:cqw_list_type,currentid:cgm_post_id,cgm_load_id_list:cgm_load_id_list},function(data){
			if(data.R == 'OK'){
				cgm_add_new_image(data.DATA);		
				cgm_preview();	
			} else {
				alert(data.MSG);
				
			}

		},'json');
	cgm_current_img_selelcted += cgm_total_count;
	
	cgm_total_count = null;
	cgm_load_id_list = null;
}



function cgm_add_new_image(addcontent){
	var tmp_var = jQuery('#cgm_image_list').html();
	
	if(tmp_var == cgm_no_images_text){
		jQuery('#cgm_image_list').html('');
	}
	
	tmp_var = null;


	if(jQuery(cgm_slidertype_pos).val() == 'touch'){
		jQuery('#cgm_image_list').append(addcontent).find('.object-imagegroup').css('opacity','0.3');
	} else {
		jQuery('#cgm_image_list').append(addcontent).find('.object-imagegroup').css('opacity','1.0');	
	}

	cgm_refresh_UI();
}



function cgm_remove_all_images(){
	if(confirm('Are you sure you want to remove all images')){
		jQuery('#cgm_image_list').html('');
		cgm_numbering_image();
		cgm_preview();
	}
}

function cgm_remove_new_image(tmpID){
	if(confirm('Are you sure you want to remove this image')){
		jQuery(tmpID).parent().parent().parent().parent().parent().parent().hide('medium',function() {
			jQuery(this).remove();
			cgm_numbering_image();
			cgm_preview();
		});
	}
}

function cgm_role_up_down(tmpThis) {
	var tmp = jQuery(tmpThis).attr('class');
	if(tmp == 'main-role-up'){
		jQuery(tmpThis).parent().parent().parent().parent().parent().parent().find('.groupClass').slideUp(200);
		jQuery(tmpThis).attr('class','main-role-down');
	} else if(tmp == 'main-role-down'){
		jQuery(tmpThis).parent().parent().parent().parent().parent().parent().find('.groupClass').slideDown(200);
		jQuery(tmpThis).attr('class','main-role-up');
	}
	
	tmp = null;	
}


function cgm_change_status_image(tmpThis){
	var tmp = jQuery(tmpThis).attr('class');
	
	if(tmp == 'main-show'){
		jQuery(tmpThis).parent().parent().parent().parent().parent().parent().addClass('hidedeaktiv');
		jQuery(tmpThis).attr('class','main-hide');
		jQuery(tmpThis).find('input').val('false');
	} else if(tmp == 'main-hide'){
		jQuery(tmpThis).parent().parent().parent().parent().parent().parent().removeClass('hidedeaktiv');
		jQuery(tmpThis).attr('class','main-show');
		jQuery(tmpThis).find('input').val('true');	
	}
	
	tmp = null;
	cgm_preview();

}


function cgm_numbering_image(){
	jQuery('#cgm_image_list li').each(function(index) {
    	jQuery(this).find('#main-number').html((index+1));
	});
}


function cgm_change_list_form(tmpvalue){
	if(tmpvalue == 'list' && cqw_list_type != 'list'){	
	
	 	jQuery('#cgm_image_list li').removeClass("object-gridtype1");
	 	jQuery('#cgm_image_list li').removeClass("object-listtype2");
	 	jQuery('#cgm_image_list li').removeClass("object-listtype3");
 		jQuery('#cgm_image_list li').addClass("object-listtype1");
		
		setTimeout(function(){
			cgm_resize_metaboxes();
		}, 500 );
	} else if(tmpvalue == 'grid' && cqw_list_type != 'grid'){
	 	jQuery('#cgm_image_list li').removeClass("object-listtype1");
	 	jQuery('#cgm_image_list li').removeClass("object-listtype2");
	 	jQuery('#cgm_image_list li').removeClass("object-listtype3");
 		jQuery('#cgm_image_list li').addClass("object-gridtype1");
	}
	
	cqw_list_type = tmpvalue;
}

function cgm_refresh_UI(){
	cgm_numbering_image();
	cgm_resize_metaboxes(true);
}




// -----------------------------------------------------------------------------------------------
// --------------------------------------- Settings Contole functions ---------------------------------------
// -----------------------------------------------------------------------------------------------

//resizes one two column
var cgm_screenwidth = 0;
var cgm_save_resize_value_select_images = 1;
var cgm_save_resize_current_select_images = 'object-listtype1'; 
function cgm_resize_metaboxes(cgm_reset_status) {

	if(cgm_reset_status){
		cgm_save_resize_value_select_images = 0;
	}

	cgm_screenwidth= jQuery('#cgm-settings-meta').width()
	if(cqw_list_type != 'grid'){
		if(cgm_screenwidth > 1050){
 			if(cgm_save_resize_value_select_images != 1){
 				jQuery('#cgm_image_list li').removeClass(cgm_save_resize_current_select_images);
 				jQuery('#cgm_image_list li').addClass("object-listtype1");
				cgm_save_resize_current_select_images = 'object-listtype1';	
 			}
 			cgm_save_resize_value_select_images = 1;	
 		} else if(cgm_screenwidth > 500){
 			if(cgm_save_resize_value_select_images != 2){
 				jQuery('#cgm_image_list li').removeClass(cgm_save_resize_current_select_images);
 				jQuery('#cgm_image_list li').addClass("object-listtype2");	
				cgm_save_resize_current_select_images = 'object-listtype2';	
 			}
 			cgm_save_resize_value_select_images = 2;	
 		} else {
 			if(cgm_save_resize_value_select_images != 3){
 				jQuery('#cgm_image_list li').removeClass(cgm_save_resize_current_select_images);
 				jQuery('#cgm_image_list li').addClass("object-listtype3");
				cgm_save_resize_current_select_images = 'object-listtype3';	
 			}
 			cgm_save_resize_value_select_images = 3;	
 		};
	}

	if(cgm_screenwidth > 740){
 		if(cgm_save_resize_value != 1){
 			jQuery('.uh_post_div_col').each(function(index) {
  				jQuery(this).animate({
    				width: "49%"
  				}, 500 );
  			});
 		}
 		cgm_save_resize_value = 1;	
 	} else {
 		if(cgm_save_resize_value != 2){
  			jQuery('.uh_post_div_col').animate({
    			width: "100%"
  			}, 500 );
 		}
 		cgm_save_resize_value = 2;
 	};
}

//Start loading data
function cgm_getData(){
	jQuery(document).ready(function($){
	
		if(jQuery(cgm_slidertype_pos).val() == 'touch'){
			jQuery('#cgm_image_list').find('.object-imagegroup').css('opacity','0.3');
		} else {
			jQuery('#cgm_image_list').find('.object-imagegroup').css('opacity','1.0');	
		}
	
		if(jQuery(cgm_slidertype_pos).val() != ''){
			jQuery(cgm_settings_pos).fadeTo('fast',0.0);
			jQuery(cgm_preview_pos).fadeTo('fast', 0.0, function() {
				jQuery(cgm_settings_pos).html('<img src="'+COMPLETE_GALLERY_URL+'images/loader.gif">');
				jQuery(cgm_preview_pos).html('<img src="'+COMPLETE_GALLERY_URL+'images/loader.gif">');
				
				jQuery(cgm_preview_pos).fadeTo('fast',1.0);
				jQuery(cgm_settings_pos).fadeTo('fast', 1.0, function() {
					var _url = COMPLETE_GALLERY_URL+'frames/frame.load_post_data.php';	
					jQuery.post(_url,{post_id:cgm_post_id,type:jQuery(cgm_slidertype_pos).val()},function(data){
					if(data.R == 'OK'){
						jQuery(cgm_preview_pos).fadeTo('fast',0.0);
						jQuery(cgm_settings_pos).fadeTo('fast', 0.0, function() {
							jQuery(cgm_settings_pos).html(data.DATA_SET);
			
							cgm_call_js_file = data.CALLJSFILE;
							cgm_call_js_func = data.CALLJSFUNC;
							cgm_call_php_file = data.CALLPHPFILE;
							cgm_call_php_func = data.CALLPHPFUNC;
							
							cgm_checktype_type = data.TYPE;
							cgm_checktype_core = data.CORE;
							cgm_checktype_flag = data.FLAG;								

							jQuery(cgm_preview_pos).fadeTo('fast',1.0);
							jQuery(cgm_settings_pos).fadeTo('fast', 1.0);
								
							uh_activate_farbtastic();
							cgm_save_resize_value = 10;
							cgm_resize_metaboxes();
							cgm_preview();
						});
					} else {
						jQuery(cgm_settings_pos).fadeTo('fast', 0.0, function() {
							jQuery(cgm_settings_pos).html(' ');
							jQuery(cgm_preview_pos).html(no_graph);				
						});
						alert(data.MSG);
					}
				},'json');	
					_url = null;
				});
			});
		} else { 
			jQuery(cgm_settings_pos).fadeTo('fast', 0.0, function() {
				jQuery(cgm_settings_pos).html(' ');				
			});
		}
	});
}


function cgm_preview(){
	jQuery(document).ready(function($){
		if(jQuery(cgm_preview_pos) && !cgm_preview_lockdown){
		
			var cgm_save_height = jQuery(cgm_preview_pos).height();
		
		
			if(typeof(cgm_touch_data) !== 'undefined'){
				var len=cgm_touch_data.length;
				for(var i=0; i<len; i++) {
					if(typeof(cgm_touch_data[i]) !== 'undefined'){
						cgm_touch_data[i].stopAutoPlay();
					}
				}
			}
		
			jQuery(cgm_preview_pos).fadeTo('fast', 0.0, function() {
				jQuery(cgm_preview_pos).html('<img src="'+COMPLETE_GALLERY_URL+'images/loader.gif">');
				jQuery(cgm_preview_pos).height(cgm_save_height);
				jQuery(cgm_preview_pos).fadeTo('fast',1.0);
				cgm_preview_lockdown = true;

				cgm_generate_settings();
				cgm_generate_images();

				var _url = COMPLETE_GALLERY_URL + '/frames/frame_preview_data.php';
				jQuery.post(_url,{type:cgm_checktype_type,core:cgm_checktype_core,flag:cgm_checktype_flag,settings:jQuery(cgm_hidden_settings).val(),images:jQuery('#cgm-selected-images-meta #cgm-gallery-data').val(),currentid:cgm_post_id},function(data){
					cgm_preview_lockdown = false;
					
					jQuery(cgm_preview_pos).fadeTo('fast', 0.0, function() {
						if(cgm_preview_new_window && typeof( cgm_popup ) != 'undefined' && cgm_popup.document){
							jQuery(cgm_preview_pos).html('The gallery is show in a new windows. Close the windows to show gallery here');
							jQuery(cgm_preview_pos).width('100%');
							jQuery(cgm_preview_pos).height('100%');
							
							cgm_popup.window.resizeTo(600,600)
							cgm_popup.document.getElementById('preview').innerHTML = data.RETURN_DATA;
						} else {
							jQuery(cgm_preview_pos).html(data.RETURN_DATA);
							jQuery(cgm_preview_pos).width('');
							jQuery(cgm_preview_pos).height('100%');
						}
					
					
						if(cgm_call_js_func != ''){
							window[cgm_call_js_func](0,jQuery(cgm_hidden_settings).val(),cgm_post_id,COMPLETE_GALLERY_URL,true);
						}
						jQuery(cgm_preview_pos).fadeTo('fast',1.0);
					});
				},'json').error(function() { cgm_preview_lockdown = false;})
				cgm_save_height = null;
				_url = null;
			});
		
		}
	});
}







// -----------------------------------------------------------------------------------------------
// --------------------------------------- Extra functions ---------------------------------------
// -----------------------------------------------------------------------------------------------

// update the cgm category list

function cgm_category_update_all(){

	var cgm_selectvar = '';
	var cgm_notselectvar = '';
	
	jQuery('#cgm-categorychecklist input').each(function(){
		if(jQuery(this).attr('checked') == 'checked'){
			cgm_selectvar += '<input id="categoryid'+jQuery(this).val()+'" type="checkbox" value="'+jQuery(this).val()+'" style="margin-right: 4px;">'+jQuery(this).parent().text()+'<br>';				
		} else {
			cgm_notselectvar += '<input id="categoryid'+jQuery(this).val()+'" type="checkbox" value="'+jQuery(this).val()+'" style="margin-right: 4px;">'+jQuery(this).parent().text()+'<br>';
		}
	});
	
	if(cgm_selectvar == ''){
		cgm_selectvar = cgm_notselectvar;
		cgm_notselectvar = '';
	}
	
	var cgm_select_array = new Array();
	jQuery('#cgm_image_list .object-category').each(function(){
		jQuery(this).find('input:checked').each(function(){
			cgm_select_array.push(jQuery(this).attr('id'));
		});
	
		jQuery(this).html(cgm_selectvar);
		
		for(var i=0; i<cgm_select_array.length;i++){
			jQuery(this).find('#'+cgm_select_array[i]).attr('checked','checked');
		}
		
		cgm_select_array = new Array();
	});
	
	
	jQuery('.cgm_categorygroup .cgm_categorychecklist_checkuplist').each(function(){
		jQuery(this).find('input:checked').each(function(){
			cgm_select_array.push(jQuery(this).attr('id'));
		});
	
		jQuery(this).html(cgm_selectvar);
		
		for(var i=0; i<cgm_select_array.length;i++){
			jQuery(this).find('#'+cgm_select_array[i]).attr('checked','checked');
		}
		
		cgm_select_array = new Array();
	});
	
	var cgm_selectvar = null;
	var cgm_notselectvar = null;
	
}



// check if it is the right metaboxes
function cgm_check_meta_boxes(tmp_value){
	if((tmp_value != null && (tmp_value.substr(0,4) == 'cgm-' || tmp_value == 'submitdiv' || tmp_value == 'postimagediv' || tmp_value == 'pur-postmeta')))	{
		return true;
	} else {
		return false;
	}
}

function cgm_dubblicate_object(tmp_this,tmp_id){
	var _url = COMPLETE_GALLERY_URL + 'frames/duplicate_post.php';

	var imagetmp = jQuery(tmp_this).parent().html(); 

	jQuery(tmp_this).parent().html('<img src="'+COMPLETE_GALLERY_URL+'images/wpspin_light.gif">'); 
	
	jQuery.post(_url,{post_id:tmp_id},function(data){
		alert(data.MSG);
		
		if(data.R == 'OK'){
			location.reload(true);
		}
		
		return false;								
	},'json').error(function() { alert("Error No data found");return false; })
	_url = null;
	imagetmp = null; 	
	return false;
}


// string settings tools -----------------------------------------------------
// clear up name
function cgm_clearUp_name_data(_tmp_name){
	var tmp_name;
	tmp_name = _tmp_name.replace('evt_','');
	tmp_name = tmp_name.replace(/__/g,'.');
	
	return tmp_name;
}

//check value
function cgm_clearUp_value_data(tmp_value){
	return cgm_isnumber_data(tmp_value);
}

// check if number
function cgm_isnumber_data(tmp_value){
	if(isNaN(tmp_value)){
		if(tmp_value.split('[').length > 1){
			return cgm_string_to_array_value(tmp_value);
		} else if(tmp_value.split('{').length > 1){
			return cgm_string_to_object_value(tmp_value);
		} else if(tmp_value == "true") {	
			return true;
		} else if(tmp_value == "false") {	
			return false;	
		} else {
			return tmp_value;
		}
	} else {
		return parseFloat(tmp_value);
	}
}

// create object from string
function cgm_change_string_to_object_by_dot(_tmp_name,_tmp_val){
	var tmp_name = cgm_clearUp_name_data(_tmp_name);
	var tmp_name_array = tmp_name.split('.');
	
	if(tmp_name_array.length == 2){
		if(!cgm_settings[tmp_name_array[0]]){
			cgm_settings[tmp_name_array[0]] = new Object();
		}
		cgm_settings[tmp_name_array[0]][tmp_name_array[1]] = cgm_clearUp_value_data(_tmp_val);
	} else if(tmp_name_array.length == 3){
		if(!cgm_settings[tmp_name_array[0]]){
			cgm_settings[tmp_name_array[0]] = new Object();
		}
		
		if(!cgm_settings[tmp_name_array[0]][tmp_name_array[1]]){
			cgm_settings[tmp_name_array[0]][tmp_name_array[1]] = new Object();
		}		
		
		cgm_settings[tmp_name_array[0]][tmp_name_array[1]][tmp_name_array[2]] = cgm_clearUp_value_data(_tmp_val);
	} else {
		if(tmp_name == 'region'){
			cgm_settings[tmp_name_array[0]] = _tmp_val;
		} else {
			cgm_settings[tmp_name_array[0]] = cgm_clearUp_value_data(_tmp_val);
		}
	}
	tmp_name = null;
	tmp_name_array = null;
	
}
// string to array
function cgm_string_to_array_value(_tmp_value){
	_tmp_value = _tmp_value.replace('[','');
	_tmp_value = _tmp_value.replace(']','');
	
	var tmp_value_array = _tmp_value.split(',');
	return tmp_value_array;
}

// string to object
function cgm_string_to_object_value(_tmp_value){
	var tmp_value_array_comma = new Array(); 
	var tmp_value_array = _tmp_value.split(',');
	var temp_object = new Object();
	var tmp_string = '';
	var first_time = true;
	var tmp_begin_object = false;
	var tmp_end_object = false;
	
	var array_level = new Array();

	for (x in tmp_value_array)
	{
		tmp_string = '';
		tmp_string = tmp_value_array[x];
		
		tmp_begin_object = false;
		tmp_end_object = false;
		
		for (i=0;i<=tmp_string.length ;i++)
		{
			if(tmp_string.charAt(i) == '{'){
				if(!tmp_begin_object){
					tmp_begin_object = true
				} else {
					first_time = false;
				}
			}
		
			if(tmp_string.charAt(i) == '}'){
				tmp_end_object = true
			}
		}
		
		tmp_string = tmp_string.replace('}','');
		tmp_string = tmp_string.replace('{','');
		
		tmp_value_array_comma = tmp_string.split(':');
		
		if(tmp_begin_object && !first_time){
			array_level.push(tmp_value_array_comma[0]);
			
			tmp_value_array_comma[0] = tmp_value_array_comma[1];
			tmp_value_array_comma[1] = tmp_value_array_comma[2];
			
		}
		first_time = false;
		

		tmp_value_array_comma[0] = tmp_value_array_comma[0].replace('{','');
		tmp_value_array_comma[1] = tmp_value_array_comma[1].replace('}','');		
		
		switch(array_level.length)
		{
			case 1:
				if(!temp_object[array_level[0]]){
  					temp_object[array_level[0]] = new Object();
  				}
  					
  				temp_object[array_level[0]][tmp_value_array_comma[0]] = tmp_value_array_comma[1];
  				break;
			case 2:
				if(!temp_object[array_level[0]][array_level[1]]){
  					temp_object[array_level[0]][array_level[1]] = new Object();
  				}

  				temp_object[array_level[0]][array_level[1]][tmp_value_array_comma[0]] = tmp_value_array_comma[1];
  				break;
			case 3:
				if(!temp_object[array_level[0]][array_level[1]][array_level[2]])
  					temp_object[array_level[0]][array_level[1]][array_level[2]] = new Object();
  					
  				temp_object[array_level[0]][array_level[1]][array_level[2]][tmp_value_array_comma[0]] = tmp_value_array_comma[1];			
  				break;	
			case 4:
				if(!temp_object[array_level[0]][array_level[1]][array_level[2]][array_level[3]])
  					temp_object[array_level[0]][array_level[1]][array_level[2]][array_level[3]] = new Object();
  					
  				temp_object[array_level[0]][array_level[1]][array_level[2]][array_level[3]][tmp_value_array_comma[0]] = tmp_value_array_comma[1];			
  				break;				
			case 5:
				if(temp_object[array_level[0]][array_level[1]][array_level[2]][array_level[3]][array_level[4]])
  					temp_object[array_level[0]][array_level[1]][array_level[2]][array_level[3]][array_level[4]] = new object(); 
  					
  				temp_object[array_level[0]][array_level[1]][array_level[2]][array_level[3]][array_level[4]][tmp_value_array_comma[0]] = tmp_value_array_comma[1];			
  				break;		
			default:
  				temp_object[tmp_value_array_comma[0]] = tmp_value_array_comma[1];
  				break;	
		}	
		
		if(tmp_end_object){
			array_level.pop();
		}
	}
	
	tmp_value_array_comma = null; 
	tmp_value_array = null; 
	tmp_string = null; 
	first_time = null; 
	tmp_begin_object = null; 
	tmp_end_object = null; 

	return temp_object;
}

function cgm_select_image_preview() {
	cgm_preview();
};