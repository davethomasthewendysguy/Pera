var cgm_prety_photo_save = new Array();
var cgm_prety_photo_data = new Array();
var cgm_univarial_max = new Array();
var cgm_COMPLETE_GALLERY_URL = '';

function cgm_drawIsoTope_gallery(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL,debug,cgm_extra){
	cgm_COMPLETE_GALLERY_URL = tmp_COMPLETE_GALLERY_URL;
	if(debug){
		jQuery('#cgm_preview').fadeTo('slow',0,function(){
			setTimeout(function() {
				cgm_drawIsoTope_gallery_v2(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL,true);
			},100);
		});
	} else {
		jQuery(document).ready(function($){
		
			jQuery('#completegallery'+tmp_id).html(jQuery('#cgmtemp'+tmp_id).html());
			jQuery('#cgmtemp'+tmp_id).remove();
		
			if( window.location.protocol == 'https:'){
				tmp_COMPLETE_GALLERY_URL=tmp_COMPLETE_GALLERY_URL.replace("http","https"); 
			} else {
				tmp_COMPLETE_GALLERY_URL=tmp_COMPLETE_GALLERY_URL.replace("https","http"); 
			}
			
			cgm_drawIsoTope_gallery_v2(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL,false,cgm_extra);	
			jQuery('#cgm_isotype_bg_'+tmp_id).isotope();
			
			var max_size_univasal = 0;
			
			if(typeof(cgm_univarial_max[tmp_id]) !== 'undefined'){
				max_size_univasal = cgm_univarial_max[tmp_id];
			}

			
			cgm_load_next_images(tmp_COMPLETE_GALLERY_URL+ 'frames/select_next_images.php',tmp_id,tmp_post_id,0,max_size_univasal);
		});
	}


}


function cgm_load_next_images(_url,_tmp_id,_tmp_post_id,_count,max_size_univasal){
	jQuery.post(_url,{tmp_id:_tmp_id,post_id:_tmp_post_id,count:_count,max_count:cgm_univarial_max[_tmp_id]},function(data){
		if(data.R == 'OK'){
			cgm_activate_images(data.DATA,data.TMPID);
			if(data.MOREDATA && (typeof(cgm_univarial_max[data.TMPID]) == 'undefined')){
				cgm_load_next_images(_url,data.TMPID,data.POSTID,data.COUNT,0);
				if(typeof(cgm_prety_photo_save[data.TMPID]) !== 'undefined'){
					cgm_prety_photo_data[data.TMPID] = '';
					//cgm_prety_photo_data[data.TMPID] = jQuery("#cgm_isotype_bg_"+data.TMPID+" a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data.TMPID]);
					cgm_prety_photo_data[data.TMPID] = jQuery("#cgm_isotype_bg_"+data.TMPID+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data.TMPID]);
				}
				jQuery('#cgm_isotype_bg_'+data.TMPID).isotope();
			} else {
				jQuery('#cgm_isotype_bg_'+data.TMPID).isotope( 'reloadItems' );
							
				if(typeof(cgm_univarial_max[data.TMPID]) !== 'undefined'){
					jQuery('#cgm_isotype_bg_'+data.TMPID).isotope({filter:'.cgm_items:not(.cgm_loading)'});
				} else {
					jQuery('#cgm_isotype_bg_'+data.TMPID).isotope();
				}
				
				jQuery('#completegallery'+data.TMPID + ' .universall_scroll span').html('true');
				if(typeof(cgm_prety_photo_save[data.TMPID]) !== 'undefined'){
					cgm_prety_photo_data[data.TMPID] = '';
					//cgm_prety_photo_data[data.TMPID] = jQuery("#cgm_isotype_bg_"+data.TMPID+" a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data.TMPID]);
					cgm_prety_photo_data[data.TMPID] = jQuery("#cgm_isotype_bg_"+data.TMPID+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data.TMPID]);	
				}	
				
				setTimeout(function() {
					for(var i=0; i<cgm_prety_photo_save.length;i++){
						cgm_prety_photo_data[i] = '';
						cgm_prety_photo_data[i] = jQuery("#cgm_isotype_bg_"+i+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[i]);
					}
				},400);	
				
			}
			data = null;
		}
	},'json');
}

function cgm_activate_images(tmp_data,tmp_id){
	for(var i=0;i<tmp_data.length;i++){
		var tmp_style = jQuery('#cgm_isotype_bg_'+tmp_id+' .cgm_loading_'+tmp_data[i].ID).attr('style');
		jQuery('#cgm_isotype_bg_'+tmp_id+' .cgm_loading_'+tmp_data[i].ID).addClass(tmp_data[i].category).attr('style',tmp_style+tmp_data[i].style).html(tmp_data[i].content).removeClass('cgm_loading').removeClass('cgm_loading_'+tmp_data[i].ID);
		tmp_style = null;
	}
	
}


