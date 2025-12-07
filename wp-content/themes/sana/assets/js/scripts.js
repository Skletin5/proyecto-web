"use strict";

jQuery(document).on('ready', function() { 

	initSwiper();
	initEvents();
	initStyles();
	initMap();
	initCollapseMenu();	
	checkCountUp();	
	initScrollReveal();
	initCountDown();
	initOnScroll();

	//setTimeout(function() { window.dispatchEvent(new Event('resize')); }, 1000);
});

jQuery(window).on('scroll', function (event) {

	checkNavbar();
	checkGoTop();
}).scroll();

jQuery(window).on('load', function(){

	initMasonry();
	initParallax();
});

jQuery(window).on("resize", function () {

	setResizeStyles();
}).resize();



/* Navbar menu initialization */
function initCollapseMenu() {

	var navbar = jQuery('#navbar'),
		navbar_toggle = jQuery('.navbar-toggle'),
		navbar_wrapper = jQuery("#nav-wrapper");

    navbar_wrapper.on('click', '.navbar-toggle', function (e) {

        navbar_toggle.toggleClass('collapsed');
        navbar.toggleClass('collapse');
        navbar_wrapper.toggleClass('mob-visible');
    });

	// Anchor mobile menu
	navbar.on('click', '.menu-item-type-custom > a', function(e) {

		if ( typeof jQuery(this).attr('href') !== 'undefined' && jQuery(this).attr('href') !== '#' && jQuery(this).attr('href').charAt(0) === '#' )  {

	        navbar_toggle.addClass('collapsed');
	        navbar.addClass('collapse');
	        navbar_wrapper.removeClass('mob-visible');
    	}  	    
    });

    navbar.on('click', '.menu-item-has-children > a', function(e) {

    	var el = jQuery(this);

    	if (!el.closest('#navbar').hasClass('collapse')) {

    		if ((el.attr('href') === undefined || el.attr('href') === '#') || e.target.tagName == 'A') {

		    	el.next().toggleClass('show');
		    	el.next().children().toggleClass('show');
		    	el.parent().toggleClass('show');

		    	return false;
		    }
	    }
    });

    var lastWidth;
    jQuery(window).on("resize", function () {

    	checkNavbar();

    	var winWidth = jQuery(window).width(),
    		winHeight = jQuery(window).height();

       	lastWidth = winWidth;
    });	
}

/* Navbar attributes depends on resolution and scroll status */
function checkNavbar() {

	var navbar = jQuery('#navbar'),
		scroll = jQuery(window).scrollTop(),
    	navBar = jQuery('nav.navbar:not(.no-dark)'),
    	topBar = jQuery('.ltx-topbar-block'),
    	navbar_toggle = jQuery('.navbar-toggle'),
    	navbar_wrapper = jQuery("#nav-wrapper"),
	    slideDiv = jQuery('.slider-full'),
	    winWidth = jQuery(window).width(),
    	winHeight = jQuery(window).height(),
		navbar_mobile_width = navbar.data('mobile-screen-width');

   	if ( winWidth < navbar_mobile_width ) {

		navbar.addClass('navbar-mobile').removeClass('navbar-desktop');
	}
		else {

		navbar.addClass('navbar-desktop').removeClass('navbar-mobile');
	}

	navbar_wrapper.addClass('inited');

	if ( topBar.length ) {

		navBar.data('offset-top', topBar.height());
	}

    if (winWidth > navbar_mobile_width && navbar_toggle.is(':hidden')) {

        navbar.addClass('collapse');
        navbar_toggle.addClass('collapsed');
        navbar_wrapper.removeClass('mob-visible');
    }

    jQuery("#nav-wrapper.navbar-layout-transparent + .page-header, #nav-wrapper.navbar-layout-transparent + .main-wrapper").css('margin-top', '-' + navbar_wrapper.height() + 'px');


    if (scroll > 1) navBar.addClass('dark'); else navBar.removeClass('dark');
}


