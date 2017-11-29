(function ($) {
	"use strict";

// Initialize preloader (dependency imageLoaded plugin)
// ----------------------------------------------------
	preloader();
// Initialize Plugins

	var chartOpts = {
			size       : 150,
			scaleLength: 1,
			barColor   : "#fff",
			trackColor : false,
			lineWidth  : 7,
			scaleColor : false,
			lineCap    : "square",
			rotate     : 90
		},
		smoothScrollOpts = {
			direction: "top",
			offset   : -65
		};


// Initialize Easy Pie Chart
	$(".chart-draw").easyPieChart(chartOpts);
	// and set it to 0, update it inside waypoint.
	$(".chart-draw").each(function () {
		var s = $(this);
		s.data("easyPieChart").update(0);
	});

// Smooth scroll plugin (learn-more btn)
// ---------------------------------
	$( '.learn-more a' ).off( 'click' ).on( 'click', function( e ) { 
		e.preventDefault();
		if (jQuery("#header_2").length) {
			
			var height_of = jQuery(window).height();
		}else if (jQuery("#header_3").length) {
			var height_of = jQuery(window).height() -$("#header_3").height();
		}else {
			var height_of = jQuery(window).height() -$("#header").height();
		}
		$('html, body').animate({
		    scrollTop: height_of
		}, 1000);
	});

// Animate Resume Page with waypoint
// ------------------------------------
	function animateResumePage() {
		var $rDescBox = $(".timeline-cont .desc-box"),
			oddBox = $rDescBox.filter(":odd"),
			evenBox = $rDescBox.filter(":even");
		$rDescBox.addClass("ar-desc-box");
		oddBox.addClass("ar-left");
		evenBox.addClass("ar-right");

		$rDescBox.waypoint({
			handler    : function () {
				var $s = $(this);
				if ($s.hasClass("ar-left"))
					$s.removeClass("ar-left");
				else
					$s.removeClass("ar-right");
			},
			triggerOnce: true,
			offset     : "100%"
		});
	}

	animateResumePage();    // Initialize

// Magnific Popup 
// -----------------------------------------
	$(".filter-port figure .prettyPhoto").magnificPopup({
		type       : "image",
	  	image: {
          	titleSrc: function(item) {
	            return item.el.parents('figure').find('h6').html();
          	},
          	tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        },
		key        : "image-key",
		verticalFit: true,
		mainClass  : "image-popup-style", // This same class is used for video popup
		tError     : '<a href="%url%">The image</a> could not be loaded.',
		gallery    : {
			enabled: true,
			tCounter: ''
		},
		callbacks  : {
			open : function () {
				this.content.addClass("fadeInLeft");
			},
			close: function () {
				this.content.removeClass("fadeInLeft");
			}
		}
	});


// Isotope Filter
// ----------------------------------------------
	function isotopeInit() {
		var $container = $(".filter-port"),
			$filter = $(".filter-menu");

		$(window).on("load resize", function () {
			$container.isotope({
				itemSelector     : ".item",
				animationEngine  : "best-available",
				transformsEnabled: true,
				resizesContainer : true,
				resizable        : true,
				easing           : "linear",
				layoutMode       : "masonry"
			});

			$filter.find("a").on("click touchstart", function (e) {
				var $t = $(this),
					selector = $t.data("filter");
				// Don't proceed if already selected
				if ($t.hasClass("filter-current"))
					return false;

				$filter.find("a").removeClass("filter-current");
				$t.addClass("filter-current");
				$container.isotope({filter: selector});

				e.stopPropagation();
				e.preventDefault();
			});
		})
	}

// Initialization
	isotopeInit();


// Form Validation and Settings
// ---------------------------------
	function formValidation() {
		var $form = $("#contact-form");//,
		$form.validate({
			rules       : {
				"name"   : {
					required : true,
					minlength: 2
				},
				"email"  : "required",
				"message": {
					required : true,
					minlength: 5
				}
			},
			errorClass  : "invalid-error",
			errorElement: "span",

		});

		$(".wpcf7-form i").click(function () {
			$("#contact-form").submit();
		});

		$("#form-submit").hover(
			function () {
				$(".wpcf7-form i").css('color', 'white');
				$("#form-submit").css('color', 'white');
			}, function () {
				$(".wpcf7-form i").css('color', '#151d2a');
				$("#form-submit").css('color', '#151d2a');
			}
		);

		$(".wpcf7-form i").hover(
			function () {
				$(this).css('color', 'white');
				$("#form-submit").css('color', 'white');
			}, function () {

			}
		);


	}

// Initialization
	formValidation();

// Main Navigation Config 
// ------------------------
	function mainNavInit() {
		var $mainNav = $(".main-nav"),
			$aboutSec = $(".inner-nav a").eq(1);
		$mainNav.find(".nav-control a, .nav-control").on("click touchstart", function (e) {
			if (e.target.parentNode == this) {
				if ($(this).parent().attr('class') == 'nav-control') {
					$(this).parent().find(".inner-nav").toggleClass("show-nav");
					$("#nav-toggle").toggleClass("active");
				} else {

					$(this).find(".inner-nav").toggleClass("show-nav");
					if ($(this).find(".inner-nav").attr('class'))
						$("#nav-toggle").toggleClass("active");
				}


				e.stopPropagation();
				e.preventDefault();
			}
		});

		$( '.inner-nav a' ).off( 'click' ).on( 'click', function( e ) { 
			var thisHref = jQuery(this).attr('href');
			if (thisHref.charAt(0) != "#") {
				window.location.href = thisHref;
			}else if (jQuery(thisHref).length) {
			}else {
				window.location.href = thisHref;
			}
		});
		// initialize smooth scroll for this
		$aboutSec.smoothScroll(smoothScrollOpts); // for `aboutSection` offset is different.
		$mainNav.find(".inner-nav a").not($aboutSec).smoothScroll({
			direction: "top",
			// offset   : -104,
			offset: -(jQuery("#header").height()),
			speed    : 800
		});
	}

// Iniitialization
	mainNavInit();


// Main Navigation 2 Config 
// ------------------------
	var before = false;
	function mainNav2Init() {
		$( '#header_2 .navbar-nav a' ).off( 'click' ).on( 'click', function( e ) { 
			 e.preventDefault();

			var thisHref = jQuery(this).attr('href');
			if (thisHref.charAt(0) != "#") {
				window.location.href = thisHref;
			}else if (jQuery(thisHref).length) {
			}else {
				window.location.href = thisHref;
			}
			var about = $( '#header_2 .navbar-nav a' ).eq(1).attr('href');
			if (jQuery(this).attr('href') != about) {
				$('html, body').animate({
	                scrollTop: $(jQuery(this).attr('href')).offset().top -($("#header_2").height())
	            }, 1000);
	        }else {
	        	$('html, body').animate({
	                scrollTop: $(jQuery(this).attr('href')).offset().top -($("#header_2").height())
	            }, 1000);
	        }
		});

	}

// Iniitialization nav 2
	mainNav2Init();

// Main Navigation 3 Config 
// ------------------------
	function mainNav3Init() {
		$( '#header_3 .navbar-nav a' ).off( 'click' ).on( 'click', function( e ) { 
			e.preventDefault();

			var thisHref = jQuery(this).attr('href');
			if (thisHref.charAt(0) != "#") {
				window.location.href = thisHref;
			}else if (jQuery(thisHref).length) {
			}else {
				window.location.href = thisHref;
			}
			var about = $( '#header_3 .navbar-nav a' ).eq(1).attr('href');
			if (jQuery(this).attr('href') != about) {
				$('html, body').animate({
	                scrollTop: $(jQuery(this).attr('href')).offset().top -($("#header_3").height())
	            }, 1000);
	        }else {
	        	$('html, body').animate({
	                scrollTop: $(jQuery(this).attr('href')).offset().top - ($("#header_3").height())
	            }, 1000);
	        }
		});

	}

// Iniitialization nav 3
	mainNav3Init();

// Preloader (require pace.min.js)
	function preloader() {
		$(window).on("load", function () {
			Pace.on("done", function () {
				$("#preload").delay(100).fadeOut(500);
			});
		});
	}

})(jQuery);