function cgm_drawIsoTope_gallery_v2(tmp_id,tmp_settings,tmp_post_id,tmp_COMPLETE_GALLERY_URL,debug,cgm_extra){
		if(typeof(tmp_settings)=='string'){
		
		
			if(typeof(cgm_extra)=='string'){
				cgm_extra = decodeURI(cgm_extra);
				cgm_extra = cgm_extra.replace(/%3A/g,':');
				cgm_extra = cgm_extra.replace(/%2C/g,',');
			    cgm_extra = JSON.parse(cgm_extra);
			} else {
				cgm_extra = '';
			}
			




			tmp_settings = JSON.parse(decodeURI(tmp_settings));
			
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
			
			

			//cgm_prety_photo_data[tmp_id] = jQuery("#cgm_isotype_bg_"+tmp_id+" a[rel^='prettyPhoto']").prettyPhoto(cgm_tmp_pretty_photo);
			cgm_prety_photo_data[tmp_id] = jQuery("#cgm_isotype_bg_"+tmp_id+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_tmp_pretty_photo);
			cgm_prety_photo_save[tmp_id] = cgm_tmp_pretty_photo
			cgm_tmp_pretty_photo = null;

			var cgm_tmp_isotope = new Object();
			cgm_tmp_isotope.itemSelector = '.cgm_items';
			
			cgm_tmp_isotope.layoutMode = tmp_settings.cgm_layout['default'];
			cgm_tmp_isotope.sortBy = tmp_settings.cgm_sort['default'];			

			if( typeof(cgm_extra['sort'])=='string' && (cgm_extra['sort'].toLowerCase() == 'index' || cgm_extra['sort'].toLowerCase() == 'title' || cgm_extra['sort'].toLowerCase() == 'desc' || cgm_extra['sort'].toLowerCase() == 'date' || cgm_extra['sort'].toLowerCase() == 'link' || cgm_extra['sort'].toLowerCase() == 'imageSize' || cgm_extra['sort'].toLowerCase() == 'random' )){
					if('imagesize' == cgm_extra['sort'].toLowerCase()){
						cgm_tmp_isotope.sortBy = 'imageSize';
					} else {
						cgm_tmp_isotope.sortBy = cgm_extra['sort'].toLowerCase();
					}
				
			}
			

			if(typeof(cgm_extra['layout'])=='string' && (cgm_extra['layout'] == 'masonry' || cgm_extra['layout'] == 'fitRows' || cgm_extra['layout'] == 'cellsByRow' || cgm_extra['layout'] == 'straightDown' || cgm_extra['layout'] == 'masonryHorizontal' || cgm_extra['layout'] == 'fitColumns' || cgm_extra['layout'] == 'cellsByColumn' || cgm_extra['layout'] == 'straightAcross' )){
				cgm_tmp_isotope.layoutMode = cgm_extra['layout'];	
			}		
			
			if(typeof(cgm_extra['catID'])=='number' && cgm_extra['catID']>0){
				cgm_tmp_isotope.filter = '.categoryid'+cgm_extra['catID'];
			}	



			cgm_tmp_isotope.getSortData = {
						index : function( $elem ) {
							return parseInt( $elem.find('.index').text());
						},
						title : function( $elem ) {
							return $elem.find('.title').text();
						},
						desc : function( $elem ) {
							return $elem.find('.desc').text();
						},
						date : function( $elem ) {
							return parseFloat( $elem.find('.date').text());
						},
						link : function( $elem ) {
							return $elem.find('.link').text();
						},
						imageSize : function ( $elem ) {
							return parseFloat( $elem.find('.size').text());
						},
						random : function ( $elem ) {
							return parseFloat( $elem.find('.random').text());
						}
					};	
				

			if(typeof(tmp_settings.cgm_sort.directiondefault)=='string'){
				if(tmp_settings.cgm_sort.directiondefault == 'ASC'){
					cgm_tmp_isotope.sortAscending = true;	
				} else {
					cgm_tmp_isotope.sortAscending = false;
				}

			}
			
			if(typeof(cgm_extra['sortDir'])=='string' && (cgm_extra['sortDir'].toLowerCase() == 'asc' || cgm_extra['sortDir'].toLowerCase() == 'desc' )){
				if(cgm_extra['sortDir'].toLowerCase() == 'asc'){
					cgm_tmp_isotope.sortAscending = true;	
				} else {
					cgm_tmp_isotope.sortAscending = false;
				}
			}
						
			if(typeof(tmp_settings.cgm_animation.type)=='string'){
				cgm_tmp_isotope.animationEngine = tmp_settings.cgm_animation.type;	
			}

			if(typeof(tmp_settings.cgm_animation.duration)=='number'){
				cgm_tmp_isotope.animationOptions = {
     				duration: tmp_settings.cgm_animation.duration,
     				easing: tmp_settings.cgm_animation.easing,
     				queue: false
   				}
			}
			

				var cgm_height = 0;
				var cgm_width = 0;
				var collect_all_h = 0;
				var collect_all_w = 0;
				var cgm_lr = 0;
				var cgm_hb = 0;			
				jQuery('#cgm_isotype_bg_'+tmp_id).find('.cgm_items').each(function(){
				
					var cgm_lr = parseInt(jQuery(this).css("padding-left"))+parseInt(jQuery(this).css("padding-right"));
					var cgm_hb = parseInt(jQuery(this).css("padding-bottom"))+parseInt(jQuery(this).css("padding-top"));	
				
				
					if(cgm_width < (jQuery(this).width()+cgm_lr)){
						cgm_width = (jQuery(this).width()+cgm_lr);
					}
					collect_all_w += jQuery(this).width();
						
					if(cgm_height < (jQuery(this).height()+cgm_hb)){
						cgm_height = (jQuery(this).height()+cgm_hb);
					}		
					
					collect_all_h += jQuery(this).height();
					
				}); 
				
				if(typeof(tmp_settings.cgm_animation.type)=='string' && tmp_settings.cgm_animation.type != 'jQuery'){
					cgm_tmp_isotope.masonry = {columnWidth : 1};
					cgm_tmp_isotope.masonryHorizontal = {rowHeight:1};
				
				}
				cgm_tmp_isotope.cellsByRow = {columnWidth : (cgm_width+5),rowHeight : (cgm_height+5)};
				cgm_tmp_isotope.cellsByColumn = {columnWidth : (cgm_width+cgm_lr+5),rowHeight : (cgm_height+cgm_hb+5)};
				
				cgm_height = null;
				cgm_width = null;
				cgm_lr = null;
				cgm_hb = null;
	
			
			//cgm_changeLayoutMode(cgm_tmp_isotope.layoutMode,tmp_id);
						
			jQuery('#cgm_isotype_bg_'+tmp_id).isotope(cgm_tmp_isotope);	

			
			if(typeof(tmp_settings.cgm_universallScroll.loadNumber)=='number' && tmp_settings.cgm_universallScroll.loadNumber>0 && tmp_settings.cgm_universallScroll.loadNumber != null){
				
				cgm_univarial_max[tmp_id] = tmp_settings.cgm_universallScroll.loadNumber;
				
				var cgm_setscollepos = jQuery('#cgm_isotype_bg_'+tmp_id).parent();
				if(typeof(tmp_settings.cgm_height) == 'undefined'  || (typeof(tmp_settings.cgm_height) == 'number' && tmp_settings.cgm_height == 0)){
					 cgm_setscollepos = jQuery(window);
				} else {
					jQuery(cgm_setscollepos).scrollTop(0);
				}
				
				jQuery(cgm_setscollepos).scroll(function () {
					if(jQuery('#completegallery'+tmp_id).hasClass('cgm-iso-fullscreen') == false){
						var cgm_universal_scroll_max = 0;
						if(typeof(tmp_settings.cgm_height) == 'undefined' || (typeof(tmp_settings.cgm_height) == 'number' && tmp_settings.cgm_height == 0)){
							var cgm_top_universal =  jQuery('#cgm_isotype_bg_'+tmp_id).parent().offset();
							cgm_top_universal = Math.round(cgm_top_universal.top);
							cgm_universal_scroll_max = jQuery('#cgm_isotype_bg_'+tmp_id).parent().height() + cgm_top_universal - jQuery(this).height()+100;
							cgm_top_universal = null;
						} else {
							cgm_universal_scroll_max = jQuery(this)[0].scrollHeight - jQuery(this).height();
						}
						var tmp_universal = jQuery('#completegallery'+tmp_id + ' .universall_scroll span').html();
	
	
						if(jQuery(this).scrollTop() > cgm_universal_scroll_max-50 && tmp_universal == 'true'){
						
							jQuery('#completegallery'+tmp_id + ' .universall_scroll span').html('false');
	
							jQuery('#completegallery'+tmp_id + ' .universall_scroll div').html('Loading');
							jQuery('#completegallery'+tmp_id + ' .universall_scroll').fadeIn(500, function() {
	
								jQuery.post(tmp_COMPLETE_GALLERY_URL+'frames/select_next_images.php',{'steps':tmp_settings.cgm_universallScroll.loadNumber,'post_id':tmp_post_id,count:(jQuery('#cgm_isotype_bg_'+tmp_id).children("div:not(.cgm_loading)").length-1),'tmp_id':tmp_id,max_count:cgm_univarial_max[tmp_id]},function(data2){
								
									if(data2.R == 'OK'){
										cgm_activate_images(data2.DATA,data2.TMPID);
										if(data2.MOREDATA && (typeof(cgm_univarial_max[data2.TMPID]) == 'undefined')){
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
										} else {
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope( 'reloadItems' );
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
											if(typeof(cgm_prety_photo_save[data2.TMPID]) !== 'undefined'){
												//cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
												cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
											}	
										}
										
										
										var tmp_id__ = data2.TMPID;
										
										
										if(data2.MOREDATA){	
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												setTimeout(function(){
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll span').html('true');
												}, 500 );								
											});
										} else {
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll div').html('No more pictures');
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeIn(500, function() {	
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').delay(1000).fadeOut(500, function() {
														jQuery(this).hide();
													});	
												})
											});
										}
										
										
										data2 = null;
									}
								},'json');
							})
						}
					}
				});
				
				
			if (document.attachEvent) //if IE (and Opera depending on user setting)
			    document.attachEvent("on"+mousewheelevt, function(){
		    	if(jQuery('#completegallery'+tmp_id).hasClass('cgm-iso-fullscreen') && jQuery('#completegallery0').scrollTop() < 1){
							jQuery('#completegallery'+tmp_id + ' .universall_scroll span').html('false');
	
							jQuery('#completegallery'+tmp_id + ' .universall_scroll div').html('Loading');
							jQuery('#completegallery'+tmp_id + ' .universall_scroll').fadeIn(500, function() {
	
								jQuery.post(tmp_COMPLETE_GALLERY_URL+'frames/select_next_images.php',{'steps':tmp_settings.cgm_universallScroll.loadNumber,'post_id':tmp_post_id,count:(jQuery('#cgm_isotype_bg_'+tmp_id).children("div:not(.cgm_loading)").length-1),'tmp_id':tmp_id,max_count:cgm_univarial_max[tmp_id]},function(data2){
								
									if(data2.R == 'OK'){
										cgm_activate_images(data2.DATA,data2.TMPID);
										if(data2.MOREDATA && (typeof(cgm_univarial_max[data2.TMPID]) == 'undefined')){
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
										} else {
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope( 'reloadItems' );
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
											if(typeof(cgm_prety_photo_save[data2.TMPID]) !== 'undefined'){
												//cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
												cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
											}	
										}
										
										
										var tmp_id__ = data2.TMPID;
										
										
										if(data2.MOREDATA){	
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												setTimeout(function(){
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll span').html('true');
												}, 500 );								
											});
										} else {
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll div').html('No more pictures');
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeIn(500, function() {	
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').delay(1000).fadeOut(500, function() {
														jQuery(this).hide();
													});	
												})
											});
										}
										
										
										data2 = null;
									}
								},'json');
							})

			    	}
				    
			    })
			else if (document.addEventListener) //WC3 browsers
			    document.addEventListener(mousewheelevt, function(){
			    	if(jQuery('#completegallery'+tmp_id).hasClass('cgm-iso-fullscreen') && jQuery('#cgm_isotype_bg_'+tmp_id).height()+100 < jQuery(window).height()){
							jQuery('#completegallery'+tmp_id + ' .universall_scroll span').html('false');
	
							jQuery('#completegallery'+tmp_id + ' .universall_scroll div').html('Loading');
							jQuery('#completegallery'+tmp_id + ' .universall_scroll').fadeIn(500, function() {
	
								jQuery.post(tmp_COMPLETE_GALLERY_URL+'frames/select_next_images.php',{'steps':tmp_settings.cgm_universallScroll.loadNumber,'post_id':tmp_post_id,count:(jQuery('#cgm_isotype_bg_'+tmp_id).children("div:not(.cgm_loading)").length-1),'tmp_id':tmp_id,max_count:cgm_univarial_max[tmp_id]},function(data2){
								
									if(data2.R == 'OK'){
										cgm_activate_images(data2.DATA,data2.TMPID);
										if(data2.MOREDATA && (typeof(cgm_univarial_max[data2.TMPID]) == 'undefined')){
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
										} else {
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope( 'reloadItems' );
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
											if(typeof(cgm_prety_photo_save[data2.TMPID]) !== 'undefined'){
												//cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
												cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
											}	
										}
										
										
										var tmp_id__ = data2.TMPID;
										
										
										if(data2.MOREDATA){	
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												setTimeout(function(){
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll span').html('true');
												}, 500 );								
											});
										} else {
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll div').html('No more pictures');
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeIn(500, function() {	
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').delay(1000).fadeOut(500, function() {
														jQuery(this).hide();
													});	
												})
											});
										}
										
										
										data2 = null;
									}
								},'json');
							})

			    	}
			    
			    }, false)
				
				
			jQuery('#completegallery0').scroll(function () {
					if(jQuery('#completegallery'+tmp_id).hasClass('cgm-iso-fullscreen')){
						var cgm_universal_scroll_max = 0;
						if(typeof(tmp_settings.cgm_height) == 'undefined' || (typeof(tmp_settings.cgm_height) == 'number' && tmp_settings.cgm_height == 0)){
							var cgm_top_universal =  jQuery('#cgm_isotype_bg_'+tmp_id).parent().offset();
							cgm_top_universal = Math.round(cgm_top_universal.top);
							cgm_universal_scroll_max = jQuery('#cgm_isotype_bg_'+tmp_id).parent().height() + cgm_top_universal - jQuery(this).height()+100;
							cgm_top_universal = null;
						} else {
							cgm_universal_scroll_max = jQuery(this)[0].scrollHeight - jQuery(this).height();
						}
						var tmp_universal = jQuery('#completegallery'+tmp_id + ' .universall_scroll span').html();
	
	
						if(jQuery(this).scrollTop() > cgm_universal_scroll_max-jQuery(window).height() && tmp_universal == 'true'){
						
							jQuery('#completegallery'+tmp_id + ' .universall_scroll span').html('false');
	
							jQuery('#completegallery'+tmp_id + ' .universall_scroll div').html('Loading');
							jQuery('#completegallery'+tmp_id + ' .universall_scroll').fadeIn(500, function() {
	
								jQuery.post(tmp_COMPLETE_GALLERY_URL+'frames/select_next_images.php',{'steps':tmp_settings.cgm_universallScroll.loadNumber,'post_id':tmp_post_id,count:(jQuery('#cgm_isotype_bg_'+tmp_id).children("div:not(.cgm_loading)").length-1),'tmp_id':tmp_id,max_count:cgm_univarial_max[tmp_id]},function(data2){
								
									if(data2.R == 'OK'){
										cgm_activate_images(data2.DATA,data2.TMPID);
										if(data2.MOREDATA && (typeof(cgm_univarial_max[data2.TMPID]) == 'undefined')){
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
										} else {
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope( 'reloadItems' );
											jQuery('#cgm_isotype_bg_'+data2.TMPID).isotope();
											if(typeof(cgm_prety_photo_save[data2.TMPID]) !== 'undefined'){
												//cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
												cgm_prety_photo_data[data2.TMPID] = jQuery("#cgm_isotype_bg_"+data2.TMPID+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[data2.TMPID]);
											}	
										}
										
										
										var tmp_id__ = data2.TMPID;
										
										
										if(data2.MOREDATA){	
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												setTimeout(function(){
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll span').html('true');
												}, 500 );								
											});
										} else {
											jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeOut(500, function() {
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll div').html('No more pictures');
												jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').fadeIn(500, function() {	
													jQuery('#completegallery'+tmp_id__ + ' .universall_scroll').delay(1000).fadeOut(500, function() {
														jQuery(this).hide();
													});	
												})
											});
										}
										
										
										data2 = null;
									}
								},'json');
							})
						}
					}
				});
				
				
			}


			tmp_universal = null;
			cgm_universal_scroll_max = null;
			cgm_tmp_isotope = null;
			
			setTimeout(function() {
				if(debug){
					jQuery('#cgm_preview').fadeTo('slow',1);
					jQuery('#cgm-settings-preview-meta .hndle').click(function(){setTimeout(function() {jQuery('#cgm_isotype_bg_0').isotope();},10);});
					jQuery('#cgm_isotype_bg_'+tmp_id).fadeTo('slow',1);
				} else {
					jQuery('#cgm_isotype_bg_'+tmp_id).fadeTo('slow',1);
				}
				
				jQuery('#cgm_isotype_bg_'+tmp_id).isotope();

				
			},500);	
		}	
}

 
var mousewheelevt=(/Firefox/i.test(navigator.userAgent))? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
 


