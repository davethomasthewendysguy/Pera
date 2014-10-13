var cgm_touch_data = new Array();
var cgm_touch_click = false;
var cgm_touch_move = false;

function cgm_drawTouch_gallery(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL,debug,tmp_extra){
	cgm_COMPLETE_GALLERY_URL = tmp_COMPLETE_GALLERY_URL;
	var ver = cgm_getInternetExplorerVersion();
	
	if (ver > -1 && ver < 9.0) {
		jQuery('#completegallery'+tmp_id).html('Sorry this slide is not ie8 compatible (needs html5 css3)');
		jQuery('#cgm_preview').html('Sorry this slide is not ie8 compatible (needs html5 css3)');
	} else if(debug){
		jQuery('#cgm_preview').fadeTo('slow',0,function(){
			setTimeout(function() {
				cgm_drawTouch_gallery2(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL);
			},100);
		});
		cgm_fn_touch_autocorrect('#cgm_slidersize','#cgm_ts_width','#cgm_ts_height');
	} else {
		jQuery(document).ready(function($){
			var _url = tmp_COMPLETE_GALLERY_URL+'frames/frame.get_data.php';	
			
			if( window.location.protocol == 'https:'){
				tmp_COMPLETE_GALLERY_URL=tmp_COMPLETE_GALLERY_URL.replace("http","https"); 
			} else {
				tmp_COMPLETE_GALLERY_URL=tmp_COMPLETE_GALLERY_URL.replace("https","http"); 
			}
			
			
			jQuery.post(_url,{gallery_count_id:tmp_id,post_id:tmp_post_id},function(data){
				if(data.R == 'OK'){
					
					jQuery('#completegallery'+tmp_id).fadeTo('slow',0,function(){
						jQuery('#completegallery'+tmp_id).html(data.RETURN_DATA);
						
						cgm_loadcss(data.CSS, "css");
						
						setTimeout(function() {
							cgm_drawTouch_gallery2(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL);	
						},100);
					});
				}
			},'json');
			
			_url = null;
		});
	}
	
	ver = null;
}

