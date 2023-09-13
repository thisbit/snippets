<?php
/**
 * Disable display of Gutenberg Post Setting UI for a specific
 * taxonomy. While this isn't the official API for this need,
 * it works for now because only Gutenberg is dependent on the
 * REST API response.
 */
add_filter( 'rest_prepare_taxonomy', function( $response, $taxonomy ){
	if ( 'category' === $taxonomy->name ) {
		$response->data['visibility']['show_ui'] = false;
	}
	return $response;
}, 10, 2 );
