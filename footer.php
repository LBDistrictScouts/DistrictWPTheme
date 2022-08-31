	<div class="banner_section cf">
		<div class="wrapper">
			
			<div class="find_bar cf">
				<h3>Find Your<span>Nearest Group...</span></h3>
				<p>Enter your location or postcode to find your nearest Scout Group!</p>
				<form class="cf" action="<?php bloginfo('url'); ?>/find-your-nearest-group/" method="GET" autocomplete="off">
					<input type="text" class="text" name="location" value="<?php if ( $s ) { echo $s; } else { echo 'Location / Postcode'; } ?>" onfocus="if (this.value == 'Location / Postcode') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Location / Postcode';}" />
					<button class="icon_wrap">
						<img src="<?php bloginfo('template_url'); ?>/images/location.png" alt="">
					</button><!-- icon wrap -->
				</form>
			</div><!-- find bar -->

			<div class="quote_bar cf">
				<div class="text_wrap">
					<h3>Scouting provides a <span>second family</span> to lots of young people</h3>
					<span class="name">Bear Grylls, Chief Scout</span>
				</div><!-- text wrap -->
				<img class="bear" src="<?php bloginfo('template_url'); ?>/images/bear.png" alt="Bear Grylls">
			</div><!-- quote bar -->

		</div><!-- wrapper -->
	</div><!-- banner section -->

	<footer class="footer cf">
		<div class="top cf">
			<div class="wrapper">
				<div class="col">
					<h5>Our District</h5>
					<?php 
						if(is_user_logged_in()) {
	                        wp_nav_menu(['theme_location' => 'footer_left_in', 'container' => false]);
	                    } else {
	                        wp_nav_menu(['theme_location' => 'footer_left_out', 'container' => false]);
	                    }
					 ?>
				</div><!-- col -->
				<div class="col">
					<h5>Useful Links</h5>
					<?php wp_nav_menu(['theme_location' => 'footer_right', 'container' => false]); ?>
				</div><!-- col -->
				<div class="col big">
					<a href="<?php the_field("newsletter_signup_url",1820); ?>" class="news_bar" target="_blank">
						<img class="newsletter" src="<?php bloginfo('template_url'); ?>/images/newsletter.png" alt="Newsletter" />
						<span>Sign Up To Our Newsletter</span>
					</a>
				</div><!-- col big -->
			</div><!-- wrapper -->
		</div><!-- top -->
		<div class="bottom cf">
			<div class="wrapper">
				<p class="left">Copyright &copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?></p>
				<p class="right">Website designed by <a target="_blank" href="https://www.scout-websites.co.uk/" class="">Scout Websites</a></p>
			</div><!-- wrapper -->
		</div><!-- bottom -->
	</footer>
	<div class="footer_image">
		<img src="<?php bloginfo('template_url'); ?>/images/footer_bg.png" alt="" />
	</div><!-- footer_image -->
	<?php wp_footer(); ?>
    </body>
</html>