jQuery(function() {

	// Tabbed Area //
	jQuery('.tab_content').hide();
	jQuery('.tab_content:first').show();
	jQuery('#admin_options ul#tabs li:first').addClass('active');
	jQuery('#admin_options ul#tabs li a').click(function(e) {
		e.preventDefault();
		jQuery('#admin_options ul#tabs li').removeClass('active');
		jQuery(this).parents('li').addClass('active');
		var chosen_tab = jQuery(this).attr('href');
		jQuery('.tab_content').hide();
		jQuery(chosen_tab).fadeIn();
	});
	
	// Settings Panel //
	jQuery('.tab_content').hide();
	jQuery('.tab_content:first').show();
	jQuery('.admin_sidebar ul li:first').addClass('active');
	jQuery('.admin_sidebar ul li a').click(function(e) {
		e.preventDefault();
		jQuery('.admin_sidebar ul li').removeClass('active');
		jQuery(this).parents('li').addClass('active');
		var chosen_tab = jQuery(this).attr('href');
		jQuery('.tab_content').hide();
		jQuery(chosen_tab).fadeIn();
	});
	setTimeout(function() {
		jQuery('.settings_internal .content h5').slideUp('slow');
	}, 3000);

});