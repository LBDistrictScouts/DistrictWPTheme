<?php
/*
	Template Name: Group Finder
*/
?>
<?php get_header(); ?>

	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 cf">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>

				<p>You searched for Scout Groups near <strong id="location"><?php echo $_GET['location']; ?></strong>. Hover over Groups on the map to find out more. Full details of each Group can be found below.</p>
				
				<div id="groupsMap">
					<div id="groupsMapContain"></div><!-- groupsMapContain -->
				</div><!-- groupsMap -->

				<div class="search_results"></div><!-- search_results -->
				
				<div class="loading">
					<div class="inner">
						<img src="<?php bloginfo('template_url'); ?>/images/loader.gif" alt="Loading..." />
						<h5>Loading...</h5>
						<p>Please bear with us, we're just loading your results...</p>
					</div><!-- inner -->
				</div><!-- loading -->

			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>