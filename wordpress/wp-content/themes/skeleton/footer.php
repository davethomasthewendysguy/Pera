<script>
	jQuery(document).ready(function() {
		jQuery("ul.meal-selector li a").click(function(e) {			
			e.preventDefault();
			
			var selected_menu = jQuery(this).attr('class');
			var elem;
			var visible_elem;
			
			console.log("Selected Menu:" + selected_menu);
			
			jQuery("#restaurant-menu nav").each(function(index, el) {
				this_el = jQuery(this);
								
				//SET ELEMENT TO BE SHOWN
				if(this_el.hasClass(selected_menu)) {
					console.log("Has it!");
					elem = this_el;
				}
				
				//SET VISIBILE MENU ELEMENT
				if(this_el.css("display") == "block") {
					console.log("Visible");
					visible_elem = this_el;
				}
			});
			
			//console.log("Elem:" + elem);
			//console.log("Visible Elem:" + visible_elem);
			
			if(elem.hasClass(selected_menu) && visible_elem.hasClass(selected_menu)) {
				console.log("Same");
			}
			
			if((elem.hasClass(selected_menu)) && (elem != visible_elem)) {
				visible_elem.addClass('visuallyhidden');

				visible_elem.one('transitionend', function(e) {
					visible_elem.addClass('hidden');
				});
			
				//function() {
				if(elem.hasClass("hidden")) {
					elem.removeClass("hidden");
					setTimeout(function () {
						elem.removeClass("visuallyhidden");
					}, 20);
				}
				//});
			}
		});
	});
</script>

</body>
</html>
