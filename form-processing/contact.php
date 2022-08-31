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
	$contact_full_name = $_POST['contact_full_name'];
	$contact_email_address = $_POST['contact_email_address'];
	$contact_telephone = $_POST['contact_telephone'];
	$contact_enquiry = $_POST['contact_enquiry'];
	$to_contact = $_POST['to_contact'];

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

	if (isset($body) && $body['success'] && !empty($contact_email_address)) {
		
		// // Insert Into Database
		global $wpdb;
		$wpdb->insert( 
			'kolodo_contact_enquiries', 
			[ 
				'session_id' => $session_id,
				'ip_address' => $ip_address,
				'contact_full_name' => $contact_full_name,
				'contact_email_address' => $contact_email_address,
				'contact_telephone' => $contact_telephone,
				'contact_enquiry' => $contact_enquiry,
				'to_contact' => $to_contact,
				'recapture_output' => $json_body
			], 
			[ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ]
		);
		
		// Build Email Template		
		$email_template = file_get_contents('email-templates/contact.html');
		$find_values = [
			"{SITE_URL}",
			"{THEME_URL}",
			"{SITE_NAME}",
			"{CONTACT_FULL_NAME}",
			"{CONTACT_EMAIL_ADDRESS}",
			"{CONTACT_TELEPHONE}",
			"{CONTACT_ENQUIRY}",
			"{DATE_YEAR}"
		];
		$replace_values = [
			get_bloginfo('url'),
			get_bloginfo('template_url'),
			get_bloginfo('name'),
			$contact_full_name,
			$contact_email_address,
			$contact_telephone,
			$contact_enquiry,
			date("Y")
		];
		$email_template = str_replace($find_values,$replace_values,$email_template);
		
		// Email User
		$to = $lbdOptions['form_email'];
		$subject = 'Contact Enquiry #' . $wpdb->insert_id . ' | ' . get_bloginfo('name');
		$headers = [
			'Content-Type: text/html; charset=UTF-8'
		];
		 
		$sendMail = wp_mail( $to, $subject, $email_template, $headers );

		if ( $sendMail ):
			header('Location:' . get_bloginfo('url') . '/thank-you/?form=contact');
		else:
			echo '<h1>Oops. Something went wrong. Please try again.</h1>';
		endif;
		
	} else {
		echo '<h1>Oops. Something went wrong. Please try again.</h1>';
	}
?>