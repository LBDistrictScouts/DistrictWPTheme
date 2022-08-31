<div class="events_section cf">
	<div class="wrapper">
		<h3><a href="<?php bloginfo('url'); ?>/news-and-events/upcoming-events/">Upcoming Events</a></h3>
		<div class="col_wrap cf">
			<div class="col">
				<?php
					$arguments = array( 'post_type' => 'events', 'posts_per_page' => 3, 'orderby' => 'meta_value', 'meta_key' => 'date', 'order' => 'ASC', 'meta_query' => array( 'key' => 'date', 'value' => date("Ymd"), 'compare' => '>=', 'type' => 'numeric' ) );
					$loop = new WP_Query( $arguments );
					if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
				?>
					<a class="block ease" href="<?php the_permalink(); ?>">
						<div class="date">
							<div class="inner align_vertical">
								<span class="number"><?php echo date("d", strtotime(get_field("date"))); ?></span>
								<span class="month"><?php echo date("M", strtotime(get_field("date"))); ?></span>
							</div><!-- inner -->
						</div><!-- date -->
						<div class="text">
							<h6><?php the_title(); ?></h6>
							<?php if ( kolodoEventSections(get_the_ID()) ) { ?><p><?php echo kolodoEventSections(get_the_ID()); ?></p><?php } ?>
							<span>Read more &raquo;</span>
						</div><!-- text -->
					</a><!-- block -->
				<?php endwhile; endif; ?>
			</div><!-- col -->
			<div class="col down">
				<?php
					$arguments = array( 'post_type' => 'events', 'posts_per_page' => 3, 'offset' => 3, 'orderby' => 'meta_value', 'meta_key' => 'date', 'order' => 'ASC', 'meta_query' => array( 'key' => 'date', 'value' => date("Ymd"), 'compare' => '>=', 'type' => 'numeric' ) );
					$loop = new WP_Query( $arguments );
					if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
				?>
					<a class="block ease" href="<?php the_permalink(); ?>">
						<div class="date">
							<div class="inner align_vertical">
								<span class="number"><?php echo date("d", strtotime(get_field("date"))); ?></span>
								<span class="month"><?php echo date("M", strtotime(get_field("date"))); ?></span>
							</div><!-- inner -->
						</div><!-- date -->
						<div class="text">
							<h6><?php the_title(); ?></h6>
							<?php if ( kolodoEventSections(get_the_ID()) ) { ?><p><?php echo kolodoEventSections(get_the_ID()); ?></p><?php } ?>
							<span>Read more &raquo;</span>
						</div><!-- text -->
					</a><!-- block -->
				<?php endwhile; endif; ?>
			</div><!-- col -->
		</div><!-- col wrap -->
	</div><!-- wrapper -->
</div><!-- events section -->