jQuery(document).ready(function($){
	if( $('#cgm-insert-tool-trigger').length > 0 && $('#cgm-insert-tool').length > 0){
		$('#cgm-insert-tool-trigger').click(function(e){
			$('#cgm-insert-tool').css('top', $(document).scrollTop() );
			$('#cgm_chart_selected').val('').change();	
			$('#cgm-insert-tool').fadeIn();		
		});
		
		$('#cgm-insert-tool').find('.cgm-close-icon-a').click(function(e){
			$('#cgm-insert-tool').fadeOut();	
		});
	}
});

/* CSSEditor */
jQuery(document).ready(function($){
	$('#cgm_chart_selected').change(function(){
		var html_backup;
		if($('#cgm_chart_selected').val()){
			jQuery('#preview_gallery_cgm').fadeTo('fast', 0.0);
			jQuery('#data_loaded_cgm').fadeTo('fast', 0.0, function() {
				html_backup = jQuery('#data_loaded_cgm').html();
				
				jQuery('#preview_gallery_cgm').html('<img src="'+COMPLETE_GALLERY_URL+'images/loader.gif">');
				jQuery('#data_loaded_cgm').html('<img src="'+COMPLETE_GALLERY_URL+'images/loader.gif">');
				
				jQuery('#preview_gallery_cgm').fadeTo('fast', 1.0);
				jQuery('#data_loaded_cgm').fadeTo('fast', 1.0, function() {
					_url = COMPLETE_GALLERY_URL+'frames/load_tinmce_button_data.php';	  

					jQuery.post(_url,{post_id:$('#cgm_chart_selected').val()},function(data){
						jQuery('#preview_gallery_cgm').fadeTo('fast', 0.0);
						jQuery('#data_loaded_cgm').fadeTo('fast', 0.0, function() {
							if(data.R == 'OK'){
								jQuery('#data_loaded_cgm').html(html_backup);
								html_backup = null
								if(data.SHORTCODE){
									jQuery('#cgm_shortcode').html(data.SHORTCODE);
								} else {
									jQuery('#cgm_shortcode').html('');
								}


								
								if(data.PREVIEW){
									jQuery('#preview_gallery_cgm').html('<div style="background-image:url(\''+data.PREVIEW[0]+'\');"></div>');
									
									jQuery('#cgm_carID').append(data.CATEGORY);
									
									
									jQuery('#preview_gallery_cgm').fadeTo('fast', 1.0);
								} else {
									jQuery('#preview_gallery_cgm').fadeTo('fast', 0.0);
								}
								
								jQuery('#data_loaded_cgm').fadeTo('fast', 1.0);

							} else {
								alert(data.MSG);
							}
						});	
					},"json");
				});
			});	
		} else {
			jQuery('#preview_chart_cgm').fadeTo('fast', 0.0);
			jQuery('#data_loaded_cgm').fadeTo('fast', 0.0);
		}

	});
	$('#cgm_chart_selected').val('').change();	
});

function cgm_input_change_value(){
	jQuery(document).ready(function($){
		var cgm_border = jQuery('#cgm_border').val();
		var cgm_vspace = jQuery('#cgm_vspace').val();
		var cgm_hspace = jQuery('#cgm_hspace').val();
		
		var str = '';
	
		if(cgm_border != '' && !isNaN(cgm_border)){
			str += 'border: '+cgm_border+'px solid black;';
		}	
		if(cgm_vspace != '' && cgm_hspace == '' && !isNaN(cgm_vspace)){
			str += 'margin-top: '+cgm_vspace+'px; margin-bottom: '+cgm_vspace+'px;';
		} else if(cgm_vspace == '' && cgm_hspace != '' && !isNaN(cgm_hspace)){
			str += 'margin-right: '+cgm_hspace+'px; margin-left: '+cgm_hspace+'px;';
		} else if(cgm_vspace != '' && cgm_hspace != '' && !isNaN(cgm_hspace) && !isNaN(cgm_vspace)){
			if(cgm_vspace == cgm_hspace){
				str += 'margin: '+cgm_hspace+'px;';
			} else {
				str += 'margin: '+cgm_vspace+'px '+cgm_hspace+'px;';
			}
		}
	
		jQuery('#cgm_style').val(str);
		
		cgm_border = null;
		cgm_vspace = null;
		cgm_hspace = null;
		str = null;
	
	});
}


function insert_cgm_shortcode(){
	jQuery(document).ready(function($){
    	var str = '';
		var str_class = '';
		var str_style = '';
		var str_radio_class = ''; 
		
		var cgm_layout = jQuery('#cgm_layout').val();
		var cgm_sort = jQuery('#cgm_sort').val();
		var cgm_sortDir = jQuery('#cgm_sortDir').val();
		var cgm_carID = jQuery('#cgm_carID').val();	
		
		
		
		
		str = jQuery('#cgm_shortcode').html();
		str = str.replace(']','');
		
		str_class = jQuery('#cgm_class').val();
		str_style = jQuery('#cgm_style').val();
		
		str_radio_class = jQuery("#cgm_radio_list input[name=cgm_align]:checked").val();

		if(str_class != ''){
			str_class = str_class + ' ';
		}
		
		str += ' class="'+str_class+str_radio_class+ '" ';

		if(str_style != ''){
			str += ' style="' +str_style+'" ';
		}	
		
		
		if(cgm_layout != ''){
			str += ' layout="' +cgm_layout+'" ';
		}
		
		if(cgm_sort != ''){
			str += ' sort="' +cgm_sort+'" ';
		}
		
		if(cgm_sortDir != ''){
			str += ' sortDir="' +cgm_sortDir+'" ';
		}
		
		if(cgm_carID != ''){
			str += ' catID="' +cgm_carID+'" ';
		}
		
		str += ']';

		if(str){
			send_to_editor(str);
			var ed;
			if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
				ed.setContent(ed.getContent());
			}
			$('#cgm-insert-tool').fadeOut();
		} else {
			alert('Pleas choose a gallery');
		}
		
    	str = null;
		str_class = null;
		str_style = null;
		str_radio_class = null; 		
		
	});
}