function cgm_drawTouch_gallery2(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL){
 	if(typeof(tmp_settings)=='string'){
		var tmp_set_object = new Object();
			tmp_settings = JSON.parse(decodeURI(tmp_settings));
	
		jQuery(document).ready(function($){
				if(typeof(tmp_settings.cgm_pageinShow) =='boolean' && tmp_settings.cgm_pageinShow == false){
					tmp_set_object.createPagination = false;
				} else {
					tmp_set_object.createPagination = true;
					tmp_set_object.pagination = '.pagination'+tmp_id;
				}
		
				if(typeof(tmp_settings.cgm_imageprslide)=='number'){
					tmp_set_object.slidesPerSlide = tmp_settings.cgm_imageprslide;
				} else {
					tmp_set_object.slidesPerSlide = 1;
				}
		
				if(typeof(tmp_settings.cgm_sliderloop) =='boolean' && tmp_settings.cgm_sliderloop == false){
					tmp_set_object.loop = false;
				} else {
					tmp_set_object.loop = true;
				}
				
				if(typeof(tmp_settings.cgm_sliderAutoPlay) =='boolean' && tmp_settings.cgm_sliderAutoPlay == true){
					if(typeof(tmp_settings.cgm_sliderAutoPlayTime)=='number' && tmp_settings.cgm_sliderAutoPlayTime > 100){
						tmp_set_object.autoPlay = tmp_settings.cgm_sliderAutoPlayTime;
					}
				}
				
				tmp_set_object.onTouchStart  = function() {cgm_fn_touch_start(tmp_id)};
				tmp_set_object.onTouchMove  = function() {cgm_fn_touch_move(tmp_id)};		
		
				if(typeof(tmp_settings.cgm_sliderdirection)=='string'){
					tmp_set_object.mode = tmp_settings.cgm_sliderdirection;
				}
		
				if(typeof(tmp_settings.cgm_slidertype)=='string'){
					if(tmp_settings.cgm_slidertype == 'freemode' ){
						tmp_set_object.freeMode = true;
						tmp_set_object.freeModeFluid = false;
					} else if(tmp_settings.cgm_slidertype == 'freemodefloat'){
						tmp_set_object.freeMode = true;
						tmp_set_object.freeModeFluid = true;
					} else {
						tmp_set_object.freeMode = false;
						tmp_set_object.freeModeFluid = false;
					}
				}
				
				cgm_touch_data[tmp_id] = jQuery('.swiper'+tmp_id).swiper(tmp_set_object);
				
				tmp_set_object = null;
				
				jQuery('.pagination'+tmp_id+' span').click(function(){
					if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
						cgm_touch_data[tmp_id].stopAutoPlay();
						cgm_touch_data[tmp_id].swipeTo(jQuery(this).index(),1600,null);
					}
				});	
				
				
				
			if(tmp_settings.cgm_mouseEventClick == 'prettyPhoto'){
			
				var cgm_tmp_pretty_photo = new Object();
				
				if(typeof(tmp_settings.cgm_pretty.theme)=='string'){
					cgm_tmp_pretty_photo.theme = tmp_settings.cgm_pretty.theme;
				}
				
				if(typeof(tmp_settings.cgm_pretty.thumbnails) =='boolean' && tmp_settings.cgm_pretty.thumbnails == false){
					cgm_tmp_pretty_photo.gallery_markup = ' ';
				}
				
				if(typeof(tmp_settings.cgm_pretty.thumbnails) =='string' && tmp_settings.cgm_pretty.thumbnails == 'false'){
					cgm_tmp_pretty_photo.gallery_markup = ' ';
				}

				cgm_tmp_pretty_photo.show_title = tmp_settings.cgm_pretty.showtitle;	
				cgm_tmp_pretty_photo.autoplay_slideshow = tmp_settings.cgm_pretty.autoplayslideshow;
				cgm_tmp_pretty_photo.deeplinking = tmp_settings.cgm_pretty.deeplinking;			
			
				if(typeof(tmp_settings.cgm_pretty.opacity)=='number'){
					cgm_tmp_pretty_photo.opacity = tmp_settings.cgm_pretty.opacity;
				}	
			
				if(typeof(tmp_settings.cgm_pretty.slideshow)=='number'){
					cgm_tmp_pretty_photo.slideshow = tmp_settings.cgm_pretty.slideshow;
				}
				
				if(typeof(tmp_settings.cgm_pretty.animationspeed)=='string'){
					cgm_tmp_pretty_photo.animation_speed = tmp_settings.cgm_pretty.animationspeed;
				}	
				
				cgm_tmp_pretty_photo.allow_resize = true;
				cgm_tmp_pretty_photo.default_width = 700;
				cgm_tmp_pretty_photo.default_height = 544;
				
				jQuery(".swiper"+tmp_id+" a[rel^='prettyPhoto']").prettyPhoto(cgm_tmp_pretty_photo);
				
				cgm_tmp_pretty_photo = null;
			}		
			
			
			var cgm_temp_img = new Image();
			var cgm_temp_patt=/\url|\(|\"|\"|\'|\)/g;
			var cgm_temp_url= jQuery(".swiper"+tmp_id+" .swiper-wrapper div:first-child").css("background-image");
			
			if(cgm_temp_url != undefined && cgm_temp_url != ''){
				cgm_temp_url = cgm_temp_url.replace(cgm_temp_patt,'');
				
				jQuery(cgm_temp_img).load(function (){
				
					if(typeof(tmp_settings.cgm_sliderAutoPlay) =='boolean' && tmp_settings.cgm_sliderAutoPlay == true){
						if(typeof(tmp_settings.cgm_sliderAutoPlayTime)=='number' && tmp_settings.cgm_sliderAutoPlayTime > 100){
							cgm_touch_data[tmp_id].stopAutoPlay();
							cgm_touch_data[tmp_id].startAutoPlay();
						}
					}
				
				
					jQuery('#cgm_preview').fadeTo('slow',1);
					jQuery('#completegallery'+tmp_id).fadeTo('slow',1);
				}).error(function(){}).attr('src', cgm_temp_url);
				
				
			}
		});
	}
}

