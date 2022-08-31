<?php

	@ini_set( 'upload_max_size' , '64M' );
	@ini_set( 'post_max_size', '64M');
	@ini_set( 'max_execution_time', '300' );
	
	
	// Register Thumbnail Support //
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'feature', 1500, 1000, true );
	add_image_size( 'news_feature', 1000, 1000, true ); 
	add_image_size( 'news_thumbnail', 350, 200, true ); 
	add_image_size( 'gallery_thumbnail', 300, 300, true ); 
	add_image_size( 'team_thumbnail', 250, 250, true ); 

	include(TEMPLATEPATH . '/admin/widget.php');
	include(TEMPLATEPATH . '/admin/settings_panel.php');
	
	include(TEMPLATEPATH . '/custom-nav-spec.php');
	include(TEMPLATEPATH . '/custom-post-spec.php');		
	include(TEMPLATEPATH . '/custom-role-spec.php');

	include(TEMPLATEPATH . '/district-directory/directory.php');
	include(TEMPLATEPATH . '/district-directory/syncDirectory.php');
	include(TEMPLATEPATH . '/district-directory/scheduleSync.php');

	// Is Tree //
	function is_tree( $pid ) {
	    global $post;
	    if ( is_page($pid) )
	        return true;
	    $anc = get_post_ancestors( $post->ID );
	    foreach ( $anc as $ancestor ) {
	        if( is_page() && $ancestor == $pid ) {
	            return true;
	        }
	    }
	    return false; 
	}
	
	// Update Longitude & Latitude
	function kolodoUpdateGroupFinder( $post_id, $latitude, $longitude ) {
		global $wpdb;
		if ( !$wpdb->query("SELECT * FROM kolodo_groups WHERE group_id = '$post_id'" ) ) {
			$wpdb->query("INSERT INTO kolodo_groups (group_id,latitude,longitude) VALUES ('$post_id','$latitude','$longitude')");
		} else {
			$wpdb->query("UPDATE kolodo_groups SET latitude = '$latitude', longitude = '$longitude' WHERE group_id = '$post_id'");
		}
	}
	function save_groups_meta( $post_id, $post, $update ) {
		$post_type = get_post_type($post_id);
		if ( "groups" != $post_type ) return;
		$postcode = str_replace(' ','',get_field("postcode",$post_id));
		$postcode_google_maps = simplexml_load_string(file_get_contents("https://maps.googleapis.com/maps/api/geocode/xml?address=".$postcode."&sensor=false"));
		$postcode_lat = (string) $postcode_google_maps->result->geometry->location->lat;
		$postcode_lng = (string) $postcode_google_maps->result->geometry->location->lng;
        update_field("latitude", $postcode_lat, $post_id);
        update_field("longitude", $postcode_lng, $post_id);
        kolodoUpdateGroupFinder($post_id,$postcode_lat,$postcode_lng);
	}
	add_action( 'save_post', 'save_groups_meta', 10, 3 );
	
	// Twitter
	function kolodoTwitter($offset=0) {
		global $wpdb;
		$tweet = $wpdb->get_results( "SELECT * FROM kolodo_twitter ORDER BY tweet_timestamp DESC LIMIT 1 OFFSET $offset", OBJECT );
		return $tweet;
	}
	function kolodoTwitterTweetFormat($tweet) {
		$formatted_tweet = preg_replace('/(\b(www\.|http\:\/\/)\S+\b)/', "<a target='_blank' href='$1'>$1</a>", $tweet);
		$formatted_tweet = preg_replace('/(\b(www\.|https\:\/\/)\S+\b)/', "<a target='_blank' href='$1'>$1</a>", $formatted_tweet);
		$formatted_tweet = preg_replace('/\#(\w+)/', "<a target='_blank' href='https://twitter.com/search?q=$1'>#$1</a>", $formatted_tweet);
		$formatted_tweet = preg_replace('/\@(\w+)/', "<a target='_blank' href='http://twitter.com/$1'>@$1</a>", $formatted_tweet);
		return $formatted_tweet;
	}
	function kolodoTwitterTweetTime($date,$granularity=1) {
	    $difference = time() - $date;
	    $periods = array('decade' => 315360000,
	        'year' => 31536000,
	        'month' => 2628000,
	        'week' => 604800, 
	        'day' => 86400,
	        'hour' => 3600,
	        'minute' => 60,
	        'second' => 1);
	
	    foreach ($periods as $key => $value) {
	        if ($difference >= $value) {
	            $time = floor($difference/$value);
	            $difference %= $value;
	            $retval .= ($retval ? ' ' : '').$time.' ';
	            $retval .= (($time > 1) ? $key.'s' : $key);
	            $granularity--;
	        }
	        if ($granularity == '0') { break; }
	    }
	    return $retval.' ago';
	}
	
	// Events Back-End
	function kolodoEventSections($event_id) {
		$sections = wp_get_post_terms($event_id,"events_sections",array('orderby' => 'ID','order' => 'ASC'));
		$result = null;
		$sections_sep = null;
		foreach ( $sections as $section ) {
			$result .= $sections_sep . $section->name;
			$sections_sep = ", ";
		}
		return $result;
	}
	function kolodoEventSection($event_id,$check_section) {
		$sections = wp_get_post_terms($event_id,"events_sections",array('orderby' => 'ID','order' => 'ASC'));
		$result = "false";
		foreach ( $sections as $section ) {
			if ( $check_section == $section->name ) {
				$result = "true";
			}
		}
		return $result;
	}
	
	// Shortcodes
	function shortcode_upcoming_events($atts) {
		extract(shortcode_atts(array(
			"section" => ''
		), $atts));
		$arguments = array( 'post_type' => 'events', 'posts_per_page' => -1, 'orderby' => 'meta_value', 'meta_key' => 'date', 'order' => 'ASC', 'events_sections' => $section, 'meta_query' => array( 'key' => 'date', 'value' => date("Ymd"), 'compare' => '>=', 'type' => 'numeric' ) );
		$loop = new WP_Query( $arguments );
		if ( $loop->have_posts() ) :
			$upcoming_events = '<div class="events_list cf">';
			while ( $loop->have_posts() ) : $loop->the_post();
				$upcoming_events .= '<a class="single" href="' . get_the_permalink() . '">
				<h5>' . get_the_title() . '</h5>';
				if ( kolodoEventSections(get_the_ID()) ) { $upcoming_events .= '<p>' . kolodoEventSections(get_the_ID()) . '</p>'; }
				$upcoming_events .= '<span class="time">Read more &raquo;</span>
				<span class="date">
					<span class="inner align_vertical">
						<span class="number">' . date("d", strtotime(get_field("date"))) . '</span>
						<span class="month">' . date("M", strtotime(get_field("date"))) . '</span>
					</span><!-- inner -->
				</span><!-- date -->
				</a><!-- single -->';
			endwhile;
			$upcoming_events .= '</div><!-- events_list -->';
		else:
			$upcoming_events = '<p>There are currently no upcoming events within the County for this section.</p>';
		endif; wp_reset_query();
		return $upcoming_events;
	}
	add_shortcode('upcoming_events','shortcode_upcoming_events');
	
	
	function title_format($content) {
		return '%s';
	}
	add_filter('private_title_format', 'title_format');
	add_filter('protected_title_format', 'title_format');
	
	function my_login_logo() { ?>
	    <style type="text/css">
	        #login h1 a, .login h1 a {
	            background-image: url(<?php bloginfo('template_url'); ?>/images/scout_logo.png);
				height:85px;
				width:auto;
				background-size: auto 85px;
				background-repeat: no-repeat;
		        padding-bottom: 0px;
	        }
	    </style>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo' );
	?>
