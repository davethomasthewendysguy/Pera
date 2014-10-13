// aktivste color wheel
function uh_activate_farbtastic(){
	jQuery(document).ready(function($){
		jQuery('.pop-farbtastic').each(function(i,o){
			$(this).farbtastic($(this).attr('rel')).hide();
		});	
		jQuery('.uh_post_color').click(function(e){
			var helper = $(this).parent().find('.pop-farbtastic');
			if(helper.is(':visible')){
				helper.slideUp();
				jQuery(this).addClass('show-colorpicker').removeClass('hide-colorpicker');
				if(uh_call_preview_function != ''){
					window[uh_call_preview_function]();
				}

			}else{
				helper.slideDown();
				jQuery(this).addClass('hide-colorpicker').removeClass('show-colorpicker');
			}
		});
		
		jQuery('.uh_post_color').mousedown(function(e){jQuery(this).parent().find('input').trigger('focus');});
	});
}

function uh_categorysort_pos(tmp_pos){

	var tmp_array = '';

	jQuery(tmp_pos+'_div #sortable li').each(function(){
		if(tmp_array != ''){
			tmp_array += ',';
		}
		
		tmp_array += jQuery(this).attr('datatmp');
	});
	
	jQuery(tmp_pos).val(tmp_array);
}



function uh_categorygroup_remove(tmp_this,tmp_type,tmp_name){
	if (confirm("Are you sure you want to delete this group")){
		jQuery(tmp_this).parent().parent().parent().parent().parent().remove();
		uh_categorygroup_ref(tmp_type,tmp_name);
	}
}

function uh_categorygroup_add(tmp_type,tmp_name){
	var cgm_selectvar = '';
	var cgm_notselectvar = '';
	
	var add_title = tmp_type+'_'+tmp_name+'_add';
	var add_location = tmp_type+'_'+tmp_name+'_list';
	var add_title_content = jQuery('#'+add_title).val();
	
	if(add_title_content != undefined && add_title_content != ''){
		jQuery('#cgm-categorychecklist input').each(function(){
			if(jQuery(this).attr('checked') == 'checked'){
				cgm_selectvar += '<input onChange="uh_categorygroup_ref(\''+tmp_type+'\',\''+tmp_name+'\');" id="categoryid'+jQuery(this).val()+'" type="checkbox" value="'+jQuery(this).val()+'" style="margin-right: 4px;">'+jQuery(this).parent().text()+'<br>';				
			} else {
				cgm_notselectvar += '<input onChange="uh_categorygroup_ref(\''+tmp_type+'\',\''+tmp_name+'\');" id="categoryid'+jQuery(this).val()+'" type="checkbox" value="'+jQuery(this).val()+'" style="margin-right: 4px;">'+jQuery(this).parent().text()+'<br>';
			}
		});
		
		if(cgm_selectvar == ''){
			cgm_selectvar = cgm_notselectvar;
			cgm_notselectvar = '';
		}
		
		var cgm_return_stirng = '<span style="margin-top: 20px; display: block;"><table><tr><td style="width:100%">';
			cgm_return_stirng += '<input  onkeyup="uh_categorygroup_ref_key(\''+tmp_type+'\',\''+tmp_name+'\')"  class="uh_post_input" value="'+add_title_content+'" >';
			cgm_return_stirng += '</td><td>';	
			cgm_return_stirng += '<input type="submit" value="Remove" onclick="uh_categorygroup_remove(this,\''+tmp_type+'\',\''+tmp_name+'\');return false;" class="button-secondary" style="margin-left: 10px; margin-right: -2px;">';
			cgm_return_stirng += '</td></tr><tr><td colspan="2"><div class="cgm_categorychecklist_checkuplist" style="width:100%;max-height:100px;overflow: auto;">';
			cgm_return_stirng += cgm_selectvar;
			cgm_return_stirng += '</div></td></tr></table></span>';
			
		jQuery('#'+add_location).append(cgm_return_stirng);
		uh_categorygroup_ref(tmp_type,tmp_name);
	} else {
		alert('Please input a title');
	}
	cgm_return_stirng = '';
	add_title_content = '';
	jQuery('#'+add_title).val('');
}

var uh_group_ref_time = '';

