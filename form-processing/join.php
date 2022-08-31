<?php

	// Start Session
	session_start();

	// Include WordPress
	include_once('../../../../wp-config.php');

	// Get Variables
	$session_id = session_id();
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$lbdOptions = get_option('lbd_settings');

	// Get Posts
	$join_full_name = $_POST['join_full_name'];
	$join_dob = $_POST['join_dob'];
	$join_parent_name = $_POST['join_parent_name'];
	$join_parent_email = $_POST['join_parent_email'];
	$join_parent_telephone = $_POST['join_parent_telephone'];
	$join_group = $_POST['join_group'];

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$options = [
		'body' => [
			'secret' => $lbdOptions['recap_secret'],
			'response' => $_POST['g-recaptcha-response'],
			'remoteip' => $ip_address,
		],
	];

	$response = wp_remote_post($url, $options);
	$json_body = wp_remote_retrieve_body($response);
	$body = json_decode($json_body, true);

	if (isset($body) && $body['success'] && !empty($join_parent_email)) {

		// // Insert Into Database
		global $wpdb;
		$wpdb->insert(
			'kolodo_joining_enquiries'
			, [
				'session_id' => $session_id
				, 'ip_address' => $ip_address
				, 'join_full_name' => $join_full_name
				, 'join_dob' => $join_dob
				, 'join_parent_name' => $join_parent_name
				, 'join_parent_email' => $join_parent_email
				, 'join_parent_telephone' => $join_parent_telephone
				, 'join_group' => $join_group_name
			]
			, [
				'%s'
				, '%s'
				, '%s'
				, '%s'
				, '%s'
				, '%s'
				, '%s'
				, '%s'
			]
		);
		
		// Build Email Template		
		$email_template = file_get_contents('email-templates/join.html');
		$find_values = [
			"{SITE_URL}"
			,"{THEME_URL}"
			,"{SITE_NAME}"
			,"{JOIN_FULL_NAME}"
			,"{JOIN_DOB}"
			,"{JOIN_PARENT_NAME}"
			,"{JOIN_PARENT_EMAIL}"
			,"{JOIN_PARENT_TELEPHONE}"
			,"{JOIN_GROUP}"
			,"{DATE_YEAR}"
		];
		$replace_values = [
			get_bloginfo('url')
			,get_bloginfo('template_url')
			,get_bloginfo('name')
			,$join_full_name
			,$join_dob
			,$join_parent_name
			,$join_parent_email
			,$join_parent_telephone
			,$join_group_name
			,date("Y")
		];
		$email_template = str_replace($find_values,$replace_values,$email_template);
		
		// Email User
		$to = $lbdOptions['form_email'];
		$subject = 'Joining Enquiry #' . $wpdb->insert_id . ' | ' . get_bloginfo('name');
		$headers = [
			'Content-Type: text/html; charset=UTF-8'
		];
		 
		$sendMail = wp_mail( $to, $subject, $email_template, $headers );

		if($sendMail):
			header('Location:'.get_bloginfo('url').'/thank-you/?form=join');
		else:
			echo '<h1>Oops. Something went wrong. Please try again.</h1>';
		endif;
		
	} else {
		
		echo '<h1>Oops. Something went wrong. Please try again.</h1>';
		
	}
	
?>