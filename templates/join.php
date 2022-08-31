<?php
/*
	Template Name: Join
*/
?>
<?php get_header(); ?>
<script>
   function onSubmit(token) {
     document.getElementById("join_form").submit();
   }
 </script>
	
	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 join_today cf">

                <form action="<?php bloginfo('template_url'); ?>/form-processing/join.php" id="join_form"  class="standard_form cf" method="POST" autocomplete="off">

                    <h4>Join Scouting Today!</h4>

                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
					
					<div class="fields cf">

                        <div class="field full">
                            <input type="text" class="text" name="join_full_name" id="join_full_name" placeholder="Full Name" required />
                        </div>

                        <div class="field full">
                            <input type="date" class="text" name="join_dob" id="join_dob" placeholder="D.O.B" required />
                        </div>

                        <div class="field full">
                            <input type="text" class="text" name="join_parent_name" id="join_parent_name" placeholder="Parent Name" required />
                        </div>

                        <div class="field full">
                            <input type="email" class="text" name="join_parent_email" id="join_parent_email" placeholder="Parent Email" required />
                        </div>

                        <div class="field full">
                            <input type="text" class="text" name="join_parent_telephone" id="join_parent_telephone" placeholder="Parent Telephone Number" />
                        </div>

                        <div class="field full select_box">
                            <span class="arrow"></span>
                            <select name="join_group" id="join_group" required>
                                <option value="">- Select a Group -</option>
                                    <option value="Not Specific">Don't mind which group.</option>
								<?php
								$arguments = array( 'post_type' => 'groups', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' );
								$loop = new WP_Query( $arguments );
								if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
									?>
                                    <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
								<?php
								endwhile; endif;
								wp_reset_query();
								?>
                            </select>
                        </div><!-- select_box -->
						
						<?php $option = get_option('lbd_settings'); ?>

						<div class="field half">
							<input type="submit" data-sitekey="<?php echo $option['recap_site_id']; ?>" class="submit g-recaptcha"  data-callback="onSubmit" value="Join" />
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