function uh_categorygroup_ref_key(tmp_type,tmp_name){
	if(uh_group_ref_time != ''){
			window.clearTimeout(uh_group_ref_time);
	}
	
	uh_group_ref_time = setTimeout(function() {
		uh_categorygroup_ref(tmp_type,tmp_name)
	},1250);
	
}


function uh_categorygroup_ref(tmp_type,tmp_name){

	var cgm_save_array_tmp = new Array();


	jQuery('#'+tmp_type+'_'+tmp_name+'_list span').each(function(){
		var cgm_select_array = new Array();
		var cgm_title_name = jQuery(this).find('.uh_post_input').val();
		
		jQuery(this).find('input:checked').each(function(){
			cgm_select_array.push(jQuery(this).val());
		});
		
		cgm_save_array_tmp.push(new Object({name:cgm_title_name,data:cgm_select_array}))	
	});
	
	jQuery('#'+tmp_type+'_'+tmp_name).val(encodeURI(JSON.stringify(cgm_save_array_tmp, null, 2)));
	
	cgm_preview();
	
}


function uh_template_changelist(tmp_this,tmp_slider,tmp_adr){
	var cgm_themes_changeto = jQuery(tmp_this).val();
	if(cgm_themes_changeto == 'custom'){
		uh_template_showmenu_boxes(true); 
	} else {
		uh_template_showmenu_boxes(false);
	}
	
	if(cgm_themes_changeto != '' && cgm_themes_changeto != 'custom'){
			var _url = tmp_adr + '/frames/frame_theme_data.php';
			jQuery.post(_url,{tname:cgm_themes_changeto,
							  tslider:tmp_slider,
							  tsettings:jQuery('#cgm_hidden_settings').val(),
						      tstatus:'loaddata'},function(data){
								  
				  if(data.R == 'OK'){
				  	  uh_template_loadlist(data.DATA);
				  	  cgm_preview();
				  	  
				  } 
			},'JSON');
	}
}

var uh_template_object_list1 = '';
var uh_template_object_list2 = '';
var uh_template_object_list3 = '';
var uh_template_object_list4 = '';

function uh_template_loadlist(tmp_object){

	uh_template_resetfn();
	
	var cgm_temp_data = '';
	
	for (uhx in tmp_object)
	{
		if(uhx.substring(0,13) != 'templatetype_' && uhx != 'filterscategory'){
		
			cgm_temp_data = jQuery('[name="cgm_'+uhx+'"]');
		
			if(jQuery(cgm_temp_data).attr('class') == 'uh_post_color show-colorpicker'){
				jQuery(cgm_temp_data).val(tmp_object[uhx]);
				jQuery(cgm_temp_data).css({'backgroundColor':tmp_object[uhx],'color':'#000000'});
			} else if(jQuery(cgm_temp_data).attr('type') == 'radio'){
				jQuery(cgm_temp_data).each(function(){
					if(tmp_object[uhx] == true || tmp_object[uhx] == 'true'){
						if(jQuery(this).val() == 'true'){
							jQuery(this).attr('checked','checked');
						} else {
							jQuery(this).removeAttr('checked');
						}
					} else {
						if(jQuery(this).val() == 'false'){
							jQuery(this).attr('checked','checked');
						} else {
							jQuery(this).removeAttr('checked');
						}
					}	
				});
			} else {
				jQuery(cgm_temp_data).val(tmp_object[uhx]);
			}	
		}
	}
}

function uh_template_resetfn(){
	jQuery('#cgm_data_set').find('.uh_groupClass').each(function(){
		if(jQuery(this).attr('id') != '' && jQuery(this).attr('id') != 'group_theme_settings'){
			jQuery(this).find('input').each(function(){
				if(jQuery(this).attr('name')  != undefined){
				
					if(jQuery(this).attr('class') == 'uh_post_color show-colorpicker'){
						jQuery(this).val('#');
						jQuery(this).css({'backgroundColor':'#ffffff','color':'#000000'});
					} else if(jQuery(this).attr('type') == 'radio'){
						if(jQuery(this).val() == 'true'){
							jQuery(this).removeAttr('checked');
						} else {
							jQuery(this).attr('checked','checked');
						}
					} else {
						jQuery(this).val('')
					}
				}
			});
			jQuery(this).find('select').each(function(){
				if(jQuery(this).attr('name') != undefined){
					jQuery(this).val('');
				}
			});		
		}
	});
	jQuery('#cgm_filterscategory_list').html('');
}


