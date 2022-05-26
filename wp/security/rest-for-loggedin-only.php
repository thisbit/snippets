<?php
/**
 * Allow rest requests only for logged in users, for example http://domain.com/wp-json/wp/v2/users
 * Prevents user enumeration, for security resons
 * Combine with http://domain.com/?author=1 using htaccess (check my htaccess folder in this repo)
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