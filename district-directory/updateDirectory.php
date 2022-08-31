<?php
	// Include WordPress
	include_once('../../../../wp-load.php');
	
	global $wpdb;
	
	$accepted = array('first_name', 'last_name', 'email', 'address_1', 'address_2', 'city', 'county', 'postcode', 'contact_1', 'contact_2', 'contact_3', 'membership_number');
	
	$user_id = $_POST['sid'];
	
	foreach($_POST as $key => $value) {
		if(in_array($key, $accepted)){
			update_field( $key, $value, 'user_'.$user_id );
		} else if($key == 'placements') {
			$placements = json_decode(stripslashes($value), true);
			foreach($placements as $p) {
				if($p['placement_id'] == -1){
					$wpdb->insert('kolodo_dd_placements', array('user_id' => $user_id, 'role' => $p['role'], 'section' => $p['section'], 'group' => $p['group']));
				} else {
					$wpdb->update('kolodo_dd_placements', array('role' => $p['role'], 'section' => $p['section'], 'group' => $p['group']), array('id' => $p['placement_id']));
				}
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
?>