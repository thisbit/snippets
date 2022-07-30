<?php
/** 
 * Put this in wp-content/mu-plugins folder
 * @link https://wordpress.org/support/article/configuring-automatic-background-updates/
 * @link https://kinsta.com/blog/wordpress-automatic-updates/
 * @link https://make.wordpress.org/core/2013/10/25/the-definitive-guide-to-disabling-auto-updates-in-wordpress-3-7/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'automatic_updater_disabled', '__return_true' );  // prevent all auto updates
add_filter( 'auto_update_core',           '__return_false' ); // prevent core updates
add_filter( 'auto_update_plugin',         '__return_false' ); // Plugins prevent autoupdate
add_filter( 'auto_update_theme',          '__return_false' ); // Themes prevent autoupdate

add_filter( 'allow_dev_auto_core_updates',    '__return_false' );  // Disable development updates
add_filter( 'allow_minor_auto_core_updates',  '__return_true' );   // Enable minor updates
add_filter( 'allow_major_auto_core_updates',  '__return_false' );  // Disable major updates
add_filter( 'auto_update_translation',        '__return_false' );  // Disable translations updates

add_filter( 'automatic_updates_is_vcs_checkout', '__return_true', 1 ); // Check if dev files are in repo, if yes, do not update


/** 
 * Target specific plugins to autoupdate 
 */
function cb_auto_update_plugins ( $update, $item ) {
	$plugins = array ( 'hello', 'akismet' );
	if ( in_array( $item->slug, $plugins ) ) {
		// update plugin
		return true; 
	} else {
		// use default settings
		return $update; 
	}
}
add_filter( 'auto_update_plugin', 'cb_auto_update_plugins', 10, 2 );



apply_filters( 'auto_core_update_send_email',         '__return_false' );   // Do not send me emails about updates
apply_filters( 'send_core_update_notification_email', '__return_true' );
apply_filters( 'automatic_updates_send_debug_email',  '__return_true' );



/** 
 * Specify which emails to get 
 * more info on links above
 */
function cb_auto_core_update_send_email ( $send, $type, $core_update, $result ) {
	if ( !empty( $type ) && $type == 'success' ) {
		// don't send email
		return false; 
	}
		// use default settings
		return $send; 
	}
}
add_filter( 'auto_core_update_send_email', 'cb_auto_core_update_send_email', 10, 4 );