function uh_template_delete(tmp_type,tmp_slider,tmp_id,tmp_adr){
	var cgm_themes_changeto = jQuery('#'+tmp_type+'_templatetypelistdelete_'+tmp_slider).val();
	
	//cgm_template_delete_buttons
	if(cgm_themes_changeto != '' && !uh_template_loading_pause){
		uh_template_loading_pause = true;
		uh_template_button_save = jQuery('#cgm_template_delete_buttons').html();
		jQuery('#cgm_template_delete_buttons').html('Loading... please wait');
	
		if (confirm("Are you sure you want to delete "+jQuery('#'+tmp_type+'_templatetypelistdelete_'+tmp_slider).val()+"?")){
		
			var _url = tmp_adr + '/frames/frame_theme_data.php';
			jQuery.post(_url,{tname:cgm_themes_changeto,
							  tslider:tmp_slider,
							  tsettings:jQuery('#cgm_hidden_settings').val(),
						      tstatus:'delete'},function(data){
								  
				  if(data.R == 'OK'){
					 	alert(data.MSG);
						jQuery('#'+tmp_type+'_templatetypelistdelete_'+tmp_slider).val('');
						jQuery('#cgm_template_delete_buttons').html(uh_template_button_save);
						jQuery("#"+tmp_type+"_templatetypelistdelete_"+tmp_slider+" option[value='"+cgm_themes_changeto+"']").remove();
						jQuery("#"+tmp_type+"_templatetypelistsave_"+tmp_slider+" option[value='"+cgm_themes_changeto+"']").remove();
						
						
						if(jQuery('#'+tmp_type+'_templatetype_'+tmp_slider).val() == cgm_themes_changeto){
							if(jQuery("#"+tmp_type+"_templatetype_"+tmp_slider+" option[value='custom']").val() == 'custom'){
								jQuery("#"+tmp_type+"_templatetype_"+tmp_slider+" option[value='"+cgm_themes_changeto+"']").remove();
								uh_template_showmenu_boxes(true);
								jQuery("#"+tmp_type+"_templatetype_"+tmp_slider).val('custom');
							} else {
								uh_template_showmenu_boxes(false);
								jQuery("#"+tmp_type+"_templatetype_"+tmp_slider+" option[value='"+cgm_themes_changeto+"']").remove();
								jQuery("#"+tmp_type+"_templatetype_"+tmp_slider).val('');
							}
						} else {
								jQuery("#"+tmp_type+"_templatetype_"+tmp_slider+" option[value='"+cgm_themes_changeto+"']").remove();	
						}

					  uh_template_goto(tmp_id,2,0);
				  } else if(data.R == 'ERR'){
					  alert(data.MSG);
				  }
				  jQuery('#cgm_template_delete_buttons').html(uh_template_button_save);
				  uh_template_loading_pause = false;
			},'JSON');
		} else {
			jQuery('#cgm_template_delete_buttons').html(uh_template_button_save);
			uh_template_loading_pause = false;
		}
	}
}

function uh_template_saveoverwrite(tmp_this,tmp_id,tmp_adr,tmp_slider){
	var cgm_themes_changeto = jQuery(tmp_this).val();
	if(cgm_themes_changeto != '' && !uh_template_loading_pause){
		uh_template_loading_pause = true;
		
		uh_template_button_save = jQuery('#cgm_template_save_buttons').html();
		jQuery('#cgm_template_save_buttons').html('Loading... please wait');
		
		if (confirm("Are you sure you want to overwrite "+jQuery(tmp_this).val()+"?")){
		var _url = tmp_adr + '/frames/frame_theme_data.php';
		jQuery.post(_url,{tname:jQuery(tmp_this).val(),
						  tsettings:jQuery('#cgm_hidden_settings').val(),
						  tslider:tmp_slider,
					      tstatus:'savewriteower'},function(data){
							  
			  if(data.R == 'OK'){
				  alert(data.MSG);
				  uh_template_goto(tmp_id,1,0);
			  } else if(data.R == 'ERR'){
				  alert(data.MSG);
			  }
			  jQuery(tmp_this).val('');
			  jQuery('#cgm_template_save_buttons').html(uh_template_button_save);
			  uh_template_loading_pause = false;
		},'JSON');
		} else {
			  jQuery('#cgm_template_save_buttons').html(uh_template_button_save);
			  uh_template_loading_pause = false;
		}
		jQuery(tmp_this).val('');
	} else {
		jQuery(tmp_this).val('');	
	}
}

