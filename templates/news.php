<?php
/*
	Template Name: News
*/
?>
<?php get_header(); ?>
	
	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 cf">
	
				<div class="news_list cf">
					
					<?php
						$counter = 1;
						$arguments = array( 'post_type' => 'news', 'posts_per_page' => -1, 'orderby' => 'date' );
						$loop = new WP_Query( $arguments );
						if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
					?>
					
						<?php if ( $counter == 1 ) { ?> 
					
							<a class="single large" href="<?php the_permalink(); ?>">
								<div class="over">
									<h5><?php the_title(); ?></h5>
									<span class="date"><?php the_time('jS F Y'); ?></span>
								</div><!-- over -->
								<span class="shadow"></span>
								<span class="image">
									<?php if ( has_post_thumbnail() ) { ?>
										<?php the_post_thumbnail(); ?>
									<?php } else { ?>
										<img src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="" />
									<?php } ?>
								</span><!-- image -->
							</a><!-- single -->
							
						<?php } else { ?>
						
							<a class="single" href="<?php the_permalink(); ?>">
								<h5><?php the_title(); ?></h5>
								<span class="date"><?php the_time('jS F Y'); ?></span>
								<span class="image">
									<?php if ( has_post_thumbnail() ) { ?>
										<?php the_post_thumbnail('news_thumbnail'); ?>
									<?php } else { ?>
										<img src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="" />
									<?php } ?>
								</span><!-- image -->
							</a><!-- single -->
							
						<?php } ?>
					
					<?php $counter++; endwhile; endif; wp_reset_query(); ?>
					
				</div><!-- news_list -->
				
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>