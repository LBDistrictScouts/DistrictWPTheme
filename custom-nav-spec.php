<?php

	// Register Menu Support //
	register_nav_menus([
		'primary_logged_in' => 'Primary - Logged In',
		'primary_logged_out' => 'Primary - Logged Out',
		'primary_sidebar' => 'Primary - Sidebar',
		'secondary_nav' => 'Secondary - Nav',
		'footer_left_in' => 'Footer - Left - Logged In',
		'footer_left_out' => 'Footer - Left - Logged Out',
		'footer_right' => 'Footer - Right'
	]);

	// add_action('after_setup_theme', 'remove_admin_bar');
 
	// function remove_admin_bar() {
	// 	if (!current_user_can('administrator') && !current_user_can('directory_administrator') && !is_admin()) {
	// 	  show_admin_bar(false);
	// 	}
	// }