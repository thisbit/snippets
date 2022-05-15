<?php
// enable core link manager
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

// display list of links with shortcode
function thisbit_bookmarks(){
	ob_start();
	echo wp_list_bookmarks();
return ob_get_clean();
}
add_shortcode('links', 'thisbit_bookmarks'); 


