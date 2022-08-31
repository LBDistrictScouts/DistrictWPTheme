<?php
/*
	Template Name: Gallery
*/
?>
<?php get_header(); ?>
	
	<div class="wrapper">
		<div class="item_filters gallery cf">
			<div class="filter filter_event">
				<div class="styled_dropdown">
					<div class="top">
						<span class="text">All events</span>
						<span class="arrow"></span>
					</div><!-- top -->
					<ul>
						<li data-event-slug=""><a href="#">All events</a></li>
						<?php $gallery_events = get_terms( 'gallery_events' ); if ( !empty( $gallery_events ) && ! is_wp_error( $gallery_events ) ) { foreach ( $gallery_events as $gallery_event ) { ?>
							<li data-event-slug="<?php echo $gallery_event->slug; ?>"><a href="#"><?php echo $gallery_event->name; ?></a></li>
						<?php } } ?>
					</ul>
				</div><!-- styled_dropdown -->
			</div><!-- filter -->
			<div class="filter middle filter_section">
				<div class="styled_dropdown">
					<div class="top">
						<span class="text">All sections</span>
						<span class="arrow"></span>
					</div><!-- top -->
					<ul>
						<li data-section-slug=""><a href="#">All sections</a></li>
						<?php $gallery_sections = get_terms( 'gallery_sections' ); if ( !empty( $gallery_sections ) && ! is_wp_error( $gallery_sections ) ) { foreach ( $gallery_sections as $gallery_section ) { ?>
							<li data-section-slug="<?php echo $gallery_section->slug; ?>"><a href="#"><?php echo $gallery_section->name; ?></a></li>
						<?php } } ?>
					</ul>
				</div><!-- styled_dropdown -->
			</div><!-- filter -->
			<div class="filter filter_order">
				<div class="styled_dropdown">
					<div class="top">
						<span class="text">Show latest first</span>
						<span class="arrow"></span>
					</div><!-- top -->
					<ul>
						<li data-order-slug="DESC"><a href="#">Show latest first</a></li>
						<li data-order-slug="ASC"><a href="#">Show oldest first</a></li>
					</ul>
				</div><!-- styled_dropdown -->
			</div><!-- filter -->
		</div><!-- item_filters -->
		<div class="no_results">
			<h3>There were no results found for your search criteria.</h3>
			<p>Please use the filters above to amend your search.</p>
		</div><!-- no_results -->
		<ul class="gallery_list all ease cf">
			<?php
				$arguments = array( 'post_type' => 'gallery', 'posts_per_page' => -1, 'orderby' => 'date' );
				$loop = new WP_Query( $arguments );
				if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
					if ( has_post_thumbnail() ) {
						include(TEMPLATEPATH.'/includes/loops/gallery_image.php');
					}
				endwhile; endif; wp_reset_query();
			?>
		</ul>
	</div><!-- wrapper -->

<?php get_footer(); ?>