<?php
/*
	Template Name: Newsletter
*/
?>
<?php get_header(); ?>
	
	<div class="wrapper">
		
		<div class="columns cf no_hero">
			
			<div class="col col_2 cf">
	
				<form class="standard_form cf" action="<?php bloginfo('template_url'); ?>/form-processing/newsletter.php" method="POST" autocomplete="off">
					
					<h5>Sign up to our newsletter...</h5>
					
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
					
					<div class="fields cf">
					
						<div class="field full">
							<label for="newsletter_name">Full Name</label>
							<input type="text" class="text" name="newsletter_name" id="newsletter_name" />
						</div><!-- field -->
						
						<div class="field full">
							<label for="newsletter_email">Email Address</label>
							<input type="text" class="text" name="newsletter_email" id="newsletter_email" />
						</div><!-- field -->
						
						<div class="field half">
							<input type="submit" class="submit" value="Sign up" />
						</div><!-- field -->
						
					</div><!-- fields -->
					
				</form><!-- standard_form -->
								
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>