/* Check GoTop Visibility*/
function checkGoTop() {

	var gotop = jQuery('.ltx-go-top'),
		scrollBottom = jQuery(document).height() - jQuery(window).height() - jQuery(window).scrollTop();

	if ( gotop.length ) {

		if ( jQuery(window).scrollTop() > 100 ) {

			gotop.addClass('show');
		}
			else {

			gotop.removeClass('show');
    	}

    	if ( scrollBottom < 50 ) {

    		gotop.addClass('scroll-bottom');
    	}
    		else {

    		gotop.removeClass('scroll-bottom');
   		}
	}	
}

/* All keyboard and mouse events */
function initEvents() {

	setTimeout(function() { if ( typeof Pace !== 'undefined' ) { Pace.stop(); }  }, 3000);	

	jQuery('.swipebox.photo').magnificPopup({type:'image', gallery: { enabled: true }});
	jQuery('.swipebox.image-video').magnificPopup({type:'iframe'});

	if (!/Mobi/.test(navigator.userAgent) && jQuery(window).width() > 768) {

		jQuery('.matchHeight').matchHeight();
		jQuery('.items-matchHeight article').matchHeight();
	}	

	// WooCommerce grid-list toggle
	jQuery('.gridlist-toggle').on('click', 'a', function() {

		jQuery('.matchHeight').matchHeight();
	});

	jQuery('.menu-types').on('click', 'a', function() {

		var el = jQuery(this);

		el.addClass('active').siblings('.active').removeClass('active');
		el.parent().find('.type-value').val(el.data('value'));

		return false;
	});

	/* Scrolling to navbar from "go top" button in footer */
    jQuery('.ltx-go-top').on('click', function() {

    	jQuery('html, body').animate({ scrollTop: 0 }, 1200);
    	
    	return false;
	});

    jQuery('.alert').on('click', '.close', function() {

	    jQuery(this).parent().fadeOut();
	    return false;
	});	

	jQuery(".topbar-icons.mobile, .topbar-icons.icons-hidden")
		.mouseover(function() {

			jQuery('.topbar-icons.icons-hidden').addClass('show');
			jQuery('#navbar').addClass('muted');
		})
		.mouseout(function() {
			jQuery('.topbar-icons.icons-hidden').removeClass('show');
			jQuery('#navbar').removeClass('muted');
	});

	// TopBar Search
    var searchHandler = function(event){

        if (jQuery(event.target).is(".top-search, .top-search *")) return;
        jQuery(document).off("click", searchHandler);
        jQuery('.top-search').removeClass('show-field');
        jQuery('#navbar').removeClass('muted');
    }

    jQuery('#top-search-ico-close').on('click', function (e) {

		jQuery(this).parent().toggleClass('show-field');
		jQuery('#navbar').toggleClass('muted');    	
    });

	jQuery('#top-search-ico').on('click', function (e) {

		e.preventDefault();
		jQuery(this).parent().toggleClass('show-field');
		jQuery('#navbar').toggleClass('muted');

        if (jQuery(this).parent().hasClass('show-field')) {

        	jQuery(document).on("click", searchHandler);
        }
        	else {

        	jQuery(document).off("click", searchHandler);
        }
	});

	jQuery('#top-search-ico-mobile').on('click', function() {

		window.location = '/?s=' + jQuery(this).next().val();
		return false;
	});	

	jQuery('.top-search input').keypress(function (e) {
		if (e.which == 13) {
			window.location = '/?s=' + jQuery(this).val();
			return false;
		}
	});

	jQuery('.ltx-navbar-search span').on('click', function (e) {
		window.location = '/?s=' + jQuery('.ltx-navbar-search input').val();
	});	

	jQuery('.woocommerce').on('click', 'div.quantity > span', function(e) {

		var f = jQuery(this).siblings('input');
		if (jQuery(this).hasClass('more')) {
			f.val(Math.max(0, parseInt(f.val()))+1);
		} else {
			f.val(Math.max(1, Math.max(0, parseInt(f.val()))-1));
		}
		e.preventDefault();

		jQuery(this).siblings('input').change();

		return false;
	});

	if ( jQuery("#ltx-modal").length && !ltxGetCookie('ltx-modal-cookie') ) {

		jQuery("#ltx-modal").modal("show");
	}

	jQuery('#ltx-modal').on('click', '.ltx-modal-yes', function() {
	
    	jQuery('body').removeClass('modal-open');
	    jQuery('#ltx-modal').remove();
	    jQuery('.modal-backdrop').remove();
	    ltxSetCookie('ltx-modal-cookie', 1, jQuery(this).data('period'));
	});	

	jQuery('#ltx-modal').on('click', '.ltx-modal-no', function() {

	    window.location.href = jQuery(this).data('no');
	    return false;
	});		

	jQuery('.navbar').on( 'affix.bs.affix', function(){

	    if (!jQuery( window ).scrollTop()) return false;
	});		
}

