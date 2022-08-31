<?php
	
	function kolodoGetPeople($roles){
		$query = new WP_User_Query(
			array(
				'role__in' => $roles
				, 'meta_key' => 'show_in_dd'
				, 'meta_value' => '1'
			)
		);
		return $query->get_results();
	}

	function kolodoGetGroupPeople($roles, $groupId){

		$groupUsers = kolodoGetGroupAssociatedUsers($groupId);

		if (empty($groupUsers)) {
			return null;
		}

		$query = new WP_User_Query(
			[
				'include' => $groupUsers
				, 'role__in' => $roles
				, 'meta_key' => 'show_in_dd'
				, 'meta_value' => '1'
			]
		);

		$foundGroupUsers = $query->get_results();

		return $foundGroupUsers;
	}
	
	function kolodoSearchDirectory($roles, $search_term){

		global $wpdb;
		
		$search_term = esc_attr($search_term);
		$searchArray = explode(' ', $search_term, 10);

		$query_ret = [];

		foreach($searchArray as $term) {

			// Nutralise Special Chars
			$term = esc_attr($term);

			// Meta Fields
			$query = new WP_User_Query([
				'meta_query' => [
			        'relation' => 'OR',
			        [
			            'key' => 'first_name',
			            'value' => $term,
			            'compare' => 'LIKE'
			        ],
			        [
			            'key' => 'last_name',
			            'value' => $term,
			            'compare' => 'LIKE'
			        ]
			    ]
				, 'fields' => 'ID'
			]);

			$foundIds = $query->get_results();

			$query_ret = array_merge($query_ret, $foundIds);

			// Standard Search
			$query = new WP_User_Query([
				'search'     => '*' . $term . '*'
				, 'fields' => 'ID'
			]);

			$foundIds = $query->get_results();

			$query_ret = array_merge($query_ret, $foundIds);

			// Groups
			$groups = new WP_Query([
			    'post_type' => 'groups'
			    , 's' => $term
			    , 'nopaging' => true
			]);
			if ( $groups->have_posts() ) {
				while ( $groups->have_posts() ) {
					$groups->the_post(); 
					$users = kolodoGetGroupAssociatedUsers(get_the_ID());
					$query_ret = array_merge($query_ret, $users);
				}
			}

			// 	Roles
			$roles = new WP_Query([
				'post_type' => 'dd_roles'
				, 's' => $term
			]);
			if( $roles->have_posts()) {
				while ( $roles->have_posts()) {
					$roles->the_post();
					$users = kolodoGetRoleAssociatedUsers(get_the_ID());
					$query_ret = array_merge($query_ret, $users);
				}
			}
		}	

		if (empty($query_ret)) {
			return null;
		}

		$query_ret = array_unique($query_ret, 2);

		$query = new WP_User_Query([
				'include' => $query_ret
				, 'meta_key' => 'show_in_dd'
				, 'meta_value' => '1'
			]);

		$foundUsers = $query->get_results();

		return $foundUsers;
	}

	
	function kolodoGetPlacements($userId){
		global $wpdb;
		return $wpdb->get_results('SELECT * FROM kolodo_dd_placements WHERE user_id = ' . $userId, OBJECT);
	}
	
	function kolodoGetNumbers($userId){
		global $wpdb;
		return $wpdb->get_results('SELECT * FROM kolodo_dd_contacts WHERE user_id = ' . $userId, OBJECT);
	}
	
	function kolodoGetRoles(){
		$roles = new WP_Query([
		    'post_type' => 'dd_roles',
		    'post_per_page' => -1,
		    'nopaging' => true
		]);
		
		$ret = [];
		if ( $roles->have_posts() ) {
			while ( $roles->have_posts() ) {
				$roles->the_post(); 
				$ret[] = [
				   'title' => get_the_title(),
				   'id' =>  get_the_ID()
			    ];
			}
		}
		return $ret;
	}

	function kolodoGetRoleAssociatedUsers($roleId){
		global $wpdb;
		$res = $wpdb->get_results('SELECT user_id FROM kolodo_dd_placements WHERE `role` = ' . $roleId . ';', OBJECT);
		$users = [];
		foreach($res as $user) {
			array_push($users, $user->user_id);
		}
		return $users;
	}
	
	function kolodoGetSections() {
		$sections = new WP_Query([
		    'post_type' => 'dd_sections',
		    'post_per_page' => -1,
		    'nopaging' => true,
		    'orderby' => 'menu_order',
		    'order' => 'ASC'
		]);
		$ret = [];
		if ( $sections->have_posts() ) {
			while ( $sections->have_posts() ) {
				$sections->the_post(); 
				$ret[] = [
				   'name' => get_the_title(),
				   'id' =>  get_the_ID()
			    ];
			}
		}
		return $ret;
	}
	
	function kolodoGetGroups() {
		$groups = new WP_Query([
		    'post_type' => 'groups',
		    'post_per_page' => -1,
		    'nopaging' => true,
		    'orderby' => 'menu_order',
		    'order' => 'ASC'
		]);
		$ret = [];
		if ( $groups->have_posts() ) {
			while ( $groups->have_posts() ) {
				$groups->the_post(); 
				$ret[] = [
				   'name' => get_the_title(),
				   'id' =>  get_the_ID()
			    ];
			}
		}
		return $ret;
	}
	
	function kolodoGetAssociatedGroups($userId){
		global $wpdb;
		$res = $wpdb->get_results('SELECT `group` FROM kolodo_dd_placements WHERE user_id = ' . $userId . ';', OBJECT);
		$groups = [];
		foreach($res as $grp) {
			array_push($groups, $grp->group);
		}
		return $groups;
	}

	function kolodoGetGroupAssociatedUsers($groupId){
		global $wpdb;
		$res = $wpdb->get_results('SELECT user_id FROM kolodo_dd_placements WHERE `group` = ' . $groupId . ';', OBJECT);
		$users = [];
		foreach($res as $user) {
			array_push($users, $user->user_id);
		}
		return $users;
	}
	
	function kolodoDeletePlacement($placementId){
		global $wpdb;
		$res = $wpdb->delete('kolodo_dd_placements', ['id' => $placementId]);
		return $res;
	}
	
	function kolodoDeleteContact($phoneId){
		global $wpdb;
		$res = $wpdb->delete('kolodo_dd_contacts', ['id' => $phoneId]);
		return $res;
	}
	

?>