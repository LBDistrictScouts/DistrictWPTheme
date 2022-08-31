<?php

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function add_sync_widget() {

	wp_add_dashboard_widget(
                 'sync_users_with_uploader',         // Widget slug.
                 'Sync Users',         // Title.
                 'uploader_user_sync_function' // Display function.
        );	
}

if ( is_super_admin()) {
	add_action( 'wp_dashboard_setup', 'add_sync_widget' );
	add_action( 'admin_footer', 'trigger_sync_javascript' );
	add_action( 'wp_ajax_trigger_sync', 'trigger_sync' );
}
	
/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function uploader_user_sync_function() {

	// Display whatever it is you want to show.
	echo "<input type='button' class='button button-primary' id='btnSync' value='Sync Users' />";
}

 // Write our JS below here

function trigger_sync_javascript() { ?>
	<script type="text/javascript" >
	
	jQuery(document).ready(function($){

		$("#btnSync").click(function() {

			var data = {
				'action': 'trigger_sync'
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			jQuery.post(ajaxurl, data, function(response) {
				alert('Got this from the server: ' + response);
			});
		});
	});
	</script> <?php
}

function trigger_sync() {

	$response = syncUsers();

    echo $response;

	wp_die(); // this is required to terminate immediately and return a proper response
}