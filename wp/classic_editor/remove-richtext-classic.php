<?php

/**
 * Remove rich text completely in classic, per post type
 */
function apuri_remove_rich_text( $default ) {
	if ( get_post_type() === 'cpt_slug' )  {
		return false;
	}
  return $default;
}
add_filter('user_can_richedit', 'apuri_remove_rich_text' );