function initCountDown() {

	var countDownEl = jQuery('.ltx-countdown');

	if (jQuery(countDownEl).length) {

			jQuery(countDownEl).each(function(i, el) {

			jQuery(el).countdown(jQuery(el).data('date'), function(event) {

				jQuery(this).html(event.strftime('' + jQuery(countDownEl).data('template')));
			});		
		});
	}
}

function ltxUrlDecode(str) {

   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}

/* Parallax initialization */
function initParallax() {

	// Only for desktop
	if (/Mobi/.test(navigator.userAgent)) return false;

	jQuery('.ltx-parallax').parallax("50%", 0.2);	
	jQuery('.ltx-parallax.wpb_column .vc_column-inner').parallax("50%", 0.3);	

	if ( jQuery('.ltx-parallax-slider').length ) {

		jQuery('.ltx-parallax-slider').each(function(e, el) {

			var scene = jQuery(el).get(0);
			var parallaxInstance = new Parallax(scene, {

				hoverOnly : true,
				selector : '.ltx-layer',
				limitY : 0,
			});
		});
	}

	jQuery('.ltx-bg-parallax-enabled:not(.wpb_column)').each(function(i, el) {

		var val = jQuery(el).attr('class').match(/ltx-bg-parallax-value-(\S+)/); 	

		jQuery(el).parallax("50%", parseFloat(val[1]));	
	});	

	jQuery('.ltx-bg-parallax-enabled.wpb_column').each(function(i, el) {

		var val = jQuery(el).attr('class').match(/ltx-bg-parallax-value-(\S+)/); 	

		jQuery(el).children('.vc_column-inner').parallax("50%", parseFloat(val[1]));	
	});	

	jQuery(".ltx-scroll-parallax").each(function(i, el) {

		jQuery(el).paroller({ factor: jQuery(el).data('factor'), type: 'foreground', direction: jQuery(el).data('direction') });
	});


	jQuery(".ltx-parallax-slider .layer").each(function(i, el) {

		jQuery(el).paroller({ factor: jQuery(el).data('factor'), type: jQuery(el).data('type'), direction: jQuery(el).data('direction') });
	});	
}

