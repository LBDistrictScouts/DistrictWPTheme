<?php
/*
	Template Name: Co-ordinator
*/
?>
<?php get_header(); ?>
	
	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 cf">
				
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
				
				<?php if( have_rows('co_ordinator_editions') ): ?>
					<div class="co_ordinator cf">
						<?php while( have_rows('co_ordinator_editions') ): the_row(); 
							// vars
							$document = get_sub_field('edition');
							?>
								<?php if( $document ): 
									// vars
									$url = $document['url'];
									$title = $document['title'];
									$caption = $document['caption'];
									
									// icon
									$icon = $document['icon'];
									
									if( $document['type'] == 'image' ) {
										$icon =  $document['sizes']['thumbnail'];
									} ?>

									<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
										<!-- <img src="<?php //echo $icon; ?>" /> -->
										<p><?php echo $title; ?></p>
										<small><?php echo $document['filename']; ?></small>
										<span class="arrow">&raquo;</span>
									</a>
								<?php endif; ?>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
				
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->

<?php get_footer(); ?>