function cgm_sort_order_system(tmp_id,tmp_action,tmp_this){
	var cgm_tmp_isotope = new Object();
	cgm_tmp_isotope.sortAscending = tmp_action;
	jQuery(document).ready(function($){
		jQuery('#cgm_isotype_menu_'+tmp_id+' .cgm_sort_order a').removeClass('selected');
		jQuery(tmp_this).addClass('selected');
	
		jQuery('#cgm_isotype_bg_'+tmp_id).isotope(cgm_tmp_isotope);
	});	
	cgm_tmp_isotope = null;
	
}

document.addEventListener("fullscreenchange", function () {
	if(document.fullscreen){	
	} else {
		jQuery('.cgm-iso-fullscreen').removeClass('cgm-iso-fullscreen');
		document.documentElement.style.overflow = 'auto';	 // firefox, chrome
		document.body.scroll = "yes";	// ie only
		jQuery('#wpadminbar').show();	
	}
}, false);

document.addEventListener("mozfullscreenchange", function () {
	if(document.mozFullScreen){	
	} else {
		jQuery('.cgm-iso-fullscreen').removeClass('cgm-iso-fullscreen');
		document.documentElement.style.overflow = 'auto';	 // firefox, chrome
		document.body.scroll = "yes";	// ie only
		jQuery('#wpadminbar').show();	
	}
}, false);

