<?php
/*
	Template Name: Events
*/
?>
<?php get_header(); ?>
	
	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 cf">
			
				<div class="item_filters events cf">
					<p>Choose a section to filter events:</p>
					<div class="filter filter_section">
						<div class="styled_dropdown">
							<div class="top">
								<span class="text">All sections</span>
								<span class="arrow"></span>
							</div><!-- top -->
							<ul>
								<li data-section=""><a href="#">All sections</a></li>
								<?php $sections = get_terms(array('taxonomy' => 'events_sections', 'orderby' => 'ID','order' => 'ASC')); foreach ( $sections as $section ) { ?>
									<li data-section="<?php echo $section->slug; ?>"><a href="#"><?php echo $section->name; ?></a></li>
								<?php } ?>
							</ul>
						</div><!-- styled_dropdown -->
					</div><!-- filter -->
				</div><!-- item_filters -->
	
				<div class="events_list cf">
					
					<?php
						$counter = 1;
						$arguments = array( 'post_type' => 'events', 'posts_per_page' => -1, 'orderby' => 'meta_value', 'meta_key' => 'date', 'order' => 'ASC', 'meta_query' => array( 'key' => 'date', 'value' => date("Ymd"), 'compare' => '>=', 'type' => 'numeric' ) );
						$loop = new WP_Query( $arguments );
						if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
					?>
					
						<?php if ( $counter == 1 ) { ?> 
					
							<a class="single large" href="<?php the_permalink(); ?>"<?php $sections = get_terms(array('taxonomy' => 'events_sections', 'orderby' => 'ID','order' => 'ASC')); foreach ( $sections as $section ) { ?> data-<?php echo $section->slug; ?>-event="<?php echo kolodoEventSection(get_the_ID(),$section->name); ?>"<?php } ?>>
								<p class="next">Next Event</p>
								<h5><?php the_title(); ?></h5>
								<?php if ( kolodoEventSections(get_the_ID()) ) { ?><p><?php echo kolodoEventSections(get_the_ID()); ?></p><?php } ?>
								<span class="time">Read more &raquo;</span>
								<span class="date">
									<span class="inner align_vertical">
										<span class="number"><?php echo date("d", strtotime(get_field("date"))); ?></span>
										<span class="month"><?php echo date("M", strtotime(get_field("date"))); ?></span>
									</span><!-- inner -->
								</span><!-- date -->
							</a><!-- single -->
							
						<?php } else { ?>
						
							<a class="single" href="<?php the_permalink(); ?>"<?php $sections = get_terms(array('taxonomy' => 'events_sections', 'orderby' => 'ID','order' => 'ASC')); foreach ( $sections as $section ) { ?> data-<?php echo $section->slug; ?>-event="<?php echo kolodoEventSection(get_the_ID(),$section->name); ?>"<?php } ?>>
								<h5><?php the_title(); ?></h5>
								<?php if ( kolodoEventSections(get_the_ID()) ) { ?><p><?php echo kolodoEventSections(get_the_ID()); ?></p><?php } ?>
								<span class="time">Read more &raquo;</span>
								<span class="date">
									<span class="inner align_vertical">
										<span class="number"><?php echo date("d", strtotime(get_field("date"))); ?></span>
										<span class="month"><?php echo date("M", strtotime(get_field("date"))); ?></span>
									</span><!-- inner -->
								</span><!-- date -->
							</a><!-- single -->
							
						<?php } ?>
					
					<?php $counter++; endwhile; endif; wp_reset_query(); ?>
					
				</div><!-- events_list -->
				
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>