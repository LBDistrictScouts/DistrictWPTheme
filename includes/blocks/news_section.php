<div class="news_section cf">
	<div class="wrapper">
		<h3 class="responsive cf"><a href="<?php bloginfo('url'); ?>/news-and-events/latest-news/">Latest <span>News</span></a></h3>
		<?php
			$arguments = array( 'post_type' => 'news', 'posts_per_page' => 1, 'orderby' => 'date' );
			$loop = new WP_Query( $arguments );
			if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
		?>
			<a href="<?php the_permalink(); ?>" class="left cf">
				<span class="shadow"></span>
				<div class="inner">
					<h6><?php the_title(); ?></h6>
					<span><?php the_time("jS F Y"); ?></span>
				</div><!-- inner -->
				<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail("news_feature", array("class" => "bg ease")); ?>
				<?php } else { ?>
					<img class="bg ease" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="" />
				<?php } ?>
			</a><!-- left -->
		<?php endwhile; endif; ?>
		<div class="right cf">
			<h3><a href="<?php bloginfo('url'); ?>/news-and-events/latest-news/">Latest <span>News</span></a></h3>
			<?php
				$arguments = array( 'post_type' => 'news', 'posts_per_page' => 3, 'orderby' => 'date', 'offset' => 1 );
				$loop = new WP_Query( $arguments );
				if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
			?>
				<a class="row" href="<?php the_permalink(); ?>">
					<div class="image">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php the_post_thumbnail("news_feature", array("class" => "bg ease")); ?>
						<?php } else { ?>
							<img class="bg ease" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="" />
						<?php } ?>
					</div><!-- image -->
					<div class="text">
						<h6><?php the_title(); ?></h6>
						<span><?php the_time("jS F Y"); ?></span>
					</div><!-- text -->
				</a><!-- row -->
			<?php endwhile; endif; ?>
		</div><!-- right -->
	</div><!-- wrapper -->
	<img class="cut" src="<?php bloginfo('template_url'); ?>/images/white_cut.png" alt="" />
</div><!-- news section -->