jQuery(function ($) {
	if (jQuery().flexslider) {
		$('.post-formats-wrapper .flexslider').flexslider({
			animation : "slide",
			prevText  : "<i class='fa fa-angle-left'></i>",
			nextText  : "<i class='fa fa-angle-right'></i>",
			controlNav: false
		});
	}
 });

//BEGIN DOCUMENT.READY FUNCTION
jQuery(document).ready(function () {
	jQuery( ".inner-nav > li > a > span" ).hover(
    	function() {
    		z=100;
    		jQuery(this).parent().parent().children("ul").css("right", ""+z+"%");
			jQuery(this).parent().parent().children("ul").css("width", ""+(jQuery(this).width()+42)+"px");
       	}, function() {
        }
    );
	jQuery( ".inner-nav > li" ).hover(
    	function() {
       	}, function() {
       		jQuery(this).children("ul").css("right", "-500%");
        }
    );
	/* ------------------------------------------------------------------------ */
	/* BACK TO TOP
	 /* ------------------------------------------------------------------------ */

	$(window).scroll(function () {
		if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
			$('#return-to-top').fadeIn(200);    // Fade in the arrow
		} else {
			$('#return-to-top').fadeOut(200);   // Else fade out the arrow
		}
	});
	$('#return-to-top').click(function () {      // When arrow is clicked
		$('body,html').animate({
			scrollTop: 0                       // Scroll to top of body
		}, 500);
	});

	// Footer Closer
	// ======================
	var finished = true;
	jQuery('.close-footer i').click(function() {
		
		if (finished) {
			finished = false;
			if (jQuery('.footer-contact').css("position") == "static") {
				jQuery('.footer-contact').css({position: 'relative'});
				var checked = false;
			}else {
				var checked = true;
			}
		  	jQuery('.footer-active').slideToggle( "slow", function() {
		  		if (checked) {
					jQuery('.footer-contact').css({position: 'static'});
		  		}
		  		finished = true;
			});	
		}
	});

});
//END DOCUMENT.READY FUNCTION