document.addEventListener("webkitfullscreenchange", function () {
	if(document.webkitIsFullScreen){
	} else {
		jQuery('.cgm-iso-fullscreen').removeClass('cgm-iso-fullscreen');
		document.documentElement.style.overflow = 'auto';	 // firefox, chrome
		document.body.scroll = "yes";	// ie only
		jQuery('#wpadminbar').show();	
	}
}, false);


function cgm_fn_iso_fullscreen(tmp_id,tmp_this,tmp_text,tmp_exittext,tmp_fullscreentype){
	if(tmp_fullscreentype == '2'){
		if (jQuery('#completegallery'+tmp_id).hasClass('cgm-iso-fullscreen')) {
			jQuery('#completegallery'+tmp_id).removeClass('cgm-iso-fullscreen');
			jQuery(tmp_this).html(tmp_text);
			document.documentElement.style.overflow = 'auto';	 // firefox, chrome
			document.body.scroll = "yes";	// ie only
			jQuery('#wpadminbar').show();		
			cgm_RunPrefixMethod(document, "CancelFullScreen");	
		}else {
			cgm_RunPrefixMethod(document, "RequestFullScreen");
			jQuery('#completegallery'+tmp_id).addClass('cgm-iso-fullscreen');
			jQuery(tmp_this).html(tmp_exittext);
			document.documentElement.style.overflow = 'hidden';	 // firefox, chrome
			document.body.scroll = "no";	// ie only
			jQuery('#wpadminbar').hide();	
		} 
		jQuery('#cgm_isotype_bg_'+tmp_id).isotope();	
	} else {
		if(jQuery('#cgm_isotype_bg_'+tmp_id).parent().hasClass('cgm-iso-fullscreen')){
			jQuery('#cgm_isotype_bg_'+tmp_id).parent().removeClass('cgm-iso-fullscreen');
			jQuery(tmp_this).html(tmp_text);
			document.documentElement.style.overflow = 'auto';	 // firefox, chrome
			document.body.scroll = "yes";	// ie only	
			jQuery('#wpadminbar').show();
		} else {
			jQuery('#cgm_isotype_bg_'+tmp_id).parent().addClass('cgm-iso-fullscreen');
			jQuery(tmp_this).html(tmp_exittext);
			document.documentElement.style.overflow = 'hidden';	 // firefox, chrome
			document.body.scroll = "no";	// ie only	
			jQuery('#wpadminbar').hide();
		}
		
		jQuery('#cgm_isotype_bg_'+tmp_id).isotope();	
	}
}

