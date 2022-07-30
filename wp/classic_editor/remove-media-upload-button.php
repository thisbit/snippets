<?php
/**
 * Removes media upload ability based on post type
 */
function apuri_remove_all_media_buttons() {
	global $post;
	$cpt = $post;
	if ( 'apuri_osoblje' === get_post_type( $cpt ) ) {
		remove_all_actions( 'media_buttons' );
	}
}
add_action( 'wp_editor_settings', 'apuri_remove_all_media_buttons' );