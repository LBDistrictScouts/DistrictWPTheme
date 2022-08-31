<?php wp_reset_query(); ?>

<?php if ( is_page_template('templates/contact.php') ) { ?>

	<?php include get_template_directory() . '/includes/modules/contact_details.php'; ?>
	<?php include get_template_directory() . '/includes/modules/map.php'; ?>
	<?php include get_template_directory() . '/includes/modules/join_today.php'; ?>
	<?php include get_template_directory() . '/includes/modules/events.php'; ?>
	
<?php } else { ?>

	<?php include get_template_directory() . '/includes/modules/links.php'; ?>
	<?php include get_template_directory() . '/includes/modules/join_today.php'; ?>
	<?php if ( !is_singular('events') ) { ?>
		<?php include get_template_directory() . '/includes/modules/events.php'; ?>
	<?php } ?>
	<?php if ( !is_singular('news') ) { ?>
		<?php include get_template_directory() . '/includes/modules/news.php'; ?>
	<?php } ?>
	
<?php } ?>