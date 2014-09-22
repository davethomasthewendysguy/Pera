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


		/*$('#restaurant-menu-nav').click(function(e) {
			var hash = location.hash.replace('#', '');
		
			console.log(hash);
		
			if(hash) {
				$("#live-menu-" + hash).fadeIn("slow");
			
				console.log(hash);
			}
			
			e.preventDefault();
		});*/
		
		//LOAD APPROPRIATE MENU ON PAGE LOAD IF APPLICABLE
		var page_load_hash = window.location.hash;
		
		console.log(page_load_hash);
			
		if(page_load_hash) {
			if(page_load_hash == "#brunch") {
				$("#live-menu-brunch").fadeIn("slow");
			} else if(page_load_hash == "#lunch") {
				$("#live-menu-lunch").fadeIn("slow");
			} else if(page_load_hash == "#dinner") {
				$("#live-menu-dinner").fadeIn("slow");
			} else if(page_load_hash == "#dessert") {
				$("#live-menu-dessert").fadeIn("slow");
			} else if(page_load_hash == "#rooftop") {
				$("#live-menu-rooftop").fadeIn("slow");
			} else if(page_load_hash == "#happy-hour") {
				$("#live-menu-happy-hour").fadeIn("slow");
			}
		}
		
		
		
		$('a[href*=#]:not([href=#])').click(function(e) {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				$(".page-template-menu-php #food-navigation li").click(function() {
					//FIND A BETTER WAY, TIME PERMETTING
					if($(this).hasClass("brunch")) {
						$("#live-menu-brunch").fadeIn("slow");
						$("#live-menu-lunch").fadeOut("slow");
						$("#live-menu-dinner").fadeOut("slow");
						$("#live-menu-dessert").fadeOut("slow");
						$("#live-menu-rooftop").fadeOut("slow");
						$("#live-menu-happy-hour").fadeOut("slow");
					}
					
					if($(this).hasClass("lunch")) {
						$("#live-menu-lunch").fadeIn("slow");
						$("#live-menu-brunch").fadeOut("slow");
						$("#live-menu-dinner").fadeOut("slow");
						$("#live-menu-dessert").fadeOut("slow");
						$("#live-menu-rooftop").fadeOut("slow");
						$("#live-menu-happy-hour").fadeOut("slow");
					}
					
					if($(this).hasClass("dinner")) {
						$("#live-menu-dinner").fadeIn("slow");
						$("#live-menu-brunch").fadeOut("slow");
						$("#live-menu-lunch").fadeOut("slow");
						$("#live-menu-dessert").fadeOut("slow");
						$("#live-menu-rooftop").fadeOut("slow");
						$("#live-menu-happy-hour").fadeOut("slow");
					}
					
					if($(this).hasClass("dessert")) {
						$("#live-menu-dessert").fadeIn("slow");
						$("#live-menu-brunch").fadeOut("slow");
						$("#live-menu-lunch").fadeOut("slow");
						$("#live-menu-dinner").fadeOut("slow");
						$("#live-menu-rooftop").fadeOut("slow");
						$("#live-menu-happy-hour").fadeOut("slow");
					}
					
					if($(this).hasClass("rooftop")) {
						$("#live-menu-rooftop").fadeIn("slow");
						$("#live-menu-brunch").fadeOut("slow");
						$("#live-menu-lunch").fadeOut("slow");
						$("#live-menu-dinner").fadeOut("slow");
						$("#live-menu-dessert").fadeOut("slow");
						$("#live-menu-happy-hour").fadeOut("slow");
					}
					
					if($(this).hasClass("happy-hour")) {
						$("#live-menu-happy-hour").fadeIn("slow");
						$("#live-menu-brunch").fadeOut("slow");
						$("#live-menu-lunch").fadeOut("slow");
						$("#live-menu-dinner").fadeOut("slow");
						$("#live-menu-dessert").fadeOut("slow");
						$("#live-menu-rooftop").fadeOut("slow");
					}
				});
				
				var target = $(this.hash);
				
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				
				if(target.length) {
					
					if($("nav#cbp-spmenu-s2").hasClass("cbp-spmenu-open")) {
						closeMenu();
					}
					
					$('html,body').animate({
						scrollTop: target.offset().top - 170
					}, 1000);
					
					console.log("Alert");
					
					$(".page-template-menu-php #food-navigation").click(function() {
						console.log("Alert 2");
					});
					
					/*$("#site-navigation").click(function() {
						if(target.length) {
							console.log("Works 99");
		
							e.preventDefault();
						}
					});*/
					
					return false;
				}

				e.preventDefault();
			}
		});

		// This will capture hash changes while you are on the same page
		$(window).on("hashchange", function () {
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
				if($(document).scrollTop() > 500) { //SHOW THE FIXED MENU AFTER SCROLLING DOWN 700PX
					$('#main-menu').css("opacity","1");
					$('#logo-overlay').css("z-index","10");
				} else {
					$('#main-menu').css("opacity","0");
					//$('#logo-overlay').css("z-index","9999");
					
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
				$('#logo-overlay').css("z-index","10");
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
			console.log("Clicked");
		
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