function cgm_fn_touch_start(tmp_id){
 	cgm_touch_click = true;
 	cgm_touch_move = false;
}
function cgm_fn_touch_move(tmp_id){
 	cgm_touch_move = true;
}

document.addEventListener("fullscreenchange", function () {
	if(document.fullscreen){
		jQuery('.cgm-fullscreen').removeClass('cgm_fullscreen_open')
		jQuery('.cgm-fullscreen').addClass('cgm_fullscreen_close');
		document.documentElement.style.overflow = 'hidden';	 // firefox, chrome
		document.body.scroll = "no";	// ie only
		jQuery('#wpadminbar').hide();	
	} else {
		jQuery('.cgm-fullscreen').addClass('cgm_fullscreen_open')
		jQuery('.cgm-fullscreen').removeClass('cgm_fullscreen_close');
		document.documentElement.style.overflow = 'auto';	 // firefox, chrome
		document.body.scroll = "yes";	// ie only
		jQuery('#wpadminbar').show();
		jQuery('.cgm-fullscreen_activate_item').removeClass("cgm-fullscreen_activate_item");
		jQuery('.cgm-fullscreen_activate').removeClass("cgm-fullscreen_activate");
	}

	if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
		cgm_touch_data[tmp_id].swiperResizeUpdate();
	}
}, false);

document.addEventListener("mozfullscreenchange", function () {
	if(document.mozFullScreen){
		jQuery('.cgm-fullscreen').removeClass('cgm_fullscreen_open')
		jQuery('.cgm-fullscreen').addClass('cgm_fullscreen_close');
		document.documentElement.style.overflow = 'hidden';	 // firefox, chrome
		document.body.scroll = "no";	// ie only
		jQuery('#wpadminbar').hide();	
	} else {
		jQuery('.cgm-fullscreen').addClass('cgm_fullscreen_open')
		jQuery('.cgm-fullscreen').removeClass('cgm_fullscreen_close');
		document.documentElement.style.overflow = 'auto';	 // firefox, chrome
		document.body.scroll = "yes";	// ie only
		jQuery('#wpadminbar').show();
		jQuery('.cgm-fullscreen_activate_item').removeClass("cgm-fullscreen_activate_item");
		jQuery('.cgm-fullscreen_activate').removeClass("cgm-fullscreen_activate");
	}

	if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
		cgm_touch_data[tmp_id].swiperResizeUpdate();
	}
}, false);

document.addEventListener("webkitfullscreenchange", function () {
	if(document.webkitIsFullScreen){
		jQuery('.cgm-fullscreen').removeClass('cgm_fullscreen_open')
		jQuery('.cgm-fullscreen').addClass('cgm_fullscreen_close');
		document.documentElement.style.overflow = 'hidden';	 // firefox, chrome
		document.body.scroll = "no";	// ie only
		jQuery('#wpadminbar').hide();	
	} else {
		jQuery('.cgm-fullscreen').addClass('cgm_fullscreen_open')
		jQuery('.cgm-fullscreen').removeClass('cgm_fullscreen_close');
		document.documentElement.style.overflow = 'auto';	 // firefox, chrome
		document.body.scroll = "yes";	// ie only
		jQuery('#wpadminbar').show();
		jQuery('.cgm-fullscreen_activate_item').removeClass("cgm-fullscreen_activate_item");
		jQuery('.cgm-fullscreen_activate').removeClass("cgm-fullscreen_activate");
	}

	if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
		cgm_touch_data[tmp_id].swiperResizeUpdate();
	}
}, false);



