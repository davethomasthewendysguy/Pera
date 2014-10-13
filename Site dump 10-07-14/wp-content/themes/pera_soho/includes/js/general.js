/*-----------------------------------------------------------------------------------*/
/* Run scripts on jQuery(document).ready() */
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function() {

    jQuery('<span class="custom-menu-toggle"></span>').appendTo(jQuery('.widget_nav_menu .widget-title'));



    jQuery('.widget_nav_menu .widget-title').on('click', function(evt) {
        evt.preventDefault();

        var ios = /iPhone|iPad|iPod/i.test(navigator.userAgent);

        if (ios) {
            jQuery(this).siblings().slideToggle();
        }
    });

    // FitVids - Responsive Videos
    jQuery('.widget, .panel, .video').fitVids();
    if (window.innerWidth < 768) {
        jQuery('.entry').fitVids();
    }

    // Add class to parent menu items with JS until WP does this natively
    jQuery('ul.sub-menu, ul.children').parents('li').addClass('parent');

    // Responsive Navigation (switch top drop down for select)
    jQuery('ul#top-nav').mobileMenu({
        switchWidth: 767, //width (in px to switch at)
        topOptionText: woo_localized_data.select_a_page, //first option text
        indentString: '&nbsp;&nbsp;&nbsp;' //string for indenting nested items
    });

    // Show/hide the main navigation
    /* 	jQuery( '.nav-toggle' ).click(function() {
	  jQuery( '#navigation' ).slideToggle( 'fast', function() {
	  	return false;
	    // Animation complete.
	  });


	});*/

    // Stop the navigation link moving to the anchor (Still need the anchor for semantic markup)
    jQuery('.nav-toggle a').click(function(e) {
        e.preventDefault();
    });

    /*-----------------------------------------------------------------------------------*/
    /* Add rel="lightbox" to image links if the lightbox is enabled */
    /*-----------------------------------------------------------------------------------*/

    if (jQuery('body').hasClass('has-lightbox') && !jQuery('body').hasClass('portfolio-component')) {
        jQuery('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".png"]').each(function() {
            var imageTitle = '';
            if (jQuery(this).next().hasClass('wp-caption-text')) {
                imageTitle = jQuery(this).next().text();
            }

            if ('' != imageTitle) {
                jQuery(this).attr('title', imageTitle);
            }

            if (jQuery(this).parents('.gallery').length) {
                var galleryID = jQuery(this).parents('.gallery').attr('id');
                jQuery(this).attr('rel', 'lightbox[' + galleryID + ']');
            } else {
                jQuery(this).attr('rel', 'lightbox');
            }
        });

        jQuery('a[rel^="lightbox"]').prettyPhoto({
            social_tools: false
        });
    }

    /*-----------------------------------------------------------------------------------*/
    /* Add alt-row styling to tables */
    /*-----------------------------------------------------------------------------------*/

    jQuery('.entry table tr:odd').addClass('alt-table-row');
}); // End jQuery()

/*-----------------------------------------------------------------------------------*/
/* Run scripts on load only. */
/*-----------------------------------------------------------------------------------*/
window.onload = function() {
    (function($) {
        /*--[ Posts More ]------ */
        var $postMore = $('.post-more'),
            padding = 19;
        if ($postMore.length != 0) {
            $postMore.each(function(i) {
                var readMoreLength = parseInt($(this).find('.read-more').outerWidth(true)) + padding;
                var dateTimePublished = parseInt($(this).find('.date.time.published').outerWidth(true)) + padding;

                if (readMoreLength)
                    $(this).find('.module-magic-divider').css({
                        'padding-left': readMoreLength + 'px'
                    });

                if (readMoreLength)
                    $(this).find('.module-magic-divider').css({
                        'padding-right': dateTimePublished + 'px'
                    });
            });
        }



        /*--[ Remove AJAX hash ]------ */
        window.location.hash = '';
    })(jQuery);
}

/* Custom JS */
active = 2;
fullScreen = 0;

