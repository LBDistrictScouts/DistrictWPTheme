<div class="nav_overlay">
	<a href="#" class="close">x</a>
	<div class="inner align_vertical">
		<div class="primary_nav">
			<?php 
				if(is_user_logged_in()) {
                        wp_nav_menu(['theme_location' => 'primary_logged_in', 'container' => false]);
                    } else {
                        wp_nav_menu(['theme_location' => 'primary_logged_out', 'container' => false]);
                    }
			 ?>
		</div><!-- primary_nav -->
		<div class="secondary_nav">
			<?php wp_nav_menu(['theme_location' => 'secondary_nav', 'container' => false]); ?>
		</div><!-- secondary_nav -->
	</div><!-- inner -->
</div><!-- search_overlay -->
