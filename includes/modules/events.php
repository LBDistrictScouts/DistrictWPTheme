<div class="module events">
	<div class="title">
		<h4>Our Next Event</h4>
	</div><!-- title -->
	<div class="inner cf">
		<?php
			$arguments = array( 'post_type' => 'events', 'posts_per_page' => 1, 'orderby' => 'meta_value', 'meta_key' => 'date', 'order' => 'ASC', 'meta_query' => array( 'key' => 'date', 'value' => date("Ymd"), 'compare' => '>=', 'type' => 'numeric' ) );
			$loop = new WP_Query( $arguments );
			if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
		?>
			<a href="<?php the_permalink(); ?>" class="event">
				<h6><?php the_title(); ?></h6>
				<p class="info"><span class="date"><?php echo date("jS F Y", strtotime(get_field("date"))); ?></span> <span class="time">Read more &raquo;</span></p>
			</a>
		<?php endwhile; endif; ?>
		<?php wp_reset_query(); ?>
	</div><!-- inner -->
</div><!-- module -->