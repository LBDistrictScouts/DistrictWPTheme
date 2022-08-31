<li>
	<a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="fancybox" rel="tag">
		<img data-original="<?php the_post_thumbnail_url("gallery_thumbnail"); ?>" class="lazy"/>
		<noscript>
			<img src="<?php the_post_thumbnail_url("gallery_thumbnail"); ?>"/>
		</noscript>
		<?php if ( !is_home() ) { ?>
			<div class="over ease">
				<span class="align_vertical">+</span>
			</div><!-- over -->
		<?php } ?>
	</a>
</li>