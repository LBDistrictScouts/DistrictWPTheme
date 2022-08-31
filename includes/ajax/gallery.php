<?php
	include('../../../../../wp-config.php');
	$arguments = array( 'post_type' => 'gallery', 'posts_per_page' => -1, 'gallery_events' => $_POST['event'], 'gallery_sections' => $_POST['section'], 'orderby' => 'date', 'order' => $_POST['order'] );
	$loop = new WP_Query( $arguments );
	if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
		if ( has_post_thumbnail() ) {
			include(TEMPLATEPATH.'/includes/loops/gallery_image.php');
		}
	endwhile; endif; wp_reset_query();
?>