/* Adding custom classes to element */
function initStyles() {

	jQuery('form:not(.checkout, .woocommerce-shipping-calculator) select:not(#rating), aside select').wrap('<div class="select-wrap"></div>');
	jQuery('.wpcf7-checkbox').parent().addClass('margin-none');

	jQuery('input[type="submit"], button[type="submit"]').not('.btn').addClass('btn btn-xs');
	jQuery('#send_comment').removeClass('btn-xs');
	jQuery('#searchsubmit').removeClass('btn');

	jQuery('.form-btn-shadow .btn,.form-btn-shadow input[type="submit"]').addClass('btn-shadow');
	jQuery('.form-btn-wide .btn,.form-btn-wide input[type="submit"]').addClass('btn-wide');


	jQuery('.woocommerce .button').addClass('btn btn-black color-hover-main').removeClass('button');
	jQuery('.woocommerce .wc-forward:not(.checkout)').removeClass('btn-black').addClass('btn-main');
	jQuery('.woocommerce-message .btn, .woocommerce-info .btn').addClass('btn-xs');
	jQuery('.woocommerce .price_slider_amount .btn').removeClass('btn-black color-hover-white').addClass('btn btn-main btn-xs color-hover-black');
	jQuery('.woocommerce .checkout-button').removeClass('btn-black color-hover-white').addClass('btn btn-main btn-xs color-hover-black');
	jQuery('button.single_add_to_cart_button').removeClass('btn-xs color-hover-white').addClass('color-hover-main');
	jQuery('.woocommerce .coupon .btn').removeClass('color-hover-white').addClass('color-hover-main');

	jQuery('.widget_product_search button').removeClass('btn btn-xs');
	jQuery('.input-group-append .btn').removeClass('btn-xs');

	jQuery('.ltx-hover-logos img').each(function(i, el) { jQuery(el).clone().addClass('ltx-img-hover').insertAfter(el); });
	
	jQuery(".container input[type=\"submit\"], .container input[type=\"button\"], .container .btn").wrap('<span class="ltx-btn-wrap"></span');
	jQuery('.search-form .ltx-btn-wrap').removeClass('ltx-btn-wrap');
	jQuery('.ltx-btn-wrap > .btn-main').parent().addClass('ltx-btn-wrap-main');
	jQuery('.ltx-btn-wrap > .btn-black').parent().addClass('ltx-btn-wrap-black');
	jQuery('.ltx-btn-wrap > .btn-white').parent().addClass('ltx-btn-wrap-white');

	jQuery('.ltx-btn-wrap > .color-hover-main').parent().addClass('ltx-btn-wrap-hover-main');
	jQuery('.ltx-btn-wrap > .color-hover-black').parent().addClass('ltx-btn-wrap-hover-black');
	jQuery('.ltx-btn-wrap > .color-hover-white').parent().addClass('ltx-btn-wrap-hover-white');

	jQuery('.woocommerce .products .item .ltx-btn-wrap .btn').addClass('btn-xs');

	jQuery('.woocommerce .products .item').each(function(i, el) {

		jQuery(el).find('.ltx-btn-wrap-black').clone().appendTo(jQuery(el).find('.image'));
	});
	
	jQuery(".container .wpcf7-submit").addClass('btn-lg').removeClass('btn-xs').wrap('<span class="ltx-btn-wrap"></span');

	jQuery('.woocommerce-result-count, .woocommerce-ordering').wrapAll('<div class="ltx-wc-order"></div>');

	jQuery('.blog-post .nav-links > a').wrapInner('<span></span>');
	jQuery('.blog-post .nav-links > a[rel="next"]').wrap('<span class="next"></span>');
	jQuery('.blog-post .nav-links > a[rel="prev"]').wrap('<span class="prev"></span>');

	jQuery('section.bg-overlay-true-black, .wpb_row.bg-overlay-true-black').prepend('<div class="ltx-overlay-true-black"></div>');
	jQuery('section.bg-overlay-white, .wpb_row.bg-overlay-white').prepend('<div class="ltx-overlay-white"></div>');
	jQuery('section.bg-overlay-black, .wpb_row.bg-overlay-black').prepend('<div class="ltx-overlay-black"></div>');
	jQuery('section.bg-overlay-dark, .wpb_row.bg-overlay-dark').prepend('<div class="ltx-overlay-dark"></div>');
	jQuery('section.bg-overlay-xblack, .wpb_row.bg-overlay-xblack').prepend('<div class="ltx-overlay-xblack"></div>');
	jQuery('section.bg-overlay-gradient, .wpb_row.bg-overlay-gradient').prepend('<div class="ltx-overlay-gradient"></div>');
	jQuery('section.bg-overlay-waves, .wpb_row.bg-overlay-waves').prepend('<div class="ltx-overlay-waves"></div>');
	jQuery('section.bg-overlay-half, .wpb_row.bg-overlay-half').prepend('<div class="ltx-overlay-half"></div>');
	jQuery('section.bg-overlay-divider, .wpb_row.bg-overlay-divider').prepend('<div class="ltx-overlay-divider"></div>');
	jQuery('section.white-space-top, .wpb_row.white-space-top').prepend('<div class="ltx-white-space-top"></div>');

	var update_width = jQuery('.woocommerce-cart-form__contents .product-subtotal').outerWidth();

	jQuery('button[name="update_cart"]').css('width', update_width);

	jQuery('.wp-searchform .btn').removeClass('btn');

	if ( jQuery('.woocommerce .products').length ) {

		jQuery('.woocommerce .products .product').each(function(i, el) {

			var href = jQuery(el).find('a').attr('href'),
				img = jQuery(el).find('.image img');

			jQuery(img).wrap('<a href="'+ href +'">');
		});
	}

	// Settings copyrights overlay for non-default heights
	var copyrights = jQuery('.copyright-block.copyright-layout-copyright-transparent'),
		footer = jQuery('#ltx-widgets-footer + .copyright-block'),
		widgets_footer = jQuery('#ltx-widgets-footer'),
		footerHeight = footer.outerHeight() + 1;

	// Cart quanity change
	jQuery('.woocommerce div.quantity,.woocommerce-page div.quantity').append('<span class="more"></span><span class="less"></span>');
	jQuery(document).off('updated_wc_div').on('updated_wc_div', function () {

		jQuery('.woocommerce div.quantity,.woocommerce-page div.quantity').append('<span class="more"></span><span class="less"></span>');
		initStyles();
	});
}

