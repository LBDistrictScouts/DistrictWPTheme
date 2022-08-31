<?php if ( is_tree(5) || is_tree(7) || is_page(38) || is_page(40) || is_tree(1188) || is_tree(17) || is_tree(2315) || is_singular('events') || is_singular('news') || is_singular('groups') ) { ?>
<div class="module links">
	<div class="title green">
		<h4>More in this section...</h4>
	</div><!-- title -->
	<div class="inner cf">
		<div class="list">
			<?php if ( is_tree(5) ) { ?>
				<p><a href="<?php bloginfo('url'); ?>/about/">About Us</a></p>
				<?php wp_nav_menu(array('menu' => 'Sidebar > About Us')); ?>
			<?php } else if ( is_tree(7) ) { ?>
				<p><a href="<?php bloginfo('url'); ?>/join/">Join</a></p>
				<?php wp_nav_menu(array('menu' => 'Sidebar > Join')); ?>
			<?php } else if ( is_tree(1188) ) { ?>
				<p><a href="<?php bloginfo('url'); ?>/jamboree/">Jamboree</a></p>
				<?php wp_nav_menu(array('menu' => 'Sidebar > Jamboree')); ?>
			<?php } else if ( is_tree(17) ) { ?>
				<p><a href="<?php bloginfo('url'); ?>/members/">Members</a></p>
				<?php wp_nav_menu(array('menu' => 'Sidebar > Members')); ?>
			<?php } else if ( is_tree(2315) ) { ?>
				<?php 
					if(is_user_logged_in() && canEdit() === true) {
						wp_nav_menu(array('menu' => 'Sidebar > Directory (Logged In - Admin)'));
					} else if(is_user_logged_in()){
						wp_nav_menu(array('menu' => 'Sidebar > Directory (Logged In - Leader)'));
					} else {
						wp_nav_menu(array('menu' => 'Sidebar > Directory (Logged Out)'));
					}
				?>
				<?php ; ?>
			<?php } else if ( is_singular('events') || is_singular('news') || is_page(38) || is_page(40) ) { ?>
				<p>News & Events</p>
				<?php wp_nav_menu(array('menu' => 'Sidebar > News & Events')); ?>
			<?php } else if ( is_singular('groups') ) { ?>
				<p>Groups</p>
				<ul>
				<?php
					$arguments = array( 'post_type' => 'groups', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
					$loop = new WP_Query( $arguments );
					if ( $loop->have_posts() ) :
						while ( $loop->have_posts() ) : $loop->the_post();
				?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php
						endwhile;
					endif;
				?>
			<?php } ?>
		</div><!-- list -->
	</div><!-- inner -->
</div><!-- module -->
<?php } ?>