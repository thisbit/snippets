<?php

// place [content_here] shortcode where you want to place your hooked element

function apuri_hero_hook_function( $atts, $content = null ) {
	ob_start();
		do_action( 'prefix_content_here' );
   return ob_get_clean();	
}

add_shortcode( 'content_here', 'prefix_content_here' );