/* Styles reloaded then page has been resized */
function setResizeStyles() {

	var videos = jQuery('.blog-post article.format-video iframe'),
		container = jQuery('.blog-post'),
		bodyWidth = jQuery(window).outerWidth(),
		contentWrapper = jQuery('.ltx-content-wrapper.ltx-footer-parallax'),
		footerWrapper = jQuery('.ltx-content-wrapper.ltx-footer-parallax + .ltx-footer-wrapper');

		contentWrapper.css('margin-bottom', footerWrapper.outerHeight() + 'px');

	jQuery.each(videos, function(i, el) {

		var height = jQuery(el).height(),
			width = jQuery(el).width(),
			containerW = jQuery(container).width(),
			ratio = containerW / width;

		jQuery(el).css('width', width * ratio);
		jQuery(el).css('height', height * ratio);
	});

	if ( jQuery('.services-sc.layout-list').length ) {

		var el = jQuery('.services-sc.layout-list');

		if ( !el.hasClass('inited') ) {

			var bodyStyles = window.getComputedStyle(document.body);
			var niceScrollConf = {cursorcolor:bodyStyles.getPropertyValue('--black'),cursorborder:"0px",background:bodyStyles.getPropertyValue('--gray'),cursorwidth: "7px",cursorborderradius: "0px",autohidemode:false};

			el.find('.ltx-list-wrap').niceScroll(niceScrollConf);	

//			el.addClass('inited');
		}
	}

	document.documentElement.style.setProperty( '--fullwidth', bodyWidth + 'px' );
}

/* Starting countUp function */
function checkCountUp() {

	if (jQuery(".countUp").length){

		jQuery('.countUp').counterUp();
	}
}

