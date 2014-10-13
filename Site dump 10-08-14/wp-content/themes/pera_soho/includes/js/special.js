/* Animation storyboard. */
var stories = new Array();
 
/* I have ten stories to tell. */
for (var i=0; i< 4; i++) { stories[i] = new ScrollMagic(); }

function _triggerMobileNavChange() {
	(function($){
		if ( $(window).outerWidth() <= 950 ) {
			
			if ( 0 == $('#above-main-wrapper').length ) {
				$('<div>')
					.attr('id', 'above-main-wrapper')
					.prependTo('.whole-wrapper')
					.hide();
			}

			if ( 0 == $('#nav-toggle').length ) {
				$('<div>')
					.attr('id', 'nav-toggle')
					.prependTo('#above-main-wrapper');

				$('#nav-toggle').on('click', function(e) {
					if ( ! $(this).hasClass('clicked') ) {
						
						$(this).addClass('clicked');

						$('.super-wrapper > #navigation').animate({
							'left' : 0
						},350, 'easeOutQuad');

						$('.whole-wrapper, #above-main-wrapper').animate({
							'left' : ( 1 * $('.super-wrapper > #navigation').outerWidth() ) + 'px'
						},350*1.5, 'easeInQuad');

						if ( $(window).outerWidth() >= 650 && 0 != $('.twitter-bar-header').length ) {
							$('.twitter-bar-header').animate({
								'left' : ( 1 * $('.super-wrapper > #navigation').outerWidth() ) + 'px'
							},350*1.5, 'easeInQuad');	
						} {
							$('.twitter-bar-header').css({
								'left' : 0
							});
						}

						$('#navigation').superfish({
							animation:   {opacity:'show', height: 'show'},
							animationOut:   {opacity:'hide', height: 'hide'},
							speed: 'slow',
							autoArrows: true,
							delay: 400
						});

					} else {
						
						$(this).removeClass('clicked');

						$('.super-wrapper > #navigation').animate({
							'left' : ( -1 * $('.super-wrapper > #navigation').outerWidth() ) + 'px'
						},350*2, 'easeInQuad');

						$('.whole-wrapper, #above-main-wrapper').animate({
							'left' : 0
						},350*1.5, 'easeInQuad');

						if ( 0 != $('.twitter-bar-header').length ) {
							$('.twitter-bar-header').animate({
								'left' : 0
							},350*1.5, 'easeInQuad');
						}

						$('#navigation').superfish('destroy');
					}
				});	
			}

			if ( 1 == $('#above-main-wrapper').length && 1 == $('#above-footer address').length && 0 == $('#above-main-wrapper address').length ) {
				$('#above-footer address').clone().appendTo($('#above-main-wrapper'));
			} else if (1 == $('.top-widget-container address').length && 0 == $('#above-main-wrapper address').length ) {
				$('.top-widget-container address').clone().appendTo($('#above-main-wrapper'));		
				console.log('hi');
			}

			if ( 1 == $('#navigation').length ) {
				$('#above-main-wrapper').slideDown();
				$('#header').css({'top':'47px'});
				$('body').css({'overflow-x':'hidden'});

				if ( 0 == $('.super-wrapper > #navigation').length ) {
					$('#navigation').detach().prependTo($('.super-wrapper')).css({'opacity':'1'});
					console.log("removed");
				}
			}
		
		} else {
			$('#above-main-wrapper').slideUp(function(e){
				$(this).remove();
			});

			if ( $('body').hasClass('landing') && $('body').hasClass('logged-in') && $('body').hasClass('admin-bar') && 1 == $('#navigation').length) {
				$('#header').css({'top':'32px'});
			} else {
				$('#header').css({'top':'0'})
			}
			

			$('.super-wrapper').css({
				'left' : 0
			});

			if ( 1 == $('#navigation').length ) {
				if ( 1 == $('.super-wrapper > #navigation').length ) {
					$('.super-wrapper > #navigation').detach().removeAttr('style').insertAfter($('#logo')).css({'opacity':'1'});
				}
			}	

			$('.super-wrapper > #navigation').css({
				'left' : ( -1 * $('.super-wrapper > #navigation').outerWidth() ) + 'px'
			});

			$('.whole-wrapper, #above-main-wrapper').css({
				'left' : 0
			});

			if ( 0 != $('.twitter-bar-header').length ) {
				$('.twitter-bar-header').css({
					'left' : 0
				});
			}

			$('#navigation').superfish('destroy');	
		}		
	})(jQuery);
}