function cgm_fn_fullscreen(tmp_this,tmp_id,tmp_fullscreen) {
	
	if(tmp_fullscreen == '2'){
		var tmp_e = tmp_this;
		if (cgm_RunPrefixMethod(document, "FullScreen") || cgm_RunPrefixMethod(document, "IsFullScreen")) {
			cgm_RunPrefixMethod(document, "CancelFullScreen");	
		}else {
			cgm_RunPrefixMethod(tmp_e.parentNode, "RequestFullScreen");
		} 
		tmp_e = null;
	} else {
		if(jQuery(tmp_this).hasClass('cgm_fullscreen_open')){
			jQuery(tmp_this).removeClass('cgm_fullscreen_open')
			jQuery(tmp_this).addClass('cgm_fullscreen_close');
			document.documentElement.style.overflow = 'hidden';	 // firefox, chrome
			document.body.scroll = "no";	// ie only		
			jQuery('#wpadminbar').hide();	
		} else {
			jQuery(tmp_this).addClass('cgm_fullscreen_open')
			jQuery(tmp_this).removeClass('cgm_fullscreen_close');
			document.documentElement.style.overflow = 'auto';	 // firefox, chrome
			document.body.scroll = "yes";	// ie only
			jQuery('#wpadminbar').show();
		}
	}

	jQuery(tmp_this).parent().find('.swiper-wrapper .swiper-slide').each(function(){
		jQuery(this).toggleClass("cgm-fullscreen_activate_item");
	})

	jQuery(tmp_this).parent().toggleClass("cgm-fullscreen_activate");
	if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
		cgm_touch_data[tmp_id].swiperResizeUpdate();
	}
}


function cgm_fn_touch_on_release(tmp_this){
	if(cgm_touch_click && !cgm_touch_move){	
		if(jQuery(tmp_this).find('a').attr('target') == '_black' && jQuery(tmp_this).find('a').attr('rel') == undefined){
			window.open(jQuery(tmp_this).find('a').attr('href'),'_blank');
		} else if(jQuery(tmp_this).find('a').attr('rel') == undefined){
			window.open(jQuery(tmp_this).find('a').attr('href'));
		} else {
			jQuery(tmp_this).find('a').click();	
		}
	}
}

function cgm_fn_touch_dirrection(tmp_dir,tmp_id){
	if(tmp_dir == 'left'){
		if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
			cgm_touch_data[tmp_id].stopAutoPlay();
			cgm_touch_data[tmp_id].swipePrev();
		}
	} else {
		if(typeof(cgm_touch_data[tmp_id])!== 'undefined'){
			cgm_touch_data[tmp_id].stopAutoPlay();
			cgm_touch_data[tmp_id].swipeNext();
		}
	}
};

function cgm_fn_touch_autocorrect(tmp_this,tmp_width,tmp_height){
	
	if(jQuery(tmp_this).val() == 'thumbnail'){
		jQuery(tmp_width).attr('disabled','disabled');
		jQuery(tmp_height).attr('disabled','disabled');
		jQuery(tmp_width).css('color','#dddddd');
		jQuery(tmp_height).css('color','#dddddd');
		jQuery(tmp_width).val(cgm_sizes_thumbnail_width);
		jQuery(tmp_height).val(cgm_sizes_thumbnail_height);
	} else if(jQuery(tmp_this).val() == 'medium'){
		jQuery(tmp_width).attr('disabled','disabled');
		jQuery(tmp_height).attr('disabled','disabled');
		jQuery(tmp_width).css('color','#dddddd');
		jQuery(tmp_height).css('color','#dddddd');
		jQuery(tmp_width).val(cgm_sizes_medium_width);
		jQuery(tmp_height).val(cgm_sizes_medium_height);
	} else if(jQuery(tmp_this).val() == 'large'){
		jQuery(tmp_width).attr('disabled','disabled');
		jQuery(tmp_height).attr('disabled','disabled');
		jQuery(tmp_width).css('color','#dddddd');
		jQuery(tmp_height).css('color','#dddddd');
		jQuery(tmp_width).val(cgm_sizes_large_width);
		jQuery(tmp_height).val(cgm_sizes_large_height);
	} else if(jQuery(tmp_this).val() == 'fullwidth'){
		jQuery(tmp_width).attr('disabled','disabled');
		jQuery(tmp_width).val('100%');
		jQuery(tmp_height).removeAttr('disabled');
		jQuery(tmp_width).css('color','#dddddd');
		jQuery(tmp_height).css('color','#333333');
	} else {
		if(jQuery(tmp_width).val() == '100%'){
			jQuery(tmp_width).val('500');
		}
		jQuery(tmp_width).css('color','#333333');
		jQuery(tmp_height).css('color','#333333');
		jQuery(tmp_width).removeAttr('disabled');
		jQuery(tmp_height).removeAttr('disabled');
	}	
}