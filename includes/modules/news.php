<?php
	$arguments = array( 'post_type' => 'news', 'posts_per_page' => 1, 'orderby' => 'date' );
	$loop = new WP_Query( $arguments );
	if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
?>
	<a class="module news" href="<?php the_permalink(); ?>">
		<div class="title">
			<h4>Latest News</h4>
		</div><!-- title -->
		<?php if ( has_post_thumbnail() ) { ?>
			<?php the_post_thumbnail("news_feature", array("class" => "bg ease")); ?>
		<?php } else { ?>
			<img class="bg ease" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="" />
		<?php } ?>
		<span class="shadow"></span>
		<div class="inner cf">
			<h6><?php the_title(); ?></h6>
			<span class="date"><?php the_time("jS F Y"); ?></span>
		</div><!-- inner -->
	</a><!-- module -->
<?php endwhile; endif; ?>
<?php wp_reset_query(); ?>