var uh_template_loading_pause = false;
var uh_template_button_save = '';

function uh_template_save(tmp_id,tmp_adr,tmp_slider){
	cgm_generate_settings();

	if(!uh_template_loading_pause && jQuery('#uh_post_input_savenew_files').val() != '' && jQuery('#cgm_hidden_settings').val() != ''){
		uh_template_loading_pause = true;
		
		uh_template_button_save = jQuery('#cgm_template_save_buttons').html();
		jQuery('#cgm_template_save_buttons').html('Loading... please wait');
		
		var _url = tmp_adr + '/frames/frame_theme_data.php';
		jQuery.post(_url,{tname:jQuery('#uh_post_input_savenew_files').val(),
						  tsettings:jQuery('#cgm_hidden_settings').val(),
						  tslider:tmp_slider,
						  cgm_post_id:cgm_post_id,
					      tstatus:'savenewfile'},function(data){
							  
			  if(data.R == 'OK'){
			  	  jQuery('#cgm_templatetypelistdelete_'+tmp_slider).html('<option value="">-- Select Template --</option>'+data.DATA);
			  	  jQuery('#cgm_templatetypelistdelete_'+tmp_slider).val('');
			  
			  	  jQuery('#cgm_templatetypelistsave_'+tmp_slider).html('<option value="">-- Select Template --</option>'+data.DATA);
			  	  jQuery('#cgm_templatetypelistsave_'+tmp_slider).val('');
			  	  
			  	  
			  	  
			  	  var tmpp_selectlist = jQuery('#cgm_templatetype_'+tmp_slider+' option:last-child').val();
			  	  var tmpp_selectlist_current = jQuery('#cgm_templatetype_'+tmp_slider).val();
			  	  
			  	  if(tmpp_selectlist == 'custom'){
				  	  jQuery('#cgm_templatetype_'+tmp_slider).html('<option value="">-- Select Template --</option>'+data.DATA+'<option value="custom">Custom</option>');
			  	  } else {
				  	  jQuery('#cgm_templatetype_'+tmp_slider).html('<option value="">-- Select Template --</option>'+data.DATA);	  
			  	  }
			  	  
			  	  jQuery('#cgm_templatetype_'+tmp_slider).val(tmpp_selectlist_current);
			  	  
			  	  jQuery('#uh_post_input_savenew_files').val('');
			  	  
			  	  
			  	  
				  alert(data.MSG);
				  uh_template_goto(tmp_id,1,0);
				  
			  } else if(data.R == 'ERR'){
				  alert(data.MSG);
				  
			  }
			  jQuery('#cgm_template_save_buttons').html(uh_template_button_save);
			  uh_template_loading_pause = false;
		},'JSON');
	} else if(jQuery('#uh_post_input_savenew_files').val() != ''){
		alert('Pleas enter a file name')
	}
}





function uh_template_showmenu_boxes(cgm_show_hide){
	jQuery('#cgm_data_set .uh_post_div_col .uh_post_div,#cgm_data_set .uh_post_div_col .uh_groupClass').each(function(){
			if(jQuery(this).attr('id') != 'uh_post_theme_h4' && jQuery(this).attr('id') != 'group_theme_settings'){
				if(cgm_show_hide && jQuery(this).attr('class') == 'uh_post_div'){
					jQuery(this).show();
				} else {
					jQuery(this).hide();
				}
			}
			
			
	});
}

function uh_template_goto(tmp_id,tmp_from,tmp_to){
	//group_theme_settings
	jQuery('#group_'+tmp_id +' span:eq('+tmp_from+')').slideUp("slow", function() {
		jQuery('#group_'+tmp_id +' span:eq('+tmp_from+')').hide();
		jQuery('#group_'+tmp_id +' span:eq('+tmp_to+')').css('opacity',1);
		jQuery('#group_'+tmp_id +' span:eq('+tmp_to+')').show("slow");
	});
	

	
	
	
	/*jQuery('#group_'+tmp_id +' span:eq('+tmp_from+')').animate({
    opacity: 0,
    height: 'toggle'
  }, 500,function(){
	jQuery('#group_'+tmp_id +' span:eq('+tmp_to+')').animate({
    opacity: 1,
    height: 'toggle'
  }, 500);   
  }); */
	
  if(tmp_to == 0){
  	jQuery('.uh_post_theme_h4').html('Template Settings');  
  } else if(tmp_to == 1){
  	jQuery('.uh_post_theme_h4').html('Template Settings -- Save Templates'); 
  } else if(tmp_to == 2){
  	jQuery('.uh_post_theme_h4').html('Template Settings -- Delete Templates');
  }
}

