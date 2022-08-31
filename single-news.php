<?php get_header(); ?>

	<div class="wrapper">
		
		<div class="columns cf no_hero">
			
			<div class="col col_2 cf">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="post_info">
						<h1><?php the_title(); ?>...</h1>
						<h5>Written on: <?php the_time("jS F Y"); ?></h5>
					</div><!-- post_info -->
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>