function _makeScrollAnimations(){
	(function($){
		if ( 1 == $('.trigger-banner1').length ) {
			stories[0].addScene( new ScrollScene( { triggerElement: ".trigger-banner1" } )
								.setTween(TweenMax.fromTo("#header", 1, 
									{
										backgroundColor: 'transparent'
									}, {
										backgroundColor: '#50341B'
									}))
								);
		}

		if ($(window).outerWidth > 520) {
			if ( 1 == $('.trigger-banner1').length ) {
				stories[0].addScene( new ScrollScene( { triggerElement: ".trigger-banner1" } )
										.setTween(TweenMax.to(".shortnav.navigation-drop", 1, 
											{
												className: "+=likeHovered"
											}))
										);
			}			
		}


		if ( 1 == $('.slider-wrapper').length ) {
			stories[1].addScene( new ScrollScene( { triggerElement: ".slider-wrapper", duration: $(".slider-wrapper").outerHeight() } )
									.setTween( TweenMax.from(".no-stellar-bg-1", 1, 
										{
											autoAlpha: 0
										}))
									);
		}

		if ( 1 == $('.slider-wrapper').length ) {
			stories[1].addScene( new ScrollScene( { triggerElement: ".slider-wrapper", duration: $(".slider-wrapper").outerHeight() } )
									.setTween( TweenMax.from(".no-stellar-bg-2", 1, 
										{
											autoAlpha: 0
			 							}))
									);
		}

		if ( 1 == $('.trigger-parallax1').length ) {
			stories[2].addScene( new ScrollScene( { triggerElement: ".trigger-parallax1", duration: $(".parallax1").outerHeight()/2 } )
									.setTween( TweenMax.to(".no-stellar-bg-1", 1, 
										{
											autoAlpha: 1
										}))
									);
		}

		if ( 1 == $('.trigger-offers1').length ) {
			stories[2].addScene( new ScrollScene( { triggerElement: ".trigger-offers1" } )
									.setTween( TweenMax.to(".no-stellar-bg-1", 1, 
										{
											autoAlpha: 0
										}))
									);
		}
		
		if ( 1 == $('.trigger-parallax2').length ) {
			stories[2].addScene( new ScrollScene( { triggerElement: ".trigger-parallax2" } )
									.setTween(TweenMax.from(".parallax2 .text.right.top", 1, 
										{
											autoAlpha: 0 
										}))
									);			
		}
		
		if ( 1 == $('.trigger-offers1').length ) {
			stories[2].addScene( new ScrollScene( { triggerElement: ".trigger-offers1", duration: $(".trigger-offers1").outerHeight()/2 } )
									.setTween( TweenMax.to(".no-stellar-bg-2", 1, 
										{
											autoAlpha: 1
										}))
									);
		}

		if ( 1 == $('.trigger-offers1').length ) {
			stories[3].addScene( new ScrollScene( { triggerHook: 0.80, triggerElement: ".animated.offers1" } )
									.setTween( TweenMax.fromTo( ".animated.offers1 .offers-item-1, .animated.offers1 .offers-item-3", 1, 
										{
											top: (-1 * $('.animated.offers1').outerHeight()),
											autoAlpha: 0
										}, {
											top: 0,
											autoAlpha: 1
										}))
									);
		}

		if ( 1 == $('.trigger-offers1').length ) {
			stories[3].addScene( new ScrollScene( { triggerHook: 0.80, triggerElement: ".animated.offers1" } )
									.setTween( TweenMax.fromTo( ".animated.offers1 .offers-item-2, .animated.offers1 .offers-item-4", 1, 
										{
											bottom: (-1 * $('.animated.offers1').outerHeight()),
											autoAlpha: 0
										}, {
											bottom: 0,
											autoAlpha: 1
										}))
									);
		}
	})(jQuery);
}

