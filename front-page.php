<?php get_header(); ?>

<div class="container cf">

	<div class="welcome_section cf">
		<div class="wrapper">

			<div class="left">
				<h2>Welcome To... <span><?php bloginfo('name'); ?></span></h2>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
				<a class="btn purple" href="<?php bloginfo('url'); ?>/about-us/">Find out more</a>
			</div><!-- left -->

			<div class="right">

				<div class="age block">
					<div class="title">
						<h3>Aged <span>6-25?</h3>
					</div><!-- title -->
					<ul>
						<li>
							<a href="<?php bloginfo('url'); ?>/join/beaver-scouts/" class="">
								<div class="age">6 - 8</div>
								<div class="img_wrap">
									<img width="158" class="group" src="<?php bloginfo('template_url'); ?>/images/beavers.png" alt="Beavers" />
								</div><!-- img wrap -->
								<span style="background: #ffcd04;" class="arrow ease">></arrow>
							</a>
						</li>
						<li>
							<a href="<?php bloginfo('url'); ?>/join/cub-scouts/" class="">
								<div class="age">8 - 10.5</div>
								<div class="img_wrap">
									<img width="118" class="group" src="<?php bloginfo('template_url'); ?>/images/cubs.png" alt="Cubs" />
								</div><!-- img wrap -->
								<span style="background: #83a43e;" class="arrow ease">></arrow>
							</a>
						</li>
						<li>
							<a href="<?php bloginfo('url'); ?>/join/scouts/" class="">
								<div class="age">10.5 - 14</div>
								<div class="img_wrap">
									<img width="160" class="group" src="<?php bloginfo('template_url'); ?>/images/scouts.png" alt="Scouts" />
								</div><!-- img wrap -->
								<span style="background: #044851;" class="arrow ease">></arrow>
							</a>
						</li>
						<li>
							<a href="<?php bloginfo('url'); ?>/join/explorer-scouts/" class="">
								<div class="age">14 - 18</div>
								<div class="img_wrap">
									<img width="180" class="group" src="<?php bloginfo('template_url'); ?>/images/explorers.png" alt="Explorers" />
								</div><!-- img wrap -->
								<span style="background: #152e53;" class="arrow ease">></arrow>
							</a>
						</li>
						<li>
							<a href="<?php bloginfo('url'); ?>/join/network-scouts/" class="">
								<div class="age">18 - 25</div>
								<div class="img_wrap">
									<img width="180" class="group" src="<?php bloginfo('template_url'); ?>/images/network.png" alt="Network" />
								</div><!-- img wrap -->
								<span style="background: #000000;" class="arrow ease">></arrow>
							</a>
						</li>
					</ul>
				</div><!-- block -->

				<div class="block volunteers">
					<h3>Adult<span>Volunteers...</span></h3>
					<p>The Scout Association award-winning training scheme for volunteers means that adults get as much from Scouts as young people.</p>
					<a class="btn clear" href="<?php bloginfo('url'); ?>/join/volunteers-and-active-support/">Volunteer today</a>
				</div><!-- block -->


			</div><!-- right -->
		</div><!-- wrapper -->
	</div><!-- welcome section -->
	
	<?php include get_template_directory() . '/includes/blocks/news_section.php'; ?>
	<?php include get_template_directory() . '/includes/blocks/events_section.php'; ?>

	<div class="gallery_section cf">
		<div class="wrapper">
			<h3><a href="<?php bloginfo('url'); ?>/gallery/">Our latest <span>photos & videos</span></a></h3>
			<ul class="gallery_list cf">
				<?php
					$arguments = array( 'post_type' => 'gallery', 'posts_per_page' => 5, 'orderby' => 'date' );
					$loop = new WP_Query( $arguments );
					if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
						if ( has_post_thumbnail() ) {
							include(TEMPLATEPATH.'/includes/loops/gallery_image.php');
						}
					endwhile; endif; wp_reset_query();
				?>
			</ul>
		</div><!-- wrapper -->
		<img class="cut" src="<?php bloginfo('template_url'); ?>/images/white_cut.png" alt="" />
	</div><!-- gallery section -->

</div><!-- container -->

<?php get_footer(); ?>