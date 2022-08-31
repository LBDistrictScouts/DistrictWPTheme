<?php

// Include WordPress
include_once(__DIR__.'/../../../../wp-load.php');

global $wpdb;
global $wp_version;

function getHubOptions ($data = null)
{
	$headers = [
    	'Accept' => 'application/json',
    	'Content-Type' => 'application/json',
    	'Authorization' => 'Basic V29yZFByZXNzOjY5ODM5YjA1N2FjZDg5ZDhmZWUzNDJlOTljNmNiNjA3YWVjZmZlZmE='
    ];

	$options = [
	    'headers' => $headers
	];

	if (!is_null($data) && isset($data)) {
		$options = [
		    'headers' => $headers,
		    'body' => json_encode($data)
		];
	}
	return $options;
}

function getHubRoot ()
{
	return $rootUrl = 'https://user-admin.lbdscouts.org.uk';
	// return $rootUrl = 'https://request-lbd-bin.herokuapp.com/10n4epy1';
}

function sendHubPost($action, $data)
{
	$rootUrl = getHubRoot();
	$options = getHubOptions($data);

	$url = $rootUrl . $action;

	$response = wp_remote_post($url, $options);

	$code = wp_remote_retrieve_response_code($response);

	if ($code == 201 && isset($code)) {
		return true;
	} 
	return false;
}

function sendHubGet($action)
{
	$rootUrl = getHubRoot();
	$options = getHubOptions();

	$url = $rootUrl . $action;

	$response = wp_remote_get( $url, $options);

	$code = wp_remote_retrieve_response_code($response);

	if ($code <> 200 && $code <> 0 && isset($code)) {
		return $code . ' HTTP ERROR';
	} elseif ($code == 0) {
		return 'NO RESPONSE ERROR';
	}

	$body = json_decode(wp_remote_retrieve_body($response), true);
	return $body;
}

function syncUsers ()
{
	syncHubUsers();

	syncRoles();

	syncGroups();

	syncSections();

	syncPlacements();

	// return $pass;

	// if (!$pass) {
	// 	return 'SEND ERROR';
	// }

	return 'Users Synced';
}

function syncGroups()
{
	sendGroups();
	addGroups();
	sendGroups();
}

function syncHubUsers()
{
	sendHubUsers();
	parseNewUsers();
}

function syncRoles()
{
	sendRoles();
	addRoles();
	sendRoles();
}

function syncSections()
{
	sendSections();
	addSections();
	sendSections();
}

function syncPlacements()
{
	sendPlacements();
	addPlacements();
	sendPlacements();
}

function parseNewUsers()
{
	$action = '/api/contacts/new-contact';

	$body = sendHubGet($action);

	if (key_exists('contacts', $body)) {
		$contacts = $body['contacts'];
		$contactCount = array_count_values($contacts);
	}

	if ($contactCount == 0 || !isset($contactCount)) {
		return 'ARRAY ERROR';
	}

	$total = 0;
	$fail = 0;

	foreach ($contacts as $subArray) {
		$rval = addNewUser($subArray);
		$total += 1;

		if ($rval == false) {
			$fail += 1;
		}
	}

	if ($fail > 0) {
		return 'FAIL COUNT ERROR';
	}

	return $total . ' CONTACTS SYNCED';
}
function updateUserId($userId) 
{
	$user = new WP_User($userId);

	$action = '/api/contacts/assign';
	$data = [
		'email' => $user->get('email'),
		'wp_id' => $user->get('id')
	];

	return sendHubPost($action, $data);
}

