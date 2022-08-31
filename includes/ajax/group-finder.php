<?php

	// Include WordPress
	include_once('../../../../../wp-config.php');
	
	// Get Search Criteria
	$location = $_POST["location"] . ", UK";
	
	// Get Longitude and Latitude of Search Criteria
	$location_google_maps = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?address=".$location."&sensor=false");
	$location_lat = $location_google_maps->result->geometry->location->lat;
	$location_lng = $location_google_maps->result->geometry->location->lng;
	
	// Query Database for Nearest 16 Groups
	$google_maps_markers = array();
	global $wpdb;
	$groups = $wpdb->get_results("SELECT group_id, latitude, longitude, 111.045 * DEGREES(ACOS(COS(RADIANS($location_lat)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS($location_lng)) + SIN(RADIANS($location_lat)) * SIN(RADIANS(latitude)))) AS distance_in_km FROM kolodo_groups ORDER BY distance_in_km ASC LIMIT 0,16;");
	if ( $groups ) {
		foreach ( $groups as $group ) {
			$miles = $group->distance_in_km * 0.62137119;
			$arguments = array( 'post_type' => 'groups', 'p' => $group->group_id );
			$loop = new WP_Query( $arguments );
			if ( $loop->have_posts() ) :
				while ( $loop->have_posts() ) : $loop->the_post();
					$districts = wp_get_post_terms( get_the_ID(), array('groups_districts') ); foreach ( $districts as $district ) { $district_name = $district->name; }
?>
					<a href="<?php the_permalink(); ?>" class="single ease">
						<h5><?php the_title(); ?></h5>
						<span><?php echo $district_name; ?></span>
						<span><?php echo number_format($miles,1); ?> miles away</span>
						<span><?php the_field("postcode"); ?></span>
					</a><!-- single -->
<?php
					$google_maps_markers[] = array( "title" => get_the_title(), "latitude" => $group->latitude, "longitude" => $group->longitude );
				endwhile;
			endif;
		}
	}
	
	// Load Map
?>
<script>
      function initMap() {
        var search_location = {lat: <?php echo $location_lat; ?>, lng: <?php echo $location_lng; ?>};
        var map = new google.maps.Map(document.getElementById('groupsMapContain'), {
			zoom: 10,
			center: search_location
        });
        var marker = new google.maps.Marker({
			position: {lat: <?php echo $location_lat; ?>, lng: <?php echo $location_lng; ?>},
			map: map,
			icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
		});
        <?php foreach ( $google_maps_markers as $marker ) { ?>
	        var marker = new google.maps.Marker({
				position: {lat: <?php echo $marker["latitude"]; ?>, lng: <?php echo $marker["longitude"]; ?>},
				map: map,
				title: '<?php echo $marker["title"]; ?>',
				icon: 'https://maps.google.com/mapfiles/ms/icons/purple-dot.png'
			});
        <?php } ?>
      }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8VUudMvIbSTQ-Q88MDE1v0Fue_G4R8Nc&callback=initMap"></script>