jQuery(document).ready(function($) {

    twitterFetcher.fetch('428636397520441344', '', 1, true, false, false, '', false, handleTweets, false);


    function handleTweets(tweets) {
        var x = tweets.length;
        var n = 0;
        var element = jQuery('.twitter-footer, .twitter-bar-header');
        var html = '';
        while (n < x) {
            html += tweets[n];
            console.log(tweets[n]);
            n++;
        }
        element.html(html);
    }

    $('.nav-toggle').click(function() {
        outerWidth = $(window).width();

        $('html, body, #main-wrapper, .mobile-nav').toggleClass('active-mobile');
        if (active == 1) {
            $('#main-wrapper, body').css('width', '');
            active = 0;
        } else if (active == 2 || active == 0) {
            $('body').css('width', outerWidth - 220);
            $('#main-wrapper').css('width', outerWidth);
            active = 1;
        }



    });

    $('#main').delay(100).queue(function(next) {
        $('#cgm-iso-fullscreen-button').click(function() {

            if (fullScreen == 0) {
                fullScreen = 1;
                $('#wrapper').css('position', 'relative');
                $('#wrapper').css('z-index', '99');
            } else {
                $('#wrapper').css('position', '');
                $('#wrapper').css('z-index', '');

                fullScreen = 0;
            }

        });
        next();
    });




    currentsubpage = $('#sidebar .widget_nav_menu .menu .current-menu-item');


    windowSize = $(window).outerWidth();
    if (windowSize <= 500) {
        currentsubpage.delay(100).queue(function(next) {
            currentpageHeight = $(this).outerHeight();
            $('#sidebar .widget_nav_menu .menu').css('padding-top', currentpageHeight);
            next();
        });

    }

    currentsubpage.click(function(e) {
        e.preventDefault();
        $('#sidebar .widget_nav_menu .menu').toggleClass('active');
    });

    $('.special-offer .clear').remove();

    $(window).resize(function() {

        windowSize = $(window).outerWidth();
        outerWidth = $(window).width();


        if (windowSize >= 800) {
            $('#main-wrapper, body').css('width', '');
        } else if (active == 1) {
            $('body').css('width', outerWidth - 220);
            $('#main-wrapper').css('width', outerWidth);
        }

        if (windowSize <= 500) {
            currentsubpage.delay(100).queue(function(next) {
                currentpageHeight = $(this).outerHeight();
                $('#sidebar .widget_nav_menu .menu').css('padding-top', currentpageHeight);
                next();
            });

            currentsubpage.click(function(e) {
                e.preventDefault();
            });



        } else {
            currentsubpage.delay(100).queue(function(next) {
                $('#sidebar .widget_nav_menu .menu').css('padding-top', '');
                next();
            });
        }

    });

});