function cgm_sort_system(tmp_id,tmp_action,tmp_this){
	var cgm_tmp_isotope = new Object();
	cgm_tmp_isotope.sortBy = tmp_action;
	
	jQuery(document).ready(function($){
		jQuery('#cgm_isotype_menu_'+tmp_id+' .cgm_sort a').removeClass('selected');
		jQuery(tmp_this).addClass('selected');
	
		jQuery('#cgm_isotype_bg_'+tmp_id).isotope(cgm_tmp_isotope);
	});	
	
	cgm_tmp_isotope = null;
	
}

function cgm_filter_system(tmp_id,tmp_action,tmp_this){
	var cgm_tmp_isotope = new Object();
	if(tmp_action != '*' && tmp_action != ''){
		tmp_action = '.'+tmp_action
	}
	cgm_tmp_isotope.filter = tmp_action;
	
	
	
	if(typeof(cgm_univarial_max[tmp_id]) !== 'undefined'){
				cgm_tmp_isotope.filter = tmp_action+':not(.cgm_loading)';
	}

	jQuery(document).ready(function($){
		jQuery('#cgm_isotype_menu_'+tmp_id+' .cgm_filter a').removeClass('selected');
		jQuery(tmp_this).addClass('selected');
	
		jQuery('#cgm_isotype_bg_'+tmp_id).isotope(cgm_tmp_isotope);
	});	
	
	setTimeout(function(){
		cgm_prety_photo_data[tmp_id] = jQuery("#cgm_isotype_bg_"+tmp_id+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[tmp_id]);
	},1000);
	
	cgm_tmp_isotope = null;
}

