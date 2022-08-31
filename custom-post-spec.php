<?php

	// Remove Comments & Posts from Admin
	function kolodo_remove_wp_menus() {
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'edit.php' );
	}
	add_action( 'admin_menu', 'kolodo_remove_wp_menus' );
	
	// District Team Custom Post Type //
	add_action('init', 'district_team');
	function district_team() {
		$labels = array(
			'name' => __('District Team'),
			'singular_name' => __('District Team'),
			'add_new' => __('Add New Member'),
			'add_new_item' => __('Add New Member'),
			'edit_item' => __('Edit Member'),
			'new_item' => __('New Member'),
			'view_item' => __('View Members'),
			'search_items' => __('Search Members'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => '/about-us/our-team' ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-id-alt',
			'supports' => array('title','editor','thumbnail','page-attributes'),
			'capabilities' => array(
			  'edit_post'          => 'edit_district_team', 
			  'read_post'          => 'read_district_team', 
			  'delete_post'        => 'delete_district_team', 
			  'edit_posts'         => 'edit_district_team', 
			  'edit_others_posts'  => 'edit_others_district_team', 
			  'publish_posts'      => 'publish_district_team',       
			  'read_private_posts' => 'read_private_district_team', 
			  'create_posts'       => 'edit_district_team', 
			)
		); 
		register_post_type( 'district_team' , $args );
		flush_rewrite_rules();
	}
	add_action("manage_posts_custom_column",  "district_team_custom_columns");
	add_filter("manage_edit-district_team_columns", "district_team_edit_columns");
	function district_team_edit_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "District Team",
			"job_title" => "Job Title",
			"date" => "Date",
		);
		return $columns;
	}
	function district_team_custom_columns($column){
		global $post;
		switch ($column) {
			case "job_title":
				echo get_field("job_title",$post->ID);
			break;
		}
	}
	
	// News Custom Post Type //
	add_action('init', 'news');
	function news() {
		$labels = array(
			'name' => __('News'),
			'singular_name' => __('News'),
			'add_new' => __('Add New Article'),
			'add_new_item' => __('Add New Article'),
			'edit_item' => __('Edit Article'),
			'new_item' => __('New Article'),
			'view_item' => __('View Articles'),
			'search_items' => __('Search Articles'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => '/latest-news' ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-format-aside',
			'supports' => array('title','editor','thumbnail'),
			'capabilities' => array(
			  'edit_post'          => 'edit_news', 
			  'read_post'          => 'read_news', 
			  'delete_post'        => 'delete_news', 
			  'edit_posts'         => 'edit_news', 
			  'edit_others_posts'  => 'edit_others_news', 
			  'publish_posts'      => 'publish_news',       
			  'read_private_posts' => 'read_private_news', 
			  'create_posts'       => 'create_news', 
			)
		); 
		register_post_type( 'news' , $args );
		flush_rewrite_rules();
	}
	register_taxonomy("news_category", array("news"), array("hierarchical" => true, "label" => "Categories", "singular_label" => "Categories", "rewrite" => true ));
	
	// Events Custom Post Type //
	add_action('init', 'events');
	function events() {
		$labels = array(
			'name' => __('Events'),
			'singular_name' => __('Events'),
			'add_new' => __('Add New Event'),
			'add_new_item' => __('Add New Event'),
			'edit_item' => __('Edit Event'),
			'new_item' => __('New Event'),
			'view_item' => __('View Events'),
			'search_items' => __('Search Events'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => '/upcoming-events' ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-backup',
			'supports' => array('title','editor','thumbnail'),
			'capabilities' => array(
			  'edit_post'          => 'edit_events', 
			  'read_post'          => 'read_events', 
			  'delete_post'        => 'delete_events', 
			  'edit_posts'         => 'edit_events', 
			  'edit_others_posts'  => 'edit_others_events', 
			  'publish_posts'      => 'publish_events',       
			  'read_private_posts' => 'read_private_events', 
			  'create_posts'       => 'create_events', 
			)
		); 
		register_post_type( 'events' , $args );
		flush_rewrite_rules();
	}
	register_taxonomy("events_sections", array("events"), array("hierarchical" => true, "label" => "Sections", "singular_label" => "Section", "rewrite" => true ));
	add_action("manage_posts_custom_column",  "events_custom_columns");
	add_filter("manage_edit-events_columns", "events_edit_columns");
	function events_edit_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Events",
			"e_date" => "Date",
			"e_sections" => "Sections",
			"date" => "Date",
		);
		return $columns;
	}
	function events_custom_columns($column){
		global $post;
		switch ($column) {
			case "e_date":
				echo date("jS F Y", strtotime(get_field("date")));
			break;
			case "e_sections":
				echo get_the_term_list($post->ID,'events_sections','',', ','');
			break;
		}
	}
	
	// Groups Custom Post Type //
	add_action('init', 'groups');
	function groups() {
		$labels = array(
			'name' => __('Groups'),
			'singular_name' => __('Groups'),
			'add_new' => __('Add New Group'),
			'add_new_item' => __('Add New Group'),
			'edit_item' => __('Edit Group'),
			'new_item' => __('New Group'),
			'view_item' => __('View Groups'),
			'search_items' => __('Search Groups'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => '/find-your-nearest-group' ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-networking',
			'supports' => array('title','editor','thumbnail','page-attributes'),
			'capabilities' => array(
			  'edit_post'          => 'edit_dd_groups', 
			  'read_post'          => 'read_dd_groups', 
			  'delete_post'        => 'delete_dd_groups', 
			  'edit_posts'         => 'edit_dd_groups', 
			  'edit_others_posts'  => 'edit_others_dd_groups', 
			  'publish_posts'      => 'publish_groups',       
			  'read_private_posts' => 'read_private_dd_groups', 
			  'create_posts'       => 'edit_dd_groups', 
			)
		); 
		register_post_type( 'groups' , $args );
		flush_rewrite_rules();
	}
	add_action("manage_posts_custom_column",  "groups_custom_columns");
	add_filter("manage_edit-groups_columns", "groups_edit_columns");
	function groups_edit_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Groups",
			"postcode" => "Postcode",
			"date" => "Date",
		);
		return $columns;
	}
	function groups_custom_columns($column){
		global $post;
		switch ($column) {
			case "postcode":
				echo get_field("postcode",$post->ID);
			break;
		}
	}

	// Custom Meeting Day Spec

	register_taxonomy('meeting_days', ['groups'], [
		"hierarchical" => false
		, "label" => "Meeting Days"
		, "singular_label" => "Meeting Day"
		, "rewrite" => true 
	]);

	// Roles Custom Post Type //
	add_action('init', 'roles');
	function roles() {
		$labels = array(
			'name' => __('Role'),
			'singular_name' => __('Role'),
			'add_new' => __('Add New Role'),
			'add_new_item' => __('Add New Role'),
			'edit_item' => __('Edit Role'),
			'new_item' => __('New Role'),
			'view_item' => __('View Roles'),
			'search_items' => __('Search Roles'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = [
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => '/directory_roles' ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-nametag',
			'supports' => ['title','editor','thumbnail','page-attributes'],
			'capabilities' => [
			  'edit_post'          => 'edit_dd_roles', 
			  'read_post'          => 'read_dd_roles', 
			  'delete_post'        => 'delete_dd_roles', 
			  'edit_posts'         => 'edit_dd_roles', 
			  'edit_others_posts'  => 'edit_others_dd_roles', 
			  'publish_posts'      => 'publish_dd_roles',       
			  'read_private_posts' => 'read_private_dd_roles', 
			  'create_posts'       => 'edit_dd_roles'
			]
		]; 
		register_post_type( 'dd_roles' , $args );
		flush_rewrite_rules();
	}

	// DD Sections Custom Post Type //
	add_action('init', 'dd_sections');
	function dd_sections() {
		$labels = array(
			'name' => __('Sections'),
			'singular_name' => __('Section'),
			'add_new' => __('Add New Section'),
			'add_new_item' => __('Add New Section'),
			'edit_item' => __('Edit Section'),
			'new_item' => __('New Section'),
			'view_item' => __('View Sections'),
			'search_items' => __('Search Sections'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => '>'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => '/sections' ),
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => null,
			'menu_icon' => 'dashicons-universal-access',
			'supports' => array('title','editor','thumbnail','page-attributes'),
			'capabilities' => array(
			  'edit_post'          => 'edit_dd_groups', 
			  'read_post'          => 'read_dd_groups', 
			  'delete_post'        => 'delete_dd_groups', 
			  'edit_posts'         => 'edit_dd_groups', 
			  'edit_others_posts'  => 'edit_others_dd_groups', 
			  'publish_posts'      => 'publish_groups',       
			  'read_private_posts' => 'read_private_dd_groups', 
			  'create_posts'       => 'edit_dd_groups', 
			)
		); 
		register_post_type( 'dd_sections' , $args );
		flush_rewrite_rules();
	}