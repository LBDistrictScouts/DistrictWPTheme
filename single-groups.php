<?php get_header(); ?>

	<div class="wrapper">
		
		<div class="columns cf no_hero">
			
			<div class="col col_2 cf">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="post_info">
						<h1><?php the_title(); ?>...</h1>
						<h5>Postcode: <?php the_field("postcode"); ?></h5>
					</div><!-- post_info -->
					<?php the_content(); ?>
				<?php endwhile; endif; ?>

				<!-- Meeting Times -->
				<?php if( have_rows('section_meeting_times') ): ?>
					<h2>Meeting Times</h2>
					<div class="meeting_list cf">
						<?php while( have_rows('section_meeting_times') ): the_row(); 

							// vars
							$start = get_sub_field('start_time');
							$end = get_sub_field('end_time');
							$day = get_sub_field('meeting_day');
							$section_type = get_sub_field('section_type');

							?>

							<div class="meeting">
								<a class="single large">
									<p><?php echo $section_type->name; ?></p>
									<small><span class="day"><?php echo $day->name; ?></span> ( <span class="time"><?php echo $start; ?></span> - <span class="time"><?php echo $end; ?></span> )</small>
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
				
				<!-- District Directory -->

				<?php if(is_user_logged_in()){ ?>

					<br/>
					<hr/>
					<h2>Group District Directory Contacts</h2>
					

					<p>Logged in as <strong><?php echo ucwords(implode(', ', get_userdata(get_current_user_id())->roles)); ?></strong></p>

					<div class="directory_list cf">
						<?php 
							$group_id = get_the_ID();
							$people = kolodoGetGroupPeople(array('leader', 'directory_administrator', 'group_administrator', 'administrator'), $group_id); 
							foreach($people as $person){ 
						?>
							<a href="<?php bloginfo('url'); ?>/district-directory/person/?sid=<?php echo $person->ID; ?>">
								<p><?php the_field('first_name', 'user_'.$person->ID); ?> <?php the_field('last_name', 'user_'.$person->ID); ?></p>
								<small>Email: <?php the_field('email', 'user_'.$person->ID); ?></small>
								<span class="arrow">&raquo;</span>
							</a>
						<?php } ?>
					</div><!-- directory_list -->
				<?php } ?>


			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>