var scrollTimer = false,
	scrollHandler = function () {
		var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
		jQuery('.inner-nav li a[href^=#]').each(function () {
			var thisHref = jQuery(this).attr('href');
			if (jQuery(thisHref).length) {

				var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10),
					thisPosition = thisTruePosition - 65;
				if (scrollPosition <= parseInt(jQuery(jQuery('.inner-nav li a[href^=#]').first().attr('href')).height(), 10) + 2 - 65) {

					if (scrollPosition >= thisPosition) {
						jQuery('.inner-nav li a[href^=#]').removeClass('nav-active');
						jQuery('.inner-nav li a[href=' + thisHref + ']').addClass('nav-active');
					}
				} else {
					if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
						jQuery('.inner-nav li a[href^=#]').removeClass('nav-active');
						jQuery('.inner-nav li a[href=' + thisHref + ']').addClass('nav-active');
					}
				}
			}
		});

		/** header 2**/
		var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
		jQuery('#header_2 .navbar-nav li a[href^=#]').each(function () {
			var thisHref = jQuery(this).attr('href');
			if (jQuery(thisHref).length) {

				var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10),
					thisPosition = thisTruePosition - jQuery("#header_2").height();
				if (scrollPosition <= parseInt(jQuery(jQuery('.navbar-nav li a[href^=#]').first().attr('href')).height(), 10)) {

					if (scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^=#]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href=' + thisHref + ']').addClass('nav-active');
					}
				} else {
					if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^=#]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href=' + thisHref + ']').addClass('nav-active');
					}
				}
			}
		});

		/** header 3**/
		var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
		jQuery('#header_3 .navbar-nav li a[href^=#]').each(function () {
			var thisHref = jQuery(this).attr('href');
			if (jQuery(thisHref).length) {

				var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10),
					thisPosition = thisTruePosition - jQuery("#header_3").height();
				if (scrollPosition <= parseInt(jQuery(jQuery('.navbar-nav li a[href^=#]').first().attr('href')).height(), 10)) {

					if (scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^=#]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href=' + thisHref + ']').addClass('nav-active');
					}
				} else {
					if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^=#]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href=' + thisHref + ']').addClass('nav-active');
					}
				}
			}
		});
	}