/* 
	Scroll Reveal Initialization
	Catches the classes: ltx-sr-fade_in ltx-sr-text_el ltx-sr-delay-200 ltx-sr-duration-300 ltx-sr-sequences-100
*/
function initScrollReveal() {

	if (/Mobi/.test(navigator.userAgent) || jQuery(window).width() < 768) return false;

	window.sr = ScrollReveal();

	var srAnimations = {
		zoom_in: {
			
			opacity : 1,
			scale    : 0.01,
		},
		fade_in: {
			distance: 0,
			opacity : 0,
			scale : 1,
		},
		slide_from_left: {
			distance: '200%',
			origin: 'left',			
		},
		slide_from_right: {
			distance: '150%',
			origin: 'right',			
		},
		slide_from_top: {
			distance: '150%',
			origin: 'top',			
		},
		slide_from_bottom: {
			distance: '150%',
			origin: 'bottom',			
		},
		slide_rotate: {
			rotate: { x: 0, y: 0, z: 360 },		
		},		
	};

	var srElCfg = {

		block: [''],
		items: ['article', '.item'],
		text_el: ['.heading', '.header', '.subheader', '.btn', '.btn-wrap', 'p', 'ul'],
		list_el: ['li']
	};


	/*
		Parsing elements class to get variables
	*/
	jQuery('.ltx-sr').each(function() {

		var el = jQuery(this),
			srClass = el.attr('class');

		var srId = srClass.match(/ltx-sr-id-(\S+)/),
			srEffect = srClass.match(/ltx-sr-effect-(\S+)/),
			srEl = srClass.match(/ltx-sr-el-(\S+)/),
			srDelay = srClass.match(/ltx-sr-delay-(\d+)/),
			srDuration = srClass.match(/ltx-sr-duration-(\d+)/),
			srSeq = srClass.match(/ltx-sr-sequences-(\d+)/); 

		var cfg = srAnimations[srEffect[1]];

		var srConfig = {

			delay : parseInt(srDelay[1]),
			duration : parseInt(srDuration[1]),
			easing   : 'ease-in-out',
			afterReveal: function (domEl) { jQuery(domEl).css('transition', 'all .3s ease'); }
		}			

		cfg = jQuery.extend({}, cfg, srConfig);

		var initedEls = [];
		jQuery.each(srElCfg[srEl[1]], function(i, e) {

			initedEls.push('.ltx-sr-id-' + srId[1] + ' ' + e);
		});

		sr.reveal(initedEls.join(','), cfg, parseInt(srSeq[1]));
	});
}

/*
	Slider filter 
	Filters element in slider and reinits swiper slider after
*/
function initSliderFilter(swiper) {

	var btns = jQuery('.slider-filter'),
		container = jQuery('.slider-filter-container');

	var ww = jQuery(window).width(),
		wh = jQuery(window).height();

	if (btns.length) {

		btns.on('click', 'a.cat, span.cat, span.img', function() {

			var el = jQuery(this),
				filter = el.data('filter'),
				limit = el.data('limit');

			container.find('.filter-item').show();
			el.parent().parent().find('.cat-active').removeClass('cat-active')
			el.parent().parent().find('.cat-li-active').removeClass('cat-li-active')
			el.addClass('cat-active');
			el.parent().addClass('cat-li-active');

			if (filter !== '') {

				container.find('.filter-item').hide();
				container.find('.filter-item.filter-type-' + filter + '').fadeIn(900);
			}

			if (swiper !== 0) {

				swiper.slideTo(0, 0);

				swiper.update();
			}

			return false;
		});

		// First Init, Activating first tab
		var firstBtn = btns.find('.cat:first')

		firstBtn.addClass('cat-active');
		firstBtn.parent().addClass('cat-li-active');
		container.find('.filter-item').hide();
		container.find('.filter-item.filter-type-' + firstBtn.data('filter') + '').show();
	}
}


