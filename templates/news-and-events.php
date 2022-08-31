<?php
/*
	Template Name: News & Events
*/
?>
<?php get_header(); ?>

	<div class="top_spacing"></div>
	
	<?php include get_template_directory() . '/includes/blocks/events_section.php'; ?>
	
	<div class="bottom_spacing"></div>
	
	<?php include get_template_directory() . '/includes/blocks/news_section.php'; ?>

<?php get_footer(); ?>