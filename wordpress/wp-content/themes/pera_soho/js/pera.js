(function($) {
	$(document).ready(function() {
			
		//PARALLAX SCROLLING
		if($(window).width() >= 768)  {			
			$('div[data-type="background"]').each(function(){
				var $bgobj = $(this); // assigning the object
	 
				$(window).scroll(function() {
					var yPos = -($(window).scrollTop() / $bgobj.data('speed')); 
			
					//console.log(yPos); 
			 
					// PUT TOGETHER OUR FINAL BACKGROUND POSITION
					var coords = '50% '+ yPos + 'px';
 
					// MOVE THE BACKGROUND
					$bgobj.css({ backgroundPosition: coords });
				});
			});
		}
	
		//SHOW OPEN TABLE POP-UP MODAL
		var openTable = $('.open-table'); //SLIDING MENU ELEMENT
		
		$("a.open-reservation-box").on("click", toggleOpenTable);
		
		$("a.close-open-table-modal").on("click", toggleOpenTable);
		
		//CALL SLIDER WHEN PAGE LOADS
		show_top_menu();
		
	
		//MOBILE MENU SLIDER
		var menuRight = $('#cbp-spmenu-s2'), //SLIDING MENU ELEMENT
			showRightPush = $('#showRightPush, h3.menu-toggle'), //MENU TRIGGER
			body = document.body;
	
	
		//TOGGLE MENU WHEN MENU LINK OR CLOSE BUTTON IS CLICKED
		showRightPush.on("click", toggleMenu);

		
		//LOAD APPROPRIATE MENU ON PAGE LOAD IF APPLICABLE
		var page_load_hash = window.location.hash;
		page_load_hash = page_load_hash.substring(1);
		
		if(page_load_hash) {
			$('.live-menu').each(function(i, obj) {					
				if($(this).attr("id") == "live-menu-" + page_load_hash) {
					$(this).fadeIn("slow");
				} else {
					$(this).fadeOut("slow");
				}
			});
			
			//HIGHLIGHT PROPER FOOD MENU IF APPROPRIATE
			$("." + page_load_hash).addClass("menu-highlight");
		} else {
			//DEFAULT TO DINNER IF NO MENU IS SELECTED
			$(".page-id-1712 .dinner").addClass("menu-highlight");
		}
		
		$('a[href*=#]:not([href=#])').click(function(e) {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {				
				if($(this).parent().hasClass("food-menu")) {
					
					var new_menu;
					
					var menus = new Array("brunch","lunch","dinner","dessert","happy-hour","skydeck");
					
					//SET MENU TO SEARCH FOR
					for(var i = 0; i < menus.length; i++) {
						if($(this).parent().hasClass(menus[i])) {
							var change_class = menus[i];
														
							new_menu = menus[i];
					  	}
					}
					
					//REMOVE ALL MENU HIGHLIGHTING
					$("#food-navigation li").removeClass("menu-highlight");
					
					//ADD MENU HIGHLIGHTING FOR CLICKED MENU
					if($(this).parent().hasClass(change_class)) {
						$(this).parent().addClass("menu-highlight");
					}
					
					//FADE IN APPROPRIATE MENU
					$('.live-menu').each(function(i, obj) {					
						if($(this).attr("id") == "live-menu-" + new_menu) {
							$(this).fadeIn("slow");
						} else {
							$(this).fadeOut("slow");
						}
					});
				}
				
				var target = $(this.hash);
				
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				
				if(target.length) {
					
					if($("nav#cbp-spmenu-s2").hasClass("cbp-spmenu-open")) {
						closeMenu();
					}
					
					var menu_offset = $(".fixed-menu").css("height");
					console.log(menu_offset);
					
					$('html,body').animate({
						scrollTop: target.offset().top - 170
					}, 1000);
					
					//console.log("Alert");
					
					$(".page-template-menu-php #food-navigation").click(function() {
						//console.log("Alert 2");
					});
					
					return false;
				}

				e.preventDefault();
			}
		});
		
		// CLOSE MENU IF OPEN AND WINDOW IS LARGER THAN 767px
		$(window).on("resize", function() {
			if($("nav#cbp-spmenu-s2").hasClass("cbp-spmenu-open") && $(window).width() >= 768) {
				closeMenu();
			}
		});
		
		// This will capture hash changes while you are on the same page
		$(window).on("hashchange", function() {
			offsetAnchor();
		});

		// This is here so that when you enter the page with a hash,
		// it can provide the offset in that case too. Having a timeout
		// seems necessary to allow the browser to jump to the anchor first.
		window.setTimeout(function() {
			offsetAnchor();
		}, 1); // The delay of 1 is arbitrary and may not always work right (although it did in my testing).
		
		//CHECK FOR WEBSITE SCROLL POSITION
		$(window).scroll(function($) {
			show_top_menu();
		});
	
	
	
	
	

		//REUSABLE FUNCTIONS
	
		//FUNCTION TO CHECK THE VERTICAL SCROLL POSITION OF THE WEBSITE
		function show_top_menu() {
			if($("body").hasClass("home")) { //TRIGGER ON HOMEPAGE OTHERWISE ALWAYS SHOW
				if($(document).scrollTop() > 500) { //SHOW THE FIXED MENU AFTER SCROLLING DOWN 500PX
					$('#main-menu').css("opacity","1");
					$('#logo-overlay').css("z-index","10");
				} else {
					$('#main-menu').css("opacity","0");
					$('#logo-overlay').css("z-index","9997");
					
					animationComplete();
					
					//$(body).find('#main-menu' ).css('opacity','0').end().find('#logo-overlay').css("z-index","9999");  
				}
			} else { //IF NOT ON HOMEPAGE, SET OPACITY TO 100%
				$('#main-menu').css("opacity","1");
			}
		}
		
		//CHECK FOR CSS TRANSITION COMPLETION
		function animationComplete() {
			if($("#main-menu").css('opacity') == 0) {
				//$('#logo-overlay').css("z-index","10");
			} else {
				setTimeout(function(){animationComplete()}, 500);        
			}
		}
		
		//OFFSET THE VERTICAL POSITION OF HASH IS IN URL
		function offsetAnchor() {
			// This if statement is optional. It is just making sure that
			// there is a valid anchor to offset from.
			if($(location.hash).length !== 0) {
				window.scrollTo(window.scrollX, window.scrollY - 120);
			}
		}
		
		//TOGGLE SIDE MENU
		function toggleMenu(e) {
			$(this).toggleClass("active");
			$(body).toggleClass("cbp-spmenu-push-toleft");
			$(menuRight).toggleClass("cbp-spmenu-open");
		
			e.preventDefault();
		}
	
		//CLOSE MENU IF OPEN OR IF MENU LINK IS CLICKED
		function closeMenu(e) {
			$(body).removeClass("cbp-spmenu-push-toleft");
			$(menuRight).removeClass("cbp-spmenu-open");
		
			//e.preventDefault();
		}
		
		//TOGGLE OPEN TABLE WIDGET
		function toggleOpenTable(e) {
			//console.log("Clicked");
		
			openTable.toggleClass("modal-hide");
			openTable.toggleClass("modal-show");
			$(".overlay").toggle();
		
			e.preventDefault();
		}
		
		//CLOSE OPEN TABLE WIDGET
		function closeModal(e) {
			openTable.toggleClass("modal-hide");
			openTable.toggleClass("modal-show");
			$(".overlay").toggleClass("shade");
			
			e.preventDefault();
		}
		
		/*$('a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = jQuery(this.hash);
				target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					jQuery('html,body').animate({
						scrollTop: target.offset().top - 120
					}, 1000);
				
					return false;
				}
			} else {
			}
		});*/
	});
})(jQuery);