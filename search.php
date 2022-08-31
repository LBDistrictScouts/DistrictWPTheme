<?php get_header(); ?>

	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 cf">
			
				<h1>Search Results...</h1>
				
				<?php if ( have_posts() ) { ?>
					<h6>Below are your results for your search criteria.</h6>
				<?php } else { ?>
					<h6>Unfortunately we couldn't find anything that matched your search query.</h6>
				<?php } ?>
				
				<div class="search_results cf">
					<?php if ( have_posts() ) { ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php $post_type = get_post_type(); ?>
							<a href="<?php if ( $post_type == "groups" ) { ?><?php bloginfo('url'); ?>/find-your-nearest-group/?location=<?php echo get_search_query(); ?><?php } else { ?><?php the_permalink(); ?><?php } ?>" class="single ease">
								<h5><?php the_title(); ?></h5>
								<?php if ( get_field("date") ) { ?><p><?php echo date("jS F Y", strtotime(get_field("date"))); ?></p><?php } ?>
								<?php if ( get_field("location") ) { ?><p><?php the_field("location"); ?></p><?php } ?>
								<span><?php echo $post_type; ?></span>
							</a>
						<?php endwhile; ?>
					<?php } ?>
				</div><!-- search_results -->	
			
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>