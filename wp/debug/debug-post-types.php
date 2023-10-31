<?php
// List all registered post types 
function apuri_debug_list_post_types() {
	$post_types = get_post_types( '', 'names' ); 
 
	echo '<pre style="min-height: 720px;">';
	echo '<h4>Registered Post Types</h4>';
			
	foreach ( $post_types as $post_type ) {
		echo $post_type . '<br>' ; 
	}
	
	echo '</pre>';
}

add_action( 'wp_head', 'apuri_debug_list_post_types' );