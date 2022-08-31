<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link rel="icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

        <!-- Hard Coded -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/dd_letchworth.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/responsive.css">
		
		<!-- Osano Data Consent -->
		<script src="https://cmp.osano.com/AzZctHS568RCI13uD/8e64d152-8bad-4ea5-b12e-6ee984ab3dcf/osano.js"></script>

        <!-- JQUERY & Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        
        <script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script type="text/javascript">var template_url = '<?php bloginfo('template_url'); ?>', site_url = '<?php bloginfo('url'); ?>';</script>
        <script src="<?php bloginfo('template_url'); ?>/js/main.js"></script>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
	    
	<?php include get_template_directory() . '/includes/blocks/search_overlay.php'; ?>
	<?php include get_template_directory() . '/includes/blocks/nav_overlay.php'; ?>

    <header class="header cf<?php if ( $post->post_parent || is_single() ) { ?> no_hero<?php } ?>">
        <div class="primary cf">
            <div class="wrapper">
                <a href="<?php bloginfo('url'); ?>" class="logo">
                    <img class="icon" src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="Logo" />
                    <h2>Letchworth <br/>& Baldock<br/> District</h2>
                </a>
                <div class="bar">
                    <div class="head_wrap">
                        <div class="nav_wrap">
                            <?php wp_nav_menu(['theme_location' => 'secondary_nav', 'container' => false]); ?>
                        </div><!-- nav wrap -->
                        <div class="social">
                            <?php if ( get_field("social_media_facebook_url",1820) ) { ?>
                            	<a class="icon" href="<?php the_field("social_media_facebook_url",1820); ?>" target="_blank">
                            		<img class="icon" src="<?php bloginfo('template_url'); ?>/images/facebook_icon.png" alt="Facebook" />
                            	</a>
                            <?php } ?>
                            <?php if ( get_field("social_media_twitter_url",1820) ) { ?>
                            	<a class="icon" href="<?php the_field("social_media_twitter_url",1820); ?>" target="_blank">
                            		<img class="icon" src="<?php bloginfo('template_url'); ?>/images/twitter_icon.png" alt="Twitter" />
                            	</a>
                            <?php } ?>
                            <?php if ( get_field("social_media_youtube_url",1820) ) { ?>
                            	<a class="icon" href="<?php the_field("social_media_youtube_url",1820); ?>" target="_blank">
                            		<img class="icon" src="<?php bloginfo('template_url'); ?>/images/youtube_icon.png" alt="YouTube" />
                            	</a>
                            <?php } ?>
                            <?php if ( get_field("social_media_instagram_url",1820) ) { ?>
                            	<a class="icon" href="<?php the_field("social_media_instagram_url",1820); ?>" target="_blank">
                            		<img class="icon" src="<?php bloginfo('template_url'); ?>/images/instagram_icon.png" alt="Instagram" />
                            	</a>
                            <?php } ?>
                            <a class="icon" href="<?php bloginfo('url'); ?>/feed/" target="_blank">
                            	<img class="icon" src="<?php bloginfo('template_url'); ?>/images/rss_icon.png" alt="RSS" />
                            </a>
                        </div><!-- socail -->
                    </div><!-- head wrap -->
                    <div class="search">
                        <img class="icon" src="<?php bloginfo('template_url'); ?>/images/search_icon.png" alt="Search" />
                    </div><!-- search -->
                    <div class="hamburger">
                        <img class="icon" src="<?php bloginfo('template_url'); ?>/images/hamburger_icon.png" alt="Navigation" />
                    </div><!-- hamburger -->
                </div><!-- bar -->
            </div><!-- wrapper -->
        </div><!-- primary -->

        <div class="secondary cf">
            <div class="wrapper">
                <?php 
                    if(is_user_logged_in()) {
                        wp_nav_menu(['theme_location' => 'primary_logged_in', 'container' => false]);
                    } else {
                        wp_nav_menu(['theme_location' => 'primary_logged_out', 'container' => false]);
                    }
                 ?>
                <a href="<?php bloginfo('url'); ?>/" class="home">
                    <img class="icon" src="<?php bloginfo('template_url'); ?>/images/home.png" alt="icon" />
                </a>
            </div><!-- wrapper -->
        </div><!-- secondary -->

    </header>
    
    <?php if ( is_front_page() ) { ?>

	    <div class="hero large">
	    	<?php $random = rand(1,5); ?>
	        <img class="bg" src="<?php echo get_field("banner_image_" . $random)["url"]; ?>" alt="" />
	        <div class="inner center">
	            <h1><?php the_field("banner_headline",1820); ?></h1>
	            <p><?php the_field("banner_text",1820); ?></p>
	            <a class="btn" href="<?php bloginfo('url'); ?>/about/">Find Out More</a>
	            <a class="btn green" href="<?php bloginfo('url'); ?>/join/">Join Us Today</a>
	        </div><!-- inner center -->
	        <img class="cut" src="<?php bloginfo('template_url'); ?>/images/white_cut.png" alt="" />
	    </div><!-- hero -->
	    
	<?php } elseif ( is_404() ) { ?>
	
		<div class="hero">
	        <img class="bg" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="Hero Image" />
	        <div class="inner center">
	        	<h1>Page not found</h1>
				<p>Unfortunately we could not find the page you are looking for. Please choose a page from the sitemap below.</p>	    
	        </div><!-- inner center -->
	        <img class="cut" src="<?php bloginfo('template_url'); ?>/images/white_cut_alt.png" alt="" />
	    </div><!-- hero -->
	    
	<?php } elseif ( is_search() ) { ?>
		
		<div class="hero">
	        <img class="bg" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="Hero Image" />
	        <div class="inner center">
	        	<h1>Search</h1>
				<p>You searched for: <?php echo get_search_query(); ?></p>	    
	        </div><!-- inner center -->
	        <img class="cut" src="<?php bloginfo('template_url'); ?>/images/white_cut_alt.png" alt="" />
	    </div><!-- hero -->
		
	<?php } else if ( $post->post_parent || is_single() ) {} else { ?>
	
		<div class="hero">
			<?php if ( has_post_thumbnail() ) { ?>
				<?php the_post_thumbnail('feature', array('class' => 'bg')); ?>
			<?php } else { ?>
				<img class="bg" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="Hero Image" />
			<?php } ?>
	        <div class="inner center">
	        	<?php if ( is_singular('news') ) { ?>
		            <h1><?php the_field("banner_heading",38); ?></h1>
		            <p><?php the_field("banner_text",38); ?></p>
	        	<?php } else if ( is_singular('events') ) { ?>
		            <h1><?php the_field("banner_heading",40); ?></h1>
		            <p><?php the_field("banner_text",40); ?></p>
	        	<?php } else if ( is_singular('training') ) { ?>
		            <h1><?php the_field("banner_heading",59); ?></h1>
		            <p><?php the_field("banner_text",59); ?></p>
	        	<?php } else { ?>
		            <h1><?php if ( get_field("banner_heading") ) { the_field("banner_heading"); } else { the_title(); } ?></h1>
		            <p><?php the_field("banner_text"); ?></p>
	        	<?php } ?>
	        </div><!-- inner center -->
	        <img class="cut" src="<?php bloginfo('template_url'); ?>/images/white_cut_alt.png" alt="" />
	    </div><!-- hero -->
	
	<?php } ?>