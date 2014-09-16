
/*
Tipr 1.0.1
Copyright (c) 2013 Tipue
Tipr is released under the MIT License
http://www.tipue.com/tipr
*/


(function($) {

     $.fn.tipr = function(options) {
     
          var set = $.extend( {
          
               'speed'        : 200,
               'mode'         : 'top'
          
          }, options);

          return this.each(function() {
          
          		var tipr_cont = '.tipr_container_' + set.mode;

	            $(this).hover(
                	function () {
						$(this).css("background","red");

						var out = '<div class="tipr_container_' + set.mode + '"><div class="tipr_point_' + set.mode + '"><div class="tipr_content">' + $(this).attr('data-tip') + '</div></div><div class="tipr_arrow_' + set.mode + '"></div></div>';

						$(this).append(out);

						var w_t = $(tipr_cont).outerWidth();
						var w_e = $(this).width();
						var m_l = (w_e / 2) - (w_t / 2);

						m_l = m_l + 8;
                         
                        $(this).removeAttr('title');
                        $(tipr_cont).fadeIn(set.speed);              
                    },
                    function ()
                    {   
                    	$(this).css("background","transparent");
                        $(tipr_cont).remove();    
                    }     
               );
                              
          });
     };
     
    //TIPR DOES NOT ALIGN PROPERLY, USE UNIQUE CLASS TO TARGET BUTTON AND POSITION ACCORDINGLY
	$('#toolbar_hupso_toolbar_0 a:first-child').addClass("tip_facebook");
	$('#toolbar_hupso_toolbar_0 a:nth-child(2)').addClass("tip_twitter");
	$('#toolbar_hupso_toolbar_0 a:nth-child(3)').addClass("tip_gplus");
     
	var tipr_cont = '.tipr_container_' + set.mode;
	
	$(this).hover(function () {
		if($("#toolbar_hupso_toolbar_0 a").hasClass("tip_facebook")) {
			console.log("1");
			$(tipr_cont).css('margin-left','0px');
		} else if($("#toolbar_hupso_toolbar_0 a").hasClass("tip_twitter")) {
			console.log("2");
			$(tipr_cont).css('margin-left','32px');
		} else if($("#toolbar_hupso_toolbar_0 a").hasClass("tip_gplus")) {
			console.log("3");
			$(tipr_cont).css('margin-left','64px');
		}	
	});
})(jQuery);
