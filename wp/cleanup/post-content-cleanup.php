<?php

/**
 * Remove extraneous whitespace from excerpts on blog posts, post archives and search results
 * Double test the output
 * Wonder why do this, real life reason here -> https://i.imgur.com/5KD8gOd.png
 */
add_filter( 'run_wptexturize', '__return_false' ); // removes wp feature that makes emdash from two consecutive dashes

function apuri_clean_post_content( $content ){

	$content = preg_replace( '/[\p{Z}\s]{2,}/mu', ' ', $content ); // trailing whitepace @link https://www.josheaton.org/wordpress-plugins/remove-double-space/
	$content = preg_replace('/[—-]{2,}/mu', '', $content); // repeating dashes
	$content = preg_replace( '#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content ); // empty p tags
    $content = preg_replace( '/(&nbsp;)+/i', '', $content ); // remove consecutive &nbsp;
    $content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $content); // remove css in the content (if it remains after bad theme removal )
    $content = preg_replace('/style\s*=\s*["\'][^"\']*["\']/i', '', $content); // remove css inside the style property
	
	if ( is_singular( 'post' ) ) {
		
		$content = str_replace( array( '<td>' ), '<p>', $content ); // wrap those td elements in p so that they are not without wrapper
		$content = strip_tags( $content, array( 'a', 'p', 'br', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li', 'figure'. 'figcaption', 'img' ) );
		
		// remove p tags that wrap image tags in classic editor
		$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);



		return wp_kses_decode_entities($content);
	} else {
		return $content;
	}
}

add_filter( "the_content", "apuri_clean_post_content", 20, 1 );