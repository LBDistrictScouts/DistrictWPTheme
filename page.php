<?php get_header(); ?>

	<div class="wrapper">
		
		<div class="columns cf<?php if ( $post->post_parent ) { ?> no_hero<?php } ?>">
			
			<div class="col col_2 cf">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
				<?php if ( is_page(158) ) { ?>
					<h3>All pages</h3>
					<ul class="site_map cf">
						<li><a href="<?php bloginfo('url'); ?>">Home</a></li>
						<?php wp_list_pages('title_li=&exclude=74,368,381,406,696,379,380,2315,2317'); ?>
					</ul>
				<?php } ?>
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>