window.clearTimeout(scrollTimer);
scrollHandler();


jQuery(window).scroll(function () {
	window.clearTimeout(scrollTimer);
	scrollTimer = window.setTimeout(function () {
		scrollHandler();
	}, 20);
});
var xy = "";
function sr_FullHeightScreen () {
	if (jQuery("#header_2").length) {
		if (jQuery(".top_site_main").length) {
			jQuery('.top_site_main').css({'margin-bottom':jQuery("#header_2").height()});	
			window_height = jQuery('.top_site_main').height();	
		}else {
			window_height = jQuery(window).height();
			jQuery('div.home').css({height:window_height});	
			if (xy == "") {
				xy = jQuery("#header_2").height() + parseInt(jQuery("#header_2").next().css('margin-top'), 10);
			}
			jQuery("#header_2").next().css({'margin-top':xy});
		}
		if (parseInt(jQuery(window).scrollTop(), 10) >= window_height) {
			jQuery('#header_2').removeClass("h-top");	
			jQuery('#header_2').addClass("h-fixed");	
		}else {
			jQuery('#header_2').removeClass("h-fixed");	
			jQuery('#header_2').addClass("h-top");	
			
			jQuery('#header_2').css({top:window_height});	
		}
	}else if (jQuery("#header_3").length) { 
		if (jQuery(".top_site_main").length) {
			window_height = jQuery('.top_site_main').height();	
		}else {
			window_height = jQuery(window).height();
			jQuery('div.home').css({height:window_height});	
		}

		if (parseInt(jQuery(window).scrollTop(), 10) >= window_height-jQuery("#header_3").height()) {
			jQuery('#header_3').addClass("h3_bg");	
		}else {
			jQuery('#header_3').removeClass("h3_bg");	
		}
	}
	else {
		window_height = jQuery(window).height();
		jQuery('div.home').css({height:window_height});	
	}
}
sr_FullHeightScreen();
jQuery(window).bind('resize',function() {	  
	sr_FullHeightScreen();	 	 
});

jQuery(window).scroll(function () {
	sr_FullHeightScreen();
});

jQuery(document).ready(function($) {
	jQuery('.am_animate_when_almost_visible:not(.am_start_animation)').waypoint(function() {
			jQuery(this).addClass('am_start_animation');
	}, { offset: '85%' });
	
	count_down = 0;
	countInterval = setInterval(function () {
		if (count_down < 20) {
			if (jQuery('.owl-wrapper-outer').length) {
		        jQuery('.owl-wrapper-outer').each(function () {
		        	var wh = jQuery(this).height()/2;
		        	if (wh < 30) {
		        		wh = 0;
		        	}else {
		        		wh = wh-30;
		        	}
		        	jQuery(this).next().find('.owl-prev').css({top:wh});
		        	jQuery(this).next().find('.owl-next').css({top:wh});
		        });
		    }
			count_down++;
		} else {
			clearInterval(countInterval);
		}
	}, 2000);
	
	
	
}); // END jQuery(document).ready
$(document).ready(function() { 
	if ($('body').hasClass('single-post')) {
		//alert(window.location.hash.replace('#', ''));
		var elem = window.location.hash.replace('#', '');
	    if(elem && $("#header").length) {
	    	//alert(elem);
	        //$.scrollTo(elem.left, elem.top+100);
	        $('html, body').animate({
		        scrollTop: $( "#"+elem ).offset().top-$("#header").height()
		    }, 500);
	    }	
	}
});