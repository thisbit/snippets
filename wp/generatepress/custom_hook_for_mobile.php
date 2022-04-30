<?php
/* 
* Plugin Name: Mobile Only Custom Hook for GeneratePress sites
* Description: this is just a concept, works on my site, the idea being that mobile quicklink menu should only load for mobiles
*/

function prefix_mobile_quicklinks() {
	if ( wp_is_mobile() && function_exists( 'generate_after_footer' ) ) :
	  	do_action( 'mobile_quicklinks' );
	endif;
}
add_action( 'generate_after_footer', 'prefix_mobile_quicklinks' );