function addNewUser ($userArray)
{
	$accepted = array('first_name', 'last_name', 'email', 'address_1', 'address_2', 'city', 'county', 'postcode', 'membership_number','show_in_dd', 'admin_group');
	
	if (array_key_exists('full_name', $userArray)) {
		$userArray['username'] = $userArray['full_name'];
	} else {
		$userArray['username'] = $userArray['first_name'] . ' ' . $userArray['last_name'];
	}

	$userArray['address_1'] = $userArray['address_line_1'];
	$userArray['address_2'] = $userArray['address_line_2'];

	$userArray['show_in_dd'] = 1;

	$user_id = register_new_user($userArray['username'], $userArray['email']);
	
	if(is_wp_error($user_id)) {
		return false;
	}
	
	$user = new WP_User($user_id);

	if($userArray['admin_group']){
		$user->set_role('group_administrator');
		update_field( 'group_id', $userArray['admin_group'], 'user_'.$user_id );
	} else {
		$user->set_role('leader');
	}
	
	foreach($userArray as $key => $value) {
		if(in_array($key, $accepted)){
			update_field( $key, $value, 'user_'.$user_id );
		}
	}

	$pass = updateUserId($user_id);

	if (!$pass) {
		return false;
	}
	
	return true;
}

function sendRoles()
{
	$roles = new WP_Query([
	    'post_type' => 'dd_roles',
	    'post_count' => -1,
	    'nopaging' => true
	]);

	$sendRoles = [];

	if ( $roles->have_posts() ) {
		while ( $roles->have_posts() ) {
			$roles->the_post(); 

			$thispost = get_post(get_the_id());

			$role = [
				'uah_id' => $thispost->menu_order,
				'wp_role_id' => get_the_id()
			];

			array_push($sendRoles, $role);
		}
	}

	$action = '/api/role-types/send';
	$data = ['roles' => $sendRoles];

	return sendHubPost($action, $data);
}

function sendHubUsers()
{
	$systemUsers = get_users([
		'nopaging' => true
	]);

	$sendArray = [];

	foreach ($systemUsers as $user) {
		$user_data = [
			'email' => $user->get('email'),
			'wp_id' => $user->get('id')
		];

		if (!empty($user_data['email'])) {
			array_push($sendArray, $user_data);
		}
	}

	$action = '/api/contacts/assign';

	$data = ['data' => $sendArray];

	$response = sendHubPost($action, $data);

	return $response;
}

function sendGroups()
{
	$groups = new WP_Query([
	    'post_type' => 'groups',
	    'post_count' => -1,
	    'nopaging' => true
	]);

	$sendGroups = [];

	if ( $groups->have_posts() ) {
		while ( $groups->have_posts() ) {
			$groups->the_post(); 

			$thispost = get_post(get_the_id());

			$role = [
				'uah_name' => get_the_title(),
				'wp_group_id' => get_the_id()
			];

			array_push($sendGroups, $role);
		}
	}

	$action = '/api/scout-groups/send';
	$data = ['groups' => $sendGroups];

	return sendHubPost($action, $data);
}

function sendSections()
{
	$sections = new WP_Query([
	    'post_type' => 'dd_sections',
	    'post_count' => -1,
	    'nopaging' => true
	]);

	$sendSections = [];

	if ( $sections->have_posts() ) {
		while ( $sections->have_posts() ) {
			$sections->the_post(); 

			$thispost = get_post(get_the_id());

			$section = [
				'uah_id' => $thispost->menu_order,
				'wp_section_id' => get_the_id()
			];

			array_push($sendSections, $section);
		}
	}

	$action = '/api/sections/send';
	$data = ['sections' => $sendSections];

	return sendHubPost($action, $data);
}

function sendPlacements()
{
	global $wpdb;
	$placements = $wpdb->get_results('SELECT * FROM kolodo_dd_placements', OBJECT);

	$sendRoles = [];

	foreach ($placements as $placement) {
		$role = [
			'wp_placement_id' => $placement->id,
			'user_id' => $placement->user_id,
			'role_id' => $placement->role,
			'section_id' => $placement->section
		];

		array_push($sendRoles, $role);
	}

	$action = '/api/roles/send';
	$data = ['placements' => $sendRoles];

	return sendHubPost($action, $data);
}

