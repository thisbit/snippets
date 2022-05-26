<?php
/**
 * Allow rest requests only for logged in users
 * Prevents user enumeration, for security resons
 * @link https://developer.wordpress.org/rest-api/frequently-asked-questions/#require-authentication-for-all-requests
 */
add_filter( 'rest_authentication_errors', function( $result ) {
	// If a previous authentication check was applied,
	// pass that result along without modification.
	if ( true === $result || is_wp_error( $result ) ) {
			return $result;
	}
	if ( ! is_user_logged_in() ) {
			return new WP_Error(
					'rest_not_logged_in',
					__( 'You are not currently logged in.' ),
					array( 'status' => 401 )
			);
	}
	return $result;
});