var twitterFetcher = function() {
    function x(e) {
        return e.replace(/<b[^>]*>(.*?)<\/b>/gi, function(c, e) {
            return e
        }).replace(/class=".*?"|data-query-source=".*?"|dir=".*?"|rel=".*?"/gi, "")
    }

    function p(e, c) {
        for (var g = [], f = RegExp("(^| )" + c + "( |$)"), a = e.getElementsByTagName("*"), h = 0, d = a.length; h < d; h++) f.test(a[h].className) && g.push(a[h]);
        return g
    }
    var y = "",
        l = 20,
        s = !0,
        k = [],
        t = !1,
        q = !0,
        r = !0,
        u = null,
        v = !0,
        z = !0,
        w = null,
        A = !0;
    return {
        fetch: function(e, c, g, f, a, h, d, b, m, n) {
            void 0 === g && (g = 20);
            void 0 === f && (s = !0);
            void 0 === a && (a = !0);
            void 0 === h && (h = !0);
            void 0 === d && (d = "default");
            void 0 === b && (b = !0);
            void 0 === m && (m = null);
            void 0 === n && (n = !0);
            t ? k.push({
                id: e,
                domId: c,
                maxTweets: g,
                enableLinks: f,
                showUser: a,
                showTime: h,
                dateFunction: d,
                showRt: b,
                customCallback: m,
                showInteraction: n
            }) : (t = !0, y = c, l = g, s = f, r = a, q = h, z = b, u = d, w = m, A = n, c = document.createElement("script"), c.type = "text/javascript", c.src = "//cdn.syndication.twimg.com/widgets/timelines/" + e + "?&lang=en&callback=twitterFetcher.callback&suppress_response_codes=true&rnd=" + Math.random(), document.getElementsByTagName("head")[0].appendChild(c))
        },
        callback: function(e) {
            var c = document.createElement("div");
            c.innerHTML = e.body;
            "undefined" === typeof c.getElementsByClassName && (v = !1);
            e = [];
            var g = [],
                f = [],
                a = [],
                h = [],
                d = 0;
            if (v)
                for (c = c.getElementsByClassName("tweet"); d < c.length;) {
                    0 < c[d].getElementsByClassName("retweet-credit").length ? a.push(!0) : a.push(!1);
                    if (!a[d] || a[d] && z) e.push(c[d].getElementsByClassName("e-entry-title")[0]), h.push(c[d].getAttribute("data-tweet-id")), g.push(c[d].getElementsByClassName("p-author")[0]), f.push(c[d].getElementsByClassName("dt-updated")[0]);
                    d++
                } else
                    for (c = p(c, "tweet"); d < c.length;) e.push(p(c[d], "e-entry-title")[0]), h.push(c[d].getAttribute("data-tweet-id")), g.push(p(c[d], "p-author")[0]), f.push(p(c[d], "dt-updated")[0]), 0 < p(c[d], "retweet-credit").length ? a.push(!0) : a.push(!1), d++;
            e.length > l && (e.splice(l, e.length - l), g.splice(l, g.length - l), f.splice(l, f.length - l), a.splice(l, a.length - l));
            c = [];
            d = e.length;
            for (a = 0; a < d;) {
                if ("string" !== typeof u) {
                    var b = new Date(f[a].getAttribute("datetime").replace(/-/g, "/").replace("T", " ").split("+")[0]),
                        b = u(b);
                    f[a].setAttribute("aria-label", b);
                    if (e[a].innerText)
                        if (v) f[a].innerText = b;
                        else {
                            var m = document.createElement("p"),
                                n = document.createTextNode(b);
                            m.appendChild(n);
                            m.setAttribute("aria-label", b);
                            f[a] = m
                        } else f[a].textContent = b
                }
                b = "";
                animatedimg = (jQuery('body').hasClass('landing')) ? ('<img class="twitterbirdanimated" src="'+woo_localized_data.site_url+'/wp-content/themes/pera/images/twitterbirdanim.gif" alt="" style="position: absolute; top: 12px; z-index: 1000; left: 54px;">') : '';

                s ? (r && (b += '<div class="user">' + x(g[a].innerHTML) + "</div>"), b += animatedimg + '<p class="tweet">' + x(e[a].innerHTML) + "</p>", q && (b += '<p class="timePosted">' + f[a].getAttribute("aria-label") + "</p>")) : e[a].innerText ? (r && (b += '<p class="user">' + g[a].innerText + "</p>"), b += '<p class="tweet">' + e[a].innerText +
                    "</p>", q && (b += '<p class="timePosted">' + f[a].innerText + "</p>")) : (r && (b += '<p class="user">' + g[a].textContent + "</p>"), b += '<p class="tweet">' + e[a].textContent + "</p>", q && (b += '<p class="timePosted">' + f[a].textContent + "</p>"));
                A && (b += '<p class="interact"><a href="https://twitter.com/intent/tweet?in_reply_to=' + h[a] + '" class="twitter_reply_icon">Reply</a><a href="https://twitter.com/intent/retweet?tweet_id=' + h[a] + '" class="twitter_retweet_icon">Retweet</a><a href="https://twitter.com/intent/favorite?tweet_id=' +
                    h[a] + '" class="twitter_fav_icon">Favorite</a></p>');
                c.push(b);
                a++
            }
            if (null == w) {
                e = c.length;
                g = 0;
                f = document.getElementById(y);
                for (h = "<ul>"; g < e;) h += "<li>" + c[g] + "</li>", g++;
                f.innerHTML = h + "</ul>"
            } else w(c);
            t = !1;
            0 < k.length && (twitterFetcher.fetch(k[0].id, k[0].domId, k[0].maxTweets, k[0].enableLinks, k[0].showUser, k[0].showTime, k[0].dateFunction, k[0].showRt, k[0].customCallback, k[0].showInteraction), k.splice(0, 1))
        }
    }
}();