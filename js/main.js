$(function(){
	
	if ( $('html').hasClass('touch') ) {
		var touch_device = true;
	} else {
		var touch_device = false;
	}
	
	// Styled Dropdown
	$('.styled_dropdown .top').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		if (!$(this).parent().hasClass('disabled')) {
			if ( $(this).siblings('ul').is(':visible') ) {
				$('.styled_dropdown ul').hide();
			} else {
				$('.styled_dropdown ul').hide();
				$(this).parents('.styled_dropdown').find('ul').show();
			}
		}
	});
	var chosenOption = 0;
	$('.styled_dropdown ul li').click(function(e){
		e.stopPropagation();
		var chosenOption = $(this).attr('data-value');
		var chosenOptionText = $(this).text();		
		var updateInput = $(this).parents('.styled_dropdown').attr('data-update-input');
		if ( $(this).find('a').attr('href') == "#" ) {
			e.preventDefault();
		}
		$(this).parents('.styled_dropdown').find('span').text(chosenOptionText);		
		$(this).parents('.styled_dropdown').find('ul').hide();
		$(this).parents('.styled_dropdown').find('span.error').remove();
		$('#'+updateInput).val(chosenOption);
		$(this).siblings().removeClass('selected');
		$(this).addClass('selected');
	});
	$('body').click(function(){
		$('.styled_dropdown ul').hide();
	});
	
	//Fancybox
	$('.fancybox').fancybox();
	
	// Search overlay
	$('.header .primary .bar .search').click(function(e){
		e.preventDefault();
		$('.search_overlay').fadeIn(500);
		$('.search_overlay .inner form .text').attr('name', 's')
		$('.search_overlay .inner form').attr('action', site_url)
		$('.search_overlay .inner h6').text('Search...')
		if ( touch_device == false ) {
			$('.search_overlay .inner form .text').focus();
		}
	});
	
	$('#menu-sidebar-directory-logged-in-admin .search_directory a, #menu-sidebar-directory-logged-in-leader .search_directory a').click(function(e){
		e.preventDefault();
		$('.search_overlay .inner form .text').attr('name', 'query')
		$('.search_overlay .inner form').attr('action', site_url + '/district-directory')
		$('.search_overlay .inner h6').text('Search Directory')
		$('.search_overlay').fadeIn(500)
		if ( touch_device == false ) {
			$('.search_overlay .inner form .text').focus();
		}
	});
	
	$('.search_overlay .close').click(function(e){
		e.preventDefault();
		$('.search_overlay').fadeOut(500);
	});
	
	// Nav overlay
	$('.header .primary .bar .hamburger').click(function(e){
		e.preventDefault();
		$('.nav_overlay').fadeIn(500);
	});
	
	$('.nav_overlay .close').click(function(e){
		e.preventDefault();
		$('.nav_overlay').fadeOut(500);
	});
	
	$(document).one('keyup', function(e) {
	  	if (e.which == 27) {
	  		$('.search_overlay').fadeOut('fast');
	  	}
  	});
  	
  	// Team biographies
    $('.columns .col_2 .team_list .single .view').click(function(e){
	    e.preventDefault();
	    if ( $(this).text() == "Read more" ) { $(this).text("Read less"); } else { $(this).text("Read more"); }
	    $(this).parents('.single').toggleClass('open');
	    $(this).parents('.single').find('.read_more').slideToggle();
    });
	
	// Image resize
    function imageResize() {
		$('.hero img.bg').resizeToParent({parent: '.hero', delay: 1});
		$('.team_list .single .image img').resizeToParent({parent: '.team_list .single .image', delay: 1});
		$('.team_list .single .image img').resizeToParent({parent: '.team_list .single .image', delay: 1});
		$('.news_section .right .row .image img').resizeToParent({parent: '.news_section .right .row .image', delay: 1});
		$('.news_section .left img').resizeToParent({parent: '.left', delay: 1});
		$('.news_list .single .image img').resizeToParent({parent: '.news_list .single .image', delay: 1});
		$('.gallery_list li img').resizeToParent({parent: '.gallery_list li', delay: 1});
		$('.training_section img.bg').resizeToParent({parent: '.training_section', delay: 1});
		$('.columns .col_1 .module.news .bg').resizeToParent({parent: '.columns .col_1 .module.news', delay: 1});
	}
	imageResize();
	
	// Gallery Filters
    var gallery_filter_event = '';
    var gallery_filter_section = '';
    var gallery_filter_order = '';
    var gallery_filter_results_count = '';
    function galleryFilter() {
    	gallery_filter_event = $('.item_filters .filter_event ul li.selected').attr('data-event-slug');
    	gallery_filter_section = $('.item_filters .filter_section ul li.selected').attr('data-section-slug');
    	gallery_filter_order = $('.item_filters .filter_order ul li.selected').attr('data-order-slug');
		$('.gallery_list').addClass('waiting');
		$.ajax({
			type: 'POST',
			url: template_url + '/includes/ajax/gallery.php',
			data: { event: gallery_filter_event, section: gallery_filter_section, order: gallery_filter_order },
			success: function(response) {
				$('.gallery_list').removeClass('waiting');
				$('.gallery_list').html(response);
				gallery_filter_results_count = $('.gallery_list li').length;
				if ( gallery_filter_results_count == 0 ) {
					$('.no_results').fadeIn();
				} else {
					$('.no_results').hide();
				}
				$('img.lazy').lazyload({
					effect : "fadeIn"
				});
				imageResize();
			},
			error: function(response) {
				$('.no_results').hide();
			}
		});
    }
    $('.item_filters.gallery ul li').click(function(e){
	   e.preventDefault();
	   galleryFilter();
    });
    
    // Event Filters
    var events_filter = '';
    $('.item_filters.events ul li').click(function(e){
	   e.preventDefault();
	   events_filter = $(this).attr('data-section');
	   $('.events_list .single').each(function() {
			if ( $(this).attr('data-' + events_filter + '-event') == "true" ) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
		if ( events_filter == "" ) {
			$('.events_list .single').show();
		}
    });
    
    // Scroll to group finder
    $('.group_slide').click(function(e) {
    	e.preventDefault();
    	$('html, body').delay(250).animate({
	        scrollTop: $('.banner_section .find_bar').offset().top-150
	    }, 1000);
    });
    
    // Group Search
    if ( $('body').hasClass('page-template-group-finder') ) {
	    $.ajax({
			type: 'POST',
			url: template_url + '/includes/ajax/group-finder.php',
			data: { location: $('#location').text() },
			success: function(data) {
				$('.loading').fadeOut();
				$('.search_results').html(data);
			}
		});
	}
	
	// Lazy Load
	$('img.lazy').lazyload({
		effect : "fadeIn"
	});
    
    // If website hasn't loaded after 6 seconds...
	window.setTimeout(function(){
		$('body').addClass('load_complete');
	},6000);
	
	// After all assets are loaded...
	$(window).load(function(){
		
		window.setTimeout(function(){
			$('body').addClass('load_complete');
		},500);
		
		imageResize();

	});

});