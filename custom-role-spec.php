<?php

	// Add Permissions for Admin
	$role = get_role( 'administrator' );

	// On District Directory
	$role->add_cap( 'create_district_team');
	$role->add_cap( 'edit_district_team' );
	$role->add_cap( 'read_district_team' );
	$role->add_cap( 'delete_district_team' );
	$role->add_cap( 'edit_others_district_team' );
	$role->add_cap( 'publish_district_team' );
	$role->add_cap( 'read_private_district_team' );
	
	// On Group
	$role->add_cap( 'create_dd_groups');
	$role->add_cap( 'edit_dd_groups' );
	$role->add_cap( 'read_dd_groups' );
	$role->add_cap( 'delete_dd_groups' );
	$role->add_cap( 'edit_others_dd_groups' );
	$role->add_cap( 'publish_groups' );
	$role->add_cap( 'read_private_dd_groups' );

	// On DD Role
	$role->add_cap( 'create_dd_roles');
	$role->add_cap( 'edit_dd_roles' );
	$role->add_cap( 'read_dd_roles' );
	$role->add_cap( 'delete_dd_roles' );
	$role->add_cap( 'edit_others_dd_roles' );
	$role->add_cap( 'publish_dd_roles' );
	$role->add_cap( 'read_private_dd_roles' );

	// On News
	$role->add_cap( 'create_news');
	$role->add_cap( 'edit_news' );
	$role->add_cap( 'read_news' );
	$role->add_cap( 'delete_news' );
	$role->add_cap( 'edit_news' );
	$role->add_cap( 'publish_news' );
	$role->add_cap( 'read_private_news' );
	$role->add_cap( 'edit_others_news' );

	// On Events
	$role->add_cap( 'create_events' );
	$role->add_cap( 'edit_events' );
	$role->add_cap( 'read_events' );
	$role->add_cap( 'delete_events' );
	$role->add_cap( 'edit_others_events' );
	$role->add_cap( 'publish_events' );
	$role->add_cap( 'read_private_events' );

	remove_role('leader');
	add_role( 'leader', __('Leader' ),
		[
			'read' => true,
			'edit_news' => true,
			'create_news' => true,
			'edit_events' => true,
			'create_events' => true,
			'upload_files' => true,
		]
	);
	
	remove_role('publisher');
	add_role( 'publisher', __('Publisher' ),
		[
			'read' => true,
			'upload_files' => true,

			// On News
			'edit_news' => true,
			'read_news' => true,
			'delete_news' => true,
			'edit_news' => true,
			'publish_news' => true,
			'read_private_news' => true,
			'create_news' => true,
			'edit_others_news' => true,

			// On Events
			'edit_events' => true,
			'read_events' => true,
			'delete_events' => true,
			'edit_others_events' => true,
			'publish_events' => true,
			'read_private_events' => true,
			'create_events' => true,
			'edit_others_events' => true,

			// On Pages
			'edit_pages' => true,
			'edit_published_pages' => true,
			'publish_news' => true,
			'publish_events' => true,
			'publish_pages' => true,
			'edit_others_pages' => true,
		]
	);
	
	remove_role('group_administrator');
	add_role( 'group_administrator', __('Group Administrator' ),
		[
			'read' => true,
			'edit_news' => true,
			'edit_events' => true,
			'upload_files' => true,
		]
	);

	remove_role('wpseo_editor');
	remove_role('wpseo_manager');
	remove_role('author');
	remove_role('editor');
	remove_role('contributor');
	remove_role('subscriber');
