<?php

/*
 * Plugin Name: Disable Password Reset
 * Description: Disable password reset functionality. Only users with administrator role will be able to change passwords from inside admin area. 
 * Version: 1.0
 */

// In ademin area
if ( is_admin() ) {
	add_action( 'init', 'disable_password_fields', 10 );

	function disable_password_fields() {
		// if ( ! current_user_can( 'administrator' ) )
		$show_password_fields = add_filter( 'show_password_fields', '__return_false' );
	}
}

// Hide pass reset link on login screen
function vpsb_remove_lostpassword_text ( $text ) {
	if ($text == 'Lost your password?'){$text = '';}
	return $text;
}
add_filter( 'gettext', 'vpsb_remove_lostpassword_text' );

// Disable Password Reset URL & Redirect
function vpsb_disable_lost_password() {
    if (isset( $_GET['action'] )){
        if ( in_array( $_GET['action'], array('lostpassword', 'retrievepassword') ) ) {
            wp_redirect( wp_login_url(), 301 );
            exit;
        }
    }
}
add_action( "login_init", "vpsb_disable_lost_password" );