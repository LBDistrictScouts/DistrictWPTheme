<?php
	// Include WordPress
	include_once(__DIR__.'/../../../../wp-load.php');
	
	global $wpdb;
	
	$accepted = array('first_name', 'last_name', 'email', 'address_1', 'address_2', 'city', 'county', 'postcode', 'membership_number','show_in_dd', 'admin_group');
	
	$dd_username = $_POST['first_name'] . ' ' . $_POST['last_name'];
	$user_id = register_new_user($dd_username, $_POST['email']);
	
	if(is_wp_error($user_id)){
		header("HTTP/1.1 500 Internal Server Error");
		echo 'User with that email already exists';
		return;
	}
	
	$user = new WP_User($user_id);
	
	if($_POST['admin_group']){
		$user->set_role('group_administrator');
		update_field( 'group_id', $_POST['admin_group'], 'user_'.$user_id );
	} else {
		$user->set_role('leader');
	}

	
	foreach($_POST as $key => $value) {
		if(in_array($key, $accepted)){
			update_field( $key, $value, 'user_'.$user_id );
		} else if($key == 'placements') {
			$roles = json_decode(stripslashes($value), true);
			foreach($roles as $r) {
				$wpdb->insert('kolodo_dd_placements', array('user_id' => $user_id, 'role' => $r['role'], 'section' => $r['section'], 'group' => $r['group']));
			}
		} else if($key == 'contact_numbers'){
			$numbers = json_decode(stripslashes($value), true);
			foreach($numbers as $n) {
				if($n['contact_id'] == -1){
					$wpdb->insert('kolodo_dd_contacts', array('user_id' => $user_id, 'phone_number' => $n['phone_number']));
				} else {
					$wpdb->update('kolodo_dd_contacts', array('phone_number' => $n['phone_number']), array('id' => $n['contact_id']));
				}
			}
		}
	}
	
	echo bloginfo('url').'/district-directory/person/?sid='.$user_id;
	return;
	
?>