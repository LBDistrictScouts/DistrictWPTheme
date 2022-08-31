<?php

if ( ! wp_next_scheduled( 'sync_directory' ) ) {
  wp_schedule_event( time(), 'hourly', 'sync_directory' );
}

add_action( 'sync_directory', 'syncUsers' );

?>