function uh_check_color(tmp_this){

var strings = jQuery(tmp_this).val();
var string = '';
var i = 0;
while (i <= strings.length){
    character = strings.charAt(i);
	if(isNaN(character * 1) && character != 'a' && character != 'b' && character != 'c' && character != 'd' && character != 'e' && character != 'f'){
	
		if(character == '#' && i == 0 ) {
			character = '#';
		} else {
			character = 'f';
		}
	}
	
	if(i < 7){
		string += character;
	}
    i++;
}



	if(string == '' || string == '#'){
		jQuery(tmp_this).val('#');
	
		jQuery(tmp_this).css('backgroundColor','#ffffff')
	} else {
		jQuery(tmp_this).val(string);
	}
}



function uh_show_hide_group(tmp_this,tmp_id){
	jQuery(document).ready(function($){
		if(tmp_id != ''){
			var cgw_group = jQuery('#group_'+tmp_id).is(":hidden");
			
			jQuery.post(uh_form_URL+'frames/save_group_visible.php',{tmp_id:tmp_id,cgw_group_hide:cgw_group});	
			
			if(jQuery(tmp_this).find('div').attr('class') == 'uh_arrow_up'){
				jQuery(tmp_this).find('div').attr('class','uh_arrow_down');
			} else {
				jQuery(tmp_this).find('div').attr('class','uh_arrow_up');
			}
			
			
			if(cgw_group){
				jQuery('#group_'+tmp_id).slideDown();
			} else {
				jQuery('#group_'+tmp_id).slideUp();
			}
		}
	});
}

//check numbers
function uh_numbersonly(myfield, e, dec)
{
	var key;
	var keychar;

	if (window.event)
  		key = window.event.keyCode;
	else if (e)
   		key = e.which;
	else
   		return true;
	keychar = String.fromCharCode(key);

	// control keys
	if ((key==null) || (key==0) || (key==8) || 
    	(key==9) || (key==13) || (key==27) )
   		return true;

	// numbers
	else if (((".-0123456789").indexOf(keychar) > -1))
   		return true;

	// decimal point jump
	else if (dec && (keychar == "."))
   	{
   		myfield.form.elements[dec].focus();
   		return false;
   	}
	else
   		return false;
}


//var uh_timer_chekker;

// fade ud help
/*function uh_hide_help(evt_object){
	jQuery(document).ready(function($){
		if(uh_timer_chekker){
			clearTimeout(uh_timer_chekker);
		}
		
		jQuery('#referent_pointer_'+jQuery(evt_object).attr('name')).parent().parent().fadeTo('slow', 0 , function(){
			jQuery(this).hide();
		});
	});
}*/

// fade in help
function uh_activate_help(evt_object,evt_title,evt_txt){
	jQuery(document).ready(function($){
		var content = '';
		if(evt_txt && evt_title){
			content += '<span class="uh_help_h3">'+evt_title+'</span>';
			content += '<p>'+evt_txt+'</p><div id="referent_pointer_'+jQuery(evt_object).attr('ref')+'" style="display:none"></div>';
			$('.wp-pointer').fadeTo('slow', 0).hide();
           	$(evt_object).pointer({
   			    content: content,
        		position: {
        			edge:'left',
					my: 'left top',
					at: 'right top',
					offset: '1 -55px'
        		}
      		}).pointer('open');
      			
			jQuery('#referent_pointer_'+jQuery(evt_object).attr('ref')).parent().parent().css({ opacity: 0 });
      		jQuery('.wp-pointer-arrow').hide();
      		jQuery('#referent_pointer_'+jQuery(evt_object).attr('ref')).parent().parent().fadeTo('slow', 1);
		}
	});
}