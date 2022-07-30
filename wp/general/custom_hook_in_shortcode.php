<?php
/**
 * This is a basic custom hook wrapped in a shortcode, allows for dynamically placing content arround site
 * it could be extended to allow for placing custom queries, while leaving post templating to generatepress elements ...
 * this is a solution that predates generateblocks new edition that will have its own query block
 * place [content_here] shortcode where you want to place your hooked element
*/
function prefix_content_here( $atts, $content = null ) {
	ob_start();
		do_action( 'prefix_content_here' );
   return ob_get_clean();	
}

add_shortcode( 'content_here', 'prefix_content_here' );