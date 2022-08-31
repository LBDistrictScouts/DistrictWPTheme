<?php get_header(); ?>

	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
			<div class="col col_2 cf">
				<h1>Error 404</h1>
				<h6>Oops, something has gone wrong. The page you're looking for cannot be found.</h6>
				<p>Please take a look at our sitemap below, which will hopefully get you back on track!</p>
				<ul class="site_map cf">
					<li><a href="<?php bloginfo('url'); ?>">Home</a></li>
					<?php wp_list_pages('title_li=&exclude=74,368,381,406,696'); ?>
				</ul>
			</div><!-- col_2 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>