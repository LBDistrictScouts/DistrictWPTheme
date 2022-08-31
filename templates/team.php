<?php
/*
	Template Name: Team
*/
?>
<?php get_header(); ?>
	
	<div class="wrapper">
		
		<div class="columns cf no_hero">
			
			<div class="col col_2 cf">
				
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
				
				<div class="team_list cf">
					<?php $team_counter = 1; ?>
					<?php $team_args = array( 'post_type' => 'district_team', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ); $team_loop = new WP_Query( $team_args ); ?>
					<?php if (have_posts()) : while ( $team_loop->have_posts() ) : $team_loop->the_post(); ?>
						<div class="single<?php if ( $team_counter == 1 ) { ?> open<?php } ?>">
							<h5><?php the_title(); ?></h5>
							<span class="job_title"><?php echo get_field('job_title'); ?></span>
							<?php if ( get_the_content() ) { ?>
								<div class="read_more">
									<?php if ( has_post_thumbnail() ) { ?>
										<div class="image">
											<?php the_post_thumbnail('team_thumbnail'); ?>
										</div><!-- image -->
									<?php } ?>
									<?php the_content(); ?>
								</div><!-- read_more -->
								<a href="" class="btn green view">Read <?php if ( $team_counter == 1 ) { ?>less<?php } else { ?>more<?php } ?></a>
							<?php } ?>
							<a href="<?php bloginfo('url'); ?>/contact/?to_contact=<?php echo urlencode(the_title()); ?>" class="btn purple contact">Contact <?php $first_name = explode(" ",get_the_title()); echo $first_name[0]; ?></a>
						</div><!-- single -->
						<?php $team_counter++; ?>
					<?php endwhile; endif; wp_reset_query(); ?>
				</div><!-- team_list -->
				
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>