/* Swiper slider initialization */
function initSwiper() {

	var products = jQuery('.products-slider'),
		slidersLtx = jQuery('.slider-sc'),
		servicesEl = jQuery('.services-slider'),
		clientsSwiperEl = jQuery('.testimonials-slider'),
		gallerySwiperEl = jQuery('.swiper-gallery'),
		postGalleryEl = jQuery('.ltx-post-gallery'),
		teamEl = jQuery('.ltx-team-slider'),		
		sliderFc = jQuery('.ltx-slider-fc'),		
		textSwiperEl = jQuery('.swiper-text'),
		schedule = jQuery('.swiper-schedule');


    window.dispatchEvent(new Event('resize'));
	
	setTimeout(function() { window.dispatchEvent(new Event('resize')); }, 10);

	setTimeout(function() { window.dispatchEvent(new Event('resize')); }, 1000);
		

	if (teamEl.length) {

		var autoplay = false;

	    var teamSwiper = new Swiper(teamEl, {

			speed		: 1000,
			//loop: true,
			spaceBetween : 30,
			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},
			pagination : {

				el: '.swiper-pages',
				clickable: true,				
			},			
			slidesPerView : 3,
		
			autoplay: autoplay,			
	    });

	    initSliderFilter(teamSwiper);
	}
		else {

	    initSliderFilter(0);
	}

	if (slidersLtx.length) {

		if ( slidersLtx.data('autoplay') === 0 ) {

			var autoplay = false;
		}
			else {

			var autoplay = {
				delay: slidersLtx.data('autoplay'),
				disableOnInteraction: false,
			}
		}

	    var slidersSwiper = new Swiper(slidersLtx, {

			speed		: 1000,

			effect : 'fade',
			fadeEffect: { crossFade: true },

			autoplay: autoplay,	

			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},			
	
			pagination : {

				el: '.swiper-pages',
				clickable: true,				
			},

	    });

	    slidersSwiper.update();   
	}

	if (sliderFc.length) {

		if ( sliderFc.data('autoplay') === 0 ) {

			var autoplay = false;
		}
			else {

			var autoplay = {
				delay: sliderFc.data('autoplay'),
				disableOnInteraction: false,
			}
		}		

	    var sliderFcSwiper = new Swiper(sliderFc, {

			direction   : 'horizontal',
			
			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},	
			spaceBetween : 2,

			loop		: true,   
			speed		: 1000,   
			slidesPerView : sliderFc.data('cols'),
			mousewheel: {
			    invert: false,
			},
		
			autoplay    : autoplay,
		
	    });

	    sliderFcSwiper.update();
	    
		jQuery(document).on('vc-full-width-row', function() {

			sliderFcSwiper.update();
		});	  	    
	}


	if (postGalleryEl.length) {

	    var postGallerySwiper = new Swiper(postGalleryEl, {

			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},

			speed		: 1000,   
		
			autoplay    : postGalleryEl.data('autoplay'),
			autoplayDisableOnInteraction	: false,
		
	    });

	    postGallerySwiper.update();
	}

	if (clientsSwiperEl.length) {

		if ( clientsSwiperEl.data('autoplay') === 0 ) {

			var autoplay = false;
		}
			else {

			var autoplay = {
				delay: clientsSwiperEl.data('autoplay'),
				disableOnInteraction: false,
			}
		}

	    var clientsSwiper = new Swiper(clientsSwiperEl, {

	    	initialSlide : 1,
			speed		: 1000,
			slidesPerView : clientsSwiperEl.data('cols'),	
			centeredSlides: true,

			spaceBetween: 30,
			loop: true,

			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},
	
			autoplay: autoplay,	

	    });

	    clientsSwiper.update();
	}

	if (products.length) {

	    var productsSwiper = new Swiper(products, {

			speed		: 1000,
			slidesPerView : products.data('cols'),	        
			slidesPerGroup : 1,	        

			autoplay    : products.data('autoplay'),
			autoplayDisableOnInteraction	: false,
	    });

	    initSliderFilter(productsSwiper);
	}

	if (servicesEl.length) {

		if ( servicesEl.data('autoplay') === 0 ) {

			var autoplay = false;
		}
			else {

			var autoplay = {
				delay: servicesEl.data('autoplay'),
				disableOnInteraction: false,
			}
		}

	    var servicesSwiper = new Swiper(servicesEl, {

			speed		: 1000,
			spaceBetween: 30,

			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},
			slidesPerView : servicesEl.data('cols'),
		
			autoplay: autoplay,	
	    });
	}

	if (gallerySwiperEl.length) {	

	    var gallerySwiperEl = new Swiper(gallerySwiperEl, {
			direction   : 'horizontal',
	        pagination: '.swiper-pagination',
	        paginationClickable: true,		
			autoplay    : 4000,
			autoplayDisableOnInteraction	: false,        
	    });
	}

	if (textSwiperEl.length) {	

	    var textSwiperEl = new Swiper(textSwiperEl, {
			direction   : 'horizontal',
			nextButton	: '.arrow-right',
			prevButton	: '.arrow-left',
			loop		: true,
			autoplay    : 4000,
			autoplayDisableOnInteraction	: false,        
	    });
	}	

	jQuery(window).on('resize', function(){

		var ww = jQuery(window).width(),
			wh = jQuery(window).height();


		if (sliderFc.length && sliderFc.data('cols') >= 3) {

			if (ww > 1200) { sliderFcSwiper.params.slidesPerView = 4; }
			if (ww <= 1200) { sliderFcSwiper.params.slidesPerView = 3; }
			if (ww <= 1000) { sliderFcSwiper.params.slidesPerView = 2; }
			if (ww <= 768) { sliderFcSwiper.params.slidesPerView = 1; }		
		
			sliderFcSwiper.update();			
		}

		if (servicesEl.length ) {

			if (ww > 1600) { servicesSwiper.params.slidesPerView = 3; }
			if (ww <= 1599) { servicesSwiper.params.slidesPerView = 3; }
			if (ww <= 1199) { servicesSwiper.params.slidesPerView = 2; }		
			if (ww <= 768) { servicesSwiper.params.slidesPerView = 1; }		
		
			servicesSwiper.update();			
		}

		if (clientsSwiperEl.length) {

			if (ww <= 1000) { clientsSwiper.params.slidesPerView = 1; }	else { clientsSwiper.params.slidesPerView = 1; }
		
			clientsSwiper.update();			
		}
			else
		if (clientsSwiperEl.length && clientsSwiperEl.data('cols') == 2) {

			if (ww > 1600) { clientsSwiper.params.slidesPerView = 2; }
			if (ww <= 1000) { clientsSwiper.params.slidesPerView = 1; }		
			if (ww <= 768) { clientsSwiper.params.slidesPerView = 1; }		
		
			clientsSwiper.update();			
		}					

		if (teamEl.length ) {


			teamSwiper.params.slidesPerView = 3;
			if (ww <= 1199) { teamSwiper.params.slidesPerView = 2; }
			if (ww <= 768) { teamSwiper.params.slidesPerView = 1; }		
		
			teamSwiper.update();			
		}		

		if (products.length && products.data('cols') >= 2) {

			if (ww >= 1600) { productsSwiper.params.slidesPerView = 3; }
			if (ww <= 1599) { productsSwiper.params.slidesPerView = 3; }
			if (ww <= 1199) { productsSwiper.params.slidesPerView = 2; }
			if (ww <= 768) { productsSwiper.params.slidesPerView = 1; }		
		
			productsSwiper.update();			
		}	

	}).resize();

}