function _makeShorterAsScreenGetsSmall(){
	(function($){
		if ($(window).outerWidth() <= 1200) {
			$('body.landing.page .animated.offers > div').css({
				'padding-top':(300*($(window).outerWidth()/1200))+'px', 
				'padding-bottom':(300*($(window).outerWidth()/1200))+'px'
			})
		} else {
			$('body.landing.page .animated.offers > div').css({'padding-top':'300px', 'padding-bottom':'300px'});
		}
	})(jQuery);
}

jQuery(document).ready(function(){
	(function($){

		/* Only excecute the animation on the landing page. */
		if ( $('body').hasClass('landing') && $('body').hasClass('page')) {


			/* Make sure the Visual Composer rows are numbered. 1-indexed.*/
			$('.wpb_row').each(function(i,e){
				var $this = $(e);
				var w = $('.wpb_row').length;
				var classes = $(this).attr('class');
					classes = classes.split(" ");
				var newClasses = 'wpb_row vc_row-fluid';

				for (var m=0; m < classes.length; m++) {
					$this.addClass( classes[m] + ($('.'+classes[m]).index($this) + 1) );
					newClasses += (' trigger-' + classes[m] + ($('.'+classes[m]).index($this) + 1)); 
				}

				if (i>0) {
					$('<div>').addClass('trigger').addClass(newClasses).insertBefore($this);
				}	
			});

			$(".navigation-drop").hoverIntent({
				timeout: 400,
			    over: function(e){
			    	$(this).addClass('likeHovered');
			    	$(this).children('ul').slideDown();
			    },
			    out: function(e){
			    	$(this).removeClass('likeHovered');
			    	$(this).children('ul').slideUp();
			    }
			});
		
			/* Make sure the items in the animated pic list VC module are numbered. 1-indexed.*/
			$('.animated.offers ul').each(function(i,e){
				$(e).find('li').each(function(j,k){
					$(this).addClass('offers-item-' + (j+1));	
				});
			});

			/* RENAME this class. This seq is a workaround background-attachment:fixed bug and Stellar.js bug. */			
			$('.animated.parallax').each(function(i,e){
				$this = $(this);

				$(this).find('img.back').each(function(g,h){
					$('<div class="no-stellar-bg no-stellar-bg-' + ($('.animated.parallax').index($this)+1) +'" style="background-image: url(' + "'" + $(this).attr('src') + "'" + ')">').prependTo('body');	
				});
			});

			var tl = new TimelineMax();
				tl.to(".wpb_row:not(.twitter-bar-header)",0.4,{opacity:0})
				  .fromTo("#logo",0.4,{opacity:0},{opacity:1})
				  .fromTo("#navigation",0.4,{opacity:0},{opacity:1})
				  .fromTo(".twitter-bar-header",0.4,{opacity:0},{opacity:1})
				  .fromTo(".navigation-drop",0.4,{opacity:0},{opacity:1})
				  .fromTo(".sub-navigation",0.4,{opacity:0},{opacity:1})
				  .to(".wpb_row:not(.twitter-bar-header)",0.4,{opacity:1});
				  
			_makeShorterAsScreenGetsSmall();
		} else {
			$('.twitterbirdanimated').remove();
		}

		_triggerMobileNavChange();
	})(jQuery);
});

window.onload = function(){
	(function($){
		if ( $('body').hasClass('landing') && $('body').hasClass('page') ) {
			_makeScrollAnimations();		
			_makeShorterAsScreenGetsSmall();			
		}

		_triggerMobileNavChange();
	})(jQuery);
};

window.onresize = function(){
	(function($){
		if ( $('body').hasClass('landing') && $('body').hasClass('page') ) {		
			_makeShorterAsScreenGetsSmall();		
		}

		_triggerMobileNavChange();
	})(jQuery);
};