function cgm_filter_combination_system(tmp_id,tmp_action,tmp_this){
	var cgm_tmp_filter_list = new Array();
	var cgm_tmp_current_list =	jQuery(tmp_this).parent().parent().parent();
	jQuery(cgm_tmp_current_list).find('a').removeClass('selected');
	jQuery(tmp_this).addClass('selected');

	jQuery(cgm_tmp_current_list).parent().find('.cgm_filter').each(function(){
		var temp_data = jQuery(this).find('.selected').attr('rel');
		if(temp_data != '*' && temp_data != ''){
			temp_data = '.'+temp_data
		}
		cgm_tmp_filter_list.push( temp_data);
		temp_data = null;
	});

	var selector = cgm_tmp_filter_list.join('');
	jQuery('#cgm_isotype_bg_'+tmp_id).isotope({ filter: selector });
	
	
	setTimeout(function(){
		cgm_prety_photo_data[tmp_id] = jQuery("#cgm_isotype_bg_"+tmp_id+" .cgm_items:visible a[rel^='prettyPhoto']").prettyPhoto(cgm_prety_photo_save[tmp_id]);
	},1000);
	
	cgm_tmp_current_list = null;
	cgm_tmp_filter_list = null;
	selector = null;
	
}



function cgm_changeImages(tmp_id,tmp_this,tmp_action){
	jQuery(document).ready(function($){
		var defaultdiv = jQuery(tmp_this).children('.default_image').html();
		var lastdiv = jQuery(tmp_this).children('.imageSize').children('div:last-child').index();
		var current = jQuery(tmp_this).children('.imageSize').children('.current').index();
		var newselect = 0;
		
		
		
		console.log(defaultdiv); 
		console.log(lastdiv); 
		console.log(current); 
		
		
		if(defaultdiv=='thumbnail'){
			defaultdiv = 0;
		} else if(defaultdiv=='medium'){
			defaultdiv = 1;
		} else if(defaultdiv=='large'){
			defaultdiv = 2;
		} else if(defaultdiv=='full'){
			defaultdiv = 3;
		} else if(defaultdiv=='custom'){
			defaultdiv = 4;
		}

		jQuery('#cgm_isotype_bg_'+tmp_id).isotope()
		jQuery(tmp_this).children('.imageSize').children('div:eq('+current+')').removeClass('current');

		if(tmp_action == 'exAll'){
			if(current == lastdiv){
				newselect = 0;
			} else {
				newselect = current + 1;
				if(current > 2){
					newselect = lastdiv;
				}
			}
		} else if(tmp_action == 'ex0'){
			if(current == defaultdiv){
				newselect = 0;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'ex1'){
			if(current == defaultdiv){
				newselect = 1;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'ex2'){
			if(current == defaultdiv){
				newselect = 2;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'ex3'){
			if(current == defaultdiv){
				newselect = 3;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'ex4'){
			if(current == defaultdiv){
				newselect = lastdiv;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'hex0'){
			if(current == defaultdiv){
				newselect = 0;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'hex1'){
			if(current == defaultdiv){
				newselect = 1;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'hex2'){
			if(current == defaultdiv){
				newselect = 2;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'hex3'){
			if(current == defaultdiv){
				newselect = 3;
			} else {
				newselect = defaultdiv;
			}
		} else if(tmp_action == 'hex4'){
			if(current == defaultdiv){
				newselect = lastdiv;
			} else {
				newselect = defaultdiv;
			}
		}
		
		
		jQuery(tmp_this).children('.imageSize').children('div:eq('+newselect+')').addClass('current');	
		
		var newHeight = jQuery(tmp_this).children('.imageSize').children('div:eq('+newselect+')').find('.height').html();
		var newWidth = jQuery(tmp_this).children('.imageSize').children('div:eq('+newselect+')').find('.width').html();		
		var newUrl = jQuery(tmp_this).children('.imageSize').children('div:eq('+newselect+')').find('.url').html(); 	
		
		if(jQuery(tmp_this).parent().attr('id') == 'cgm_items'){
			//jQuery(tmp_this).parent().width(newWidth).height(newHeight);
			jQuery(tmp_this).parent().css({ width: newWidth,height:newHeight });

		} else if(jQuery(tmp_this).parent().parent().attr('id') =='cgm_items'){
			//jQuery(tmp_this).parent().parent().width(newWidth).height(newHeight);
			jQuery(tmp_this).parent().parent().css({ width: newWidth,height:newHeight });
		}	
		
		
		jQuery(tmp_this).children('.size').text(parseFloat(newWidth*newHeight));
		jQuery(tmp_this).children('img:first-child').attr('src',newUrl).css({ width: newWidth,height:newHeight });
	
		if(jQuery(tmp_this).parent().attr('id') == 'cgm_items'){
			jQuery('#cgm_isotype_bg_'+tmp_id).isotope('updateSortData',jQuery(tmp_this).parent());
		} else if(jQuery(tmp_this).parent().parent().attr('id') =='cgm_items'){
			jQuery('#cgm_isotype_bg_'+tmp_id).isotope('updateSortData',jQuery(tmp_this).parent().parent());
		}	
		
				
		jQuery('#cgm_isotype_bg_'+tmp_id).isotope();
		setTimeout(function(){
			jQuery('#cgm_isotype_bg_'+tmp_id).isotope();
		}, 100 )

		setTimeout(function(){
				jQuery('#cgm_isotype_bg_'+tmp_id).isotope();
			}, 500 )

		setTimeout(function(){
				jQuery('#cgm_isotype_bg_'+tmp_id).isotope();
			}, 1000 )

		setTimeout(function(){
				jQuery('#cgm_isotype_bg_'+tmp_id).isotope();
			}, 1500 )
			
		defaultdiv = null;
		lastdiv = null;
		current = null;
		newselect = null;
		newUrl = null;
		newWidth = null;
		newHeight = null;
		cgm_tmp_isotope = null;
		cgm_height = null;
		cgm_width = null;
		cgm_lr = null;
		cgm_hb = null;
	});
}
var isHorizontal = false;
function cgm_changeLayoutMode( options ,tmp_id) {
	var wasHorizontal = isHorizontal;
		if(options== 'straightAcross' || options== 'masonryHorizontal' || options== 'cellsByColumn' || options== 'fitColumns'){
			isHorizontal = true;
		} else {
			isHorizontal = false;
		}

		if ( wasHorizontal !== isHorizontal ) {
			var style = isHorizontal ? {height: '85%', width: jQuery('#cgm_isotype_bg_'+tmp_id).width() } : { width: 'auto' };
			jQuery('#cgm_isotype_bg_'+tmp_id).filter(':animated').stop();
			jQuery('#cgm_isotype_bg_'+tmp_id).addClass('no-transition').css( style );
			

			if(isHorizontal){
				jQuery('#cgm_isotype_bg_'+tmp_id).addClass('overflowx');
			} else {
				jQuery('#cgm_isotype_bg_'+tmp_id).removeClass('overflowx');
			}

			
			setTimeout(function(){
				jQuery('#cgm_isotype_bg_'+tmp_id).removeClass('no-transition').isotope( {'layoutMode':options} );
				}, 100 )
		} else {
			jQuery('#cgm_isotype_bg_'+tmp_id).isotope( {'layoutMode':options} );
		}
} 



function cgm_layout_system(tmp_id,tmp_action,tmp_width,tmp_height,tmp_this){
	var cgm_tmp_isotope = new Object();
	cgm_tmp_isotope.layoutMode = tmp_action;

	jQuery(document).ready(function($){

		if(jQuery(tmp_this).hasClass('selected') == false){
			cgm_changeLayoutMode(tmp_action,tmp_id);
		
		};

		jQuery('#cgm_isotype_menu_'+tmp_id+' .cgm_layout a').removeClass('selected');
		jQuery(tmp_this).addClass('selected');

	});		 
}