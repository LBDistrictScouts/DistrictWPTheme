<?php
/*
	Template Name: Contact
*/
?>
<?php get_header(); ?>
<script>
   function onSubmit(token) {
     document.getElementById("contact_form").submit();
   }
 </script>
	
	<div class="wrapper">
		
		<div class="columns cf">	
			
			<div class="col col_2 cf">
	
				<form class="standard_form cf" id="contact_form" action="<?php bloginfo('template_url'); ?>/form-processing/contact.php" method="POST" autocomplete="off">
					
					<h5>Send us a message...</h5>
					
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
					
					<div class="fields cf">

						<?php if ( !empty($_GET['to_contact']) ) : ?>

							<input type="hidden" name="to_contact" value="<?php echo $_GET['to_contact']; ?>" />

							<div class="field full">
								<label for="to_email_address">Send to Contact</label>
								<input type="email" class="text" name="to_email_address" id="to_email_address" disabled value="<?php echo $_GET['to_contact']; ?>" />
							</div>

						<?php endif; ?>
					
						<div class="field full">
							<label for="contact_full_name">Full Name</label>
							<input type="text" class="text" name="contact_full_name" id="contact_full_name" required />
						</div><!-- field -->
						
						<div class="field full">
							<label for="contact_email_address">Email Address</label>
							<input type="email" class="text" name="contact_email_address" id="contact_email_address" required />
						</div><!-- field -->
						
						<div class="field full">
							<label for="contact_telephone">Telephone Number</label>
							<input type="text" class="text" name="contact_telephone" id="contact_telephone" />
						</div><!-- field -->
						
						<div class="field full">
							<label for="contact_enquiry">Enquiry</label>
							<textarea class="text" name="contact_enquiry" id="contact_enquiry"></textarea>
						</div><!-- field -->
						
						<?php $option = get_option('lbd_settings'); ?>

						<div class="field half">
							<input type="submit" data-sitekey="<?php echo $option['recap_site_id']; ?>" class="submit g-recaptcha"  data-callback="onSubmit" value="Send Enquiry" />
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