<?php
/** 
 * Prevent password change for nonadmins
 * @link https://wpengineer.com/2285/disable-password-fields-for-non-admins/
 * 
 * 
 * Find out more about all this
 * @link https://wordpress.stackexchange.com/questions/94968/is-it-possible-to-block-subscriber-users-to-changing-its-password
 * CREDITS - thanks to:
 * You get the role using code like this:
 * Getting a user role from the user login name
 * This was the source of my bit of blocking code:
 * @link https://www.isitwp.com/disable-the-allow_password_reset-feature/
 * You can extend the number of options you want to block or perhaps use a ! to select those which are not in the users->roles array should you want that.
 * Thanks to:
 * @link https://stackoverflow.com/questions/2440506/how-to-check-if-an-array-value-exists
 * @link https://www.geeksforgeeks.org/php-in_array-function/
 * This was where I got the code - originally for logging who attempted to change a password - which I used to wrap and trigger the password reset blocking function. It provides the hook to detect when a password reset request was being made and grabs the user who was making it. You could also add a line for logging the user, as this post suggests.
 * How can I tell who changed the password?
 * This answer gives some useful ideas on how to make a log file separately from the PHP error log: 
 * @link https://stackoverflow.com/questions/4660692/is-it-possible-to-print-a-log-of-all-database-queries-for-a-page-request-in-word/4660903#4660903
 * I couldn't find this exact functionality anywhere else so hope it might help somebody.
 * Apologies if my code is not entirely WordPress perfect but it has worked on six sites so far and performs as expected. It uses the functionality of the standard wp-login.php template - sorry to those who want more personalised stuff but there is other code here for that.
*/

function thisbit_disable_password_fields() {
	if ( is_admin() && ! current_user_can( 'administrator' ) ) { // in admin area for non administrators, we could also run it only on profile page
	    add_filter( 'show_password_fields', '__return_false' );
	}
}

add_action( 'admin_init', 'thisbit_disable_password_fields', 10 );


// Block Editor Accounts from external Password Reset

function disable_password_reset() {
  return false; 
}

add_action( 'retrieve_password', 'log_password_requests' );

function log_password_requests( $user_name_or_email ) {
	$user = get_user_by( 'login', $user_name_or_email );

	if (in_array( "editor", $user->roles )){
	   add_filter ( 'allow_password_reset', 'disable_password_reset' );
	   } else{
	   remove_filter ( 'allow_password_reset', 'disable_password_reset' );
	}
}