/* Masonry initialization */
function initMasonry() {

	jQuery('.masonry').masonry({
	  itemSelector: '.item',
	  columnWidth:  '.item'
	});		

	jQuery('.gallery-inner').masonry({
	  itemSelector: '.mdiv',
	  columnWidth:  '.mdiv'
	});			
}

/* Google maps init */
function initMap() {

	jQuery('.ltx-google-maps').each(function(i, mapEl) {

		mapEl = jQuery(mapEl);
		if (mapEl.length) {

			var uluru = {lat: mapEl.data('lat'), lng: mapEl.data('lng')};
			var map = new google.maps.Map(document.getElementById(mapEl.attr('id')), {
			  zoom: mapEl.data('zoom'),
			  center: uluru,
			  scrollwheel: false,
			  styles: mapStyles
			});

			var marker = new google.maps.Marker({
			  position: uluru,
			  icon: mapEl.data('marker'),
			  map: map
			});
		}
	});
}

function ltxGetCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

function ltxSetCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function initOnScroll() {

	return false;

   var c, currentScrollTop = 0,
       navbar = jQuery('nav.navbar');

   jQuery(window).scroll(function () {
      var a = jQuery(window).scrollTop();
      var b = navbar.height() - 100;
     
      currentScrollTop = a;
     
      if (c < currentScrollTop && a > b + b) {
        navbar.addClass("scrollUp");
      } else if (c > currentScrollTop && !(a <= b)) {
        navbar.removeClass("scrollUp");
      }
      c = currentScrollTop;
  });	
}