function addRoles ()
{
	$action = '/api/role-types';

	$body = sendHubGet($action);

	if (!is_array($body)) {
		return $body;
	}

	if (array_key_exists('roles', $body)) {
		$roles = $body['roles'];
		$roleCount = count($roles);
	}

	if ($roleCount == 0 || !isset($roleCount) || empty($roleCount)) {
		return 'ARRAY ERROR';
	}

	$total = 0;

	foreach ($roles as $role) {
		if(array_key_exists('role_type', $role)) {
			$id = 0;
			if (array_key_exists('wp_role_id', $role) && !is_null($role['wp_role_id'])) {
				$id = $role['wp_role_id'];
			}
			$rolePost = [
				'ID' => $id,
				'post_type' => 'dd_roles',
				'post_title' => $role['role_type'],
				'post_status' => 'publish',
				'post_author' => 5,
				'menu_order' => $role['id']
			];
			wp_insert_post($rolePost);
			$total += 1;
		}
	}
	return $total . ' Roles Synced.';
}

function addGroups()
{
	$action = '/api/scout-groups';

	$body = sendHubGet($action);

	if (!is_array($body)) {
		return $body;
	}

	if (array_key_exists('groups', $body)) {
		$groups = $body['groups'];
		$groupCount = count($groups);
	}

	if ($groupCount == 0 || !isset($groupCount) || empty($groupCount)) {
		return 'ARRAY ERROR';
	}

	$total = 0;

	foreach ($groups as $group) {
		if(array_key_exists('scout_group', $group)) {
			$id = 0;
			if (array_key_exists('wp_group_id', $group) && !is_null($group['wp_group_id'])) {
				$id = $group['wp_group_id'];
			}
			$groupPost = [
				'ID' => $id,
				'post_type' => 'groups',
				'post_title' => $group['group_alias'],
				'post_status' => 'publish',
				'post_author' => 5,
				'menu_order' => $group['id']
			];
			wp_insert_post($groupPost);
			$total += 1;
		}
	}
	return $total . ' Groups Synced.';
}

function addSections()
{
	$action = '/api/sections';

	$body = sendHubGet($action);

	if (!is_array($body)) {
		return $body;
	}

	if (array_key_exists('sections', $body)) {
		$sections = $body['sections'];
		$sectionCount = count($sections);
	}

	if ($sectionCount == 0 || !isset($sectionCount) || empty($sectionCount)) {
		return 'ARRAY ERROR';
	}

	$total = 0;

	foreach ($sections as $section) {
		if(array_key_exists('section', $section)) {
			$id = 0;
			if (array_key_exists('wp_section_id', $section) && !is_null($section['wp_section_id'])) {
				$id = $section['wp_section_id'];
			}
			$group = $section['scout_group'];
			$sectionPost = [
				'ID' => $id,
				'post_type' => 'dd_sections',
				'post_title' => $section['section'],
				'post_status' => 'publish',
				'post_author' => 5,
				'post_parent' => $group['wp_group_id'],
				'menu_order' => $section['id']
			];
			wp_insert_post($sectionPost);
			$total += 1;
		}
	}
	return $total . ' Sections Synced.';
}

function addPlacements()
{
	$action = '/api/roles';

	$body = sendHubGet($action);

	if (!is_array($body)) {
		return $body;
	}

	if (key_exists('placements', $body)) {
		$placements = $body['placements'];
		$placementCount = count($placements);
	}

	if ( $placementCount == 0 || !isset($placementCount) || empty($placementCount) ) {
		return 'ARRAY ERROR';
	}

	$total = 0;

	foreach ($placements as $placement) {
		if(array_key_exists('placement_id', $placement)) {

			if (is_null($placement['placement_id']) || empty($placement['placement_id'])) {
				global $wpdb;
				$wpdb->insert('kolodo_dd_placements', [
					'user_id' => $placement['user_id'], 
					'role' => $placement['role_id'], 
					'section' => $placement['section_id'], 
					'group' => $placement['group_id']
				],
				[ '%d', '%d', '%d', '%d' ]);
			} else {
				global $wpdb;
				$wpdb->update('kolodo_dd_placements', [
					'user_id' => $placement['user_id'], 
					'role' => $placement['role_id'], 
					'section' => $placement['section_id'], 
					'group' => $placement['group_id']
				], [
					'id' => $placement['placement_id']
				]);
			}
			$total += 1;
		}
	}
	return $total . ' Placements Synced.';
}