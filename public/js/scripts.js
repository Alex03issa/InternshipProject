/* Template: Pavo Mobile App Website Tailwind CSS HTML Template
   Description: Custom JS file
*/

(function($) {
    "use strict"; 
	
    /* Navbar Scripts */
    // jQuery to collapse the navbar on scroll
    $(window).on('scroll load', function() {
		if ($(".navbar").offset().top > 60) {
			$(".fixed-top").addClass("top-nav-collapse");
		} else {
			$(".fixed-top").removeClass("top-nav-collapse");
		}
    });
    
	// jQuery for page scrolling feature - requires jQuery Easing plugin
	$(function() {
		$(document).on('click', 'a.page-scroll', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 600, 'easeInOutExpo');
			event.preventDefault();
		});
    });

    // close menu on click in small viewport
    $('[data-toggle="offcanvas"], .nav-link:not(.dropdown-toggle').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    })

    // hover in desktop mode
    function toggleDropdown (e) {
        const _d = $(e.target).closest('.dropdown'),
            _m = $('.dropdown-menu', _d);
        setTimeout(function(){
            const shouldOpen = e.type !== 'click' && _d.is(':hover');
            _m.toggleClass('show', shouldOpen);
            _d.toggleClass('show', shouldOpen);
            $('[data-toggle="dropdown"]', _d).attr('aria-expanded', shouldOpen);
        }, e.type === 'mouseleave' ? 300 : 0);
    }
    $('body')
    .on('mouseenter mouseleave','.dropdown',toggleDropdown)
    .on('click', '.dropdown-menu a', toggleDropdown);


    /* Details Lightbox - Magnific Popup */
    $('.popup-with-move-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: true,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-slide-bottom'
    });
    

	/* Card Slider - Swiper */
	var cardSlider = new Swiper('.card-slider', {
		autoplay: {
			delay: 4000,
			disableOnInteraction: false
		},
		loop: totalMembers > 1, // Enable loop only if there are multiple members
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev'
		},
		slidesPerView: totalMembers < 3 ? totalMembers : 3, // Show 1, 2, or 3 slides depending on totalMembers
		spaceBetween: totalMembers === 1 ? 0 : (totalMembers === 2 ? 40 : 70), // Adjust spacing based on totalMembers
		breakpoints: {
			// when window is <= 767px
			767: {
				slidesPerView: 1
			},
			// when window is <= 1023px
			1023: {
				slidesPerView: totalMembers < 2 ? totalMembers : 2, // Show 1 or 2 slides on smaller screens
				spaceBetween: totalMembers === 1 ? 0 : 40
			}
		}
	});




    /* Counter - CountTo */
	var a = 0;
	$(window).scroll(function() {
		if ($('#counter').length) { // checking if CountTo section exists in the page, if not it will not run the script and avoid errors	
			var oTop = $('#counter').offset().top - window.innerHeight;
			if (a == 0 && $(window).scrollTop() > oTop) {
			$('.counter-value').each(function() {
				var $this = $(this),
				countTo = $this.attr('data-count');
				$({
				countNum: $this.text()
				}).animate({
					countNum: countTo
				},
				{
					duration: 2000,
					easing: 'swing',
					step: function() {
					$this.text(Math.floor(this.countNum));
					},
					complete: function() {
					$this.text(this.countNum);
					//alert('finished');
					}
				});
			});
			a = 1;
			}
		}
    });


    /* Move Form Fields Label When User Types */
    // for input and textarea fields
    $("input, textarea").keyup(function(){
		if ($(this).val() != '') {
			$(this).addClass('notEmpty');
		} else {
			$(this).removeClass('notEmpty');
		}
	});
	

    /* Back To Top Button */
    // create the back to top button
    $('body').prepend('<a href="body" class="back-to-top page-scroll">Back to Top</a>');
    var amountScrolled = 700;
    $(window).scroll(function() {
        if ($(window).scrollTop() > amountScrolled) {
            $('a.back-to-top').fadeIn('500');
        } else {
            $('a.back-to-top').fadeOut('500');
        }
    });


	/* Removes Long Focus On Buttons */
	$(".button, a, button").mouseup(function() {
		$(this).blur();
	});

	/* Function to get the navigation links for smooth page scroll */
	function getMenuItems() {
		var menuItems = [];
		
		$('.nav-link').each(function() {
			var href = $(this).attr('href');
			
			if (href && typeof href === 'string') {
				// If it's a full URL (starts with http), ignore the # character check
				if (href.startsWith('http')) {
					console.log('Full URL:', href); // Handle full URLs differently if needed
				} else if (href.startsWith('#')) {
					// If it's a hash link (starts with #), process it
					var hash = href.substr(1); // Remove the leading #
					if (hash !== "") {
						menuItems.push(hash);
					}
				}
			} else {
				console.log("Element without valid href:", $(this));
			}
		});
	
		return menuItems;
	}
	

	/* Prevents adding of # at the end of URL on click of non-pagescroll links */
	$('.nav-link').each(function() {
		var href = $(this).attr('href');
		
		// Check if href exists and is a valid string
		if (href && typeof href === 'string') {
			// Check if it's a hash link (starts with #)
			if (href.startsWith('#')) {
				var hash = href.substr(1); // Remove the leading '#' from the hash link
				if (hash !== "") {
					console.log("Valid hash:", hash);
					// Your logic for handling hash links
				}
			} else {
				// This is not a hash link, handle full URLs or other types of links
				console.log("Full URL or other link:", href);
			}
		} else {
			// Log when href is undefined or invalid
			console.log("Invalid or undefined href:", $(this));
		}
	});
	
	/* Checks page scroll offset and changes active link on page load */
	changeActive();

	/* Change active link on scroll */
	$(document).scroll(function(){
		changeActive();
	});
	
	function changeActive() {
		// Select all menu items
		$('.nav-link').each(function() {
			var href = $(this).attr('href');
			
			// Ignore full URLs, handle only hash links
			if (href && href.startsWith('#')) {
				var sectionId = href.substr(1); // Get the section ID from the href (after #)
				
				if (sectionId) {
					var section = $('#' + sectionId); // Select the section using the ID
					if (section.length) {
						// Your logic to change active state
					}
				}
			}
		});
	}
	

})(jQuery);

